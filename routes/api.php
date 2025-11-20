<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\SpecialtyController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // CRUD APPOINTMENTS
    Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::post('/appointments', [AppointmentController::class, 'store']);
    Route::get('/appointments/{id}', [AppointmentController::class, 'show']);
    Route::put('/appointments/{id}', [AppointmentController::class, 'update']);
    Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy']);
    // CRUD DOCTORS
    Route::get('/doctors', [DoctorController::class, 'index']);
    Route::post('/doctors', [DoctorController::class, 'store']);
    Route::get('/doctors/{id}', [DoctorController::class, 'show']);
    Route::put('/doctors/{id}', [DoctorController::class, 'update']);
    Route::delete('/doctors/{id}', [DoctorController::class, 'destroy']);
    // CRUD PATIENTS
    Route::get('/patients', [PatientController::class, 'index']);
    Route::post('/patients', [PatientController::class, 'store']);
    Route::get('/patients/{id}', [PatientController::class, 'show']);
    Route::put('/patients/{id}', [PatientController::class, 'update']);
    Route::delete('/patients/{id}', [PatientController::class, 'destroy']);
    // CRUD ROLE
    Route::get('/roles', [RoleController::class, 'index']);
    Route::post('/roles', [RoleController::class, 'store']);
    Route::get('/roles/{id}', [RoleController::class, 'show']);
    Route::put('/roles/{id}', [RoleController::class, 'update']);
    Route::delete('/roles/{id}', [RoleController::class, 'destroy']);
    // CRUD SPECIALTIES
    Route::get('/specialties', [SpecialtyController::class, 'index']);
    Route::post('/specialties', [SpecialtyController::class, 'store']);
    Route::get('/specialties/{id}', [SpecialtyController::class, 'show']);
    Route::put('/specialties/{id}', [SpecialtyController::class, 'update']);
    Route::delete('/specialties/{id}', [SpecialtyController::class, 'destroy']);
    // CRUD USERS
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
