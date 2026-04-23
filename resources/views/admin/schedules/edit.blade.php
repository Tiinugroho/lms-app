@extends('partials.app')
@section('title', 'Edit Jadwal Pelajaran')

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
            <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Edit Jadwal Pelajaran</h2>
                </div>
                <a href="{{ route('admin.schedules.index') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900 bg-white px-4 py-2 rounded-md border border-gray-200 shadow-sm transition">
                    &larr; Kembali
                </a>
            </div>

            @error('clash')
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-md shadow-sm flex items-start animate-bounce-short">
                    <svg class="h-6 w-6 text-red-500 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    <div>
                        <h3 class="text-sm font-bold text-red-800">Gagal Memperbarui! Terdeteksi Tabrakan Jadwal</h3>
                        <p class="text-sm font-medium text-red-700 mt-1">{{ $message }}</p>
                    </div>
                </div>
            @enderror

            @if ($errors->any() && !$errors->has('clash'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-5 py-4 rounded-lg text-sm">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.schedules.update', $schedule->id) }}" method="POST" class="bg-white shadow-sm sm:rounded-xl border border-gray-200 overflow-hidden">
                @csrf
                @method('PUT')
                
                <div class="p-6 sm:p-10 space-y-8">
                    
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 flex items-center justify-between opacity-70">
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Tahun Ajaran (Tidak Dapat Diubah)</p>
                            <p class="text-base font-bold text-gray-900 mt-0.5">{{ $schedule->academicYear->period }} - Semester {{ $schedule->academicYear->semester }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-12 gap-6">
                        
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Ruang Kelas <span class="text-red-500">*</span></label>
                            <select name="classroom_id" required class="select2-search block w-full">
                                @foreach($classrooms as $classroom)
                                    <option value="{{ $classroom->id }}" {{ old('classroom_id', $schedule->classroom_id) == $classroom->id ? 'selected' : '' }}>
                                        Tingkat {{ $classroom->level }} - {{ $classroom->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Mata Pelajaran <span class="text-red-500">*</span></label>
                            <select name="subject_id" required class="select2-search block w-full">
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ old('subject_id', $schedule->subject_id) == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->code }} - {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Guru Pengajar <span class="text-red-500">*</span></label>
                            <select name="teacher_id" required class="select2-search block w-full">
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ old('teacher_id', $schedule->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Hari <span class="text-red-500">*</span></label>
                            <select name="day_of_week" required class="select2-search block w-full">
                                @foreach($days as $day)
                                    <option value="{{ $day }}" {{ old('day_of_week', $schedule->day_of_week) == $day ? 'selected' : '' }}>{{ $day }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-12 md:col-span-3">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Mulai <span class="text-red-500">*</span></label>
                            <input type="time" name="start_time" value="{{ old('start_time', \Carbon\Carbon::parse($schedule->start_time)->format('H:i')) }}" required class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-2.5 px-3">
                        </div>

                        <div class="col-span-12 md:col-span-3">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Selesai <span class="text-red-500">*</span></label>
                            <input type="time" name="end_time" value="{{ old('end_time', \Carbon\Carbon::parse($schedule->end_time)->format('H:i')) }}" required class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-2.5 px-3">
                        </div>

                    </div>
                </div>
                
                <div class="bg-gray-50 px-6 py-5 sm:px-10 flex justify-end border-t border-gray-200">
                    <button type="submit" class="w-full sm:w-auto inline-flex justify-center py-2.5 px-8 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Perbarui Jadwal
                    </button>
                </div>
            </form>
        </div>
    </main>

    <style>
        .animate-bounce-short { animation: bounce-short 1s ease-in-out 2; }
        @keyframes bounce-short { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
    </style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2-search').select2({ width: '100%' });
    });
</script>
@endpush