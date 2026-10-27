<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Medicine;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Medicine::create([
            'name' => 'Amoxicillin 500mg',
            'brand' => 'Dược Hậu Giang',
            'description' => 'Thuốc kháng sinh điều trị nhiễm khuẩn răng miệng, viêm họng.',
            'dosage_form' => 'Viên nén'
        ]);

        Medicine::create([
            'name' => 'Paracetamol 500mg',
            'brand' => 'Sanofi',
            'description' => 'Thuốc giảm đau, hạ sốt cấp tính.',
            'dosage_form' => 'Viên sủi'
        ]);
    }
}
