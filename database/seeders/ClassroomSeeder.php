<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class ClassroomSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua guru yang sudah dibuat di UserSeeder
        $teachers = Teacher::all();
        $teacherIndex = 0;

        $levels = [10, 11, 12];
        $majors = ['IPA', 'IPS'];
        $sections = [1, 2, 3]; // Per tingkat ada 3 kelas per jurusan

        foreach ($levels as $level) {
            foreach ($majors as $major) {
                foreach ($sections as $section) {
                    $className = ($level == 10 ? 'X' : ($level == 11 ? 'XI' : 'XII')) . " {$major} {$section}";
                    
                    Classroom::create([
                        'name'                => $className,
                        'level'               => $level,
                        // Ambil guru secara berurutan untuk jadi wali kelas
                        'homeroom_teacher_id' => isset($teachers[$teacherIndex]) ? $teachers[$teacherIndex]->id : null,
                    ]);

                    $teacherIndex++;
                }
            }
        }
    }
}