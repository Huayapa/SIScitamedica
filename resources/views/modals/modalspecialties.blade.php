<x-modal name="edit-specialty">
    <form id="edit_specialty_form"  method="POST">
        @csrf
        @method('PUT')

        <h3 class="text-lg font-semibold text-white">
            Editar Especialidad
        </h3>

        <div class="mt-4 space-y-4">
            {{-- Nombre --}}
            <div class="space-y-2">
                <label class="text-sm font-medium text-slate-300">
                    Nombre
                </label>
                <input
                    id="edit_specialty_name"
                    name="name"
                    type="text"
                    required
                    class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500"
                    placeholder="Nombre de la especialidad"
                >
            </div>

            {{-- Descripción --}}
            <div class="space-y-2">
                <label class="text-sm font-medium text-slate-300">
                    Descripción (Opcional)
                </label>
                <textarea
                    id="edit_specialty_description"
                    name="description"
                    rows="2"
                    class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500"
                    placeholder="Breve descripción del alcance."
                ></textarea>
            </div>

            {{-- Activo --}}
            <div class="flex items-center">
                <input
                    id="edit_specialty_active"
                    name="is_active"
                    type="checkbox"
                    value="1"
                    class="h-4 w-4 text-blue-600 bg-slate-800 border-slate-700 rounded focus:ring-blue-500"
                >
                <label for="edit_specialty_active" class="ml-2 text-sm text-slate-300">
                    Especialidad Activa
                </label>
            </div>
        </div>

        <div class="mt-6 sm:flex sm:flex-row-reverse">
            <button
                type="submit"
                class="w-full sm:w-auto px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-md text-white font-medium"
            >
                Guardar Cambios
            </button>

            <button
                type="button"
                @click="$dispatch('close-modal', 'edit-specialty')"
                class="mt-3 sm:mt-0 sm:mr-3 w-full sm:w-auto px-4 py-2 bg-slate-700 hover:bg-slate-600 rounded-md text-slate-300 font-medium"
            >
                Cancelar
            </button>
        </div>

    </form>
</x-modal>


{{-- ===================================== --}}
{{-- MODAL DE CONFIRMACIÓN DE ELIMINACIÓN --}}
{{-- ===================================== --}}
<x-modal name="delete-specialty">
    <div class="sm:flex sm:items-start">
        <div class="mx-auto sm:mx-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-300" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>

        <div class="mt-3 sm:ml-4 sm:mt-0">
            <h3 class="text-lg font-semibold text-white">
                Confirmar Eliminación
            </h3>

            <p class="mt-2 text-sm text-slate-400">
                ¿Está seguro de que desea eliminar la especialidad
                <span x-text="deletingSpecialty?.name" class="font-bold text-red-400"></span>?
            </p>
        </div>
    </div>

    <form id="delete_specialty_form" method="POST" class="mt-5 sm:flex sm:flex-row-reverse">
        @csrf
        @method('DELETE')

        <button type="submit"
            class="w-full sm:w-auto inline-flex justify-center px-4 py-2 rounded-md bg-red-600 text-white hover:bg-red-700 font-medium">
            Eliminar
        </button>

        <button type="button"
            @click="$dispatch('close-modal', 'delete-specialty')"
            class="mt-3 sm:mt-0 sm:mr-3 w-full sm:w-auto inline-flex justify-center px-4 py-2 rounded-md bg-slate-700 text-slate-300 hover:bg-slate-600">
            Cancelar
        </button>
    </form>
</x-modal>