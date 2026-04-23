@extends('partials.app')
@section('title', 'Atur Rentang Tanggal Semester')

@section('content')
    <main class="flex-1 pb-12 pt-8 relative">
        <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-indigo-50/50 to-transparent -z-10 pointer-events-none"></div>

        <div class="mx-auto max-w-12xl px-4 sm:px-6 lg:px-8 w-full">
            <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Atur Rentang Tanggal</h2>
                    <p class="text-sm text-gray-500 mt-1">Tentukan kapan semester ini dimulai dan berakhir untuk keperluan otomasi KBM.</p>
                </div>
                <a href="{{ route('admin.academic-years.index') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900 bg-white px-4 py-2 rounded-md border border-gray-200 shadow-sm transition">
                    &larr; Kembali
                </a>
            </div>

            <form action="{{ route('admin.academic-years.update', $academicYear->id) }}" method="POST" class="bg-white shadow-sm sm:rounded-xl border border-gray-200 overflow-hidden">
                @csrf
                @method('PUT')
                
                <div class="p-6 sm:p-10 space-y-8">
                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-600 px-5 py-4 rounded-lg text-sm">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <h4 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-2 mb-4">Informasi Semester (Terkunci)</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Periode</label>
                                <input type="text" value="{{ $academicYear->period }}" disabled class="block w-full rounded-md border border-gray-200 bg-gray-100 text-gray-500 shadow-sm text-sm py-2.5 px-3 cursor-not-allowed">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Semester</label>
                                <input type="text" value="{{ $academicYear->semester }}" disabled class="block w-full rounded-md border border-gray-200 bg-gray-100 text-gray-500 shadow-sm text-sm py-2.5 px-3 cursor-not-allowed">
                            </div>
                        </div>
                        <p class="mt-2 text-xs text-amber-600 italic">*Periode dan Semester tidak dapat diubah untuk menjaga integritas data akademik dan nilai siswa.</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-2 mb-4">Pengaturan Tanggal Aktif</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                                <input type="date" name="start_date" value="{{ old('start_date', $academicYear->start_date) }}" class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5 px-3 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Berakhir</label>
                                <input type="date" name="end_date" value="{{ old('end_date', $academicYear->end_date) }}" class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5 px-3 transition">
                            </div>
                        </div>
                    </div>

                </div>
                
                <div class="bg-gray-50 px-6 py-5 sm:px-10 flex justify-end border-t border-gray-200">
                    <button type="submit" class="inline-flex justify-center py-2.5 px-8 border border-transparent shadow-sm text-sm font-bold rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Simpan Tanggal
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection