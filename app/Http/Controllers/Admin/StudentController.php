<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('user')->latest()->paginate(10);
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            // Akun User
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
            
            // Profil Siswa
            'nis' => 'required|string|max:20|unique:students',
            'nisn' => 'nullable|string|max:20|unique:students',
            'gender' => 'required|in:L,P',
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Buat Akun
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_active' => true,
            ]);

            // 2. Berikan Hak Akses
            $user->assignRole('siswa');

            // 3. Buat Profil
            Student::create([
                'user_id' => $user->id,
                'nis' => $request->nis,
                'nisn' => $request->nisn,
                'gender' => $request->gender,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
            ]);
        });

        return redirect()->route('admin.students.index')->with('success', 'Data Siswa berhasil ditambahkan.');
    }
    
    // Method show, edit, update, destroy bisa ditambahkan dengan pola serupa
}