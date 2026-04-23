<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Reset cache Spatie agar tidak ada data nyangkut
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Daftar Modul End-to-End
        $modules = [
            'teachers', 'staffs', 'students',
            'academic_years', 'classrooms', 'subjects',
            'rombels', 'plottings', 'schedules',
            'monitoring_attendances', 'monitoring_materials',
            'attendances', 'materials', 'assignments',
            'grades', 'report_cards',
            'promotions', // <-- MODUL PROMOTION DITAMBAHKAN DI SINI
            'roles', 'settings'
        ];

        $actions = ['index', 'create', 'edit', 'delete', 'export', 'import'];

        // 3. Buat semua Permissions standar (CRUD)
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => $module . '-' . $action,
                    'guard_name' => 'web'
                ]);
            }
        }

        // 4. Buat Custom Permissions (Khusus)
        $customPermissions = [
            'report_cards-print',
            'assignments-grade',
        ];

        foreach ($customPermissions as $custom) {
            Permission::firstOrCreate([
                'name' => $custom,
                'guard_name' => 'web'
            ]);
        }

        // =========================================================================
        // 5. CONNECT ROLE DAN PERMISSION SESUAI KONTEKS
        // =========================================================================

        // A. SUPER ADMIN (Dapat Semuanya otomatis)
        $superAdmin = Role::where('name', 'super-admin')->first();
        if ($superAdmin) {
            $superAdmin->syncPermissions(Permission::all());
        }

        // B. ADMIN SEKOLAH / TATA USAHA (Master Data & Operasional)
        $adminSekolah = Role::where('name', 'admin-sekolah')->first();
        if ($adminSekolah) {
            $adminSekolahPermissions = [
                // Mengelola User
                'teachers-index', 'teachers-create', 'teachers-edit', 'teachers-delete', 'teachers-export', 'teachers-import',
                'staffs-index', 'staffs-create', 'staffs-edit', 'staffs-delete', 'staffs-export', 'staffs-import',
                'students-index', 'students-create', 'students-edit', 'students-delete', 'students-export', 'students-import',
                // Mengelola Master Data
                'academic_years-index', 'academic_years-create', 'academic_years-edit',
                'classrooms-index', 'classrooms-create', 'classrooms-edit', 'classrooms-delete',
                'subjects-index', 'subjects-create', 'subjects-edit', 'subjects-delete',
                // Mengelola Operasional
                'rombels-index', 'rombels-create', 'rombels-edit', 'rombels-delete',
                'plottings-index', 'plottings-create', 'plottings-edit', 'plottings-delete',
                'schedules-index', 'schedules-create', 'schedules-edit', 'schedules-delete',
                // Akses Monitoring & Rapor
                'monitoring_attendances-index', 'monitoring_materials-index',
                'report_cards-index', 'report_cards-print'
            ];
            $adminSekolah->syncPermissions($adminSekolahPermissions);
        }

        // C. GURU (E-Learning, KBM & Wali Kelas)
        $guru = Role::where('name', 'guru')->first();
        if ($guru) {
            $guruPermissions = [
                // Guru mengelola kelasnya sendiri
                'attendances-index', 'attendances-create', 'attendances-edit', 'attendances-delete',
                'materials-index', 'materials-create', 'materials-edit', 'materials-delete',
                'assignments-index', 'assignments-create', 'assignments-edit', 'assignments-delete',
                'assignments-grade', 
                'grades-index', 'grades-create', 'grades-edit', 'grades-delete',
                // Administrasi Wali Kelas
                'promotions-index', 'promotions-create', 'promotions-edit', 'promotions-delete', // <-- AKSES KENAIKAN KELAS
            ];
            $guru->syncPermissions($guruPermissions);
        }
    }
}