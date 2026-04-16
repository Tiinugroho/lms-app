<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        // Menampilkan semua mapel, diurutkan dari yang terbaru
        $subjects = Subject::latest()->paginate(10);
        return view('admin.subjects.index', compact('subjects'));
    }

    public function create()
    {
        // Menampilkan form tambah mapel
        return view('admin.subjects.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:subjects,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Simpan ke database
        Subject::create($validated);

        return redirect()->route('admin.subjects.index')->with('success', 'Mata Pelajaran berhasil ditambahkan.');
    }

    public function show(Subject $subject)
    {
        // Opsional: Menampilkan detail mapel beserta daftar tugas di dalamnya
        $subject->load('assignments');
        return view('admin.subjects.show', compact('subject'));
    }

    public function edit(Subject $subject)
    {
        // Menampilkan form edit mapel
        return view('admin.subjects.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        // Validasi update (pengecualian unique untuk ID yang sedang di-edit)
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:subjects,code,' . $subject->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Update data
        $subject->update($validated);

        return redirect()->route('admin.subjects.index')->with('success', 'Mata Pelajaran berhasil diperbarui.');
    }

    public function destroy(Subject $subject)
    {
        // Hapus data
        $subject->delete();

        return redirect()->route('admin.subjects.index')->with('success', 'Mata Pelajaran berhasil dihapus.');
    }
}