@extends('partials.app')
@section('title', 'Dashboard Admin')

@section('content')
    <main class="flex-1 pb-12 pt-8 relative w-full">
        <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-indigo-50/50 to-transparent -z-10 pointer-events-none"></div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 w-full">

            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Dashboard Analytics</h2>
                <p class="text-sm text-gray-500 mt-1">Ringkasan aktivitas dan metrik pengguna LMS Anda.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white/60 backdrop-blur-md border border-white p-6 rounded-xl shadow-sm transition hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Pengguna</p>
                            <h3 class="mt-1 text-3xl font-bold text-gray-900">{{ number_format($totalUsers) }}</h3>
                        </div>
                        <div class="p-3 bg-indigo-50 text-indigo-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white/60 backdrop-blur-md border border-white p-6 rounded-xl shadow-sm transition hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Pengguna Aktif</p>
                            <h3 class="mt-1 text-3xl font-bold text-gray-900">{{ number_format($activeUsers) }}</h3>
                        </div>
                        <div class="p-3 bg-green-50 text-green-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white/60 backdrop-blur-md border border-white p-6 rounded-xl shadow-sm transition hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Akun Non-Aktif</p>
                            <h3 class="mt-1 text-3xl font-bold text-gray-900">{{ number_format($inactiveUsers) }}</h3>
                        </div>
                        <div class="p-3 bg-red-50 text-red-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="lg:col-span-1 bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6 flex flex-col">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-3">Distribusi Peran Pengguna</h3>
                    
                    @if(array_sum($chartData) > 0)
                        <div class="relative flex-1 flex items-center justify-center min-h-[300px]">
                            <canvas id="roleChart"></canvas>
                        </div>
                    @else
                        <div class="flex-1 flex flex-col items-center justify-center text-center py-10">
                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                            <p class="text-sm text-gray-500">Belum ada data pengguna untuk ditampilkan pada grafik.</p>
                        </div>
                    @endif
                </div>

                <div class="lg:col-span-2 bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-100 pb-3">Daftar Semua Pengguna</h3>
                    
                    <div class="overflow-x-auto w-full">
                        @if($users->count() > 0)
                            <table id="usersTable" class="w-full text-left border-collapse min-w-[600px]">
                                <thead>
                                    <tr class="border-b border-gray-200 text-sm font-semibold text-gray-600 bg-gray-50/50">
                                        <th class="px-4 py-3 whitespace-nowrap">Nama & Email</th>
                                        <th class="px-4 py-3 whitespace-nowrap">Role</th>
                                        <th class="px-4 py-3 whitespace-nowrap">Status</th>
                                        <th class="px-4 py-3 text-right whitespace-nowrap">Terdaftar Pada</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($users as $user)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-4 py-3">
                                                <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex flex-wrap gap-1">
                                                    @forelse($user->roles as $role)
                                                        <span class="px-2.5 py-0.5 bg-indigo-50 text-indigo-700 border border-indigo-100 rounded-md text-[11px] font-bold tracking-wider uppercase">
                                                            {{ str_replace('-', ' ', $role->name) }}
                                                        </span>
                                                    @empty
                                                        <span class="text-xs text-gray-400 italic">No Role</span>
                                                    @endforelse
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                @if($user->is_active)
                                                    <span class="px-2 py-1 bg-green-50 text-green-700 border border-green-200 rounded-md text-xs font-medium">Aktif</span>
                                                @else
                                                    <span class="px-2 py-1 bg-red-50 text-red-700 border border-red-200 rounded-md text-xs font-medium">Non-Aktif</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-right text-sm text-gray-500 whitespace-nowrap">
                                                {{ $user->created_at->format('d M Y') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center py-12">
                                <p class="text-gray-500 text-sm">Belum ada data pengguna di dalam sistem.</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    $(document).ready(function() {
        // Inisialisasi DataTable untuk tabel pengguna
        if ($('#usersTable').length) {
            $('#usersTable').DataTable({
                "language": {},
                "pagingType": "simple_numbers",
                "lengthMenu": [5, 10, 25],
                "pageLength": 5 // Tampilkan 5 baris saja sebagai default agar Dashboard tidak terlalu panjang
            });
        }

        // Inisialisasi Chart.js (Hanya jika ada data)
        @if(array_sum($chartData) > 0)
            const ctx = document.getElementById('roleChart').getContext('2d');
            
            // Melempar data dari Controller PHP ke JavaScript
            const chartLabels = @json($chartLabels);
            const chartData = @json($chartData);

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        data: chartData,
                        backgroundColor: [
                            '#4f46e5', // Indigo 600
                            '#0ea5e9', // Indigo-like blue
                            '#f59e0b', // Amber 500
                            '#10b981', // Emerald 500
                            '#8b5cf6'  // Violet
                        ],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                font: {
                                    family: "'Figtree', sans-serif",
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(17, 24, 39, 0.9)',
                            padding: 12,
                            titleFont: { family: "'Figtree', sans-serif", size: 13 },
                            bodyFont: { family: "'Figtree', sans-serif", size: 13 },
                            cornerRadius: 8,
                        }
                    },
                    cutout: '65%' // Membuat lubang donat sedikit lebih besar agar estetik
                }
            });
        @endif
    });
</script>
@endpush