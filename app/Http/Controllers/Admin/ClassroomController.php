<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassHistory;
use App\Models\Classroom;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index()
    {
        // Load data kelas beserta wali kelasnya dan ambil nama usernya
        $classrooms = Classroom::with('homeroomTeacher.user')->orderBy('level')->get();
        return view('admin.classrooms.index', compact('classrooms'));
    }

    public function create()
    {
        // Ambil data guru untuk dipilih sebagai wali kelas
        $teachers = Teacher::with('user')->get();
        return view('admin.classrooms.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|integer|min:1|max:12', // Asumsi tingkat 1 s/d 12
            'homeroom_teacher_id' => 'nullable|exists:teachers,id',
        ]);

        Classroom::create($validated);

        return redirect()->route('admin.classrooms.index')->with('success', 'Data Kelas berhasil dibuat.');
    }

    public function edit(Classroom $classroom)
    {
        $teachers = Teacher::with('user')->get();
        return view('admin.classrooms.edit', compact('classroom', 'teachers'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|integer|min:1|max:12',
            'homeroom_teacher_id' => 'nullable|exists:teachers,id',
        ]);

        $classroom->update($validated);

        return redirect()->route('admin.classrooms.index')->with('success', 'Data Kelas berhasil diperbarui.');
    }

    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        return redirect()->back()->with('success', 'Data Kelas berhasil dihapus.');
    }

    public function assignClass(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'student_id' => 'required',
            'classroom_id' => 'required',
            'academic_year_id' => 'required',
            'semester' => 'required',
        ]);

        // Simpan ke history
        ClassHistory::create($validated);

        return back()->with('success', 'Siswa berhasil ditempatkan di kelas.');
    }
}
