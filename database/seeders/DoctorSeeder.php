<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\Specialty;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nhaKhoa = Specialty::where('name', 'Nha khoa')->first();
        $nhiKhoa = Specialty::where('name', 'Nhi khoa')->first();

        Doctor::create([
            'specialty_id' => $nhaKhoa->id,
            'name' => 'BS. Nguyễn Văn Đạt',
            'avatar' => 'doctors/avatar1.png',
            'schedule' => 'Thứ 2 - Thứ 6 (08:00 - 17:00)',
            'is_active' => true
        ]);

        Doctor::create([
            'specialty_id' => $nhaKhoa->id,
            'name' => 'BS. Trần Thị Mai',
            'avatar' => 'doctors/avatar2.png',
            'schedule' => 'Thứ Bảy - Chủ Nhật (08:00 - 12:00)',
            'is_active' => true
        ]);

        Doctor::create([
            'specialty_id' => $nhiKhoa->id,
            'name' => 'ThS. BS. Lê Hoàng Nam',
            'avatar' => 'doctors/avatar3.png',
            'schedule' => 'Thứ 2 - Thứ 6 (13:00 - 20:00)',
            'is_active' => true
        ]);
    }
}
