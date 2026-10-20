<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // API 1: Bệnh nhân gửi yêu cầu đặt lịch từ Flutter App lên
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|string',
            'symptoms' => 'nullable|string',
        ]);

        $appointment = Appointment::create($validated);

        return response()->json([
            'message' => 'Đặt lịch hẹn thành công! Vui lòng chờ phòng khám duyệt.',
            'data' => $appointment
        ], 210);
    }

    // API 2: Lấy danh sách lịch hẹn của một Bệnh nhân (Hiện lên trang Lịch sử trên Flutter)
    public function getPatientAppointments($userId)
    {
        $appointments = Appointment::with('doctor')
            ->where('user_id', $userId)
            ->orderBy('appointment_date', 'desc')
            ->get();

        return response()->json($appointments);
    }

    // API 3: Web Admin/Bác sĩ duyệt hoặc hủy lịch hẹn
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,completed,cancelled',
            'cancellation_reason' => 'required_if:status,cancelled|string'
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->update($request->only(['status', 'cancellation_reason']));

        return response()->json([
            'message' => 'Cập nhật trạng thái lịch hẹn thành công!',
            'data' => $appointment
        ]);
    }
}
