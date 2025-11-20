@extends('layouts.app')

@section('title', 'Gestión de Citas - MediCitas')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-white">Gestión de Citas</h1>
            <p class="text-slate-400 mt-1">Administra todas las citas médicas</p>
        </div>
        
        <a href="{{ route('appointments.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nueva Cita
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-slate-900 border border-slate-800 rounded-lg p-4">
        <form method="GET" action="{{ route('appointments.index') }}" class="flex flex-col sm:flex-row gap-4">
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input
                    type="text"
                    name="search"
                    placeholder="Buscar por paciente o médico..."
                    value="{{ request('search') }}"
                    class="w-full pl-10 pr-4 py-2 bg-slate-800 border border-slate-700 rounded-lg text-sm text-slate-200 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>
            
            <div class="flex gap-2">
                <select name="status" class="px-4 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all">Todos los estados</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmadas</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendientes</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Canceladas</option>
                </select>
                
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Appointments Table -->
    <div class="bg-slate-900 border border-slate-800 rounded-lg">
        <div class="px-6 py-4 border-b border-slate-800">
            <h2 class="text-lg font-semibold text-white">Lista de Citas ({{ $appointments->total() }})</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-800">
                        <th class="text-left py-3 px-4 text-sm font-medium text-slate-400">Fecha & Hora</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-slate-400">Paciente</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-slate-400">Médico</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-slate-400">Especialidad</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-slate-400">Estado</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-slate-400">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                        <tr class="border-b border-slate-800 hover:bg-slate-800 transition-colors">
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <div>
                                        <div class="text-sm text-slate-200">{{ $appointment->appointment_date->format('d/m/Y') }}</div>
                                        <div class="text-xs text-slate-400">{{ $appointment->appointment_time }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div>
                                    <div class="text-sm text-slate-200">{{ $appointment->patient->full_name }}</div>
                                    <div class="text-xs text-slate-400">{{ $appointment->patient->code }}</div>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-sm text-slate-200">{{ $appointment->doctor->full_name }}</td>
                            <td class="py-4 px-4 text-sm text-slate-200">{{ $appointment->doctor->specialty->name }}</td>
                            <td class="py-4 px-4">{!! $appointment->status_badge !!}</td>
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-2">
                                    <button 
                                    @click="$dispatch('open-modal', 'edit-appointment'); $dispatch('set-appointment', @js($appointment))"
                                    class="p-1 hover:bg-slate-700 rounded transition-colors" title="Editar">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>

                                    <!-- Eliminar -->
                                    <button @click="$dispatch('open-modal', 'delete-appointment')" class="p-1 hover:bg-slate-700 rounded text-red-500 transition-colors" title="Eliminar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">No se encontraron citas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($appointments->hasPages())
            <div class="px-6 py-4 border-t border-slate-800">
                {{ $appointments->links() }}
            </div>
        @endif
    </div>

</div>



<x-modal name="edit-appointment" 
    x-data="{ appointment: {} }"
    x-on:set-appointment.window="appointment = $event.detail">
    <form method="POST" :action="`/appointments/${appointment.id}`" class="p-6 space-y-4">
        @csrf
        @method('PUT')

        <h2 class="text-lg font-semibold text-white">Editar Cita</h2>

        <select name="patient_id" required class="w-full p-2 rounded bg-slate-700 text-white">
            @foreach($patients as $patient)
                <option value="{{ $patient->id }}" {{ $appointment->patient_id == $patient->id ? 'selected' : '' }}>
                    {{ $patient->full_name }}
                </option>
            @endforeach
        </select>

        <select name="doctor_id" required class="w-full p-2 rounded bg-slate-700 text-white">
            @foreach($doctors as $doctor)
                <option value="{{ $doctor->id }}" {{ $appointment->doctor_id == $doctor->id ? 'selected' : '' }}>
                    {{ $doctor->full_name }}
                </option>
            @endforeach
        </select>

        <input type="date" name="appointment_date" value="{{ $appointment->appointment_date->format('Y-m-d') }}" class="w-full p-2 rounded bg-slate-700 text-white" required>
        <input type="time" name="appointment_time" value="{{ $appointment->appointment_time }}" class="w-full p-2 rounded bg-slate-700 text-white" required>

        <select name="status" class="w-full p-2 rounded bg-slate-700 text-white" required>
            <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>Pendiente</option>
            <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>Confirmada</option>
            <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
            <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Completada</option>
        </select>

        <div class="flex justify-end gap-2">
            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                Guardar Cambios
            </button>
            <button type="button" @click="showEditModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-slate-700 shadow-sm px-4 py-2 bg-slate-700 text-base font-medium text-slate-300 hover:bg-slate-600 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                Cancelar
            </button>
        </div>
    </form>
</x-modal>

<x-modal name="delete-appointment" focusable>
    <div class="p-6 space-y-4">
        <h2 class="text-lg font-semibold text-white">Eliminar Cita</h2>
        <p class="text-sm text-slate-300">¿Está seguro de eliminar esta cita? Esta acción no se puede deshacer.</p>

        <form method="POST" action="{{ route('appointments.destroy', $appointment) }}">
            @csrf
            @method('DELETE')
            <div class="flex justify-end gap-2">
                <button type="button" @click="showDeleteModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-slate-700 shadow-sm px-4 py-2 bg-slate-700 text-base font-medium text-slate-300 hover:bg-slate-600 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancelar
                </button>
                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                    Eliminar
                </button>
            </div>
        </form>
    </div>
</x-modal>
@endsection