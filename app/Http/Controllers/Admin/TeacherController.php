<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class TeacherController extends Controller
{
    public function index()
    {
        $totalTeachers = Teacher::count();
        $activeTeachers = Teacher::whereHas('user', function($q) {
            $q->where('is_active', true);
        })->count();
        $inactiveTeachers = $totalTeachers - $activeTeachers;

        $teachers = Teacher::with('user')->latest()->get(); 
        
        return view('admin.teachers.index', compact('teachers', 'totalTeachers', 'activeTeachers', 'inactiveTeachers'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Validasi Akun User
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'is_active' => 'boolean',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Maksimal 2MB
            
            // Validasi Profil Guru
            'nip' => 'required|string|max:20|unique:teachers,nip', // Wajib untuk password
            'nik' => 'nullable|string|max:20|unique:teachers,nik', // Kolom NIK baru
            'nuptk' => 'nullable|string|max:20|unique:teachers,nuptk',
            'gender' => 'required|in:L,P',
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $validated) {
            // Handle Upload Avatar
            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
            }

            // Buat User (Password default disamakan dengan NIP)
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['nip']),
                'is_active' => $request->has('is_active'),
                'avatar' => $avatarPath,
            ]);

            $user->assignRole('guru');

            // Buat Profil Teacher
            Teacher::create([
                'user_id' => $user->id,
                'nik' => $validated['nik'],
                'nip' => $validated['nip'],
                'nuptk' => $validated['nuptk'],
                'gender' => $validated['gender'],
                'phone_number' => $validated['phone_number'],
                'address' => $validated['address'],
            ]);
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Data Guru berhasil ditambahkan. Password default adalah NIP.');
    }

    public function edit(Teacher $teacher)
    {
        $teacher->load('user'); 
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $teacher->user_id,
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'is_active' => 'boolean',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            
            'nip' => 'required|string|max:20|unique:teachers,nip,' . $teacher->id,
            'nik' => 'nullable|string|max:20|unique:teachers,nik,' . $teacher->id,
            'nuptk' => 'nullable|string|max:20|unique:teachers,nuptk,' . $teacher->id,
            'gender' => 'required|in:L,P',
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $validated, $teacher) {
            $user = $teacher->user;
            
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'is_active' => $request->has('is_active'),
            ];

            // Handle Update Avatar
            if ($request->hasFile('avatar')) {
                // Hapus avatar lama dari storage jika ada
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $userData['avatar'] = $request->file('avatar')->store('avatars', 'public');
            }

            // Update password hanya jika diisi (opsional saat edit)
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            // Update Profil Teacher
            $teacher->update([
                'nik' => $validated['nik'],
                'nip' => $validated['nip'],
                'nuptk' => $validated['nuptk'],
                'gender' => $validated['gender'],
                'phone_number' => $validated['phone_number'],
                'address' => $validated['address'],
            ]);
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Data Guru berhasil diperbarui.');
    }

    public function destroy(Teacher $teacher)
    {
        // Hapus file foto dari storage sebelum hapus data dari database
        if ($teacher->user->avatar && Storage::disk('public')->exists($teacher->user->avatar)) {
            Storage::disk('public')->delete($teacher->user->avatar);
        }
        
        $teacher->user->delete(); // Cascade delete akan otomatis menghapus profil Teacher
        
        return redirect()->route('admin.teachers.index')->with('success', 'Data Guru berhasil dihapus.');
    }
}