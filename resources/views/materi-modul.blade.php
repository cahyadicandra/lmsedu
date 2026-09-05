@extends('layouts.app')

@section('content')
<div class="flex flex-col w-full gap-space-xl">
<!-- Top Navigation & Stage Header Banner -->
<div class="w-full bg-surface-card rounded-[20px] p-space-lg shadow-sm flex flex-col gap-space-lg">
<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-space-md">
<div class="flex flex-col gap-space-xxs">
<div class="flex items-center gap-space-sm flex-wrap">
<span class="font-headline-lg text-headline-lg font-bold text-on-surface tracking-tight">Kurikulum &amp; Modul Pembelajaran</span>
<span class="inline-flex items-center gap-1.5 px-space-sm py-1 bg-surface-container-high text-primary-container font-label-md text-label-md font-semibold rounded-full">
<span class="material-symbols-outlined text-sm">school</span>
            Level SMP / Menengah (Fase 1 - 6)
          </span>
</div>
<p class="font-body-sm text-body-sm text-text-muted">Akses materi teori komprehensif, panduan lab terpandu, repositori latihan, dan rekaman sesi live mentor.</p>
</div>
<!-- Quick Search & Actions -->
<div class="flex items-center gap-space-sm w-full lg:w-auto">
<div class="relative flex-1 sm:w-80">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-muted text-base">search</span>
<input class="w-full pl-9 pr-3 py-2 bg-canvas-bg rounded-full text-on-surface font-body-sm text-body-sm placeholder:text-text-muted outline-none focus:ring-1 focus:ring-primary-container" id="lessonSearch" placeholder="Cari sesi, topik, atau kata kunci..." type="text"/>
</div>
<button class="p-2 bg-canvas-bg hover:bg-surface-container rounded-full text-secondary transition-all flex items-center justify-center" title="Unduh Silabus Lengkap">
<span class="material-symbols-outlined text-xl">download</span>
</button>
</div>
</div>
<!-- Phase / Track Tabs Selector -->
<div class="flex items-center gap-space-xs overflow-x-auto pb-1 -mb-1 scrollbar-none">
<button class="phase-tab px-4 py-2 rounded-full font-label-md text-label-md font-semibold whitespace-nowrap bg-canvas-bg text-text-muted hover:text-on-surface hover:bg-surface-container transition-all" data-phase="all">
        Semua Fase
      </button>
<button class="phase-tab px-4 py-2 rounded-full font-label-md text-label-md font-semibold whitespace-nowrap bg-canvas-bg text-text-muted hover:text-on-surface hover:bg-surface-container transition-all" data-phase="fase-1">
        Fase 1: Dasar
      </button>
<button class="phase-tab px-4 py-2 rounded-full font-label-md text-label-md font-semibold whitespace-nowrap bg-canvas-bg text-text-muted hover:text-on-surface hover:bg-surface-container transition-all" data-phase="fase-2">
        Fase 2: Interaktif
      </button>
<button class="phase-tab px-4 py-2 rounded-full font-label-md text-label-md font-semibold whitespace-nowrap bg-primary-container text-on-primary shadow-sm transition-all" data-phase="fase-3">
        Fase 3: Modern Frontend (Aktif)
      </button>
<button class="phase-tab px-4 py-2 rounded-full font-label-md text-label-md font-semibold whitespace-nowrap bg-canvas-bg text-text-muted hover:text-on-surface hover:bg-surface-container transition-all" data-phase="fase-4">
        Fase 4: Backend Supabase
      </button>
<button class="phase-tab px-4 py-2 rounded-full font-label-md text-label-md font-semibold whitespace-nowrap bg-canvas-bg text-text-muted hover:text-on-surface hover:bg-surface-container transition-all" data-phase="fase-5">
        Fase 5: Fullstack Project
      </button>
<button class="phase-tab px-4 py-2 rounded-full font-label-md text-label-md font-semibold whitespace-nowrap bg-canvas-bg text-text-muted hover:text-on-surface hover:bg-surface-container transition-all" data-phase="fase-6">
        Fase 6: Capstone &amp; Sertifikasi
      </button>
</div>
</div>
<!-- Summary Metrics Row (Bento Style Cards) -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-space-md">
<!-- Metric 1: Total Modul -->
<div class="bg-surface-card rounded-[20px] p-space-lg shadow-sm flex items-center justify-between">
<div class="flex flex-col gap-1">
<span class="font-label-md text-label-md text-text-muted">Total Modul Belajar</span>
<div class="flex items-baseline gap-2">
<span class="font-display-metric text-display-metric text-on-surface">32</span>
<span class="font-label-sm text-label-sm text-text-muted font-medium">Sesi Terstruktur</span>
</div>
<span class="font-caption text-caption text-secondary flex items-center gap-1 mt-1">
<span class="material-symbols-outlined text-sm">timer</span> Total estimasi 96 jam lab
        </span>
</div>
<div class="w-12 h-12 rounded-2xl bg-canvas-bg text-primary-container flex items-center justify-center">
<span class="material-symbols-outlined text-2xl">library_books</span>
</div>
</div>
<!-- Metric 2: Modul Selesai with Donut SVG -->
<div class="bg-surface-card rounded-[20px] p-space-lg shadow-sm flex items-center justify-between">
<div class="flex flex-col gap-1">
<span class="font-label-md text-label-md text-text-muted">Modul Selesai</span>
<div class="flex items-baseline gap-2">
<span class="font-display-metric text-display-metric text-success">18</span>
<span class="font-label-sm text-label-sm text-text-muted font-medium">/ 32 Sesi (56%)</span>
</div>
<div class="w-28 h-1.5 bg-chart-track rounded-full mt-2 overflow-hidden">
<div class="h-full bg-success rounded-full" style="width: 56%"></div>
</div>
</div>
<!-- Metric SVG Donut -->
<div class="relative w-14 h-14 flex items-center justify-center">
<svg class="w-14 h-14 -rotate-90" viewbox="0 0 48 48">
<circle class="text-chart-track" cx="24" cy="24" fill="transparent" r="19" stroke="currentColor" stroke-width="4.5"></circle>
<circle class="text-primary-container" cx="24" cy="24" fill="transparent" r="19" stroke="currentColor" stroke-dasharray="119.38" stroke-dashoffset="52.5" stroke-linecap="round" stroke-width="4.5"></circle>
</svg>
<span class="absolute font-label-sm text-label-sm font-bold text-on-surface">56%</span>
</div>
</div>
<!-- Metric 3: Modul Sedang Berjalan -->
<div class="bg-surface-card rounded-[20px] p-space-lg shadow-sm flex items-center justify-between">
<div class="flex flex-col gap-1 min-w-0 pr-2">
<div class="flex items-center gap-1.5">
<span class="w-2 h-2 rounded-full bg-secondary-container animate-pulse"></span>
<span class="font-label-md text-label-md text-primary font-semibold">Sedang Berjalan</span>
</div>
<span class="font-title-sm text-title-sm text-on-surface font-semibold truncate">Sesi 19: Supabase Auth &amp; Rules</span>
<span class="font-caption text-caption text-text-muted">Fase 3 • Selesai 3 dari 4 target</span>
</div>
<div class="w-12 h-12 rounded-2xl bg-secondary-fixed text-primary-container flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-2xl">pending_actions</span>
</div>
</div>
<!-- Metric 4: Sertifikat Milestone -->
<div class="bg-surface-card rounded-[20px] p-space-lg shadow-sm flex items-center justify-between">
<div class="flex flex-col gap-1">
<span class="font-label-md text-label-md text-text-muted">Status Sertifikat</span>
<div class="flex items-baseline gap-2">
<span class="font-display-metric text-display-metric text-on-surface">1</span>
<span class="font-label-sm text-label-sm text-text-muted font-medium">Tersedia di Fase 6</span>
</div>
<span class="font-caption text-caption text-warning flex items-center gap-1 mt-1 font-medium">
<span class="material-symbols-outlined text-sm">lock_clock</span> Selesaikan 14 modul lagi
        </span>
</div>
<div class="w-12 h-12 rounded-2xl bg-canvas-bg text-warning flex items-center justify-center">
<span class="material-symbols-outlined text-2xl">workspace_premium</span>
</div>
</div>
</div>
<!-- Workspace Grid: Modul Cards + Detail Preview Interactive Drawer/Panel -->
<div class="grid grid-cols-1 xl:grid-cols-12 gap-space-lg items-start">
<!-- Left 7 Cols: Modul Cards List -->
<div class="xl:col-span-7 flex flex-col gap-space-md">
<div class="flex items-center justify-between px-space-xs">
<div class="flex items-center gap-2">
<span class="font-headline-md text-headline-md font-bold text-on-surface">Daftar Modul Pembelajaran</span>
<span class="px-2 py-0.5 rounded-full bg-canvas-bg text-secondary font-label-sm text-label-sm font-semibold">Fase 3 &amp; 4</span>
</div>
<div class="flex items-center gap-2">
<span class="font-caption text-caption text-text-muted">Urutan: Kurikulum Standar</span>
</div>
</div>
<!-- Card 1: Fase 3 - Selesai -->
<div class="bg-surface-card rounded-[20px] p-space-lg shadow-sm hover:shadow-md transition-all flex flex-col sm:flex-row gap-space-md items-start group cursor-pointer" onclick="selectModul(17)">
<div class="w-full sm:w-44 h-32 rounded-2xl overflow-hidden relative shrink-0 bg-surface-container">
<img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" data-alt="Modern clean software workspace illustration with REST API network request nodes in blue and white colors, vector aesthetic, subtle soft lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDakVf5h6TGaHD1hJH5XZFT5Z0mBxZrDp8hIOiBttaNDhcAPgNR1XcgAVEsC21GhAhUE0dP_PM7kXHwTMsi1FRaa4Qw7YVT-AZWWHwaXIznmyZsL-ynpkX3ev_R0uva7GZGXTF0Eglr3cSH47Zb-Rj0-o0I9TtYZBbggjhPkFkCCnboCjXTO8DJMl2aeoPAlzeDcQs6CrmNPsSDZs3mX7NU4AGJ27cmJvlR0qsgdvjzm5up_W4SADrX6w"/>
<span class="absolute top-2 left-2 px-2 py-0.5 rounded-full bg-success text-on-primary font-label-sm text-label-sm font-semibold flex items-center gap-1 shadow-sm">
<span class="material-symbols-outlined text-xs">check_circle</span> Selesai
          </span>
<span class="absolute bottom-2 right-2 px-2 py-0.5 rounded-full bg-surface-card/90 backdrop-blur font-caption text-caption font-semibold text-on-surface">
            45 Menit
          </span>
</div>
<div class="flex-1 flex flex-col justify-between h-full min-w-0">
<div>
<div class="flex items-center justify-between gap-2 mb-1">
<span class="font-caption text-caption text-text-muted uppercase tracking-wider font-semibold">Fase 3 • Frontend Advanced</span>
<span class="px-2 py-0.5 rounded bg-surface-container-high text-primary-container font-label-sm text-label-sm font-bold">Nilai: 94 / 100</span>
</div>
<h3 class="font-title-sm text-title-sm font-bold text-on-surface group-hover:text-primary-container transition-colors truncate">
              Sesi 17: Integrasi REST API &amp; Fetching Data
            </h3>
<p class="font-body-sm text-body-sm text-text-muted line-clamp-2 mt-1">
              Mempelajari implementasi TanStack React Query, data caching, handling HTTP error response, dan pagination modern.
            </p>
</div>
<div class="flex flex-wrap items-center justify-between gap-2 mt-4 pt-3 border-t border-transparent bg-canvas-bg/50 -mx-2 px-2 py-1.5 rounded-xl">
<div class="flex items-center gap-3">
<a class="inline-flex items-center gap-1 font-label-sm text-label-sm font-medium text-secondary hover:text-primary" href="#">
<span class="material-symbols-outlined text-sm">smart_display</span> Rekaman Sesi
              </a>
<a class="inline-flex items-center gap-1 font-label-sm text-label-sm font-medium text-secondary hover:text-primary" href="#">
<span class="material-symbols-outlined text-sm">picture_as_pdf</span> Modul PDF (3.4 MB)
              </a>
</div>
<button class="text-primary font-label-sm text-label-sm font-semibold flex items-center gap-0.5 hover:underline">
              Review Ulang <span class="material-symbols-outlined text-sm">arrow_forward</span>
</button>
</div>
</div>
</div>
<!-- Card 2: Fase 3 - Sedang Aktif (Spotlighted) -->
<div class="bg-surface-card rounded-[20px] p-space-lg shadow-sm hover:shadow-md transition-all flex flex-col sm:flex-row gap-space-md items-start group ring-2 ring-primary-container/20 cursor-pointer" onclick="selectModul(18)">
<div class="w-full sm:w-44 h-32 rounded-2xl overflow-hidden relative shrink-0 bg-surface-container">
<img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" data-alt="Futuristic web development screen showing Next.js server components structure diagrams, deep rich royal blue background with glowing elements" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCAmZBSOe85-gvq0dmvdmE8YXoI8i2xxUATsY99bZ7eiBAuJ1Kfryu1Q7JJdzBbQ-V15VwiMkfXfzpdHHmc-TW-4jKkx7I72Vtbz_sjuE3sHDAeMKlUf3Qh5EHdnfSUnAYq5aMNlQyiSuOGXqwznm5KhAfFhAysT779baNCFahgCwHkvfjTC9LaUbizJQ0ajSxqZnwVvv7d0jOKDtAMD4k0C3XBN0sXzcJLgzIwNsKSoNvrxduqaVfHYw"/>
<span class="absolute top-2 left-2 px-2 py-0.5 rounded-full bg-primary-container text-on-primary font-label-sm text-label-sm font-semibold flex items-center gap-1 shadow-sm">
<span class="material-symbols-outlined text-xs">play_circle</span> Sedang Aktif
          </span>
<span class="absolute bottom-2 right-2 px-2 py-0.5 rounded-full bg-surface-card/90 backdrop-blur font-caption text-caption font-semibold text-on-surface">
            60 Menit
          </span>
</div>
<div class="flex-1 flex flex-col justify-between h-full min-w-0">
<div>
<div class="flex items-center justify-between gap-2 mb-1">
<span class="font-caption text-caption text-primary font-semibold uppercase tracking-wider">Fase 3 • Sesi Utama Minggu Ini</span>
<span class="px-2 py-0.5 rounded-full bg-secondary-fixed text-on-secondary-fixed font-label-sm text-label-sm font-bold">Progress: 75%</span>
</div>
<h3 class="font-title-sm text-title-sm font-bold text-on-surface group-hover:text-primary-container transition-colors">
              Sesi 18: Client State vs Server Components
            </h3>
<p class="font-body-sm text-body-sm text-text-muted line-clamp-2 mt-1">
              Konsep re-rendering, hybrid architecture di Next.js App Router, pemisahan logika interactivity vs direct SQL fetch.
            </p>
<!-- Progress Bar -->
<div class="w-full bg-canvas-bg rounded-full h-2 mt-3 overflow-hidden">
<div class="bg-primary-container h-full rounded-full transition-all duration-500" style="width: 75%"></div>
</div>
</div>
<div class="flex flex-wrap items-center justify-between gap-2 mt-4 pt-3">
<button class="inline-flex items-center gap-1 font-label-sm text-label-sm font-semibold text-text-muted hover:text-primary">
<span class="material-symbols-outlined text-base">download</span> Cheatsheet.zip (820 KB)
            </button>
<button class="px-4 py-2 bg-primary-container text-on-primary rounded-full font-label-md text-label-md font-semibold hover:bg-secondary transition-all shadow-sm flex items-center gap-1.5">
<span class="material-symbols-outlined text-sm">play_arrow</span> Lanjutkan Belajar
            </button>
</div>
</div>
</div>
<!-- Card 3: Fase 3 - Terkunci/Next -->
<div class="bg-surface-card rounded-[20px] p-space-lg shadow-sm hover:shadow-md transition-all flex flex-col sm:flex-row gap-space-md items-start group opacity-90 cursor-pointer" onclick="selectModul(19)">
<div class="w-full sm:w-44 h-32 rounded-2xl overflow-hidden relative shrink-0 bg-surface-container">
<img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" data-alt="Relational database tables diagram, security shields representing Row Level Security, clean modern vector graphic with navy blue tones" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDFN9za9YAT7d8v-2vxVFHGkYuPuXFu68ICT72IMq5R7smm2Ga0touArPVgrry6A6ga67AS3wBkmZ0NefiRsRoRbLUCDSsSAeEone_EN-Rp2G7vX09xUornt2paaymi1IF-xXZHVlhoO-HPVvkoL0pAl1oJRv6fMilRIYWZuw6B28xKbCGxF0yt2ri2Jpn7DBymi78y01bMPsuKBM-DbrfJ6inp1lx9lVwQzEXlhYiTj7wx45sdtTC0gA"/>
<span class="absolute top-2 left-2 px-2 py-0.5 rounded-full bg-canvas-bg text-on-surface-variant font-label-sm text-label-sm font-semibold flex items-center gap-1">
<span class="material-symbols-outlined text-xs">lock</span> Mendatang
          </span>
<span class="absolute bottom-2 right-2 px-2 py-0.5 rounded-full bg-surface-card/90 backdrop-blur font-caption text-caption font-semibold text-on-surface">
            Besok 10:00 WIB
          </span>
</div>
<div class="flex-1 flex flex-col justify-between h-full min-w-0">
<div>
<div class="flex items-center justify-between gap-2 mb-1">
<span class="font-caption text-caption text-text-muted uppercase tracking-wider font-semibold">Fase 3 • Modul Penutup</span>
<span class="font-caption text-caption text-warning flex items-center gap-1 font-semibold">
<span class="material-symbols-outlined text-sm">schedule</span> Jadwal Live Mentor
              </span>
</div>
<h3 class="font-title-sm text-title-sm font-bold text-on-surface group-hover:text-primary-container transition-colors">
              Sesi 19: Database Postgres &amp; RLS Supabase
            </h3>
<p class="font-body-sm text-body-sm text-text-muted line-clamp-2 mt-1">
              Mengenal Schema Builder Supabase, penulisan SQL Migration, dan penerapan Row Level Security (RLS) untuk perlindungan data pengguna.
            </p>
</div>
<div class="flex items-center justify-between gap-2 mt-4 pt-3">
<span class="font-caption text-caption text-text-muted flex items-center gap-1">
<span class="material-symbols-outlined text-base">notifications_active</span> Pengingat kalender aktif
            </span>
<button class="px-3 py-1.5 rounded-full bg-canvas-bg text-text-muted font-label-sm text-label-sm font-semibold hover:text-on-surface">
              Lihat Silabus Sesi
            </button>
</div>
</div>
</div>
<!-- Card 4: Fase 4 - Terkunci Lengkap -->
<div class="bg-surface-card rounded-[20px] p-space-lg shadow-sm flex flex-col sm:flex-row gap-space-md items-start opacity-60">
<div class="w-full sm:w-44 h-32 rounded-2xl overflow-hidden relative shrink-0 bg-surface-container flex items-center justify-center">
<div class="flex flex-col items-center gap-1 text-outline">
<span class="material-symbols-outlined text-3xl">lock</span>
<span class="font-caption text-caption font-medium">Terkunci</span>
</div>
</div>
<div class="flex-1 flex flex-col justify-between h-full min-w-0">
<div>
<div class="flex items-center justify-between gap-2 mb-1">
<span class="font-caption text-caption text-text-muted uppercase tracking-wider font-semibold">Fase 4 • Backend &amp; Realtime</span>
<span class="px-2 py-0.5 rounded bg-surface-container text-text-muted font-label-sm text-label-sm">Syarat: Lulus Fase 3</span>
</div>
<h3 class="font-title-sm text-title-sm font-bold text-on-surface">
              Sesi 20: CRUD Data Realtime &amp; Trigger Supabase
            </h3>
<p class="font-body-sm text-body-sm text-text-muted line-clamp-2 mt-1">
              Implementasi websocket subscriptions Supabase, sinkronisasi state multi-client, dan PostgreSQL database automated triggers.
            </p>
</div>
<div class="flex items-center justify-between gap-2 mt-4 pt-3">
<span class="font-caption text-caption text-text-muted">Akan terbuka otomatis setelah evaluasi Sesi 19</span>
<button class="text-text-muted font-label-sm text-label-sm flex items-center gap-1 cursor-not-allowed">
<span class="material-symbols-outlined text-sm">lock</span> Terkunci
            </button>
</div>
</div>
</div>
</div>
<!-- Right 5 Cols: Detail Preview Drawer / Active Lesson Workspace Panel -->
<div class="xl:col-span-5 flex flex-col gap-space-md sticky top-20">
<div class="bg-surface-card rounded-[20px] p-space-lg shadow-sm flex flex-col gap-space-md">
<!-- Drawer Header / Active Topic Banner -->
<div class="flex items-start justify-between pb-space-sm">
<div>
<div class="flex items-center gap-2 mb-1">
<span class="px-2.5 py-0.5 bg-secondary-container/30 text-on-secondary-container font-label-sm text-label-sm font-bold rounded-full">
                Sesi Terpilih
              </span>
<span class="font-caption text-caption text-text-muted">Fase 3 • Minggu ke-4</span>
</div>
<h2 class="font-headline-md text-headline-md font-bold text-on-surface leading-tight" id="drawerTitle">
              Sesi 18: Client State vs Server Components
            </h2>
</div>
<button class="p-1.5 rounded-full hover:bg-canvas-bg text-text-muted hover:text-on-surface" title="Bagikan Tautan Modul">
<span class="material-symbols-outlined text-xl">share</span>
</button>
</div>
<!-- Tutor / Mentor Card Component -->
<div class="flex items-center justify-between p-3 bg-canvas-bg rounded-2xl">
<div class="flex items-center gap-3">
<img class="w-10 h-10 rounded-full object-cover" data-alt="Portrait of a friendly Indonesian tech mentor wearing navy collared shirt with soft studio backdrop lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAazeY-tyUC0AqPr0EjhRVoOUa6oyGZVX1GEcx3WRSr3EzRrqTizWGU2poS3cA8Ms1jyPaVWvUiMB-5vgADCE9zdBcd_pyXPoQDi8ukvmrVKk60Bz5tcxIujtWofs9HhpcAE45OnYXy4eNXURaxJTv1zWvEivfBFM_JS1p_KbcFfJbfQxx3J988zM-DZnF3i4Jo5QTGvDsiFIuo-x5CZlnvaAeP9lwOJe_6hPtq2VN3T-3Yacet813IzQ"/>
<div class="flex flex-col">
<span class="font-title-sm text-title-sm font-semibold text-on-surface">Arya Wicaksono, M.Kom</span>
<span class="font-caption text-caption text-text-muted">Lead Instructor • Frontend Specialist</span>
</div>
</div>
<div class="flex items-center gap-1">
<button class="w-8 h-8 rounded-full bg-surface-card text-secondary flex items-center justify-center hover:bg-surface-container shadow-xs" title="Kirim Pesan">
<span class="material-symbols-outlined text-base">chat</span>
</button>
<button class="w-8 h-8 rounded-full bg-surface-card text-secondary flex items-center justify-center hover:bg-surface-container shadow-xs" title="Konsultasi Diskusi">
<span class="material-symbols-outlined text-base">forum</span>
</button>
</div>
</div>
<!-- Video Player / Rekaman Preview Box -->
<div class="relative rounded-2xl overflow-hidden aspect-video bg-inverse-surface group shadow-inner">
<img class="w-full h-full object-cover opacity-80 group-hover:scale-105 transition-all duration-300" data-alt="Screenshot of an interactive coding session showing code editor with React JSX components and terminal split screen in dark mode" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBhk8CFhC_lP9-YOuDmjBj5aqGB5s59MZuarCzQYuWwpXPAdRmUxXZll12z6i5NWu-C3aEz83riJgEV-nuDqbD8Ul9FIghkvzRM44yLmjhL9-NrsqtMrxIeI_7sS1sHGJLAzHHHouEPdvFIS6pdAEbuYzDDRST3uTUv8evS0aOJ-gYTrHDFnA8dSVeydk_QDDX7Twf2rIWUR3aIfuS7Y0CpunGfItQEf3L86ijsyG9KIuWbqBkhXxgjCw"/>
<div class="absolute inset-0 bg-gradient-to-t from-on-surface/80 via-transparent to-transparent flex flex-col justify-between p-3">
<div class="flex justify-end">
<span class="px-2 py-0.5 bg-on-surface/70 backdrop-blur text-surface-card font-caption text-caption rounded-full">
                HD 1080p
              </span>
</div>
<div class="flex items-center justify-between">
<div class="flex items-center gap-2">
<button class="w-10 h-10 rounded-full bg-primary-container text-on-primary flex items-center justify-center shadow-lg hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-xl">play_arrow</span>
</button>
<div class="flex flex-col text-on-primary">
<span class="font-label-sm text-label-sm font-semibold">Video Penjelasan Mentor</span>
<span class="font-caption text-caption opacity-80">Durasi: 38:42</span>
</div>
</div>
<span class="font-caption text-caption text-on-primary font-mono bg-on-surface/50 px-2 py-1 rounded">28:15 / 38:42</span>
</div>
</div>
</div>
<!-- Checklist Sub-Topik Belajar (3/4 Selesai) -->
<div class="flex flex-col gap-space-xs">
<div class="flex items-center justify-between">
<span class="font-title-sm text-title-sm font-bold text-on-surface">Target &amp; Sub-Topik</span>
<span class="font-label-sm text-label-sm text-success font-semibold flex items-center gap-1">
<span class="material-symbols-outlined text-sm">task_alt</span> 3 dari 4 Diselesaikan
            </span>
</div>
<div class="flex flex-col gap-2 mt-1">
<!-- Item 1 -->
<label class="flex items-start gap-3 p-2.5 rounded-xl bg-canvas-bg/60 hover:bg-canvas-bg cursor-pointer transition-colors">
<input checked="" class="mt-0.5 w-4 h-4 rounded text-primary-container accent-primary-container cursor-pointer" type="checkbox"/>
<div class="flex-1 flex flex-col">
<span class="font-body-sm text-body-sm font-semibold text-on-surface line-through text-text-muted">1. Paradigma Component Tree &amp; Hydration</span>
<span class="font-caption text-caption text-text-muted">Memahami batasan boundary 'use client' dan lifecycle.</span>
</div>
<span class="material-symbols-outlined text-success text-base">check</span>
</label>
<!-- Item 2 -->
<label class="flex items-start gap-3 p-2.5 rounded-xl bg-canvas-bg/60 hover:bg-canvas-bg cursor-pointer transition-colors">
<input checked="" class="mt-0.5 w-4 h-4 rounded text-primary-container accent-primary-container cursor-pointer" type="checkbox"/>
<div class="flex-1 flex flex-col">
<span class="font-body-sm text-body-sm font-semibold text-on-surface line-through text-text-muted">2. Optimasi Render Passes dengan Memoization</span>
<span class="font-caption text-caption text-text-muted">Penggunaan useMemo, useCallback dan custom hooks.</span>
</div>
<span class="material-symbols-outlined text-success text-base">check</span>
</label>
<!-- Item 3 -->
<label class="flex items-start gap-3 p-2.5 rounded-xl bg-canvas-bg/60 hover:bg-canvas-bg cursor-pointer transition-colors">
<input checked="" class="mt-0.5 w-4 h-4 rounded text-primary-container accent-primary-container cursor-pointer" type="checkbox"/>
<div class="flex-1 flex flex-col">
<span class="font-body-sm text-body-sm font-semibold text-on-surface line-through text-text-muted">3. Mengirim Props dari Server ke Client</span>
<span class="font-caption text-caption text-text-muted">Serialisasi format JSON dan payload boundaries.</span>
</div>
<span class="material-symbols-outlined text-success text-base">check</span>
</label>
<!-- Item 4 (Pending) -->
<label class="flex items-start gap-3 p-2.5 rounded-xl bg-canvas-bg hover:bg-surface-container cursor-pointer transition-colors">
<input class="mt-0.5 w-4 h-4 rounded text-primary-container accent-primary-container cursor-pointer" type="checkbox"/>
<div class="flex-1 flex flex-col">
<span class="font-body-sm text-body-sm font-semibold text-on-surface">4. Studi Kasus Mini Dashboard Filter Data</span>
<span class="font-caption text-caption text-secondary font-medium">Tantangan wajib: Terapkan debounce query params.</span>
</div>
<span class="material-symbols-outlined text-warning text-base">pending</span>
</label>
</div>
</div>
<!-- Quick Resources Links -->
<div class="flex flex-col gap-2 pt-2">
<span class="font-label-md text-label-md font-semibold text-text-muted uppercase tracking-wider">Materi &amp; Bahan Pendukung</span>
<div class="grid grid-cols-2 gap-2">
<a class="p-2.5 rounded-xl bg-canvas-bg hover:bg-surface-container flex items-center gap-2 transition-colors" href="#">
<span class="material-symbols-outlined text-primary-container text-lg">code</span>
<div class="flex flex-col min-w-0">
<span class="font-label-sm text-label-sm font-semibold text-on-surface truncate">Repo Starter Code</span>
<span class="font-caption text-caption text-text-muted">GitHub • v2.4.0</span>
</div>
</a>
<a class="p-2.5 rounded-xl bg-canvas-bg hover:bg-surface-container flex items-center gap-2 transition-colors" href="#">
<span class="material-symbols-outlined text-primary-container text-lg">description</span>
<div class="flex flex-col min-w-0">
<span class="font-label-sm text-label-sm font-semibold text-on-surface truncate">Slide Presentasi</span>
<span class="font-caption text-caption text-text-muted">Google Slides • 42 Halaman</span>
</div>
</a>
</div>
</div>
<!-- Action Buttons -->
<div class="flex flex-col sm:flex-row items-center gap-space-sm pt-2">
<button class="w-full sm:flex-1 py-3 px-space-md rounded-full bg-canvas-bg text-on-surface font-label-md text-label-md font-semibold hover:bg-surface-container transition-all flex items-center justify-center gap-1.5" onclick="markComplete()">
<span class="material-symbols-outlined text-base">check_circle</span> Tandai Selesai
          </button>
<a class="w-full sm:flex-1 py-3 px-space-md rounded-full bg-primary-container text-on-primary font-label-md text-label-md font-semibold hover:bg-secondary transition-all shadow-sm flex items-center justify-center gap-1.5" data-path="challenges" href="#">
<span class="material-symbols-outlined text-base">terminal</span> Kerjakan Tantangan
          </a>
</div>
</div>
<!-- Quick Peer Study Group Banner -->
<div class="bg-surface-card rounded-[20px] p-space-md shadow-sm flex items-center justify-between">
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-full bg-secondary-fixed flex items-center justify-center text-primary-container">
<span class="material-symbols-outlined">group</span>
</div>
<div class="flex flex-col">
<span class="font-title-sm text-title-sm font-semibold text-on-surface">Kelompok Diskusi Batch 4</span>
<span class="font-caption text-caption text-text-muted">14 Rekan sedang aktif mendiskusikan modul ini</span>
</div>
</div>
<button class="px-3 py-1.5 rounded-full bg-canvas-bg text-primary-container font-label-sm text-label-sm font-semibold hover:bg-surface-container">
          Gabung Room
        </button>
</div>
</div>
</div>
</div>
<script>
  // Simple tab filtering and card selector interaction
  document.querySelectorAll('.phase-tab').forEach(tab => {
    tab.addEventListener('click', function() {
      document.querySelectorAll('.phase-tab').forEach(t => {
        t.className = 'phase-tab px-4 py-2 rounded-full font-label-md text-label-md font-semibold whitespace-nowrap bg-canvas-bg text-text-muted hover:text-on-surface hover:bg-surface-container transition-all';
      });
      this.className = 'phase-tab px-4 py-2 rounded-full font-label-md text-label-md font-semibold whitespace-nowrap bg-primary-container text-on-primary shadow-sm transition-all';
    });
  });

  function selectModul(sesiNumber) {
    const titles = {
      17: "Sesi 17: Integrasi REST API & Fetching Data",
      18: "Sesi 18: Client State vs Server Components",
      19: "Sesi 19: Database Postgres & RLS Supabase"
    };
    const titleElem = document.getElementById('drawerTitle');
    if (titleElem && titles[sesiNumber]) {
      titleElem.textContent = titles[sesiNumber];
    }
  }

  function markComplete() {
    alert("Kerja bagus! Progres sesi berhasil disimpan.");
  }
</script>
@endsection
