<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\Material;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    /**
     * Menampilkan seluruh data absensi (Jurnal) dari semua kelas & guru
     */
    public function attendances(Request $request)
    {
        $academicYears = AcademicYear::orderBy('period', 'desc')->orderBy('semester', 'desc')->get();
        $activeYear = AcademicYear::where('is_active', true)->first();
        $selectedYearId = $request->academic_year_id ?? ($activeYear->id ?? null);

        $attendances = Attendance::with(['schedule.teacher.user', 'schedule.classroom', 'schedule.subject'])
            ->whereHas('schedule', function($q) use ($selectedYearId) {
                $q->where('academic_year_id', $selectedYearId);
            })
            ->orderBy('date', 'desc')
            ->get();

        return view('admin.monitoring.attendances', compact('attendances', 'academicYears', 'selectedYearId'));
    }

    /**
     * Menampilkan seluruh data bahan ajar (Materi) dari semua kelas & guru
     */
    public function materials(Request $request)
    {
        $materials = Material::with(['teacher.user', 'classroom', 'subject'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.monitoring.materials', compact('materials'));
    }
}