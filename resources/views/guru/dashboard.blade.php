@extends('partials.app')
@section('title', 'Dashboard Guru')

@section('content')
<main class="flex-1 pb-12 pt-8 relative w-full">
    <div class="absolute top-0 left-0 w-full h-[300px] bg-gradient-to-b from-indigo-600 to-indigo-800 -z-10 rounded-b-3xl"></div>

    <div class="mx-auto max-w-12xl px-4 sm:px-6 lg:px-8 w-full">
        
        <div class="mb-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="h-16 w-16 rounded-full bg-white/20 border-2 border-white/40 flex items-center justify-center p-1 overflow-hidden shrink-0">
                    <img src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=E0E7FF&color=4338CA' }}" alt="Profile" class="h-full w-full rounded-full object-cover">
                </div>
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-white">Selamat Datang, {{ auth()->user()->name }}</h2>
                    <p class="text-indigo-100 font-medium text-sm mt-1">
                        @if($activeYear)
                            Tahun Ajaran Aktif: {{ $activeYear->period }} (Semester {{ $activeYear->semester }})
                        @else
                            <span class="text-red-200">Belum ada Tahun Ajaran aktif.</span>
                        @endif
                    </p>
                </div>
            </div>
            <div class="text-right hidden sm:block">
                <p class="text-indigo-100 text-sm font-medium">{{ \Carbon\Carbon::now()->isoFormat('l, d F Y') }}</p>
                <p class="text-white text-xl font-bold" id="realtimeClock">00:00:00 WIB</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5 transform hover:-translate-y-1 transition duration-300">
                <div class="h-14 w-14 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-500 uppercase tracking-wide">Kelas Diajar</p>
                    <p class="text-2xl font-black text-gray-900 mt-0.5">{{ $totalClasses }} <span class="text-sm font-medium text-gray-500">Kelas</span></p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5 transform hover:-translate-y-1 transition duration-300">
                <div class="h-14 w-14 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 shrink-0">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-500 uppercase tracking-wide">Total Siswa</p>
                    <p class="text-2xl font-black text-gray-900 mt-0.5">{{ $totalStudents }} <span class="text-sm font-medium text-gray-500">Siswa</span></p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5 transform hover:-translate-y-1 transition duration-300">
                <div class="h-14 w-14 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600 shrink-0">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-500 uppercase tracking-wide">Tugas Aktif</p>
                    <p class="text-2xl font-black text-gray-900 mt-0.5">{{ $activeAssignments }} <span class="text-sm font-medium text-gray-500">Berlangsung</span></p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 sm:p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            Jadwal Mengajar Hari Ini
                        </h3>
                        <a href="{{ route('guru.attendances.index') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800">Lihat Semua &rarr;</a>
                    </div>
                    
                    <div class="p-5 sm:p-6">
                        @if($todaySchedules->isEmpty())
                            <div class="text-center py-8">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-50 mb-4">
                                    <svg class="w-8 h-8 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <h4 class="text-base font-bold text-gray-900">Tidak ada jadwal hari ini</h4>
                                <p class="text-sm text-gray-500 mt-1">Anda bisa bersantai atau memeriksa tugas siswa.</p>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($todaySchedules as $schedule)
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 rounded-xl border border-gray-100 hover:border-indigo-200 hover:shadow-md transition-all bg-white gap-4">
                                    <div class="flex items-start gap-4">
                                        <div class="bg-indigo-50 text-indigo-700 font-bold px-3 py-2 rounded-lg text-center min-w-[80px]">
                                            <p class="text-xs uppercase opacity-70">Jam</p>
                                            <p class="text-sm">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</p>
                                        </div>
                                        <div>
                                            <h4 class="text-base font-bold text-gray-900">{{ $schedule->classroom->name }}</h4>
                                            <p class="text-sm text-gray-600">{{ $schedule->subject->name }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('guru.attendances.create', $schedule->id) }}" class="w-full sm:w-auto text-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-lg shadow-sm transition">
                                        Mulai Kelas
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                            Tugas Terbaru
                        </h3>
                    </div>
                    
                    <div class="p-5">
                        @if($recentAssignments->isEmpty())
                            <p class="text-sm text-gray-500 text-center py-4">Belum ada tugas yang diterbitkan.</p>
                        @else
                            <div class="space-y-4">
                                @foreach($recentAssignments as $assignment)
                                <div class="border-l-4 border-indigo-500 pl-4 py-1">
                                    <p class="text-sm font-bold text-gray-900 truncate" title="{{ $assignment->title }}">{{ $assignment->title }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $assignment->classroom->name }} • {{ $assignment->type }}</p>
                                    @php $isPast = \Carbon\Carbon::parse($assignment->due_date)->isPast(); @endphp
                                    <p class="text-[10px] font-bold mt-1 {{ $isPast ? 'text-red-500' : 'text-emerald-500' }}">
                                        Deadline: {{ \Carbon\Carbon::parse($assignment->due_date)->format('d M Y') }}
                                    </p>
                                </div>
                                @endforeach
                            </div>
                            <div class="mt-5 text-center">
                                <a href="{{ route('guru.assignments.index') }}" class="text-sm font-bold text-indigo-600 hover:underline">Kelola Semua Tugas &rarr;</a>
                            </div>
                        @endif
                    </div>
                </div>
                
            </div>

        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    // Script sederhana untuk Jam Realtime di Dashboard
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID', { hour12: false }) + ' WIB';
        const clockElement = document.getElementById('realtimeClock');
        if(clockElement) {
            clockElement.textContent = timeString;
        }
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
@endpush