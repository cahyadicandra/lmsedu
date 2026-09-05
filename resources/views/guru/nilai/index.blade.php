@extends('layouts.app')

@section('content')
<div>
    <div class="flex items-center justify-between mb-space-lg">
        <div>
            <h1 class="font-headline-lg text-headline-lg font-bold text-on-surface">Manajemen Nilai</h1>
            <p class="font-body-md text-text-muted mt-1">Pilih mata pelajaran dan kelas untuk mengelola nilai siswa.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-success/10 text-success border border-success/20 px-4 py-3 rounded-xl mb-space-md flex items-center gap-2">
        <span class="material-symbols-outlined">check_circle</span>{{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-space-md">
        @forelse($subjects as $s)
        <div class="bg-surface-card rounded-2xl shadow-sm border border-border-subtle p-space-md flex flex-col hover:border-primary/50 transition-colors">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl">menu_book</span>
                </div>
                <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold bg-primary-fixed text-on-primary-fixed">{{ $s->code }}</span>
            </div>
            <h3 class="font-headline-sm font-bold text-on-surface mb-1">{{ $s->name }}</h3>
            <p class="text-sm text-text-muted mb-6">Kelas: {{ $s->schoolClass->name ?? '-' }}</p>
            
            <div class="mt-auto pt-4 border-t border-border-subtle flex justify-end">
                <a href="{{ route('nilai.index', ['subject_id' => $s->id, 'school_class_id' => $s->school_class_id]) }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold bg-primary text-white hover:bg-primary/90 rounded-lg transition-colors">
                    Kelola Nilai <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 text-center text-text-muted bg-surface-card rounded-2xl border border-border-subtle">
            <div class="flex flex-col items-center gap-2">
                <span class="material-symbols-outlined text-4xl text-border-subtle">assignment</span>
                <p>Belum ada mata pelajaran yang Anda ampu.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
