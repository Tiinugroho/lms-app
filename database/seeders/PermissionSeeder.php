<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache Spatie
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Daftar modul utama di aplikasi Anda
        $modules = [
            'teachers',
            'staffs',
            'students',
            'classrooms',
            'subjects',
            'academic_years',
            'roles'
        ];

        // Aksi standar untuk tiap modul
        $actions = ['index', 'create', 'edit', 'delete','export', 'import'];

        // Looping otomatis untuk generate (contoh: teachers-index, teachers-create)
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => $module . '-' . $action,
                    'guard_name' => 'web'
                ]);
            }
        }
        
        // (Opsional) Berikan semua permission ini ke role super-admin jika role-nya sudah ada
        $superAdmin = \App\Models\Role::where('name', 'super-admin')->first();
        if ($superAdmin) {
            $superAdmin->syncPermissions(Permission::all());
        }
    }
}