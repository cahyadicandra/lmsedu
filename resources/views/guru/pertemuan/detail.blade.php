@extends('layouts.app')

@section('content')
<div x-data="{ tab: 'informasi' }">
    {{-- Breadcrumb & Header --}}
    <div class="flex items-center gap-2 text-sm text-text-muted mb-4">
        <a href="{{ route('pertemuan.index') }}" class="hover:text-primary transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span> Kembali
        </a>
        <span>/</span>
        <span class="font-semibold text-on-surface">Detail Pertemuan</span>
    </div>

    <div class="flex items-center justify-between mb-space-lg">
        <div>
            <h1 class="font-headline-lg text-headline-lg font-bold text-on-surface">Pertemuan Ke-{{ $session->meeting_number }}</h1>
            <p class="font-body-md text-text-muted mt-1">{{ $session->title }}</p>
        </div>
        <div class="flex items-center gap-3">
            @if($session->status === 'Belum Dimulai')
                <form action="{{ route('pertemuan.update', $session->id) }}" method="POST">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="Berlangsung">
                    <input type="hidden" name="subject_id" value="{{ $session->subject_id }}">
                    <input type="hidden" name="school_class_id" value="{{ $session->school_class_id }}">
                    <input type="hidden" name="meeting_number" value="{{ $session->meeting_number }}">
                    <input type="hidden" name="title" value="{{ $session->title }}">
                    <input type="hidden" name="date" value="{{ $session->date }}">
                    <input type="hidden" name="time" value="{{ $session->time }}">
                    <button type="submit" class="bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-lg font-semibold flex items-center gap-2 transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-sm">play_arrow</span> Mulai Pertemuan
                    </button>
                </form>
            @elseif($session->status === 'Berlangsung')
                <form action="{{ route('pertemuan.update', $session->id) }}" method="POST">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="Selesai">
                    <input type="hidden" name="subject_id" value="{{ $session->subject_id }}">
                    <input type="hidden" name="school_class_id" value="{{ $session->school_class_id }}">
                    <input type="hidden" name="meeting_number" value="{{ $session->meeting_number }}">
                    <input type="hidden" name="title" value="{{ $session->title }}">
                    <input type="hidden" name="date" value="{{ $session->date }}">
                    <input type="hidden" name="time" value="{{ $session->time }}">
                    <button type="submit" class="bg-success hover:bg-success/90 text-white px-4 py-2 rounded-lg font-semibold flex items-center gap-2 transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-sm">check</span> Selesaikan Pertemuan
                    </button>
                </form>
            @else
                <span class="inline-flex items-center gap-1 bg-success/10 text-success px-3 py-1.5 rounded-lg text-sm font-semibold">
                    <span class="material-symbols-outlined text-sm">done_all</span> Selesai
                </span>
            @endif
        </div>
    </div>

    {{-- Tabs Navigation --}}
    <div class="flex items-center gap-2 border-b border-border-subtle mb-space-md">
        <button @click="tab = 'informasi'" :class="tab === 'informasi' ? 'border-primary text-primary font-bold' : 'border-transparent text-text-muted hover:text-on-surface hover:border-border-subtle font-semibold'" class="px-4 py-3 border-b-2 text-sm transition-colors">
            Informasi
        </button>
        <button @click="tab = 'absensi'" :class="tab === 'absensi' ? 'border-primary text-primary font-bold' : 'border-transparent text-text-muted hover:text-on-surface hover:border-border-subtle font-semibold'" class="px-4 py-3 border-b-2 text-sm transition-colors">
            Absensi
        </button>
        <button @click="tab = 'nilai'" :class="tab === 'nilai' ? 'border-primary text-primary font-bold' : 'border-transparent text-text-muted hover:text-on-surface hover:border-border-subtle font-semibold'" class="px-4 py-3 border-b-2 text-sm transition-colors">
            Nilai
        </button>
    </div>

    {{-- Tab Content: Informasi --}}
    <div x-show="tab === 'informasi'" x-cloak>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
            <div class="bg-surface-card rounded-2xl border border-border-subtle shadow-sm p-space-md">
                <h3 class="font-headline-md font-bold text-on-surface mb-4">Informasi Sesi</h3>
                <div class="flex flex-col gap-3 text-sm">
                    <div class="grid grid-cols-3"><span class="text-text-muted font-semibold">Mata Pelajaran</span><span class="col-span-2 font-medium text-on-surface">{{ $session->subject->name ?? '-' }}</span></div>
                    <div class="grid grid-cols-3"><span class="text-text-muted font-semibold">Kelas</span><span class="col-span-2 font-medium text-on-surface">{{ $session->schoolClass->name ?? '-' }}</span></div>
                    <div class="grid grid-cols-3"><span class="text-text-muted font-semibold">Tanggal</span><span class="col-span-2 font-medium text-on-surface">{{ date('d F Y', strtotime($session->date)) }}</span></div>
                    <div class="grid grid-cols-3"><span class="text-text-muted font-semibold">Waktu</span><span class="col-span-2 font-medium text-on-surface">{{ $session->time ? date('H:i', strtotime($session->time)) : '-' }}</span></div>
                    <div class="grid grid-cols-3"><span class="text-text-muted font-semibold">Status</span>
                        <span class="col-span-2">
                            @if($session->status === 'Berlangsung')
                                <span class="text-warning font-semibold">{{ $session->status }}</span>
                            @elseif($session->status === 'Selesai')
                                <span class="text-success font-semibold">{{ $session->status }}</span>
                            @else
                                <span class="text-text-muted font-semibold">{{ $session->status }}</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
            <div class="bg-surface-card rounded-2xl border border-border-subtle shadow-sm p-space-md">
                <h3 class="font-headline-md font-bold text-on-surface mb-4">Deskripsi Pembelajaran</h3>
                <p class="text-sm text-on-surface leading-relaxed">
                    {{ $session->description ?: 'Tidak ada deskripsi untuk pertemuan ini.' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Tab Content: Absensi --}}
    <div x-show="tab === 'absensi'" x-cloak>
        <div class="bg-surface-card rounded-2xl border border-border-subtle shadow-sm p-space-md flex flex-col items-center justify-center py-12">
            <span class="material-symbols-outlined text-5xl text-border-subtle mb-3">how_to_reg</span>
            <p class="text-on-surface font-semibold mb-1">Manajemen Absensi</p>
            <p class="text-text-muted text-sm text-center max-w-md mb-6">Kelola absensi untuk seluruh siswa pada pertemuan ini secara langsung.</p>
            <a href="{{ route('absensi.index', ['session_id' => $session->id]) }}" class="bg-primary hover:bg-primary/90 text-white px-6 py-2.5 rounded-xl font-semibold transition-colors shadow-sm">
                Isi / Lihat Absensi
            </a>
        </div>
    </div>

    {{-- Tab Content: Nilai --}}
    <div x-show="tab === 'nilai'" x-cloak>
        <div class="bg-surface-card rounded-2xl border border-border-subtle shadow-sm p-space-md flex flex-col items-center justify-center py-12">
            <span class="material-symbols-outlined text-5xl text-border-subtle mb-3">assignment_turned_in</span>
            <p class="text-on-surface font-semibold mb-1">Manajemen Nilai</p>
            <p class="text-text-muted text-sm text-center max-w-md mb-6">Tambahkan nilai tugas atau evaluasi untuk siswa pada kelas ini.</p>
            <a href="{{ route('nilai.index', ['subject_id' => $session->subject_id, 'school_class_id' => $session->school_class_id]) }}" class="bg-primary hover:bg-primary/90 text-white px-6 py-2.5 rounded-xl font-semibold transition-colors shadow-sm">
                Kelola Nilai
            </a>
        </div>
    </div>
</div>
@endsection
