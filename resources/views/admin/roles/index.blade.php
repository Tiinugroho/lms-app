@extends('partials.app')
@section('title', 'Manajemen Hak Akses (RBAC)')

@section('content')
    <main class="flex-1 pb-12 pt-8 relative w-full">
        <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-indigo-50/50 to-transparent -z-10 pointer-events-none"></div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 w-full">

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Manajemen Role (Peran)</h2>
                    <p class="text-sm text-gray-500 mt-1">Kelola peran pengguna dan hak akses (permissions) secara spesifik.</p>
                </div>
                <a href="{{ route('admin.roles.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition">
                    + Buat Role Baru
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-8 w-full">
                <div class="bg-white/60 backdrop-blur-md border border-white p-5 sm:p-6 rounded-xl shadow-sm transition hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Role Sistem</p>
                            <h3 class="mt-1 text-2xl sm:text-3xl font-bold text-gray-900">{{ $totalRoles }}</h3>
                        </div>
                        <div class="p-3 bg-indigo-50 text-indigo-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white/60 backdrop-blur-md border border-white p-5 sm:p-6 rounded-xl shadow-sm transition hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Modul Hak Akses (Permissions)</p>
                            <h3 class="mt-1 text-2xl sm:text-3xl font-bold text-gray-900">{{ $totalPermissions }}</h3>
                        </div>
                        <div class="p-3 bg-amber-50 text-amber-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg border border-gray-100 p-4 sm:p-6 w-full relative">
                @if ($roles->count() > 0)
                    <div class="overflow-x-auto w-full">
                        <table id="roleTable" class="w-full min-w-[800px] text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-200 text-sm font-semibold text-gray-600 bg-gray-50/50">
                                    <th class="px-4 py-3 whitespace-nowrap w-16">No</th>
                                    <th class="px-4 py-3 whitespace-nowrap w-48">Nama Role</th>
                                    <th class="px-4 py-3">Hak Akses (Permissions)</th>
                                    <th class="px-4 py-3 whitespace-nowrap text-center">Jml Pengguna</th>
                                    <th class="px-4 py-3 text-right whitespace-nowrap w-40">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($roles as $role)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-4 py-4 text-sm text-gray-600">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-4">
                                            <div class="font-bold text-gray-900 whitespace-nowrap tracking-wide">{{ strtoupper(str_replace('-', ' ', $role->name)) }}</div>
                                            <div class="text-xs text-gray-500">Sistem: {{ $role->name }}</div>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="flex flex-wrap gap-1.5">
                                                @forelse($role->permissions->take(8) as $permission)
                                                    <span class="px-2.5 py-1 bg-gray-100 text-gray-700 border border-gray-200 rounded text-xs font-medium">
                                                        {{ $permission->name }}
                                                    </span>
                                                @empty
                                                    <span class="text-xs text-gray-400 italic">Belum ada hak akses</span>
                                                @endforelse
                                                
                                                @if($role->permissions_count > 8)
                                                    <span class="px-2.5 py-1 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded text-xs font-medium font-bold">
                                                        +{{ $role->permissions_count - 8 }} lainnya
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            <span class="inline-flex items-center justify-center px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-bold">
                                                {{ $role->users_count }} Akun
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                            
                                            <a href="{{ route('admin.roles.edit', $role->id) }}" class="flex items-center gap-1 px-3 py-1.5 bg-indigo-100 text-indigo-600 rounded hover:bg-indigo-200 text-sm font-medium transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6.586-6.586a2 2 0 112.828 2.828L11.828 13.828A4 4 0 019 15H6v-3a4 4 0 011.172-2.828z" />
                                                </svg>
                                                Edit
                                            </a>

                                            @if($role->name !== 'super-admin')
                                                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="flex items-center gap-1 px-3 py-1.5 bg-red-100 text-red-600 rounded hover:bg-red-200 text-sm font-medium transition btn-delete">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-1 14H6L5 7m5 4v6m4-6v6M9 7h6m-7 0l1-2h4l1 2" />
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            @endif
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Belum Ada Role</h3>
                        <p class="mt-1 text-sm text-gray-500 max-w-sm mx-auto">Sistem belum memiliki data hak akses (role). Silakan buat role pertama Anda.</p>
                        <div class="mt-6">
                            <a href="{{ route('admin.roles.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                Buat Role Pertama
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
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Konfirmasi Hapus Role</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus Role ini? Pengguna yang terikat dengan Role ini akan kehilangan seluruh hak aksesnya di sistem.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" id="confirmDeleteAction" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Ya, Hapus Role
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
            $('#roleTable').DataTable({
                "language": {},
                "pagingType": "simple_numbers",
                "lengthMenu": [5, 10, 25, 50],
                "columnDefs": [{ "orderable": false, "targets": 4 }] // Matikan sorting untuk kolom Aksi
            });

            // Logika Modal Hapus
            let formToSubmit = null;

            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
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