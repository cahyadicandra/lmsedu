@extends('layouts.app')

@section('content')
<div class="flex flex-col w-full gap-space-lg pb-space-3xl">

    {{-- Breadcrumb --}}
    <div class="flex flex-wrap items-center justify-between gap-space-sm">
        <span class="font-label-md text-label-md font-semibold text-primary">Materi Pembelajaran</span>
        <div class="flex items-center gap-space-sm">
            <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-text-muted hover:text-primary transition-colors">Dashboard</a>
            <span class="material-symbols-outlined text-sm text-text-muted">chevron_right</span>
            <span class="text-sm font-bold text-on-surface">Materi</span>
        </div>
    </div>

    {{-- Filter Form --}}
    <form method="GET" action="{{ route('siswa.materi.index') }}" class="flex items-center gap-3 bg-surface-card p-4 rounded-2xl border border-border-subtle shadow-sm">
        <div class="flex-1 max-w-sm">
            <select name="subject_id" class="input-standard w-full" onchange="this.form.submit()">
                <option value="">Semua Mata Pelajaran</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    {{-- Material List --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-space-md">
        @forelse($materials as $material)
        <div class="bg-surface-card border border-border-subtle rounded-2xl p-space-md shadow-sm flex flex-col gap-3 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary flex-shrink-0">
                    <span class="material-symbols-outlined text-2xl">menu_book</span>
                </div>
                <span class="text-xs font-bold text-text-muted">{{ $material->published_at ? $material->published_at->format('d M Y') : '-' }}</span>
            </div>
            
            <div class="mt-2">
                <p class="text-xs font-semibold text-primary uppercase tracking-wider mb-1">{{ $material->subject->name ?? 'Umum' }}</p>
                <h3 class="font-headline-sm font-bold text-on-surface line-clamp-2">{{ $material->title }}</h3>
                <p class="text-sm text-text-muted mt-2 line-clamp-2">{{ Str::limit(strip_tags($material->description), 100) }}</p>
            </div>
            
            <div class="pt-4 mt-auto">
                <a href="{{ route('siswa.materi.show', $material->id) }}" class="btn-primary w-full py-2 bg-primary/10 text-primary border-none hover:bg-primary/20">
                    Baca Materi
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 flex flex-col items-center justify-center text-center">
            <span class="material-symbols-outlined text-6xl text-border-subtle mb-4">menu_book</span>
            <p class="text-lg font-bold text-on-surface">Belum ada materi</p>
            <p class="text-text-muted text-sm mt-1">Materi yang dipublikasikan oleh guru akan tampil di sini.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
