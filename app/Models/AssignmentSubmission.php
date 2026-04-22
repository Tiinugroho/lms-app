<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentSubmission extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'assignment_id',
        'student_id',
        'file_path',
        'student_note',
        'submitted_at',
        'score',
        'teacher_feedback',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'score' => 'decimal:2',
    ];

    public function assignment() { return $this->belongsTo(Assignment::class); }
    public function student() { return $this->belongsTo(Student::class); }
}