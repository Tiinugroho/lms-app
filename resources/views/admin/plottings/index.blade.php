@extends('partials.app')
@section('title', 'Pilih Kelas - Plotting Siswa')

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

        <div class="mx-auto max-w-12xl px-4 sm:px-6 lg:px-8 w-full mt-10">
            
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 mb-4 shadow-inner">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Plotting Ruang Kelas</h2>
                <p class="text-base text-gray-500 mt-2 max-w-xl mx-auto">Silakan pilih Tahun Ajaran dan Kelas yang ingin Anda kelola data siswanya.</p>
            </div>

            <form action="{{ route('admin.plottings.index') }}" method="GET" class="bg-white shadow-sm sm:rounded-2xl border border-gray-200 overflow-hidden">
                <div class="p-6 sm:p-10">
                    
                    <div class="mb-8">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Ajaran <span class="text-red-500">*</span></label>
                        <select name="academic_year_id" required class="select2-search block w-full">
                            <option value="" disabled {{ !$activeYear ? 'selected' : '' }}>-- Pilih Tahun Ajaran --</option>
                            @foreach($academicYears as $year)
                                <option value="{{ $year->id }}" {{ ($activeYear && $activeYear->id == $year->id) ? 'selected' : '' }}>
                                    {{ $year->period }} - Semester {{ $year->semester }} 
                                    {!! $year->is_active ? '(Aktif Saat Ini)' : '' !!}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-2 text-xs text-gray-500">Secara default sistem memilih tahun ajaran yang sedang aktif.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Ruang Kelas <span class="text-red-500">*</span></label>
                        <select name="classroom_id" required class="select2-search block w-full">
                            <option value="" disabled selected>-- Pilih Ruang Kelas Tujuan --</option>
                            @foreach($classrooms as $classroom)
                                <option value="{{ $classroom->id }}">
                                    Tingkat {{ $classroom->level }} - {{ $classroom->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
                
                <div class="bg-gray-50 px-6 py-5 sm:px-10 flex justify-end border-t border-gray-200">
                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center py-2.5 px-8 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Lanjutkan Pengaturan Kelas &rarr;
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