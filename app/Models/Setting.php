<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'app_name',
        'app_short_name',
        'app_logo',
        'favicon',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'school_phone',
        'school_email',
        'school_address',
        'instagram_link',
        'facebook_link',
        'youtube_link',
        'is_promotion_open', // Tambahkan field ini ke fillable
    ];

    /**
     * Helper untuk mengambil data setting.
     * Karena tabel ini hanya punya 1 baris data, kita buat static function
     * agar mudah dipanggil di Blade, misal: \App\Models\Setting::getSetting()->app_name
     */
    public static function getSetting()
    {
        // Ambil baris pertama, jika kosong, buatkan 1 baris default
        return self::firstOrCreate(
            ['id' => 1], // Kondisi pencarian
            [
                'app_name' => 'Sistem Informasi Akademik',
                'app_short_name' => 'SIAKAD',
                // Nilai default lainnya bisa diisi di sini
            ]
        );
    }

    /**
     * Accessor untuk mendapatkan URL lengkap Logo
     */
    public function getLogoUrlAttribute()
    {
        if ($this->app_logo) {
            return asset('storage/' . $this->app_logo);
        }
        
        // Placeholder logo jika belum ada yang diupload
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->app_short_name) . '&background=4f46e5&color=fff';
    }

    /**
     * Accessor untuk mendapatkan URL lengkap Favicon
     */
    public function getFaviconUrlAttribute()
    {
        if ($this->favicon) {
            return asset('storage/' . $this->favicon);
        }
        
        return asset('favicon.ico'); // Default favicon laravel
    }
}