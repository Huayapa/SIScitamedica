<x-modal name="edit-user">
    <form id="edit_user_form" method="POST">
        @csrf
        @method('PUT')

        <h3 class="text-lg font-semibold text-white">Editar Usuario</h3>

        <div class="mt-4 space-y-4">
            <div class="space-y-2">
                <label class="text-sm font-medium text-slate-300">Nombre</label>
                <input id="edit_user_name" name="name" type="text" required
                       class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500"
                       placeholder="Nombre completo">
            </div>

            <div class="space-y-2">
                <label class="text-sm font-medium text-slate-300">Email</label>
                <input id="edit_user_email" name="email" type="email" required
                       class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500"
                       placeholder="usuario@ejemplo.com">
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium text-slate-300">Contraseña (Opcional)</label>
                <input id="edit_user_password" name="password" type="password"
                      class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500"
                      placeholder="Dejar vacío para no cambiar">
            </div>

            <div class="space-y-2">
                <label class="text-sm font-medium text-slate-300">Rol</label>
                <select id="edit_user_role_id" name="role_id" required
                        class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500">
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mt-6 sm:flex sm:flex-row-reverse">
            <button type="submit"
                    class="w-full sm:w-auto px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-md text-white font-medium">
                Guardar Cambios
            </button>
            <button type="button" @click="$dispatch('close-modal', 'edit-user')"
                    class="mt-3 sm:mt-0 sm:mr-3 w-full sm:w-auto px-4 py-2 bg-slate-700 hover:bg-slate-600 rounded-md text-slate-300 font-medium">
                Cancelar
            </button>
        </div>
    </form>
</x-modal>

{{-- Eliminar Usuario --}}
<x-modal name="delete-user">
    <div class="sm:flex sm:items-start">
        <div class="mx-auto sm:mx-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-800">
            {!! getIconSvg('Trash', 'w-6 h-6 text-red-300') !!}
        </div>

        <div class="mt-3 sm:ml-4 sm:mt-0">
            <h3 class="text-lg font-semibold text-white">Confirmar Eliminación</h3>
            <p class="mt-2 text-sm text-slate-400">
                ¿Está seguro de que desea eliminar al usuario
                <span x-text="deletingUser?.name" class="font-bold text-red-400"></span>?
            </p>
        </div>
    </div>

    <form id="delete_user_form" method="POST" class="mt-5 sm:flex sm:flex-row-reverse">
        @csrf
        @method('DELETE')

        <button type="submit"
                class="w-full sm:w-auto inline-flex justify-center px-4 py-2 rounded-md bg-red-600 text-white hover:bg-red-700 font-medium">
            Eliminar
        </button>

        <button type="button" @click="$dispatch('close-modal', 'delete-user')"
                class="mt-3 sm:mt-0 sm:mr-3 w-full sm:w-auto inline-flex justify-center px-4 py-2 rounded-md bg-slate-700 text-slate-300 hover:bg-slate-600">
            Cancelar
        </button>
    </form>
</x-modal>