<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Doctor;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|string',
            'symptoms' => 'nullable|string',
        ]);

        $userId = $request->user()->id;

        $appointment = Appointment::create([
            'user_id'          => $userId,
            'doctor_id'        => $validated['doctor_id'],
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'symptoms'         => $validated['symptoms'],
            'status'           => 'pending',
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Đặt lịch hẹn thành công! Vui lòng chờ phòng khám duyệt.',
            'data' => $appointment
        ], 201);
    }

    public function getPatientAppointments(Request $request)
    {
        $userId = $request->user()->id;

        $appointments = Appointment::with(['doctor', 'medicalRecord.medicines'])
            ->where('user_id', $userId)
            ->orderBy('appointment_date', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $appointments
        ], 200);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,completed,cancelled',
            'cancellation_reason' => 'required_if:status,cancelled|string'
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->update([
            'status' => $request->status,
            'cancellation_reason' => $request->status === 'cancelled' ? $request->cancellation_reason : null
        ]);

        return response()->json([
            'message' => 'Cập nhật trạng thái lịch hẹn thành công!',
            'data' => $appointment
        ], 200);
    }

    public function getDoctors()
    {
        $doctors = Doctor::with('specialty')
            ->where('is_active', true)
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Lấy danh sách bác sĩ thành công!',
            'data' => $doctors
        ], 200);
    }
}
