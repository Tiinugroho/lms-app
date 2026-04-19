<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute; // <-- WAJIB TAMBAHKAN INI DI ATAS

class AcademicYear extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = ['period', 'semester', 'is_active'];

    // TAMBAHKAN FUNGSI INI
    // Fungsi ini akan otomatis membuat atribut 'name' buatan
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->period} {$this->semester}",
        );
    }
}