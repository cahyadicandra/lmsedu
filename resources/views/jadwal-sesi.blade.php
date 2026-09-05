@extends('layouts.app')

@section('content')
<div class="flex flex-col w-full gap-y-space-lg pb-space-3xl">
<!-- Dynamic Top Control Bar -->
<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-space-md">
<div class="flex flex-col">
<div class="flex items-center gap-space-xs text-text-muted">
<span class="font-caption text-caption uppercase tracking-wider font-semibold text-secondary">Akademik</span>
<span class="text-xs">•</span>
<span class="font-caption text-caption">Batch 4 Fullstack Engineering</span>
</div>
<h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight mt-0.5">Jadwal Kelas &amp; Sesi Mentoring</h1>
</div>
<!-- Filter & View Controls -->
<div class="flex flex-wrap items-center gap-space-xs">
<div class="inline-flex bg-surface-container-high p-1 rounded-full">
<button class="px-space-md py-1.5 rounded-full bg-surface-card text-primary font-label-md text-label-md shadow-sm font-semibold transition-all" type="button">Minggu Ini</button>
<button class="px-space-md py-1.5 rounded-full text-on-surface-variant hover:text-on-surface font-label-md text-label-md transition-all" type="button">Bulan Ini</button>
</div>
<div class="relative">
<button class="flex items-center gap-space-xs px-space-md py-2 bg-surface-card text-on-surface rounded-full shadow-sm font-label-md text-label-md hover:bg-surface-container-low transition-colors" type="button">
<span class="material-symbols-outlined text-sm text-secondary">school</span>
<span>Kelas Saya (Batch 4)</span>
<span class="material-symbols-outlined text-sm text-text-muted">expand_more</span>
</button>
</div>
<button class="flex items-center gap-space-xs px-space-md py-2 bg-primary text-on-primary rounded-full shadow-sm font-label-md text-label-md hover:bg-primary-container transition-all" type="button">
<span class="material-symbols-outlined text-sm">event_repeat</span>
<span>Sinkron Google Calendar</span>
</button>
</div>
</div>
<!-- Key Attendance & Commitment Metric Stripe -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
<div class="bg-surface-card rounded-2xl p-space-md shadow-sm flex items-center justify-between">
<div class="flex items-center gap-space-md">
<div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-primary">
<span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">verified</span>
</div>
<div>
<span class="font-caption text-caption text-text-muted uppercase tracking-wider block font-medium">Tingkat Kehadiran</span>
<div class="flex items-baseline gap-space-xs">
<span class="font-display-metric text-display-metric text-on-surface font-bold">98%</span>
<span class="font-label-sm text-label-sm text-text-muted font-normal">(23/24 Sesi)</span>
</div>
</div>
</div>
<div class="relative w-12 h-12 flex items-center justify-center">
<svg class="w-full h-full -rotate-90" viewbox="0 0 36 36">
<path class="text-chart-track stroke-current" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke-width="3.5"></path>
<path class="text-success stroke-current" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke-dasharray="98, 100" stroke-linecap="round" stroke-width="3.5"></path>
</svg>
</div>
</div>
<div class="bg-surface-card rounded-2xl p-space-md shadow-sm flex items-center justify-between">
<div class="flex items-center gap-space-md">
<div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-secondary">
<span class="material-symbols-outlined text-2xl">timelapse</span>
</div>
<div>
<span class="font-caption text-caption text-text-muted uppercase tracking-wider block font-medium">Sisa Pertemuan</span>
<div class="flex items-baseline gap-space-xs">
<span class="font-display-metric text-display-metric text-on-surface font-bold">8</span>
<span class="font-label-sm text-label-sm text-text-muted">Sesi Tersisa</span>
</div>
</div>
</div>
<div class="px-space-sm py-1 bg-surface-container text-secondary rounded-full font-label-sm text-label-sm font-semibold">
        Modul 4 &amp; 5
      </div>
</div>
<div class="bg-surface-card rounded-2xl p-space-md shadow-sm flex items-center justify-between">
<div class="flex items-center gap-space-md">
<div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-text-muted">
<span class="material-symbols-outlined text-2xl">event_busy</span>
</div>
<div>
<span class="font-caption text-caption text-text-muted uppercase tracking-wider block font-medium">Izin &amp; Tidak Hadir</span>
<div class="flex items-baseline gap-space-xs">
<span class="font-display-metric text-display-metric text-on-surface font-bold">0</span>
<span class="font-label-sm text-label-sm text-success font-medium">Absensi Nihil</span>
</div>
</div>
</div>
<div class="flex items-center gap-1 text-success font-label-sm text-label-sm bg-success/10 px-space-sm py-1 rounded-full">
<span class="material-symbols-outlined text-sm">check_circle</span>
<span>Track Bersih</span>
</div>
</div>
</div>
<!-- Main Grid: Interactive Schedule Stream + Side Widgets -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg items-start">
<!-- Left 8 Columns: Interactive Timeline & Daily Schedule -->
<div class="lg:col-span-8 flex flex-col gap-space-lg">
<!-- Weekdays Quick Horizontal Scroller -->
<div class="bg-surface-card rounded-2xl p-space-md shadow-sm flex flex-col gap-space-sm">
<div class="flex items-center justify-between">
<div class="flex items-center gap-space-xs">
<span class="material-symbols-outlined text-primary text-xl">calendar_today</span>
<h2 class="font-headline-md text-headline-md text-on-surface">Pekan 6: Arsitektur Backend &amp; API</h2>
</div>
<div class="flex items-center gap-1">
<button aria-label="Minggu sebelumnya" class="w-8 h-8 rounded-full bg-canvas-bg text-on-surface flex items-center justify-center hover:bg-surface-container transition-colors" type="button">
<span class="material-symbols-outlined text-sm">chevron_left</span>
</button>
<span class="font-label-md text-label-md font-semibold px-space-xs text-on-surface">16 - 22 Oktober 2024</span>
<button aria-label="Minggu selanjutnya" class="w-8 h-8 rounded-full bg-canvas-bg text-on-surface flex items-center justify-center hover:bg-surface-container transition-colors" type="button">
<span class="material-symbols-outlined text-sm">chevron_right</span>
</button>
</div>
</div>
<div class="grid grid-cols-7 gap-space-xs pt-space-xs">
<!-- Mon -->
<div class="flex flex-col items-center py-2 px-1 rounded-xl bg-canvas-bg/50 cursor-pointer hover:bg-canvas-bg transition-colors">
<span class="font-caption text-caption text-text-muted">SEN</span>
<span class="font-title-sm text-title-sm font-semibold text-on-surface mt-0.5">16</span>
<div class="flex gap-1 mt-1.5">
<span class="w-1.5 h-1.5 rounded-full bg-success"></span>
<span class="w-1.5 h-1.5 rounded-full bg-success"></span>
</div>
</div>
<!-- Tue -->
<div class="flex flex-col items-center py-2 px-1 rounded-xl bg-canvas-bg/50 cursor-pointer hover:bg-canvas-bg transition-colors">
<span class="font-caption text-caption text-text-muted">SEL</span>
<span class="font-title-sm text-title-sm font-semibold text-on-surface mt-0.5">17</span>
<div class="flex gap-1 mt-1.5">
<span class="w-1.5 h-1.5 rounded-full bg-success"></span>
</div>
</div>
<!-- Wed (Active) -->
<div class="flex flex-col items-center py-2 px-1 rounded-xl bg-primary text-on-primary shadow-sm cursor-pointer relative overflow-hidden">
<div class="absolute top-1 right-1 w-1.5 h-1.5 rounded-full bg-secondary-container"></div>
<span class="font-caption text-caption text-on-primary/70">RAB</span>
<span class="font-title-sm text-title-sm font-bold text-on-primary mt-0.5">18</span>
<div class="flex gap-1 mt-1.5">
<span class="w-1.5 h-1.5 rounded-full bg-success"></span>
<span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
</div>
</div>
<!-- Thu -->
<div class="flex flex-col items-center py-2 px-1 rounded-xl bg-canvas-bg/50 cursor-pointer hover:bg-canvas-bg transition-colors">
<span class="font-caption text-caption text-text-muted">KAM</span>
<span class="font-title-sm text-title-sm font-semibold text-on-surface mt-0.5">19</span>
<div class="flex gap-1 mt-1.5">
<span class="w-1.5 h-1.5 rounded-full bg-primary-container"></span>
</div>
</div>
<!-- Fri -->
<div class="flex flex-col items-center py-2 px-1 rounded-xl bg-canvas-bg/50 cursor-pointer hover:bg-canvas-bg transition-colors">
<span class="font-caption text-caption text-text-muted">JUM</span>
<span class="font-title-sm text-title-sm font-semibold text-on-surface mt-0.5">20</span>
<div class="flex gap-1 mt-1.5">
<span class="w-1.5 h-1.5 rounded-full bg-primary-container"></span>
</div>
</div>
<!-- Sat -->
<div class="flex flex-col items-center py-2 px-1 rounded-xl bg-canvas-bg/30 cursor-pointer hover:bg-canvas-bg transition-colors">
<span class="font-caption text-caption text-text-muted">SAB</span>
<span class="font-title-sm text-title-sm font-semibold text-on-surface-variant mt-0.5">21</span>
<span class="w-1.5 h-1.5 rounded-full bg-transparent mt-1.5"></span>
</div>
<!-- Sun -->
<div class="flex flex-col items-center py-2 px-1 rounded-xl bg-canvas-bg/30 cursor-pointer hover:bg-canvas-bg transition-colors">
<span class="font-caption text-caption text-text-muted">MIN</span>
<span class="font-title-sm text-title-sm font-semibold text-on-surface-variant mt-0.5">22</span>
<span class="w-1.5 h-1.5 rounded-full bg-transparent mt-1.5"></span>
</div>
</div>
<div class="flex items-center gap-space-md pt-space-xs text-xs text-text-muted">
<div class="flex items-center gap-1.5">
<span class="w-2 h-2 rounded-full bg-success"></span>
<span class="font-caption text-caption">Telah Hadir</span>
</div>
<div class="flex items-center gap-1.5">
<span class="w-2 h-2 rounded-full bg-primary"></span>
<span class="font-caption text-caption">Sesi Hari Ini / Mendatang</span>
</div>
<div class="flex items-center gap-1.5">
<span class="w-2 h-2 rounded-full bg-warning"></span>
<span class="font-caption text-caption">Review / Tugas</span>
</div>
</div>
</div>
<!-- Timeline Schedule Stream -->
<div class="flex flex-col gap-space-md">
<div class="flex items-center justify-between pl-space-xs">
<div class="flex items-center gap-space-xs">
<span class="w-2.5 h-2.5 rounded-full bg-primary"></span>
<h3 class="font-title-sm text-title-sm text-on-surface font-semibold">Rabu, 18 Oktober 2024 — Agenda Hari Ini</h3>
</div>
<span class="font-caption text-caption text-text-muted">3 Sesi Dijadwalkan</span>
</div>
<div class="flex flex-col gap-space-md relative">
<!-- Sesi 1: Selesai -->
<div class="bg-surface-card rounded-2xl p-space-lg shadow-sm flex flex-col md:flex-row gap-space-md items-start md:items-center justify-between">
<div class="flex items-start gap-space-md min-w-0">
<div class="flex flex-col items-center justify-center p-space-sm rounded-xl bg-canvas-bg min-w-[5.5rem] text-center shrink-0">
<span class="font-title-sm text-title-sm font-bold text-on-surface">09:00</span>
<span class="font-caption text-caption text-text-muted">10:30 WIB</span>
<span class="mt-1 px-1.5 py-0.5 rounded-full bg-success/15 text-success font-label-sm text-label-sm font-semibold">Selesai</span>
</div>
<div class="flex flex-col min-w-0">
<div class="flex items-center gap-space-xs flex-wrap">
<span class="px-2 py-0.5 rounded-full bg-surface-container text-primary font-label-sm text-label-sm font-semibold">Teori Fundamental</span>
<span class="font-caption text-caption text-text-muted">• 90 Menit</span>
</div>
<h4 class="font-headline-md text-headline-md text-on-surface mt-1 truncate">Sesi Teori: Arsitektur Relasi Database &amp; Supabase Schema</h4>
<div class="flex items-center gap-space-xs mt-1 text-text-muted">
<img class="w-5 h-5 rounded-full object-cover" data-alt="Close up professional portrait of Fajar Ramadhan, a male senior software engineer with glasses, soft studio lighting in a modern edtech studio." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDdBK1w-WpWL8sK2tcZ2AFUX6tDOZdwD9Vpt4bTsXeNPtRRgjciaTtauPs2nGlulAqBYuC3srNKFkVT8bwc6LIjOdz4dfc9GwXJ8DHpFqz8UQ8EG605swytI6T0KkDGAoNFFQm953n8uQQcoyyr2_DLnJIhhgojU8cTovVZad8bQ5d8u1aVJrNhWOD3qrhiXk6DZenknyNdnrQawPPvE3SJgBHwTlI2l5Ic0sVQBuniCJFoNTvBF30yhA"/>
<span class="font-body-sm text-body-sm">Tutor: <span class="text-on-surface font-medium">Fajar Ramadhan</span></span>
<span class="text-xs">•</span>
<span class="font-caption text-caption text-success font-medium flex items-center gap-0.5">
<span class="material-symbols-outlined text-xs">check_small</span> Presensi Tercatat
                  </span>
</div>
</div>
</div>
<div class="flex items-center gap-space-xs shrink-0 self-end md:self-center">
<a class="inline-flex items-center gap-space-xs px-space-md py-2 bg-surface-container text-primary hover:bg-surface-container-high rounded-full font-label-md text-label-md transition-colors" href="#">
<span class="material-symbols-outlined text-base">play_circle</span>
<span>Tonton Rekaman</span>
</a>
<button aria-label="Materi presentasi" class="p-2 rounded-full bg-canvas-bg text-text-muted hover:text-on-surface transition-colors" type="button">
<span class="material-symbols-outlined text-lg">download</span>
</button>
</div>
</div>
<!-- Sesi 2: Selesai (Hands-on) -->
<div class="bg-surface-card rounded-2xl p-space-lg shadow-sm flex flex-col md:flex-row gap-space-md items-start md:items-center justify-between">
<div class="flex items-start gap-space-md min-w-0">
<div class="flex flex-col items-center justify-center p-space-sm rounded-xl bg-canvas-bg min-w-[5.5rem] text-center shrink-0">
<span class="font-title-sm text-title-sm font-bold text-on-surface">13:30</span>
<span class="font-caption text-caption text-text-muted">15:00 WIB</span>
<span class="mt-1 px-1.5 py-0.5 rounded-full bg-success/15 text-success font-label-sm text-label-sm font-semibold">Selesai</span>
</div>
<div class="flex flex-col min-w-0">
<div class="flex items-center gap-space-xs flex-wrap">
<span class="px-2 py-0.5 rounded-full bg-surface-container text-secondary font-label-sm text-label-sm font-semibold">Hands-on Workshop</span>
<span class="font-caption text-caption text-text-muted">• 90 Menit</span>
</div>
<h4 class="font-headline-md text-headline-md text-on-surface mt-1 truncate">Live Coding Lab: Hands-on Query &amp; Foreign Key</h4>
<div class="flex items-center gap-space-xs mt-1 text-text-muted">
<span class="material-symbols-outlined text-sm text-primary">terminal</span>
<span class="font-body-sm text-body-sm text-on-surface font-medium">Lab Lingkungan: Postgres &amp; Prisma CLI</span>
<span class="text-xs">•</span>
<span class="font-caption text-caption text-text-muted">Tugas Selesai Terverifikasi</span>
</div>
</div>
</div>
<div class="flex items-center gap-space-xs shrink-0 self-end md:self-center">
<a class="inline-flex items-center gap-space-xs px-space-md py-2 bg-surface-container text-primary hover:bg-surface-container-high rounded-full font-label-md text-label-md transition-colors" href="#">
<span class="material-symbols-outlined text-base">code</span>
<span>Code Repository GitHub</span>
</a>
</div>
</div>
<!-- Sesi 3: ACTIVE CURRENT SESSION (Highlighted Blue Gradient) -->
<div class="relative overflow-hidden rounded-2xl p-space-lg text-on-primary shadow-xl bg-gradient-to-r from-primary-container via-primary to-surface-tint">
<!-- Subtle backdrop particle / glow element -->
<div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
<div class="relative z-10 flex flex-col md:flex-row gap-space-md items-start md:items-center justify-between">
<div class="flex items-start gap-space-md min-w-0">
<div class="flex flex-col items-center justify-center p-space-sm rounded-xl bg-white/15 backdrop-blur-md min-w-[5.5rem] text-center shrink-0">
<span class="font-title-sm text-title-sm font-bold text-white">15:30</span>
<span class="font-caption text-caption text-on-primary-container">17:00 WIB</span>
<div class="mt-1 flex items-center gap-1 px-1.5 py-0.5 rounded-full bg-white text-primary font-label-sm text-label-sm font-bold animate-pulse">
<span class="w-1.5 h-1.5 rounded-full bg-danger"></span>
<span>LIVE</span>
</div>
</div>
<div class="flex flex-col min-w-0">
<div class="flex items-center gap-space-xs flex-wrap">
<span class="px-2 py-0.5 rounded-full bg-white/20 text-white font-label-sm text-label-sm font-semibold">1-on-1 Mentoring</span>
<span class="font-caption text-caption text-on-primary-container">Sedang Berlangsung</span>
</div>
<h4 class="font-headline-lg text-headline-lg text-white mt-1">Mentoring 1-on-1 &amp; Code Review Challenge 5</h4>
<div class="flex items-center gap-space-sm mt-1.5 flex-wrap">
<div class="flex items-center gap-space-xs">
<img class="w-6 h-6 rounded-full object-cover border-subtle" data-alt="Friendly Indonesian female senior frontend mentor Sarah Anindita smiling in a brightly lit modern tech company office." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCAuTaIkxgq8LbH8aVImO3T2ibIt7I2l8rkzyeQXH94_vBACKlHmMXKaflvpIbYyRk3lf1nk9SsyNajgaeIhIcnaBR9MiqxpZFeZrLjEOOi3WrLi2CISeR49GAi9oRjWPw9NArorP8EaM4HpMoNHAZD4bnGewj654vnq-cFEmYs-udCYxVQ5sizBRk8fsf5sWqQbCDmNBKVqBF3DpZHQijddfcGYd4cVo1Nbt4EjK394pzY89J-AkbGqw"/>
<span class="font-body-sm text-body-sm text-white font-medium">Sarah Anindita</span>
<span class="text-xs text-on-primary-container">(Lead Mentor)</span>
</div>
<span class="text-on-primary-container">•</span>
<div class="flex items-center gap-1 text-on-primary-container font-caption text-caption">
<span class="material-symbols-outlined text-sm">schedule</span>
<span>Tersisa 45 Menit</span>
</div>
</div>
</div>
</div>
<!-- Call to Action Button -->
<div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-space-xs shrink-0 self-stretch md:self-center">
<a class="inline-flex items-center justify-center gap-space-xs px-space-lg py-3 bg-white text-primary font-label-md text-label-md font-bold rounded-full shadow-lg hover:bg-surface-bright transition-all transform hover:-translate-y-0.5" href="#">
<span class="material-symbols-outlined text-lg text-primary">videocam</span>
<span>Masuk Google Meet / Zoom</span>
</a>
</div>
</div>
<div class="mt-space-md pt-space-sm border-t border-white/10 flex items-center justify-between text-on-primary-container text-xs">
<span class="flex items-center gap-1">
<span class="material-symbols-outlined text-xs">info</span>
                Presensi akan diverifikasi otomatis setelah 15 menit kehadiran aktif.
              </span>
<span class="font-medium text-white hidden sm:inline">ID Sesi: ASL-B4-MTR-08</span>
</div>
</div>
<!-- Section Break: Upcoming Tomorrow -->
<div class="flex items-center gap-space-xs pt-space-xs pl-space-xs">
<span class="w-2.5 h-2.5 rounded-full bg-text-muted"></span>
<h3 class="font-title-sm text-title-sm text-on-surface font-semibold">Kamis, 19 Oktober 2024 — Besok</h3>
</div>
<!-- Sesi Besok -->
<div class="bg-surface-card rounded-2xl p-space-lg shadow-sm flex flex-col md:flex-row gap-space-md items-start md:items-center justify-between">
<div class="flex items-start gap-space-md min-w-0">
<div class="flex flex-col items-center justify-center p-space-sm rounded-xl bg-canvas-bg min-w-[5.5rem] text-center shrink-0">
<span class="font-title-sm text-title-sm font-bold text-on-surface">10:00</span>
<span class="font-caption text-caption text-text-muted">12:00 WIB</span>
<span class="mt-1 px-1.5 py-0.5 rounded-full bg-surface-container text-secondary font-label-sm text-label-sm font-semibold">Mendatang</span>
</div>
<div class="flex flex-col min-w-0">
<div class="flex items-center gap-space-xs flex-wrap">
<span class="px-2 py-0.5 rounded-full bg-surface-container text-secondary font-label-sm text-label-sm font-semibold">Kolaborasi Kelompok</span>
<span class="font-caption text-caption text-text-muted">• Ruang Diskusi 2</span>
</div>
<h4 class="font-headline-md text-headline-md text-on-surface mt-1 truncate">Sesi Diskusi Kelompok Guru &amp; Siswa: Prototype LMS</h4>
<div class="flex items-center gap-space-xs mt-1 text-text-muted">
<span class="material-symbols-outlined text-sm text-secondary">groups</span>
<span class="font-body-sm text-body-sm">Kelompok 3: EdTech Portal • 5 Anggota Tim</span>
</div>
</div>
</div>
<div class="flex items-center gap-space-xs shrink-0 self-end md:self-center">
<button class="inline-flex items-center gap-space-xs px-space-md py-2 bg-canvas-bg text-on-surface hover:bg-surface-container rounded-full font-label-md text-label-md transition-colors" type="button">
<span class="material-symbols-outlined text-base">notifications_active</span>
<span>Pasang Pengingat</span>
</button>
</div>
</div>
</div>
</div>
</div>
<!-- Right 4 Columns: Documentation & Policy Rails -->
<div class="lg:col-span-4 flex flex-col gap-space-lg">
<!-- Card: Dokumentasi & Rekaman Pertemuan Terbaru -->
<div class="bg-surface-card rounded-2xl p-space-lg shadow-sm flex flex-col gap-space-md">
<div class="flex items-center justify-between">
<div class="flex items-center gap-space-xs">
<span class="material-symbols-outlined text-primary text-xl">smart_display</span>
<h3 class="font-title-sm text-title-sm text-on-surface font-semibold">Dokumentasi &amp; Rekaman</h3>
</div>
<a class="font-label-sm text-label-sm text-primary hover:underline font-semibold" href="#">Lihat Semua</a>
</div>
<p class="font-body-sm text-body-sm text-text-muted">Akses arsip video pembelajaran terdahulu beserta rangkuman materi PDF dan slide deck.</p>
<div class="flex flex-col gap-space-sm">
<!-- Item 1 -->
<div class="p-space-sm rounded-xl bg-canvas-bg flex flex-col gap-2 hover:bg-surface-container transition-colors">
<div class="flex items-center justify-between">
<span class="font-label-sm text-label-sm text-secondary font-semibold">Modul 3: Backend REST</span>
<span class="font-caption text-caption text-text-muted">16 Okt 2024</span>
</div>
<div class="font-title-sm text-title-sm text-on-surface font-semibold line-clamp-1">
              Building Robust REST APIs dengan Express &amp; TypeScript
            </div>
<div class="flex items-center justify-between pt-1">
<div class="flex items-center gap-space-xs text-text-muted font-caption text-caption">
<span class="material-symbols-outlined text-xs">timer</span>
<span>1j 42m</span>
<span>•</span>
<span class="text-success font-medium">Tersedia</span>
</div>
<a class="text-primary font-label-sm text-label-sm font-semibold hover:underline flex items-center gap-0.5" href="#">
<span>Rangkuman</span>
<span class="material-symbols-outlined text-xs">arrow_forward</span>
</a>
</div>
</div>
<!-- Item 2 -->
<div class="p-space-sm rounded-xl bg-canvas-bg flex flex-col gap-2 hover:bg-surface-container transition-colors">
<div class="flex items-center justify-between">
<span class="font-label-sm text-label-sm text-secondary font-semibold">Modul 3: Authentication</span>
<span class="font-caption text-caption text-text-muted">13 Okt 2024</span>
</div>
<div class="font-title-sm text-title-sm text-on-surface font-semibold line-clamp-1">
              JWT Token Implementation &amp; Security Best Practices
            </div>
<div class="flex items-center justify-between pt-1">
<div class="flex items-center gap-space-xs text-text-muted font-caption text-caption">
<span class="material-symbols-outlined text-xs">timer</span>
<span>1j 28m</span>
<span>•</span>
<span class="text-success font-medium">Tersedia</span>
</div>
<a class="text-primary font-label-sm text-label-sm font-semibold hover:underline flex items-center gap-0.5" href="#">
<span>Rangkuman</span>
<span class="material-symbols-outlined text-xs">arrow_forward</span>
</a>
</div>
</div>
<!-- Item 3 -->
<div class="p-space-sm rounded-xl bg-canvas-bg flex flex-col gap-2 hover:bg-surface-container transition-colors">
<div class="flex items-center justify-between">
<span class="font-label-sm text-label-sm text-secondary font-semibold">Modul 2: State Management</span>
<span class="font-caption text-caption text-text-muted">10 Okt 2024</span>
</div>
<div class="font-title-sm text-title-sm text-on-surface font-semibold line-clamp-1">
              Optimistic UI with Zustand &amp; TanStack Query v5
            </div>
<div class="flex items-center justify-between pt-1">
<div class="flex items-center gap-space-xs text-text-muted font-caption text-caption">
<span class="material-symbols-outlined text-xs">timer</span>
<span>2j 05m</span>
<span>•</span>
<span class="text-success font-medium">Tersedia</span>
</div>
<a class="text-primary font-label-sm text-label-sm font-semibold hover:underline flex items-center gap-0.5" href="#">
<span>Rangkuman</span>
<span class="material-symbols-outlined text-xs">arrow_forward</span>
</a>
</div>
</div>
</div>
</div>
<!-- Card: Aturan Presensi & Kebijakan Kelulusan -->
<div class="bg-surface-card rounded-2xl p-space-lg shadow-sm flex flex-col gap-space-sm">
<div class="flex items-center gap-space-xs">
<div class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center text-primary">
<span class="material-symbols-outlined text-base">rule</span>
</div>
<h3 class="font-title-sm text-title-sm text-on-surface font-semibold">Aturan Presensi Otomatis</h3>
</div>
<div class="flex flex-col gap-space-xs pt-space-xs font-body-sm text-body-sm text-on-surface-variant">
<div class="flex items-start gap-space-xs">
<span class="material-symbols-outlined text-success text-base shrink-0 mt-0.5">check_circle</span>
<span><strong class="text-on-surface">Auto-Sync Zoom/Meet:</strong> Sistem mencatat kehadiran siswa saat bergabung minimal 45 menit dari total durasi.</span>
</div>
<div class="flex items-start gap-space-xs">
<span class="material-symbols-outlined text-success text-base shrink-0 mt-0.5">check_circle</span>
<span><strong class="text-on-surface">Syarat Kelulusan Batch:</strong> Minimal 85% kehadiran live session di setiap modul berjalan.</span>
</div>
<div class="flex items-start gap-space-xs">
<span class="material-symbols-outlined text-warning text-base shrink-0 mt-0.5">warning</span>
<span><strong class="text-on-surface">Kompensasi Sakit/Izin:</strong> Wajib menonton rekaman penuh dan mengisi quiz rangkuman dalam waktu 2x24 jam.</span>
</div>
</div>
<div class="mt-space-xs pt-space-xs">
<a class="w-full inline-flex items-center justify-center gap-space-xs py-2 px-space-md rounded-full bg-canvas-bg hover:bg-surface-container text-on-surface font-label-md text-label-md transition-colors" href="#">
<span class="material-symbols-outlined text-sm">article</span>
<span>Buku Panduan Akademik Asalink</span>
</a>
</div>
</div>
<!-- Card: Mentor Hub Quick Action -->
<div class="bg-surface-card rounded-2xl p-space-lg shadow-sm flex items-center justify-between">
<div class="flex items-center gap-space-sm">
<img class="w-10 h-10 rounded-full object-cover" data-alt="Portrait of an Indonesian female academic advisor with warm friendly smile in modern university office." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDo5NOusEIavN8C8F2eBfbiaazQTZOIRPA23rxrRcY2TkpPudklEmRNq003d8L_hZ4rtXPnJC42XcXKoErC4_Y8jxt_I-RISXtiXj9e7WNHGAwLGAb5u8r7YmnCo1nZTPOl5waqRwVdxmPzMzUbvQISrUP1j1bbGkjp9b2XaaOL_iDce7qmnBBwp4O8umukxFFnP5e2Tp8102dn3ls4_koytGsNhynHBF_f-oAprThhVw4w3ccy-CiEMw"/>
<div class="flex flex-col">
<span class="font-title-sm text-title-sm font-semibold text-on-surface">Konsultasi Jadwal?</span>
<span class="font-caption text-caption text-text-muted">Hubungi Academic Counselor</span>
</div>
</div>
<button aria-label="Kirim pesan bantuan" class="w-9 h-9 rounded-full bg-primary text-on-primary flex items-center justify-center hover:bg-primary-container transition-colors shadow-sm" type="button">
<span class="material-symbols-outlined text-base">chat</span>
</button>
</div>
</div>
</div>
</div>
@endsection
