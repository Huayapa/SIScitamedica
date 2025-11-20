<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return response()->json($roles);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'role_name' => 'required|string|max:100|unique:roles',
        ]);

        $role = Role::create($validated);

        return response()->json([
            'message' => 'Rol creado correctamente',
            'data' => $role
        ], 201);
    }

    public function show($id)
    {
        $role = Role::findOrFail($id);
        return response()->json($role);
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'role_name' => 'required|string|max:100|unique:roles,role_name,' . $role->id,
        ]);

        $role->update($validated);

        return response()->json([
            'message' => 'Rol actualizado correctamente',
            'data' => $role
        ]);
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json([
            'message' => 'Rol eliminado correctamente'
        ]);
    }
}
