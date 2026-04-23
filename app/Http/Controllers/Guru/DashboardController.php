<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Assignment;
use App\Models\ClassHistory;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;
        $activeYear = AcademicYear::where('is_active', true)->first();

        // Variabel default jika belum ada tahun ajaran
        $totalClasses = 0;
        $totalStudents = 0;
        $activeAssignments = 0;
        $todaySchedules = collect();
        $recentAssignments = collect();

        if ($activeYear && $teacher) {
            // 1. Dapatkan daftar ID kelas unik yang diajar oleh guru ini
            $classroomIds = Schedule::where('teacher_id', $teacher->id)
                ->where('academic_year_id', $activeYear->id)
                ->pluck('classroom_id')
                ->unique();
            
            $totalClasses = $classroomIds->count();

            // 2. Hitung total siswa dari kelas-kelas tersebut
            $totalStudents = ClassHistory::whereIn('classroom_id', $classroomIds)
                ->where('academic_year_id', $activeYear->id)
                ->where('status', 'Aktif')
                ->count();

            // 3. Konversi hari ini ke bahasa Indonesia
            $days = [
                'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 
                'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
            ];
            $todayIndo = $days[date('l')];

            // 4. Jadwal mengajar HARI INI
            $todaySchedules = Schedule::with(['classroom', 'subject'])
                ->where('teacher_id', $teacher->id)
                ->where('academic_year_id', $activeYear->id)
                ->where('day_of_week', $todayIndo)
                ->orderBy('start_time', 'asc')
                ->get();

            // 5. Tugas aktif (Deadline belum lewat)
            $activeAssignments = Assignment::where('teacher_id', $teacher->id)
                ->where('due_date', '>=', now())
                ->count();

            // 6. Tugas yang baru saja dibuat
            $recentAssignments = Assignment::with(['classroom', 'subject'])
                ->where('teacher_id', $teacher->id)
                ->orderBy('created_at', 'desc')
                ->take(4)
                ->get();
        }

        return view('guru.dashboard', compact(
            'teacher', 
            'activeYear', 
            'totalClasses', 
            'totalStudents', 
            'activeAssignments', 
            'todaySchedules',
            'recentAssignments'
        ));
    }
}