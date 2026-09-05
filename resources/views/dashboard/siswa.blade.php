@extends('layouts.app')

@section('content')
<div class="flex flex-col w-full gap-space-lg pb-space-3xl">

    {{-- Breadcrumb --}}
    <div class="flex flex-wrap items-center justify-between gap-space-sm">
        <span class="font-label-md text-label-md font-semibold text-primary">Dashboard Siswa</span>
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
            <span class="text-xs font-semibold text-white uppercase tracking-widest">SISWA</span>
            <h2 class="font-headline-lg text-headline-lg font-bold text-white mt-1">Selamat datang, {{ auth()->user()->name }}! 👋</h2>
            <p class="text-white text-sm mt-1 max-w-md">Pantau jadwal kelas, kerjakan tugas, dan cek nilai terbarumu di sini.</p>
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
                ['label'=>'Mata Pelajaran', 'value'=>$totalMatpel, 'icon'=>'menu_book',   'color'=>'text-primary',  'bg'=>'bg-primary/10'],
                ['label'=>'Kelas Diikuti',  'value'=>$totalKelas,  'icon'=>'meeting_room','color'=>'text-success',  'bg'=>'bg-success/10'],
                ['label'=>'Tugas Belum',    'value'=>$tugasBelum,  'icon'=>'assignment',  'color'=>'text-warning',  'bg'=>'bg-warning/10'],
                ['label'=>'Nilai Terbaru',  'value'=>$nilaiTerbaru ? $nilaiTerbaru->grade : '-', 'icon'=>'military_tech', 'color'=>'text-danger',   'bg'=>'bg-danger/10'],
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

    {{-- Quick Actions + Tugas Mendatang --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-space-md">

        {{-- Quick Actions --}}
        <div class="bg-surface-card rounded-2xl border border-border-subtle shadow-sm p-space-md flex flex-col gap-3">
            <h3 class="font-headline-md font-bold text-on-surface">Quick Actions</h3>
            @php
                $actions = [
                    ['label'=>'Lihat Kelas',         'icon'=>'meeting_room', 'href'=>route('siswa.kelas.index'), 'color'=>'bg-primary/10 text-primary'],
                    ['label'=>'Kerjakan Tugas',      'icon'=>'assignment',   'href'=>route('siswa.tugas.index'), 'color'=>'bg-warning/10 text-warning'],
                    ['label'=>'Lihat Nilai',         'icon'=>'military_tech','href'=>route('siswa.nilai.index'), 'color'=>'bg-success/10 text-success'],
                    ['label'=>'Kirim Pesan ke Guru', 'icon'=>'sticky_note_2','href'=>route('siswa.pesan.index'), 'color'=>'bg-danger/10 text-danger'],
                ];
            @endphp
            @foreach($actions as $a)
            <a href="{{ $a['href'] }}" class="flex items-center gap-3 p-3 rounded-xl {{ $a['color'] }} hover:opacity-80 transition-opacity font-semibold text-sm">
                <span class="material-symbols-outlined text-xl">{{ $a['icon'] }}</span>
                {{ $a['label'] }}
            </a>
            @endforeach
        </div>

        {{-- Tugas Mendatang --}}
        <div class="lg:col-span-2 bg-surface-card rounded-2xl border border-border-subtle shadow-sm p-space-md">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-headline-md font-bold text-on-surface">Tugas Mendatang</h3>
                <a href="{{ route('siswa.tugas.index') }}" class="text-sm font-semibold text-primary hover:underline">Lihat Semua →</a>
            </div>
            
            @php
                $upcomingTasks = \App\Models\Assignment::where('school_class_id', auth()->user()->school_class_id)
                    ->where('due_date', '>=', now())
                    ->orderBy('due_date', 'asc')
                    ->take(3)
                    ->get();
            @endphp

            @if($upcomingTasks->isEmpty())
            <div class="flex flex-col items-center justify-center py-8 text-text-muted gap-2">
                <span class="material-symbols-outlined text-4xl text-border-subtle">assignment_turned_in</span>
                <p class="text-sm">Tidak ada tugas mendesak.</p>
            </div>
            @else
            <div class="flex flex-col gap-3">
                @foreach($upcomingTasks as $task)
                <div class="p-3 border border-border-subtle rounded-xl flex items-center justify-between hover:bg-surface-container transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-warning/10 flex items-center justify-center flex-shrink-0 text-warning">
                            <span class="material-symbols-outlined text-xl">assignment</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-on-surface">{{ $task->title }}</p>
                            <p class="text-xs text-text-muted font-medium mt-0.5">{{ $task->subject->name ?? 'Mata Pelajaran' }} &bull; Tenggat: {{ $task->due_date ? $task->due_date->format('d M Y') : '-' }}</p>
                        </div>
                    </div>
                    <a href="{{ route('siswa.tugas.show', $task->id) }}" class="btn-primary text-xs py-1.5 px-3">Kerjakan</a>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
