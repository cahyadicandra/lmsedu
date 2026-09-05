@extends('layouts.app')

@section('content')
<div class="flex flex-col w-full gap-space-lg pb-space-3xl max-w-6xl mx-auto">

    {{-- Header Dashboard --}}
    <div class="relative overflow-hidden rounded-[20px] bg-gradient-to-r from-primary-container via-secondary to-primary-container p-space-xl text-on-primary shadow-md flex flex-col md:flex-row md:items-end justify-between gap-space-md mb-8">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="absolute -right-16 -top-20 w-80 h-80 rounded-full bg-secondary-container/20 blur-3xl pointer-events-none"></div>
        <div class="absolute -left-12 -bottom-16 w-60 h-60 rounded-full bg-tertiary-container/30 blur-2xl pointer-events-none"></div>
        
        <div class="relative z-10 flex-1 space-y-space-sm">
            <div class="inline-flex items-center gap-2 px-space-sm py-0.5 bg-white/15 backdrop-blur-md rounded-full text-on-primary font-label-sm text-label-sm tracking-wide uppercase font-semibold mb-2">
                <span class="material-symbols-outlined text-[18px]">family_home</span>
                Panel Wali Murid
            </div>
            
            <h1 class="font-headline-lg text-headline-lg text-white font-bold tracking-tight mb-2">Selamat datang, {{ explode(' ', auth()->user()->name)[0] }}!</h1>
            
            @if($student)
                <p class="font-body-md text-body-md text-on-primary-container max-w-lg leading-relaxed flex flex-wrap items-center gap-2">
                    Anak yang dipantau: 
                    <span class="font-bold text-white bg-white/10 backdrop-blur-md px-3 py-1 rounded-lg shadow-inner">
                        {{ $student->name }} — {{ $student->schoolClass->name ?? 'Belum ada kelas' }}
                    </span>
                </p>
            @else
                <p class="text-warning-container bg-warning/20 px-4 py-2 rounded-lg inline-flex items-center gap-2 mt-2 font-medium">
                    <span class="material-symbols-outlined">warning</span> Belum ada data anak yang dipantau
                </p>
            @endif
        </div>
        
        <div class="relative z-10 flex gap-3">
            <a href="{{ route('walimurid.profil.index') }}" class="btn bg-white text-primary hover:bg-gray-50 shadow-md px-5 py-2.5 rounded-xl font-bold transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">face</span> Profil Anak
            </a>
        </div>
    </div>

    @if($student)
    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-space-md">
        
        {{-- Card 1: Persentase Kehadiran --}}
        <div class="bg-surface-card p-6 rounded-2xl border border-border-subtle shadow-sm flex flex-col hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-16 h-16 bg-success/5 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex items-start justify-between mb-2">
                <div class="text-text-muted font-semibold text-sm">Kehadiran</div>
                <div class="w-10 h-10 bg-success/10 text-success rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined">fact_check</span>
                </div>
            </div>
            <div class="text-3xl font-black text-on-surface mb-1">
                {{ $attendancePercentage }}<span class="text-xl text-text-muted font-bold">%</span>
            </div>
            <div class="text-xs font-medium text-success flex items-center gap-1 mt-auto">
                <span class="material-symbols-outlined text-[14px]">trending_up</span> Dari {{ $hadir + $izin + $alpa }} Pertemuan
            </div>
        </div>

        {{-- Card 2: Jumlah Hadir --}}
        <div class="bg-surface-card p-6 rounded-2xl border border-border-subtle shadow-sm flex flex-col hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-16 h-16 bg-blue-500/5 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex items-start justify-between mb-2">
                <div class="text-text-muted font-semibold text-sm">Hadir</div>
                <div class="w-10 h-10 bg-blue-500/10 text-blue-600 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined">how_to_reg</span>
                </div>
            </div>
            <div class="text-3xl font-black text-on-surface mb-1">{{ $hadir }}</div>
            <div class="text-xs font-medium text-text-muted mt-auto">Total Pertemuan Hadir</div>
        </div>

        {{-- Card 3: Izin / Sakit --}}
        <div class="bg-surface-card p-6 rounded-2xl border border-border-subtle shadow-sm flex flex-col hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-16 h-16 bg-warning/5 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex items-start justify-between mb-2">
                <div class="text-text-muted font-semibold text-sm">Izin / Sakit</div>
                <div class="w-10 h-10 bg-warning/10 text-warning rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined">sick</span>
                </div>
            </div>
            <div class="text-3xl font-black text-on-surface mb-1">{{ $izin }}</div>
            <div class="text-xs font-medium text-text-muted mt-auto">Pertemuan Izin/Sakit</div>
        </div>

        {{-- Card 4: Rata-rata Nilai --}}
        <div class="bg-surface-card p-6 rounded-2xl border border-border-subtle shadow-sm flex flex-col hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-16 h-16 bg-primary/5 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex items-start justify-between mb-2">
                <div class="text-text-muted font-semibold text-sm">Rata-rata Nilai</div>
                <div class="w-10 h-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined">military_tech</span>
                </div>
            </div>
            <div class="text-3xl font-black text-on-surface mb-1">{{ $averageGrade }}</div>
            <div class="text-xs font-medium text-primary flex items-center gap-1 mt-auto">
                <a href="{{ route('walimurid.nilai.index') }}" class="hover:underline font-bold flex items-center gap-1">Lihat Detail <span class="material-symbols-outlined text-[14px]">arrow_forward</span></a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-space-lg">
        
        {{-- Section: Nilai Terbaru --}}
        <div class="bg-surface-card rounded-2xl border border-border-subtle shadow-sm flex flex-col">
            <div class="px-6 py-5 border-b border-border-subtle flex justify-between items-center bg-surface-container-low rounded-t-2xl">
                <h3 class="font-bold text-lg text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[22px]">grade</span> Nilai Terbaru
                </h3>
                <a href="{{ route('walimurid.nilai.index') }}" class="text-sm font-semibold text-primary hover:underline">Lihat Semua</a>
            </div>
            <div class="p-6 flex-1">
                @if($recentGrades->count() > 0)
                <div class="flex flex-col gap-4">
                    @foreach($recentGrades as $grade)
                    <div class="flex items-center justify-between p-4 bg-canvas-bg rounded-xl border border-border-subtle hover:border-primary/30 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-lg flex items-center justify-center font-bold text-lg text-white shadow-sm
                                {{ $grade->score >= 85 ? 'bg-success' : ($grade->score >= 70 ? 'bg-primary' : 'bg-danger') }}">
                                {{ $grade->score }}
                            </div>
                            <div>
                                <h4 class="font-bold text-on-surface">{{ $grade->type }} - {{ $grade->subject->name ?? 'Pelajaran' }}</h4>
                                <p class="text-xs text-text-muted mt-0.5"><span class="font-medium text-on-surface">{{ $grade->teacher->name ?? 'Guru' }}</span> • {{ $grade->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="flex flex-col items-center justify-center h-full text-center text-text-muted py-8">
                    <span class="material-symbols-outlined text-5xl mb-3 opacity-20">history_edu</span>
                    <p class="font-medium">Belum ada nilai yang dimasukkan.</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Section: Pesan Terakhir (Sticky Notes) --}}
        <div class="bg-surface-card rounded-2xl border border-border-subtle shadow-sm flex flex-col">
            <div class="px-6 py-5 border-b border-border-subtle flex justify-between items-center bg-surface-container-low rounded-t-2xl">
                <h3 class="font-bold text-lg text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-warning text-[22px]">sticky_note_2</span> Pesan ke Guru
                </h3>
                <a href="{{ route('walimurid.pesan.index') }}" class="text-sm font-semibold text-primary hover:underline">Papan Pesan</a>
            </div>
            <div class="p-6 flex-1 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] bg-repeat" style="background-color: #fafbfc;">
                @if($recentMessages->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($recentMessages as $msg)
                    @php
                        $colors = ['bg-yellow-100', 'bg-blue-100', 'bg-pink-100', 'bg-green-100'];
                        $color = $colors[$loop->index % count($colors)];
                        $rotations = ['rotate-1', '-rotate-1', 'rotate-2', '-rotate-2'];
                        $rotation = $rotations[$loop->index % count($rotations)];
                    @endphp
                    <div class="{{ $color }} p-4 rounded-bl-3xl rounded-tr-md rounded-tl-md rounded-br-md shadow-sm relative transform transition-transform {{ $rotation }} hover:rotate-0 hover:z-10 hover:scale-[1.03] duration-300 border border-black/5 flex flex-col h-full" style="min-height: 140px;">
                        <div class="absolute -top-2 left-1/2 -translate-x-1/2 w-8 h-4 bg-red-400/80 rounded-sm shadow-sm z-10" style="clip-path: polygon(0 0, 100% 0, 95% 100%, 5% 100%);"></div>
                        
                        <div class="flex items-center justify-between mb-2 border-b border-black/10 pb-1.5">
                            <span class="font-bold text-xs text-black/80 truncate pr-2">Ke: {{ $msg->teacher->name ?? 'Guru' }}</span>
                            @if($msg->reply)
                                <span class="material-symbols-outlined text-[14px] text-blue-600" title="Dibalas">mark_email_read</span>
                            @elseif($msg->is_read)
                                <span class="material-symbols-outlined text-[14px] text-success" title="Sudah dibaca">done_all</span>
                            @else
                                <span class="material-symbols-outlined text-[14px] text-text-muted" title="Terkirim">check</span>
                            @endif
                        </div>
                        
                        <p class="text-black/90 font-medium text-xs leading-relaxed flex-1 line-clamp-3" style="font-family: 'Kalam', 'Comic Sans MS', cursive;">
                            {{ $msg->content }}
                        </p>
                        
                        <div class="mt-2 pt-2 border-t border-black/10 text-[10px] text-black/60 font-semibold text-right">
                            {{ $msg->created_at->diffForHumans() }}
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="flex flex-col items-center justify-center h-full text-center text-text-muted bg-white/50 rounded-xl p-8 backdrop-blur-sm border border-black/5">
                    <span class="material-symbols-outlined text-5xl mb-3 opacity-20">drafts</span>
                    <p class="font-medium text-sm">Belum ada pesan terkirim.</p>
                    <a href="{{ route('walimurid.pesan.index') }}" class="btn-secondary py-1.5 px-4 rounded-lg mt-3 text-sm">Tulis Pesan Pertama</a>
                </div>
                @endif
            </div>
        </div>

    </div>
    
    @endif
</div>
@endsection
