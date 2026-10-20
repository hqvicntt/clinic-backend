<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AppointmentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/appointments', [AppointmentController::class, 'store']);
Route::get('/patient/{userId}/appointments', [AppointmentController::class, 'getPatientAppointments']);
Route::put('/appointments/{id}/status', [AppointmentController::class, 'updateStatus']);
