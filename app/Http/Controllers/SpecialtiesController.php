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
        return view('dashboard.specialtyindex', compact('specialties'));
    }

    /**
     * Muestra la vista para crear una nueva especialidad (el formulario).
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('dashboard.specialtycreate');
    }

    public function show(Specialty $specialty)
    {
        // Puedes redirigir a la lista de especialidades (index)
        return redirect()->route('specialty.index'); 
        
        // O podrías hacer una vista para mostrar una especialidad específica:
        // return view('specialties.show', compact('specialty'));
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
     * Muestra el formulario de edición (o datos para el modal) de la especialidad especificada.
     *
     * Nota: Normalmente se usa para cargar datos en un modal o una vista separada.
     *
     * @param  \App\Models\Specialty  $specialty
     * @return \Illuminate\View\View
     */
    public function edit(Specialty $specialty)
    {
        // En este caso, solo retornaremos la vista de índice, ya que el modal usará
        // esta misma ruta para construir la URL de actualización en el frontend,
        // o si usas Livewire/Inertia, cargarías el componente.
        // Si no usas JS/Livewire, podrías retornar un fragmento JSON de los datos.
        // Pero para el patrón Blade estándar, el modal estará en el index.
        return view('specialty.index', ['specialties' => Specialty::all(), 'editingSpecialty' => $specialty]);
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
