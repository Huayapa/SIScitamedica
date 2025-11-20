<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        // Trae todos los pacientes
        $patients = Patient::all();

        return response()->json($patients);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'document_number' => 'required|string|max:20|unique:patients',
            'birth_date' => 'required|date|before:today',
            'gender' => 'required|in:Masculino,Femenino,Otro',
            'email' => 'required|email|unique:patients',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'blood_type' => 'nullable|string|max:5',
            'allergies' => 'nullable|string',
        ]);

        // Generar código automático
        $validated['code'] = 'PAC-' . str_pad(Patient::count() + 1, 6, '0', STR_PAD_LEFT);

        $patient = Patient::create($validated);

        return response()->json([
            'message' => 'Paciente registrado correctamente',
            'data' => $patient
        ], 201);
    }

    public function show($id)
    {
        $patient = Patient::findOrFail($id);

        return response()->json($patient);
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'document_number' => 'required|string|max:20|unique:patients,document_number,' . $patient->id,
            'birth_date' => 'required|date|before:today',
            'gender' => 'required|in:Masculino,Femenino,Otro',
            'email' => 'required|email|unique:patients,email,' . $patient->id,
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'blood_type' => 'nullable|string|max:5',
            'allergies' => 'nullable|string',
        ]);

        $patient->update($validated);

        return response()->json([
            'message' => 'Paciente actualizado correctamente',
            'data' => $patient
        ]);
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return response()->json([
            'message' => 'Paciente eliminado correctamente'
        ]);
    }
}
