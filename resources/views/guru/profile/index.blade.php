@extends('partials.app')
@section('title', 'Profil Saya')

@section('content')
    <main class="flex-1 pb-12 pt-8 relative w-full">
        <div
            class="absolute top-0 left-0 w-full h-80 bg-gradient-to-br from-indigo-600 to-indigo-800 -z-10 rounded-b-[3rem]">
        </div>

        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8 flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-md">
                    <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-white uppercase tracking-tight">Profil Guru</h2>
                    <p class="text-indigo-100 text-sm">Kelola informasi publik dan kredensial akun Anda.</p>
                </div>
            </div>

            <form action="{{ route('guru.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="space-y-6">
                        <div
                            class="bg-white rounded-3xl shadow-xl shadow-indigo-100/50 border border-gray-100 overflow-hidden">
                            <div class="p-8 text-center border-b border-gray-50">
                                <div class="relative inline-block group mb-6">
                                    <img id="avatar_preview"
                                        src="{{ $user->avatar ? Storage::url($user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=EEF2FF&color=4338CA&size=128' }}"
                                        class="h-32 w-32 rounded-3xl object-cover border-4 border-indigo-50 shadow-inner group-hover:scale-105 transition duration-500">
                                </div>

                                <div class="mt-2 px-2">
                                    <label
                                        class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 text-center">Ganti
                                        Foto Profil</label>
                                    <div class="relative group">
                                        <input type="file" name="avatar" id="avatar_input" class="hidden">
                                        <label for="avatar_input"
                                            class="flex items-center justify-center gap-2 py-2.5 px-4 bg-indigo-50 text-indigo-600 rounded-xl text-[10px] font-black uppercase tracking-wider cursor-pointer hover:bg-indigo-600 hover:text-white transition-all duration-300 border border-indigo-100 border-dashed">
                                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                            </svg>
                                            Pilih Foto
                                        </label>
                                    </div>
                                    <p class="text-[9px] text-gray-400 mt-2 italic">*Maksimal 2MB (JPG, PNG)</p>
                                </div>

                                <h3 class="mt-6 text-xl font-black text-gray-900 leading-tight">{{ $user->name }}</h3>
                                <p class="text-indigo-600 font-bold text-xs uppercase tracking-widest mt-1">Tenaga Pengajar
                                </p>
                            </div>

                            <div class="p-8 space-y-5 bg-gray-50/30">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">NIP
                                        (Identitas)</span>
                                    <span class="text-sm font-bold text-gray-800">{{ $user->teacher->nip ?? '-' }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span
                                        class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">NUPTK</span>
                                    <span class="text-sm font-bold text-gray-800">{{ $user->teacher->nuptk ?? '-' }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">NIK</span>
                                    <span class="text-sm font-bold text-gray-800">{{ $user->teacher->nik ?? '-' }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span
                                        class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">Gender</span>
                                    <span
                                        class="text-sm font-bold text-gray-800">{{ $user->teacher->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-amber-50 rounded-2xl p-5 border border-amber-100">
                            <div class="flex gap-3">
                                <svg class="w-5 h-5 text-amber-600 shrink-0" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <p class="text-xs text-amber-800 leading-relaxed font-medium">
                                    Nomor NIP, NUPTK, dan NIK dikunci secara otomatis. Silakan hubungi <strong>Admin
                                        Kurikulum</strong> jika terdapat kekeliruan data.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                            <div class="p-8 sm:p-10 space-y-12">
                                <div>
                                    <h4 class="text-base font-black text-gray-900 border-b-2 border-indigo-50 pb-4 mb-8">
                                        Informasi Personal</h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                                        <div class="sm:col-span-2">
                                            <label
                                                class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Nama
                                                Lengkap & Gelar</label>
                                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                                class="w-full rounded-xl border-gray-200 bg-gray-50/50 py-3 px-4 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-300">
                                        </div>

                                        <div>
                                            <label
                                                class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Alamat
                                                Email</label>
                                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                                class="w-full rounded-xl border-gray-200 bg-gray-50/50 py-3 px-4 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-300">
                                        </div>

                                        <div>
                                            <label
                                                class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Nomor
                                                Telepon/WA</label>
                                            <input type="text" name="phone_number"
                                                value="{{ old('phone_number', $user->teacher->phone_number) }}"
                                                class="w-full rounded-xl border-gray-200 bg-gray-50/50 py-3 px-4 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-300">
                                        </div>

                                        <div class="sm:col-span-2">
                                            <label
                                                class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Alamat
                                                Domisili</label>
                                            <textarea name="address" rows="3"
                                                class="w-full rounded-xl border-gray-200 bg-gray-50/50 py-3 px-4 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-300">{{ old('address', $user->teacher->address) }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-4">
                                    <h4 class="text-base font-black text-gray-900 mb-8">Keamanan Akun</h4>
                                    <div class="bg-gray-50/80 rounded-3xl p-8 border border-gray-100 space-y-8">
                                        <div>
                                            <label
                                                class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Password
                                                Saat Ini</label>
                                            <input type="password" name="current_password" placeholder="••••••••"
                                                class="w-full rounded-xl border-gray-200 py-3 px-4 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 shadow-sm transition-all duration-300 bg-white">
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                                            <div>
                                                <label
                                                    class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Password
                                                    Baru</label>
                                                <input type="password" name="new_password"
                                                    class="w-full rounded-xl border-gray-200 py-3 px-4 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 shadow-sm transition-all duration-300 bg-white">
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Konfirmasi
                                                    Password</label>
                                                <input type="password" name="new_password_confirmation"
                                                    class="w-full rounded-xl border-gray-200 py-3 px-4 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 shadow-sm transition-all duration-300 bg-white">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50/80 px-10 py-8 border-t border-gray-100 flex justify-end">
                                <button type="submit"
                                    class="group bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs uppercase tracking-[0.2em] py-4 px-12 rounded-2xl transition shadow-xl shadow-indigo-200 hover:shadow-indigo-300 active:scale-95 duration-300 flex items-center gap-3">
                                    <svg class="w-4 h-4 text-white group-hover:rotate-12 transition-transform"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('avatar_input');
            const preview = document.getElementById('avatar_preview');

            input.addEventListener('change', function(e) {
                const file = e.target.files[0];

                if (!file) return;

                // Validasi tipe file
                if (!file.type.startsWith('image/')) {
                    alert('File harus berupa gambar!');
                    input.value = '';
                    return;
                }

                // Validasi ukuran (max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran maksimal 2MB!');
                    input.value = '';
                    return;
                }

                // Preview realtime
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };

                reader.readAsDataURL(file);
            });
        });
    </script>
@endpush
