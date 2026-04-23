@extends('partials.app')
@section('title', 'Edit Data Role')

@section('content')
    <main class="flex-1 pb-12 pt-8 relative w-full">
        <div
            class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-indigo-50/50 to-transparent -z-10 pointer-events-none">
        </div>

        <div class="mx-auto max-w-12xl px-4 sm:px-6 lg:px-8 w-full">
            <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Edit Role:
                        {{ strtoupper(str_replace('-', ' ', $role->name)) }}</h2>
                    <p class="text-sm text-gray-500 mt-1">Perbarui nama peran dan kelola hak akses yang diperbolehkan.</p>
                </div>
                <a href="{{ route('admin.roles.index') }}"
                    class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900 bg-white px-4 py-2 rounded-md border border-gray-200 shadow-sm transition">
                    &larr; Kembali
                </a>
            </div>

            <form action="{{ route('admin.roles.update', $role->id) }}" method="POST"
                class="bg-white shadow-sm sm:rounded-xl border border-gray-200 overflow-hidden">
                @csrf
                @method('PUT')
                <div class="p-6 sm:p-10">

                    @if ($errors->any())
                        <div class="mb-8 bg-red-50 border border-red-200 text-red-600 px-5 py-4 rounded-lg text-sm">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-10">
                        <label class="block text-sm font-bold text-gray-900 mb-2">Nama Role <span
                                class="text-red-500">*</span></label>

                        @if ($role->name === 'super-admin')
                            <input type="text" name="name" value="{{ $role->name }}" readonly
                                class="block w-full max-w-md rounded-md border border-gray-300 bg-gray-100 text-gray-500 shadow-sm text-base py-2.5 px-3 cursor-not-allowed">
                            <p class="text-xs text-red-500 mt-2">Nama role sistem default tidak dapat diubah.</p>
                        @else
                            <input type="text" name="name"
                                value="{{ old('name', str_replace('-', ' ', $role->name)) }}" required
                                class="block w-full max-w-md rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-2.5 px-3 transition">
                        @endif
                    </div>

                    <h3 class="text-xl font-bold text-gray-900 mb-6 border-b border-gray-100 pb-3">Penugasan Hak Akses
                        (Permissions)</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                        @php
                            // Mengelompokkan permission berdasarkan modul
                            $groupedPermissions = $permissions->groupBy(function ($perm) {
                                return explode('-', $perm->name)[0];
                            });
                        @endphp

                        @foreach ($groupedPermissions as $module => $perms)
                            <div class="bg-gray-50 rounded-lg border border-gray-200 p-5 module-container">
                                <div class="flex justify-between items-center border-b border-gray-200 pb-2 mb-3">
                                    <h4 class="font-bold text-gray-800 uppercase text-xs tracking-wider">
                                        Modul: {{ str_replace('_', ' ', $module) }}
                                    </h4>
                                    <label
                                        class="inline-flex items-center text-[10px] font-semibold text-indigo-600 cursor-pointer uppercase tracking-tight">
                                        <input type="checkbox"
                                            class="select-all-module mr-1.5 h-3 w-3 rounded border-gray-300">
                                        Pilih Semua
                                    </label>
                                </div>

                                <div class="space-y-3">
                                    @foreach ($perms as $permission)
                                        @php
                                            $action = explode('-', $permission->name)[1] ?? $permission->name;
                                            // Untuk halaman Edit, variabel $isChecked sudah ada di kode Anda sebelumnya
                                            $checkedAttr =
                                                isset($rolePermissions) && in_array($permission->id, $rolePermissions)
                                                    ? 'checked'
                                                    : '';
                                        @endphp
                                        <label
                                            class="flex items-start cursor-pointer hover:bg-gray-100 p-1.5 rounded transition">
                                            <div class="flex items-center h-5">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                                    {{ $checkedAttr }}
                                                    class="permission-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 w-4 h-4 mt-0.5">
                                            </div>
                                            <div class="ml-3 text-sm flex-1">
                                                <span
                                                    class="font-medium text-gray-700 capitalize">{{ $action }}</span>
                                                <span
                                                    class="block text-xs text-gray-400 font-mono mt-0.5">{{ $permission->name }}</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-5 sm:px-10 flex justify-end border-t border-gray-200">
                    <button type="submit"
                        class="inline-flex justify-center py-2.5 px-8 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Perbarui Data Role
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil semua container modul
            const moduleContainers = document.querySelectorAll('.module-container');

            moduleContainers.forEach(container => {
                const selectAllCheckbox = container.querySelector('.select-all-module');
                const permissionCheckboxes = container.querySelectorAll('.permission-checkbox');

                // 1. Logika Klik "Pilih Semua"
                selectAllCheckbox.addEventListener('change', function() {
                    permissionCheckboxes.forEach(cb => {
                        cb.checked = this.checked;
                    });
                });

                // 2. Logika Sinkronisasi Balik (Jika satu di-uncheck, "Pilih Semua" juga uncheck)
                permissionCheckboxes.forEach(cb => {
                    cb.addEventListener('change', function() {
                        const allChecked = Array.from(permissionCheckboxes).every(p => p
                            .checked);
                        selectAllCheckbox.checked = allChecked;
                    });
                });

                // 3. Jalankan pengecekan awal (khusus halaman Edit agar status "Pilih Semua" sesuai data)
                const allCheckedOnLoad = Array.from(permissionCheckboxes).every(p => p.checked);
                if (permissionCheckboxes.length > 0) {
                    selectAllCheckbox.checked = allCheckedOnLoad;
                }
            });
        });
    </script>
@endpush
