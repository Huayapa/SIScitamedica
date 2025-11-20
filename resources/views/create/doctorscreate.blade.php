@extends('layouts.app')

@section('title', 'Registrar Médico - Medify')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-white">Registrar Nuevo Médico</h1>
        <p class="text-slate-400 mt-1">Complete el formulario para registrar un médico</p>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-lg p-6">
        <form action="{{ route('doctors.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Errores --}}
            @if ($errors->any())
                <div class="bg-red-900/50 border border-red-700 text-red-300 p-3 rounded-lg text-sm">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>- {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                {{-- Nombre --}}
                <div class="space-y-2">
                    <label for="first_name" class="block text-sm font-medium text-slate-300">Nombre</label>
                    <input
                        id="first_name"
                        name="first_name"
                        type="text"
                        placeholder="Dr./Dra. Nombre"
                        required
                        value="{{ old('first_name') }}"
                        class="w-full px-3 py-2 rounded-lg bg-slate-800 border border-slate-700 text-slate-200 focus:ring-2 focus:ring-blue-500"
                    />
                </div>

                {{-- Apellido --}}
                <div class="space-y-2">
                    <label for="last_name" class="block text-sm font-medium text-slate-300">Apellido</label>
                    <input
                        id="last_name"
                        name="last_name"
                        type="text"
                        placeholder="Apellido"
                        required
                        value="{{ old('last_name') }}"
                        class="w-full px-3 py-2 rounded-lg bg-slate-800 border border-slate-700 text-slate-200 focus:ring-2 focus:ring-blue-500"
                    />
                </div>

                {{-- CMP --}}
                <div class="space-y-2">
                    <label for="license_number" class="block text-sm font-medium text-slate-300">Nº Colegiatura (CMP)</label>
                    <input
                        id="license_number"
                        name="license_number"
                        type="text"
                        placeholder="CMP-12345"
                        required
                        value="{{ old('license_number') }}"
                        class="w-full px-3 py-2 rounded-lg bg-slate-800 border border-slate-700 text-slate-200 focus:ring-2 focus:ring-blue-500"
                    />
                </div>

                {{-- Especialidad --}}
                <div class="space-y-2">
                    <label for="specialty_id" class="block text-sm font-medium text-slate-300">Especialidad</label>
                    <select
                        id="specialty_id"
                        name="specialty_id"
                        required
                        class="w-full px-3 py-2 rounded-lg bg-slate-800 border border-slate-700 text-slate-200 focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="" disabled selected>Selecciona una Especialidad</option>

                        @foreach ($specialties as $specialty)
                            <option value="{{ $specialty->id }}" {{ old('specialty_id') == $specialty->id ? 'selected' : '' }}>
                                {{ $specialty->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Teléfono --}}
                <div class="space-y-2">
                    <label for="phone" class="block text-sm font-medium text-slate-300">Teléfono</label>
                    <input
                        id="phone"
                        name="phone"
                        type="tel"
                        placeholder="+51 987 654 321"
                        required
                        value="{{ old('phone') }}"
                        class="w-full px-3 py-2 rounded-lg bg-slate-800 border border-slate-700 text-slate-200 focus:ring-2 focus:ring-blue-500"
                    />
                </div>

                {{-- Email --}}
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-slate-300">Correo Electrónico</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        placeholder="doctor@medicitas.com"
                        required
                        value="{{ old('email') }}"
                        class="w-full px-3 py-2 rounded-lg bg-slate-800 border border-slate-700 text-slate-200 focus:ring-2 focus:ring-blue-500"
                    />
                </div>

                {{-- Consultorio --}}
                <div class="space-y-2">
                    <label for="office" class="block text-sm font-medium text-slate-300">Consultorio</label>
                    <input
                        id="office"
                        name="office"
                        type="text"
                        placeholder="Ej: Consultorio 201"
                        value="{{ old('office') }}"
                        class="w-full px-3 py-2 rounded-lg bg-slate-800 border border-slate-700 text-slate-200 focus:ring-2 focus:ring-blue-500"
                    />
                </div>

                {{-- Horario --}}
                <div class="space-y-2">
                    <label for="schedule" class="block text-sm font-medium text-slate-300">Horario de Atención</label>
                    <input
                        id="schedule"
                        name="schedule"
                        type="text"
                        placeholder="Lun-Vie: 9:00-17:00"
                        value="{{ old('schedule') }}"
                        class="w-full px-3 py-2 rounded-lg bg-slate-800 border border-slate-700 text-slate-200 focus:ring-2 focus:ring-blue-500"
                    />
                </div>

                {{-- Años de Experiencia --}}
                <div class="space-y-2">
                    <label for="experience_years" class="block text-sm font-medium text-slate-300">Años de Experiencia</label>
                    <input
                        id="experience_years"
                        name="experience_years"
                        type="number"
                        min="0"
                        placeholder="10"
                        required
                        value="{{ old('experience_years') }}"
                        class="w-full px-3 py-2 rounded-lg bg-slate-800 border border-slate-700 text-slate-200 focus:ring-2 focus:ring-blue-500"
                    />
                </div>

                {{-- Disponible --}}
                <div class="flex items-center space-x-2 pt-4">
                    <input
                        id="is_available"
                        name="is_available"
                        type="checkbox"
                        value="1"
                        {{ old('is_available', true) ? 'checked' : '' }}
                        class="w-4 h-4 text-blue-600 bg-slate-800 border-slate-700 rounded focus:ring-blue-500"
                    />
                    <label for="is_available" class="text-sm font-medium text-slate-300">Disponible para citas</label>
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex justify-end gap-3 pt-4">
                <a
                    href="{{ route('doctors.index') }}"
                    class="px-4 py-2 bg-slate-800 border border-slate-700 text-slate-300 rounded-lg hover:bg-slate-700 transition-colors"
                >
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                >
                    Registrar Médico
                </button>
            </div>
        </form>
    </div>
</div>
@endsection