<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Staff;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1. Super Admin (Password statis karena tidak punya NIP)
        $admin = User::create([
            'name'      => 'System Administrator',
            'email'     => 'admin@gmail.com',
            'password'  => Hash::make('password123'),
            'is_active' => true,
        ]);
        $admin->assignRole('super-admin');

        // 2. Generate Staff (5 orang) - Password pakai NIP
        for ($i = 1; $i <= 5; $i++) {
            $nip = $faker->unique()->numerify('##################'); // Generate 18 digit NIP
            
            $user = User::create([
                'name'     => $faker->name,
                'email'    => "staff{$i}@sekolah.com",
                'password' => Hash::make($nip), // Set password menggunakan NIP
            ]);
            $user->assignRole('admin-sekolah');
            
            Staff::create([
                'user_id'      => $user->id,
                'nip'          => $nip, // Masukkan NIP yang sama
                'nik'          => $faker->unique()->numerify('################'),
                'position'     => $faker->randomElement(['Admin Kurikulum', 'Admin Kesiswaan', 'Bendahara', 'Sekretaris']),
                'gender'       => $faker->randomElement(['L', 'P']),
                'phone_number' => $faker->numerify('08##########'), 
                'address'      => $faker->address,
            ]);
        }

        // 3. Generate Guru (20 orang) - Password pakai NIP
        for ($i = 1; $i <= 20; $i++) {
            $nip = $faker->unique()->numerify('##################'); // Generate 18 digit NIP
            
            $user = User::create([
                'name'     => $faker->name,
                'email'    => "guru{$i}@sekolah.com",
                'password' => Hash::make($nip), // Set password menggunakan NIP
            ]);
            $user->assignRole('guru');

            Teacher::create([
                'user_id'      => $user->id,
                'nip'          => $nip, // Masukkan NIP yang sama
                'nik'          => $faker->unique()->numerify('################'),
                'nuptk'        => $faker->unique()->numerify('################'),
                'gender'       => $faker->randomElement(['L', 'P']),
                'phone_number' => $faker->numerify('08##########'),
                'address'      => $faker->address,
            ]);
        }

        // 4. Generate Siswa (100 orang) - Password pakai NISN
        for ($i = 1; $i <= 100; $i++) {
            $nisn = $faker->unique()->numerify('##########'); // Generate 10 digit NISN
            
            $user = User::create([
                'name'     => $faker->name,
                'email'    => "siswa{$i}@sekolah.com",
                'password' => Hash::make($nisn), // Set password menggunakan NISN
            ]);
            $user->assignRole('siswa');

            Student::create([
                'user_id'      => $user->id,
                'nis'          => '2204' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'nisn'         => $nisn, // Masukkan NISN yang sama
                'nik'          => $faker->unique()->numerify('################'),
                'gender'       => $faker->randomElement(['L', 'P']),
                'phone_number' => $faker->numerify('08##########'),
                'address'      => $faker->address,
            ]);
        }
    }
}