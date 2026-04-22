<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $academicYears = AcademicYear::orderBy('period', 'desc')->orderBy('semester', 'desc')->get();
        $activeYear = AcademicYear::where('is_active', true)->first();
        
        $selectedYearId = $request->academic_year_id ?? ($activeYear->id ?? null);

        $schedules = Schedule::with(['classroom', 'subject', 'teacher.user'])
            ->when($selectedYearId, function ($query) use ($selectedYearId) {
                return $query->where('academic_year_id', $selectedYearId);
            })
            ->orderByRaw("FIELD(day_of_week, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('start_time', 'asc')
            ->get();

        return view('admin.schedules.index', compact('schedules', 'academicYears', 'selectedYearId'));
    }

    public function create()
    {
        $activeYear = AcademicYear::where('is_active', true)->first();
        
        if (!$activeYear) {
            return redirect()->route('admin.schedules.index')->withErrors('Tidak ada Tahun Ajaran yang aktif.');
        }

        $classrooms = Classroom::orderBy('level')->orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        $teachers = Teacher::with('user')->whereHas('user', function($q) {
            $q->where('is_active', true);
        })->get();
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        return view('admin.schedules.create', compact('activeYear', 'classrooms', 'subjects', 'teachers', 'days'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'day_of_week' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ], [
            'end_time.after' => 'Jam selesai harus lebih besar dari jam mulai.',
        ]);

        // Cek Bentrok Jadwal
        $clashError = $this->checkScheduleClash(
            $validated['academic_year_id'],
            $validated['day_of_week'],
            $validated['start_time'],
            $validated['end_time'],
            $validated['teacher_id'],
            $validated['classroom_id']
        );

        if ($clashError) {
            return back()->withInput()->withErrors(['clash' => $clashError]);
        }

        Schedule::create($validated);

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal Pelajaran berhasil ditambahkan.');
    }

    public function edit(Schedule $schedule)
    {
        $classrooms = Classroom::orderBy('level')->orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        $teachers = Teacher::with('user')->whereHas('user', function($q) {
            $q->where('is_active', true);
        })->get();
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        return view('admin.schedules.edit', compact('schedule', 'classrooms', 'subjects', 'teachers', 'days'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'day_of_week' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'start_time' => 'required|date_format:H:i|date_format:H:i:s', // Kadang HTML time mengirimkan detik
            'end_time' => 'required|date_format:H:i|date_format:H:i:s|after:start_time',
        ]);

        // Jika format waktu memiliki detik (misal 07:30:00), potong menjadi H:i (07:30) agar validasi bekerja konsisten
        $startTime = substr($validated['start_time'], 0, 5);
        $endTime = substr($validated['end_time'], 0, 5);

        // Cek Bentrok Jadwal (Tambahkan $schedule->id agar tidak mengecek jadwalnya sendiri saat di-update)
        $clashError = $this->checkScheduleClash(
            $schedule->academic_year_id,
            $validated['day_of_week'],
            $startTime,
            $endTime,
            $validated['teacher_id'],
            $validated['classroom_id'],
            $schedule->id
        );

        if ($clashError) {
            return back()->withInput()->withErrors(['clash' => $clashError]);
        }

        $schedule->update([
            'classroom_id' => $validated['classroom_id'],
            'subject_id' => $validated['subject_id'],
            'teacher_id' => $validated['teacher_id'],
            'day_of_week' => $validated['day_of_week'],
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal Pelajaran berhasil diperbarui.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal Pelajaran berhasil dihapus.');
    }

    /**
     * PRIVATE METHOD: Radar Anti Bentrok Jadwal
     */
    private function checkScheduleClash($academicYearId, $dayOfWeek, $startTime, $endTime, $teacherId, $classroomId, $ignoreScheduleId = null)
    {
        // 1. Cek Bentrok RUANG KELAS (Apakah kelas ini sudah ada mapel lain di jam tersebut?)
        $roomClash = Schedule::where('academic_year_id', $academicYearId)
            ->where('day_of_week', $dayOfWeek)
            ->where('classroom_id', $classroomId)
            ->when($ignoreScheduleId, function($q) use ($ignoreScheduleId) {
                return $q->where('id', '!=', $ignoreScheduleId); // Abaikan jadwal diri sendiri saat update
            })
            ->where(function($q) use ($startTime, $endTime) {
                // Logika Overlap Waktu
                $q->where('start_time', '<', $endTime)
                  ->where('end_time', '>', $startTime);
            })->first();

        if ($roomClash) {
            return "Bentrok! Ruang kelas ini sudah digunakan untuk mata pelajaran {$roomClash->subject->name} pada rentang waktu tersebut.";
        }

        // 2. Cek Bentrok GURU (Apakah guru ini ngajar di kelas lain di jam tersebut?)
        $teacherClash = Schedule::where('academic_year_id', $academicYearId)
            ->where('day_of_week', $dayOfWeek)
            ->where('teacher_id', $teacherId)
            ->when($ignoreScheduleId, function($q) use ($ignoreScheduleId) {
                return $q->where('id', '!=', $ignoreScheduleId);
            })
            ->where(function($q) use ($startTime, $endTime) {
                $q->where('start_time', '<', $endTime)
                  ->where('end_time', '>', $startTime);
            })->first();

        if ($teacherClash) {
            return "Bentrok! Guru bersangkutan sudah memiliki jadwal mengajar di kelas {$teacherClash->classroom->name} pada rentang waktu tersebut.";
        }

        return null; // Aman, tidak ada yang bentrok
    }
}