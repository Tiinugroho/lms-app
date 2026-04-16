<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Gunakan firstOrCreate berdasarkan email
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'], 
            [
                'name'      => 'System Administrator',
                'password'  => Hash::make('password123'),
                'is_active' => true,
            ]
        );

        // Menetapkan role
        $superAdmin->assignRole('super-admin');
    }
}