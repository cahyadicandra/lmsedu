@extends('layouts.app')

@section('content')
<div>
    <div class="flex items-center justify-between mb-space-lg">
        <div>
            <h1 class="font-headline-lg text-headline-lg font-bold text-on-surface">Manajemen Absensi</h1>
            <p class="font-body-md text-text-muted mt-1">Pilih pertemuan untuk mengelola kehadiran siswa.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-success/10 text-success border border-success/20 px-4 py-3 rounded-xl mb-space-md flex items-center gap-2">
        <span class="material-symbols-outlined">check_circle</span>{{ session('success') }}
    </div>
    @endif

    {{-- Filter Form --}}
    <div class="bg-surface-card rounded-2xl p-space-md border border-border-subtle shadow-sm mb-space-md flex flex-wrap gap-4 items-end">
        <form action="{{ route('absensi.index') }}" method="GET" class="flex flex-wrap gap-4 items-end w-full">
            <div class="flex-1 min-w-[150px]">
                <label class="block text-xs font-semibold text-text-muted mb-1 uppercase tracking-wider">Tanggal</label>
                <div class="relative flex items-center">
                    <span class="material-symbols-outlined absolute left-3 text-text-muted text-[18px]">event</span>
                    <input type="date" name="date" value="{{ request('date') }}" class="w-full pl-9 pr-3 py-2 bg-canvas-bg/50 border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                </div>
            </div>
            <div class="flex-1 min-w-[150px]">
                <label class="block text-xs font-semibold text-text-muted mb-1 uppercase tracking-wider">Mata Pelajaran</label>
                <select name="subject_id" class="w-full px-3 py-2 bg-canvas-bg/50 border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                    <option value="">Semua Mapel</option>
                    @foreach($subjects as $sub)
                        <option value="{{ $sub->id }}" {{ request('subject_id') == $sub->id ? 'selected' : '' }}>{{ $sub->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-[150px]">
                <label class="block text-xs font-semibold text-text-muted mb-1 uppercase tracking-wider">Kelas</label>
                <select name="school_class_id" class="w-full px-3 py-2 bg-canvas-bg/50 border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                    <option value="">Semua Kelas</option>
                    @foreach($classes as $c)
                        <option value="{{ $c->id }}" {{ request('school_class_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="px-4 py-2 bg-surface-variant text-text-muted hover:bg-border-subtle rounded-lg text-sm font-semibold transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">filter_list</span> Filter
                </button>
            </div>
        </form>
    </div>

    <div class="bg-surface-card rounded-2xl shadow-sm border border-border-subtle overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-canvas-bg/50 border-b border-border-subtle">
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Tanggal</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Mata Pelajaran</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Kelas</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Pertemuan</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Jml Siswa</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Status Absensi</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-subtle text-sm">
                    @forelse($sessions as $s)
                    <tr class="hover:bg-canvas-bg/30 transition-colors">
                        <td class="py-3 px-space-md">
                            <span class="font-semibold text-on-surface block">{{ date('d M Y', strtotime($s->date)) }}</span>
                            <span class="text-xs text-text-muted">{{ $s->time ? date('H:i', strtotime($s->time)) : '-' }}</span>
                        </td>
                        <td class="py-3 px-space-md font-semibold text-primary">{{ $s->subject->name ?? '-' }}</td>
                        <td class="py-3 px-space-md font-medium">{{ $s->schoolClass->name ?? '-' }}</td>
                        <td class="py-3 px-space-md"><span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold bg-primary-fixed text-on-primary-fixed">Ke-{{ $s->meeting_number }}</span></td>
                        @php
                            $totalSiswa = $s->schoolClass->students()->count() ?? 0;
                            $absenMasuk = $s->attendances->count();
                        @endphp
                        <td class="py-3 px-space-md font-medium text-text-muted">{{ $totalSiswa }} Siswa</td>
                        <td class="py-3 px-space-md">
                            @if($absenMasuk > 0)
                                <span class="inline-flex items-center gap-1 text-success font-medium text-xs">
                                    <span class="material-symbols-outlined text-sm">check_circle</span> Terisi ({{ $absenMasuk }})
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-warning font-medium text-xs">
                                    <span class="material-symbols-outlined text-sm">warning</span> Belum Diisi
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-space-md text-right">
                            <a href="{{ route('absensi.index', ['session_id' => $s->id]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold bg-primary/10 text-primary hover:bg-primary/20 rounded-lg transition-colors">
                                <span class="material-symbols-outlined text-sm">how_to_reg</span> Isi Absensi
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="py-8 text-center text-text-muted">
                        <div class="flex flex-col items-center gap-2">
                            <span class="material-symbols-outlined text-4xl text-border-subtle">event_note</span>
                            <p>Belum ada jadwal pertemuan yang sesuai.</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($sessions->hasPages())<div class="p-space-md border-t border-border-subtle">{{ $sessions->links() }}</div>@endif
    </div>
</div>
@endsection
