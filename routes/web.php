<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SpecialtiesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Citas Médicas
    Route::get('appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('appointments', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::resource('appointments', AppointmentController::class);
    Route::get('appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');

    // Pacientes
    Route::get('patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('patients', [PatientController::class, 'create'])->name('patients.create');
    Route::resource('patients', PatientController::class);

    // Médicos
    Route::get('doctors', [DoctorController::class, 'index'])->name('doctors.index');
    Route::resource('doctors', DoctorController::class);
    Route::get('doctors/{doctor}/schedule', [DoctorController::class, 'schedule'])->name('doctors.schedule');

    // Reportes
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.export-pdf');
    Route::get('reports/export-excel', [ReportController::class, 'exportExcel'])->name('reports.export-excel');

    // Especialidad
    Route::get('specialty', [SpecialtiesController::class, 'index'])->name('specialty.index');
    Route::get('specialty', [SpecialtiesController::class, 'create'])->name('specialty.create');
    Route::resource('specialty', SpecialtiesController::class);
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
