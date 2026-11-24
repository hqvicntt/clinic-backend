<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::post('/admin/appointments/{id}/status', [AdminController::class, 'updateAppointmentStatus'])->name('admin.appointments.update');
    Route::post('/admin/appointments/{id}/complete', [AdminController::class, 'completeAppointment'])->name('admin.appointments.complete');
});
