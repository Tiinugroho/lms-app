<header
    class="flex h-16 shrink-0 items-center justify-between border-b border-gray-100 bg-white/80 backdrop-blur-md px-4 sm:px-6 lg:px-8 z-10 sticky top-0">
    <div class="flex items-center gap-4">
        <button id="openSidebar" class="lg:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <div class="hidden sm:flex items-center text-sm text-gray-500 capitalize">
            @php
                $segments = request()->segments();
            @endphp
            
            @forelse($segments as $index => $segment)
                @if($index > 0)
                    <span class="mx-2">/</span>
                @endif
                
                @php
                    // Membersihkan tanda strip ('-') pada URL menjadi spasi
                    $cleanSegment = ucwords(str_replace('-', ' ', $segment));
                @endphp

                @if($loop->last)
                    <span class="font-medium text-gray-900">{{ $cleanSegment }}</span>
                @else
                    <span>{{ $cleanSegment }}</span>
                @endif
            @empty
                <span class="font-medium text-gray-900">Dashboard</span>
            @endforelse
        </div>
    </div>

    <div class="flex items-center gap-4 relative">

        <div class="relative">
            <button id="profileBtn"
                class="flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-indigo-600 focus:outline-none transition">
                {{ Auth::user()->name ?? 'Administrator' }}
                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>

            <div id="profileDropdown"
                class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-100 ring-1 ring-black ring-opacity-5">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Saya</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pengaturan</a>
                <div class="border-t border-gray-100 my-1"></div>
                
                <button type="button" id="triggerLogout"
                    class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                    Log Out
                </button>
            </div>
        </div>
    </div>
</header>

<div id="logoutModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden">
    <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"></div>
    
    <div class="bg-white rounded-xl shadow-2xl transform transition-all sm:max-w-md w-full mx-4 z-10 p-6 border border-gray-100">
        <div class="flex items-center gap-4 mb-4">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:h-10 sm:w-10">
                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Konfirmasi Logout</h3>
        </div>
        
        <p class="text-sm text-gray-500 mb-6 pl-14">Apakah Anda yakin ingin keluar dari aplikasi? Anda harus login kembali untuk mengakses sistem.</p>
        
        <div class="flex justify-end gap-3">
            <button id="cancelLogout" type="button" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 text-sm transition">
                Batal
            </button>
            
            <button id="confirmLogout" type="button" class="px-4 py-2 bg-red-600 border border-transparent rounded-md font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 text-sm shadow-sm transition">
                Ya, Keluar
            </button>
        </div>
    </div>
</div>

<form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
    @csrf
</form>