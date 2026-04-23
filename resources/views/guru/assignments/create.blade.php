@extends('partials.app')
@section('title', 'Buat Tugas & Ujian Baru')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container .select2-selection--single { height: 44px !important; border: 1px solid #d1d5db !important; border-radius: 0.375rem !important; display: flex; align-items: center; padding-left: 0.25rem; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important; }
    .select2-container--default .select2-selection--single .select2-selection__arrow { height: 42px !important; right: 8px !important; }
    .select2-container--default .select2-selection--single .select2-selection__rendered { color: #374151 !important; font-size: 1rem !important; }
    .select2-container--default.select2-container--focus .select2-selection--single { border-color: #6366f1 !important; box-shadow: 0 0 0 1px #6366f1 !important; }
</style>
@endpush

@section('content')
<main class="flex-1 pb-12 pt-8 relative w-full">
    <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-indigo-50/50 to-transparent -z-10 pointer-events-none"></div>

    <div class="mx-auto max-w-12xl px-4 sm:px-6 lg:px-8 w-full">
        
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900">Terbitkan Evaluasi Pembelajaran</h2>
            <a href="{{ route('guru.assignments.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 bg-white px-4 py-2 rounded-md border border-gray-200 shadow-sm">&larr; Kembali</a>
        </div>

        <form action="{{ route('guru.assignments.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-sm sm:rounded-2xl border border-gray-200 overflow-hidden">
            @csrf
            
            <div class="p-6 sm:p-10 space-y-6">
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="col-span-1 sm:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tujuan Kelas & Mata Pelajaran <span class="text-red-500">*</span></label>
                        <select name="classroom_subject" required class="select2-search block w-full">
                            <option value="" disabled selected>-- Pilih dari Jadwal Mengajar Anda --</option>
                            @foreach($teachingClasses as $schedule)
                                <option value="{{ $schedule->classroom_id }}|{{ $schedule->subject_id }}">
                                    {{ $schedule->classroom->name }} - {{ $schedule->subject->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-1 sm:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Tugas / Evaluasi <span class="text-red-500">*</span></label>
                        <input type="text" name="title" required placeholder="Contoh: Latihan Soal Bab 1, Kuis Prakarya..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5 px-3 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe Penilaian <span class="text-red-500">*</span></label>
                        <select name="type" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5 px-3 text-sm bg-white">
                            <option value="" disabled selected>-- Pilih Tipe --</option>
                            @foreach($types as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tenggat Waktu (Deadline) <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="due_date" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5 px-3 text-sm">
                        <p class="text-[11px] text-gray-500 mt-1">Setelah melewati waktu ini, tugas dianggap ditutup/terlambat.</p>
                    </div>
                </div>

                <hr class="border-gray-100">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Instruksi Soal / Tugas</label>
                    <textarea name="description" rows="4" placeholder="Ketikkan soal langsung di sini, atau berikan instruksi agar siswa mendownload file lampiran di bawah..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5 px-3 text-sm"></textarea>
                </div>

                <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 border-dashed">
                    <label class="block text-sm font-bold text-gray-800 mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                        Lampiran File Soal (Opsional)
                    </label>
                    <p class="text-xs text-gray-500 mb-3 leading-relaxed">Gunakan fitur ini jika soal terlalu panjang, atau jika tugas berupa pengerjaan dari dokumen eksternal.</p>
                    <input type="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx,.zip" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer">
                    <p class="text-[10px] text-gray-400 mt-2">Maks 10MB. Format didukung: PDF, DOC, PPT, ZIP.</p>
                </div>

            </div>
            
            <div class="bg-gray-50 px-6 py-5 flex justify-end border-t border-gray-200 gap-3">
                <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center py-2.5 px-8 border border-transparent shadow-sm text-sm font-bold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition">
                    Terbitkan Tugas Sekarang
                </button>
            </div>
        </form>

    </div>
</main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2-search').select2({ width: '100%' });
    });
</script>
@endpush