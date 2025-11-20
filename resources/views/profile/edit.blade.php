@extends('layouts.app') <!-- o el layout que tiene tu sidebar y header -->

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Actualizar información -->
    <div class="p-4 shadow rounded-lg">
        @include('profile.partials.update-profile-information-form')
    </div>

    <!-- Cambiar contraseña -->
    <div class="p-4  shadow rounded-lg">
        @include('profile.partials.update-password-form')
    </div>

    <!-- Eliminar cuenta -->
    <div class="p-4  shadow rounded-lg">
        @include('profile.partials.delete-user-form')
    </div>
</div>
@endsection
