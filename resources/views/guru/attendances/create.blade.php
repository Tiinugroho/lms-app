@extends('partials.app')
@section('title', 'Isi Absensi - ' . $schedule->classroom->name)

@section('content')
<main class="flex-1 pb-12 pt-8 relative w-full">
    <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-indigo-50/50 to-transparent -z-10 pointer-events-none"></div>

    <div class="mx-auto max-w-[90rem] px-4 sm:px-6 lg:px-8 w-full">
        
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900">Jurnal & Absensi Harian</h2>
            <a href="{{ route('guru.attendances.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 bg-white px-4 py-2 rounded-md border border-gray-200 shadow-sm">&larr; Kembali</a>
        </div>

        <form action="{{ route('guru.attendances.store', $schedule->id) }}" method="POST" class="flex flex-col lg:flex-row gap-6">
            @csrf
            
            <div class="w-full lg:w-4/12 flex flex-col gap-6">
                <div class="bg-indigo-600 rounded-2xl shadow-lg p-6 text-white overflow-hidden relative">
                    <div class="absolute -right-6 -top-6 opacity-10">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                    </div>
                    <div class="relative z-10">
                        <span class="inline-block px-3 py-1 bg-white/20 rounded-full text-xs font-bold backdrop-blur-sm mb-4">
                            Semester {{ $activeYear->semester }}
                        </span>
                        <h3 class="text-3xl font-extrabold mb-1">{{ $schedule->classroom->name }}</h3>
                        <p class="text-indigo-100 font-medium mb-6">{{ $schedule->subject->name }}</p>
                        
                        <div class="flex items-center gap-4 text-sm font-medium border-t border-white/20 pt-4">
                            <div class="flex items-center gap-1.5"><svg class="w-4 h-4 text-indigo-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> {{ $schedule->day_of_week }}</div>
                            <div class="flex items-center gap-1.5"><svg class="w-4 h-4 text-indigo-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} WIB</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <h4 class="text-lg font-bold text-gray-900 mb-5 border-b border-gray-100 pb-3">Isi Jurnal Mengajar</h4>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Tanggal Pertemuan</label>
                            <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Pertemuan Ke-</label>
                            <input type="number" name="meeting_number" value="{{ $nextMeeting }}" required min="1" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Topik / Materi Pembelajaran</label>
                            <textarea name="topic" rows="3" required placeholder="Contoh: Menjelaskan Bab 3 tentang Aljabar..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-md transition transform hover:-translate-y-0.5 flex justify-center items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                    Simpan Jurnal & Absensi
                </button>
            </div>

            <div class="w-full lg:w-8/12 bg-white rounded-2xl shadow-sm border border-gray-200 flex flex-col h-[800px]">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 rounded-t-2xl shrink-0">
                    <div>
                        <h4 class="text-lg font-bold text-gray-900">Daftar Kehadiran Siswa</h4>
                        <p class="text-xs text-gray-500">Pilih status kehadiran untuk masing-masing siswa.</p>
                    </div>
                    <span class="bg-indigo-100 text-indigo-800 py-1 px-3 rounded-full text-xs font-bold">{{ $students->count() }} Siswa</span>
                </div>

                <div class="flex-1 overflow-y-auto p-4 space-y-3">
                    @foreach($students as $index => $row)
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 bg-white border border-gray-200 rounded-xl hover:border-indigo-300 transition shadow-sm gap-4">
                        
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-bold text-gray-400 w-6 text-center">{{ $loop->iteration }}</span>
                            <img src="{{ $row->student->user->avatar_url }}" class="w-10 h-10 rounded-full object-cover border border-gray-200 shrink-0">
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ $row->student->user->name }}</p>
                                <p class="text-xs text-gray-500">NIS: {{ $row->student->nis }} | {{ $row->student->gender }}</p>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-2 pl-9 sm:pl-0">
                            
                            <label class="cursor-pointer">
                                <input type="radio" name="attendance[{{ $row->student_id }}]" value="Hadir" class="peer sr-only" checked>
                                <div class="px-3 py-1.5 rounded-lg text-xs font-bold border border-gray-200 text-gray-600 peer-checked:bg-emerald-500 peer-checked:text-white peer-checked:border-emerald-600 transition hover:bg-gray-50">
                                    Hadir
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" name="attendance[{{ $row->student_id }}]" value="Sakit" class="peer sr-only">
                                <div class="px-3 py-1.5 rounded-lg text-xs font-bold border border-gray-200 text-gray-600 peer-checked:bg-yellow-400 peer-checked:text-white peer-checked:border-yellow-500 transition hover:bg-gray-50">
                                    Sakit
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" name="attendance[{{ $row->student_id }}]" value="Izin" class="peer sr-only">
                                <div class="px-3 py-1.5 rounded-lg text-xs font-bold border border-gray-200 text-gray-600 peer-checked:bg-blue-500 peer-checked:text-white peer-checked:border-blue-600 transition hover:bg-gray-50">
                                    Izin
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" name="attendance[{{ $row->student_id }}]" value="Alpa" class="peer sr-only">
                                <div class="px-3 py-1.5 rounded-lg text-xs font-bold border border-gray-200 text-gray-600 peer-checked:bg-red-500 peer-checked:text-white peer-checked:border-red-600 transition hover:bg-gray-50">
                                    Alpa
                                </div>
                            </label>

                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
        </form>
    </div>
</main>
@endsection