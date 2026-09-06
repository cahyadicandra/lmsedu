@props(['schedules'])

<div class="bg-surface-card rounded-[20px] p-space-lg shadow-sm flex flex-col gap-space-md">
<div class="flex items-center justify-between">
<div>
<span class="font-caption text-caption uppercase tracking-wider text-text-muted font-semibold">Agenda Belajar</span>
<h2 class="font-headline-md text-headline-md text-on-surface font-bold">Jadwal Hari Ini</h2>
</div>
<!-- Date Pill Filter -->
<div class="flex items-center gap-1 bg-canvas-bg px-space-sm py-1.5 rounded-full text-on-surface font-label-sm text-label-sm font-semibold">
<span class="material-symbols-outlined text-sm text-primary">calendar_today</span>
<span>5 Sep 2026</span>
</div>
</div>
<!-- Weekly mini calendar strip -->
<div class="grid grid-cols-7 gap-1 py-space-xs text-center">
<div class="flex flex-col items-center py-1.5 rounded-xl bg-transparent text-text-muted">
<span class="font-caption text-[10px]">Sen</span>
<span class="font-label-sm text-label-sm font-semibold">1</span>
</div>
<div class="flex flex-col items-center py-1.5 rounded-xl bg-transparent text-text-muted">
<span class="font-caption text-[10px]">Sel</span>
<span class="font-label-sm text-label-sm font-semibold">2</span>
</div>
<div class="flex flex-col items-center py-1.5 rounded-xl bg-transparent text-text-muted">
<span class="font-caption text-[10px]">Rab</span>
<span class="font-label-sm text-label-sm font-semibold">3</span>
</div>
<div class="flex flex-col items-center py-1.5 rounded-xl bg-transparent text-text-muted">
<span class="font-caption text-[10px]">Kam</span>
<span class="font-label-sm text-label-sm font-semibold">4</span>
</div>
<!-- Active Today -->
<div class="flex flex-col items-center py-1.5 rounded-xl bg-primary-container text-on-primary shadow-sm">
<span class="font-caption text-[10px] font-medium">Jum</span>
<span class="font-label-sm text-label-sm font-bold">5</span>
</div>
<div class="flex flex-col items-center py-1.5 rounded-xl bg-transparent text-text-muted">
<span class="font-caption text-[10px]">Sab</span>
<span class="font-label-sm text-label-sm font-semibold">6</span>
</div>
<div class="flex flex-col items-center py-1.5 rounded-xl bg-transparent text-text-muted">
<span class="font-caption text-[10px]">Min</span>
<span class="font-label-sm text-label-sm font-semibold">7</span>
</div>
</div>
<!-- Timeline Items Stack -->
<div class="relative pl-6 space-y-space-md before:absolute before:left-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-border-subtle before:border-dashed">
<!-- Item 1: Past / Completed -->
<div class="relative flex flex-col gap-1 text-left">
<span class="absolute -left-6 top-1.5 w-3.5 h-3.5 rounded-full bg-success ring-4 ring-white flex items-center justify-center">
<span class="material-symbols-outlined text-[10px] text-white">check</span>
</span>
<div class="flex items-center justify-between text-caption font-caption text-text-muted">
<span>09:00 - 10:30 WIB</span>
<span class="text-success font-medium">Selesai</span>
</div>
<div class="p-space-sm rounded-xl bg-canvas-bg/50">
<h4 class="font-title-sm text-body-md font-semibold text-on-surface">Quiz Harian: Asynchronous JavaScript</h4>
<p class="font-caption text-caption text-text-muted">Nilai: 96/100 • Tersimpan otomatis</p>
</div>
</div>
<!-- Item 2: ONGOING LIVE LESSON (HIGHLIGHTED SOLID BLUE #5B75E6) -->
<div class="relative flex flex-col gap-1 text-left">
<span class="absolute -left-6 top-2 w-3.5 h-3.5 rounded-full bg-warning ring-4 ring-white animate-ping"></span>
<span class="absolute -left-6 top-2 w-3.5 h-3.5 rounded-full bg-primary-container ring-4 ring-white"></span>
<div class="flex items-center justify-between text-caption font-caption text-primary font-bold">
<span class="flex items-center gap-1">
<span class="w-2 h-2 rounded-full bg-danger animate-pulse"></span>
                SEKARANG • 14:00 - 15:30 WIB
              </span>
<span class="px-2 py-0.5 rounded-full bg-danger text-white text-[10px] font-bold tracking-wider uppercase">Live Sesi 14</span>
</div>
<!-- Elevated Solid Blue Card -->
<div class="p-space-md rounded-2xl bg-[#5B75E6] text-white shadow-lg space-y-space-xs">
<div class="flex items-start justify-between">
<div>
<h4 class="font-title-sm text-title-sm font-bold leading-tight">Live Coding: State Management &amp; Redux</h4>
<p class="font-caption text-caption text-blue-100 mt-0.5">Bersama Fajar Ramadhan • Zoom Room #2</p>
</div>
<span class="material-symbols-outlined text-white/90 text-2xl">sensors</span>
</div>
<p class="font-body-sm text-body-sm text-white/90 leading-normal">
                Membahas persistensi state, reducer slice, dan middleware Redux Toolkit secara hands-on.
              </p>
<div class="pt-space-xs flex items-center justify-between gap-2">
<button class="w-full py-2 px-space-md rounded-full bg-white text-primary font-label-sm text-label-sm font-bold shadow hover:bg-surface-bright transition-transform active:scale-95 flex items-center justify-center gap-1.5">
<span class="material-symbols-outlined text-base">video_camera_front</span>
<span>Masuk Kelas Sekarang</span>
</button>
</div>
</div>
</div>
<!-- Item 3: Upcoming 1 -->
<div class="relative flex flex-col gap-1 text-left">
<span class="absolute -left-6 top-1.5 w-3.5 h-3.5 rounded-full bg-outline-variant ring-4 ring-white"></span>
<div class="flex items-center justify-between text-caption font-caption text-text-muted">
<span>16:00 - 16:45 WIB</span>
<span class="font-medium text-primary">Segera</span>
</div>
<div class="p-space-sm rounded-xl bg-canvas-bg/60 hover:bg-canvas-bg transition-colors">
<h4 class="font-title-sm text-body-md font-semibold text-on-surface">Review Challenge UI Dashboard</h4>
<p class="font-caption text-caption text-text-muted">Fase 3 • Feedback interaktif antarmuka siswa</p>
</div>
</div>
<!-- Item 4: Upcoming 2 -->
<div class="relative flex flex-col gap-1 text-left">
<span class="absolute -left-6 top-1.5 w-3.5 h-3.5 rounded-full bg-outline-variant ring-4 ring-white"></span>
<div class="flex items-center justify-between text-caption font-caption text-text-muted">
<span>19:00 - 20:00 WIB</span>
<span class="font-medium text-text-muted">Malam</span>
</div>
<div class="p-space-sm rounded-xl bg-canvas-bg/60 hover:bg-canvas-bg transition-colors">
<h4 class="font-title-sm text-body-md font-semibold text-on-surface">Diskusi Project Kelompok Guru &amp; Siswa</h4>
<p class="font-caption text-caption text-text-muted">Google Meet kelompok 4B • Sync progress sprint</p>
</div>
</div>
</div>
</div>
