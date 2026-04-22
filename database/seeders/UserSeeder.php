<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Staff;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $password = Hash::make('password123');

        // 1. Super Admin
        $admin = User::create([
            'name'      => 'System Administrator',
            'email'     => 'admin@gmail.com',
            'password'  => $password,
            'is_active' => true,
        ]);
        $admin->assignRole('super-admin');

        // 2. Generate Staff (5 orang)
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name'     => $faker->name,
                'email'    => "staff{$i}@sekolah.com",
                'password' => $password,
            ]);
            $user->assignRole('admin-sekolah');
            
            Staff::create([
                'user_id'      => $user->id,
                'nip'          => $faker->unique()->numerify('##################'),
                'nik'          => $faker->unique()->numerify('################'),
                'position'     => $faker->randomElement(['Admin Kurikulum', 'Admin Kesiswaan', 'Bendahara', 'Sekretaris']),
                'gender'       => $faker->randomElement(['L', 'P']),
                
                // UBAH BARIS INI 👇
                'phone_number' => $faker->numerify('08##########'), 
                
                'address'      => $faker->address,
            ]);
        }

        // 3. Generate Guru (20 orang)
        for ($i = 1; $i <= 20; $i++) {
            $user = User::create([
                'name'     => $faker->name,
                'email'    => "guru{$i}@sekolah.com",
                'password' => $password,
            ]);
            $user->assignRole('guru');

            Teacher::create([
                'user_id'      => $user->id,
                'nip'          => $faker->unique()->numerify('##################'),
                'nik'          => $faker->unique()->numerify('################'),
                'nuptk'        => $faker->unique()->numerify('################'),
                'gender'       => $faker->randomElement(['L', 'P']),
                
                // UBAH BARIS INI 👇
                'phone_number' => $faker->numerify('08##########'),
                
                'address'      => $faker->address,
            ]);
        }

        // 4. Generate Siswa (100 orang)
        for ($i = 1; $i <= 100; $i++) {
            $user = User::create([
                'name'     => $faker->name,
                'email'    => "siswa{$i}@sekolah.com",
                'password' => $password,
            ]);
            $user->assignRole('siswa');

            Student::create([
                'user_id'      => $user->id,
                'nis'          => '2204' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'nisn'         => $faker->unique()->numerify('##########'),
                'nik'          => $faker->unique()->numerify('################'),
                'gender'       => $faker->randomElement(['L', 'P']),
                
                // UBAH BARIS INI 👇
                'phone_number' => $faker->numerify('08##########'),
                
                'address'      => $faker->address,
            ]);
        }
    }
}