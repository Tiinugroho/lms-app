@extends('partials.app')
@section('title', 'Monitoring Kehadiran & Jurnal')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container .select2-selection--single { height: 42px !important; border: 1px solid #d1d5db !important; border-radius: 0.375rem !important; display: flex; align-items: center; padding-left: 0.25rem; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important; }
    .select2-container--default .select2-selection--single .select2-selection__arrow { height: 40px !important; right: 8px !important; }
    .select2-container--default .select2-selection--single .select2-selection__rendered { color: #374151 !important; font-size: 0.875rem !important; line-height: 40px !important; }
    .select2-container--default.select2-container--focus .select2-selection--single { border-color: #6366f1 !important; box-shadow: 0 0 0 1px #6366f1 !important; }
</style>
@endpush

@section('content')
<main class="flex-1 pb-12 pt-8 relative w-full">
    <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-indigo-50/50 to-transparent -z-10 pointer-events-none"></div>

    <div class="mx-auto max-w-12xl px-4 sm:px-6 lg:px-8 w-full">
        <div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Monitoring Jurnal Guru</h2>
                <p class="text-sm text-gray-500 mt-1">Pantau aktivitas mengajar dan pengisian absensi dari seluruh guru.</p>
            </div>
        </div>

        <div class="bg-white/60 backdrop-blur-md p-5 rounded-2xl border border-white shadow-sm mb-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-900">Filter Berdasarkan Periode</p>
                </div>
            </div>
            <form action="{{ route('admin.monitoring.attendances') }}" method="GET" class="w-full sm:w-1/3">
                <select name="academic_year_id" onchange="this.form.submit()" class="select2-search block w-full">
                    @foreach($academicYears as $year)
                        <option value="{{ $year->id }}" {{ $selectedYearId == $year->id ? 'selected' : '' }}>
                            {{ $year->period }} - Semester {{ $year->semester }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="bg-white shadow-sm sm:rounded-lg border border-gray-100 p-4 sm:p-6 w-full">
            <div class="overflow-x-auto w-full">
                <table id="monitoringTable" class="w-full text-left border-collapse min-w-[900px]">
                    <thead>
                        <tr class="border-b border-gray-200 text-xs font-semibold text-gray-500 uppercase tracking-wider bg-gray-50">
                            <th class="px-4 py-3 w-10 text-center">No</th>
                            <th class="px-4 py-3">Tanggal & Topik</th>
                            <th class="px-4 py-3">Guru & Mapel</th>
                            <th class="px-4 py-3">Kelas</th>
                            <th class="px-4 py-3 text-center">Pertemuan Ke-</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($attendances as $row)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-4 text-sm text-gray-500 text-center">{{ $loop->iteration }}</td>
                            <td class="px-4 py-4">
                                <p class="text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}</p>
                                <p class="text-xs text-gray-500 truncate max-w-xs mt-1" title="{{ $row->topic }}">{{ $row->topic }}</p>
                            </td>
                            <td class="px-4 py-4">
                                <p class="text-sm font-bold text-indigo-600">{{ $row->schedule->teacher->user->name }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $row->schedule->subject->name }}</p>
                            </td>
                            <td class="px-4 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $row->schedule->classroom->name }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <span class="text-sm font-bold text-gray-700 bg-gray-50 px-3 py-1 rounded-lg border border-gray-200">{{ $row->meeting_number }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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

        const emptyTableHTML = `
            <div class="flex flex-col items-center justify-center py-12 px-4 text-center w-full">
                <div class="h-20 w-20 bg-indigo-50 rounded-full flex items-center justify-center mb-4 border border-indigo-100">
                    <svg class="h-10 w-10 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                </div>
                <h3 class="text-base font-bold text-gray-900">Belum Ada Data Jurnal</h3>
                <p class="mt-1 text-sm text-gray-500 max-w-sm mx-auto">Tidak ada guru yang mengisi jurnal atau melakukan absensi pada periode akademik yang dipilih.</p>
            </div>
        `;

        if ($('#monitoringTable').length) {
            $('#monitoringTable').DataTable({
                "language": {
                    "emptyTable": emptyTableHTML,
                    "search": "Cari (Topik/Guru/Kelas):",
                },
                "pagingType": "simple_numbers",
                "lengthMenu": [10, 25, 50]
            });
        }
    });
</script>
@endpush