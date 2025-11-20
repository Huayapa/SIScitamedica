@extends('layouts.app')

@section('title', 'Nueva Especialidad - Medify')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-white">Registrar Nueva Especialidad</h1>
        <p class="text-slate-400 mt-1">Defina el nombre y la descripción para la nueva especialidad médica.</p>
    </div>

    {{-- Manejo de errores de validación si existen --}}
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
        {{-- El formulario apunta al método store del controlador --}}
        <form action="{{ route('specialty.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nombre de la Especialidad -->
            <div class="space-y-2">
                <label for="name" class="block text-sm font-medium text-slate-300">Nombre de la Especialidad <span class="text-red-500">*</span></label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                    placeholder="Ej: Cardiología"
                />
                @error('name')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Descripción -->
            <div class="space-y-2">
                <label for="description" class="block text-sm font-medium text-slate-300">Descripción (Opcional)</label>
                <textarea
                    id="description"
                    name="description"
                    rows="3"
                    class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                    placeholder="Breve descripción del alcance de esta especialidad."
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Estado Activo (is_active) -->
            <div class="pt-2">
                <div class="flex items-center">
                    <input
                        type="checkbox"
                        id="is_active"
                        name="is_active"
                        value="1"
                        {{-- Mantenemos el check si se vuelve a la página por un error de validación, por defecto activo --}}
                        @if(old('is_active', true)) checked @endif
                        class="h-4 w-4 text-blue-600 bg-slate-800 border-slate-700 rounded focus:ring-blue-500"
                    >
                    <label for="is_active" class="ml-2 block text-sm text-slate-300">
                        Especialidad Activa
                    </label>
                </div>
                <p class="text-xs text-slate-500 mt-1">Si está marcada, la especialidad estará disponible para su uso.</p>
                @error('is_active')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>


            <!-- Buttons -->
            <div class="flex justify-end gap-3 pt-4">
                {{-- Botón de Cancelar: redirige al listado --}}
                <a href="{{ route('specialty.index') }}" class="px-4 py-2 bg-slate-800 border border-slate-700 text-slate-300 rounded-lg hover:bg-slate-700 transition-colors">
                    Cancelar
                </a>
                
                {{-- Botón de Enviar --}}
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-md shadow-blue-900/50">
                    Guardar Especialidad
                </button>
            </div>
        </form>
    </div>
</div>
@endsection