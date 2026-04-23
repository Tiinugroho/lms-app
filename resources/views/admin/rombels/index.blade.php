@extends('partials.app')
@section('title', 'Manajemen Rombongan Belajar')

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
    <main class="flex-1 pb-12 pt-8 relative w-full">
        <div
            class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-indigo-50/50 to-transparent -z-10 pointer-events-none">
        </div>

        <div class="mx-auto max-w-[90rem] px-4 sm:px-6 lg:px-8 w-full space-y-8">

            <div>
                <div class="mb-4">
                    <h2 class="text-2xl font-bold text-gray-900">Manajemen Rombel (Kelas)</h2>
                    <p class="text-sm text-gray-500 mt-1">Atur penempatan siswa ke dalam kelas berdasarkan Tahun Akademik.
                    </p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8">
                    <form action="{{ route('admin.rombels.index') }}" method="GET"
                        class="flex flex-col md:flex-row md:items-end gap-6">
                        <div class="w-full md:w-5/12">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Tahun Ajaran</label>
                            <select name="academic_year_id" class="select2 w-full text-sm">
                                @foreach ($academicYears as $year)
                                    <option value="{{ $year->id }}"
                                        {{ $selectedYearId == $year->id ? 'selected' : '' }}>
                                        {{ $year->period }} - Semester {{ $year->semester }}
                                        {{ $year->is_active ? '(Aktif)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full md:w-5/12">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Kelas</label>
                            <select name="classroom_id" required class="select2 w-full text-sm">
                                <option value="">-- Cari dan Pilih Kelas --</option>
                                @foreach ($classrooms as $class)
                                    <option value="{{ $class->id }}"
                                        {{ $selectedClassroomId == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }} (Tingkat {{ $class->level }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full md:w-2/12 shrink-0">
                            <button type="submit"
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-sm transition h-[42px] flex items-center justify-center">
                                Tampilkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            @if (session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-md shadow-sm flex items-center">
                    <svg class="h-5 w-5 text-emerald-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-md shadow-sm">
                    <p class="text-sm font-medium text-red-800">{{ $errors->first() }}</p>
                </div>
            @endif

            @if ($selectedYearId && $selectedClassroomId)
                <div class="flex items-center gap-3 bg-indigo-50/50 border border-indigo-100 p-4 rounded-xl">
                    <h2 class="text-lg font-bold text-indigo-900 flex items-center gap-2">
                        Kelas: {{ $selectedClass->name }}
                        <span
                            class="px-2.5 py-0.5 rounded-full bg-indigo-100 text-indigo-800 text-[10px] font-bold uppercase tracking-wider border border-indigo-200">Tingkat
                            {{ $selectedClass->level }}</span>
                    </h2>
                    <span class="text-gray-400">|</span>
                    <p class="text-sm text-gray-700 font-medium">Tahun Ajaran: <span
                            class="text-indigo-600 font-bold">{{ $selectedYear->period }}
                            ({{ $selectedYear->semester }})</span></p>
                </div>

                <div class="flex flex-col lg:flex-row gap-6">

                    <div class="w-full lg:w-4/12 bg-white shadow-sm sm:rounded-xl border border-gray-200 flex flex-col h-[750px]">
                        <div class="p-5 border-b border-gray-100 bg-gray-50/80 rounded-t-xl shrink-0">
                            <div class="flex justify-between items-center mb-3">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Siswa Belum Terdaftar</h3>
                                    <p class="text-[11px] text-gray-500 mt-0.5">Daftar siswa yang menganggur di sistem.</p>
                                </div>
                                <span class="bg-gray-200 text-gray-700 py-1 px-3 rounded-full text-xs font-bold">{{ $unplacedStudents->count() }} Siswa</span>
                            </div>

                            <div class="relative mt-2">
                                <input type="text" id="searchUnassigned" placeholder="Cari nama atau NIS..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition">
                                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="bg-blue-50/50 border-b border-blue-100 p-4 shrink-0">
                            <div class="flex gap-3 items-start">
                                <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-[11px] text-blue-800 leading-relaxed font-medium">
                                    Panel ini memuat siswa baru atau siswa mutasi yang baru saja ditambahkan oleh Admin. Gunakan panel ini untuk memasukkan mereka ke kelas di pertengahan semester.
                                </p>
                            </div>
                        </div>

                        <form action="{{ route('admin.rombels.store') }}" method="POST"
                            class="flex flex-col flex-1 overflow-hidden">
                            @csrf
                            <input type="hidden" name="academic_year_id" value="{{ $selectedYearId }}">
                            <input type="hidden" name="classroom_id" value="{{ $selectedClassroomId }}">

                            <div class="flex-1 overflow-y-auto p-4 bg-gray-50/30" id="unassignedListContainer">
                                @if ($unplacedStudents->count() > 0)
                                    <ul class="space-y-2">
                                        <li
                                            class="pl-4 pb-3 border-b border-gray-200 mb-3 sticky top-0 bg-gray-50/90 backdrop-blur z-10 py-1">
                                            <label class="flex items-center cursor-pointer group">
                                                <input type="checkbox" id="selectAllUnassigned"
                                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 h-4 w-4 transition cursor-pointer">
                                                <span
                                                    class="ml-3 text-sm font-bold text-gray-700 group-hover:text-indigo-600 transition">Pilih
                                                    Semua (Yang Tampil)</span>
                                            </label>
                                        </li>

                                        @foreach ($unplacedStudents as $student)
                                            <li class="student-item" data-name="{{ strtolower($student->user->name) }}"
                                                data-nis="{{ strtolower($student->nis) }}">
                                                <label
                                                    class="flex items-center p-3 w-full bg-white border border-gray-200 rounded-xl cursor-pointer hover:bg-indigo-50 hover:border-indigo-200 transition shadow-sm student-label">
                                                    <input type="checkbox" name="student_ids[]" value="{{ $student->id }}"
                                                        class="student-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 h-5 w-5 transition cursor-pointer">
                                                    <img src="{{ $student->user->avatar ? Storage::url($student->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($student->user->name) . '&background=E0E7FF&color=4338CA' }}"
                                                        class="w-9 h-9 rounded-full ml-3 object-cover border border-gray-200 shrink-0">
                                                    <div class="ml-3 overflow-hidden">
                                                        <p class="text-sm font-bold text-gray-900 truncate">
                                                            {{ $student->user->name }}</p>
                                                        <p class="text-xs text-gray-500 truncate">NIS: {{ $student->nis }}
                                                            | {{ $student->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                                    </div>
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div id="noResultFound"
                                        class="hidden flex-col items-center justify-center py-10 text-center">
                                        <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                            </path>
                                        </svg>
                                        <p class="text-sm text-gray-500">Siswa tidak ditemukan.</p>
                                    </div>
                                @else
                                    <div class="flex flex-col items-center justify-center h-full text-center p-6">
                                        <div
                                            class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-bold text-gray-900">Tidak ada siswa yang menganggur.</p>
                                        <p class="text-[11px] text-gray-500 mt-2 max-w-[200px] leading-relaxed">
                                            Seluruh siswa di sistem sudah memiliki kelas. Nama siswa baru atau mutasi akan otomatis muncul di sini.
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <div class="p-5 border-t border-gray-200 bg-white rounded-b-xl shrink-0">
                                <button type="submit" id="btnSubmitPlotting" disabled
                                    class="w-full flex items-center justify-center gap-2 py-3 px-4 border border-transparent shadow-sm text-sm font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 disabled:bg-indigo-300 disabled:cursor-not-allowed transition">
                                    Masukkan ke Kelas &rarr;
                                </button>
                            </div>
                        </form>
                    </div>

                    <div
                        class="w-full lg:w-8/12 bg-white shadow-sm sm:rounded-xl border border-gray-200 flex flex-col h-[750px] relative">
                        <div
                            class="p-5 border-b border-gray-100 bg-indigo-50/50 rounded-t-xl flex justify-between items-center shrink-0">
                            <div>
                                <h3 class="text-lg font-bold text-indigo-900">Anggota Kelas Saat Ini</h3>
                                <p class="text-xs text-indigo-600 mt-0.5">Daftar siswa yang menempati kelas
                                    {{ $selectedClass->name }}</p>
                            </div>
                            <span
                                class="bg-indigo-600 text-white py-1 px-3 rounded-full text-xs font-bold shadow-sm">{{ $students->count() }}
                                Terdaftar</span>
                        </div>

                        <div class="flex-1 overflow-y-auto p-4 bg-white">
                            <div class="w-full">
                                <table id="enrolledTable" class="w-full text-left border-collapse">
                                    <thead>
                                        <tr
                                            class="border-b border-gray-200 text-xs font-semibold text-gray-500 uppercase tracking-wider bg-gray-50">
                                            <th class="px-4 py-3 w-10 text-center">No</th>
                                            <th class="px-4 py-3">Nama Siswa</th>
                                            <th class="px-4 py-3">NIS</th>
                                            <th class="px-4 py-3 text-center">L/P</th>
                                            <th class="px-4 py-3 text-right w-20">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach ($students as $history)
                                            <tr class="hover:bg-gray-50 transition group">
                                                <td class="px-4 py-4 text-sm text-gray-500 text-center">
                                                    {{ $loop->iteration }}</td>
                                                <td class="px-4 py-4">
                                                    <div class="flex items-center gap-3">
                                                        <img src="{{ $history->student->user->avatar ? Storage::url($history->student->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($history->student->user->name) . '&background=DBEAFE&color=1D4ED8' }}"
                                                            class="w-9 h-9 rounded-full object-cover border border-gray-200 shrink-0">
                                                        <div>
                                                            <p class="text-sm font-bold text-gray-900 truncate">
                                                                {{ $history->student->user->name }}</p>
                                                            <p class="text-[10px] font-medium text-gray-500">Status: <span
                                                                    class="{{ $history->status == 'Aktif' ? 'text-emerald-600' : 'text-amber-600' }} font-bold">{{ $history->status }}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4 text-sm font-medium text-gray-700">
                                                    {{ $history->student->nis }}</td>
                                                <td class="px-4 py-4 text-sm text-gray-700 text-center font-bold">
                                                    {{ $history->student->gender }}</td>
                                                <td class="px-4 py-4 text-right">
                                                    <form action="{{ route('admin.rombels.destroy', $history->id) }}"
                                                        method="POST" class="inline-block m-0">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="inline-flex items-center p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition shadow-sm tooltip btn-delete-plot"
                                                            title="Keluarkan dari kelas">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-3xl p-16 text-center shadow-sm border border-gray-200 border-dashed mt-8">
                    <svg class="mx-auto h-16 w-16 text-indigo-200" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-bold text-gray-900">Belum Ada Data Terpilih</h3>
                    <p class="mt-2 text-sm text-gray-500 max-w-md mx-auto">Silakan pilih <strong>Tahun Ajaran</strong> dan
                        <strong>Kelas</strong> pada filter di atas untuk melihat atau mengelola daftar siswa.</p>
                </div>
            @endif

            <div id="customDeleteModal" class="fixed inset-0 z-[100] hidden overflow-y-auto"
                aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity close-modal"
                        aria-hidden="true"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div
                        class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-bold text-gray-900">Keluarkan Siswa</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">Apakah Anda yakin ingin mengeluarkan siswa ini
                                            dari kelas? Siswa akan dikembalikan ke daftar "Belum Diplot".</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                            <button type="button" id="confirmDeleteAction"
                                class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2.5 bg-red-600 text-base font-bold text-white hover:bg-red-700 focus:outline-none sm:w-auto sm:text-sm">Ya,
                                Keluarkan</button>
                            <button type="button"
                                class="close-modal mt-3 sm:mt-0 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2.5 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none sm:w-auto sm:text-sm">Batal</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {

            // Inisialisasi Select2
            $('.select2').select2({
                width: '100%',
                placeholder: "-- Cari --",
                allowClear: false
            });

            // ================== INIT DATATABLE KANAN ==================
            const emptyEnrolledHTML = `
            <div class="flex flex-col items-center justify-center h-full text-center p-6 w-full">
                <div class="w-16 h-16 bg-indigo-50 rounded-full flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                </div>
                <p class="text-sm font-medium text-gray-900">Kelas masih kosong.</p>
                <p class="text-xs text-gray-500 mt-1">Pilih siswa di panel sebelah kiri lalu klik "Masukkan ke Kelas".</p>
            </div>
        `;

            if ($('#enrolledTable').length) {
                $('#enrolledTable').DataTable({
                    "language": {
                        "emptyTable": emptyEnrolledHTML,
                        "zeroRecords": "Siswa tidak ditemukan.",
                        "search": "Cari Anggota:"
                    },
                    "pagingType": "simple_numbers",
                    "lengthMenu": [10, 25, 50],
                    "pageLength": 25,
                    "columnDefs": [{
                            "orderable": false,
                            "targets": 4
                        },
                        {
                            "orderable": false,
                            "targets": 0
                        }
                    ]
                });
            }

            // ================== LOGIKA LIVE SEARCH KIRI ==================
            $('#searchUnassigned').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                var hasVisibleItems = false;

                $('.student-item').filter(function() {
                    var name = $(this).data('name');
                    var nis = $(this).data('nis');
                    var match = (name.indexOf(value) > -1 || String(nis).indexOf(value) > -1);

                    $(this).toggle(match);
                    if (match) hasVisibleItems = true;
                });

                if (hasVisibleItems) {
                    $('#noResultFound').addClass('hidden').removeClass('flex');
                } else {
                    $('#noResultFound').removeClass('hidden').addClass('flex');
                }

                $('#selectAllUnassigned').prop('checked', false);
            });

            // ================== LOGIKA CEKLIST SISWA KIRI ==================
            $('#selectAllUnassigned').on('change', function() {
                var isChecked = $(this).prop('checked');
                $('.student-item:visible .student-checkbox').prop('checked', isChecked);
                if (!isChecked) {
                    $('.student-checkbox').prop('checked', false);
                }
                updateRowStyle();
                checkSubmitButton();
            });

            $(document).on('change', '.student-checkbox', function() {
                updateRowStyle();
                checkSubmitButton();

                var visibleCheckboxes = $('.student-item:visible .student-checkbox').length;
                var visibleChecked = $('.student-item:visible .student-checkbox:checked').length;

                if (visibleCheckboxes > 0 && visibleChecked === visibleCheckboxes) {
                    $('#selectAllUnassigned').prop('checked', true);
                } else {
                    $('#selectAllUnassigned').prop('checked', false);
                }
            });

            function updateRowStyle() {
                $('.student-checkbox').each(function() {
                    if ($(this).is(':checked')) {
                        $(this).closest('label').addClass(
                            'bg-indigo-50 border-indigo-300 ring-2 ring-indigo-500/20');
                    } else {
                        $(this).closest('label').removeClass(
                            'bg-indigo-50 border-indigo-300 ring-2 ring-indigo-500/20');
                    }
                });
            }

            function checkSubmitButton() {
                var totalChecked = $('.student-checkbox:checked').length;
                if (totalChecked > 0) {
                    $('#btnSubmitPlotting').prop('disabled', false);
                    $('#btnSubmitPlotting').html(`Masukkan ${totalChecked} Siswa ke Kelas &rarr;`);
                } else {
                    $('#btnSubmitPlotting').prop('disabled', true);
                    $('#btnSubmitPlotting').html(`Masukkan ke Kelas &rarr;`);
                }
            }

            // ================== LOGIKA MODAL KELUARKAN SISWA ==================
            let formToSubmitPlot = null;
            $(document).on('click', '.btn-delete-plot', function(e) {
                e.preventDefault();
                formToSubmitPlot = $(this).closest('form');
                $('#customDeleteModal').removeClass('hidden');
            });

            $('#confirmDeleteAction').on('click', function() {
                if (formToSubmitPlot) {
                    formToSubmitPlot.submit();
                }
            });

            $('.close-modal').on('click', function() {
                $('#customDeleteModal').addClass('hidden');
                formToSubmitPlot = null;
            });
        });
    </script>
@endpush