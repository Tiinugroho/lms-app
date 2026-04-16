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
        // Menampilkan daftar tahun ajaran, diurutkan dari yang terbaru
        $academicYears = AcademicYear::latest()->paginate(10);
        return view('admin.academic-years.index', compact('academicYears'));
    }

    public function create()
    {
        return view('admin.academic-years.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:academic_years,name',
            // is_active tidak divalidasi dari form create, default selalu false di awal
        ]);

        AcademicYear::create([
            'name' => $validated['name'],
            'is_active' => false, // Aman: default selalu tidak aktif saat baru dibuat
        ]);

        return redirect()->route('admin.academic-years.index')->with('success', 'Tahun Ajaran baru berhasil ditambahkan.');
    }

    public function edit(AcademicYear $academicYear)
    {
        return view('admin.academic-years.edit', compact('academicYear'));
    }

    public function update(Request $request, AcademicYear $academicYear)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:academic_years,name,' . $academicYear->id,
        ]);

        $academicYear->update($validated);

        return redirect()->route('admin.academic-years.index')->with('success', 'Nama Tahun Ajaran berhasil diperbarui.');
    }

    public function destroy(AcademicYear $academicYear)
    {
        // Proteksi: Jangan izinkan menghapus tahun ajaran yang sedang aktif
        if ($academicYear->is_active) {
            return redirect()->back()->withErrors('Tidak dapat menghapus Tahun Ajaran yang sedang aktif!');
        }

        $academicYear->delete();

        return redirect()->route('admin.academic-years.index')->with('success', 'Tahun Ajaran berhasil dihapus.');
    }

    /**
     * Method Khusus: Mengaktifkan Tahun Ajaran
     */
    public function activate(AcademicYear $academicYear)
    {
        // Gunakan transaksi DB agar jika terjadi error, data tidak setengah-setengah
        DB::transaction(function () use ($academicYear) {
            // 1. Nonaktifkan semua tahun ajaran yang ada di database
            AcademicYear::query()->update(['is_active' => false]);
            
            // 2. Aktifkan hanya tahun ajaran yang dipilih
            $academicYear->update(['is_active' => true]);
        });

        return redirect()->back()->with('success', 'Tahun Ajaran ' . $academicYear->name . ' sekarang aktif.');
    }
}