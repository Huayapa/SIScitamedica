<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        // Trae todos los doctores con su especialidad
        $doctors = Doctor::with('specialty')->get();

        return response()->json($doctors);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'license_number' => 'required|string|max:50|unique:doctors',
            'specialty_id' => 'required|exists:specialties,id',
            'email' => 'required|email|unique:doctors',
            'phone' => 'required|string|max:20',
            'office' => 'nullable|string|max:50',
            'schedule' => 'nullable|string|max:100',
            'experience_years' => 'required|integer|min:0',
            'is_available' => 'boolean',
        ]);

        // Código automático
        $validated['code'] = 'DOC-' . str_pad(Doctor::count() + 1, 6, '0', STR_PAD_LEFT);

        $doctor = Doctor::create($validated);

        return response()->json([
            'message' => 'Médico registrado correctamente',
            'data' => $doctor
        ], 201);
    }

    public function show($id)
    {
        $doctor = Doctor::with('specialty')->findOrFail($id);

        return response()->json($doctor);
    }

    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'license_number' => 'required|string|max:50|unique:doctors,license_number,' . $doctor->id,
            'specialty_id' => 'required|exists:specialties,id',
            'email' => 'required|email|unique:doctors,email,' . $doctor->id,
            'phone' => 'required|string|max:20',
            'office' => 'nullable|string|max:50',
            'schedule' => 'nullable|string|max:100',
            'experience_years' => 'required|integer|min:0',
            'is_available' => 'boolean',
        ]);

        $doctor->update($validated);

        return response()->json([
            'message' => 'Médico actualizado correctamente',
            'data' => $doctor
        ]);
    }

    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();

        return response()->json([
            'message' => 'Médico eliminado correctamente'
        ]);
    }
}
