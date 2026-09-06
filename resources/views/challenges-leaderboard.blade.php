@extends('layouts.app')

@section('content')
<div class="flex flex-col w-full gap-space-lg">
<div class="flex flex-col md:flex-row md:items-center justify-between gap-space-md">
<div>
<div class="flex items-center gap-space-xs text-primary-container font-label-md text-label-md font-semibold tracking-wider uppercase mb-1">
<span class="material-symbols-outlined text-base">workspace_premium</span>
<span>Evaluasi &amp; Prestasi Belajar</span>
</div>
<h1 class="font-headline-lg text-headline-lg text-on-surface font-bold tracking-tight">Tantangan Koding &amp; Papan Skor Peserta</h1>
<p class="font-body-sm text-body-sm text-text-muted mt-1">Uji kompetensi teknis, kumpulkan XP mingguan, dan pantau posisi peringkat Batch 4.</p>
</div>
<div class="flex items-center bg-surface-container-high/60 p-1 rounded-full self-start md:self-auto shadow-sm">
<button class="px-space-md py-2 rounded-full font-label-md text-label-md font-semibold bg-primary-container text-on-primary transition-all shadow-sm flex items-center gap-1.5" id="tab-active" onclick="switchTab('active')">
<span class="material-symbols-outlined text-sm">code</span>
<span>Tantangan Aktif</span>
</button>
<button class="px-space-md py-2 rounded-full font-label-md text-label-md font-medium text-text-muted hover:text-on-surface transition-all flex items-center gap-1.5" id="tab-history" onclick="switchTab('history')">
<span class="material-symbols-outlined text-sm">history_edu</span>
<span>Riwayat Pengumpulan</span>
</button>
<button class="px-space-md py-2 rounded-full font-label-md text-label-md font-medium text-text-muted hover:text-on-surface transition-all flex items-center gap-1.5" id="tab-leaderboard" onclick="switchTab('leaderboard')">
<span class="material-symbols-outlined text-sm">leaderboard</span>
<span>Leaderboard Batch 4</span>
</button>
</div>
</div>
<div class="relative overflow-hidden bg-surface-card rounded-2xl p-space-lg shadow-[0_8px_24px_rgba(62,88,184,0.06)]">
<div class="absolute -right-10 -bottom-10 w-64 h-64 bg-primary-fixed/20 rounded-full blur-3xl pointer-events-none"></div>
<div class="absolute right-1/3 -top-12 w-48 h-48 bg-secondary-fixed/30 rounded-full blur-2xl pointer-events-none"></div>
<div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-space-lg">
<div class="flex items-center gap-space-md">
<div class="relative">
<img alt="Nadia Kirana" class="w-16 h-16 rounded-full object-cover shadow-md" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAAmTg-lScXYNwriRRvGKHx5GW19BuSi8E8CnR2tR8JefvjFYaFEJmWIoSwLu0SG3JpGbZ1pno4YcRIi8zECYB-wFimrIuIGimtO_uoYKe-TDKP4_HAhjXkVq7wbCr3Mx8tGxz0xNHz-97__OqUoAvGPs25YB7yyj7CrfQIRC-Iik9UD08n8w17YlP_6cViFUTMVYl80rVHUYz9Mjjb6DtNVXtSR59ecCpMrWeY04t771aF_ZTpQGRlig"/>
<div class="absolute -bottom-1 -right-1 bg-amber-500 text-surface-card rounded-full w-6 h-6 flex items-center justify-center font-label-sm text-label-sm font-bold shadow-sm">
            #3
          </div>
</div>
<div>
<div class="flex items-center gap-2">
<h2 class="font-headline-md text-headline-md font-bold text-on-surface">Nadia Kirana</h2>
<span class="px-2.5 py-0.5 rounded-full bg-tertiary-fixed text-tertiary font-label-sm text-label-sm font-semibold">Tier: Challenger Pro</span>
</div>
<p class="font-body-sm text-body-sm text-text-muted mt-0.5">Frontend Engineering • Peserta Teraktif Minggu Ini</p>
</div>
</div>
<div class="grid grid-cols-2 sm:grid-cols-4 gap-space-md lg:gap-space-xl">
<div class="bg-canvas-bg/80 rounded-xl p-space-sm flex flex-col">
<span class="font-caption text-caption text-text-muted uppercase tracking-wider font-semibold">Posisi Peringkat</span>
<div class="flex items-baseline gap-1 mt-1">
<span class="font-display-metric text-display-metric text-primary-container leading-none">#3</span>
<span class="font-caption text-caption text-text-muted">/ 127 Peserta</span>
</div>
</div>
<div class="bg-canvas-bg/80 rounded-xl p-space-sm flex flex-col">
<span class="font-caption text-caption text-text-muted uppercase tracking-wider font-semibold">Total Perolehan</span>
<div class="flex items-baseline gap-1 mt-1">
<span class="font-display-metric text-display-metric text-primary leading-none">2,450</span>
<span class="font-label-sm text-label-sm font-bold text-primary">XP</span>
</div>
</div>
<div class="bg-canvas-bg/80 rounded-xl p-space-sm flex flex-col">
<span class="font-caption text-caption text-text-muted uppercase tracking-wider font-semibold">Terselesaikan</span>
<div class="flex items-baseline gap-1 mt-1">
<span class="font-display-metric text-display-metric text-success leading-none">14</span>
<span class="font-caption text-caption text-text-muted">Tantangan</span>
</div>
</div>
<div class="bg-canvas-bg/80 rounded-xl p-space-sm flex flex-col">
<span class="font-caption text-caption text-text-muted uppercase tracking-wider font-semibold">Status Pengajuan</span>
<div class="flex items-baseline gap-1 mt-1">
<span class="font-display-metric text-display-metric text-warning leading-none">1</span>
<span class="font-caption text-caption text-text-muted">Menunggu Review</span>
</div>
</div>
</div>
</div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg items-start">
<section class="lg:col-span-7 flex flex-col gap-space-md">
<div class="flex items-center justify-between">
<div class="flex items-center gap-space-xs">
<span class="material-symbols-outlined text-primary-container text-xl">bolt</span>
<h3 class="font-headline-md text-headline-md font-bold text-on-surface">Daftar Tantangan Koding</h3>
</div>
<div class="flex items-center gap-2">
<button class="px-3 py-1.5 rounded-full bg-surface-card text-on-surface font-label-md text-label-md shadow-sm hover:bg-canvas-bg transition-colors flex items-center gap-1">
<span class="material-symbols-outlined text-sm">filter_list</span>
<span>Semua Modul</span>
</button>
</div>
</div>
<div class="bg-surface-card rounded-2xl p-space-lg shadow-[0_8px_24px_rgba(62,88,184,0.05)] relative overflow-hidden transition-all hover:shadow-[0_12px_32px_rgba(62,88,184,0.1)]">
<div class="absolute top-0 left-0 bottom-0 w-1.5 bg-primary-container"></div>
<div class="flex flex-col gap-space-sm pl-2">
<div class="flex flex-wrap items-center justify-between gap-2">
<div class="flex items-center gap-2">
<span class="px-2.5 py-0.5 rounded-full bg-primary-fixed text-on-primary-fixed font-label-sm text-label-sm font-semibold">Sedang Dikerjakan</span>
<span class="px-2.5 py-0.5 rounded-full bg-canvas-bg text-on-surface-variant font-label-sm text-label-sm">Menengah</span>
</div>
<div class="flex items-center gap-1.5 text-warning font-label-md text-label-md font-semibold bg-amber-50 px-2.5 py-0.5 rounded-full">
<span class="material-symbols-outlined text-base">alarm</span>
<span>Tenggat: 2 Hari Lagi</span>
</div>
</div>
<div>
<h4 class="font-title-sm text-title-sm font-bold text-on-surface text-lg">Challenge #12: Buat State Management Dashboard dengan LocalStorage &amp; API Mock</h4>
<p class="font-body-sm text-body-sm text-text-muted mt-1 leading-relaxed">Bangun modul sinkronisasi state keranjang kursus menggunakan custom hook React/Vue serta simulasikan fallback data offline ketika koneksi internet terputus.</p>
</div>
<div class="bg-canvas-bg/60 rounded-xl p-space-sm flex flex-col gap-2">
<div class="flex justify-between items-center text-xs font-semibold text-on-surface-variant">
<span>Kelengkapan Kriteria (3/4 selesai)</span>
<span class="text-primary-container">75%</span>
</div>
<div class="w-full h-2 bg-chart-track/50 rounded-full overflow-hidden">
<div class="h-full bg-primary-container rounded-full" style="width: 75%"></div>
</div>
</div>
<div class="flex flex-wrap items-center justify-between gap-space-sm pt-2">
<div class="flex items-center gap-2">
<span class="w-8 h-8 rounded-full bg-primary-fixed flex items-center justify-center text-primary-container">
<span class="material-symbols-outlined text-lg">military_tech</span>
</span>
<div class="flex flex-col">
<span class="font-caption text-caption text-text-muted">Reward Kelulusan</span>
<span class="font-label-md text-label-md font-bold text-primary-container">+250 XP &amp; Badge Sync Master</span>
</div>
</div>
<button class="px-space-md py-2.5 rounded-full bg-primary-container text-on-primary font-label-md text-label-md font-semibold hover:bg-primary transition-colors flex items-center gap-2 shadow-sm" onclick="openSubmitModal()">
<span class="material-symbols-outlined text-lg">cloud_upload</span>
<span>Kirim Solusi / Submit Jawaban</span>
</button>
</div>
</div>
</div>
<div class="bg-surface-card rounded-2xl p-space-lg shadow-[0_8px_24px_rgba(62,88,184,0.05)] transition-all hover:shadow-[0_12px_32px_rgba(62,88,184,0.1)]">
<div class="flex flex-col gap-space-sm">
<div class="flex flex-wrap items-center justify-between gap-2">
<div class="flex items-center gap-2">
<span class="px-2.5 py-0.5 rounded-full bg-canvas-bg text-text-muted font-label-sm text-label-sm font-semibold">Tersedia untuk Diambil</span>
<span class="px-2.5 py-0.5 rounded-full bg-rose-100 text-danger font-label-sm text-label-sm font-semibold">Tingkat: Sulit</span>
</div>
<span class="text-text-muted font-label-sm text-label-sm">Rilis: Hari ini</span>
</div>
<div>
<h4 class="font-title-sm text-title-sm font-bold text-on-surface text-lg">Challenge #13: Implementasi Row Level Security (RLS) di Supabase</h4>
<p class="font-body-sm text-body-sm text-text-muted mt-1 leading-relaxed">Konfigurasikan kebijakan PostgreSQL RLS multi-tenant untuk sistem manajemen kursus agar instruktur hanya dapat membaca dan mengubah rekaman kelas milik mereka sendiri.</p>
</div>
<div class="flex flex-wrap items-center gap-space-xs text-text-muted font-caption text-caption">
<span class="px-2 py-0.5 bg-canvas-bg rounded">PostgreSQL</span>
<span class="px-2 py-0.5 bg-canvas-bg rounded">Supabase Auth</span>
<span class="px-2 py-0.5 bg-canvas-bg rounded">Database Policy</span>
</div>
<div class="flex flex-wrap items-center justify-between gap-space-sm pt-2">
<div class="flex items-center gap-2">
<span class="w-8 h-8 rounded-full bg-secondary-fixed flex items-center justify-center text-secondary">
<span class="material-symbols-outlined text-lg">stars</span>
</span>
<div class="flex flex-col">
<span class="font-caption text-caption text-text-muted">Potensi XP</span>
<span class="font-label-md text-label-md font-bold text-secondary">+350 XP</span>
</div>
</div>
<button class="px-space-md py-2 rounded-full bg-canvas-bg text-on-surface font-label-md text-label-md font-semibold hover:bg-primary-fixed/50 hover:text-primary transition-colors flex items-center gap-2">
<span class="material-symbols-outlined text-base">play_arrow</span>
<span>Mulai Kerjakan</span>
</button>
</div>
</div>
</div>
<div class="bg-surface-card rounded-2xl p-space-lg shadow-[0_8px_24px_rgba(62,88,184,0.05)] opacity-95">
<div class="flex flex-col gap-space-sm">
<div class="flex flex-wrap items-center justify-between gap-2">
<div class="flex items-center gap-2">
<span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-success font-label-sm text-label-sm font-semibold flex items-center gap-1">
<span class="material-symbols-outlined text-sm">check_circle</span>
<span>Tervalidasi Mentor</span>
</span>
<span class="px-2.5 py-0.5 rounded-full bg-canvas-bg text-text-muted font-label-sm text-label-sm">Dasar - Menengah</span>
</div>
<span class="font-title-sm text-title-sm font-bold text-success">Skor: 98 / 100</span>
</div>
<div>
<h4 class="font-title-sm text-title-sm font-bold text-on-surface">Challenge #11: Slicing UI Student Portal Responsive</h4>
<p class="font-body-sm text-body-sm text-text-muted mt-1">Mengonversi desain Figma kompleks menjadi layout Tailwind CSS fluid dengan grid adapts sempurna pada desktop dan smartphone.</p>
</div>
<div class="bg-surface-container-low rounded-xl p-space-sm flex items-start gap-space-sm">
<img alt="Lead Mentor" class="w-8 h-8 rounded-full object-contain bg-primary-container p-1 mt-0.5" src="https://lh3.googleusercontent.com/aida/AEtjO1UZG1lqU0gaad7nZDQFmzceYWWU98_huh2xnpvP9wxvrLaRCDU2MIqwhO9yfz8h-L0fBd2PJ1Kpvj6IgEZhHiXSsTJTVC3NxFOFWleTurbmJFIEFlIdS_21mgUpOOPUZNPrWtyshL7UZ4Tf0CHWvcZVqE3-wbg2EqW4tVDA60Tv4ZH-3dR3abBhclJAh3QygymdHVTaMWSR6XaTGe21eLb7agNe2HvXJhGMmFOGkLS84HnQ0X0FnJa2ootR"/>
<div class="flex-1">
<div class="flex items-center justify-between">
<span class="font-label-md text-label-md font-bold text-primary">Catatan Lead Reviewer (Bramantyo, S.Kom.)</span>
<span class="font-caption text-caption text-text-muted">3 hari lalu</span>
</div>
<p class="font-body-sm text-body-sm text-on-surface-variant italic mt-0.5">“Sangat rapi dan modular! Struktur semantic HTML tepat sasaran dan integrasi variable Tailwind selaras dengan design token sistem.”</p>
</div>
</div>
</div>
</div>
</section>
<aside class="lg:col-span-5 flex flex-col gap-space-md">
<div class="flex items-center justify-between">
<div class="flex items-center gap-space-xs">
<span class="material-symbols-outlined text-primary-container text-xl">emoji_events</span>
<h3 class="font-headline-md text-headline-md font-bold text-on-surface">Papan Skor Batch 4</h3>
</div>
<span class="font-caption text-caption text-text-muted bg-surface-card px-2.5 py-1 rounded-full shadow-sm">Update 10m lalu</span>
</div>
<div class="bg-surface-card rounded-2xl p-space-lg shadow-[0_8px_24px_rgba(62,88,184,0.06)] flex flex-col">
<div class="text-center pb-space-sm">
<span class="font-caption text-caption font-bold text-primary tracking-wider uppercase">Top 3 Leaderboard Mingguan</span>
</div>
<div class="flex items-end justify-center gap-2 sm:gap-4 pt-space-md pb-2">
<div class="flex flex-col items-center flex-1">
<div class="relative mb-2">
<img class="w-14 h-14 rounded-full object-cover shadow-md" data-alt="Warm photographic headshot portrait of a cheerful Indonesian female computer science student named Aisyah wearing a light pastel hijab, studio lighting, clean soft corporate navy and white aesthetic." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCdd84pz1eIceJvp02MFx-IMQymR3uEKulq0foOKKs8V-RrV06tIMyNo0Kix5N4fUvPjzt8h8X0Qv_PWrdh0RiHE_lIJUUAxkUctlPjfpsXm576LAcEuEjAPrOo1SqTjqcDjigDuMoBtjM6LLE7RJ2o2Kf_A-XSVvHyCWyAQZ-T9Vdv1vVjGfJFRf03lppXC1whzBpWUgNJPL_6iLeg-ooomPsg4e6i2j6H_StjgGlnYRjDE6gIHmssuQ"/>
<div class="absolute -bottom-2 left-1/2 -translate-x-1/2 bg-slate-300 text-slate-800 text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">
                #2
              </div>
</div>
<span class="font-label-md text-label-md font-bold text-on-surface text-center truncate w-24">Aisyah Putri</span>
<span class="font-caption text-caption text-primary-container font-semibold">2,610 XP</span>
<div class="w-full bg-surface-container-high rounded-t-xl h-24 mt-2 flex items-center justify-center flex-col">
<span class="material-symbols-outlined text-slate-400 text-2xl">workspace_premium</span>
<span class="font-caption text-caption text-text-muted font-bold">PERAK</span>
</div>
</div>
<div class="flex flex-col items-center flex-1">
<div class="relative mb-2">
<div class="absolute -top-3 left-1/2 -translate-x-1/2 text-amber-500">
<span class="material-symbols-outlined text-xl">crown</span>
</div>
<img class="w-16 h-16 rounded-full object-cover shadow-lg" data-alt="Portrait of a focused Indonesian male software developer named Kevin wearing spectacles and modern casual navy collared shirt, confident expression, gentle natural studio lighting." src="https://lh3.googleusercontent.com/aida-public/AB6AXuAn8tkoMzka_44QSx8K_xeVemr0YgNA5CXVCzVUhb-tWxGW_6ud1Xy7grnf9Vq21TfVLQNXu7-lkevPCSVBovCt4fsyUQ415-QP02jHeIIU7iHNsoiEaA6o3G--NJHRSNYAaFYCJ7tSQfpWpa9O2Nv9UdPrhB6r_e39FLBub7rztdg7v55qOEEEUx2jOo3mnUcph0tQ68DjS8n1XZPmPn9O2Xme1rVV1am6Wuv3DM2hUvIDFW8JTlb3WQ"/>
<div class="absolute -bottom-2 left-1/2 -translate-x-1/2 bg-amber-400 text-amber-950 text-[11px] font-extrabold px-2.5 py-0.5 rounded-full shadow-sm">
                #1
              </div>
</div>
<span class="font-label-md text-label-md font-bold text-on-surface text-center truncate w-28">Kevin Pratama</span>
<span class="font-label-sm text-label-sm text-primary-container font-bold">2,820 XP</span>
<div class="w-full bg-primary-container rounded-t-xl h-32 mt-2 flex items-center justify-center flex-col text-on-primary">
<span class="material-symbols-outlined text-amber-300 text-3xl">military_tech</span>
<span class="font-caption text-caption font-bold text-on-primary-container">EMAS</span>
</div>
</div>
<div class="flex flex-col items-center flex-1">
<div class="relative mb-2">
<img alt="Nadia Kirana" class="w-14 h-14 rounded-full object-cover shadow-md" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAAmTg-lScXYNwriRRvGKHx5GW19BuSi8E8CnR2tR8JefvjFYaFEJmWIoSwLu0SG3JpGbZ1pno4YcRIi8zECYB-wFimrIuIGimtO_uoYKe-TDKP4_HAhjXkVq7wbCr3Mx8tGxz0xNHz-97__OqUoAvGPs25YB7yyj7CrfQIRC-Iik9UD08n8w17YlP_6cViFUTMVYl80rVHUYz9Mjjb6DtNVXtSR59ecCpMrWeY04t771aF_ZTpQGRlig"/>
<div class="absolute -bottom-2 left-1/2 -translate-x-1/2 bg-amber-600 text-surface-card text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">
                #3
              </div>
</div>
<span class="font-label-md text-label-md font-bold text-on-surface text-center truncate w-24">Nadia (Anda)</span>
<span class="font-caption text-caption text-primary-container font-semibold">2,450 XP</span>
<div class="w-full bg-surface-container rounded-t-xl h-20 mt-2 flex items-center justify-center flex-col">
<span class="material-symbols-outlined text-amber-700 text-2xl">workspace_premium</span>
<span class="font-caption text-caption text-text-muted font-bold">PERUNGGU</span>
</div>
</div>
</div>
<div class="mt-space-md flex flex-col gap-2 pt-space-sm bg-canvas-bg/40 rounded-xl p-2">
<div class="flex items-center justify-between p-2 rounded-lg bg-surface-card shadow-sm hover:bg-surface-container-low transition-colors">
<div class="flex items-center gap-space-sm min-w-0">
<span class="font-label-md text-label-md font-bold text-text-muted w-5 text-center">#4</span>
<img class="w-8 h-8 rounded-full object-cover" data-alt="Portrait avatar of a smiling Southeast Asian male student named Dimas with short styled hair and casual tech attire, clean soft blue backdrop, approachable expression." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCd5HkPRSmyKmiks2M0Ktzgkj3oRlMbzszUKBdwOq0VsBYtgf536WKMnNu5BAUY8seseXtUtZtlfD0lpKm6qX7-iTFnlY42taSYCGIvipG0o7CxY1zrcNAzRrAoIOVww9CWdTyW90z943atNryDpK_Wy2NYteialtYepp3Ouvov39aXHHfEyho3IBs73P30gb79hRe0zOwpu0ZfADlQ97_4q_PcPto0IaQGK-0Yjb-q1kzZjCrOiUQjdQ"/>
<div class="flex flex-col min-w-0">
<span class="font-label-md text-label-md font-semibold text-on-surface truncate">Dimas Prasetyo</span>
<span class="font-caption text-caption text-text-muted">13 Tantangan Selesai</span>
</div>
</div>
<span class="font-label-md text-label-md font-bold text-primary-container">2,380 XP</span>
</div>
<div class="flex items-center justify-between p-2 rounded-lg bg-surface-card shadow-sm hover:bg-surface-container-low transition-colors">
<div class="flex items-center gap-space-sm min-w-0">
<span class="font-label-md text-label-md font-bold text-text-muted w-5 text-center">#5</span>
<div class="w-8 h-8 rounded-full bg-secondary-fixed-dim text-on-secondary-fixed flex items-center justify-center font-label-sm text-label-sm font-bold">
                RZ
              </div>
<div class="flex flex-col min-w-0">
<span class="font-label-md text-label-md font-semibold text-on-surface truncate">Rizky Zakaria</span>
<span class="font-caption text-caption text-text-muted">12 Tantangan Selesai</span>
</div>
</div>
<span class="font-label-md text-label-md font-bold text-primary-container">2,240 XP</span>
</div>
<div class="flex items-center justify-between p-2 rounded-lg bg-surface-card shadow-sm hover:bg-surface-container-low transition-colors">
<div class="flex items-center gap-space-sm min-w-0">
<span class="font-label-md text-label-md font-bold text-text-muted w-5 text-center">#6</span>
<img class="w-8 h-8 rounded-full object-cover" data-alt="Professional headshot of an Indonesian woman named Farah in minimalist modern hijab and blazer smiling cordially in an edtech studio setting." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDj-iP0RoEdt_XIA3xmhLygl-cY_BWZ_xDz6n4SfkUQ0HuzLhJeStP3z4ePOy9wOFZ7CBdP4r2o4CqKUD374PbleiAEJrf3y42kTX8t5CrMIl7hoeFfRyLmPK1i1pH7-2R-QsYgRHaLlst1aHiZF1RbEOiBCJ55kBFL9vGf5YmIZGEQWWrvxLFg5mBk5JMn8rDBmTV0c6ybq7SBVAOxvCBJl-02_obOv2jICQlxV-iBlUYbKpARfl4FqQ"/>
<div class="flex flex-col min-w-0">
<span class="font-label-md text-label-md font-semibold text-on-surface truncate">Farah Nabila</span>
<span class="font-caption text-caption text-text-muted">12 Tantangan Selesai</span>
</div>
</div>
<span class="font-label-md text-label-md font-bold text-primary-container">2,190 XP</span>
</div>
<div class="flex items-center justify-between p-2 rounded-lg bg-surface-card shadow-sm hover:bg-surface-container-low transition-colors">
<div class="flex items-center gap-space-sm min-w-0">
<span class="font-label-md text-label-md font-bold text-text-muted w-5 text-center">#7</span>
<div class="w-8 h-8 rounded-full bg-tertiary-fixed text-on-tertiary-fixed flex items-center justify-center font-label-sm text-label-sm font-bold">
                BP
              </div>
<div class="flex flex-col min-w-0">
<span class="font-label-md text-label-md font-semibold text-on-surface truncate">Bagus Pangestu</span>
<span class="font-caption text-caption text-text-muted">11 Tantangan Selesai</span>
</div>
</div>
<span class="font-label-md text-label-md font-bold text-primary-container">2,050 XP</span>
</div>
<div class="flex items-center justify-between p-2 rounded-lg bg-surface-card shadow-sm hover:bg-surface-container-low transition-colors">
<div class="flex items-center gap-space-sm min-w-0">
<span class="font-label-md text-label-md font-bold text-text-muted w-5 text-center">#8</span>
<div class="w-8 h-8 rounded-full bg-surface-variant text-on-surface-variant flex items-center justify-center font-label-sm text-label-sm font-bold">
                SS
              </div>
<div class="flex flex-col min-w-0">
<span class="font-label-md text-label-md font-semibold text-on-surface truncate">Siti Sarah</span>
<span class="font-caption text-caption text-text-muted">11 Tantangan Selesai</span>
</div>
</div>
<span class="font-label-md text-label-md font-bold text-primary-container">1,980 XP</span>
</div>
</div>
<button class="mt-space-sm text-center font-label-md text-label-md text-primary-container font-semibold py-2 hover:bg-surface-container-low rounded-full transition-colors">
          Lihat Seluruh 127 Peserta →
        </button>
</div>
<div class="bg-gradient-to-br from-primary-container to-secondary rounded-2xl p-space-lg text-on-primary shadow-md relative overflow-hidden">
<div class="absolute right-0 bottom-0 opacity-10 translate-x-4 translate-y-4">
<span class="material-symbols-outlined text-9xl">psychology</span>
</div>
<div class="relative z-10 flex flex-col gap-space-sm">
<div class="flex items-center gap-2">
<span class="p-1 rounded-md bg-white/20 backdrop-blur-sm">
<span class="material-symbols-outlined text-lg text-on-primary">smart_toy</span>
</span>
<span class="font-label-sm text-label-sm font-bold uppercase tracking-wider text-on-primary-container">Eksperimental • Mockup</span>
</div>
<div>
<h4 class="font-title-sm text-title-sm font-bold text-on-primary">AI Challenge Generator</h4>
<p class="font-body-sm text-body-sm text-on-primary-container mt-1">Buat studi kasus coding personal otomatis yang disesuaikan dengan topik kelemahan analisismu.</p>
</div>
<div class="flex flex-col gap-2 pt-1">
<div class="relative">
<input class="w-full bg-white/10 placeholder-white/60 text-on-primary text-xs rounded-xl px-3 py-2.5 pr-8 outline-none focus:bg-white/20 transition-all font-body-sm" readonly="" type="text" value="Buat 1 mini-project algoritma searching dengan TypeScript"/>
<span class="material-symbols-outlined absolute right-2.5 top-1/2 -translate-y-1/2 text-sm text-on-primary/70">auto_fix_high</span>
</div>
<button class="w-full py-2 bg-surface-card text-primary font-label-md text-label-md font-bold rounded-full shadow hover:bg-surface-container-low transition-all flex items-center justify-center gap-1.5">
<span>Generate Tantangan Latihan</span>
<span class="material-symbols-outlined text-base">arrow_forward</span>
</button>
</div>
</div>
</div>
</aside>
</div>
<div class="fixed inset-0 z-50 flex items-center justify-center bg-inverse-surface/40 backdrop-blur-sm p-4 hidden" id="submitModal">
<div class="bg-surface-card w-full max-w-lg rounded-2xl p-space-xl shadow-2xl flex flex-col gap-space-md animate-in fade-in zoom-in-95 duration-200">
<div class="flex items-center justify-between pb-2">
<div class="flex items-center gap-2">
<span class="w-9 h-9 rounded-full bg-primary-fixed flex items-center justify-center text-primary-container">
<span class="material-symbols-outlined text-xl">upload_file</span>
</span>
<div>
<h3 class="font-headline-md text-headline-md font-bold text-on-surface">Submit Solusi Tantangan</h3>
<span class="font-caption text-caption text-text-muted">Challenge #12 - State Management Dashboard</span>
</div>
</div>
<button class="w-8 h-8 rounded-full bg-canvas-bg text-on-surface-variant flex items-center justify-center hover:bg-surface-container transition-colors" onclick="closeSubmitModal()">
<span class="material-symbols-outlined text-lg">close</span>
</button>
</div>
<form class="flex flex-col gap-space-md" onsubmit="handleFormSubmit(event)">
<div class="flex flex-col gap-1.5">
<label class="font-label-md text-label-md font-semibold text-on-surface">URL Repository GitHub / GitLab <span class="text-danger">*</span></label>
<div class="relative">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-muted text-lg">link</span>
<input class="w-full bg-canvas-bg rounded-xl pl-10 pr-3 py-2.5 font-body-sm text-body-sm text-on-surface placeholder:text-text-muted outline-none focus:bg-surface-card focus:ring-2 focus:ring-primary-container" placeholder="https://github.com/username/asalink-challenge-12" required="" type="url"/>
</div>
</div>
<div class="flex flex-col gap-1.5">
<label class="font-label-md text-label-md font-semibold text-on-surface">URL Live Demo (Opsional)</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-muted text-lg">language</span>
<input class="w-full bg-canvas-bg rounded-xl pl-10 pr-3 py-2.5 font-body-sm text-body-sm text-on-surface placeholder:text-text-muted outline-none focus:bg-surface-card focus:ring-2 focus:ring-primary-container" placeholder="https://asalink-demo.vercel.app" type="url"/>
</div>
</div>
<div class="flex flex-col gap-1.5">
<label class="font-label-md text-label-md font-semibold text-on-surface">Catatan Pengerjaan &amp; Kendala</label>
<textarea class="w-full bg-canvas-bg rounded-xl p-3 font-body-sm text-body-sm text-on-surface placeholder:text-text-muted outline-none focus:bg-surface-card focus:ring-2 focus:ring-primary-container resize-none" placeholder="Jelaskan arsitektur folder, teknik penanganan mock, atau trade-off yang Anda ambil..." rows="3"></textarea>
</div>
<div class="bg-surface-container-low rounded-xl p-3 flex items-start gap-2.5 text-on-surface-variant font-caption text-caption">
<span class="material-symbols-outlined text-base text-primary-container mt-0.5">info</span>
<span>Setelah dikirimkan, reviewer memiliki waktu maksimal 2x24 jam untuk melakukan code review dan merilis poin XP ke akun Anda.</span>
</div>
<div class="flex items-center justify-end gap-space-sm pt-2">
<button class="px-space-md py-2 rounded-full text-on-surface-variant font-label-md text-label-md hover:bg-canvas-bg transition-colors" onclick="closeSubmitModal()" type="button">
            Batalkan
          </button>
<button class="px-space-lg py-2.5 rounded-full bg-primary-container text-on-primary font-label-md text-label-md font-semibold hover:bg-primary transition-colors flex items-center gap-2 shadow-sm" type="submit">
<span class="material-symbols-outlined text-base">send</span>
<span>Konfirmasi Pengumpulan</span>
</button>
</div>
</form>
</div>
</div>
<div class="fixed bottom-6 right-6 z-50 bg-inverse-surface text-inverse-on-surface px-space-md py-3 rounded-xl shadow-xl flex items-center gap-3 transform translate-y-20 opacity-0 transition-all duration-300 pointer-events-none" id="toastSuccess">
<span class="material-symbols-outlined text-success text-xl">check_circle</span>
<div class="flex flex-col">
<span class="font-label-md text-label-md font-semibold">Solusi Berhasil Dikirimkan!</span>
<span class="font-caption text-caption text-surface-container-highest">Mentor akan mengevaluasi repositori Anda segera.</span>
</div>
</div>
</div>
<script>
  function switchTab(tabKey) {
    const tabs = ['active', 'history', 'leaderboard'];
    tabs.forEach(key => {
      const btn = document.getElementById('tab-' + key);
      if (!btn) return;
      if (key === tabKey) {
        btn.className = "px-space-md py-2 rounded-full font-label-md text-label-md font-semibold bg-primary-container text-on-primary transition-all shadow-sm flex items-center gap-1.5";
      } else {
        btn.className = "px-space-md py-2 rounded-full font-label-md text-label-md font-medium text-text-muted hover:text-on-surface transition-all flex items-center gap-1.5";
      }
    });
  }

  function openSubmitModal() {
    const modal = document.getElementById('submitModal');
    if (modal) {
      modal.classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    }
  }

  function closeSubmitModal() {
    const modal = document.getElementById('submitModal');
    if (modal) {
      modal.classList.add('hidden');
      document.body.style.overflow = '';
    }
  }

  function handleFormSubmit(e) {
    e.preventDefault();
    closeSubmitModal();
    const toast = document.getElementById('toastSuccess');
    if (toast) {
      toast.classList.remove('translate-y-20', 'opacity-0');
      setTimeout(() => {
        toast.classList.add('translate-y-20', 'opacity-0');
      }, 4000);
    }
  }
</script>
@endsection

