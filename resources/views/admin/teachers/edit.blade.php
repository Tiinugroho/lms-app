@extends('admin.partials.app')
@section('title', 'Edit Data Guru')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container .select2-selection--single {
        height: 44px !important;
        border: 1px solid #d1d5db !important;
        border-radius: 0.375rem !important;
        display: flex;
        align-items: center;
        padding-left: 0.25rem;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 42px !important;
        right: 8px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #374151 !important;
        font-size: 1rem !important;
    }
    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 1px #6366f1 !important;
    }
</style>
@endpush

@section('content')
    <main class="flex-1 pb-12 pt-8 relative">
        <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-indigo-50/50 to-transparent -z-10 pointer-events-none"></div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 w-full">
            <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Edit Data Guru</h2>
                    <p class="text-sm text-gray-500 mt-1">Perbarui profil dan data login untuk <strong>{{ $teacher->user->name }}</strong>.</p>
                </div>
                <a href="{{ route('admin.teachers.index') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900 bg-white px-4 py-2 rounded-md border border-gray-200 shadow-sm transition">
                    &larr; Kembali
                </a>
            </div>

            <form action="{{ route('admin.teachers.update', $teacher->id) }}" method="POST" class="bg-white shadow-sm sm:rounded-xl border border-gray-200 overflow-hidden">
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

                    <h3 class="text-xl font-semibold text-gray-900 mb-6 border-b border-gray-100 pb-3">Informasi Akun (Login)</h3>
                    <div class="grid grid-cols-12 gap-6 mb-10">
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $teacher->user->name) }}" required class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-2.5 px-3 transition">
                        </div>
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $teacher->user->email) }}" required class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-2.5 px-3 transition">
                        </div>
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru <span class="text-gray-400 font-normal text-xs">(Kosongkan jika tak diubah)</span></label>
                            <input type="password" name="password" class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-2.5 px-3 transition">
                        </div>
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-2.5 px-3 transition">
                        </div>
                        <div class="col-span-12 bg-gray-50 p-5 rounded-lg border border-gray-200 mt-2">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ $teacher->user->is_active ? 'checked' : '' }} class="rounded border border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 h-5 w-5">
                                <span class="ml-3 text-base text-gray-700 font-medium">Akun Aktif <span class="text-sm font-normal text-gray-500">(Dapat digunakan untuk login ke sistem)</span></span>
                            </label>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold text-gray-900 mb-6 border-b border-gray-100 pb-3">Profil Pegawai</h3>
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 md:col-span-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">NIP</label>
                            <input type="text" name="nip" value="{{ old('nip', $teacher->nip) }}" class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-2.5 px-3 transition">
                        </div>
                        <div class="col-span-12 md:col-span-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">NUPTK</label>
                            <input type="text" name="nuptk" value="{{ old('nuptk', $teacher->nuptk) }}" class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-2.5 px-3 transition">
                        </div>
                        <div class="col-span-12 md:col-span-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <select name="gender" required class="select2-search block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                                <option value="L" {{ old('gender', $teacher->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('gender', $teacher->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                            <input type="text" name="phone_number" value="{{ old('phone_number', $teacher->phone_number) }}" class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-2.5 px-3 transition">
                        </div>
                        <div class="col-span-12">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                            <textarea name="address" rows="4" class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-2.5 px-3 transition">{{ old('address', $teacher->address) }}</textarea>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-6 py-5 sm:px-10 flex justify-end border-t border-gray-200">
                    <button type="submit" class="inline-flex justify-center py-2.5 px-8 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Perbarui Data Guru
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
        $('.select2-search').select2({
            width: '100%',
            placeholder: "Ketik untuk mencari...",
            allowClear: false
        });
    });
</script>
@endpush