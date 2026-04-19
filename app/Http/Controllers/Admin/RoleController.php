<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function index()
    {
        $totalRoles = Role::count();
        $totalPermissions = Permission::count();
        $roles = Role::withCount(['users', 'permissions'])->latest()->get();

        return view('admin.roles.index', compact('roles', 'totalRoles', 'totalPermissions'));
    }

    public function create()
    {
        // Ambil semua permission
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array', // Array dari checkbox yang dicentang
            'permissions.*' => 'exists:permissions,id' // Pastikan ID permission valid
        ]);

        // Buat Role (Otomatis huruf kecil dan format slug)
        $role = Role::create([
            'name' => Str::slug($request->name),
            'guard_name' => 'web'
        ]);

        // Tempelkan permission yang dicentang ke Role ini
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil dibuat dan hak akses telah ditetapkan.');
    }

    // Method Edit & Update
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        // Ambil ID permission yang sudah dimiliki role ini dalam bentuk array
        $rolePermissions = $role->permissions->pluck('id')->toArray(); 
        
        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role->update([
            'name' => Str::slug($request->name)
        ]);

        // Update (Sync) permission
        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('admin.roles.index')->with('success', 'Role dan hak akses berhasil diperbarui.');
    }

    public function destroy(Role $role)
    {
        if ($role->name === 'super-admin') {
            return redirect()->back()->withErrors('Role Super Admin tidak boleh dihapus!');
        }

        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil dihapus.');
    }
}