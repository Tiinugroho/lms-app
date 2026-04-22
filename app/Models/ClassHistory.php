<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids; // <-- 1. WAJIB ADA DI SINI
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassHistory extends Model
{
    use HasFactory, HasUuids; // <-- 2. WAJIB ADA DI SINI JUGA

    protected $fillable = [
        'student_id',
        'classroom_id',
        'academic_year_id',
        'status',
    ];

    // Relasi ke Siswa
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relasi ke Kelas
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    // Relasi ke Tahun Ajaran
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}