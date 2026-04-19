<?php

// app/Models/User.php

namespace App\Models;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasUuids, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password', 'is_active', 'avatar',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Relasi ke Profil Guru (Jika user ini adalah guru)
    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    // Relasi ke Profil Siswa (Jika user ini adalah siswa)
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function getAvatarUrlAttribute()
{
    if ($this->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->avatar)) {
        return asset('storage/' . $this->avatar);
    }
    
    // Jika tidak ada foto, tampilkan inisial nama dengan warna random
    return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=random&color=fff';
}
}