<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class StaffController extends Controller
{
    public function index()
    {
        $totalStaffs = Staff::count();
        $activeStaffs = Staff::whereHas('user', function($q) {
            $q->where('is_active', true);
        })->count();
        $inactiveStaffs = $totalStaffs - $activeStaffs;

        $staffs = Staff::with('user')->latest()->get(); 
        
        return view('admin.staffs.index', compact('staffs', 'totalStaffs', 'activeStaffs', 'inactiveStaffs'));
    }

    public function create()
    {
        $roles = Role::whereIn('name', ['super-admin', 'admin-sekolah'])->get();
        return view('admin.staffs.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Akun User
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'is_active' => 'boolean',
            'role' => 'required|exists:roles,name',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            
            // Profil Staff
            'nip' => 'required|string|max:50|unique:staffs', 
            'nik' => 'nullable|string|max:20|unique:staffs,nik', // Tambahan NIK
            'position' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $validated) {
            // Handle Upload Avatar
            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
            }

            // 1. Buat Akun (Password otomatis = NIP)
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['nip']),
                'is_active' => $request->has('is_active'),
                'avatar' => $avatarPath,
            ]);

            // 2. Berikan Hak Akses
            $user->assignRole($validated['role']);

            // 3. Buat Profil Staff
            Staff::create([
                'user_id' => $user->id,
                'nip' => $validated['nip'],
                'nik' => $validated['nik'],
                'position' => $validated['position'],
                'gender' => $validated['gender'],
                'phone_number' => $validated['phone_number'],
                'address' => $validated['address'],
            ]);
        });

        return redirect()->route('admin.staffs.index')->with('success', 'Data Staff berhasil ditambahkan. Password default adalah NIP.');
    }

    public function edit(Staff $staff)
    {
        $staff->load('user');
        $roles = Role::whereIn('name', ['super-admin', 'admin-sekolah'])->get();
        $userRole = $staff->user->roles->first()->name ?? ''; 
        
        return view('admin.staffs.edit', compact('staff', 'roles', 'userRole'));
    }

    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $staff->user_id,
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'is_active' => 'boolean',
            'role' => 'required|exists:roles,name',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            
            'nip' => 'required|string|max:50|unique:staffs,nip,' . $staff->id,
            'nik' => 'nullable|string|max:20|unique:staffs,nik,' . $staff->id,
            'position' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $validated, $staff) {
            $user = $staff->user;
            
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
                $userData['avatar'] = $request->file('avatar')->store('avatars', 'public');
            }

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);
            $user->syncRoles([$validated['role']]);

            $staff->update([
                'nip' => $validated['nip'],
                'nik' => $validated['nik'],
                'position' => $validated['position'],
                'gender' => $validated['gender'],
                'phone_number' => $validated['phone_number'],
                'address' => $validated['address'],
            ]);
        });

        return redirect()->route('admin.staffs.index')->with('success', 'Data Staff berhasil diperbarui.');
    }

    public function destroy(Staff $staff)
    {
        if ($staff->user_id === auth()->id()) {
            return redirect()->back()->withErrors('Anda tidak dapat menghapus akun Anda sendiri saat sedang login.');
        }

        // Hapus foto dari storage
        if ($staff->user->avatar && Storage::disk('public')->exists($staff->user->avatar)) {
            Storage::disk('public')->delete($staff->user->avatar);
        }

        $staff->user->delete(); 
        
        return redirect()->route('admin.staffs.index')->with('success', 'Data Staff berhasil dihapus.');
    }

    public function printIdCard(Staff $staff)
    {
        $staff->load('user');
        $setting = \App\Models\Setting::getSetting();
        return view('admin.staffs.id-card', compact('staff', 'setting'));
    }
}