<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor.specialty']);

        // Búsqueda
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('patient', function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            })->orWhereHas('doctor', function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        // Filtro por estado
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $appointments = $query->orderBy('appointment_date', 'desc')
                             ->orderBy('appointment_time', 'desc')
                             ->paginate(15);

        return view('dashboard.appointments', compact('appointments'));
    }

    public function create()
    {
        $patients = Patient::orderBy('first_name')->get();
        $doctors = Doctor::with('specialty')->available()->orderBy('first_name')->get();
        
        return view('dashboard.appointmentscreate', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'reason' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Appointment::create($validated);

        return redirect()->route('appointments.index')
                        ->with('success', 'Cita programada exitosamente');
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor.specialty']);
        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::orderBy('first_name')->get();
        $doctors = Doctor::with('specialty')->available()->orderBy('first_name')->get();
        
        return view('appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'reason' => 'nullable|string',
            'notes' => 'nullable|string',
            'diagnosis' => 'nullable|string',
        ]);

        $appointment->update($validated);

        return redirect()->route('appointments.index')
                        ->with('success', 'Cita actualizada exitosamente');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index')
                        ->with('success', 'Cita eliminada exitosamente');
    }

    public function cancel(Appointment $appointment)
    {
        $appointment->update(['status' => 'cancelled']);

        return redirect()->route('appointments.index')
                        ->with('success', 'Cita cancelada exitosamente');
    }
}
