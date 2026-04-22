<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use Illuminate\Database\Seeder;

class AcademicYearSeeder extends Seeder
{
    public function run(): void
    {
        $years = [
            ['period' => '2025/2026', 'semester' => 'Genap', 'is_active' => false],
            ['period' => '2026/2027', 'semester' => 'Ganjil', 'is_active' => true],
            ['period' => '2026/2027', 'semester' => 'Genap', 'is_active' => false],
        ];

        foreach ($years as $year) {
            AcademicYear::firstOrCreate(
                ['period' => $year['period'], 'semester' => $year['semester']],
                ['is_active' => $year['is_active']]
            );
        }
    }
}