<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'schedule_id',
        'date',
        'meeting_number',
        'topic',
    ];

    // Relasi ke Jadwal
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    // Relasi ke Detail Absensi (One-to-Many)
    public function details()
    {
        return $this->hasMany(AttendanceDetail::class);
    }
}