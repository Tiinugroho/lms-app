@extends('partials.app')
@section('title', 'Kenaikan Kelas Massal')

@section('content')
<main class="flex-1 pb-12 pt-8 relative w-full">
    <div class="absolute top-0 left-0 w-full h-80 bg-gradient-to-b from-indigo-600 to-indigo-800 -z-10 rounded-b-[3rem]"></div>

    <div class="mx-auto max-w-12xl px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-md border border-white/30 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-white uppercase tracking-tight">Kenaikan Kelas</h2>
                    <p class="text-indigo-100 text-sm">Proses mutasi siswa massal ke tahun ajaran baru.</p>
                </div>
            </div>
        </div>

        @if(!$isPromotionOpen || !$activeYear || !$previousYear)
            <div class="bg-white rounded-3xl p-12 text-center shadow-xl border border-gray-100 mt-4">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-amber-50 mb-6">
                    <svg class="w-12 h-12 text-amber-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-gray-900">Portal Masih Tertutup</h3>
                <p class="text-gray-500 mt-3 max-w-lg mx-auto leading-relaxed">
                    Akses kenaikan kelas belum dibuka oleh Admin Sekolah. Silakan hubungi bagian Kurikulum atau Tata Usaha untuk informasi lebih lanjut.
                </p>
            </div>
        @elseif(!$myClass)
            <div class="bg-white rounded-3xl p-12 text-center shadow-xl border border-gray-100 mt-4">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-blue-50 mb-6">
                    <svg class="w-12 h-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-gray-900">Akses Dibatasi</h3>
                <p class="text-gray-500 mt-3 max-w-lg mx-auto">Hanya Guru yang terdaftar sebagai <strong>Wali Kelas</strong> yang dapat memproses kenaikan kelas siswa.</p>
            </div>
        @else
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm flex items-center">
                    <svg class="h-6 w-6 text-emerald-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <p class="font-bold text-emerald-900">{{ session('success') }}</p>
                </div>
            @endif

            <form action="{{ route('guru.promotions.store') }}" method="POST" class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden transition-all duration-300">
                @csrf
                @if($isGraduating) <input type="hidden" name="is_graduating" value="1"> @endif

                <div class="bg-gray-50/80 border-b border-gray-100 p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-8">
                    <div class="space-y-1">
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-500">Kelas Asal ({{ $previousYear->period }})</span>
                        <h3 class="text-3xl font-black text-gray-900 italic">{{ $myClass->name }}</h3>
                        <p class="text-sm text-gray-500">Kapasitas: <span class="font-bold text-gray-900">{{ $students->count() }} Siswa</span></p>
                    </div>

                    <div class="w-full md:w-2/5">
                        @if($isGraduating)
                            <div class="bg-emerald-100 border-2 border-emerald-200 p-4 rounded-2xl flex items-center gap-4">
                                <div class="bg-emerald-500 p-2 rounded-lg text-white shadow-lg shadow-emerald-200">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                </div>
                                <div>
                                    <h4 class="font-black text-emerald-800 uppercase text-xs">Target Kelulusan</h4>
                                    <p class="text-[11px] text-emerald-600 font-medium">Siswa terpilih akan berstatus Alumni/Lulus.</p>
                                </div>
                            </div>
                        @else
                            <label class="block text-[10px] font-black text-indigo-600 uppercase tracking-widest mb-2 ml-1">Pilih Kelas Tujuan ({{ $activeYear->period }})</label>
                            <select name="target_classroom_id" required class="w-full rounded-2xl border-gray-200 bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-bold py-3.5 px-5 transition-all text-sm">
                                <option value="">-- Pilih Kelas Target --</option>
                                @foreach($targetClassrooms as $target)
                                    <option value="{{ $target->id }}">{{ $target->name }} (Tingkat {{ $target->level }})</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div>

                <div class="p-8">
                    <div class="mb-6 flex justify-between items-center bg-indigo-50/50 p-4 rounded-2xl border border-indigo-100">
                        <div>
                            <h4 class="font-black text-indigo-900 italic">Validasi Daftar Siswa</h4>
                            <p class="text-xs text-indigo-600">Daftar siswa yang akan dinaikkan tingkatnya.</p>
                        </div>
                    </div>

                    <div class="overflow-hidden rounded-2xl border border-gray-100">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100">
                                    <th class="px-6 py-4 w-20 text-center">
                                        <input type="checkbox" id="checkAll" checked class="w-5 h-5 text-indigo-600 rounded-lg border-gray-300 focus:ring-indigo-500 transition cursor-pointer">
                                    </th>
                                    <th class="px-6 py-4 text-xs font-black uppercase text-gray-400">Identitas Siswa</th>
                                    <th class="px-6 py-4 text-xs font-black uppercase text-gray-400">NISN</th>
                                    <th class="px-6 py-4 text-xs font-black uppercase text-gray-400 text-center">L/P</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 bg-white">
                                @forelse($students as $history)
                                    @php
                                        $isProcessed = \App\Models\ClassHistory::where('student_id', $history->student_id)->where('academic_year_id', $activeYear->id)->exists();
                                    @endphp
                                    <tr class="hover:bg-indigo-50/30 transition group {{ $isProcessed ? 'bg-emerald-50/20' : '' }}">
                                        <td class="px-6 py-5 text-center">
                                            <input type="checkbox" name="promoted_student_ids[]" value="{{ $history->student_id }}" 
                                                {{ $isProcessed ? 'disabled' : 'checked' }} 
                                                class="student-checkbox w-6 h-6 text-indigo-600 rounded-lg border-gray-300 focus:ring-indigo-500 transition cursor-pointer disabled:opacity-30">
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-4">
                                                <img src="{{ $history->student->user->avatar_url }}" class="w-11 h-11 rounded-xl object-cover border-2 border-white shadow-sm">
                                                <div>
                                                    <p class="text-sm font-black text-gray-900">{{ $history->student->user->name }}</p>
                                                    @if($isProcessed)
                                                        <span class="flex items-center gap-1 text-[10px] font-black text-emerald-600 mt-1 uppercase">
                                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                                            Tersimpan
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 text-sm font-bold text-gray-500">{{ $history->student->nisn ?? '-' }}</td>
                                        <td class="px-6 py-5 text-sm font-black text-gray-400 text-center">{{ $history->student->gender }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-20 text-center text-gray-400 font-bold italic">Data siswa tahun lalu tidak ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-indigo-900 px-8 py-6 flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-indigo-200 text-xs font-medium max-w-md">
                        <strong>Perhatian:</strong> Pastikan seluruh nilai raport sudah tuntas sebelum memproses. Siswa yang tidak dicentang akan otomatis tinggal kelas.
                    </p>
                    <button type="submit" onclick="return confirm('Proses kenaikan kelas tidak dapat dibatalkan secara massal. Lanjutkan?');" class="w-full md:w-auto bg-white text-indigo-900 hover:bg-indigo-50 font-black py-4 px-10 rounded-2xl shadow-xl transition-all transform hover:scale-105 active:scale-95 flex items-center justify-center gap-3 text-sm uppercase tracking-widest">
                        Eksekusi Kenaikan
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4" /></svg>
                    </button>
                </div>
            </form>
        @endif
    </div>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Logika Check All
        $('#checkAll').on('change', function() {
            $('.student-checkbox:not(:disabled)').prop('checked', $(this).prop('checked'));
        });
        
        $('.student-checkbox').on('change', function() {
            if ($('.student-checkbox:not(:disabled):checked').length === $('.student-checkbox:not(:disabled)').length) {
                $('#checkAll').prop('checked', true);
            } else {
                $('#checkAll').prop('checked', false);
            }
        });
    });
</script>
@endpush