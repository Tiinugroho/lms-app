<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relasi (Opsional untuk saat ini, tapi sangat berguna nanti): 
    // Satu tahun ajaran digunakan di banyak data pembagian kelas
    // public function classroomStudents()
    // {
    //     return $this->hasMany(ClassroomStudent::class);
    // }
}