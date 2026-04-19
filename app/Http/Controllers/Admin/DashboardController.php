<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil Statistik Kartu Utama
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $inactiveUsers = User::where('is_active', false)->count();

        // 2. Ambil Data untuk Chart (Distribusi Jumlah User Berdasarkan Role)
        // Menghitung berapa banyak user yang ada di masing-masing role
        $roles = Role::withCount('users')->get();
        
        // Memformat nama role untuk label chart (misal: "super-admin" jadi "SUPER ADMIN")
        $chartLabels = $roles->pluck('name')->map(function($name) {
            return strtoupper(str_replace('-', ' ', $name));
        })->toArray();
        
        // Mengambil jumlah user-nya
        $chartData = $roles->pluck('users_count')->toArray();

        // 3. Ambil Data Tabel (Daftar Pengguna beserta Role-nya)
        $users = User::with('roles')->latest()->get();

        return view('admin.dashboard', compact(
            'totalUsers', 
            'activeUsers', 
            'inactiveUsers', 
            'chartLabels', 
            'chartData', 
            'users'
        )); 
    }
}