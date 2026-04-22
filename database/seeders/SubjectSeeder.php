<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            ['code' => 'MTKP', 'name' => 'Matematika Peminatan', 'description' => 'Mata pelajaran matematika jurusan IPA'],
            ['code' => 'MTKW', 'name' => 'Matematika Wajib', 'description' => 'Mata pelajaran matematika seluruh jurusan'],
            ['code' => 'B-IND', 'name' => 'Bahasa Indonesia', 'description' => 'Mata pelajaran Bahasa Indonesia'],
            ['code' => 'B-ING', 'name' => 'Bahasa Inggris', 'description' => 'Mata pelajaran Bahasa Inggris'],
            ['code' => 'BIO', 'name' => 'Biologi', 'description' => 'Mata pelajaran Biologi IPA'],
            ['code' => 'FIS', 'name' => 'Fisika', 'description' => 'Mata pelajaran Fisika IPA'],
        ];

        foreach ($subjects as $subject) {
            Subject::firstOrCreate(
                ['code' => $subject['code']],
                ['name' => $subject['name'], 'description' => $subject['description']]
            );
        }
    }
}