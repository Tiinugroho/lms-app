<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    // Kolom yang diizinkan untuk diisi massal
    protected $fillable = [
        'code',
        'name',
        'description',
    ];

    // Relasi: Satu mata pelajaran bisa memiliki banyak tugas
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}