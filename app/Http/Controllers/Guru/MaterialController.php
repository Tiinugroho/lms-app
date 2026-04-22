<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Material;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    /**
     * Menampilkan daftar materi yang pernah diupload oleh Guru ini
     */
    public function index()
    {
        $teacher = Auth::user()->teacher;

        $materials = Material::with(['classroom', 'subject'])
            ->where('teacher_id', $teacher->id)
            ->latest()
            ->get();

        return view('guru.materials.index', compact('materials'));
    }

    /**
     * Menampilkan form upload materi baru
     */
    public function create()
    {
        $teacher = Auth::user()->teacher;
        $activeYear = AcademicYear::where('is_active', true)->first();

        if (!$activeYear) {
            return redirect()->route('guru.materials.index')->withErrors('Tidak ada Tahun Ajaran yang aktif.');
        }

        // Ambil daftar unik Kelas & Mapel yang diajar guru ini dari tabel Jadwal
        // Menggunakan unique() agar jika guru mengajar mapel yang sama 2x seminggu di kelas yang sama, opsinya tidak dobel.
        $teachingClasses = Schedule::with(['classroom', 'subject'])
            ->where('teacher_id', $teacher->id)
            ->where('academic_year_id', $activeYear->id)
            ->get()
            ->unique(function ($item) {
                return $item->classroom_id . '-' . $item->subject_id;
            });

        if ($teachingClasses->isEmpty()) {
            return redirect()->route('guru.materials.index')->withErrors('Anda belum memiliki jadwal mengajar di tahun ajaran ini.');
        }

        return view('guru.materials.create', compact('teachingClasses'));
    }

    /**
     * Memproses penyimpanan materi dan upload file
     */
    public function store(Request $request)
    {
        $request->validate([
            'classroom_subject' => 'required|string', // Value gabungan: classroom_id|subject_id
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,rar|max:10240', // Maks 10MB
            'external_link' => 'nullable|url'
        ], [
            'file.mimes' => 'Format file harus berupa PDF, Word, PowerPoint, Excel, atau arsip ZIP/RAR.',
            'file.max' => 'Ukuran file maksimal adalah 10 MB.',
            'external_link.url' => 'Format link tidak valid (harus diawali http:// atau https://).'
        ]);

        $teacher = Auth::user()->teacher;

        // Memecah value gabungan menjadi classroom_id dan subject_id
        $parts = explode('|', $request->classroom_subject);
        $classroomId = $parts[0];
        $subjectId = $parts[1];

        // Proses Upload File jika ada
        $filePath = null;
        if ($request->hasFile('file')) {
            // Simpan ke folder storage/app/public/materials
            $filePath = $request->file('file')->store('materials', 'public');
        }

        Material::create([
            'teacher_id' => $teacher->id,
            'classroom_id' => $classroomId,
            'subject_id' => $subjectId,
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'external_link' => $request->external_link,
        ]);

        return redirect()->route('guru.materials.index')->with('success', 'Bahan Ajar berhasil diunggah!');
    }

    /**
     * Menghapus materi beserta file fisiknya
     */
    public function destroy(Material $material)
    {
        // Keamanan: Pastikan yang menghapus adalah pemilik materi
        if ($material->teacher_id !== Auth::user()->teacher->id) {
            abort(403, 'Unauthorized action.');
        }

        // Hapus file fisik dari storage jika ada
        if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return redirect()->route('guru.materials.index')->with('success', 'Bahan Ajar berhasil dihapus!');
    }
}