@extends('partials.app')
@section('title', 'Tambah Tahun Akademik')

@section('content')
    <main class="flex-1 pb-12 pt-8 relative">
        <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-indigo-50/50 to-transparent -z-10 pointer-events-none"></div>

        <div class="mx-auto max-w-12xl px-4 sm:px-6 lg:px-8 w-full">
            <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Tambah Tahun Akademik</h2>
                    <p class="text-sm text-gray-500 mt-1">Buat periode kalender akademik baru untuk sistem.</p>
                </div>
                <a href="{{ route('admin.academic-years.index') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900 bg-white px-4 py-2 rounded-md border border-gray-200 shadow-sm transition">
                    &larr; Kembali
                </a>
            </div>

            <form action="{{ route('admin.academic-years.store') }}" method="POST" class="bg-white shadow-sm sm:rounded-xl border border-gray-200 overflow-hidden">
                @csrf
                <div class="p-6 sm:p-10">
                    
                    @if ($errors->any())
                        <div class="mb-8 bg-red-50 border border-red-200 text-red-600 px-5 py-4 rounded-lg text-sm">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="bg-blue-50/80 border border-blue-100 p-5 rounded-2xl mb-8 flex gap-4 items-start shadow-sm">
                        <div class="bg-blue-100 p-2.5 rounded-full shrink-0 mt-0.5">
                            <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-blue-900">Di mana form input tanggalnya?</h4>
                            <p class="text-sm text-blue-800 mt-1.5 leading-relaxed">
                                Sistem akan otomatis men-generate dua data sekaligus (<strong>Semester Ganjil</strong> dan <strong>Semester Genap</strong>) dari periode yang Anda masukkan di bawah. Karena rentang waktu kedua semester tersebut berbeda, Anda baru bisa mengatur <strong>Tanggal Mulai</strong> dan <strong>Tanggal Berakhir</strong> melalui tombol <span class="font-semibold text-indigo-700 underline decoration-indigo-300 underline-offset-2">Edit</span> di halaman utama setelah data ini berhasil disimpan.
                            </p>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Periode Tahun Akademik <span class="text-red-500">*</span></label>
                        <input type="text" name="period" value="{{ old('period') }}" required placeholder="Contoh: 2026/2027" pattern="\d{4}/\d{4}" title="Format harus YYYY/YYYY (contoh: 2026/2027)" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-3 px-4 transition bg-gray-50/50 hover:bg-white">
                        <p class="mt-2 text-xs text-gray-500">Pastikan format sesuai dengan kalender akademik resmi, menggunakan 4 digit tahun dan dipisah garis miring (YYYY/YYYY).</p>
                    </div>

                </div>
                
                <div class="bg-gray-50 px-6 py-5 sm:px-10 flex justify-end border-t border-gray-200">
                    <button type="submit" class="inline-flex justify-center py-2.5 px-8 border border-transparent shadow-sm text-sm font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Generate Semester Baru
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection