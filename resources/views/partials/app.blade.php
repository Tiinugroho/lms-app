<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | LMS</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            darkMode: 'class', // Mematikan dark mode otomatis (media query)
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Figtree', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.tailwindcss.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }

        #preloader {
            transition: opacity 0.5s ease-out, visibility 0.5s ease-out;
        }

        /* Override DataTables Styles untuk Tabel Bersih & Bergaris */
        table.dataTable {
            border-collapse: collapse !important;
            border: 1px solid #e5e7eb !important;
        }

        table.dataTable tbody tr,
        table.dataTable tbody tr.odd,
        table.dataTable tbody tr.even,
        table.dataTable tbody td {
            background-color: transparent !important;
            border: 1px solid #e5e7eb !important;
        }

        table.dataTable thead th {
            background-color: #f9fafb !important;
            border: 1px solid #e5e7eb !important;
            border-bottom-width: 2px !important;
            color: #374151 !important;
            font-weight: 600 !important;
        }

        table.dataTable tbody tr:hover,
        table.dataTable tbody tr:hover td,
        table.dataTable tbody tr.odd:hover td,
        table.dataTable tbody tr.even:hover td {
            background-color: #f3f4f6 !important;
        }

        .dt-search input,
        .dt-length select {
            border-radius: 0.375rem !important;
            border-color: #e5e7eb !important;
            font-size: 0.875rem !important;
            background-color: white !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        }

        /* 2. Paksa Pagination Menjadi Putih & Matikan Efek Dark Mode Bawaan DataTables */
        div.dt-container div.dt-paging nav a {
            background-color: #ffffff !important;
            color: #4b5563 !important;
            /* Teks abu-abu */
            border-color: #e5e7eb !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        }

        /* Saat tombol pagination di-hover */
        div.dt-container div.dt-paging nav a:hover {
            background-color: #f9fafb !important;
            /* Abu-abu sangat terang */
            color: #111827 !important;
        }

        /* Saat tombol pagination menunjukkan halaman aktif saat ini */
        div.dt-container div.dt-paging nav a[aria-current="page"] {
            background-color: #f3f4f6 !important;
            /* Background abu-abu aktif (gray-100) */
            color: #111827 !important;
            /* Teks gelap tegas */
            font-weight: 600 !important;
            border-color: #d1d5db !important;
        }

        /* Jika tombol disable (seperti tombol 'Previous' di halaman 1) */
        div.dt-container div.dt-paging nav a[aria-disabled="true"] {
            opacity: 0.5 !important;
            cursor: not-allowed !important;
            background-color: #ffffff !important;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-gray-100 text-gray-900 antialiased overflow-hidden">

    <div id="preloader" class="fixed inset-0 z-[100] flex items-center justify-center bg-white">
        <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-b-4 border-indigo-600"></div>
    </div>

    <div class="flex h-screen overflow-hidden relative">
        <div id="sidebarOverlay"
            class="fixed inset-0 z-20 bg-gray-900 bg-opacity-50 hidden transition-opacity lg:hidden"></div>

        @include('admin.partials.sidebar')

        <div class="flex flex-1 flex-col overflow-y-auto">
            @include('admin.partials.header')
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.tailwindcss.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(window).on('load', function() {
            $('#preloader').css({
                'opacity': '0',
                'visibility': 'hidden'
            });
            $('body').removeClass('overflow-hidden');
        });

        $(document).ready(function() {
            // Konfigurasi Umum Toastr
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "4000",
            };

            // Inisialisasi DataTable & Hapus Class Hitam Tailwind bawaan
            $('#myTable').DataTable({
                "language": {
                    // "url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json"
                },
                "pagingType": "simple_numbers",
                "lengthMenu": [5, 10, 25, 50],

            });

            // Logika UI Bawaan (Sidebar & Dropdown)
            $('#profileBtn').click(function(e) {
                e.stopPropagation();
                $('#profileDropdown').toggleClass('hidden');
            });

            $(document).click(function(e) {
                if (!$(e.target).closest('#profileDropdown, #profileBtn').length) {
                    $('#profileDropdown').addClass('hidden');
                }
            });

            $('#openSidebar').click(function() {
                $('#sidebar').removeClass('-translate-x-full');
                $('#sidebarOverlay').removeClass('hidden');
            });

            $('#closeSidebar, #sidebarOverlay').click(function() {
                $('#sidebar').addClass('-translate-x-full');
                $('#sidebarOverlay').addClass('hidden');
            });

            // Logika untuk menampilkan Modal Logout
            $('#triggerLogout').click(function(e) {
                e.preventDefault();
                $('#profileDropdown').addClass('hidden'); // Tutup dropdown profil
                $('#logoutModal').removeClass('hidden'); // Tampilkan modal konfirmasi
            });

            // Logika untuk tombol Batal
            $('#cancelLogout').click(function() {
                $('#logoutModal').addClass('hidden'); // Sembunyikan modal
            });

            // Logika untuk tombol Ya, Keluar
            $('#confirmLogout').click(function() {
                // Eksekusi submit pada form hidden Laravel
                $('#logout-form').submit();
            });
        });
    </script>

    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}", "Berhasil!");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}", "Terjadi Kesalahan");
        @endif

        @if (session('info'))
            toastr.info("{{ session('info') }}", "Informasi");
        @endif
    </script>

    @stack('scripts')
</body>

</html>
