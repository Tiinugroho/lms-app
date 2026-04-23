<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\ClassHistory;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PromotionController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;
        $setting = Setting::getSetting();

        // 1. Cek portal kenaikan kelas dari setting admin
        $isPromotionOpen = $setting->is_promotion_open ?? false;

        // 2. Ambil Tahun Ajaran Aktif (Tujuan Kenaikan)
        $activeYear = AcademicYear::where('is_active', true)->first();

        // 3. Ambil Tahun Ajaran Sebelumnya (Sumber Data)
        // Logika: Cari periode terbaru sebelum tahun aktif
        $previousYear = AcademicYear::where('id', '!=', $activeYear?->id)
            ->orderBy('period', 'desc')
            ->orderBy('semester', 'desc')
            ->first();

        $myClass = null;
        $students = collect();
        $targetClassrooms = collect();
        $isGraduating = false;

        if ($isPromotionOpen && $activeYear && $previousYear) {
            // Cari kelas di mana guru ini adalah Wali Kelasnya
            $myClass = Classroom::where('homeroom_teacher_id', $teacher->id)->first();

            if ($myClass) {
                // Ambil daftar siswa dari kelas perwalian pada tahun lalu
                $students = ClassHistory::with('student.user')
                    ->where('classroom_id', $myClass->id)
                    ->where('academic_year_id', $previousYear->id)
                    ->get()
                    ->sortBy(function($query) {
                        return $query->student->user->name;
                    });

                // Cek apakah ini tingkat akhir (12) untuk kelulusan
                if ($myClass->level >= 12) {
                    $isGraduating = true;
                } else {
                    // Ambil daftar kelas untuk tingkat di atasnya
                    $targetClassrooms = Classroom::where('level', $myClass->level + 1)
                        ->orderBy('name', 'asc')
                        ->get();
                }
            }
        }

        return view('guru.promotions.index', compact(
            'isPromotionOpen', 
            'activeYear', 
            'previousYear', 
            'myClass', 
            'students', 
            'targetClassrooms', 
            'isGraduating'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'target_classroom_id' => 'required_without:is_graduating|exists:classrooms,id',
            'promoted_student_ids' => 'nullable|array',
        ]);

        $activeYear = AcademicYear::where('is_active', true)->first();
        $teacher = Auth::user()->teacher;
        $myClass = Classroom::where('homeroom_teacher_id', $teacher->id)->first();
        
        // Ambil data tahun lalu lagi untuk verifikasi
        $previousYear = AcademicYear::where('id', '!=', $activeYear->id)
            ->orderBy('period', 'desc')
            ->orderBy('semester', 'desc')
            ->first();

        $allStudentsLastYear = ClassHistory::where('classroom_id', $myClass->id)
            ->where('academic_year_id', $previousYear->id)
            ->pluck('student_id')
            ->toArray();

        $promotedIds = $request->promoted_student_ids ?? [];
        $isGraduating = $request->has('is_graduating');

        DB::transaction(function () use ($allStudentsLastYear, $promotedIds, $activeYear, $myClass, $request, $isGraduating) {
            foreach ($allStudentsLastYear as $studentId) {
                
                // Mencegah duplikasi jika tombol simpan ditekan dua kali
                $exists = ClassHistory::where('student_id', $studentId)
                    ->where('academic_year_id', $activeYear->id)
                    ->exists();
                
                if ($exists) continue;

                if (in_array($studentId, $promotedIds)) {
                    // JIKA DICENTANG: NAIK KELAS / LULUS
                    ClassHistory::create([
                        'student_id'       => $studentId,
                        'classroom_id'     => $isGraduating ? $myClass->id : $request->target_classroom_id,
                        'academic_year_id' => $activeYear->id,
                        'status'           => $isGraduating ? 'Lulus' : 'Aktif',
                    ]);
                } else {
                    // JIKA TIDAK DICENTANG: TINGGAL KELAS
                    ClassHistory::create([
                        'student_id'       => $studentId,
                        'classroom_id'     => $myClass->id, // Tetap di kelas yang sama
                        'academic_year_id' => $activeYear->id,
                        'status'           => 'Tinggal Kelas',
                    ]);
                }
            }
        });

        return back()->with('success', 'Data kenaikan kelas berhasil diproses dan disimpan ke riwayat akademik.');
    }
}