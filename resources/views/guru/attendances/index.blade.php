@extends('partials.app')
@section('title', 'Jadwal Mengajar Anda')

@section('content')
<main class="flex-1 pb-12 pt-8 relative w-full">
    <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-indigo-50/50 to-transparent -z-10 pointer-events-none"></div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 w-full">
        <div class="mb-8 text-center sm:text-left">
            <h2 class="text-2xl font-bold text-gray-900">Jadwal Mengajar Saya</h2>
            <p class="text-sm text-gray-500 mt-1">Pilih kelas untuk mulai mengisi Jurnal dan Absensi Siswa.</p>
        </div>

        @if($schedules->isEmpty())
            <div class="bg-white p-10 rounded-2xl shadow-sm border border-gray-200 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <h3 class="text-lg font-bold text-gray-900">Belum Ada Jadwal</h3>
                <p class="text-gray-500 text-sm">Anda belum memiliki jadwal mengajar di semester ini. Silakan hubungi Admin Sekolah.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($schedules as $schedule)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md hover:border-indigo-300 transition-all duration-200 group flex flex-col">
                    
                    <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 group-hover:bg-indigo-50/50 transition-colors">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white text-indigo-700 border border-indigo-100 shadow-sm">
                            {{ $schedule->day_of_week }}
                        </span>
                        <span class="text-sm font-bold text-gray-700 flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                        </span>
                    </div>

                    <div class="p-6 flex-1 flex flex-col justify-center">
                        <h3 class="text-xl font-extrabold text-gray-900 mb-1">{{ $schedule->classroom->name }}</h3>
                        <p class="text-sm font-medium text-indigo-600 mb-4">{{ $schedule->subject->name }}</p>
                        
                        <div class="flex items-center text-xs text-gray-500 bg-gray-50 p-2 rounded-lg">
                            <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            Tingkat {{ $schedule->classroom->level }}
                        </div>
                    </div>

                    <div class="p-4 border-t border-gray-100">
                        <a href="{{ route('guru.attendances.create', $schedule->id) }}" class="w-full flex justify-center items-center gap-2 bg-indigo-600 text-white px-4 py-2.5 rounded-xl font-bold text-sm hover:bg-indigo-700 transition shadow-sm">
                            Mulai Absensi
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</main>
@endsection