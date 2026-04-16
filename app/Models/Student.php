<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['user_id', 'nis', 'nisn', 'gender', 'phone_number', 'address'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class)
                    ->withPivot('academic_year_id')
                    ->withTimestamps();
    }
}