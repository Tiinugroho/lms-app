<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasUuids, HasFactory, SoftDeletes;
    protected $fillable = ['user_id', 'nis', 'nisn', 'nik', 'gender', 'phone_number', 'address'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class)->withPivot('academic_year_id')->withTimestamps();
    }

    public function classHistories()
    {
        return $this->hasMany(ClassHistory::class);
    }

    // Helper untuk mengambil kelas aktif saat ini
    public function currentClassHistory()
    {
        return $this->hasOne(ClassHistory::class)->latestOfMany();
    }
}
