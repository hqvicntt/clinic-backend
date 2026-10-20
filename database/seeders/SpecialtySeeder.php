<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Specialty;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialties = [
            ['name' => 'Nha khoa', 'description' => 'Chăm sóc và điều trị răng miệng chuyên sâu.'],
            ['name' => 'Nhi khoa', 'description' => 'Khám và điều trị bệnh lý cho trẻ em dưới 16 tuổi.'],
            ['name' => 'Da liễu', 'description' => 'Điều trị các bệnh lý về da, tóc và móng.'],
            ['name' => 'Nội tổng quát', 'description' => 'Khám và tầm soát bệnh lý nội khoa người lớn.'],
        ];

        foreach ($specialties as $specialty) {
            Specialty::create($specialty);
        }
    }
}
