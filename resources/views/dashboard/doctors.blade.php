@extends('layouts.app')

@section('title', 'Gestión de Medify')

@section('content')

{{-- Helper para renderizar iconos de Lucide (ya que no podemos usar componentes JS) --}}
@php
function getIconSvg($iconName, $class = 'w-5 h-5') {
    $icons = [
        'Plus' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="' . $class . '"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>',
        'Search' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="' . $class . '"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        'Stethoscope' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="' . $class . '"><path d="M11 18l-4-4-2.5 7 1.5-1.5 4-4Z"/><path d="m15 14 1 1 2.5-7-1.5 1.5-4 4Z"/><path d="M15 14l-4 4"/><path d="M13 16h4"/><path d="M13 2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h2Z"/></svg>',
        'Phone' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="' . $class . '"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-3.95-3.95 19.77 19.77 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',
        'Mail' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="' . $class . '"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>',
        'Clock' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="' . $class . '"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
        'Eye' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="' . $class . '"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>',
        'Edit' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="' . $class . '"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>',
    ];
    return $icons[$iconName] ?? '';
}

// Obtiene el término de búsqueda actual
$searchTerm = request('search', '');
@endphp

<div x-data="{
    editingDoctor: null,
    deletingDoctor: null,

    openEditDoctorModal(doctor) {
        // rellenar inputs
        document.getElementById('edit_doctor_first_name').value = doctor.first_name;
        document.getElementById('edit_doctor_last_name').value = doctor.last_name;
        document.getElementById('edit_doctor_license_number').value = doctor.license_number;
        document.getElementById('edit_doctor_specialty_id').value = doctor.specialty_id;
        document.getElementById('edit_doctor_email').value = doctor.email;
        document.getElementById('edit_doctor_phone').value = doctor.phone;
        document.getElementById('edit_doctor_office').value = doctor.office ?? '';
        document.getElementById('edit_doctor_schedule').value = doctor.schedule ?? '';
        document.getElementById('edit_doctor_experience_years').value = doctor.experience_years;
        document.getElementById('edit_doctor_is_available').checked = doctor.is_available;

        // actualizar acción del form
        document.getElementById('edit_doctor_form').action = `/doctors/${doctor.id}`;

        // abrir modal
        $dispatch('open-modal', 'edit-doctor');
    },

    openDeleteDoctorModal(doctor) {
        this.deletingDoctor = doctor;
        document.getElementById('delete_doctor_form').action = `/doctors/${doctor.id}`;
        $dispatch('open-modal', 'delete-doctor');
    },
}"

class="space-y-6 p-4 md:p-8 bg-slate-950 min-h-screen">
    {{-- Header y Botón de Nuevo Médico --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white">Gestión de Médicos</h1>
            <p class="text-slate-400 mt-1">Administra el equipo médico</p>
        </div>

        {{-- Botón y Modal Trigger --}}
        <div class="flex gap-[10px]">
        <a
            href="{{ route('doctors.create') }}"
            class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors h-10 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white shadow-md focus:ring-4 focus:ring-blue-600/50"
        >
            <span class="material-icons">add</span>
            Nuevo Médico
        </a>

        <a href="{{ route('specialty.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Gestión Especialidad
        </a>
        </div>
    </div>

    {{-- Search Card (Formulario de Búsqueda) --}}
    <form method="GET" action="{{ route('doctors.index') }}" class="rounded-xl border bg-slate-900 border-slate-800 shadow-lg">
        <div class="p-4">
            <div class="relative">
                {!! getIconSvg('Search', 'absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500') !!}
                <input
                    type="text"
                    name="search"
                    placeholder="Buscar por nombre, especialidad o ID..."
                    class="w-full pl-10 h-10 rounded-lg bg-slate-800 border-slate-700 text-slate-200 placeholder:text-slate-500 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                    value="{{ $searchTerm }}"
                />
            </div>
        </div>
    </form>

    {{-- Doctors Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        @forelse ($doctors as $doctor)
            @php
                $fullName = $doctor->first_name . ' ' . $doctor->last_name;
                $specialtyName = optional($doctor->specialty)->name ?? 'Sin Especialidad';
                $availability = $doctor->is_available ? 'Disponible' : 'No Disponible';
                $availabilityClass = $doctor->is_available ? 'bg-green-600 hover:bg-green-700 text-white' : 'bg-red-600 hover:bg-red-700 text-white';

                // Mocking patient count, as it's not directly loaded in the index query
                $mockPatients = $doctor->id % 5 + 10;
            @endphp
            <div class="rounded-xl border border-slate-800 shadow-lg bg-slate-900 hover:shadow-2xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-4">
                                {{-- Icono / Avatar --}}
                                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-full flex items-center justify-center flex-shrink-0">
                                    {!! getIconSvg('Stethoscope', 'w-8 h-8') !!}
                                </div>
                                <div>
                                    <div class="text-xl font-semibold text-white">{{ $fullName }}</div>
                                    <div class="text-sm text-blue-400 font-medium">{{ $specialtyName }}</div>
                                    <div class="text-xs text-slate-400 mt-1">{{ $doctor->license_number }}</div>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full {{ $availabilityClass }}">
                                {{ $availability }}
                            </span>
                        </div>

                        {{-- Metadata Section --}}
                        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-800/70">
                            <div>
                                <div class="text-xs text-slate-400">Citas Recientes</div>
                                <div class="text-slate-200 mt-1 font-semibold">{{ $mockPatients }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-slate-400">Experiencia</div>
                                <div class="text-slate-200 mt-1 font-semibold">{{ $doctor->experience_years }} años</div>
                            </div>
                        </div>

                        {{-- Contact Details --}}
                        <div class="space-y-2 text-sm pt-2">
                            <div class="flex items-center gap-2 text-slate-300">
                                {!! getIconSvg('Phone', 'w-4 h-4 text-slate-500 flex-shrink-0') !!}
                                <span class="truncate">{{ $doctor->phone }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-slate-300">
                                {!! getIconSvg('Mail', 'w-4 h-4 text-slate-500 flex-shrink-0') !!}
                                <span class="truncate">{{ $doctor->email }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-slate-300">
                                {!! getIconSvg('Clock', 'w-4 h-4 text-slate-500 flex-shrink-0') !!}
                                <span class="truncate">{{ $doctor->schedule ?? 'Horario no definido' }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-slate-300">
                                {!! getIconSvg('Stethoscope', 'w-4 h-4 text-slate-500 flex-shrink-0') !!}
                                <span class="truncate">{{ $doctor->office ?? 'Sin consultorio asignado' }}</span>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex flex-col sm:flex-row gap-2 pt-4">
                            <button 
                            @click="openEditDoctorModal(@js($doctor))"
                            class="flex-1 inline-flex items-center justify-center px-3 py-2 text-sm font-medium rounded-md border border-slate-700 text-slate-300 hover:bg-slate-800 transition-colors duration-150">
                                {!! getIconSvg('Edit', 'w-4 h-4 mr-1') !!}
                                Editar
                            </button>
                            <button 
                            @click="openDeleteDoctorModal(@js($doctor))"
                            class="flex-1 inline-flex items-center justify-center px-3 py-2 text-sm font-medium rounded-md border border-slate-700 text-slate-300 hover:bg-slate-800 transition-colors duration-150">
                                {!! getIconSvg('Clock', 'w-4 h-4 mr-1') !!}
                                Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="lg:col-span-2 text-center py-12 bg-slate-900 border border-slate-800 rounded-xl shadow-lg">
                <p class="text-slate-400 text-lg">No se encontraron médicos con el criterio de búsqueda: **{{ $searchTerm }}**.</p>
                <a href="{{ route('doctors.index') }}" class="mt-4 inline-flex text-blue-400 hover:text-blue-300">Limpiar Búsqueda</a>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="pt-4">
        {{ $doctors->links() }}
    </div>
</div>



@include('modals.modaldoctors')
@endsection