@extends('layouts.app')

@section('content')
<div class="flex flex-col w-full gap-space-lg pb-space-3xl">

    {{-- Breadcrumb --}}
    <div class="flex flex-wrap items-center justify-between gap-space-sm">
        <span class="font-label-md text-label-md font-semibold text-primary">Dashboard</span>
        <div class="flex items-center gap-space-sm"
             x-data="{ time: new Date().toLocaleTimeString('id-ID', {hour:'2-digit',minute:'2-digit',second:'2-digit'}), date: new Date().toLocaleDateString('id-ID', {weekday:'long',year:'numeric',month:'long',day:'numeric'}) }"
             x-init="setInterval(() => { let d = new Date(); time = d.toLocaleTimeString('id-ID', {hour:'2-digit',minute:'2-digit',second:'2-digit'}); date = d.toLocaleDateString('id-ID', {weekday:'long',year:'numeric',month:'long',day:'numeric'}) }, 1000)">
            <span class="inline-flex items-center gap-1.5 px-space-sm py-1 rounded-full bg-surface-container-high text-primary font-label-sm text-label-sm font-semibold">
                <span class="material-symbols-outlined text-sm">calendar_month</span>
                <span x-text="date"></span>
            </span>
            <div class="flex items-center gap-1.5 bg-surface-card px-space-sm py-1 rounded-full shadow-sm text-primary">
                <span class="material-symbols-outlined text-sm">schedule</span>
                <span class="font-label-sm text-label-sm font-bold text-on-surface" x-text="time"></span>
            </div>
        </div>
    </div>

    {{-- Welcome Banner --}}
    <div class="bg-primary rounded-2xl p-space-lg flex items-center justify-between overflow-hidden relative">
        <div class="relative z-10">
            <span class="text-xs font-semibold text-white uppercase tracking-widest">ADMIN SEKOLAH</span>
            <h2 class="font-headline-lg text-headline-lg font-bold text-white mt-1">Halo, {{ auth()->user()->name }}! 👋</h2>
            <p class="text-white text-sm mt-1 max-w-md">Kelola data akademik, pengguna, dan kelas sekolah Anda dari satu dasbor terpadu.</p>
        </div>
        <div class="hidden lg:flex flex-col items-end gap-3 relative z-10">
            <div class="bg-white/15 rounded-xl px-4 py-3 flex items-center gap-3 backdrop-blur-sm border border-white/10">
                <span class="material-symbols-outlined text-white/90 text-2xl">school</span>
                <div>
                    <p class="text-xs text-white font-medium">Tahun Akademik Aktif</p>
                    @php $activeYear = \App\Models\AcademicYear::where('status','Aktif')->first(); @endphp
                    @if($activeYear)
                        <p class="text-sm font-bold text-white">{{ $activeYear->name }} – {{ $activeYear->semester }}</p>
                    @else
                        <p class="text-sm font-medium text-white/70 italic">Belum ada tahun aktif</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-space-md">
        @php
            $stats = [
                ['label'=>'Total Siswa',  'value'=>$totalSiswa,  'icon'=>'face',         'color'=>'text-success',  'bg'=>'bg-success/10'],
                ['label'=>'Total Guru',   'value'=>$totalGuru,   'icon'=>'support_agent','color'=>'text-primary',  'bg'=>'bg-primary/10'],
                ['label'=>'Total Kelas',  'value'=>$totalKelas,  'icon'=>'meeting_room', 'color'=>'text-warning',  'bg'=>'bg-warning/10'],
                ['label'=>'Mata Pelajaran','value'=>$totalMatpel,'icon'=>'menu_book',    'color'=>'text-danger',   'bg'=>'bg-danger/10'],
            ];
        @endphp
        @foreach($stats as $s)
        <div class="bg-surface-card rounded-2xl p-space-md border border-border-subtle shadow-sm flex items-center gap-space-md">
            <div class="w-12 h-12 rounded-xl {{ $s['bg'] }} flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-2xl {{ $s['color'] }}">{{ $s['icon'] }}</span>
            </div>
            <div>
                <p class="font-display-metric text-3xl font-bold text-on-surface">{{ $s['value'] }}</p>
                <p class="text-xs text-text-muted font-semibold mt-0.5">{{ $s['label'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Quick Actions + Ringkasan Kelas --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-space-md">

        {{-- Quick Actions --}}
        <div class="bg-surface-card rounded-2xl border border-border-subtle shadow-sm p-space-md flex flex-col gap-3">
            <h3 class="font-headline-md font-bold text-on-surface">Quick Actions</h3>
            @php
                $actions = [
                    ['label'=>'Tambah Kelas',         'icon'=>'meeting_room', 'href'=>url('/kelas'),         'color'=>'bg-primary/10 text-primary'],
                    ['label'=>'Tambah Mata Pelajaran', 'icon'=>'menu_book',   'href'=>url('/mata-pelajaran'),'color'=>'bg-danger/10 text-danger'],
                    ['label'=>'Tambah Guru',           'icon'=>'support_agent','href'=>url('/data-guru'),     'color'=>'bg-warning/10 text-warning'],
                    ['label'=>'Tambah Siswa',          'icon'=>'face',        'href'=>url('/data-siswa'),     'color'=>'bg-success/10 text-success'],
                ];
            @endphp
            @foreach($actions as $a)
            <a href="{{ $a['href'] }}" class="flex items-center gap-3 p-3 rounded-xl {{ $a['color'] }} hover:opacity-80 transition-opacity font-semibold text-sm">
                <span class="material-symbols-outlined text-xl">{{ $a['icon'] }}</span>
                {{ $a['label'] }}
            </a>
            @endforeach
        </div>

        {{-- Ringkasan Kelas --}}
        <div class="lg:col-span-2 bg-surface-card rounded-2xl border border-border-subtle shadow-sm p-space-md">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-headline-md font-bold text-on-surface">Ringkasan Kelas</h3>
                <a href="{{ url('/kelas') }}" class="text-sm font-semibold text-primary hover:underline">Lihat Semua →</a>
            </div>
            @if($totalKelas === 0)
            <div class="flex flex-col items-center justify-center py-8 text-text-muted gap-2">
                <span class="material-symbols-outlined text-4xl text-border-subtle">meeting_room</span>
                <p class="text-sm">Belum ada kelas. <a href="{{ url('/kelas') }}" class="text-primary font-semibold">Tambah Kelas →</a></p>
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="border-b border-border-subtle">
                            <th class="py-2 text-xs uppercase text-text-muted font-semibold">Kelas</th>
                            <th class="py-2 text-xs uppercase text-text-muted font-semibold">Wali Kelas</th>
                            <th class="py-2 text-xs uppercase text-text-muted font-semibold text-right">Siswa</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-subtle">
                        @foreach(\App\Models\SchoolClass::with('teacher','students')->take(5)->get() as $kelas)
                        <tr class="hover:bg-canvas-bg/30">
                            <td class="py-2.5 font-semibold text-on-surface">{{ $kelas->name }}</td>
                            <td class="py-2.5 text-text-muted">{{ $kelas->teacher->name ?? '-' }}</td>
                            <td class="py-2.5 text-right font-semibold text-on-surface">{{ $kelas->students->count() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

    {{-- Aktivitas Terbaru --}}
    <div class="bg-surface-card rounded-2xl border border-border-subtle shadow-sm p-space-md">
        <h3 class="font-headline-md font-bold text-on-surface mb-4">Aktivitas Terbaru</h3>
        @php
            $recentUsers = \App\Models\User::whereIn('role', ['Guru','Siswa'])->orderBy('created_at','desc')->take(5)->get();
        @endphp
        @forelse($recentUsers as $u)
        <div class="flex items-center gap-3 py-2.5 border-b border-border-subtle last:border-0">
            <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-xs uppercase flex-shrink-0">
                {{ substr($u->name, 0, 2) }}
            </div>
            <div class="flex-1">
                <p class="text-sm font-semibold text-on-surface">{{ $u->name }}</p>
                <p class="text-xs text-text-muted">Akun {{ $u->role }} baru ditambahkan</p>
            </div>
            <p class="text-xs text-text-muted">{{ $u->created_at->diffForHumans() }}</p>
        </div>
        @empty
        <p class="text-sm text-text-muted text-center py-6">Belum ada aktivitas terbaru.</p>
        @endforelse
    </div>

</div>
@endsection
