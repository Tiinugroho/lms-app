@extends('partials.app')
@section('title', 'Dashboard Admin')
@section('content')
    <main class="flex-1 pb-12 pt-8 relative">
        <div
            class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-indigo-50/50 to-transparent -z-10 pointer-events-none">
        </div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div
                    class="bg-white/60 backdrop-blur-md border border-white p-6 rounded-xl shadow-sm transition hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Pengguna</p>
                            <h3 class="mt-1 text-3xl font-bold text-gray-900">2,405</h3>
                        </div>
                        <div class="p-3 bg-indigo-50 text-indigo-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm text-green-600 font-medium">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        12% dari bulan lalu
                    </div>
                </div>

                <div
                    class="bg-white/60 backdrop-blur-md border border-white p-6 rounded-xl shadow-sm transition hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Pengguna Aktif</p>
                            <h3 class="mt-1 text-3xl font-bold text-gray-900">1,832</h3>
                        </div>
                        <div class="p-3 bg-green-50 text-green-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm text-gray-500">
                        Berdasarkan sesi 30 hari terakhir
                    </div>
                </div>

                <div
                    class="bg-white/60 backdrop-blur-md border border-white p-6 rounded-xl shadow-sm transition hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Menunggu Verifikasi</p>
                            <h3 class="mt-1 text-3xl font-bold text-gray-900">24</h3>
                        </div>
                        <div class="p-3 bg-amber-50 text-amber-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div
                        class="mt-4 flex items-center text-sm text-indigo-600 hover:text-indigo-800 cursor-pointer font-medium">
                        Tinjau sekarang &rarr;
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg border border-gray-100 p-6">
                <div class="overflow-x-auto">
                    <table id="myTable" class="w-full table table-bordered">
                        <thead class="">
                            <tr>
                                <th class="px-4 py-3">Nama</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">Role</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-4 py-3 font-medium text-gray-900">Muhammad Jati</td>
                                <td class="px-4 py-3">jati@example.com</td>
                                <td class="px-4 py-3">Super Admin</td>
                                <td class="px-4 py-3"><span
                                        class="px-2 py-1 bg-green-50 text-green-700 border border-green-200 rounded-md text-xs font-medium">Aktif</span>
                                </td>
                                <td class="px-4 py-3 text-right"><a href="#"
                                        class="text-indigo-600 hover:underline">Edit</a></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 font-medium text-gray-900">Budi Santoso</td>
                                <td class="px-4 py-3">budi@example.com</td>
                                <td class="px-4 py-3">Editor</td>
                                <td class="px-4 py-3"><span
                                        class="px-2 py-1 bg-green-50 text-green-700 border border-green-200 rounded-md text-xs font-medium">Aktif</span>
                                </td>
                                <td class="px-4 py-3 text-right"><a href="#"
                                        class="text-indigo-600 hover:underline">Edit</a></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 font-medium text-gray-900">Siti Aminah</td>
                                <td class="px-4 py-3">siti@example.com</td>
                                <td class="px-4 py-3">User</td>
                                <td class="px-4 py-3"><span
                                        class="px-2 py-1 bg-red-50 text-red-700 border border-red-200 rounded-md text-xs font-medium">Non-Aktif</span>
                                </td>
                                <td class="px-4 py-3 text-right"><a href="#"
                                        class="text-indigo-600 hover:underline">Edit</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
