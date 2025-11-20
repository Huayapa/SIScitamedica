@extends('layouts.app')

@section('title', 'Especialidades - MediCitas')

@section('content')

{{-- Contenedor principal para la gestión de modales (usando Alpine.js para simular) --}}
{{-- Nota: Para que los modales funcionen, necesitarás inicializar Alpine.js o usar JS puro --}}
<div x-data="{
    showEditModal: false,
    showDeleteModal: false,
    editingSpecialty: null,
    deletingSpecialty: null,

    openEditModal(specialty) {
        this.editingSpecialty = specialty;
        this.showEditModal = true;
        // Pre-llenar el formulario del modal con los datos
        document.getElementById('edit_specialty_name').value = specialty.name;
        document.getElementById('edit_specialty_description').value = specialty.description || '';
        document.getElementById('edit_specialty_active').checked = specialty.is_active;
        // Actualizar la acción del formulario
        document.getElementById('edit_specialty_form').action = '/specialty/' + specialty.id; // Asume la ruta
    },

    openDeleteModal(specialty) {
        this.deletingSpecialty = specialty;
        this.showDeleteModal = true;
        // Actualizar la acción del formulario
        document.getElementById('delete_specialty_form').action = '/specialty/' + specialty.id; // Asume la ruta
    }
}" class="max-w-6xl mx-auto">
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-white">Gestión de Especialidades</h1>
        {{-- Botón para ir al formulario de creación --}}
        <a href="{{ route('specialty.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-md shadow-blue-900/50">
            + Nueva Especialidad
        </a>
    </div>

    {{-- Mensajes de Sesión (Success/Error) --}}
    @if(session('success'))
        <div class="bg-green-700 p-4 rounded-lg text-white mb-4">
            {{ session('success') }}
        </div>
    @endif

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
                                @click="openEditModal({{ $specialty }})" 
                                class="text-blue-500 hover:text-blue-400 transition-colors p-1 rounded-md hover:bg-slate-700/50"
                                title="Editar"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zm-3.18 3.18l-9 9V17h2.242l9-9-2.242-2.242z"/></svg>
                            </button>
                            
                            {{-- Botón para abrir el Modal de Eliminación --}}
                            <button 
                                @click="openDeleteModal({{ $specialty }})" 
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

    {{-- =================================== --}}
    {{-- MODAL DE EDICIÓN DE ESPECIALIDAD --}}
    {{-- =================================== --}}
    <div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            {{-- Fondo oscuro --}}
            <div x-show="showEditModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" @click="showEditModal = false"></div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            {{-- Contenido del Modal --}}
            <div x-show="showEditModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-slate-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-700">
                
                <form id="edit_specialty_form" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="bg-slate-900 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">
                                    Editar Especialidad
                                </h3>
                                
                                <div class="mt-4 space-y-4">
                                    <!-- Nombre de la Especialidad -->
                                    <div class="space-y-2">
                                        <label for="edit_specialty_name" class="block text-sm font-medium text-slate-300">Nombre</label>
                                        <input
                                            type="text"
                                            id="edit_specialty_name"
                                            name="name"
                                            required
                                            class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="Nombre de la especialidad"
                                        />
                                    </div>
                                    
                                    <!-- Descripción -->
                                    <div class="space-y-2">
                                        <label for="edit_specialty_description" class="block text-sm font-medium text-slate-300">Descripción (Opcional)</label>
                                        <textarea
                                            id="edit_specialty_description"
                                            name="description"
                                            rows="2"
                                            class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="Breve descripción del alcance."
                                        ></textarea>
                                    </div>

                                    <!-- Estado Activo -->
                                    <div class="pt-2">
                                        <div class="flex items-center">
                                            <input
                                                type="checkbox"
                                                id="edit_specialty_active"
                                                name="is_active"
                                                value="1"
                                                class="h-4 w-4 text-blue-600 bg-slate-800 border-slate-700 rounded focus:ring-blue-500"
                                            >
                                            <label for="edit_specialty_active" class="ml-2 block text-sm text-slate-300">
                                                Especialidad Activa
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-slate-800 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-lg">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Guardar Cambios
                        </button>
                        <button type="button" @click="showEditModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-slate-700 shadow-sm px-4 py-2 bg-slate-700 text-base font-medium text-slate-300 hover:bg-slate-600 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- ===================================== --}}
    {{-- MODAL DE CONFIRMACIÓN DE ELIMINACIÓN --}}
    {{-- ===================================== --}}
    <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            {{-- Fondo oscuro --}}
            <div x-show="showDeleteModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" @click="showDeleteModal = false"></div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            {{-- Contenido del Modal --}}
            <div x-show="showDeleteModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-slate-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-red-700">
                
                <div class="bg-slate-900 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-800 sm:mx-0 sm:h-10 sm:w-10">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">
                                Confirmar Eliminación
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-slate-400">
                                    ¿Está seguro de que desea eliminar la especialidad 
                                    <span x-text="deletingSpecialty ? deletingSpecialty.name : ''" class="font-bold text-red-400"></span>?
                                    Esta acción es irreversible y podría afectar a los médicos asociados.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <form id="delete_specialty_form" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="bg-slate-800 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-lg">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Eliminar
                        </button>
                        <button type="button" @click="showDeleteModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-slate-700 shadow-sm px-4 py-2 bg-slate-700 text-base font-medium text-slate-300 hover:bg-slate-600 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
{{-- Se recomienda incluir Alpine.js en 'layouts.app' si se usan las directivas x-data --}}
<script>
   
</script>
@endpush