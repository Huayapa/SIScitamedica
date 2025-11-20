@extends('layouts.app')

@section('title', 'Nueva Cita - MediCitas')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-white">Programar Nueva Cita</h1>
        <p class="text-slate-400 mt-1">Complete el formulario para agendar una cita</p>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-lg p-6">
        <form action="{{ route('appointments.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Paciente -->
                <div class="space-y-2">
                    <label for="patient_id" class="block text-sm font-medium text-slate-300">Paciente</label>
                    <select
                        id="patient_id"
                        name="patient_id"
                        required
                        class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('patient_id') border-red-500 @enderror"
                    >
                        <option value="">Seleccionar paciente</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                {{ $patient->full_name }} ({{ $patient->code }})
                            </option>
                        @endforeach
                    </select>
                    @error('patient_id')
                        <p class="text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Médico -->
                <div class="space-y-2">
                    <label for="doctor_id" class="block text-sm font-medium text-slate-300">Médico</label>
                    <select
                        id="doctor_id"
                        name="doctor_id"
                        required
                        class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('doctor_id') border-red-500 @enderror"
                    >
                        <option value="">Seleccionar médico</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                {{ $doctor->full_name }} - {{ $doctor->specialty->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('doctor_id')
                        <p class="text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fecha -->
                <div class="space-y-2">
                    <label for="appointment_date" class="block text-sm font-medium text-slate-300">Fecha</label>
                    <input
                        type="date"
                        id="appointment_date"
                        name="appointment_date"
                        value="{{ old('appointment_date') }}"
                        min="{{ date('Y-m-d') }}"
                        required
                        class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('appointment_date') border-red-500 @enderror"
                    />
                    @error('appointment_date')
                        <p class="text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Hora -->
                <div class="space-y-2">
                    <label for="appointment_time" class="block text-sm font-medium text-slate-300">Hora</label>
                    <input
                        type="time"
                        id="appointment_time"
                        name="appointment_time"
                        value="{{ old('appointment_time') }}"
                        required
                        class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('appointment_time') border-red-500 @enderror"
                    />
                    @error('appointment_time')
                        <p class="text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Motivo de Consulta -->
            <div class="space-y-2">
                <label for="reason" class="block text-sm font-medium text-slate-300">Motivo de Consulta</label>
                <textarea
                    id="reason"
                    name="reason"
                    rows="3"
                    class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('reason') border-red-500 @enderror"
                    placeholder="Describe el motivo de la consulta..."
                >{{ old('reason') }}</textarea>
                @error('reason')
                    <p class="text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notas Adicionales -->
            <div class="space-y-2">
                <label for="notes" class="block text-sm font-medium text-slate-300">Notas Adicionales (Opcional)</label>
                <textarea
                    id="notes"
                    name="notes"
                    rows="3"
                    class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('notes') border-red-500 @enderror"
                    placeholder="Notas internas o recordatorios..."
                >{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('appointments.index') }}" class="px-4 py-2 bg-slate-800 border border-slate-700 text-slate-300 rounded-lg hover:bg-slate-700 transition-colors">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Programar Cita
                </button>
            </div>
        </form>
    </div>
</div>
@endsection