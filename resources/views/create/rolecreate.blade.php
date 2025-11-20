@extends('layouts.app')

@section('title', 'Nuevo Rol - Medify')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-white">Registrar Nuevo Rol</h1>
        <p class="text-slate-400 mt-1">Defina el nombre del rol que se asignará a los usuarios.</p>
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
        <form action="{{ route('role.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nombre del Rol -->
            <div class="space-y-2">
                <label for="role_name" class="block text-sm font-medium text-slate-300">Nombre del Rol <span class="text-red-500">*</span></label>
                <input type="text" id="role_name" name="role_name" value="{{ old('role_name') }}" required
                       class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 @error('role_name') border-red-500 @enderror"
                       placeholder="Ej: Administrador">
                @error('role_name')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('user.index') }}" class="px-4 py-2 bg-slate-800 border border-slate-700 text-slate-300 rounded-lg hover:bg-slate-700 transition-colors">
                    Cancelar
                </a>

                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-md shadow-blue-900/50">
                    Guardar Rol
                </button>
            </div>
        </form>
    </div>
</div>
@endsection