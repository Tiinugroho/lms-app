<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role; // <-- Pastikan ini memanggil Custom Model kita
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = [
            'super-admin',
            'admin-sekolah',
            'guru',
            'siswa',
            'wali-murid'
        ];

        foreach ($roles as $role) {
            // Gunakan firstOrCreate agar aman jika di-seed berulang kali
            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web'
            ]);
        }
    }
}