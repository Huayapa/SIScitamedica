@extends('layouts.app')

@section('title', 'Nuevo Paciente - Medify')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-white">Registrar Nuevo Paciente</h1>
        <p class="text-slate-400 mt-1">Ingrese los datos personales y médicos para crear un nuevo registro de paciente.</p>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-lg p-6 shadow-xl">
        <form action="{{ route('patients.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Sección de Datos Personales -->
            <h2 class="text-xl font-medium text-blue-400 border-b border-slate-700 pb-2">Datos Personales</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                <!-- Nombre(s) -->
                <div class="space-y-2">
                    <label for="first_name" class="block text-sm font-medium text-slate-300">Nombre(s) <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        id="first_name"
                        name="first_name"
                        value="{{ old('first_name') }}"
                        required
                        class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('first_name') border-red-500 @enderror"
                        placeholder="Ej: Juan Antonio"
                    />
                    @error('first_name')
                        <p class="text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Apellido(s) -->
                <div class="space-y-2">
                    <label for="last_name" class="block text-sm font-medium text-slate-300">Apellido(s) <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        id="last_name"
                        name="last_name"
                        value="{{ old('last_name') }}"
                        required
                        class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('last_name') border-red-500 @enderror"
                        placeholder="Ej: Pérez García"
                    />
                    @error('last_name')
                        <p class="text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Número de Documento -->
                <div class="space-y-2">
                    <label for="document_number" class="block text-sm font-medium text-slate-300">Número de Documento <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        id="document_number"
                        name="document_number"
                        value="{{ old('document_number') }}"
                        required
                        class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('document_number') border-red-500 @enderror"
                        placeholder="Ej: 1234567890"
                    />
                    @error('document_number')
                        <p class="text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fecha de Nacimiento -->
                <div class="space-y-2">
                    <label for="birth_date" class="block text-sm font-medium text-slate-300">Fecha de Nacimiento <span class="text-red-500">*</span></label>
                    <input
                        type="date"
                        id="birth_date"
                        name="birth_date"
                        value="{{ old('birth_date') }}"
                        max="{{ date('Y-m-d') }}"
                        required
                        class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('birth_date') border-red-500 @enderror"
                    />
                    @error('birth_date')
                        <p class="text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Género -->
                <div class="space-y-2">
                    <label for="gender" class="block text-sm font-medium text-slate-300">Género <span class="text-red-500">*</span></label>
                    <select
                        id="gender"
                        name="gender"
                        required
                        class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('gender') border-red-500 @enderror"
                    >
                        <option value="">Seleccionar género</option>
                        <option value="Masculino" {{ old('gender') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                        <option value="Femenino" {{ old('gender') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                        <option value="Otro" {{ old('gender') == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                    @error('gender')
                        <p class="text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Correo Electrónico -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-slate-300">Correo Electrónico <span class="text-red-500">*</span></label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                        placeholder="ejemplo@correo.com"
                    />
                    @error('email')
                        <p class="text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Teléfono -->
                <div class="space-y-2">
                    <label for="phone" class="block text-sm font-medium text-slate-300">Teléfono <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        value="{{ old('phone') }}"
                        required
                        class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('phone') border-red-500 @enderror"
                        placeholder="Ej: +51 987 654 321"
                    />
                    @error('phone')
                        <p class="text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                 <!-- Tipo de Sangre -->
                <div class="space-y-2">
                    <label for="blood_type" class="block text-sm font-medium text-slate-300">Tipo de Sangre (Opcional)</label>
                    <select
                        id="blood_type"
                        name="blood_type"
                        class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('blood_type') border-red-500 @enderror"
                    >
                        <option value="">Seleccionar</option>
                        @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $type)
                            <option value="{{ $type }}" {{ old('blood_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                    @error('blood_type')
                        <p class="text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Dirección Completa -->
            <div class="space-y-2">
                <label for="address" class="block text-sm font-medium text-slate-300">Dirección Completa (Opcional)</label>
                <textarea
                    id="address"
                    name="address"
                    rows="2"
                    class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('address') border-red-500 @enderror"
                    placeholder="Calle, número, ciudad, etc..."
                >{{ old('address') }}</textarea>
                @error('address')
                    <p class="text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Sección de Antecedentes Médicos -->
            <h2 class="text-xl font-medium text-blue-400 border-b border-slate-700 pb-2 pt-4">Antecedentes Médicos</h2>

            <!-- Alergias -->
            <div class="space-y-2">
                <label for="allergies" class="block text-sm font-medium text-slate-300">Alergias y Reacciones (Opcional)</label>
                <textarea
                    id="allergies"
                    name="allergies"
                    rows="3"
                    class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('allergies') border-red-500 @enderror"
                    placeholder="Liste medicamentos, alimentos o sustancias a las que el paciente sea alérgico."
                >{{ old('allergies') }}</textarea>
                @error('allergies')
                    <p class="text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>


            <!-- Buttons -->
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('patients.index') }}" class="px-4 py-2 bg-slate-800 border border-slate-700 text-slate-300 rounded-lg hover:bg-slate-700 transition-colors">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-md shadow-blue-900/50">
                    Registrar Paciente
                </button>
            </div>
        </form>
    </div>
</div>
@endsection