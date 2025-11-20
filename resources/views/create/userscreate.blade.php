@extends('layouts.app')

@section('title', 'Nuevo Usuario - Medify')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-white">Registrar Nuevo Usuario</h1>
        <p class="text-slate-400 mt-1">Ingrese los datos del usuario y su rol en el sistema.</p>
    </div>

    @if ($errors->any())
        <div class="bg-red-900 border border-red-700 p-4 rounded-lg mb-4 text-red-100">
            <h4 class="font-semibold mb-2">¡Ups! Hubo algunos problemas con su entrada:</h4>
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-slate-900 border border-slate-800 rounded-lg p-6 shadow-xl">
        <form action="{{ route('user.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nombre -->
            <div class="space-y-2">
                <label for="name" class="block text-sm font-medium text-slate-300">Nombre <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                       class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                       placeholder="Nombre completo">
                @error('name')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="space-y-2">
                <label for="email" class="block text-sm font-medium text-slate-300">Email <span class="text-red-500">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                       placeholder="correo@ejemplo.com">
                @error('email')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Contraseña -->
            <div class="space-y-2">
                <label for="password" class="block text-sm font-medium text-slate-300">Contraseña <span class="text-red-500">*</span></label>
                <input type="password" id="password" name="password" required
                       class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                       placeholder="Mínimo 8 caracteres">
                @error('password')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="space-y-2">
              <label for="password_confirmation" class="block text-sm font-medium text-slate-300">Confirmar Contraseña <span class="text-red-500">*</span></label>
              <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 @error('password_confirmation') border-red-500 @enderror"
                    placeholder="Repita la contraseña">
              @error('password_confirmation')
                  <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
              @enderror
          </div>

            <!-- Rol -->
            <div class="space-y-2">
                <label for="role_id" class="block text-sm font-medium text-slate-300">Rol <span class="text-red-500">*</span></label>
                <select id="role_id" name="role_id" required
                        class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 @error('role_id') border-red-500 @enderror">
                    <option value="">Seleccione un rol</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" @selected(old('role_id') == $role->id)>{{ $role->role_name }}</option>
                    @endforeach
                </select>
                @error('role_id')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('user.index') }}" class="px-4 py-2 bg-slate-800 border border-slate-700 text-slate-300 rounded-lg hover:bg-slate-700 transition-colors">
                    Cancelar
                </a>

                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-md shadow-blue-900/50">
                    Guardar Usuario
                </button>
            </div>
        </form>
    </div>
</div>
@endsection