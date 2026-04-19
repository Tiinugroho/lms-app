@extends('partials.app')
@section('title', 'Edit Data Staff')

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
            <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Edit Data Staff</h2>
                    <p class="text-sm text-gray-500 mt-1">Perbarui informasi akun, akses, atau profil identitas pengajar.</p>
                </div>
                <a href="{{ route('admin.staffs.index') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900 bg-white px-4 py-2 rounded-md border border-gray-200 shadow-sm transition">
                    &larr; Kembali
                </a>
            </div>

            <form action="{{ route('admin.staffs.update', $staff->id) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-sm sm:rounded-xl border border-gray-200 overflow-hidden">
                @csrf
                @method('PUT')
                
                <div class="p-6 sm:p-10 space-y-8">
                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-600 px-5 py-4 rounded-lg text-sm">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-100 pb-2">1. Informasi Akun & Akses</h3>
                        <div class="grid grid-cols-12 gap-6">
                            
                            <div class="col-span-12 md:col-span-4 flex flex-col sm:flex-row sm:items-center gap-4">
                                <img src="{{ $staff->user->avatar_url }}" alt="Avatar" class="h-16 w-16 rounded-full object-cover border border-gray-200 shadow-sm">
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Ganti Foto Profil</label>
                                    <input type="file" name="avatar" accept="image/png, image/jpeg, image/jpg" class="block w-full text-sm text-gray-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition border border-gray-200">
                                </div>
                            </div>

                            <div class="col-span-12 md:col-span-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $staff->user->name) }}" required class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-2.5 px-3">
                            </div>

                            <div class="col-span-12 md:col-span-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" value="{{ old('email', $staff->user->email) }}" required class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-2.5 px-3">
                            </div>
                            
                            <div class="col-span-12 md:col-span-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Hak Akses (Role) Sistem <span class="text-red-500">*</span></label>
                                <select name="role" required class="select2-search block w-full">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ (old('role') ?? $userRole) == $role->name ? 'selected' : '' }}>
                                            {{ ucwords(str_replace('-', ' ', $role->name)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-12 md:col-span-6 bg-gray-50 p-4 rounded-lg border border-gray-200 mt-2 flex items-center">
                                <label class="flex items-center cursor-pointer w-max">
                                    <input type="checkbox" name="is_active" value="1" {{ $staff->user->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 h-5 w-5">
                                    <span class="ml-3 text-base text-gray-700 font-medium">Akun Aktif (Bisa login)</span>
                                </label>
                            </div>

                            <div class="col-span-12 border border-gray-200 rounded-lg p-5 bg-gray-50/50 mt-2">
                                <p class="text-sm text-gray-600 mb-3 font-medium">Ganti Password (Kosongkan jika tidak ingin mengubah)</p>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <input type="password" name="password" placeholder="Password Baru" class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3">
                                    <input type="password" name="password_confirmation" placeholder="Ulangi Password Baru" class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-100 pb-2">2. Profil Identitas Pegawai</h3>
                        
                        <div class="grid grid-cols-12 gap-6">
                            <div class="col-span-12 md:col-span-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">NIP / ID Pegawai <span class="text-red-500">*</span></label>
                                <input type="text" name="nip" value="{{ old('nip', $staff->nip) }}" required class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-2.5 px-3">
                            </div>

                            <div class="col-span-12 md:col-span-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">NIK (KTP)</label>
                                <input type="text" name="nik" value="{{ old('nik', $staff->nik) }}" class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-2.5 px-3">
                            </div>

                            <div class="col-span-12 md:col-span-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan / Posisi <span class="text-red-500">*</span></label>
                                <input type="text" name="position" value="{{ old('position', $staff->position) }}" required class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-2.5 px-3">
                            </div>

                            <div class="col-span-12 md:col-span-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                                <select name="gender" required class="select2-search block w-full rounded-md border border-gray-300 bg-white py-2.5 px-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                                    <option value="L" {{ old('gender', $staff->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('gender', $staff->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            <div class="col-span-12 md:col-span-8">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                                <input type="text" name="phone_number" value="{{ old('phone_number', $staff->phone_number) }}" class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-2.5 px-3">
                            </div>

                            <div class="col-span-12">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                                <textarea name="address" rows="3" class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-2.5 px-3">{{ old('address', $staff->address) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-6 py-5 sm:px-10 flex justify-end border-t border-gray-200">
                    <button type="submit" class="w-full sm:w-auto inline-flex justify-center py-2.5 px-8 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Perbarui Data Staff
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2-search').select2({ width: '100%', minimumResultsForSearch: Infinity });
    });
</script>
@endpush