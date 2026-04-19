<?php

namespace App\Models;

use App\Models\Student;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classroom extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = ['name', 'level', 'homeroom_teacher_id'];

    // Relasi ke Guru (Wali Kelas)
    public function homeroomTeacher()
    {
        return $this->belongsTo(Teacher::class, 'homeroom_teacher_id');
    }

    // 1. Relasi ke model ClassHistory (untuk melihat detail riwayat penempatan kelas)
    public function classHistories()
    {
        return $this->hasMany(ClassHistory::class);
    }

    // 2. Relasi langsung ke model Student (melalui tabel class_histories)
    public function students()
    {
        return $this->belongsToMany(Student::class, 'class_histories')
                    ->withPivot('academic_year_id', 'semester', 'status')
                    ->withTimestamps();
    }
}