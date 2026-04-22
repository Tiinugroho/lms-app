<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'teacher_id',
        'subject_id',
        'classroom_id',
        'title',
        'description',
        'file_path',
        'external_link',
    ];

    // Relasi ke Guru
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    // Relasi ke Mata Pelajaran
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // Relasi ke Kelas
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}