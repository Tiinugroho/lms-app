<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Lakukan autentikasi email & password
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        // 2. Keamanan Ekstra: Cek apakah akun aktif
        if (!$user->is_active) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda telah dinonaktifkan. Silakan hubungi Administrator.',
            ])->with('success', 'Login gagal! Akun Anda telah dinonaktifkan.');
        }

        // 3. Arahkan URL (Redirect) berdasarkan Role menggunakan Spatie
        if ($user->hasAnyRole(['super-admin', 'admin-sekolah'])) {
            return redirect()->intended(route('admin.dashboard', absolute: false))->with('success', 'Login berhasil! Selamat datang, ' . $user->name . '.');
        } 
        
        if ($user->hasRole('guru')) {
            return redirect()->intended(route('guru.dashboard', absolute: false))->with('success', 'Login berhasil! Selamat datang, ' . $user->name . '.');
        } 
        
        if ($user->hasRole('siswa')) {
            return redirect()->intended(route('siswa.dashboard', absolute: false))->with('success', 'Login berhasil! Selamat datang, ' . $user->name . '.');
        }

        // Fallback (jika user tidak punya role spesifik, misalnya wali murid)
        return redirect()->intended(route('dashboard', absolute: false))->with('success', 'Login berhasil, tetapi tidak ada dashboard khusus untuk role Anda.');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah berhasil logout.');
    }
}