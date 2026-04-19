@php
    // Memanggil helper pengaturan website
    $webSetting = \App\Models\Setting::getSetting();
@endphp

<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-30 w-64 transform -translate-x-full overflow-y-auto bg-white border-r border-gray-100 transition-transform duration-300 lg:relative lg:translate-x-0 shrink-0 shadow-sm flex flex-col">
    
    <div class="flex h-16 items-center justify-between px-6 border-b border-gray-100 shrink-0 sticky top-0 bg-white z-10">
        <a href="#" class="flex items-center gap-2 font-bold text-xl text-gray-800">
            <img src="{{ $webSetting->logo_url }}" alt="Logo" class="h-8 w-8 object-contain">
            
            <span class="tracking-tight">{{ $webSetting->app_short_name }}</span>
        </a>
        <button id="closeSidebar" class="lg:hidden text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <nav class="flex-1 p-4 space-y-6 overflow-y-auto">
        
        {{-- ========================== MENU ADMIN ========================== --}}
        @if(auth()->user()->hasRole(['super-admin', 'admin-sekolah']))
            
            <div>
                <div class="mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider px-3">Menu Utama</div>
                <div class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200 
                        {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('admin.dashboard') ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        Dashboard Admin
                    </a>
                </div>
            </div>

            @canany(['academic_years-index', 'classrooms-index', 'subjects-index'])
            <div>
                <div class="mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider px-3 flex items-center gap-2">
                    Master Data
                </div>
                <div class="space-y-1">
                    @can('academic_years-index')
                    <a href="{{ route('admin.academic-years.index') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-all duration-200 
                        {{ request()->routeIs('admin.academic-years.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('admin.academic-years.*') ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                        Tahun Akademik
                    </a>
                    @endcan
                    
                    @can('classrooms-index')
                    <a href="{{ route('admin.classrooms.index') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-all duration-200 
                        {{ request()->routeIs('admin.classrooms.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('admin.classrooms.*') ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                        </svg>
                        Manajemen Kelas
                    </a>
                    @endcan

                    @can('subjects-index')
                    <a href="{{ route('admin.subjects.index') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-all duration-200 
                        {{ request()->routeIs('admin.subjects.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('admin.subjects.*') ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                        Mata Pelajaran
                    </a>
                    @endcan
                </div>
            </div>
            @endcanany

            @canany(['teachers-index', 'students-index', 'roles-index'])
            <div>
                <div class="mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider px-3">User Management</div>
                <div class="space-y-1">
                    @can('teachers-index')
                    <a href="{{ route('admin.teachers.index') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-all duration-200 
                        {{ request()->routeIs('admin.teachers.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('admin.teachers.*') ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                        Data Guru
                    </a>
                    @endcan

                    @can('staffs-index')
                    <a href="{{ route('admin.staffs.index') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-all duration-200 
                        {{ request()->routeIs('admin.staffs.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('admin.staffs.*') ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                        Data Staff
                    </a>
                    @endcan

                    @can('students-index')
                    <a href="{{ route('admin.students.index') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-all duration-200 
                        {{ request()->routeIs('admin.students.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('admin.students.*') ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                        </svg>
                        Data Siswa
                    </a>
                    @endcan

                    
                </div>
            </div>
            @endcanany

            @if(auth()->user()->hasRole('super-admin'))
            <div>
                <div class="mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider px-3">Sistem</div>
                <div class="space-y-1">
                    @can('roles-index')
                    <a href="{{ route('admin.roles.index') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-all duration-200
                        {{ request()->routeIs('admin.roles.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('admin.roles.*') ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                        Roles & Permissions
                    </a>
                    @endcan

                    <a href="{{ route('admin.settings.index') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-all duration-200 
                        {{ request()->routeIs('admin.settings.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('admin.settings.*') ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Pengaturan Website
                    </a>
                    
                </div>
            </div>
            @endif

        @endif

        {{-- ========================== MENU GURU ========================== --}}
        @if(auth()->user()->hasRole('guru'))
            <div>
                <div class="mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider px-3">Menu Guru</div>
                <div class="space-y-1">
                    
                    <a href="{{ route('guru.dashboard') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200 
                        {{ request()->routeIs('guru.dashboard') ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('guru.dashboard') ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                        </svg>
                        Dashboard
                    </a>

                    <a href="#"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200 
                        text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                        </svg>
                        Data Siswaku
                    </a>
                </div>
            </div>
        @endif

        {{-- ========================== MENU SISWA ========================== --}}
        @if(auth()->user()->hasRole('siswa'))
            <div>
                <div class="mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider px-3">Menu Siswa</div>
                <div class="space-y-1">
                    
                    <a href="{{ route('siswa.dashboard') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200 
                        {{ request()->routeIs('siswa.dashboard') ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('siswa.dashboard') ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                        Dashboard
                    </a>
                </div>
            </div>
        @endif

    </nav>
</aside>