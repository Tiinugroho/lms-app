<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassHistory extends Model
{
    protected $fillable = [
        'student_id', 
        'classroom_id', 
        'academic_year_id', 
        'semester', 
        'status'
    ];

    // Relasi balik ke Siswa
    public function student() {
        return $this->belongsTo(Student::class);
    }

    // Relasi balik ke Kelas
    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }

    // Relasi balik ke Tahun Akademik
    public function academicYear() {
        return $this->belongsTo(AcademicYear::class);
    }
}