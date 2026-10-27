<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Medicine;

class MedicalRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $appointment = Appointment::first();

        if ($appointment) {
            $appointment->update(['status' => 'completed']);

            MedicalRecord::create([
                'appointment_id' => $appointment->id,
                'diagnosis' => 'Viêm tủy răng cấp tính tính gây sưng nướu.',
                'doctor_notes' => 'Súc miệng nước muối sinh lý hàng ngày, hạn chế ăn đồ quá nóng hoặc quá lạnh.'
            ]);

            $amox = Medicine::where('name', 'Amoxicillin 500mg')->first();
            $para = Medicine::where('name', 'Paracetamol 500mg')->first();

            $appointment->medicines()->attach([
                $amox->id => ['dosage' => 'Ngày uống 2 lần, mỗi lần 1 viên sau ăn sáng/chiều'],
                $para->id => ['dosage' => 'Uống 1 viên khi đau sốt trên 38.5 độ, cách nhau tối thiểu 4 tiếng']
            ]);
        }
    }
}
