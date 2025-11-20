@extends('layouts.app')

@section('title', 'Especialidades - Medify')

@section('content')
<div x-data="{
    editingSpecialty: null,
    deletingSpecialty: null,

    openEditModal(specialty) {
        this.editingSpecialty = specialty;
        document.getElementById('edit_specialty_name').value = specialty.name;
        document.getElementById('edit_specialty_description').value = specialty.description || '';
        document.getElementById('edit_specialty_active').checked = specialty.is_active;
        document.getElementById('edit_specialty_form').action = '/specialties/' + specialty.id;
        $dispatch('open-modal', 'edit-specialty');
    },

    openDeleteModal(specialty) {
        this.deletingSpecialty = specialty;
        document.getElementById('delete_specialty_form').action = '/specialties/' + specialty.id;
        $dispatch('open-modal', 'delete-specialty');
    }
}" class="max-w-6xl mx-auto">
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-white">Gestión de Especialidades</h1>
        {{-- Botón para ir al formulario de creación --}}
        <a href="{{ route('specialty.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-md shadow-blue-900/50">
            + Nueva Especialidad
        </a>
    </div>


    {{-- Tabla de Especialidades --}}
    <div class="bg-slate-900 border border-slate-800 rounded-lg overflow-hidden shadow-xl">
        <table class="min-w-full divide-y divide-slate-700">
            <thead class="bg-slate-800">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">
                        Nombre
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider hidden sm:table-cell">
                        Descripción
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-slate-400 uppercase tracking-wider">
                        Activa
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-slate-400 uppercase tracking-wider">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse ($specialties as $specialty)
                    <tr class="hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-200">
                            {{ $specialty->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400 hidden sm:table-cell">
                            {{ Str::limit($specialty->description, 50, '...') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                            @if($specialty->is_active)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-800 text-green-300">
                                    Sí
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-800 text-red-300">
                                    No
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                            {{-- Botón para abrir el Modal de Edición --}}
                            <button 
                                @click="openEditModal(@js($specialty))"
                                class="text-blue-500 hover:text-blue-400 transition-colors p-1 rounded-md hover:bg-slate-700/50"
                                title="Editar"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zm-3.18 3.18l-9 9V17h2.242l9-9-2.242-2.242z"/></svg>
                            </button>
                            
                            {{-- Botón para abrir el Modal de Eliminación --}}
                            <button 
                                @click="openDeleteModal(@js($specialty))"
                                class="text-red-500 hover:text-red-400 transition-colors p-1 rounded-md hover:bg-slate-700/50"
                                title="Eliminar"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 7a1 1 0 012 0v5a1 1 0 11-2 0V7zm6 0a1 1 0 11-2 0v5a1 1 0 112 0V7z" clip-rule="evenodd"/></svg>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-slate-500">
                            No hay especialidades registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    
</div>

@include('modals.modalspecialties')

@endsection

