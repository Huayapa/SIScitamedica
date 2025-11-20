@extends('layouts.app')

@section('title', 'Gestión de Usuarios y Roles')

@section('content')

@php
function getIconSvg($iconName, $class = 'w-5 h-5') {
    $icons = [
        'Plus' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="'.$class.'"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>',
        'Edit' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="'.$class.'"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>',
        'Trash' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="'.$class.'"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6m5 0V4h4v2"/></svg>',
    ];
    return $icons[$iconName] ?? '';
}

$searchTerm = request('search', '');
@endphp

<div x-data="{
    editingUser: null,
    deletingUser: null,
    editingRole: null,
    deletingRole: null,

    openEditUserModal(user) {
        document.getElementById('edit_user_name').value = user.name;
        document.getElementById('edit_user_email').value = user.email;
        document.getElementById('edit_user_role_id').value = user.role_id ?? '';
        document.getElementById('edit_user_form').action = `/users/${user.id}`;
        $dispatch('open-modal', 'edit-user');
    },

    openDeleteUserModal(user) {
        this.deletingUser = user;
        document.getElementById('delete_user_form').action = `/users/${user.id}`;
        $dispatch('open-modal', 'delete-user');
    },

    openEditRoleModal(role) {
        document.getElementById('edit_role_name').value = role.role_name;
        document.getElementById('edit_role_form').action = `/roles/${role.id}`;
        $dispatch('open-modal', 'edit-role');
    },

    openDeleteRoleModal(role) {
        this.deletingRole = role;
        document.getElementById('delete_role_form').action = `/roles/${role.id}`;
        $dispatch('open-modal', 'delete-role');
    },
}" class="space-y-6 p-4 md:p-8 bg-slate-950 min-h-screen">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white">Gestión de Usuarios y Roles</h1>
            <p class="text-slate-400 mt-1">Administra los usuarios y roles del sistema</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('user.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                {!! getIconSvg('Plus', 'w-4 h-4 mr-2') !!} Nuevo Usuario
            </a>
            <a href="{{ route('role.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                {!! getIconSvg('Plus', 'w-4 h-4 mr-2') !!} Nuevo Rol
            </a>
        </div>
    </div>

    {{-- Users Table --}}
    <div class="overflow-x-auto rounded-lg border border-slate-800 bg-slate-900 mt-4">
        <table class="w-full text-left table-auto">
            <thead class="bg-slate-800 text-slate-200">
                <tr>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Rol</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-slate-300">
                @forelse($users as $user)
                <tr class="border-b border-slate-700">
                    <td class="px-4 py-2">{{ $user->name }}</td>
                    <td class="px-4 py-2">{{ $user->email }}</td>
                    <td class="px-4 py-2">{{ $user->role->role_name ?? 'Sin rol' }}</td>
                    <td class="px-4 py-2 flex gap-2">
                        <button @click="openEditUserModal(@js($user))" class="px-2 py-1 bg-blue-600 rounded hover:bg-blue-700">{!! getIconSvg('Edit') !!}</button>
                        <button @click="openDeleteUserModal(@js($user))" class="px-2 py-1 bg-red-600 rounded hover:bg-red-700">{!! getIconSvg('Trash') !!}</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-2 text-center text-slate-400">No hay usuarios registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Roles Table --}}

    <div >
        <div>
            <h1 class="text-3xl font-bold text-white"> Roles</h1>
            <p class="text-slate-400 mt-1">Administrar los roles del sistema</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-6">
          @forelse($roles as $role)
              <div class="rounded-xl border border-slate-800 shadow-lg bg-slate-900 hover:shadow-2xl transition-shadow duration-300 p-4 flex flex-col justify-between">
                  <div class="mb-4">
                      <h2 class="text-lg font-semibold text-white">{{ $role->role_name }}</h2>
                  </div>
                  <div class="flex gap-2">
                      <button 
                          @click="openEditRoleModal(@js($role))" 
                          class="flex-1 inline-flex items-center justify-center px-3 py-2 text-sm font-medium rounded-md border border-slate-700 text-slate-300 hover:bg-slate-800 transition-colors duration-150">
                          {!! getIconSvg('Edit', 'w-4 h-4 mr-1') !!}
                          Editar
                      </button>
                      <button 
                          @click="openDeleteRoleModal(@js($role))" 
                          class="flex-1 inline-flex items-center justify-center px-3 py-2 text-sm font-medium rounded-md border border-slate-700 text-slate-300 hover:bg-slate-800 transition-colors duration-150">
                          {!! getIconSvg('Trash', 'w-4 h-4 mr-1') !!}
                          Eliminar
                      </button>
                  </div>
              </div>
          @empty
              <div class="lg:col-span-4 text-center py-12 bg-slate-900 border border-slate-800 rounded-xl shadow-lg">
                  <p class="text-slate-400 text-lg">No hay roles registrados.</p>
              </div>
          @endforelse
      </div>
    </div>

</div>

@include('modals.modalsusers')
@include('modals.modalroles')

@endsection