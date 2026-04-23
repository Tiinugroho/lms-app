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
        $setting = Setting::getSetting();
        return view('admin.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_short_name' => 'required|string|max:50',
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

        // Tangkap nilai checkbox Toggle (Jika tidak dicentang, nilainya false)
        $validated['is_promotion_open'] = $request->has('is_promotion_open') ? true : false;

        $setting = Setting::getSetting();

        if ($request->hasFile('app_logo')) {
            if ($setting->app_logo && Storage::disk('public')->exists($setting->app_logo)) {
                Storage::disk('public')->delete($setting->app_logo);
            }
            $validated['app_logo'] = $request->file('app_logo')->store('settings', 'public');
        }

        if ($request->hasFile('favicon')) {
            if ($setting->favicon && Storage::disk('public')->exists($setting->favicon)) {
                Storage::disk('public')->delete($setting->favicon);
            }
            $validated['favicon'] = $request->file('favicon')->store('settings', 'public');
        }

        $setting->update($validated);

        return redirect()->back()->with('success', 'Pengaturan Website berhasil diperbarui!');
    }
}