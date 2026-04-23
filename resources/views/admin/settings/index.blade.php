@extends('partials.app')
@section('title', 'Pengaturan Website')

@section('content')
    <main class="flex-1 pb-12 pt-8 relative w-full">
        <div
            class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-indigo-50/50 to-transparent -z-10 pointer-events-none">
        </div>

        <div class="mx-auto max-w-12xl px-4 sm:px-6 lg:px-8 w-full">

            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Pengaturan Website</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola identitas, logo, kontak, dan SEO aplikasi ERP sekolah Anda.</p>
            </div>

            @if (session('success'))
                <div class="mb-6 flex items-center p-4 text-green-800 border-l-4 border-green-500 bg-green-50 rounded-r-md shadow-sm"
                    role="alert">
                    <svg class="flex-shrink-0 w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <div class="font-medium text-sm">{{ session('success') }}</div>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 flex p-4 text-red-800 border-l-4 border-red-500 bg-red-50 rounded-r-md shadow-sm"
                    role="alert">
                    <svg class="flex-shrink-0 w-5 h-5 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <span class="font-medium text-sm">Gagal menyimpan perubahan:</span>
                        <ul class="mt-1 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                <div class="bg-white shadow-sm sm:rounded-xl border border-gray-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="text-lg font-semibold text-gray-900">Identitas Website</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Aplikasi Lengkap <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="app_name" value="{{ old('app_name', $setting->app_name) }}" required
                                class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3">
                            <p class="mt-1 text-xs text-gray-500">Contoh: Sistem Informasi Akademik SMAN 1</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Singkatan <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="app_short_name"
                                value="{{ old('app_short_name', $setting->app_short_name) }}" required
                                class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3">
                            <p class="mt-1 text-xs text-gray-500">Contoh: SIAKAD (Maks 10 karakter)</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-xl border border-gray-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="text-lg font-semibold text-gray-900">Media & Branding</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Logo Utama</label>
                            <div class="flex items-start space-x-4">
                                <div class="shrink-0">
                                    <img src="{{ $setting->logo_url }}" alt="Logo"
                                        class="h-16 w-16 object-contain border border-gray-200 rounded p-1 bg-white">
                                </div>
                                <div class="flex-1 w-full">
                                    <input type="file" name="app_logo"
                                        accept="image/png, image/jpeg, image/svg+xml, image/x-icon"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition">
                                    <p class="mt-1 text-xs text-gray-500">PNG, JPG, SVG maksimal 2MB. Resolusi transparan
                                        disarankan.</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Favicon (Ikon Tab Browser)</label>
                            <div class="flex items-start space-x-4">
                                <div class="shrink-0">
                                    <img src="{{ $setting->favicon_url }}" alt="Favicon"
                                        class="h-10 w-10 object-contain border border-gray-200 rounded p-1 bg-white">
                                </div>
                                <div class="flex-1 w-full">
                                    <input type="file" name="favicon"
                                        accept="image/png, image/x-icon, image/jpeg, image/svg+xml"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 transition">
                                    <p class="mt-1 text-xs text-gray-500">Format .ico atau .png 1:1 maksimal 1MB.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-xl border border-gray-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="text-lg font-semibold text-gray-900">Kontak Resmi Sekolah</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Telepon / WhatsApp</label>
                            <input type="text" name="school_phone"
                                value="{{ old('school_phone', $setting->school_phone) }}"
                                class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Resmi</label>
                            <input type="email" name="school_email"
                                value="{{ old('school_email', $setting->school_email) }}"
                                class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                            <textarea name="school_address" rows="3"
                                class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3">{{ old('school_address', $setting->school_address) }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="bg-white shadow-sm sm:rounded-xl border border-gray-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="text-lg font-semibold text-gray-900">Sistem Operasional Akademik</h3>
                    </div>
                    <div class="p-6">
                        <div
                            class="flex items-center justify-between bg-indigo-50/50 p-4 rounded-lg border border-indigo-100">
                            <div>
                                <h4 class="text-sm font-bold text-gray-900">Buka Portal Kenaikan Kelas</h4>
                                <p class="text-sm text-gray-600 mt-1 max-w-2xl">
                                    Aktifkan fitur ini hanya di akhir semester Genap. Saat aktif, Wali Kelas akan dapat
                                    mengakses menu "Kenaikan Kelas" di dashboard mereka untuk memproses mutasi siswa secara
                                    massal ke tahun ajaran berikutnya.
                                </p>
                            </div>

                            <label class="relative inline-flex items-center cursor-pointer shrink-0 ml-4">
                                <input type="checkbox" name="is_promotion_open" value="1" class="sr-only peer"
                                    {{ $setting->is_promotion_open ? 'checked' : '' }}>
                                <div
                                    class="w-14 h-7 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-indigo-600">
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white shadow-sm sm:rounded-xl border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="text-lg font-semibold text-gray-900">Link Sosial Media</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Instagram URL</label>
                                <input type="url" name="instagram_link"
                                    value="{{ old('instagram_link', $setting->instagram_link) }}"
                                    placeholder="https://instagram.com/..."
                                    class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Facebook URL</label>
                                <input type="url" name="facebook_link"
                                    value="{{ old('facebook_link', $setting->facebook_link) }}"
                                    placeholder="https://facebook.com/..."
                                    class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">YouTube URL</label>
                                <input type="url" name="youtube_link"
                                    value="{{ old('youtube_link', $setting->youtube_link) }}"
                                    placeholder="https://youtube.com/..."
                                    class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3">
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow-sm sm:rounded-xl border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="text-lg font-semibold text-gray-900">SEO (Mesin Pencari)</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Meta Title</label>
                                <input type="text" name="meta_title"
                                    value="{{ old('meta_title', $setting->meta_title) }}"
                                    placeholder="Sistem Informasi Akademik Terbaik"
                                    class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
                                <textarea name="meta_description" rows="3"
                                    class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3">{{ old('meta_description', $setting->meta_description) }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Meta Keywords</label>
                                <input type="text" name="meta_keywords"
                                    value="{{ old('meta_keywords', $setting->meta_keywords) }}"
                                    placeholder="sekolah, erp, sman 1"
                                    class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3">
                                <p class="mt-1 text-xs text-gray-500">Pisahkan dengan koma.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-8 border-t border-gray-200 pt-6">
                    <button type="submit"
                        class="inline-flex justify-center items-center py-2.5 px-8 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                            </path>
                        </svg>
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection
