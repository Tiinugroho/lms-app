<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class, // Buat User, Guru, Staff, Siswa
            AcademicYearSeeder::class,
            SubjectSeeder::class,
            ClassroomSeeder::class, // Buat Kelas (Assign Guru)
            ClassHistorySeeder::class, // Plotting Siswa ke Kelas
        ]);
    }
}
