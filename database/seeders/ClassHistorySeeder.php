<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\ClassHistory;
use App\Models\Classroom;
use App\Models\Student;
use Illuminate\Database\Seeder;

class ClassHistorySeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::all();
        $classrooms = Classroom::all();
        $activeYear = AcademicYear::where('is_active', true)->first();

        if (!$activeYear || $classrooms->isEmpty()) return;

        foreach ($students as $student) {
            ClassHistory::create([
                'student_id'       => $student->id,
                'classroom_id'     => $classrooms->random()->id,
                'academic_year_id' => $activeYear->id,
                'status'           => 'Aktif',
            ]);
        }
    }
}