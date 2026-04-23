<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\ClassHistory;
use App\Models\Student;
use Illuminate\Http\Request;

class RombelController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil data master untuk Dropdown Filter
        $academicYears = AcademicYear::orderBy('period', 'desc')->orderBy('semester', 'desc')->get();
        $classrooms = Classroom::orderBy('level')->orderBy('name')->get();

        $activeYear = AcademicYear::where('is_active', true)->first();

        // 2. Tangkap parameter filter (Default: Tahun Ajaran Aktif)
        $selectedYearId = $request->academic_year_id ?? ($activeYear ? $activeYear->id : null);
        $selectedClassroomId = $request->classroom_id;

        $students = collect();
        $unplacedStudents = collect();
        $selectedYear = null;
        $selectedClass = null;

        if ($selectedYearId && $selectedClassroomId) {
            $selectedYear = AcademicYear::find($selectedYearId);
            $selectedClass = Classroom::find($selectedClassroomId);

            // 3. Ambil data siswa yang BERADA di kelas dan tahun tersebut
            $students = ClassHistory::with(['student.user'])
                ->where('academic_year_id', $selectedYearId)
                ->where('classroom_id', $selectedClassroomId)
                ->get()
                ->sortBy(function($history) {
                    return $history->student->user->name; // Urutkan sesuai abjad nama
                });

            // 4. Ambil daftar siswa yang BELUM PUNYA KELAS di Tahun Ajaran tersebut (Untuk input manual)
            $placedStudentIds = ClassHistory::where('academic_year_id', $selectedYearId)->pluck('student_id');
            
            $unplacedStudents = Student::with('user')
                ->whereNotIn('id', $placedStudentIds)
                ->get()
                ->sortBy(function($student) {
                    return $student->user->name;
                });
        }

        return view('admin.rombels.index', compact(
            'academicYears', 
            'classrooms', 
            'selectedYearId', 
            'selectedClassroomId', 
            'students', 
            'selectedYear', 
            'selectedClass',
            'unplacedStudents'
        ));
    }

    // Fungsi untuk memasukkan siswa secara massal
    public function store(Request $request)
    {
        // Validasi input array
        $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'classroom_id'     => 'required|exists:classrooms,id',
            'student_ids'      => 'required|array|min:1',
            'student_ids.*'    => 'exists:students,id',
        ], [
            'student_ids.required' => 'Pilih minimal satu siswa untuk dimasukkan ke kelas.',
        ]);

        $insertedCount = 0;

        foreach ($request->student_ids as $studentId) {
            // Proteksi: Pastikan siswa belum ada di kelas lain pada tahun yang sama
            $exists = ClassHistory::where('academic_year_id', $request->academic_year_id)
                        ->where('student_id', $studentId)
                        ->exists();

            if (!$exists) {
                ClassHistory::create([
                    'student_id'       => $studentId,
                    'classroom_id'     => $request->classroom_id,
                    'academic_year_id' => $request->academic_year_id,
                    'status'           => 'Aktif',
                ]);
                $insertedCount++;
            }
        }

        return back()->with('success', $insertedCount . ' Siswa berhasil dimasukkan ke dalam Rombel.');
    }

    // Fungsi untuk mengeluarkan siswa dari kelas (Salah input / Keluar)
    public function destroy(ClassHistory $rombel)
    {
        $rombel->delete();
        return back()->with('success', 'Siswa berhasil dikeluarkan dari daftar kelas tersebut.');
    }
}