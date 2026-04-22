@extends('partials.app')
@section('title', 'Manajemen Jadwal Pelajaran')
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

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 w-full">

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Jadwal Pelajaran</h2>
                    <p class="text-sm text-gray-500 mt-1">Kelola jadwal mengajar guru dan alokasi ruang kelas.</p>
                </div>
                <a href="{{ route('admin.schedules.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition">
                    + Tambah Jadwal Baru
                </a>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-md shadow-sm flex items-center">
                    <svg class="h-5 w-5 text-emerald-400 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                    <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white/60 backdrop-blur-md p-5 rounded-2xl border border-white shadow-sm mb-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900">Filter Tahun Ajaran</p>
                        <p class="text-xs text-gray-500">Tampilkan jadwal berdasarkan periode akademik.</p>
                    </div>
                </div>
                <form action="{{ route('admin.schedules.index') }}" method="GET" class="w-full sm:w-1/3">
                    <select name="academic_year_id" onchange="this.form.submit()" class="select2-search block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3 bg-white">
                        @foreach($academicYears as $year)
                            <option value="{{ $year->id }}" {{ $selectedYearId == $year->id ? 'selected' : '' }}>
                                {{ $year->period }} - Semester {{ $year->semester }} {{ $year->is_active ? '(Aktif)' : '' }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg border border-gray-100 p-4 sm:p-6 w-full relative">
                <div class="overflow-x-auto w-full">
                    <table id="scheduleTable" class="w-full text-left border-collapse min-w-[1000px]">
                        <thead>
                            <tr class="border-b border-gray-200 text-xs font-semibold text-gray-500 uppercase tracking-wider bg-gray-50">
                                <th class="px-4 py-3 w-10 text-center">No</th>
                                <th class="px-4 py-3">Hari & Waktu</th>
                                <th class="px-4 py-3">Kelas</th>
                                <th class="px-4 py-3">Mata Pelajaran</th>
                                <th class="px-4 py-3">Guru Pengajar</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($schedules as $schedule)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-4 text-sm text-gray-500 text-center">{{ $loop->iteration }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 mb-1">
                                        {{ $schedule->day_of_week }}
                                    </span><br>
                                    <span class="text-sm font-bold text-gray-900">
                                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }} WIB
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="text-sm font-bold text-gray-900">{{ $schedule->classroom->name }}</p>
                                    <p class="text-xs text-gray-500">Tingkat {{ $schedule->classroom->level }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="text-sm font-bold text-gray-900">{{ $schedule->subject->name }}</p>
                                    <p class="text-xs text-gray-500">Kode: {{ $schedule->subject->code }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $schedule->teacher->user->avatar_url }}" class="w-8 h-8 rounded-full object-cover border border-gray-200">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $schedule->teacher->user->name }}</p>
                                            <p class="text-[10px] text-gray-500">NIP: {{ $schedule->teacher->nip }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="inline-flex items-center p-1.5 bg-indigo-50 text-indigo-600 rounded hover:bg-indigo-100 transition shadow-sm" title="Edit Jadwal">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6.586-6.586a2 2 0 112.828 2.828L11.828 13.828A4 4 0 019 15H6v-3a4 4 0 011.172-2.828z" /></svg>
                                        </a>
                                        <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" class="inline-block m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="inline-flex items-center p-1.5 bg-red-50 text-red-600 rounded hover:bg-red-100 transition shadow-sm btn-delete" title="Hapus Jadwal">
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
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Hapus Jadwal</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus jadwal ini? Data kehadiran (absensi) yang terkait dengan jadwal ini mungkin akan terpengaruh.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" id="confirmDeleteAction" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Ya, Hapus</button>
                        <button type="button" class="close-modal mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                    </div>
                </div>
            </div>
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
<script>
    $(document).ready(function() {
        const emptyTableHTML = `
            <div class="flex flex-col items-center justify-center py-12 px-4 text-center w-full">
                <div class="h-20 w-20 bg-indigo-50 rounded-full flex items-center justify-center mb-4 border border-indigo-100">
                    <svg class="h-10 w-10 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-base font-bold text-gray-900">Belum Ada Jadwal Pelajaran</h3>
                <p class="mt-1 text-sm text-gray-500 max-w-sm mx-auto">Silakan tambahkan jadwal mengajar baru untuk tahun ajaran ini.</p>
            </div>
        `;

        const zeroRecordsHTML = `
            <div class="flex flex-col items-center justify-center py-10 text-center w-full">
                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-sm font-medium text-gray-900">Pencarian Tidak Ditemukan</p>
                <p class="text-xs text-gray-500 mt-1">Coba gunakan kata kunci pencarian yang lain.</p>
            </div>
        `;

        if ($('#scheduleTable').length) {
            $('#scheduleTable').DataTable({
                "language": {
                    "emptyTable": emptyTableHTML,
                    "zeroRecords": zeroRecordsHTML,
                    // "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ jadwal",
                    // "infoEmpty": "Menampilkan 0 jadwal",
                    // "infoFiltered": "(disaring dari _MAX_ total jadwal)",
                    // "lengthMenu": "Tampilkan _MENU_ baris",
                    // "search": "Cari (Kelas, Guru, Mapel):",
                    // "paginate": { "first": "Pertama", "last": "Terakhir", "next": "Selanjutnya", "previous": "Sebelumnya" }
                },
                "pagingType": "simple_numbers",
                "lengthMenu": [10, 25, 50, 100],
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