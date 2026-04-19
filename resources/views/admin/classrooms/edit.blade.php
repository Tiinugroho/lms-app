@extends('partials.app')
@section('title', 'Edit Kelas')

@section('content')
    <main class="flex-1 pb-12 pt-8 relative w-full">
        <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-indigo-50/50 to-transparent -z-10 pointer-events-none"></div>

        <div class="mx-auto max-w-8xl px-4 sm:px-6 lg:px-8 w-full">
            <div class="mb-8">
                <a href="{{ route('admin.classrooms.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 flex items-center gap-1 mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
                <h2 class="text-2xl font-bold text-gray-900">Edit Data Kelas</h2>
                <p class="text-sm text-gray-500 mt-1">Perbarui informasi kelas di bawah ini.</p>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg border border-gray-100 p-6 sm:p-8 w-full">
                <form action="{{ route('admin.classrooms.update', $classroom->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Kelas <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $classroom->name) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2 border">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="level" class="block text-sm font-medium text-gray-700">Tingkat Kelas <span class="text-red-500">*</span></label>
                            <select name="level" id="level" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2 border">
                                <option value="" disabled>-- Pilih Tingkat --</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ old('level', $classroom->level) == $i ? 'selected' : '' }}>Kelas {{ $i }}</option>
                                @endfor
                            </select>
                            @error('level')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="homeroom_teacher_id" class="block text-sm font-medium text-gray-700">Wali Kelas (Opsional)</label>
                            <select name="homeroom_teacher_id" id="homeroom_teacher_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2 border">
                                <option value="">-- Tidak ada Wali Kelas --</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ old('homeroom_teacher_id', $classroom->homeroom_teacher_id) == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->user->name ?? 'User Tidak Diketahui' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('homeroom_teacher_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-3">
                        <a href="{{ route('admin.classrooms.index') }}" class="px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Batal
                        </a>
                        <button type="submit" class="px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Perbarui Kelas
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection