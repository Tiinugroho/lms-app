<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class TeacherController extends Controller
{
    public function index()
    {
        // Menghitung statistik untuk card di atas tabel
        $totalTeachers = Teacher::count();
        $activeTeachers = Teacher::whereHas('user', function($q) {
            $q->where('is_active', true);
        })->count();
        $inactiveTeachers = $totalTeachers - $activeTeachers;

        $teachers = Teacher::with('user')->latest()->get(); // Bisa diganti paginate(10) jika data sudah banyak
        
        return view('admin.teachers.index', compact('teachers', 'totalTeachers', 'activeTeachers', 'inactiveTeachers'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            // Validasi Akun User
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::defaults()],
            'is_active' => 'boolean',
            
            // Validasi Profil Guru
            'nip' => 'nullable|string|max:20|unique:teachers,nip',
            'nuptk' => 'nullable|string|max:20|unique:teachers,nuptk',
            'gender' => 'required|in:L,P',
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_active' => $request->has('is_active'),
            ]);

            $user->assignRole('guru');

            Teacher::create([
                'user_id' => $user->id,
                'nip' => $request->nip,
                'nuptk' => $request->nuptk,
                'gender' => $request->gender,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
            ]);
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Data Guru berhasil ditambahkan.');
    }

    public function edit(Teacher $teacher)
    {
        $teacher->load('user'); // Load data user yang terkait
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $teacher->user_id,
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'is_active' => 'boolean',
            
            'nip' => 'nullable|string|max:20|unique:teachers,nip,' . $teacher->id,
            'nuptk' => 'nullable|string|max:20|unique:teachers,nuptk,' . $teacher->id,
            'gender' => 'required|in:L,P',
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $teacher) {
            // Update User
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'is_active' => $request->has('is_active'),
            ];

            // Jika password diisi, update password
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $teacher->user->update($userData);

            // Update Teacher
            $teacher->update([
                'nip' => $request->nip,
                'nuptk' => $request->nuptk,
                'gender' => $request->gender,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
            ]);
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Data Guru berhasil diperbarui.');
    }

    public function destroy(Teacher $teacher)
    {
        // Cukup hapus User-nya, data Teacher akan otomatis terhapus (Cascade on Delete)
        $teacher->user->delete();
        
        return redirect()->route('admin.teachers.index')->with('success', 'Data Guru berhasil dihapus.');
    }
}