@extends('layouts.app')

@section('title', 'Dashboard - Medify')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-semibold text-white">Dashboard</h1>
        <p class="text-slate-400 mt-1">Resumen de actividad del sistema</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Citas de Hoy -->
        <div class="bg-slate-900 border border-slate-800 rounded-lg p-6">
            <div class="flex items-start justify-between">
                <div class="space-y-2">
                    <p class="text-sm text-slate-400">Citas de Hoy</p>
                    <h3 class="text-3xl font-semibold text-white">{{ $stats['todayAppointments'] }}</h3>
                    <p class="text-xs text-green-500">+12% vs mes anterior</p>
                </div>
                <div class="bg-blue-500 p-3 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pacientes Activos -->
        <div class="bg-slate-900 border border-slate-800 rounded-lg p-6">
            <div class="flex items-start justify-between">
                <div class="space-y-2">
                    <p class="text-sm text-slate-400">Pacientes Activos</p>
                    <h3 class="text-3xl font-semibold text-white">{{ $stats['activePatients'] }}</h3>
                    <p class="text-xs text-green-500">+8% vs mes anterior</p>
                </div>
                <div class="bg-green-500 p-3 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Médicos Disponibles -->
        <div class="bg-slate-900 border border-slate-800 rounded-lg p-6">
            <div class="flex items-start justify-between">
                <div class="space-y-2">
                    <p class="text-sm text-slate-400">Médicos Disponibles</p>
                    <h3 class="text-3xl font-semibold text-white">{{ $stats['availableDoctors'] }}</h3>
                    <p class="text-xs text-green-500">+2 nuevos</p>
                </div>
                <div class="bg-purple-500 p-3 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Tasa de Ocupación -->
        <div class="bg-slate-900 border border-slate-800 rounded-lg p-6">
            <div class="flex items-start justify-between">
                <div class="space-y-2">
                    <p class="text-sm text-slate-400">Tasa de Ocupación</p>
                    <h3 class="text-3xl font-semibold text-white">{{ $stats['occupancyRate'] }}%</h3>
                    <p class="text-xs text-green-500">+5% vs mes anterior</p>
                </div>
                <div class="bg-orange-500 p-3 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Upcoming Appointments -->
        <div class="lg:col-span-2 bg-slate-900 border border-slate-800 rounded-lg">
            <div class="px-6 py-4 border-b border-slate-800">
                <h2 class="text-lg font-semibold text-white">Próximas Citas de Hoy</h2>
            </div>
            <div class="p-6 space-y-4">
                @forelse($upcomingAppointments as $appointment)
                    <div class="flex items-center justify-between p-4 bg-slate-800 rounded-lg hover:bg-slate-700 transition-colors">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0 w-10 h-10 bg-blue-900 text-blue-300 rounded-full flex items-center justify-center font-semibold">
                                    {{ substr($appointment->patient->full_name, 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-white truncate">{{ $appointment->patient->full_name }}</p>
                                    <p class="text-sm text-slate-400 truncate">
                                        {{ $appointment->doctor->full_name }} • {{ $appointment->doctor->specialty->name }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 ml-4">
                            <div class="text-right">
                                <div class="text-sm text-white">{{ $appointment->appointment_time }}</div>
                                <div class="mt-1">{!! $appointment->status_badge !!}</div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-slate-400 py-8">No hay citas programadas para hoy</p>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions & Alerts -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-slate-900 border border-slate-800 rounded-lg">
                <div class="px-6 py-4 border-b border-slate-800">
                    <h2 class="text-lg font-semibold text-white">Acciones Rápidas</h2>
                </div>
                <div class="p-6 space-y-2">
                    <a href="{{ route('appointments.create') }}" class="block w-full px-4 py-3 bg-blue-600 text-white text-center rounded-lg hover:bg-blue-700 transition-colors">
                        Nueva Cita
                    </a>
                    <a href="{{ route('patients.create') }}" class="block w-full px-4 py-3 bg-slate-800 border border-slate-700 text-slate-200 text-center rounded-lg hover:bg-slate-700 transition-colors">
                        Registrar Paciente
                    </a>
                    <a href="{{ route('appointments.index') }}" class="block w-full px-4 py-3 bg-slate-800 border border-slate-700 text-slate-200 text-center rounded-lg hover:bg-slate-700 transition-colors">
                        Ver Calendario
                    </a>
                </div>
            </div>

            <!-- Alerts -->
            <div class="bg-slate-900 border border-slate-800 rounded-lg">
                <div class="px-6 py-4 border-b border-slate-800">
                    <h2 class="text-lg font-semibold text-white">Alertas</h2>
                </div>
                <div class="p-6 space-y-3">
                    @if($pendingAppointments > 0)
                        <div class="flex gap-3 p-3 bg-yellow-950 border border-yellow-900 rounded-lg">
                            <svg class="w-5 h-5 text-yellow-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <div>
                                <p class="text-sm text-yellow-200 font-medium">{{ $pendingAppointments }} citas sin confirmar</p>
                                <p class="text-xs text-yellow-400 mt-1">Requieren confirmación telefónica</p>
                            </div>
                        </div>
                    @endif
                    
                    <div class="flex gap-3 p-3 bg-blue-950 border border-blue-900 rounded-lg">
                        <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="text-sm text-blue-200 font-medium">Sistema actualizado</p>
                            <p class="text-xs text-blue-400 mt-1">Última actualización: {{ now()->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection