<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            // Kelompok A (Wajib Nasional)
            ['code' => 'PAI', 'name' => 'Pendidikan Agama dan Budi Pekerti', 'description' => 'Mata pelajaran wajib Kelompok A'],
            ['code' => 'PPKN', 'name' => 'Pendidikan Pancasila dan Kewarganegaraan', 'description' => 'Mata pelajaran wajib Kelompok A'],
            ['code' => 'BIND', 'name' => 'Bahasa Indonesia', 'description' => 'Mata pelajaran wajib Kelompok A'],
            ['code' => 'MTKW', 'name' => 'Matematika Wajib', 'description' => 'Mata pelajaran wajib Kelompok A'],
            ['code' => 'SEJW', 'name' => 'Sejarah Indonesia', 'description' => 'Mata pelajaran wajib Kelompok A'],
            ['code' => 'BING', 'name' => 'Bahasa Inggris', 'description' => 'Mata pelajaran wajib Kelompok A'],
            
            // Kelompok B (Wajib Kewilayahan)
            ['code' => 'SBD', 'name' => 'Seni Budaya', 'description' => 'Mata pelajaran wajib Kelompok B'],
            ['code' => 'PJOK', 'name' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan', 'description' => 'Mata pelajaran wajib Kelompok B'],
            ['code' => 'PKWY', 'name' => 'Prakarya dan Kewirausahaan', 'description' => 'Mata pelajaran wajib Kelompok B'],

            // Kelompok C (Peminatan MIPA)
            ['code' => 'MTKP', 'name' => 'Matematika Peminatan', 'description' => 'Mata pelajaran peminatan MIPA'],
            ['code' => 'BIO', 'name' => 'Biologi', 'description' => 'Mata pelajaran peminatan MIPA'],
            ['code' => 'FIS', 'name' => 'Fisika', 'description' => 'Mata pelajaran peminatan MIPA'],
            ['code' => 'KIM', 'name' => 'Kimia', 'description' => 'Mata pelajaran peminatan MIPA'],

            // Kelompok C (Peminatan IPS)
            ['code' => 'GEO', 'name' => 'Geografi', 'description' => 'Mata pelajaran peminatan IPS'],
            ['code' => 'SEJP', 'name' => 'Sejarah Peminatan', 'description' => 'Mata pelajaran peminatan IPS'],
            ['code' => 'SOS', 'name' => 'Sosiologi', 'description' => 'Mata pelajaran peminatan IPS'],
            ['code' => 'EKO', 'name' => 'Ekonomi', 'description' => 'Mata pelajaran peminatan IPS'],
        ];

        foreach ($subjects as $subject) {
            Subject::firstOrCreate(
                ['code' => $subject['code']],
                ['name' => $subject['name'], 'description' => $subject['description']]
            );
        }
    }
}