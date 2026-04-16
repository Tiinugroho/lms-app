<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'user_id', 'nip', 'nuptk', 'gender', 'phone_number', 'address'
    ];

    // Relasi ke tabel Users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Kelas (sebagai Wali Kelas)
    public function homeroomClassrooms()
    {
        return $this->hasMany(Classroom::class, 'homeroom_teacher_id');
    }
}