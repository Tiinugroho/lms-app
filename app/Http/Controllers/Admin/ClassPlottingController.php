<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\ClassHistory;
use App\Models\Classroom;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassPlottingController extends Controller
{
    /**
     * Halaman langkah 1: Pilih Tahun Ajaran dan Kelas
     */
    public function index(Request $request)
    {
        $academicYears = AcademicYear::orderBy('period', 'desc')->orderBy('semester', 'desc')->get();
        $classrooms = Classroom::orderBy('name', 'asc')->get();
        
        // Cari tahun ajaran yang sedang aktif sebagai default pilihan
        $activeYear = AcademicYear::where('is_active', true)->first();

        // Jika user melakukan filter/submit dari dropdown
        if ($request->has('academic_year_id') && $request->has('classroom_id')) {
            return redirect()->route('admin.plottings.show', [
                'academicYear' => $request->academic_year_id,
                'classroom' => $request->classroom_id
            ]);
        }

        return view('admin.plottings.index', compact('academicYears', 'classrooms', 'activeYear'));
    }

    /**
     * Halaman langkah 2: Dual-List UI (Kiri: Belum punya kelas, Kanan: Anggota Kelas)
     */
    public function show($academicYearId, $classroomId)
    {
        $academicYear = AcademicYear::findOrFail($academicYearId);
        $classroom = Classroom::findOrFail($classroomId);

        // 1. Ambil data siswa yang SUDAH masuk ke kelas ini di tahun ajaran ini (Sisi Kanan)
        $enrolledStudents = ClassHistory::with('student.user')
            ->where('academic_year_id', $academicYear->id)
            ->where('classroom_id', $classroom->id)
            ->get();

        // 2. Ambil ID semua siswa yang SUDAH punya kelas di tahun ajaran ini (kelas manapun)
        // Ini penting agar siswa kelas X IPA 1 tidak ditarik lagi ke kelas X IPA 2
        $assignedStudentIds = ClassHistory::where('academic_year_id', $academicYear->id)
            ->pluck('student_id')
            ->toArray();

        // 3. Ambil data siswa yang BELUM punya kelas sama sekali di tahun ajaran ini (Sisi Kiri)
        $unassignedStudents = Student::with('user')
            ->whereHas('user', function($query) {
                $query->where('is_active', true); // Hanya tampilkan siswa yang akunnya aktif
            })
            ->whereNotIn('id', $assignedStudentIds)
            ->get();

        return view('admin.plottings.show', compact('academicYear', 'classroom', 'enrolledStudents', 'unassignedStudents'));
    }

    /**
     * Aksi menyimpan banyak siswa sekaligus ke dalam kelas (Ceklis & Masukkan)
     */
    public function store(Request $request, $academicYearId, $classroomId)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id'
        ], [
            'student_ids.required' => 'Anda belum memilih satupun siswa untuk dimasukkan ke kelas.'
        ]);

        $academicYear = AcademicYear::findOrFail($academicYearId);
        $classroom = Classroom::findOrFail($classroomId);

        DB::transaction(function () use ($request, $academicYear, $classroom) {
            foreach ($request->student_ids as $studentId) {
                // Gunakan firstOrCreate agar tidak crash jika tidak sengaja ada data duplikat yang masuk
                // (Mencegah violation pada constraint 'student_academic_unique')
                ClassHistory::firstOrCreate([
                    'student_id' => $studentId,
                    'academic_year_id' => $academicYear->id,
                ], [
                    'classroom_id' => $classroom->id,
                    'status' => 'Aktif' // Default status
                ]);
            }
        });

        return redirect()->back()->with('success', count($request->student_ids) . ' Siswa berhasil dimasukkan ke kelas ' . $classroom->name);
    }

    /**
     * Aksi mengeluarkan 1 siswa dari kelas (Tombol "Keluarkan" di tabel kanan)
     */
    public function destroy($classHistoryId)
    {
        $classHistory = ClassHistory::findOrFail($classHistoryId);
        $studentName = $classHistory->student->user->name;
        
        $classHistory->delete();

        return redirect()->back()->with('success', 'Siswa ' . $studentName . ' berhasil dikeluarkan dari kelas.');
    }
}