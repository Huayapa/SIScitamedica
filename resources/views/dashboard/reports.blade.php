@extends('layouts.app')

@section('title', 'Reportes - MediCitas')

@section('content')

{{-- Este template de Blade asume que está incluido dentro de un layout principal con el fondo oscuro y Tailwind CSS disponible. --}}

@php
// Helper function to render Lucide Icons as SVG inline (required since we cannot use JS imports)
function getIconSvg($iconName, $class = 'w-5 h-5 text-white') {
    $icons = [
        'Download' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="' . $class . '"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>',
        'FileText' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="' . $class . '"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><line x1="10" y1="9" x2="8" y2="9"></line></svg>',
        'CalendarCheck' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="' . $class . '"><path d="M21 4V2H3v2"></path><rect x="3" y="6" width="18" height="15" rx="2"></rect><path d="M11.3 15.3l-2.4-2.4"></path><path d="M15.3 11.3l-4 4"></path></svg>',
        'Smile' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="' . $class . '"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>',
        'UserPlus' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="' . $class . '"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>',
        'Clock' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="' . $class . '"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>',
    ];
    return $icons[$iconName] ?? '';
}
@endphp

<div class="space-y-6 p-4 md:p-8 bg-slate-950 min-h-screen">
    {{-- Header and Export Buttons --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white">Reportes y Estadísticas</h1>
            <p class="text-slate-400 mt-1">Análisis operativo de la clínica</p>
        </div>
        
        <div class="flex gap-2">
            <a href="{{ route('reports.export-pdf') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors h-10 px-4 py-2 border border-slate-700 text-slate-300 hover:bg-slate-800">
                {!! getIconSvg('Download', 'w-4 h-4 mr-2') !!}
                Exportar PDF
            </a>
            <a href="{{ route('reports.export-excel') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors h-10 px-4 py-2 border border-slate-700 text-slate-300 hover:bg-slate-800">
                {!! getIconSvg('FileText', 'w-4 h-4 mr-2') !!}
                Exportar Excel
            </a>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ($stats as $stat)
            {{-- FIX: Check if $stat is an array before trying to access keys to prevent "Trying to access array offset on value of type int" --}}
            @if (is_array($stat))
            <div class="rounded-xl border bg-slate-900 border-slate-800 shadow-lg">
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div class="space-y-2">
                            <p class="text-sm text-slate-400">{{ $stat['title'] }}</p>
                            <div class="text-3xl font-semibold text-white">{{ $stat['value'] }}</div>
                            {{-- Assuming green for positive change, red for negative --}}
                            <p class="text-xs {{ str_starts_with($stat['change'], '-') ? 'text-red-500' : 'text-green-500' }}">{{ $stat['change'] }}</p>
                        </div>
                        <div class="{{ $stat['color'] }} p-3 rounded-xl shadow-lg">
                            {!! getIconSvg($stat['icon']) !!}
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    </div>

    {{--- CHART PLACEHOLDER UTILITY (Replaces Recharts/JS charts) ---}}
    @php
        // Estilo básico para simular un gráfico oscuro
        $chartPlaceholderStyle = 'h-[300px] w-full flex items-center justify-center text-slate-500 text-lg border-2 border-dashed border-slate-800 bg-slate-900 rounded-xl';
    @endphp

    {{-- Charts Row 1 --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="rounded-xl border bg-slate-900 border-slate-800 shadow-lg">
            <div class="p-4 border-b border-slate-800">
                <h3 class="text-white text-lg font-semibold">Citas por Día de la Semana</h3>
            </div>
            <div class="p-6">
                <div class="{{ $chartPlaceholderStyle }}">
                    Gráfico de Barras (Inyectar Chart.js/Recharts aquí)
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-slate-900 border-slate-800 shadow-lg">
            <div class="p-4 border-b border-slate-800">
                <h3 class="text-white text-lg font-semibold">Estado de Citas</h3>
            </div>
            <div class="p-6">
                <div class="{{ $chartPlaceholderStyle }}">
                    Gráfico de Torta (Inyectar Chart.js/Recharts aquí)
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Row 2 --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="rounded-xl border bg-slate-900 border-slate-800 shadow-lg">
            <div class="p-4 border-b border-slate-800">
                <h3 class="text-white text-lg font-semibold">Ocupación por Médico</h3>
            </div>
            <div class="p-6">
                <div class="{{ $chartPlaceholderStyle }}">
                    Gráfico de Barras Vertical (Inyectar Chart.js/Recharts aquí)
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-slate-900 border-slate-800 shadow-lg">
            <div class="p-4 border-b border-slate-800">
                <h3 class="text-white text-lg font-semibold">Tendencia Mensual</h3>
            </div>
            <div class="p-6">
                <div class="{{ $chartPlaceholderStyle }}">
                    Gráfico de Líneas (Inyectar Chart.js/Recharts aquí)
                </div>
            </div>
        </div>
    </div>

    {{-- Summary Table --}}
    <div class="rounded-xl border bg-slate-900 border-slate-800 shadow-lg">
        <div class="p-4 border-b border-slate-800">
            <h3 class="text-white text-lg font-semibold">Resumen de Especialidades</h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[700px]">
                    <thead>
                        <tr class="border-b border-slate-800">
                            <th class="text-left py-3 px-4 text-sm font-medium text-slate-400">Especialidad</th>
                            <th class="text-left py-3 px-4 text-sm font-medium text-slate-400">Médicos</th>
                            <th class="text-left py-3 px-4 text-sm font-medium text-slate-400">Citas (Mes)</th>
                            <th class="text-left py-3 px-4 text-sm font-medium text-slate-400">Cancelaciones</th>
                            <th class="text-left py-3 px-4 text-sm font-medium text-slate-400">Tasa Asistencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($specialtyReport as $report)
                            <tr class="border-b border-slate-800 last:border-b-0 hover:bg-slate-800/50 transition-colors">
                                <td class="py-4 px-4 text-sm text-slate-200 font-medium">{{ $report['specialty'] }}</td>
                                <td class="py-4 px-4 text-sm text-slate-200">{{ $report['doctors'] }}</td>
                                <td class="py-4 px-4 text-sm text-slate-200">{{ $report['appointments'] }}</td>
                                <td class="py-4 px-4 text-sm text-slate-200">{{ $report['cancellations'] }}</td>
                                <td class="py-4 px-4 text-sm text-green-500 font-bold">{{ $report['attendance_rate'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection