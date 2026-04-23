<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AcademicYearSeeder extends Seeder
{
    public function run(): void
    {
        $years = [
            // Tahun Ajaran Sebelumnya (Past Year)
            [
                'period' => '2025/2026', 
                'semester' => 'Ganjil', 
                'is_active' => false,
                'start_date' => Carbon::create(2025, 7, 15)->format('Y-m-d'),
                'end_date' => Carbon::create(2025, 12, 20)->format('Y-m-d'),
            ],
            [
                'period' => '2025/2026', 
                'semester' => 'Genap', 
                'is_active' => false,
                'start_date' => Carbon::create(2026, 1, 15)->format('Y-m-d'),
                'end_date' => Carbon::create(2026, 6, 20)->format('Y-m-d'),
            ],
            
            // Tahun Ajaran Saat Ini (Active Year)
            [
                'period' => '2026/2027', 
                'semester' => 'Ganjil', 
                'is_active' => true, // INI YANG AKTIF
                'start_date' => Carbon::create(2026, 7, 15)->format('Y-m-d'),
                'end_date' => Carbon::create(2026, 12, 20)->format('Y-m-d'),
            ],
            [
                'period' => '2026/2027', 
                'semester' => 'Genap', 
                'is_active' => false,
                'start_date' => Carbon::create(2027, 1, 15)->format('Y-m-d'),
                'end_date' => Carbon::create(2027, 6, 20)->format('Y-m-d'),
            ],
        ];

        foreach ($years as $year) {
            AcademicYear::firstOrCreate(
                ['period' => $year['period'], 'semester' => $year['semester']],
                [
                    'is_active' => $year['is_active'],
                    'start_date' => $year['start_date'],
                    'end_date' => $year['end_date'],
                ]
            );
        }
    }
}