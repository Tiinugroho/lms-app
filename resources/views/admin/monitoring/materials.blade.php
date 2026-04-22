@extends('partials.app')
@section('title', 'Monitoring Bahan Ajar')

@section('content')
<main class="flex-1 pb-12 pt-8 relative w-full">
    <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-indigo-50/50 to-transparent -z-10 pointer-events-none"></div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 w-full">
        <div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Monitoring Bahan Ajar (Materi)</h2>
                <p class="text-sm text-gray-500 mt-1">Daftar seluruh materi, modul, dan presentasi yang telah dibagikan oleh guru.</p>
            </div>
        </div>

        <div class="bg-white shadow-sm sm:rounded-lg border border-gray-100 p-4 sm:p-6 w-full">
            <div class="overflow-x-auto w-full">
                <table id="materialsAdminTable" class="w-full text-left border-collapse min-w-[900px]">
                    <thead>
                        <tr class="border-b border-gray-200 text-xs font-semibold text-gray-500 uppercase tracking-wider bg-gray-50">
                            <th class="px-4 py-3 w-10 text-center">No</th>
                            <th class="px-4 py-3">Materi & Mapel</th>
                            <th class="px-4 py-3">Guru Pengunggah</th>
                            <th class="px-4 py-3">Kelas Tujuan</th>
                            <th class="px-4 py-3 text-center">Akses File</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($materials as $material)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-4 text-sm text-gray-500 text-center">{{ $loop->iteration }}</td>
                            <td class="px-4 py-4">
                                <p class="text-sm font-bold text-gray-900 truncate max-w-xs" title="{{ $material->title }}">{{ $material->title }}</p>
                                <p class="text-xs text-indigo-600 font-medium mt-0.5">{{ $material->subject->name }}</p>
                            </td>
                            <td class="px-4 py-4">
                                <p class="text-sm font-bold text-gray-800">{{ $material->teacher->user->name }}</p>
                                <p class="text-[10px] text-gray-400 mt-1">{{ $material->created_at->format('d M Y H:i') }}</p>
                            </td>
                            <td class="px-4 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    {{ $material->classroom->name }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-center">
                                @if($material->file_path)
                                    <a href="{{ Storage::url($material->file_path) }}" target="_blank" class="inline-flex items-center text-xs font-bold text-indigo-600 hover:text-indigo-900">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg> Lihat
                                    </a>
                                @elseif($material->external_link)
                                    <a href="{{ $material->external_link }}" target="_blank" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-900">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg> Buka Link
                                    </a>
                                @else
                                    <span class="text-xs text-gray-400">Hanya teks</span>
                                @endif
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
<script>
    $(document).ready(function() {
        const emptyTableHTML = `
            <div class="flex flex-col items-center justify-center py-12 px-4 text-center w-full">
                <div class="h-20 w-20 bg-indigo-50 rounded-full flex items-center justify-center mb-4 border border-indigo-100">
                    <svg class="h-10 w-10 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-base font-bold text-gray-900">Belum Ada Materi Pembelajaran</h3>
                <p class="mt-1 text-sm text-gray-500 max-w-sm mx-auto">Saat ini belum ada guru yang mengunggah bahan ajar ke dalam sistem.</p>
            </div>
        `;

        if ($('#materialsAdminTable').length) {
            $('#materialsAdminTable').DataTable({
                "language": {
                    "emptyTable": emptyTableHTML,
                    "search": "Cari Materi / Guru:",
                },
                "pagingType": "simple_numbers",
                "lengthMenu": [10, 25, 50],
                "columnDefs": [ { "orderable": false, "targets": 4 } ]
            });
        }
    });
</script>
@endpush