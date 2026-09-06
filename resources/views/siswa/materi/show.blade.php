@extends('layouts.app')

@section('content')
<div class="flex flex-col w-full gap-space-lg pb-space-3xl">

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

        {{-- Attachment & Video --}}
        @if($material->file_path || $material->youtube_link)
        <div class="p-space-lg border-t border-border-subtle bg-surface-container-lowest flex flex-col gap-6">
            
            @if($material->file_path)
            @php
                $displayName = preg_replace('/^\d+_/', '', basename($material->file_path));
            @endphp
            <div>
                <h3 class="text-sm font-bold text-on-surface mb-3">Lampiran Materi</h3>
                <a href="{{ Storage::url($material->file_path) }}" target="_blank" class="inline-flex items-center gap-3 p-3 rounded-xl border border-border-subtle bg-surface-card hover:border-primary hover:shadow-sm transition-all max-w-sm w-full group">
                    <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary flex-shrink-0 group-hover:bg-primary group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined">description</span>
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <p class="text-sm font-bold text-on-surface truncate" title="{{ $displayName }}">{{ $displayName }}</p>
                        <p class="text-xs text-text-muted">Klik untuk melihat/mengunduh</p>
                    </div>
                    <span class="material-symbols-outlined text-text-muted group-hover:text-primary transition-colors">download</span>
                </a>
            </div>
            @endif

            @if($material->youtube_link)
            @php
                $youtubeId = '';
                if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/|youtube\.com/shorts/)([^"&?/ ]{11})%i', $material->youtube_link, $match)) {
                    $youtubeId = $match[1];
                }
            @endphp
            <div>
                <h3 class="text-sm font-bold text-on-surface mb-3">Video Pembelajaran</h3>
                @if($youtubeId)
                <div class="max-w-3xl w-full">
                    <div class="relative w-full rounded-xl overflow-hidden border border-border-subtle shadow-sm bg-black" style="padding-top: 56.25%;">
                        <iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/{{ $youtubeId }}?rel=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
                @else
                <a href="{{ $material->youtube_link }}" target="_blank" class="inline-flex items-center gap-3 p-3 rounded-xl border border-border-subtle bg-surface-card hover:border-danger hover:shadow-sm transition-all max-w-sm w-full group">
                    <div class="w-10 h-10 rounded-lg bg-danger/10 flex items-center justify-center text-danger flex-shrink-0 group-hover:bg-danger group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined">play_circle</span>
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <p class="text-sm font-bold text-on-surface truncate">Tonton Video di YouTube</p>
                        <p class="text-xs text-text-muted truncate">{{ $material->youtube_link }}</p>
                    </div>
                    <span class="material-symbols-outlined text-text-muted group-hover:text-danger transition-colors">open_in_new</span>
                </a>
                @endif
            </div>
            @endif

        </div>
        @endif
    </div>

</div>
@endsection
