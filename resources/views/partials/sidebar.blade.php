<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-30 w-64 transform -translate-x-full overflow-y-auto bg-white border-r border-gray-100 transition-transform duration-300 lg:relative lg:translate-x-0 shrink-0">
    
    <div class="flex h-16 items-center justify-between px-6 border-b border-gray-100">
        <a href="#" class="flex items-center gap-2 font-bold text-xl text-gray-800">
            <svg class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            <span>{{ config('app.name', 'Laravel') }}</span>
        </a>
        <button id="closeSidebar" class="lg:hidden text-gray-500 hover:text-gray-700">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <nav class="p-4 space-y-2">
        
        {{-- ========================== MENU ADMIN ========================== --}}
        @if(auth()->user()->hasRole(['super-admin', 'admin-sekolah']))
            <div class="pb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider px-3">Menu Admin</div>
            
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium transition-colors 
                {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="h-5 w-5 {{ request()->routeIs('admin.dashboard') ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                Dashboard
            </a>

            <a href="{{ route('admin.teachers.index') }}"
                class="flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium transition-colors 
                {{ request()->routeIs('admin.teachers.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="h-5 w-5 {{ request()->routeIs('admin.teachers.*') ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
                Manajemen Guru
            </a>

            <a href="{{ route('admin.classrooms.index') }}"
                class="flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium transition-colors 
                {{ request()->routeIs('admin.classrooms.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="h-5 w-5 {{ request()->routeIs('admin.classrooms.*') ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                </svg>
                Manajemen Kelas
            </a>

            <a href="{{ route('admin.subjects.index') }}"
                class="flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium transition-colors 
                {{ request()->routeIs('admin.subjects.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="h-5 w-5 {{ request()->routeIs('admin.subjects.*') ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
                Mata Pelajaran
            </a>

            <a href="{{ route('admin.academic-years.index') }}"
                class="flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium transition-colors 
                {{ request()->routeIs('admin.academic-years.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="h-5 w-5 {{ request()->routeIs('admin.academic-years.*') ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                </svg>
                Tahun Akademik
            </a>
        @endif

        {{-- ========================== MENU GURU ========================== --}}
        @if(auth()->user()->hasRole('guru'))
            <div class="pb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider px-3">Menu Guru</div>
            
            <a href="{{ route('guru.dashboard') }}"
                class="flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium transition-colors 
                {{ request()->routeIs('guru.dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="h-5 w-5 {{ request()->routeIs('guru.dashboard') ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                </svg>
                Dashboard
            </a>

            <a href="{{ route('guru.students.index') }}"
                class="flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium transition-colors 
                {{ request()->routeIs('guru.students.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="h-5 w-5 {{ request()->routeIs('guru.students.*') ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                </svg>
                Data Siswa
            </a>
        @endif

        {{-- ========================== MENU SISWA ========================== --}}
        @if(auth()->user()->hasRole('siswa'))
            <div class="pb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider px-3">Siswa</div>
            
            <a href="{{ route('siswa.dashboard') }}"
                class="flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium transition-colors 
                {{ request()->routeIs('siswa.dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="h-5 w-5 {{ request()->routeIs('siswa.dashboard') ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                Dashboard
            </a>
        @endif

    </nav>
</aside>