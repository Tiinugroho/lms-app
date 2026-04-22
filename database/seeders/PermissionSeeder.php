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

        // Daftar SEMUA modul dari hulu ke hilir (End-to-End)
        $modules = [
            // 1. User Management
            'teachers',
            'staffs',
            'students',
            
            // 2. Master Data
            'academic_years',
            'classrooms',
            'subjects',
            
            // 3. Operasional Akademik (Admin)
            'plottings',          // Plotting kelas siswa
            'schedules',          // Jadwal mengajar
            
            // 4. Monitoring (Admin)
            'monitoring_attendances', // Memantau absensi & jurnal
            'monitoring_materials',   // Memantau bahan ajar
            
            // 5. KBM / E-Learning (Sisi Guru)
            'attendances',        // Jurnal & Absensi
            'materials',          // Bahan Ajar
            'assignments',        // Tugas & Ujian
            
            // 6. Penilaian Akhir & Rapor (Modul Masa Depan)
            'grades',             // Input nilai tugas/ulangan
            'report_cards',       // Cetak Rapor (PDF)
            
            // 7. Pengaturan Sistem
            'roles',              // Roles & Permissions
            'settings'            // Setting Website / Logo
        ];

        // Aksi standar untuk tiap modul
        $actions = ['index', 'create', 'edit', 'delete', 'export', 'import'];

        // Looping otomatis untuk generate (contoh: teachers-index, teachers-create)
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => $module . '-' . $action,
                    'guard_name' => 'web'
                ]);
            }
        }

        // --- TAMBAHAN KHUSUS: PERMISSION KUSTOM (DILUAR CRUD STANDAR) ---
        // Kadang ada fitur yang bukan CRUD biasa, misal: Approve, Cetak PDF
        $customPermissions = [
            'report_cards-print',      // Khusus cetak rapor
            'assignments-grade',       // Khusus untuk memberikan nilai (bukan sekedar edit tugas)
        ];

        foreach ($customPermissions as $custom) {
            Permission::firstOrCreate([
                'name' => $custom,
                'guard_name' => 'web'
            ]);
        }
        
        // (Opsional) Berikan semua permission ini ke role super-admin
        $superAdmin = \App\Models\Role::where('name', 'super-admin')->first();
        if ($superAdmin) {
            $superAdmin->syncPermissions(Permission::all());
        }
    }
}