<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();

        // Búsqueda
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('document_number', 'like', "%{$search}%");
            });
        }

        $patients = $query->orderBy('first_name')
                         ->paginate(12);

        return view('dashboard.patients', compact('patients'));
    }

    public function create()
    {
        return view('create.patientscreate');
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

        Patient::create($validated);

        return redirect()->route('patients.index')
                        ->with('success', 'Paciente registrado exitosamente');
    }

    public function show(Patient $patient)
    {
        $patient->load(['appointments' => function($query) {
            $query->with('doctor.specialty')
                  ->orderBy('appointment_date', 'desc');
        }]);

        return route('patients.index');
    }

    public function edit(Patient $patient)
    {
        return route('patients.index');
    }

    public function update(Request $request, Patient $patient)
    {
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

        return redirect()->route('patients.index')
                        ->with('success', 'Paciente actualizado exitosamente');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index')
                        ->with('success', 'Paciente eliminado exitosamente');
    }
}
