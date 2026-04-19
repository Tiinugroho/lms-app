@extends('partials.app')
@section('title', 'Manajemen Mata Pelajaran')

@section('content')
    <main class="flex-1 pb-12 pt-8 relative w-full">
        <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-indigo-50/50 to-transparent -z-10 pointer-events-none"></div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 w-full">

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Mata Pelajaran</h2>
                    <p class="text-sm text-gray-500 mt-1">Kelola daftar mata pelajaran (Master Data) untuk penjadwalan.</p>
                </div>
                <a href="{{ route('admin.subjects.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition">
                    + Tambah Mata Pelajaran
                </a>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg border border-gray-100 p-4 sm:p-6 w-full relative">
                @if ($subjects->count() > 0)
                    <div class="overflow-x-auto w-full">
                        <table id="subjectTable" class="w-full min-w-[800px] text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-200 text-sm font-semibold text-gray-600 bg-gray-50/50">
                                    <th class="px-4 py-3 whitespace-nowrap w-16">No</th>
                                    <th class="px-4 py-3 whitespace-nowrap w-32">Kode Mapel</th>
                                    <th class="px-4 py-3 whitespace-nowrap">Nama Mata Pelajaran</th>
                                    <th class="px-4 py-3 whitespace-nowrap">Deskripsi</th>
                                    <th class="px-4 py-3 text-right whitespace-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($subjects as $subject)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-4 py-4 text-sm text-gray-600">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-4 font-bold text-indigo-600 whitespace-nowrap">
                                            {{ $subject->code }}
                                        </td>
                                        <td class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $subject->name }}
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-600">
                                            {{ Str::limit($subject->description, 50) ?? '-' }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('admin.subjects.edit', $subject->id) }}" class="flex items-center gap-1 px-3 py-1.5 bg-indigo-100 text-indigo-600 rounded hover:bg-indigo-200 text-sm font-medium transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6.586-6.586a2 2 0 112.828 2.828L11.828 13.828A4 4 0 019 15H6v-3a4 4 0 011.172-2.828z" /></svg>
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.subjects.destroy', $subject->id) }}" method="POST" class="inline-block m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="flex items-center gap-1 px-3 py-1.5 bg-red-100 text-red-600 rounded hover:bg-red-200 text-sm font-medium transition btn-delete">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-1 14H6L5 7m5 4v6m4-6v6M9 7h6m-7 0l1-2h4l1 2" /></svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-12 px-4 text-center">
                        <div class="h-24 w-24 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Belum Ada Mata Pelajaran</h3>
                        <p class="mt-1 text-sm text-gray-500 max-w-sm mx-auto">Silakan tambahkan data mata pelajaran untuk memulai penyusunan jadwal.</p>
                        <div class="mt-6">
                            <a href="{{ route('admin.subjects.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                Tambah Mata Pelajaran
                            </a>
                        </div>
                    </div>
                @endif
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
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Konfirmasi Hapus Data</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus mata pelajaran ini? Tindakan ini tidak dapat dibatalkan.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" id="confirmDeleteAction" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Ya, Hapus
                        </button>
                        <button type="button" class="close-modal mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#subjectTable').DataTable({
                "language": {},
                "pagingType": "simple_numbers",
                "lengthMenu": [5, 10, 25, 50],
                "columnDefs": [{ "orderable": false, "targets": 4 }]
            });

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