<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class StudentController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $activeStudents = Student::whereHas('user', function($q) {
            $q->where('is_active', true);
        })->count();
        $inactiveStudents = $totalStudents - $activeStudents;

        $students = Student::with('user')->latest()->get(); 
        
        return view('admin.students.index', compact('students', 'totalStudents', 'activeStudents', 'inactiveStudents'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Akun User
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'is_active' => 'boolean',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            
            // Profil Siswa
            'nis' => 'required|string|max:20|unique:students',
            'nisn' => 'nullable|string|max:20|unique:students',
            'nik' => 'nullable|string|max:20|unique:students', // Tambahan NIK
            'gender' => 'required|in:L,P',
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $validated) {
            // Handle Upload Avatar
            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatars/students', 'public');
            }

            // 1. Buat Akun (Password otomatis = NIS)
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['nis']),
                'is_active' => $request->has('is_active'),
                'avatar' => $avatarPath,
            ]);

            // 2. Berikan Hak Akses
            $user->assignRole('siswa');

            // 3. Buat Profil Siswa
            Student::create([
                'user_id' => $user->id,
                'nis' => $validated['nis'],
                'nisn' => $validated['nisn'],
                'nik' => $validated['nik'],
                'gender' => $validated['gender'],
                'phone_number' => $validated['phone_number'],
                'address' => $validated['address'],
            ]);
        });

        return redirect()->route('admin.students.index')->with('success', 'Data Siswa berhasil ditambahkan. Password default adalah NIS siswa.');
    }

    public function edit(Student $student)
    {
        $student->load('user');
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $student->user_id,
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'is_active' => 'boolean',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            
            'nis' => 'required|string|max:20|unique:students,nis,' . $student->id,
            'nisn' => 'nullable|string|max:20|unique:students,nisn,' . $student->id,
            'nik' => 'nullable|string|max:20|unique:students,nik,' . $student->id,
            'gender' => 'required|in:L,P',
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $validated, $student) {
            $user = $student->user;

            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'is_active' => $request->has('is_active'),
            ];

            // Handle Update Avatar
            if ($request->hasFile('avatar')) {
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $userData['avatar'] = $request->file('avatar')->store('avatars/students', 'public');
            }

            // Update password HANYA jika admin mengisinya di form edit
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            $student->update([
                'nis' => $validated['nis'],
                'nisn' => $validated['nisn'],
                'nik' => $validated['nik'],
                'gender' => $validated['gender'],
                'phone_number' => $validated['phone_number'],
                'address' => $validated['address'],
            ]);
        });

        return redirect()->route('admin.students.index')->with('success', 'Data Siswa berhasil diperbarui.');
    }

    public function destroy(Student $student)
    {
        // Hapus foto dari storage sebelum hapus data dari database
        if ($student->user->avatar && Storage::disk('public')->exists($student->user->avatar)) {
            Storage::disk('public')->delete($student->user->avatar);
        }

        $student->user->delete();
        return redirect()->route('admin.students.index')->with('success', 'Data Siswa berhasil dihapus.');
    }

    // Bonus: Method Cetak ID Card Siswa
    public function printIdCard(Student $student)
    {
        $student->load('user');
        $setting = \App\Models\Setting::getSetting();
        return view('admin.students.id-card', compact('student', 'setting'));
    }
}