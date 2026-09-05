@extends('layouts.app')

@section('content')
<div class="flex flex-col w-full gap-space-lg pb-space-3xl max-w-4xl mx-auto">

    {{-- Breadcrumb --}}
    <div class="flex flex-wrap items-center gap-space-sm mb-4">
        <a href="{{ route('siswa.materi.index') }}" class="btn-secondary py-1.5 px-3 text-sm flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali
        </a>
        <span class="material-symbols-outlined text-sm text-text-muted">chevron_right</span>
        <span class="text-sm font-bold text-on-surface truncate">{{ $material->title }}</span>
    </div>

    {{-- Material Content Card --}}
    <div class="bg-surface-card border border-border-subtle rounded-2xl shadow-sm overflow-hidden">
        {{-- Header --}}
        <div class="p-space-lg border-b border-border-subtle bg-surface-container-low">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <span class="px-3 py-1 bg-primary/10 text-primary rounded-md text-xs font-bold uppercase tracking-wider">{{ $material->subject->name ?? 'Umum' }}</span>
                <span class="text-sm text-text-muted flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-sm">calendar_today</span>
                    {{ $material->published_at ? $material->published_at->format('d M Y') : '-' }}
                </span>
            </div>
            <h1 class="font-headline-lg text-headline-lg font-bold text-on-surface mt-4">{{ $material->title }}</h1>
            <div class="flex items-center gap-2 mt-4 text-sm text-text-muted">
                <div class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center">
                    <span class="material-symbols-outlined text-sm">person</span>
                </div>
                <span>Oleh: <span class="font-bold text-on-surface">{{ $material->teacher->name ?? 'Guru' }}</span></span>
            </div>
        </div>

        {{-- Body --}}
        <div class="p-space-lg">
            <div class="prose prose-sm md:prose-base max-w-none text-on-surface">
                @if($material->description)
                    {!! nl2br(e($material->description)) !!}
                @else
                    <p class="text-text-muted italic">Tidak ada deskripsi teks untuk materi ini.</p>
                @endif
            </div>
        </div>

        {{-- Attachment (if any) --}}
        @if($material->file_path)
        <div class="p-space-lg border-t border-border-subtle bg-surface-container-lowest">
            <h3 class="text-sm font-bold text-on-surface mb-3">Lampiran Materi</h3>
            <a href="#" class="inline-flex items-center gap-3 p-3 rounded-xl border border-border-subtle hover:bg-surface-container transition-colors max-w-sm">
                <div class="w-10 h-10 rounded-lg bg-danger/10 flex items-center justify-center text-danger flex-shrink-0">
                    <span class="material-symbols-outlined">description</span>
                </div>
                <div class="flex-1 overflow-hidden">
                    <p class="text-sm font-bold text-on-surface truncate">Lampiran_Materi.pdf</p>
                    <p class="text-xs text-text-muted">Klik untuk mengunduh</p>
                </div>
                <span class="material-symbols-outlined text-text-muted">download</span>
            </a>
        </div>
        @endif
    </div>

</div>
@endsection
