<?php

namespace App\Models;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'level', 'homeroom_teacher_id'
    ];

    // Relasi ke Guru (Wali Kelas)
    public function homeroomTeacher()
    {
        return $this->belongsTo(Teacher::class, 'homeroom_teacher_id');
    }

    // Relasi ke Siswa (Nanti setelah tabel student dibuat)
    public function students()
    {
        return $this->belongsToMany(Student::class)
                    ->withPivot('academic_year_id')
                    ->withTimestamps();
    }
}