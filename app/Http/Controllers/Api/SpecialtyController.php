<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function index()
    {
        $specialties = Specialty::all();
        return response()->json($specialties);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:specialties',
            'description' => 'nullable|string|max:500',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $specialty = Specialty::create($validated);

        return response()->json([
            'message' => 'Especialidad registrada correctamente',
            'data' => $specialty
        ], 201);
    }

    public function show($id)
    {
        $specialty = Specialty::findOrFail($id);
        return response()->json($specialty);
    }

    public function update(Request $request, $id)
    {
        $specialty = Specialty::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:specialties,name,' . $specialty->id,
            'description' => 'nullable|string|max:500',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $specialty->update($validated);

        return response()->json([
            'message' => 'Especialidad actualizada correctamente',
            'data' => $specialty
        ]);
    }

    public function destroy($id)
    {
        $specialty = Specialty::findOrFail($id);
        $specialty->delete();

        return response()->json([
            'message' => 'Especialidad eliminada correctamente'
        ]);
    }
}
