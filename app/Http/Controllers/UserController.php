<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $users = User::with('role')->orderBy('name')->paginate(15);
        return view('dashboard.users', compact('users', 'roles'));
    }

    // Mostrar formulario para crear un usuario
    public function create()
    {
        $roles = Role::orderBy('role_name')->get();
        return view('create.userscreate', compact('roles'));
    }

    // Guardar un nuevo usuario
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('user.index')
                         ->with('success', 'Usuario creado correctamente');
    }

    // Actualizar usuario existente
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('user.index')
                         ->with('success', 'Usuario actualizado correctamente');
    }

    // Eliminar usuario
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('user.index')
                         ->with('success', 'Usuario eliminado correctamente');
    }
}
