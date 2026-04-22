<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory, HasUuids; // WAJIB ADA HasUuids

    protected $fillable = [
        'academic_year_id',
        'classroom_id',
        'subject_id',
        'teacher_id',
        'day_of_week',
        'start_time',
        'end_time',
    ];

    // Relasi ke Tahun Ajaran
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    // Relasi ke Kelas
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    // Relasi ke Mata Pelajaran
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // Relasi ke Guru
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}