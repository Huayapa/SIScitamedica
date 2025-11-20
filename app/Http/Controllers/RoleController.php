<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function create()
    {
        return view('create.rolecreate');
    }

    // Guardar un nuevo rol
    public function store(Request $request)
    {
        $validated = $request->validate([
            'role_name' => 'required|string|max:100|unique:roles,role_name',
        ]);

        Role::create($validated);

        return redirect()->route('user.index')->with('success', 'Rol creado correctamente');
    }

    // Actualizar un rol existente
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'role_name' => 'required|string|max:100|unique:roles,role_name,' . $role->id,
        ]);

        $role->update($validated);

        return redirect()->back()->with('success', 'Rol actualizado correctamente');
    }

    // Eliminar un rol
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->back()->with('success', 'Rol eliminado correctamente');
    }
}
