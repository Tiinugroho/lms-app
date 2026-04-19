@extends('partials.app')
@section('title', 'Tahun Akademik')

@section('content')
    <main class="flex-1 pb-12 pt-8 relative w-full">
        <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-indigo-50/50 to-transparent -z-10 pointer-events-none"></div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 w-full">

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Tahun Akademik</h2>
                    <p class="text-sm text-gray-500 mt-1">Kelola data tahun ajaran dan aktifkan semester yang sedang berjalan.</p>
                </div>
                <a href="{{ route('admin.academic-years.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition">
                    + Tambah Tahun Akademik
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-8 w-full">
                <div class="bg-white/60 backdrop-blur-md border border-white p-5 sm:p-6 rounded-xl shadow-sm transition hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Semester Aktif Saat Ini</p>
                            <h3 class="mt-1 text-2xl sm:text-3xl font-bold text-indigo-700">{{ $activeYearName }}</h3>
                        </div>
                        <div class="p-3 bg-green-50 text-green-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white/60 backdrop-blur-md border border-white p-5 sm:p-6 rounded-xl shadow-sm transition hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Semester Terdaftar</p>
                            <h3 class="mt-1 text-2xl sm:text-3xl font-bold text-gray-900">{{ $totalYears }}</h3>
                        </div>
                        <div class="p-3 bg-indigo-50 text-indigo-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg border border-gray-100 p-4 sm:p-6 w-full relative">
                @if ($academicYears->count() > 0)
                    <div class="overflow-x-auto w-full">
                        <table id="academicTable" class="w-full min-w-[800px] text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-200 text-sm font-semibold text-gray-600 bg-gray-50/50">
                                    <th class="px-4 py-3 whitespace-nowrap w-16">No</th>
                                    <th class="px-4 py-3 whitespace-nowrap">Periode</th>
                                    <th class="px-4 py-3 whitespace-nowrap">Semester</th>
                                    <th class="px-4 py-3 whitespace-nowrap text-center">Status</th>
                                    <th class="px-4 py-3 text-right whitespace-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($academicYears as $year)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-4 py-4 text-sm text-gray-600">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-4 font-bold text-gray-900 whitespace-nowrap">
                                            {{ $year->period }}
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-600 whitespace-nowrap">
                                            <span class="{{ $year->semester === 'Ganjil' ? 'text-orange-600' : 'text-blue-600' }} font-medium">
                                                {{ $year->semester }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-center">
                                            @if ($year->is_active)
                                                <span class="px-3 py-1 bg-green-100 text-green-700 border border-green-200 rounded-full text-xs font-bold tracking-wide">AKTIF</span>
                                            @else
                                                <span class="px-3 py-1 bg-gray-100 text-gray-600 border border-gray-200 rounded-full text-xs font-medium tracking-wide">NON-AKTIF</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <div class="flex items-center justify-end gap-4">
                                                
                                                <form action="{{ route('admin.academic-years.activate', $year->id) }}" method="POST" class="flex items-center gap-2 m-0">
                                                    @csrf
                                                    @method('PATCH')
                                                    <span class="text-xs font-semibold {{ $year->is_active ? 'text-indigo-600' : 'text-gray-500' }}">
                                                        {{ $year->is_active ? 'Terpilih' : 'Set Aktif' }}
                                                    </span>
                                                    <label class="relative inline-flex items-center {{ $year->is_active ? 'cursor-not-allowed' : 'cursor-pointer' }}">
                                                        <input type="checkbox" class="sr-only peer" onchange="this.form.submit()" {{ $year->is_active ? 'checked disabled' : '' }}>
                                                        <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-indigo-600 {{ $year->is_active ? 'opacity-80' : '' }}"></div>
                                                    </label>
                                                </form>

                                                <div class="h-5 w-px bg-gray-300"></div>

                                                <form action="{{ route('admin.academic-years.destroy', $year->id) }}" method="POST" class="inline-block m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="flex items-center gap-1 px-3 py-1.5 bg-red-100 text-red-600 rounded hover:bg-red-200 text-sm font-medium transition btn-delete" {{ $year->is_active ? 'disabled title="Tahun aktif tidak bisa dihapus"' : '' }}>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-1 14H6L5 7m5 4v6m4-6v6M9 7h6m-7 0l1-2h4l1 2" />
                                                        </svg>
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
                            <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Belum Ada Tahun Akademik</h3>
                        <p class="mt-1 text-sm text-gray-500 max-w-sm mx-auto">Sistem membutuhkan Tahun Akademik aktif untuk memulai kelas. Silakan tambahkan data baru.</p>
                        <div class="mt-6">
                            <a href="{{ route('admin.academic-years.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                Tambah Tahun Akademik
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
                                    <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus data semester ini? Ini dapat memengaruhi data nilai dan absensi yang terkait dengan periode ini.</p>
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
            $('#academicTable').DataTable({
                "language": {},
                "pagingType": "simple_numbers",
                "lengthMenu": [10, 25, 50],
                "columnDefs": [{
                    "orderable": false,
                    "targets": 4 
                }]
            });

            let formToSubmit = null;

            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                if($(this).is(':disabled')) return; 

                formToSubmit = $(this).closest('form');
                $('#customDeleteModal').removeClass('hidden'); 
            });

            $('#confirmDeleteAction').on('click', function() {
                if (formToSubmit) {
                    formToSubmit.submit();
                }
            });

            $('.close-modal').on('click', function() {
                $('#customDeleteModal').addClass('hidden');
                formToSubmit = null;
            });
        });
    </script>
@endpush