<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MedicalRecord;
use App\Models\Medicine;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role !== 'admin') {
                Auth::logout();
                return back()->withErrors(['email' => 'Tài khoản của bạn không có quyền truy cập hệ thống Web Admin!']);
            }

            $request->session()->regenerate();

            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors(['email' => 'Thông tin email hoặc mật khẩu không chính xác!']);
    }

    public function dashboard()
    {
        $totalDoctors = Doctor::count();
        $totalPending = Appointment::where('status', 'pending')->count();
        $totalApproved = Appointment::where('status', 'approved')->count();

        $recentAppointments = Appointment::with(['user', 'doctor'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $medicines = Medicine::all();

        return view('admin.dashboard', compact('totalDoctors', 'totalPending', 'totalApproved', 'recentAppointments', 'medicines'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

    public function updateAppointmentStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,cancelled',
            'cancellation_reason' => 'required_if:status,cancelled|string|nullable'
        ]);

        $appointment = Appointment::findOrFail($id);

        $appointment->update([
            'status' => $request->status,
            'cancellation_reason' => $request->status === 'cancelled' ? $request->cancellation_reason : null
        ]);

        return back()->with('success', 'Đã cập nhật trạng thái lịch hẹn #' . $id . ' thành công!');
    }

    public function completeAppointment(Request $request, $id)
    {
        $request->validate([
            'diagnosis' => 'required|string',
            'doctor_notes' => 'nullable|string',
        ]);

        $appointment = Appointment::findOrFail($id);

        $appointment->update(['status' => 'completed']);

        MedicalRecord::create([
            'appointment_id' => $appointment->id,
            'diagnosis' => $request->diagnosis,
            'doctor_notes' => $request->doctor_notes,
        ]);

        if ($request->has('medicines')) {
            foreach ($request->medicines as $medicineId => $data) {
                if (isset($data['selected'])) {
                    $appointment->medicines()->attach($medicineId, [
                        'dosage' => $data['dosage'] ?? 'Uống theo chỉ định của bác sĩ',
                    ]);
                }
            }
        }

        return back()->with('success', 'Đã hoàn thành ca khám #' . $id . ' và xuất đơn thuốc thành công!');
    }
}
