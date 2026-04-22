<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceDetail extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'attendance_id',
        'student_id',
        'status',
        'notes',
    ];

    // Relasi kembali ke Header Attendance
    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    // Relasi ke Siswa
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}