@extends('partials.app')
@section('title', 'Tambah Tahun Akademik')

@section('content')
    <main class="flex-1 pb-12 pt-8 relative">
        <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-indigo-50/50 to-transparent -z-10 pointer-events-none"></div>

        <div class="mx-auto max-w-8xl px-4 sm:px-6 lg:px-8 w-full">
            <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Tambah Tahun Akademik</h2>
                    <p class="text-sm text-gray-500 mt-1">Sistem akan otomatis membuat dua semester (Ganjil & Genap) untuk periode yang Anda masukkan.</p>
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

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Periode Tahun Akademik <span class="text-red-500">*</span></label>
                        <input type="text" name="period" value="{{ old('period') }}" required placeholder="Contoh: 2024/2025" pattern="\d{4}/\d{4}" title="Format harus YYYY/YYYY (contoh: 2024/2025)" class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-2.5 px-3 transition">
                        <p class="mt-2 text-sm text-gray-500">Pastikan format sesuai dengan kalender akademik resmi (YYYY/YYYY).</p>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-6 py-5 sm:px-10 flex justify-end border-t border-gray-200">
                    <button type="submit" class="inline-flex justify-center py-2.5 px-8 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Generate Semester Baru
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection