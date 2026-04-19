<?php

use App\Http\Controllers\Admin\AcademicYearController;
use App\Http\Controllers\Admin\ClassroomController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| RUTE ROOT & PENENGAH (TRAFFIC CONTROLLER)
|--------------------------------------------------------------------------
*/

// 1. Rute Root ("/")
Route::get('/', function () {
    // Jika user sudah login, arahkan ke dashboard sesuai role-nya
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->hasRole(['super-admin', 'admin-sekolah'])) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('guru')) {
            return redirect()->route('guru.dashboard');
        } elseif ($user->hasRole('siswa')) {
            return redirect()->route('siswa.dashboard');
        }
    }

    // Jika belum login, arahkan ke form login
    return redirect()->route('login');
});

// 2. Rute "/dashboard" Penengah
// Mencegah error 404 jika middleware bawaan Laravel melempar user ke "/dashboard"
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
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| RUTE ADMIN (Super Admin & Admin Sekolah)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:super-admin|admin-sekolah'])
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

        // Tahun Akademik (Pastikan route patch/activate berada di atas resource)
        Route::patch('academic-years/{academicYear}/activate', [AcademicYearController::class, 'activate'])->name('academic-years.activate');
        Route::resource('academic-years', AcademicYearController::class);

        Route::resource('roles', RoleController::class);

        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
    });

/*
|--------------------------------------------------------------------------
| RUTE GURU
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:guru'])
    ->prefix('guru')
    ->name('guru.')
    ->group(function () {
        // Dashboard Guru
        Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');

        // Nanti rute manajemen materi, tugas, dan nilai ditambahkan di sini
    });

/*
|--------------------------------------------------------------------------
| RUTE SISWA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {
        // Dashboard Siswa
        Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');

        // Nanti rute akses materi dan CBT ditambahkan di sini
    });

require __DIR__ . '/auth.php';
