<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\ClassHistory;
use App\Models\Classroom;
use App\Models\Student;
use Illuminate\Database\Seeder;

class ClassHistorySeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::all();
        
        // 1. Ambil Tahun Ajaran (Masa Lalu Ganjil & Genap, serta Saat Ini)
        $pastGanjil = AcademicYear::where('period', '2025/2026')->where('semester', 'Ganjil')->first();
        $pastGenap  = AcademicYear::where('period', '2025/2026')->where('semester', 'Genap')->first();
        $activeYear = AcademicYear::where('is_active', true)->first(); // 2026/2027 Ganjil

        if ($students->count() < 3 || !$activeYear || !$pastGanjil || !$pastGenap) {
            return;
        }

        // 2. Buat "Jalur Kelas" (Class Tracks)
        // Logika ini akan mengelompokkan kelas berdasarkan jurusan dan urutannya.
        // Contoh: 'IPA 1' => [10 => ID_X_IPA_1, 11 => ID_XI_IPA_1, 12 => ID_XII_IPA_1]
        $classrooms = Classroom::all();
        $tracks = [];
        
        foreach ($classrooms as $c) {
            // Hapus angka romawi tingkat untuk mendapatkan nama generiknya (contoh: "IPA 1")
            $trackName = trim(str_replace(['XII', 'XI', 'X'], '', $c->name));
            $tracks[$trackName][$c->level] = $c->id;
        }
        
        $trackKeys = array_keys($tracks); // ['IPA 1', 'IPA 2', 'IPS 1', dst...]
        $totalTracks = count($trackKeys);

        if ($totalTracks === 0) return;

        // 3. Bagi siswa menjadi 3 Angkatan yang sama rata
        $shuffledStudents = $students->shuffle();
        $chunkSize = ceil($shuffledStudents->count() / 3);
        
        $angkatan1 = $shuffledStudents->splice(0, $chunkSize); // Akan jadi Kelas XII
        $angkatan2 = $shuffledStudents->splice(0, $chunkSize); // Akan jadi Kelas XI
        $angkatan3 = $shuffledStudents;                        // Akan jadi Kelas X (Baru)

        $trackIndex = 0;

        // ==========================================
        // ANGKATAN 1: Saat ini Kelas XII
        // Sejarah: Tahun lalu mereka kelas XI (Ganjil & Genap)
        // ==========================================
        foreach ($angkatan1 as $student) {
            $trackName = $trackKeys[$trackIndex % $totalTracks]; // Ambil jalur berurutan (misal: IPA 1)
            $classXI  = $tracks[$trackName][11] ?? null;
            $classXII = $tracks[$trackName][12] ?? null;

            if ($classXI && $classXII) {
                // Catat Sejarah di Kelas XI Tahun Lalu (Ganjil & Genap)
                ClassHistory::firstOrCreate(['student_id' => $student->id, 'academic_year_id' => $pastGanjil->id], ['classroom_id' => $classXI, 'status' => 'Aktif']);
                ClassHistory::firstOrCreate(['student_id' => $student->id, 'academic_year_id' => $pastGenap->id], ['classroom_id' => $classXI, 'status' => 'Aktif']);
                
                // Catat di Kelas XII Tahun Ini (Semester Aktif)
                ClassHistory::firstOrCreate(['student_id' => $student->id, 'academic_year_id' => $activeYear->id], ['classroom_id' => $classXII, 'status' => 'Aktif']);
            }
            $trackIndex++;
        }

        // ==========================================
        // ANGKATAN 2: Saat ini Kelas XI
        // Sejarah: Tahun lalu mereka kelas X (Ganjil & Genap)
        // ==========================================
        foreach ($angkatan2 as $student) {
            $trackName = $trackKeys[$trackIndex % $totalTracks];
            $classX  = $tracks[$trackName][10] ?? null;
            $classXI = $tracks[$trackName][11] ?? null;

            if ($classX && $classXI) {
                // Catat Sejarah di Kelas X Tahun Lalu (Ganjil & Genap)
                ClassHistory::firstOrCreate(['student_id' => $student->id, 'academic_year_id' => $pastGanjil->id], ['classroom_id' => $classX, 'status' => 'Aktif']);
                ClassHistory::firstOrCreate(['student_id' => $student->id, 'academic_year_id' => $pastGenap->id], ['classroom_id' => $classX, 'status' => 'Aktif']);
                
                // Catat di Kelas XI Tahun Ini (Semester Aktif)
                ClassHistory::firstOrCreate(['student_id' => $student->id, 'academic_year_id' => $activeYear->id], ['classroom_id' => $classXI, 'status' => 'Aktif']);
            }
            $trackIndex++;
        }

        // ==========================================
        // ANGKATAN 3: Saat ini Kelas X (Siswa Baru)
        // Sejarah: Tidak ada (Hanya masuk di tahun ini)
        // ==========================================
        foreach ($angkatan3 as $student) {
            $trackName = $trackKeys[$trackIndex % $totalTracks];
            $classX = $tracks[$trackName][10] ?? null;

            if ($classX) {
                // Hanya dicatat di tahun ini (Semester Aktif)
                ClassHistory::firstOrCreate(['student_id' => $student->id, 'academic_year_id' => $activeYear->id], ['classroom_id' => $classX, 'status' => 'Aktif']);
            }
            $trackIndex++;
        }
    }
}