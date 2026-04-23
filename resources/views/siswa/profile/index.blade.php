@extends('partials.app')
@section('title', 'Profil Siswa')

@section('content')
    <main class="flex-1 pb-12 pt-8 relative w-full">
        <div class="absolute top-0 left-0 w-full h-80 bg-gradient-to-br from-blue-600 to-indigo-800 -z-10 rounded-b-[3rem]">
        </div>

        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 w-full">
            <div class="mb-8 flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-md">
                    <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4.26 10.147L12 14.63l7.74-4.483m-15.48 0L12 5.667l7.74 4.48m-15.48 0v6.331c0 .634.317 1.223.844 1.58L12 21.333l6.896-4.756c.527-.357.844-.946.844-1.58V10.147" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-white uppercase tracking-tight">Profil Siswa</h2>
                    <p class="text-blue-100 text-sm">Kelola data diri dan keamanan akun belajar Anda.</p>
                </div>
            </div>

            <form action="{{ route('siswa.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="flex flex-col lg:flex-row gap-8">
                    <div class="w-full lg:w-1/3 space-y-6">
                        <div
                            class="bg-white rounded-3xl shadow-xl shadow-blue-100/50 border border-gray-100 overflow-hidden sticky top-24">
                            <div class="p-8 text-center border-b border-gray-50">
                                <div class="relative inline-block group mb-6">
                                    <img id="avatar_preview"
                                        src="{{ $user->avatar ? Storage::url($user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=EEF2FF&color=4338CA&size=128' }}"
                                        class="h-32 w-32 rounded-3xl object-cover border-4 border-indigo-50 shadow-inner group-hover:scale-105 transition duration-500">
                                </div>

                                <div class="mt-2 px-2">
                                    <label
                                        class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Ganti
                                        Foto Profil</label>
                                    <div class="relative group">
                                        <input type="file" name="avatar" id="avatar_input" class="hidden">
                                        <label for="avatar_input"
                                            class="flex items-center justify-center gap-2 py-2.5 px-4 bg-blue-50 text-blue-600 rounded-xl text-[10px] font-black uppercase tracking-wider cursor-pointer hover:bg-blue-600 hover:text-white transition-all duration-300 border border-blue-100 border-dashed">
                                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                            </svg>
                                            Pilih Foto
                                        </label>
                                    </div>
                                    <p class="text-[9px] text-gray-400 mt-2 italic">*Maksimal 2MB (JPG, PNG)</p>
                                </div>

                                <h3 class="mt-6 text-xl font-black text-gray-900 leading-tight">{{ $user->name }}</h3>
                                <p class="text-blue-600 font-bold text-xs uppercase tracking-widest mt-1">Siswa Aktif</p>
                            </div>

                            <div class="p-8 space-y-5 bg-gray-50/30">
                                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">NIS
                                        Nasional (NISN)</span>
                                    <span class="text-sm font-bold text-gray-800">{{ $user->student->nisn ?? '-' }}</span>
                                </div>
                                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">NIS
                                        Sekolah</span>
                                    <span class="text-sm font-bold text-gray-800">{{ $user->student->nis ?? '-' }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">Jenis
                                        Kelamin</span>
                                    <span
                                        class="text-sm font-bold text-gray-800">{{ ($user->student->gender ?? '') == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
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
                                    NIS dan NISN dikunci sistem. Hubungi **Wali Kelas** atau **Tata Usaha** jika terdapat
                                    kesalahan data identitas.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="w-full lg:w-2/3">
                        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                            <div class="p-8 sm:p-10 space-y-12">

                                <div>
                                    <h4
                                        class="text-base font-black text-gray-900 border-b-2 border-blue-50 pb-4 mb-8 flex items-center gap-2">
                                        Biodata Siswa
                                    </h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                                        <div class="sm:col-span-2">
                                            <label
                                                class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Nama
                                                Lengkap</label>
                                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                                required
                                                class="w-full rounded-xl border-gray-200 bg-gray-50/50 py-3 px-4 focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300">
                                        </div>
                                        <div>
                                            <label
                                                class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Alamat
                                                Email</label>
                                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                                required
                                                class="w-full rounded-xl border-gray-200 bg-gray-50/50 py-3 px-4 focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300">
                                        </div>
                                        <div>
                                            <label
                                                class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Nomor
                                                WhatsApp/HP</label>
                                            <input type="text" name="phone_number"
                                                value="{{ old('phone_number', $user->student->phone_number ?? '') }}"
                                                class="w-full rounded-xl border-gray-200 bg-gray-50/50 py-3 px-4 focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300">
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label
                                                class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Alamat
                                                Domisili</label>
                                            <textarea name="address" rows="3"
                                                class="w-full rounded-xl border-gray-200 bg-gray-50/50 py-3 px-4 focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300">{{ old('address', $user->student->address ?? '') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-4">
                                    <h4 class="text-base font-black text-gray-900 mb-8">Ganti Password</h4>
                                    <div class="bg-gray-50/80 rounded-3xl p-8 border border-gray-100 space-y-8">
                                        <div>
                                            <label
                                                class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Password
                                                Saat Ini</label>
                                            <input type="password" name="current_password" placeholder="••••••••"
                                                class="w-full rounded-xl border-gray-200 py-3 px-4 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-sm transition-all duration-300 bg-white">
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                                            <div>
                                                <label
                                                    class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Password
                                                    Baru</label>
                                                <input type="password" name="new_password"
                                                    class="w-full rounded-xl border-gray-200 py-3 px-4 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-sm transition-all duration-300 bg-white">
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Konfirmasi
                                                    Password</label>
                                                <input type="password" name="new_password_confirmation"
                                                    class="w-full rounded-xl border-gray-200 py-3 px-4 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-sm transition-all duration-300 bg-white">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50/80 px-10 py-8 border-t border-gray-100 flex justify-end">
                                <button type="submit"
                                    class="group bg-blue-600 hover:bg-blue-700 text-white font-black text-xs uppercase tracking-[0.2em] py-4 px-12 rounded-2xl transition shadow-xl shadow-blue-200 hover:shadow-blue-300 active:scale-95 duration-300 flex items-center gap-3">
                                    <svg class="w-4 h-4 text-white group-hover:rotate-12 transition-transform"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Simpan Data Profil
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
