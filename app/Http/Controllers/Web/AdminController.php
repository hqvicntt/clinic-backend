<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return view('admin.dashboard', compact('totalDoctors', 'totalPending', 'totalApproved', 'recentAppointments'));
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
}
