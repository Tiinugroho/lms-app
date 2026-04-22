<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\AttendanceDetail;
use App\Models\ClassHistory;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Halaman 1: Menampilkan Card Jadwal Mengajar Guru
     */
    public function index()
    {
        $activeYear = AcademicYear::where('is_active', true)->first();
        
        // Ambil data guru dari user yang sedang login
        $teacher = Auth::user()->teacher;

        if (!$activeYear || !$teacher) {
            return redirect()->route('guru.dashboard')->withErrors('Data Tahun Ajaran aktif atau Profil Guru tidak ditemukan.');
        }

        // Ambil semua jadwal guru ini di tahun ajaran aktif
        $schedules = Schedule::with(['classroom', 'subject'])
            ->where('teacher_id', $teacher->id)
            ->where('academic_year_id', $activeYear->id)
            ->orderByRaw("FIELD(day_of_week, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('start_time', 'asc')
            ->get();

        return view('guru.attendances.index', compact('schedules', 'activeYear'));
    }

    /**
     * Halaman 2: Split-Screen Form Absensi
     */
    public function create(Schedule $schedule)
    {
        $activeYear = AcademicYear::where('is_active', true)->first();

        // Keamanan: Pastikan guru hanya bisa membuka jadwalnya sendiri
        if ($schedule->teacher_id !== Auth::user()->teacher->id) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini.');
        }

        // Ambil data siswa yang aktif di kelas tersebut (berdasarkan ClassHistory / Plotting)
        $students = ClassHistory::with('student.user')
            ->where('classroom_id', $schedule->classroom_id)
            ->where('academic_year_id', $activeYear->id)
            ->where('status', 'Aktif')
            ->get()
            ->sortBy(function($query) {
                return $query->student->user->name; // Urutkan berdasarkan nama abjad
            });

        // Cari tahu ini pertemuan ke-berapa (Otomatis +1 dari jumlah absen sebelumnya)
        $lastMeeting = Attendance::where('schedule_id', $schedule->id)->max('meeting_number');
        $nextMeeting = $lastMeeting ? $lastMeeting + 1 : 1;

        return view('guru.attendances.create', compact('schedule', 'students', 'nextMeeting', 'activeYear'));
    }

    /**
     * Proses Simpan Jurnal & Absensi
     */
    public function store(Request $request, Schedule $schedule)
    {
        $request->validate([
            'date' => 'required|date',
            'meeting_number' => 'required|integer|min:1',
            'topic' => 'required|string|max:255',
            'attendance' => 'required|array', // Data radio button
            'notes' => 'nullable|array',      // Catatan opsional
        ]);

        DB::transaction(function () use ($request, $schedule) {
            // 1. Simpan Header Jurnal
            $attendance = Attendance::create([
                'schedule_id' => $schedule->id,
                'date' => $request->date,
                'meeting_number' => $request->meeting_number,
                'topic' => $request->topic,
            ]);

            // 2. Simpan Detail Absensi Tiap Siswa
            foreach ($request->attendance as $studentId => $status) {
                AttendanceDetail::create([
                    'attendance_id' => $attendance->id,
                    'student_id' => $studentId,
                    'status' => $status,
                    'notes' => $request->notes[$studentId] ?? null,
                ]);
            }
        });

        return redirect()->route('guru.attendances.index')->with('success', 'Absensi dan Jurnal Mengajar berhasil disimpan!');
    }
}