<?php

use App\Http\Controllers\Admin\AcademicYearController;
use App\Http\Controllers\Admin\ClassPlottingController; // <-- Tambahkan ini
use App\Http\Controllers\Admin\ClassroomController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MonitoringController;
use App\Http\Controllers\Admin\ProfileController as AdminProfile;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RombelController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Guru\AssignmentController;
use App\Http\Controllers\Guru\AttendanceController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\MaterialController;
use App\Http\Controllers\Guru\ProfileController as GuruProfile;
use App\Http\Controllers\Guru\PromotionController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\ProfileController as SiswaProfile;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| RUTE ROOT & PENENGAH (TRAFFIC CONTROLLER)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        // Tambahkan pengecekan role 'staff' di sini jika staff mengakses dashboard admin
        if ($user->hasRole(['super-admin', 'admin-sekolah', 'staff'])) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('guru')) {
            return redirect()->route('guru.dashboard');
        } elseif ($user->hasRole('siswa')) {
            return redirect()->route('siswa.dashboard');
        }
    }
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return redirect('/');
})
    ->middleware('auth')
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| RUTE PROFIL (Bawaan Breeze)
|--------------------------------------------------------------------------
*/
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

/*
|--------------------------------------------------------------------------
| RUTE ADMIN (Super Admin, Admin Sekolah, & Staff)
|--------------------------------------------------------------------------
*/
// PERBAIKAN: Menambahkan role 'staff' agar bisa mengakses area ini
Route::middleware(['auth', 'role:super-admin|admin-sekolah|staff'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Manajemen User & Profil
        Route::resource('teachers', TeacherController::class);
        Route::resource('students', StudentController::class);
        Route::get('students/{student}/id-card', [StudentController::class, 'printIdCard'])->name('students.id-card');
        Route::resource('staffs', StaffController::class);
        Route::get('staffs/{staff}/id-card', [StaffController::class, 'printIdCard'])->name('staffs.id-card');

        // Manajemen Master Data Akademik
        Route::resource('classrooms', ClassroomController::class);
        Route::resource('subjects', SubjectController::class);

        // Tahun Akademik
        Route::patch('academic-years/{academicYear}/activate', [AcademicYearController::class, 'activate'])->name('academic-years.activate');
        Route::resource('academic-years', AcademicYearController::class);

        // ==========================================
        // ROUTE PLOTTING KELAS (PENEMPATAN SISWA)
        // ==========================================
        Route::get('/plottings', [ClassPlottingController::class, 'index'])->name('plottings.index');
        Route::get('/plottings/{academicYear}/{classroom}', [ClassPlottingController::class, 'show'])->name('plottings.show');
        Route::post('/plottings/{academicYear}/{classroom}', [ClassPlottingController::class, 'store'])->name('plottings.store');
        Route::delete('/plottings/remove/{classHistory}', [ClassPlottingController::class, 'destroy'])->name('plottings.destroy');

        // Manajemen Sistem (Hanya Super Admin)
        Route::resource('roles', RoleController::class);
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

        Route::resource('schedules', ScheduleController::class);

        // ROUTE MONITORING UNTUK ADMIN
        Route::get('/monitoring/attendances', [MonitoringController::class, 'attendances'])->name('monitoring.attendances');
        Route::get('/monitoring/materials', [MonitoringController::class, 'materials'])->name('monitoring.materials');

        Route::get('/profile', [AdminProfile::class, 'index'])->name('profile.index');
        Route::put('/profile', [AdminProfile::class, 'update'])->name('profile.update');

        // ==========================================
        // MANAJEMEN ROMBEL (PENEMPATAN SISWA)
        // ==========================================
        Route::get('/rombels', [RombelController::class, 'index'])->name('rombels.index');
        Route::post('/rombels', [RombelController::class, 'store'])->name('rombels.store');
        Route::delete('/rombels/{rombel}', [RombelController::class, 'destroy'])->name('rombels.destroy');
    });

/*
|--------------------------------------------------------------------------
| RUTE GURU
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:super-admin|guru'])
    ->prefix('guru')
    ->name('guru.')
    ->group(function () {
        // Dashboard Guru
        Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');

        // ROUTE ABSENSI GURU
        Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
        Route::get('/attendances/{schedule}/create', [AttendanceController::class, 'create'])->name('attendances.create');
        Route::post('/attendances/{schedule}', [AttendanceController::class, 'store'])->name('attendances.store');

        // ROUTE BAHAN AJAR (MATERIALS)
        Route::resource('materials', MaterialController::class)->except(['show', 'edit', 'update']);

        Route::resource('assignments', AssignmentController::class)->except(['show', 'edit', 'update']);

        Route::get('/profile', [GuruProfile::class, 'index'])->name('profile.index');
        Route::put('/profile', [GuruProfile::class, 'update'])->name('profile.update');

        // Fitur Kenaikan Kelas Wali Kelas
        Route::get('/promotions', [PromotionController::class, 'index'])->name('promotions.index');
        Route::post('/promotions', [PromotionController::class, 'store'])->name('promotions.store');
    });

Route::middleware(['auth', 'role:siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {
        Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');

        Route::get('/profile', [SiswaProfile::class, 'index'])->name('profile.index');
        Route::put('/profile', [SiswaProfile::class, 'update'])->name('profile.update');
    });

require __DIR__ . '/auth.php';
