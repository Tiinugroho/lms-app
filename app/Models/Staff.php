<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    // Nama tabel secara eksplisit (opsional tapi disarankan agar tidak menjadi 'staff')
    protected $table = 'staffs';

    protected $fillable = [
        'user_id',
        'nip',
        'nik',

        'position',
        'gender',
        'phone_number',
        'address',
    ];

    /**
     * Relasi balik ke tabel User (Untuk mengambil nama, email, role, dan password)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}