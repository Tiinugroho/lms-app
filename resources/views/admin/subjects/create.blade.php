@extends('partials.app')
@section('title', 'Tambah Mata Pelajaran')

@section('content')
    <main class="flex-1 pb-12 pt-8 relative">
        <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-indigo-50/50 to-transparent -z-10 pointer-events-none"></div>

        <div class="mx-auto max-w-8xl px-4 sm:px-6 lg:px-8 w-full">
            <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Tambah Mata Pelajaran</h2>
                    <p class="text-sm text-gray-500 mt-1">Lengkapi formulir di bawah untuk menambahkan mata pelajaran baru.</p>
                </div>
                <a href="{{ route('admin.subjects.index') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900 bg-white px-4 py-2 rounded-md border border-gray-200 shadow-sm transition">
                    &larr; Kembali
                </a>
            </div>

            <form action="{{ route('admin.subjects.store') }}" method="POST" class="bg-white shadow-sm sm:rounded-xl border border-gray-200 overflow-hidden">
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

                    <h3 class="text-xl font-semibold text-gray-900 mb-6 border-b border-gray-100 pb-3">Informasi Mata Pelajaran</h3>
                    
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 md:col-span-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kode Mapel <span class="text-red-500">*</span></label>
                            <input type="text" name="code" value="{{ old('code') }}" required placeholder="Contoh: MTK" class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-2.5 px-3 transition">
                        </div>
                        <div class="col-span-12 md:col-span-8">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Mata Pelajaran <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Matematika Lanjut" class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-2.5 px-3 transition">
                        </div>
                        <div class="col-span-12">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi (Opsional)</label>
                            <textarea name="description" rows="4" placeholder="Penjelasan singkat mengenai mata pelajaran ini..." class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-2.5 px-3 transition">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-6 py-5 sm:px-10 flex justify-end border-t border-gray-200">
                    <button type="submit" class="inline-flex justify-center py-2.5 px-8 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Simpan Mata Pelajaran
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection