<?php

// database/seeders/RoleSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions (Praktik terbaik saat seeding Spatie)
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Membuat daftar Role
        $roles = [
            'super-admin',
            'admin-sekolah',
            'guru',
            'siswa',
            'wali-murid' // Opsional, kita siapkan saja
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}