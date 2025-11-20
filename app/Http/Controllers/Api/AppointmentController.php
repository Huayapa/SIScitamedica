<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['patient', 'doctor.specialty'])->get();

        return response()->json($appointments);
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

        $appointment = Appointment::create($validated);

        return response()->json([
            'message' => 'Cita creada correctamente',
            'data' => $appointment
        ], 201);
    }

    public function show($id)
    {
        $appointment = Appointment::with(['patient', 'doctor.specialty'])->findOrFail($id);
        return response()->json($appointment);
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

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

        return response()->json([
            'message' => 'Cita actualizada correctamente',
            'data' => $appointment
        ]);
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return response()->json([
            'message' => 'Cita eliminada correctamente'
        ]);
    }
}
