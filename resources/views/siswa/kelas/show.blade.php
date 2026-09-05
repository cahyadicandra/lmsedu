@extends('layouts.app')

@section('content')
<div class="flex flex-col w-full gap-space-lg pb-space-3xl">

    {{-- Breadcrumb --}}
    <div class="flex flex-wrap items-center justify-between gap-space-sm">
        <span class="font-label-md text-label-md font-semibold text-primary">Detail Kelas</span>
        <div class="flex items-center gap-space-sm">
            <a href="{{ route('siswa.kelas.index') }}" class="text-sm font-semibold text-text-muted hover:text-primary transition-colors">Kelas Saya</a>
            <span class="material-symbols-outlined text-sm text-text-muted">chevron_right</span>
            <span class="text-sm font-bold text-on-surface">{{ $subject->name }}</span>
        </div>
    </div>

    {{-- Header Info --}}
    <div class="bg-surface-card border border-border-subtle rounded-2xl p-space-lg shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <h1 class="font-headline-lg text-headline-lg font-bold text-on-surface">{{ $subject->name }}</h1>
            <p class="text-text-muted text-sm mt-1">Guru: {{ $subject->teacher->name ?? 'Belum Ditentukan' }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('siswa.materi.index', ['subject_id' => $subject->id]) }}" class="btn-primary py-2 px-4 text-sm bg-primary/10 text-primary border-none hover:bg-primary/20">Lihat Semua Materi</a>
            <a href="{{ route('siswa.tugas.index', ['subject_id' => $subject->id]) }}" class="btn-primary py-2 px-4 text-sm bg-warning/10 text-warning border-none hover:bg-warning/20">Lihat Semua Tugas</a>
        </div>
    </div>

    {{-- Layout Grid for Sections --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-space-md">

        {{-- Materi Terbaru --}}
        <div class="bg-surface-card border border-border-subtle rounded-2xl p-space-md shadow-sm">
            <h3 class="font-headline-md font-bold text-on-surface mb-4">Materi Terbaru</h3>
            @if($materials->isEmpty())
                <p class="text-sm text-text-muted">Belum ada materi untuk mata pelajaran ini.</p>
            @else
                <div class="flex flex-col gap-3">
                    @foreach($materials->take(5) as $material)
                    <a href="{{ route('siswa.materi.show', $material->id) }}" class="flex items-start gap-3 p-3 rounded-xl hover:bg-surface-container transition-colors border border-transparent hover:border-border-subtle">
                        <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary flex-shrink-0">
                            <span class="material-symbols-outlined">menu_book</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-on-surface">{{ $material->title }}</h4>
                            <p class="text-xs text-text-muted mt-0.5">Dipublikasikan: {{ $material->published_at ? $material->published_at->format('d M Y') : '-' }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Tugas Aktif --}}
        <div class="bg-surface-card border border-border-subtle rounded-2xl p-space-md shadow-sm">
            <h3 class="font-headline-md font-bold text-on-surface mb-4">Tugas Aktif</h3>
            @if($assignments->isEmpty())
                <p class="text-sm text-text-muted">Belum ada tugas untuk mata pelajaran ini.</p>
            @else
                <div class="flex flex-col gap-3">
                    @foreach($assignments->take(5) as $assignment)
                    <a href="{{ route('siswa.tugas.show', $assignment->id) }}" class="flex items-start gap-3 p-3 rounded-xl hover:bg-surface-container transition-colors border border-transparent hover:border-border-subtle">
                        <div class="w-10 h-10 rounded-lg bg-warning/10 flex items-center justify-center text-warning flex-shrink-0">
                            <span class="material-symbols-outlined">assignment</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-on-surface">{{ $assignment->title }}</h4>
                            <p class="text-xs text-text-muted mt-0.5">Tenggat: {{ $assignment->due_date ? $assignment->due_date->format('d M Y') : '-' }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Pertemuan / Sesi Pembelajaran --}}
        <div class="lg:col-span-2 bg-surface-card border border-border-subtle rounded-2xl p-space-md shadow-sm">
            <h3 class="font-headline-md font-bold text-on-surface mb-4">Jadwal Pertemuan</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low text-text-muted text-xs uppercase tracking-wider">
                            <th class="p-3 font-semibold rounded-l-lg">Pertemuan</th>
                            <th class="p-3 font-semibold">Materi Pokok</th>
                            <th class="p-3 font-semibold">Tanggal</th>
                            <th class="p-3 font-semibold rounded-r-lg">Status</th>
                        </tr>
                    </thead>
                    <tbody class="align-top">
                        @forelse($sessions as $session)
                        <tr class="border-b border-border-subtle last:border-0 hover:bg-surface-container/50 transition-colors">
                            <td class="p-3">
                                <span class="font-bold text-sm text-on-surface">Ke-{{ $session->meeting_number }}</span>
                            </td>
                            <td class="p-3">
                                <p class="text-sm font-semibold text-on-surface">{{ $session->title }}</p>
                            </td>
                            <td class="p-3">
                                <span class="text-sm font-medium text-text-muted">{{ \Carbon\Carbon::parse($session->date)->format('d M Y') }}</span>
                            </td>
                            <td class="p-3">
                                @if($session->status == 'Selesai')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-success/10 text-success">Selesai</span>
                                @elseif($session->status == 'Berlangsung')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-warning/10 text-warning">Berlangsung</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-surface-container-high text-text-muted">Belum Dimulai</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-text-muted text-sm italic">Belum ada pertemuan yang dijadwalkan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
