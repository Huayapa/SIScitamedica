<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // Necesario para Str::limit

class ReportController extends Controller
{
    /**
     * Muestra el dashboard de reportes con datos adaptados para SQL Server.
     */
    public function index()
    {
        // --- 1. CONFIGURACIÓN DE TIEMPO ---
        $currentMonth = now()->month;
        $currentYear = now()->year;
        // Se definen variables para el mes anterior, aunque no se usen en el cálculo directo de $stats
        // $prevMonth = now()->subMonth()->month;
        // $prevYear = now()->subMonth()->year;

        // --- 2. CÁLCULO DE ESTADÍSTICAS BÁSICAS ---
        $totalAppointments = Appointment::whereMonth('appointment_date', $currentMonth)
                                        ->whereYear('appointment_date', $currentYear)
                                        ->count();

        $stats = [
            'totalAppointments' => $totalAppointments,
            'attendanceRate' => $this->calculateAttendanceRate($currentMonth, $currentYear),
            'newPatients' => Patient::whereMonth('created_at', $currentMonth)
                                     ->whereYear('created_at', $currentYear)
                                     ->count(),
            'averageTime' => 28, // Mock data
        ];
        
        // --- 3. DATA PARA GRÁFICOS ---

        // Citas por día de la semana (últimos 7 días) - Usando DATEPART(dw, ...) para SQL Server
        $appointmentsByDayDb = DB::table('appointments')
            // DATEPART(dw, appointment_date) devuelve un número (típicamente 1=Domingo en SQL Server)
            ->select(DB::raw('DATEPART(dw, appointment_date) as day_number'), DB::raw('COUNT(*) as count'))
            ->whereBetween('appointment_date', [now()->subDays(7), now()])
            ->groupBy(DB::raw('DATEPART(dw, appointment_date)'))
            ->get();
        
        // Mapeo de números de día a nombres (necesario para la vista)
        $dayMap = [1 => 'Dom', 2 => 'Lun', 3 => 'Mar', 4 => 'Mié', 5 => 'Jue', 6 => 'Vie', 7 => 'Sáb'];
        
        // Formatear resultados para la vista
        $appointmentsByDay = $appointmentsByDayDb->map(function ($item) use ($dayMap) {
            return [
                'day' => $dayMap[$item->day_number] ?? 'N/A',
                'citas' => $item->count
            ];
        })->values()->toArray();


        // Citas por médico (mes actual) - Tu consulta optimizada con withCount
        $topDoctors = Doctor::withCount(['appointments' => function ($query) use ($currentMonth, $currentYear) {
            // whereMonth y whereYear son compatibles con SQL Server
            $query->whereMonth('appointment_date', $currentMonth)
                  ->whereYear('appointment_date', $currentYear);
        }])
        ->whereHas('appointments', function ($query) use ($currentMonth, $currentYear) {
            $query->whereMonth('appointment_date', $currentMonth)
                  ->whereYear('appointment_date', $currentYear);
        })
        ->orderByRaw(
            '(SELECT COUNT(*) FROM appointments 
              WHERE appointments.doctor_id = doctors.id 
              AND MONTH(appointments.appointment_date) = ? 
              AND YEAR(appointments.appointment_date) = ?) DESC',
            [$currentMonth, $currentYear] // Pasamos los bindings de forma segura
        )
        ->limit(10)
        ->get();

        // Formatear resultados para la vista
        $appointmentsByDoctor = $topDoctors->map(function ($doctor) {
            $shortName = 'Dr. ' . Str::limit($doctor->name, 10, '');
            return [
                'name' => $shortName,
                'citas' => $doctor->appointments_count,
            ];
        })->toArray();


        // Estado de citas (mes actual)
        $appointmentStatusDb = DB::table('appointments')
            ->select('status', DB::raw('COUNT(*) as count'))
            ->whereMonth('appointment_date', $currentMonth)
            ->whereYear('appointment_date', $currentYear)
            ->groupBy('status')
            ->get();
        
        // Mapear colores para la vista
        $statusColors = ['completed' => '#10b981', 'pending' => '#f59e0b', 'cancelled' => '#ef4444'];
        
        $appointmentStatus = $appointmentStatusDb->map(function ($item) use ($statusColors) {
            $statusName = ucfirst($item->status);
            return [
                'name' => $statusName,
                'value' => $item->count,
                'color' => $statusColors[$item->status] ?? '#9ca3af'
            ];
        })->toArray();


        // Tendencia mensual (últimos 6 meses) - Usando funciones YEAR/MONTH compatibles con SQL Server
        $monthlyTrendDb = DB::table('appointments')
            ->select(
                DB::raw('YEAR(appointment_date) as year'),
                DB::raw('MONTH(appointment_date) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereBetween('appointment_date', [now()->subMonths(6), now()])
            // CORRECCIÓN: SQL Server no permite usar alias ('year', 'month') en GROUP BY u ORDER BY
            // Se debe repetir la expresión completa.
            ->groupBy(
                DB::raw('YEAR(appointment_date)'),
                DB::raw('MONTH(appointment_date)')
            )
            ->orderBy(DB::raw('YEAR(appointment_date)'), 'asc')
            ->orderBy(DB::raw('MONTH(appointment_date)'), 'asc')
            ->get();
        
        // Formatear tendencia para la vista (convierte número de mes a nombre)
        $monthNames = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

        $monthlyTrend = $monthlyTrendDb->map(function ($item) use ($monthNames) {
            return [
                'mes' => $monthNames[$item->month - 1] ?? $item->month,
                'citas' => $item->count
            ];
        })->values()->toArray();


        // Resumen por especialidad - Obtener datos reales
        $specialtyReport = Specialty::withCount('doctors')
            ->get()
            ->map(function ($specialty) use ($currentMonth, $currentYear) {
                // Total de citas en la especialidad para el mes
                $totalAppointmentsInSpecialty = Appointment::whereHas('doctor', function ($query) use ($specialty) {
                    $query->where('specialty_id', $specialty->id); 
                })
                ->whereMonth('appointment_date', $currentMonth)
                ->whereYear('appointment_date', $currentYear)
                ->count();
                
                // Citas canceladas
                $cancelledAppointments = Appointment::whereHas('doctor', function ($query) use ($specialty) {
                    $query->where('specialty_id', $specialty->id);
                })
                ->whereMonth('appointment_date', $currentMonth)
                ->whereYear('appointment_date', $currentYear)
                ->where('status', 'cancelled')
                ->count();

                $total = $totalAppointmentsInSpecialty;
                $attended = $total - $cancelledAppointments;
                $attendanceRate = $total > 0 ? round(($attended / $total) * 100, 1) . '%' : '0%';

                return [
                    'specialty' => $specialty->name,
                    'doctors' => $specialty->doctors_count,
                    'appointments' => $total,
                    'cancellations' => $cancelledAppointments,
                    'attendance_rate' => $attendanceRate,
                ];
            })->toArray();


        return view('dashboard.reportsindex', compact(
            'stats',
            'appointmentsByDay',
            'appointmentsByDoctor',
            'appointmentStatus',
            'monthlyTrend',
            'specialtyReport'
        ));
    }

    /**
     * Calcula la tasa de asistencia.
     */
    private function calculateAttendanceRate($month, $year)
    {
        $total = Appointment::whereMonth('appointment_date', $month)
                           ->whereYear('appointment_date', $year)
                           ->count();
        
        // Asumimos 'confirmed' y 'completed' como asistidas.
        $attended = Appointment::whereMonth('appointment_date', $month)
                             ->whereYear('appointment_date', $year)
                             ->whereIn('status', ['confirmed', 'completed'])
                             ->count();
        
        return $total > 0 ? round(($attended / $total) * 100) : 0;
    }

    public function exportPdf()
    {
        return response()->json(['message' => 'Exportación a PDF en desarrollo']);
    }

    public function exportExcel()
    {
        return response()->json(['message' => 'Exportación a Excel en desarrollo']);
    }
}
