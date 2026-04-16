<?php

// database/seeders/UserSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat akun Super Admin
        $superAdmin = User::create([
            'name'      => 'System Administrator',
            'email'     => 'admin@lms-sekolah.test',
            'password'  => Hash::make('password123'),
            'is_active' => true,
        ]);

        // Menetapkan role super-admin ke akun tersebut menggunakan trait Spatie
        $superAdmin->assignRole('super-admin');
    }
}