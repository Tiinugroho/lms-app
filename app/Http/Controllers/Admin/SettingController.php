<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        // Memanggil helper static yang sudah kita buat di Model
        $setting = Setting::getSetting();
        
        return view('admin.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_short_name' => 'required|string|max:50',
            
            // Validasi File Gambar (Maksimal 2MB)
            'app_logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg,ico|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg,ico|max:1024',
            
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            
            'school_phone' => 'nullable|string|max:20',
            'school_email' => 'nullable|email|max:255',
            'school_address' => 'nullable|string',
            
            'instagram_link' => 'nullable|url|max:255',
            'facebook_link' => 'nullable|url|max:255',
            'youtube_link' => 'nullable|url|max:255',
        ]);

        $setting = Setting::getSetting();

        // 2. Logic Upload Logo
        if ($request->hasFile('app_logo')) {
            // Hapus logo lama jika ada
            if ($setting->app_logo && Storage::disk('public')->exists($setting->app_logo)) {
                Storage::disk('public')->delete($setting->app_logo);
            }
            // Simpan logo baru di folder storage/app/public/settings
            $validated['app_logo'] = $request->file('app_logo')->store('settings', 'public');
        }

        // 3. Logic Upload Favicon
        if ($request->hasFile('favicon')) {
            // Hapus favicon lama jika ada
            if ($setting->favicon && Storage::disk('public')->exists($setting->favicon)) {
                Storage::disk('public')->delete($setting->favicon);
            }
            $validated['favicon'] = $request->file('favicon')->store('settings', 'public');
        }

        // 4. Update Database
        $setting->update($validated);

        // 5. Kembalikan dengan Notifikasi Sukses
        return redirect()->back()->with('success', 'Pengaturan Website berhasil diperbarui!');
    }
}