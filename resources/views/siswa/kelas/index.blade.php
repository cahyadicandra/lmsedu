@extends('layouts.app')

@section('content')
<div class="flex flex-col w-full gap-space-lg pb-space-3xl">

    {{-- Breadcrumb --}}
    <div class="flex flex-wrap items-center justify-between gap-space-sm">
        <span class="font-label-md text-label-md font-semibold text-primary">Kelas Saya</span>
        <div class="flex items-center gap-space-sm">
            <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-text-muted hover:text-primary transition-colors">Dashboard</a>
            <span class="material-symbols-outlined text-sm text-text-muted">chevron_right</span>
            <span class="text-sm font-bold text-on-surface">Kelas Saya</span>
        </div>
    </div>

    {{-- Header Section --}}
    <div class="flex flex-col gap-2">
        <h1 class="font-headline-lg text-headline-lg font-bold text-on-surface">Mata Pelajaran di {{ $myClass->name ?? 'Kelas Anda' }}</h1>
        <p class="text-text-muted text-sm max-w-2xl">Lihat kelas dan materi pembelajaran yang kamu ikuti pada tahun akademik ini.</p>
    </div>

    {{-- Class List --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-space-md">
        @forelse($subjects as $subject)
        <div class="bg-surface-card border border-border-subtle rounded-2xl p-space-md shadow-sm flex flex-col gap-4">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary flex-shrink-0">
                    <span class="material-symbols-outlined text-2xl">meeting_room</span>
                </div>
                <span class="px-2 py-1 bg-success/10 text-success rounded-md text-xs font-bold uppercase tracking-wider">Aktif</span>
            </div>
            
            <div>
                <h3 class="font-headline-sm font-bold text-on-surface">{{ $subject->name }}</h3>
                <p class="text-sm text-text-muted mt-1">{{ $subject->teacher->name ?? 'Guru Belum Ditentukan' }}</p>
            </div>
            
            <div class="pt-4 border-t border-border-subtle mt-auto">
                <a href="{{ route('siswa.kelas.show', $subject->id) }}" class="btn-primary w-full py-2.5">
                    Lihat Kelas
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 flex flex-col items-center justify-center text-center">
            <span class="material-symbols-outlined text-6xl text-border-subtle mb-4">meeting_room</span>
            <p class="text-lg font-bold text-on-surface">Belum ada mata pelajaran</p>
            <p class="text-text-muted text-sm mt-1">Belum ada mata pelajaran yang ditugaskan ke kelasmu.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
