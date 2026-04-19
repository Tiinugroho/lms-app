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
        // Statistik untuk Cards
        $totalYears = AcademicYear::count();
        $activeYear = AcademicYear::where('is_active', true)->first();
        // Menggunakan accessor 'name' yang sudah kita buat di Model sebelumnya
        // Hapus baris ini:
        // $activeYearName = $activeYear ? $activeYear->name : 'Belum Ada yang Aktif';

        // GANTI menjadi seperti ini:
        $activeYearName = $activeYear ? $activeYear->period . ' ' . $activeYear->semester : 'Belum Ada yang Aktif';

        // Menggunakan get() untuk DataTables
        // Diurutkan berdasarkan period terbaru, lalu semester Genap (agar Ganjil muncul duluan di tahun yang sama jika descending)
        $academicYears = AcademicYear::orderBy('period', 'desc')->orderBy('semester', 'desc')->get();

        return view('admin.academic-years.index', compact('academicYears', 'totalYears', 'activeYearName'));
    }

    public function create()
    {
        return view('admin.academic-years.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'period' => [
                    'required',
                    'string',
                    'regex:/^\d{4}\/\d{4}$/', // Wajib format: 2024/2025
                ],
            ],
            [
                'period.regex' => 'Format Tahun Akademik harus YYYY/YYYY (contoh: 2024/2025).',
            ],
        );

        $period = $validated['period'];

        // Cek apakah tahun ajaran ini sudah pernah dibuat
        if (AcademicYear::where('period', $period)->exists()) {
            return back()
                ->withErrors(['period' => 'Tahun Akademik ini sudah ada di dalam database.'])
                ->withInput();
        }

        // Gunakan DB Transaction untuk membuat Ganjil & Genap sekaligus
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

        return redirect()->route('admin.academic-years.index')->with('success', 'Tahun Akademik baru (Ganjil & Genap) berhasil ditambahkan.');
    }

    // CATATAN: Method EDIT dan UPDATE sengaja DIHAPUS.
    // Mengedit "period" sangat berbahaya jika data ini sudah berelasi dengan tabel Nilai atau Pembayaran.
    // Jika admin salah input, lebih baik di-HAPUS lalu di-CREATE ulang (selama belum ada transaksi).

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
            // Nonaktifkan semua yang sedang aktif
            AcademicYear::query()->update(['is_active' => false]);
            // Aktifkan yang dipilih
            $academicYear->update(['is_active' => true]);
        });

        return redirect()
            ->back()
            ->with('success', 'Tahun Akademik ' . $academicYear->name . ' sekarang Aktif.');
    }
}
