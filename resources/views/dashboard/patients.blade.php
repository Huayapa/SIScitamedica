@extends('layouts.app')

@section('title', 'Gestión de Pacientes - Medify')

@section('content')
<div x-data="{
    editingPatient: null,
    deletingPatient: null,

    openEditPatientModal(patient) {
        this.editingPatient = patient;

        // Set values
        document.getElementById('edit_patient_first_name').value = patient.first_name;
        document.getElementById('edit_patient_last_name').value = patient.last_name;
        document.getElementById('edit_patient_document_number').value = patient.document_number;
        document.getElementById('edit_patient_birth_date').value = patient.birth_date ? patient.birth_date.substring(0, 10) : '';
        document.getElementById('edit_patient_gender').value = patient.gender;
        document.getElementById('edit_patient_email').value = patient.email;
        document.getElementById('edit_patient_phone').value = patient.phone;
        document.getElementById('edit_patient_address').value = patient.address ?? '';
        document.getElementById('edit_patient_blood_type').value = patient.blood_type ?? '';
        document.getElementById('edit_patient_allergies').value = patient.allergies ?? '';

        // Action
        document.getElementById('edit_patient_form').action = '/patients/' + patient.id;

        $dispatch('open-modal', 'edit-patient');
    },

    openDeletePatientModal(patient) {
        this.deletingPatient = patient;

        document.getElementById('delete_patient_form').action = '/patients/' + patient.id;

        $dispatch('open-modal', 'delete-patient');
    }
}" class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-white">Gestión de Pacientes</h1>
            <p class="text-slate-400 mt-1">Administra los registros de pacientes</p>
        </div>
        
        <a href="{{ route('patients.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nuevo Paciente
        </a>
    </div>

    <!-- Search -->
    <div class="bg-slate-900 border border-slate-800 rounded-lg p-4">
        <form method="GET" action="{{ route('patients.index') }}" class="relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input
                type="text"
                name="search"
                placeholder="Buscar por nombre, ID o correo..."
                value="{{ request('search') }}"
                class="w-full pl-10 pr-4 py-2 bg-slate-800 border border-slate-700 rounded-lg text-sm text-slate-200 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
        </form>
    </div>

    <!-- Patients Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($patients as $patient)
            <div class="bg-slate-900 border border-slate-800 rounded-lg p-6 hover:shadow-lg transition-shadow">
                <div class="space-y-4">
                    <!-- Header -->
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-blue-900 text-blue-300 rounded-full flex items-center justify-center text-lg font-semibold">
                                {{ substr($patient->full_name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="text-white font-medium">{{ $patient->full_name }}</h3>
                                <p class="text-xs text-slate-400">{{ $patient->code }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center gap-2 text-slate-300">
                            <span class="text-slate-400">Edad:</span>
                            <span>{{ $patient->age }} años • {{ $patient->gender }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-slate-300">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span>{{ $patient->phone }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-slate-300">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span class="truncate">{{ $patient->email }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-slate-300">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="truncate">{{ $patient->address ?? 'No registrada' }}</span>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <div class="pt-2 border-t border-slate-800">
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div>
                                <span class="text-slate-400">Tipo de Sangre:</span>
                                <div class="text-slate-200 mt-1">{{ $patient->blood_type ?? 'N/A' }}</div>
                            </div>
                            <div>
                                <span class="text-slate-400">Última Visita:</span>
                                <div class="text-slate-200 mt-1">{{ $patient->last_visit ? $patient->last_visit->format('d/m/Y') : 'Sin visitas' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2 pt-2">
                        <button 
                            @click="openEditPatientModal(@js($patient))"
                            class="flex-1 px-3 py-2 bg-slate-800 border border-slate-700 text-slate-300 text-sm rounded-lg hover:bg-slate-700 transition-colors">
                            Editar
                        </button>

                        <button 
                            @click="openDeletePatientModal(@js($patient))"
                            class="flex-1 px-3 py-2 bg-slate-800 border border-slate-700 text-slate-300 text-sm rounded-lg hover:bg-slate-700 transition-colors">
                            Borrar
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 text-slate-400">
                No se encontraron pacientes
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($patients->hasPages())
        <div class="mt-6">
            {{ $patients->links() }}
        </div>
    @endif
</div>
@include('modals.modalpatients')
@endsection