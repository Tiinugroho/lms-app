@extends('partials.app')
@section('title', 'Manajemen Staff & Tendik')

@section('content')
    <main class="flex-1 pb-12 pt-8 relative w-full">
        <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-indigo-50/50 to-transparent -z-10 pointer-events-none"></div>

        <div class="mx-auto max-w-12xl px-4 sm:px-6 lg:px-8 w-full">

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Manajemen Tenaga Kependidikan</h2>
                    <p class="text-sm text-gray-500 mt-1">Kelola data tata usaha, admin, dan staff sekolah lainnya.</p>
                </div>
                <a href="{{ route('admin.staffs.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition">
                    + Tambah Staff Baru
                </a>
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

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8 w-full">
                <div class="bg-white/60 backdrop-blur-md border border-white p-5 sm:p-6 rounded-xl shadow-sm transition hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Staff</p>
                            <h3 class="mt-1 text-2xl sm:text-3xl font-bold text-gray-900">{{ $totalStaffs }}</h3>
                        </div>
                        <div class="p-3 bg-indigo-50 text-indigo-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white/60 backdrop-blur-md border border-white p-5 sm:p-6 rounded-xl shadow-sm transition hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Staff Aktif</p>
                            <h3 class="mt-1 text-2xl sm:text-3xl font-bold text-gray-900">{{ $activeStaffs }}</h3>
                        </div>
                        <div class="p-3 bg-green-50 text-green-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white/60 backdrop-blur-md border border-white p-5 sm:p-6 rounded-xl shadow-sm transition hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Akun Non-Aktif</p>
                            <h3 class="mt-1 text-2xl sm:text-3xl font-bold text-gray-900">{{ $inactiveStaffs }}</h3>
                        </div>
                        <div class="p-3 bg-red-50 text-red-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg border border-gray-100 p-4 sm:p-6 w-full relative">
                @if ($staffs->count() > 0)
                    <div class="overflow-x-auto w-full">
                        <table id="staffTable" class="w-full min-w-[900px] text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-200 text-sm font-semibold text-gray-600 bg-gray-50/50">
                                    <th class="px-4 py-3 whitespace-nowrap w-16">No</th>
                                    <th class="px-4 py-3 whitespace-nowrap">Profil Staff</th>
                                    <th class="px-4 py-3 whitespace-nowrap">Jabatan & ID</th>
                                    <th class="px-4 py-3 whitespace-nowrap">Hak Akses</th>
                                    <th class="px-4 py-3 whitespace-nowrap text-center">Status</th>
                                    <th class="px-4 py-3 whitespace-nowrap text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($staffs as $staff)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-4 py-4 text-sm text-gray-600">{{ $loop->iteration }}</td>
                                        
                                        <td class="px-4 py-4">
                                            <div class="flex items-center gap-3">
                                                <img src="{{ $staff->user->avatar_url }}" alt="Avatar" class="h-10 w-10 rounded-full object-cover border border-gray-200 shadow-sm">
                                                <div>
                                                    <div class="font-medium text-gray-900 whitespace-nowrap">{{ $staff->user->name }}</div>
                                                    <div class="text-sm text-gray-500 whitespace-nowrap">{{ $staff->user->email }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-4 py-4 text-sm text-gray-600 whitespace-nowrap">
                                            <span class="font-semibold text-indigo-600">{{ $staff->position }}</span> <br>
                                            <span class="text-xs text-gray-500">NIP: {{ $staff->nip }} | NIK: {{ $staff->nik ?? '-' }}</span>
                                        </td>

                                        <td class="px-4 py-4 whitespace-nowrap">
                                            @foreach($staff->user->roles as $role)
                                                <span class="px-2 py-1 bg-blue-50 text-blue-700 border border-blue-200 rounded-md text-xs font-medium">{{ ucwords(str_replace('-', ' ', $role->name)) }}</span>
                                            @endforeach
                                        </td>

                                        <td class="px-4 py-4 whitespace-nowrap text-center">
                                            @if ($staff->user->is_active)
                                                <span class="px-2 py-1 bg-green-50 text-green-700 border border-green-200 rounded-md text-xs font-medium">Aktif</span>
                                            @else
                                                <span class="px-2 py-1 bg-red-50 text-red-700 border border-red-200 rounded-md text-xs font-medium">Non-Aktif</span>
                                            @endif
                                        </td>

                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('admin.staffs.id-card', $staff->id) }}" target="_blank" class="flex items-center gap-1 px-3 py-1.5 bg-emerald-100 text-emerald-700 rounded hover:bg-emerald-200 text-sm font-medium transition" title="Cetak ID Card">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                                                    Cetak
                                                </a>
                                                <a href="{{ route('admin.staffs.edit', $staff->id) }}" class="flex items-center gap-1 px-3 py-1.5 bg-indigo-100 text-indigo-600 rounded hover:bg-indigo-200 text-sm font-medium transition">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6.586-6.586a2 2 0 112.828 2.828L11.828 13.828A4 4 0 019 15H6v-3a4 4 0 011.172-2.828z" /></svg>
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.staffs.destroy', $staff->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="flex items-center gap-1 px-3 py-1.5 bg-red-100 text-red-600 rounded hover:bg-red-200 text-sm font-medium transition btn-delete" {{ $staff->user_id === auth()->id() ? 'disabled title="Tidak bisa menghapus akun sendiri"' : '' }}>
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-1 14H6L5 7m5 4v6m4-6v6M9 7h6m-7 0l1-2h4l1 2" /></svg>
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
                            <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Belum Ada Data Staff</h3>
                        <p class="mt-1 text-sm text-gray-500 max-w-sm mx-auto">Sistem belum memiliki data tenaga kependidikan. Silakan tambahkan data baru.</p>
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
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Konfirmasi Hapus Data</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus data staff ini? Tindakan ini bersifat permanen.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" id="confirmDeleteAction" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Ya, Hapus Data</button>
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
            $('#staffTable').DataTable({
                "language": {},
                "pagingType": "simple_numbers",
                "lengthMenu": [5, 10, 25, 50],
                "columnDefs": [{"orderable": false, "targets": 5}]
            });

            let formToSubmit = null;
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                if($(this).is(':disabled')) return;
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