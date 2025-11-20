<?php

namespace App\Http\Controllers;

use App\Models\Specialties;
use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtiesController extends Controller
{
    public function index()
    {
        $specialties = Specialty::all();
        // Nota: En un entorno real, usarías Specialty::paginate(15) para rendimiento.
        return view('dashboard.specialties', compact('specialties'));
    }

    public function create()
    {
        return view('create.specialtiescreate');
    }

    public function show(Specialty $specialty)
    {
        return redirect()->route('specialty.index'); 
    }


    /**
     * Almacena una nueva especialidad en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:specialties',
            'description' => 'nullable|string|max:500',
        ]);

        // Manejo de 'is_active'. Si el checkbox no se envía (false), lo establecemos manualmente.
        $validated['is_active'] = $request->has('is_active');
        
        Specialty::create($validated);

        return redirect()->route('specialty.index')
                        ->with('success', 'Especialidad registrada exitosamente.');
    }


    /**
     * Actualiza la especialidad especificada en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Specialty  $specialty
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Specialty $specialty)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:specialties,name,' . $specialty->id,
            'description' => 'nullable|string|max:500',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $specialty->update($validated);

        return redirect()->route('specialty.index')
                        ->with('success', 'Especialidad actualizada exitosamente.');
    }

    /**
     * Elimina la especialidad de la base de datos.
     *
     * @param  \App\Models\Specialty  $specialty
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Specialty $specialty)
    {
        $specialty->delete();

        return redirect()->route('specialty.index')
                        ->with('success', 'Especialidad eliminada exitosamente.');
    }
}
