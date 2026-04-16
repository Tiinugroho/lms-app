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
        // Eager load relasi user agar query lebih efisien (N+1 Problem terhindari)
        $teachers = Teacher::with('user')->latest()->paginate(10);
        return view('admin.teachers.index', compact('teachers'));
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
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
            
            // Validasi Profil Guru
            'nip' => 'nullable|string|max:20|unique:teachers',
            'nuptk' => 'nullable|string|max:20|unique:teachers',
            'gender' => 'required|in:L,P',
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string',
        ]);

        // Gunakan DB Transaction untuk memastikan integritas data
        DB::transaction(function () use ($request) {
            // 1. Buat Akun User
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_active' => true,
            ]);

            // 2. Berikan Role Guru menggunakan Spatie
            $user->assignRole('guru');

            // 3. Buat Profil Guru yang terhubung ke User tersebut
            Teacher::create([
                'user_id' => $user->id,
                'nip' => $request->nip,
                'nuptk' => $request->nuptk,
                'gender' => $request->gender,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
            ]);
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Data Guru dan Akun berhasil ditambahkan.');
    }

    // Method show, edit, update, dan destroy dapat dilanjutkan dengan logika serupa
}