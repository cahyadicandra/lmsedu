<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Asalink Edu</title>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    <!-- Compiled CSS + Alpine + Alpine Persist (via Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Anti-glitch: set sidebar width from localStorage BEFORE first paint -->
    <script>
        (function() {
            try {
                var open = JSON.parse(localStorage.getItem('_x_sidebarOpen'));
                if (open === null) open = true;
            } catch(e) { var open = true; }
            document.documentElement.setAttribute('data-sidebar', open ? 'open' : 'closed');
        })();
    </script>
    <style>
        :root { --sidebar-w: 16rem; }
        html[data-sidebar="open"]  #sidebar-el { width: 16rem; }
        html[data-sidebar="closed"] #sidebar-el { width: 5rem; }
        html[data-sidebar="open"]  #main-el    { padding-left: 16rem; }
        html[data-sidebar="closed"] #main-el   { padding-left: 5rem; }
        html[data-sidebar="open"]  #header-el  { left: 16rem; }
        html[data-sidebar="closed"] #header-el { left: 5rem; }
        [x-cloak] { display: none !important; }
        /* Sidebar font */
        .sidebar-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; font-weight: 500; }
        .sidebar-section { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 800; letter-spacing: 0.1em; text-transform: uppercase; }
        
        .sidebar-text-bg {
            background-color: #EBF0FA;
            border-radius: 20px 0 0 20px;
            position: absolute;
            left: 5rem;
            right: -2px; /* slight overflow to prevent seams */
            top: 2px;
            bottom: 2px;
            pointer-events: none;
        }
        .sidebar-text-bg::before,
        .sidebar-text-bg::after {
            content: '';
            position: absolute;
            right: 2px;
            width: 20px;
            height: 20px;
            background-color: transparent;
            pointer-events: none;
        }
        .sidebar-text-bg::before {
            top: -20px;
            border-bottom-right-radius: 20px;
            box-shadow: 10px 10px 0 10px #EBF0FA;
        }
        .sidebar-text-bg::after {
            bottom: -20px;
            border-top-right-radius: 20px;
            box-shadow: 10px -10px 0 10px #EBF0FA;
        }
    </style>
</head>
<body class="bg-canvas-bg text-on-surface antialiased"
      style="font-family: 'Plus Jakarta Sans', sans-serif;"
      x-data="{
          sidebarOpen: $persist(true),
          ready: false,
          toggleSidebar() {
              this.sidebarOpen = !this.sidebarOpen;
              document.documentElement.setAttribute('data-sidebar', this.sidebarOpen ? 'open' : 'closed');
          }
      }"
      x-init="$nextTick(() => { ready = true; })">

    <!-- SIDEBAR -->
    <aside
        id="sidebar-el"
        class="fixed left-0 top-0 bottom-0 z-50 flex flex-col justify-between overflow-hidden"
        style="background-color: #364699; box-shadow: 1px 0 8px rgba(0,0,0,0.08); border-top-right-radius: 2rem; border-bottom-right-radius: 2rem;"
        :style="{ width: sidebarOpen ? '16rem' : '5rem', transition: ready ? 'width 0.25s ease' : 'none' }"
    >
        <!-- Lighter blue strip on the left -->
        <div class="absolute left-0 top-0 bottom-0 w-20 z-0 pointer-events-none" style="background-color: #526bea;"></div>

        <div class="flex flex-col flex-1 min-h-0 overflow-hidden relative z-10">
            <!-- Logo -->
            <div class="h-16 flex items-center px-0 pt-2 whitespace-nowrap overflow-hidden">
                <div class="w-20 flex items-center justify-center flex-shrink-0">
                    <div class="w-8 h-8 rounded bg-white flex items-center justify-center shadow-sm">
                        <span class="material-symbols-outlined text-xl" style="color: #223f9f;">school</span>
                    </div>
                </div>
                <span class="font-bold text-white tracking-tight text-lg transition-opacity duration-200 whitespace-nowrap" style="padding-left: 0.75rem;"
                      x-show="sidebarOpen" x-transition:enter="transition-opacity duration-200"
                      x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                      x-transition:leave="transition-opacity duration-100"
                      x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                    Asalink Edu
                </span>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 flex flex-col overflow-y-auto overflow-x-hidden py-3 px-0 gap-0">
                @php
                    $role = auth()->user()->role ?? '';
                    
                    function renderNavLink($url, $pattern, $icon, $label, $isDashboard = false, $role = null) {
                        $isActive = request()->is($pattern);
                        $labelDisplay = $isDashboard && $role === 'Super Admin' ? 'Dashboard Admin' : $label;
                        $textStyle = $isActive ? 'color: #364699;' : '';
                        $textColor = $isActive ? 'font-bold' : 'text-white/75 group-hover:text-white font-medium';
                        $iconColor = $isActive ? 'text-white' : 'text-white/75 group-hover:text-white';
                        
                        $html = '<a href="'.url($url).'" class="relative flex items-center h-12 transition-all whitespace-nowrap group '.($isActive ? '' : 'hover:bg-white/5').'">';
                        
                        if ($isActive) {
                            $html .= '<div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-white rounded-r-md z-20"></div>';
                            $html .= '<div class="sidebar-text-bg z-0" x-show="sidebarOpen"></div>';
                        }
                        
                        $html .= '<div class="w-20 flex items-center justify-center flex-shrink-0 z-10">';
                        $html .= '<span class="material-symbols-outlined text-[22px] transition-transform '.$iconColor.' '.($isActive?'':'group-hover:scale-110').'">'.$icon.'</span>';
                        $html .= '</div>';
                        
                        $html .= '<div class="flex-1 overflow-hidden z-10 pr-4" style="padding-left: 1rem;" x-show="sidebarOpen">';
                        $html .= '<span class="sidebar-label transition-opacity duration-200 block truncate '.$textColor.'" style="'.$textStyle.'">'.$labelDisplay.'</span>';
                        $html .= '</div>';
                        
                        $html .= '</a>';
                        return $html;
                    }
                @endphp

                @php
                    $dashUrl = '/';
                    $dashPattern = '/';
                    if ($role === 'Wali Murid') {
                        $dashUrl = '/wali-murid/dashboard';
                        $dashPattern = 'wali-murid/dashboard*';
                    }
                @endphp
                {!! renderNavLink($dashUrl, $dashPattern, 'dashboard', 'Dashboard', true, $role) !!}

                @if($role === 'Super Admin')
                {!! renderNavLink('/data-sekolah', 'data-sekolah*', 'account_balance', 'Data Sekolah') !!}
                {!! renderNavLink('/manajemen-pengguna', 'manajemen-pengguna*', 'manage_accounts', 'Manajemen Pengguna') !!}

                @elseif($role === 'Admin Sekolah')
                {!! renderNavLink('/profil-sekolah', 'profil-sekolah*', 'account_balance', 'Data Sekolah') !!}
                {!! renderNavLink('/tahun-akademik', 'tahun-akademik*', 'calendar_today', 'Tahun Akademik') !!}
                {!! renderNavLink('/kelas', 'kelas*', 'meeting_room', 'Kelas / Rombel') !!}
                {!! renderNavLink('/mata-pelajaran', 'mata-pelajaran*', 'menu_book', 'Mata Pelajaran') !!}
                
                {!! renderNavLink('/data-guru', 'data-guru*', 'support_agent', 'Data Guru') !!}
                {!! renderNavLink('/data-siswa', 'data-siswa*', 'face', 'Data Siswa') !!}
                {!! renderNavLink('/data-wali-murid', 'data-wali-murid*', 'family_restroom', 'Data Wali Murid') !!}
                
                @elseif($role === 'Guru')
                {!! renderNavLink('/pertemuan', 'pertemuan*', 'calendar_month', 'Pertemuan') !!}
                {!! renderNavLink('/tugas', 'tugas*', 'assignment', 'Tugas') !!}
                {!! renderNavLink('/absensi', 'absensi*', 'how_to_reg', 'Absensi') !!}
                {!! renderNavLink('/nilai', 'nilai*', 'assignment_turned_in', 'Nilai') !!}
                {!! renderNavLink('/pesan', 'pesan*', 'sticky_note_2', 'Pesan') !!}
                
                @elseif($role === 'Siswa')
                {!! renderNavLink('/siswa/kelas', 'siswa/kelas*', 'meeting_room', 'Kelas Saya') !!}
                {!! renderNavLink('/siswa/materi', 'siswa/materi*', 'menu_book', 'Mata Pelajaran') !!}
                {!! renderNavLink('/siswa/tugas', 'siswa/tugas*', 'assignment', 'Tugas') !!}
                {!! renderNavLink('/siswa/nilai', 'siswa/nilai*', 'military_tech', 'Nilai') !!}
                {!! renderNavLink('/siswa/pesan', 'siswa/pesan*', 'sticky_note_2', 'Pesan') !!}
                
                @elseif($role === 'Wali Murid')
                {!! renderNavLink('/wali-murid/kehadiran', 'wali-murid/kehadiran*', 'fact_check', 'Kehadiran') !!}
                {!! renderNavLink('/wali-murid/nilai', 'wali-murid/nilai*', 'grade', 'Nilai') !!}
                {!! renderNavLink('/wali-murid/pesan', 'wali-murid/pesan*', 'sticky_note_2', 'Pesan') !!}
                {!! renderNavLink('/wali-murid/profil-anak', 'wali-murid/profil-anak*', 'face', 'Profil Anak') !!}
                @endif
            </nav>
        </div>

        <!-- Logout -->
        <div class="py-3 relative z-10">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full relative flex items-center h-12 text-white/75 hover:text-white hover:bg-white/5 transition-colors whitespace-nowrap group">
                    <div class="w-20 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-[22px] group-hover:text-white transition-transform group-hover:scale-110">logout</span>
                    </div>
                    <div class="flex-1 overflow-hidden pr-4 text-left" x-show="sidebarOpen">
                        <!-- Text removed by request -->
                    </div>
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN WRAPPER -->
    <div id="main-el"
         :style="{ paddingLeft: sidebarOpen ? '16rem' : '5rem', transition: ready ? 'padding-left 0.25s ease' : 'none' }">

        <!-- HEADER -->
        <header id="header-el"
                class="fixed top-0 right-0 h-16 z-40 flex items-center justify-between px-6"
                style="background: rgba(255,255,255,0.92); backdrop-filter: blur(16px); box-shadow: 0 1px 8px rgba(0,0,0,0.06);"
                :style="{ left: sidebarOpen ? '16rem' : '5rem', transition: ready ? 'left 0.25s ease' : 'none' }">
            <div class="flex items-center gap-4">
                <!-- Toggle -->
                <button @click="toggleSidebar()"
                        class="p-2 rounded-full hover:bg-gray-100 text-gray-500 transition-colors">
                    <span class="material-symbols-outlined text-xl">menu</span>
                </button>
            </div>

            <div class="flex items-center gap-4">
                <div class="relative" x-data="{ notifOpen: false }">
                    @php
                        $unreadMessages = \App\Models\Message::where('teacher_id', auth()->id())->where('is_read', false)->latest()->take(5)->get();
                        $unreadCount = $unreadMessages->count();
                    @endphp
                    <button @click="notifOpen = !notifOpen" @click.away="notifOpen = false" class="relative p-2 rounded-full text-gray-500 hover:bg-gray-100 transition-colors focus:outline-none">
                        <span class="material-symbols-outlined text-xl">notifications</span>
                        @if($unreadCount > 0)
                        <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 rounded-full bg-red-500 border-2 border-white"></span>
                        @endif
                    </button>

                    <!-- Dropdown Notifikasi -->
                    <div x-show="notifOpen" x-transition.opacity x-cloak
                         class="absolute right-0 mt-3 w-80 bg-surface-card rounded-xl shadow-lg border border-border-subtle py-2 z-50 overflow-hidden">
                        <div class="px-4 py-2 border-b border-border-subtle flex justify-between items-center bg-canvas-bg/50">
                            <h3 class="font-bold text-sm text-on-surface">Notifikasi</h3>
                            @if($unreadCount > 0)
                            <span class="text-xs bg-primary-fixed text-on-primary-fixed px-2 py-0.5 rounded-full font-bold">{{ $unreadCount }} Baru</span>
                            @endif
                        </div>
                        <div class="max-h-80 overflow-y-auto">
                            @forelse($unreadMessages as $msg)
                            <a href="{{ url('/pesan') }}" class="flex gap-3 px-4 py-3 hover:bg-canvas-bg transition-colors border-b border-border-subtle last:border-0">
                                <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-xs shrink-0">
                                    {{ substr($msg->sender_name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm text-on-surface font-semibold leading-tight mb-0.5">Pesan baru dari {{ $msg->sender_name }}</p>
                                    <p class="text-xs text-text-muted line-clamp-1">{{ $msg->content }}</p>
                                    <span class="text-[10px] text-primary font-medium mt-1 block">{{ $msg->created_at->diffForHumans() }}</span>
                                </div>
                            </a>
                            @empty
                            <div class="px-4 py-6 text-center text-text-muted">
                                <span class="material-symbols-outlined text-3xl mb-1 opacity-50">notifications_paused</span>
                                <p class="text-sm">Tidak ada notifikasi baru.</p>
                            </div>
                            @endforelse
                        </div>
                        @if($unreadCount > 0)
                        <div class="p-2 border-t border-border-subtle bg-canvas-bg/50">
                            <a href="{{ url('/pesan') }}" class="block text-center text-xs font-bold text-primary hover:underline">Lihat Semua Pesan</a>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="relative" x-data="{ profileOpen: false }">
                    <button @click="profileOpen = !profileOpen" @click.away="profileOpen = false" class="flex items-center gap-3 pl-3 border-l border-gray-200 hover:opacity-80 transition-opacity focus:outline-none">
                        @if(auth()->user()->profile_photo)
                            <img alt="Profile" class="w-8 h-8 rounded-full object-cover shadow-sm" src="{{ asset('storage/' . auth()->user()->profile_photo) }}"/>
                        @else
                            <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm shadow-sm uppercase">
                                {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                            </div>
                        @endif
                        <div class="hidden md:flex flex-col text-left">
                            <span class="font-semibold text-sm leading-tight" style="color: #161b2e;">{{ auth()->user()->name ?? 'Admin' }}</span>
                            <span class="text-xs leading-tight capitalize" style="color: #737A90;">{{ str_replace('_', ' ', auth()->user()->role ?? 'administrator') }}</span>
                        </div>
                        <span class="material-symbols-outlined text-gray-400 text-sm" :class="{'rotate-180': profileOpen}">expand_more</span>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="profileOpen" x-transition.opacity x-cloak
                         class="absolute right-0 mt-3 w-48 bg-surface-card rounded-xl shadow-lg border border-border-subtle py-2 z-50">
                        <a href="{{ route('profile.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-on-surface hover:bg-canvas-bg transition-colors">
                            <span class="material-symbols-outlined text-[18px] text-text-muted">person</span> Profil Saya
                        </a>
                        <div class="h-px bg-border-subtle my-1"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-danger hover:bg-danger/5 transition-colors text-left">
                                <span class="material-symbols-outlined text-[18px]">logout</span> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- PAGE CONTENT -->
        <main class="w-full pt-20 min-h-screen p-6" style="background-color: #EBF0FA;">
            @yield('content')
        </main>

    </div>
</body>
</html>
