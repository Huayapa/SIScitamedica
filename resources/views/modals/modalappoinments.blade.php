<x-modal name="edit-appointment">
    <form id="edit_appointment_form" method="POST">
        @csrf
        @method('PUT')

        <h3 class="text-lg font-semibold text-white">Editar Cita</h3>

        <div class="mt-4 space-y-4">
            <div class="flex gap-[10px]">
            {{-- Paciente --}}
            <div class="space-y-2 w-full">
                <label class="text-sm text-slate-300">Paciente</label>
                <select id="edit_appointment_patient_id" name="patient_id" required
                    class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg">
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}">
                            {{ $patient->first_name }} {{ $patient->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Doctor --}}
            <div class="space-y-2 w-full">
                <label class="text-sm text-slate-300">Médico</label>
                <select id="edit_appointment_doctor_id" name="doctor_id" required
                    class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg">
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}">
                            {{ $doctor->first_name }} {{ $doctor->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            </div>
            <div class="flex gap-[10px]">
            {{-- Fecha --}}
            <div class="space-y-2 w-full">
                <label class="text-sm text-slate-300">Fecha</label>
                <input id="edit_appointment_date" name="appointment_date" type="date" required
                    class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg">
            </div>

            {{-- Hora --}}
            <div class="space-y-2 w-full">
                <label class="text-sm text-slate-300">Hora</label>
                <input id="edit_appointment_time" name="appointment_time" type="time" required
                    class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg">
            </div>
            </div>
            {{-- Estado --}}
            <div class="space-y-2">
                <label class="text-sm text-slate-300">Estado</label>
                <select id="edit_appointment_status" name="status" required
                    class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg">
                    <option value="pending">Pendiente</option>
                    <option value="confirmed">Confirmada</option>
                    <option value="cancelled">Cancelada</option>
                    <option value="completed">Completada</option>
                </select>
            </div>

            {{-- Motivo --}}
            <div class="space-y-2">
                <label class="text-sm text-slate-300">Motivo</label>
                <textarea id="edit_appointment_reason" name="reason"
                    class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg"></textarea>
            </div>

            {{-- Notas --}}
            <div class="space-y-2">
                <label class="text-sm text-slate-300">Notas</label>
                <textarea id="edit_appointment_notes" name="notes"
                    class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg"></textarea>
            </div>

            {{-- Diagnóstico --}}
            <div class="space-y-2">
                <label class="text-sm text-slate-300">Diagnóstico</label>
                <textarea id="edit_appointment_diagnosis" name="diagnosis"
                    class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg"></textarea>
            </div>

        </div>

        <div class="mt-6 sm:flex sm:flex-row-reverse">
            <button type="submit"
                class="w-full sm:w-auto px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-md text-white font-medium">
                Guardar Cambios
            </button>

            <button type="button"
                @click="$dispatch('close-modal', 'edit-appointment')"
                class="mt-3 sm:mt-0 sm:mr-3 w-full sm:w-auto px-4 py-2 bg-slate-700 hover:bg-slate-600 rounded-md text-slate-300 font-medium">
                Cancelar
            </button>
        </div>

    </form>
</x-modal>

<x-modal name="delete-appointment">
    <div class="sm:flex sm:items-start">
        <div class="mx-auto sm:mx-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-800">
            <svg class="h-6 w-6 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>

        <div class="mt-3 sm:ml-4 sm:mt-0">
            <h3 class="text-lg font-semibold text-white">
                Confirmar Eliminación
            </h3>

            <p class="mt-2 text-sm text-slate-400">
                ¿Eliminar esta cita programada para
                <span class="font-bold text-red-400"
                      x-text="deletingAppointment?.appointment_date.substring(0,10)"></span>?
            </p>
        </div>
    </div>

    <form id="delete_appointment_form" method="POST" class="mt-5 sm:flex sm:flex-row-reverse">
        @csrf
        @method('DELETE')

        <button type="submit"
            class="w-full sm:w-auto inline-flex justify-center px-4 py-2 rounded-md bg-red-600 text-white hover:bg-red-700 font-medium">
            Eliminar
        </button>

        <button type="button"
            @click="$dispatch('close-modal', 'delete-appointment')"
            class="mt-3 sm:mt-0 sm:mr-3 w-full sm:w-auto inline-flex justify-center px-4 py-2 rounded-md bg-slate-700 text-slate-300 hover:bg-slate-600">
            Cancelar
        </button>
    </form>
</x-modal>