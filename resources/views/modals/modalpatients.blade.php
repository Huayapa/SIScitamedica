<x-modal name="edit-patient">
    <form id="edit_patient_form" method="POST">
        @csrf
        @method('PUT')

        <h3 class="text-lg font-semibold text-white">Editar Paciente</h3>

        <div class="mt-4 space-y-4">

            <div class="flex gap-[10px]">
                <div class="space-y-2 w-full">
                    <label class="text-sm text-slate-300">Nombres</label>
                    <input id="edit_patient_first_name" name="first_name" type="text" required
                           class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg">
                </div>

                <div class="space-y-2 w-full">
                    <label class="text-sm text-slate-300">Apellidos</label>
                    <input id="edit_patient_last_name" name="last_name" type="text" required
                           class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg">
                </div>
            </div>
            <div class="flex gap-[10px]">
            <div class="space-y-2 w-full">
                <label class="text-sm text-slate-300">Número de Documento</label>
                <input id="edit_patient_document_number" name="document_number" type="text" required
                       class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg">
            </div>

            <div class="space-y-2 w-full">
                <label class="text-sm text-slate-300">Fecha de Nacimiento</label>
                <input id="edit_patient_birth_date" name="birth_date" type="date" required
                       class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg">
            </div>
            </div>
            <div class="flex gap-[10px]">
            <div class="space-y-2 w-full">
                <label class="text-sm text-slate-300">Género</label>
                <select id="edit_patient_gender" name="gender" required
                        class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg">
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>

            <div class="space-y-2 w-full">
                <label class="text-sm text-slate-300">Correo Electrónico</label>
                <input id="edit_patient_email" name="email" type="email" required
                       class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg">
            </div>
            </div>

            <div class="flex gap-[10px]">
              <div class="space-y-2 w-full">
                  <label class="text-sm text-slate-300">Teléfono</label>
                  <input id="edit_patient_phone" name="phone" type="text" required
                        class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg">
              </div>

              <div class="space-y-2 w-full">
                  <label class="text-sm text-slate-300">Dirección (opcional)</label>
                  <input id="edit_patient_address" name="address" type="text"
                        class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg">
              </div>
            </div>
            <div class="space-y-2">
                <label for="blood_type" class="block text-sm font-medium text-slate-300">Tipo de Sangre (Opcional)</label>
                <select
                    id="edit_patient_blood_type"
                    name="blood_type"
                    class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('blood_type') border-red-500 @enderror"
                >
                    <option value="">Seleccionar</option>
                    @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $type)
                        <option value="{{ $type }}" {{ old('blood_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
                @error('blood_type')
                    <p class="text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label class="text-sm text-slate-300">Alergias (opcional)</label>
                <textarea id="edit_patient_allergies" name="allergies"
                          class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg h-24"></textarea>
            </div>

        </div>

        <div class="mt-6 sm:flex sm:flex-row-reverse">
            <button type="submit"
                class="w-full sm:w-auto px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-md text-white font-medium">
                Guardar Cambios
            </button>

            <button type="button"
                @click="$dispatch('close-modal', 'edit-patient')"
                class="mt-3 sm:mt-0 sm:mr-3 w-full sm:w-auto px-4 py-2 bg-slate-700 hover:bg-slate-600 rounded-md text-slate-300 font-medium">
                Cancelar
            </button>
        </div>
    </form>
</x-modal>

<x-modal name="delete-patient">
    <div class="sm:flex sm:items-start">
        <div class="mx-auto sm:mx-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-300" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>

        <div class="mt-3 sm:ml-4 sm:mt-0">
            <h3 class="text-lg font-semibold text-white">Confirmar Eliminación</h3>

            <p class="mt-2 text-sm text-slate-400">
                ¿Está seguro de que desea eliminar al paciente
                <span x-text="deletingPatient?.first_name + ' ' + deletingPatient?.last_name"
                    class="font-bold text-red-400"></span>?
            </p>
        </div>
    </div>

    <form id="delete_patient_form" method="POST" class="mt-5 sm:flex sm:flex-row-reverse">
        @csrf
        @method('DELETE')

        <button type="submit"
            class="w-full sm:w-auto px-4 py-2 rounded-md bg-red-600 text-white hover:bg-red-700 font-medium">
            Eliminar
        </button>

        <button type="button"
            @click="$dispatch('close-modal', 'delete-patient')"
            class="mt-3 sm:mt-0 sm:mr-3 w-full sm:w-auto px-4 py-2 bg-slate-700 text-slate-300 hover:bg-slate-600 rounded-md">
            Cancelar
        </button>
    </form>
</x-modal>