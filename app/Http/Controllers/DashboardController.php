<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas principales
        $stats = [
            'todayAppointments' => Appointment::today()->count(),
            'activePatients' => Patient::count(),
            'availableDoctors' => Doctor::available()->count(),
            'occupancyRate' => $this->calculateOccupancyRate(),
        ];

        // Citas próximas de hoy
        $upcomingAppointments = Appointment::with(['patient', 'doctor.specialty'])
            ->today()
            ->orderBy('appointment_time', 'asc')
            ->limit(10)
            ->get();

        // Alertas del sistema
        $pendingAppointments = Appointment::pending()->today()->count();
        
        return view('dashboard.home', compact(
            'stats',
            'upcomingAppointments',
            'pendingAppointments'
        ));
    }

    private function calculateOccupancyRate()
    {
        $totalSlots = Doctor::available()->count() * 8; // 8 slots por médico
        $occupiedSlots = Appointment::today()->whereIn('status', ['confirmed', 'completed'])->count();
        
        return $totalSlots > 0 ? round(($occupiedSlots / $totalSlots) * 100) : 0;
    }
}
