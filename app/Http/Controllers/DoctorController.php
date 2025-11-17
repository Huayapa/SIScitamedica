<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $query = Doctor::with('specialty');
        $specialties = Specialty::all();

        // Búsqueda
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhereHas('specialty', function($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $doctors = $query->orderBy('first_name')
                        ->paginate(12);

        return view('dashboard.doctors', compact('doctors', 'specialties'));
    }

    public function create()
    {
        $specialties = Specialty::where('is_active', true)->orderBy('name')->get();
        return view('doctors.create', compact('specialties'));
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

        // Generar código automático
        $validated['code'] = 'DOC-' . str_pad(Doctor::count() + 1, 6, '0', STR_PAD_LEFT);

        Doctor::create($validated);

        return redirect()->route('doctors.index')
                        ->with('success', 'Médico registrado exitosamente');
    }

    public function show(Doctor $doctor)
    {
        $doctor->load(['specialty', 'appointments' => function($query) {
            $query->with('patient')
                  ->orderBy('appointment_date', 'desc')
                  ->limit(20);
        }]);

        $appointmentCount = $doctor->appointments()->count();

        return view('doctors.show', compact('doctor', 'appointmentCount'));
    }

    public function edit(Doctor $doctor)
    {
        $specialties = Specialty::where('is_active', true)->orderBy('name')->get();
        return view('doctors.edit', compact('doctor', 'specialties'));
    }

    public function update(Request $request, Doctor $doctor)
    {
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

        return redirect()->route('doctors.index')
                        ->with('success', 'Médico actualizado exitosamente');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();

        return redirect()->route('doctors.index')
                        ->with('success', 'Médico eliminado exitosamente');
    }

    public function schedule(Doctor $doctor)
    {
        $appointments = $doctor->appointments()
                              ->with('patient')
                              ->whereDate('appointment_date', '>=', today())
                              ->orderBy('appointment_date')
                              ->orderBy('appointment_time')
                              ->get();

        return view('doctors.schedule', compact('doctor', 'appointments'));
    }
}
