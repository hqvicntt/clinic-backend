<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/patient/{userId}/appointments', [AppointmentController::class, 'getPatientAppointments']);
Route::put('/appointments/{id}/status', [AppointmentController::class, 'updateStatus']);

Route::get('/doctors', [AppointmentController::class, 'getDoctors']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/appointments', [AppointmentController::class, 'store']);
});
