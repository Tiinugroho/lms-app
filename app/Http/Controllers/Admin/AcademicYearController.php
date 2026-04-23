<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AcademicYearController extends Controller
{
    public function index()
    {
        $totalYears = AcademicYear::count();
        $activeYear = AcademicYear::where('is_active', true)->first();
        
        $activeYearName = $activeYear ? $activeYear->period . ' ' . $activeYear->semester : 'Belum Ada yang Aktif';

        $academicYears = AcademicYear::orderBy('period', 'desc')->orderBy('semester', 'desc')->get();

        return view('admin.academic-years.index', compact('academicYears', 'totalYears', 'activeYearName'));
    }

    public function create()
    {
        return view('admin.academic-years.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'period' => ['required', 'string', 'regex:/^\d{4}\/\d{4}$/'],
        ], [
            'period.regex' => 'Format Tahun Akademik harus YYYY/YYYY (contoh: 2024/2025).',
        ]);

        $period = $validated['period'];

        if (AcademicYear::where('period', $period)->exists()) {
            return back()->withErrors(['period' => 'Tahun Akademik ini sudah ada di dalam database.'])->withInput();
        }

        DB::transaction(function () use ($period) {
            AcademicYear::create([
                'period' => $period,
                'semester' => 'Ganjil',
                'is_active' => false,
            ]);

            AcademicYear::create([
                'period' => $period,
                'semester' => 'Genap',
                'is_active' => false,
            ]);
        });

        return redirect()->route('admin.academic-years.index')->with('success', 'Tahun Akademik baru (Ganjil & Genap) berhasil ditambahkan. Silakan edit untuk mengatur tanggal.');
    }

    // DIMUNCULKAN KEMBALI: Hanya untuk mengedit Tanggal Mulai & Tanggal Akhir
    public function edit(AcademicYear $academicYear)
    {
        return view('admin.academic-years.edit', compact('academicYear'));
    }

    public function update(Request $request, AcademicYear $academicYear)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
        ], [
            'end_date.after_or_equal' => 'Tanggal Selesai tidak boleh lebih awal dari Tanggal Mulai.',
        ]);

        $academicYear->update([
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
        ]);

        return redirect()->route('admin.academic-years.index')->with('success', 'Rentang tanggal untuk Tahun Akademik ' . $academicYear->period . ' semester ' . $academicYear->semester . ' berhasil diperbarui.');
    }

    public function destroy(AcademicYear $academicYear)
    {
        if ($academicYear->is_active) {
            return redirect()->back()->withErrors('Tidak dapat menghapus Tahun Akademik yang sedang aktif!');
        }

        $academicYear->delete();

        return redirect()->route('admin.academic-years.index')->with('success', 'Data semester berhasil dihapus.');
    }

    public function activate(AcademicYear $academicYear)
    {
        DB::transaction(function () use ($academicYear) {
            AcademicYear::query()->update(['is_active' => false]);
            $academicYear->update(['is_active' => true]);
        });

        return redirect()->back()->with('success', 'Tahun Akademik ' . $academicYear->period . ' ' . $academicYear->semester . ' sekarang Aktif.');
    }
}