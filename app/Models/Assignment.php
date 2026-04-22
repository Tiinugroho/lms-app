<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'teacher_id',
        'subject_id',
        'classroom_id',
        'title',
        'description',
        'file_path',
        'type',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function teacher() { return $this->belongsTo(Teacher::class); }
    public function subject() { return $this->belongsTo(Subject::class); }
    public function classroom() { return $this->belongsTo(Classroom::class); }
    
    // Relasi ke tabel pengumpulan siswa
    public function submissions() { return $this->hasMany(AssignmentSubmission::class); }
}