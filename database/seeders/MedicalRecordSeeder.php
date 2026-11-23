<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MedicalRecordSeeder extends Seeder
{
    public function run(): void
    {
        $patient = User::where('role', 'patient')->first();
        if (!$patient) {
            $patient = User::create([
                'name' => 'Quang Vĩ',
                'email' => 'quangvi123@gmail.com',
                'password' => Hash::make('123456'),
                'phone' => '0912345678',
                'role' => 'patient',
            ]);
        }

        $doctor = Doctor::first();
        if (!$doctor) return;

        $appointment = Appointment::first();
        if (!$appointment) {
            $appointment = Appointment::create([
                'user_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'appointment_date' => now()->subDays(2)->toDateString(),
                'appointment_time' => '09:30',
                'symptoms' => 'Đau nhức răng hàm dưới bên phải',
                'status' => 'completed',
            ]);
        } else {
            $appointment->update(['status' => 'completed']);
        }

        MedicalRecord::create([
            'appointment_id' => $appointment->id,
            'diagnosis' => 'Viêm tủy răng cấp tính gây sưng nướu.',
            'doctor_notes' => 'Súc miệng nước muối sinh lý hàng ngày, hạn chế ăn đồ quá nóng hoặc quá lạnh.',
        ]);

        $amox = Medicine::where('name', 'Amoxicillin 500mg')->first();
        $para = Medicine::where('name', 'Paracetamol 500mg')->first();

        if ($amox && $para) {
            $appointment->medicines()->attach([
                $amox->id => ['dosage' => 'Ngày uống 2 lần, mỗi lần 1 viên sau ăn sáng/chiều'],
                $para->id => ['dosage' => 'Uống 1 viên khi đau sốt trên 38.5 độ, cách nhau tối thiểu 4 tiếng'],
            ]);
        }
    }
}
