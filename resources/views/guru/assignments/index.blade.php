@extends('partials.app')
@section('title', 'Tugas & Ujian')

@section('content')
<main class="flex-1 pb-12 pt-8 relative w-full">
    <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-indigo-50/50 to-transparent -z-10 pointer-events-none"></div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 w-full">
        
        <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Tugas & Ujian</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola evaluasi, kuis, dan ulangan untuk siswa Anda.</p>
            </div>
            <a href="{{ route('guru.assignments.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition">
                + Buat Tugas Baru
            </a>
        </div>

        <div class="bg-white shadow-sm sm:rounded-lg border border-gray-100 p-4 sm:p-6 w-full relative">
            <div class="overflow-x-auto w-full">
                <table id="assignmentTable" class="w-full text-left border-collapse min-w-[900px]">
                    <thead>
                        <tr class="border-b border-gray-200 text-xs font-semibold text-gray-500 uppercase tracking-wider bg-gray-50">
                            <th class="px-4 py-3 w-10 text-center">No</th>
                            <th class="px-4 py-3">Informasi Tugas</th>
                            <th class="px-4 py-3">Kelas & Mapel</th>
                            <th class="px-4 py-3">Tenggat Waktu (Deadline)</th>
                            <th class="px-4 py-3 text-right w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($assignments as $assignment)
                        <tr class="hover:bg-gray-50 transition group">
                            <td class="px-4 py-4 text-sm text-gray-500 text-center">{{ $loop->iteration }}</td>
                            <td class="px-4 py-4">
                                <p class="text-sm font-bold text-gray-900 truncate max-w-xs" title="{{ $assignment->title }}">{{ $assignment->title }}</p>
                                
                                @php
                                    $badgeColor = match($assignment->type) {
                                        'Tugas Harian' => 'bg-blue-100 text-blue-800',
                                        'Kuis Mingguan' => 'bg-yellow-100 text-yellow-800',
                                        'Ulangan Harian' => 'bg-orange-100 text-orange-800',
                                        'PTS', 'PAS' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    };
                                @endphp
                                <span class="inline-block mt-1.5 px-2 py-0.5 rounded text-[10px] font-bold {{ $badgeColor }}">
                                    {{ $assignment->type }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800 mb-1">
                                    {{ $assignment->classroom->name }}
                                </span><br>
                                <span class="text-xs font-bold text-gray-700">{{ $assignment->subject->name }}</span>
                            </td>
                            <td class="px-4 py-4">
                                @php
                                    $isPast = \Carbon\Carbon::parse($assignment->due_date)->isPast();
                                @endphp
                                <p class="text-sm font-bold {{ $isPast ? 'text-red-600' : 'text-emerald-600' }}">
                                    {{ \Carbon\Carbon::parse($assignment->due_date)->format('d M Y, H:i') }} WIB
                                </p>
                                <p class="text-[11px] {{ $isPast ? 'text-red-400' : 'text-gray-500' }} mt-0.5">
                                    {{ $isPast ? 'Ditutup' : 'Masih Dibuka' }}
                                </p>
                            </td>
                            <td class="px-4 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($assignment->file_path)
                                    <a href="{{ Storage::url($assignment->file_path) }}" target="_blank" class="inline-flex items-center p-1.5 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition shadow-sm tooltip" title="Lihat Lampiran Soal">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                                    </a>
                                    @endif
                                    
                                    <a href="#" class="inline-flex items-center p-1.5 bg-indigo-50 text-indigo-600 rounded hover:bg-indigo-100 transition shadow-sm tooltip" title="Lihat Pengumpulan Siswa">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                                    </a>

                                    <form action="{{ route('guru.assignments.destroy', $assignment->id) }}" method="POST" class="inline-block m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="inline-flex items-center p-1.5 bg-red-50 text-red-600 rounded hover:bg-red-100 transition shadow-sm tooltip btn-delete" title="Hapus Tugas">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-1 14H6L5 7m5 4v6m4-6v6M9 7h6m-7 0l1-2h4l1 2"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="customDeleteModal" class="fixed inset-0 z-[100] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity close-modal" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Hapus Tugas/Ujian</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus tugas ini? <br><br><b>Peringatan:</b> Seluruh file jawaban siswa yang sudah dikumpulkan dan nilai yang sudah Anda berikan pada tugas ini akan ikut terhapus permanen.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="confirmDeleteAction" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Ya, Hapus Semua</button>
                    <button type="button" class="close-modal mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        const emptyTableHTML = `
            <div class="flex flex-col items-center justify-center py-12 px-4 text-center w-full">
                <div class="h-20 w-20 bg-indigo-50 rounded-full flex items-center justify-center mb-4 border border-indigo-100">
                    <svg class="h-10 w-10 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <h3 class="text-base font-bold text-gray-900">Belum Ada Tugas/Evaluasi</h3>
                <p class="mt-1 text-sm text-gray-500 max-w-sm mx-auto">Anda belum menerbitkan tugas atau ujian apapun. Klik tombol di atas untuk membuatnya.</p>
            </div>
        `;

        if ($('#assignmentTable').length) {
            $('#assignmentTable').DataTable({
                "language": {
                    "emptyTable": emptyTableHTML,
                    "zeroRecords": "Pencarian tidak ditemukan.",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ tugas",
                    "infoEmpty": "Menampilkan 0 tugas",
                    "infoFiltered": "(disaring dari _MAX_ total tugas)",
                    "lengthMenu": "Tampilkan _MENU_ baris",
                    "search": "Cari (Judul/Mapel):",
                },
                "pagingType": "simple_numbers",
                "lengthMenu": [10, 25, 50],
                "columnDefs": [
                    { "orderable": false, "targets": -1 }, // Aksi
                    { "orderable": false, "targets": 0 }  // No
                ]
            });
        }

        let formToSubmit = null;
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            formToSubmit = $(this).closest('form');
            $('#customDeleteModal').removeClass('hidden'); 
        });
        $('#confirmDeleteAction').on('click', function() {
            if (formToSubmit) formToSubmit.submit(); 
        });
        $('.close-modal').on('click', function() {
            $('#customDeleteModal').addClass('hidden'); 
            formToSubmit = null; 
        });
    });
</script>
@endpush