<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | {{ config('app.name', 'SaaS Admin') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Figtree', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>

<body class="font-sans text-gray-900 antialiased bg-white">

    <div class="flex min-h-screen">

        <div class="hidden lg:flex lg:w-1/2 bg-indigo-600 justify-center items-center relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 to-indigo-900 opacity-90"></div>
            
            <div class="relative z-10 flex flex-col items-center text-center px-12">
                <svg class="h-24 w-24 text-white mb-6 drop-shadow-md" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                <h1 class="text-4xl font-bold text-white mb-4 tracking-tight">
                    {{ config('app.name', 'SaaS Admin') }}
                </h1>
                <p class="text-indigo-200 text-lg font-medium leading-relaxed max-w-md">
                    Sistem Manajemen Pembelajaran terintegrasi. Kelola kelas, siswa, dan materi dengan lebih efisien.
                </p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center bg-gray-50 px-6 py-12 lg:px-12 relative">
            
            <div class="w-full sm:max-w-md">
                
                <div class="lg:hidden flex flex-col items-center gap-2 mb-8">
                    <svg class="h-16 w-16 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <span class="text-2xl font-bold text-gray-800 tracking-tight">{{ config('app.name', 'SaaS Admin') }}</span>
                </div>

                <div class="mb-8 text-center lg:text-left">
                    <h2 class="text-3xl font-bold text-gray-900">Selamat Datang</h2>
                    <p class="text-sm text-gray-500 mt-2">Silakan log in ke akun Anda untuk melanjutkan.</p>
                </div>

                <div class="bg-white px-8 py-10 shadow-sm border border-gray-100 sm:rounded-xl">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div>
                            <label for="email" class="block font-medium text-sm text-gray-700">
                                Email
                            </label>
                            <input id="email"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5 px-3 border outline-none transition-colors"
                                type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                placeholder="admin@example.com">
                        </div>

                        <div class="mt-5">
                            <label for="password" class="block font-medium text-sm text-gray-700">
                                Password
                            </label>
                            <input id="password"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5 px-3 border outline-none transition-colors"
                                type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                        </div>

                        <div class="flex items-center justify-between mt-5">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 h-4 w-4 cursor-pointer"
                                    name="remember">
                                <span class="ms-2 text-sm text-gray-600 cursor-pointer">Ingat saya</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-sm text-indigo-600 hover:text-indigo-900 font-medium transition-colors"
                                    href="{{ route('password.request') }}">
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        <div class="mt-8">
                            <button type="submit"
                                class="w-full flex justify-center items-center px-4 py-2.5 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150 shadow-sm">
                                Log in
                            </button>
                        </div>
                    </form>
                </div>

                <div class="mt-8 text-center text-sm text-gray-500">
                    &copy; {{ date('Y') }} {{ config('app.name', 'SaaS Admin') }}. Hak Cipta Dilindungi.
                </div>

            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            // Konfigurasi Default
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "4000",
            };

            // Menangkap Session Flash dari Controller
            @if (session('success'))
                toastr.success("{{ session('success') }}", "Berhasil!");
            @endif

            @if (session('error'))
                toastr.error("{{ session('error') }}", "Terjadi Kesalahan");
            @endif

            @if (session('info'))
                toastr.info("{{ session('info') }}", "Informasi");
            @endif

            // Menangkap Error Validasi Auth bawaan Laravel (contoh: Kredensial salah)
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    toastr.error("{{ $error }}", "Peringatan");
                @endforeach
            @endif
        });
    </script>

</body>
</html>