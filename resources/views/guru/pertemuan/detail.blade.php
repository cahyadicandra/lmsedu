@extends('layouts.app')

@section('content')
<div x-data="{ 
    tab: '{{ session('tab', old('tab', 'informasi')) }}',
    showToast: {{ session('success') ? 'true' : 'false' }}
}">
    
    {{-- Toast Notification --}}
    <div x-show="showToast" x-transition.opacity x-transition:enter.duration.500ms x-transition:leave.duration.500ms x-init="setTimeout(() => showToast = false, 3000)" class="fixed top-4 right-4 z-[99] bg-success text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-3 font-semibold" style="display: none;">
        <span class="material-symbols-outlined">check_circle</span>
        <span>{{ session('success') }}</span>
        <button @click="showToast = false" class="ml-2 hover:text-white/80"><span class="material-symbols-outlined text-sm">close</span></button>
    </div>
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
                    <button type="submit" class="bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-full font-semibold flex items-center gap-2 transition-colors shadow-sm">
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
                    <button type="submit" class="bg-success hover:bg-success/90 text-white px-4 py-2 rounded-full font-semibold flex items-center gap-2 transition-colors shadow-sm">
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
    <div class="inline-flex items-center gap-2 p-1.5 bg-surface-card border border-border-subtle rounded-full mb-space-lg shadow-sm">
        <button @click="tab = 'informasi'" :class="tab === 'informasi' ? 'bg-primary text-white shadow-md' : 'text-text-muted hover:text-on-surface hover:bg-canvas-bg/50'" class="px-6 py-2 rounded-full text-sm font-bold transition-all duration-300">
            Informasi
        </button>
        <button @click="tab = 'materi'" :class="tab === 'materi' ? 'bg-primary text-white shadow-md' : 'text-text-muted hover:text-on-surface hover:bg-canvas-bg/50'" class="px-6 py-2 rounded-full text-sm font-bold transition-all duration-300">
            Materi
        </button>
        <button @click="tab = 'absensi'" :class="tab === 'absensi' ? 'bg-primary text-white shadow-md' : 'text-text-muted hover:text-on-surface hover:bg-canvas-bg/50'" class="px-6 py-2 rounded-full text-sm font-bold transition-all duration-300">
            Absensi
        </button>
        <button @click="tab = 'nilai'" :class="tab === 'nilai' ? 'bg-primary text-white shadow-md' : 'text-text-muted hover:text-on-surface hover:bg-canvas-bg/50'" class="px-6 py-2 rounded-full text-sm font-bold transition-all duration-300">
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

    {{-- Tab Content: Materi --}}
    <div x-show="tab === 'materi'" x-cloak class="grid grid-cols-1 lg:grid-cols-3 gap-space-md">
        <div class="lg:col-span-2">
            <h3 class="font-headline-sm font-bold text-on-surface mb-4 border-b border-border-subtle pb-2">Materi Pertemuan</h3>
            @forelse($session->materials as $m)
            <div class="bg-surface-card border border-border-subtle rounded-xl p-5 mb-4 shadow-sm relative hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <h4 class="font-bold text-lg text-primary">{{ $m->title }}</h4>
                        @if($m->description)
                        <p class="text-sm text-on-surface mt-2 whitespace-pre-line">{{ $m->description }}</p>
                        @endif
                    </div>
                    <form action="{{ route('pertemuan.materi.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus materi ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-1.5 text-text-muted hover:text-danger hover:bg-danger/10 rounded-full transition-colors" title="Hapus"><span class="material-symbols-outlined text-sm">delete</span></button>
                    </form>
                </div>
                
                <div class="mt-4 pt-4 border-t border-border-subtle flex gap-3 flex-wrap">
                    @if($m->file_path)
                    @php
                        $displayName = preg_replace('/^\d+_/', '', basename($m->file_path));
                    @endphp
                    <a href="{{ Storage::url($m->file_path) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-success/10 text-success border border-success/20 rounded-full text-sm font-bold hover:bg-success hover:text-white transition-colors" title="{{ $displayName }}">
                        <span class="material-symbols-outlined text-[18px]">download</span> Unduh Lampiran
                    </a>
                    @endif
                    @if($m->youtube_link)
                    @php
                        $youtubeId = '';
                        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/|youtube\.com/shorts/)([^"&?/ ]{11})%i', $m->youtube_link, $match)) {
                            $youtubeId = $match[1];
                        }
                    @endphp
                    @if($youtubeId)
                    <a href="https://www.youtube.com/watch?v={{ $youtubeId }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-danger/10 text-danger border border-danger/20 rounded-full text-sm font-bold hover:bg-danger hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-[18px]">play_circle</span> Tonton Video
                    </a>
                    @else
                    <a href="{{ $m->youtube_link }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-danger/10 text-danger border border-danger/20 rounded-full text-sm font-bold hover:bg-danger hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-[18px]">open_in_new</span> Buka Link
                    </a>
                    @endif
                    @endif
                </div>
            </div>
            @empty
            <div class="py-12 text-center border border-border-subtle rounded-2xl bg-canvas-bg/30 border-dashed text-text-muted flex flex-col items-center">
                <span class="material-symbols-outlined text-5xl mb-2 opacity-50">menu_book</span>
                <p class="font-semibold text-on-surface">Belum ada materi</p>
                <p class="text-sm">Silakan tambahkan materi untuk sesi ini.</p>
            </div>
            @endforelse
        </div>
        
        <div>
            <div class="bg-surface-card border border-border-subtle rounded-2xl p-space-md shadow-sm sticky top-4">
                <h3 class="font-bold text-on-surface mb-4 border-b border-border-subtle pb-2">Tambah Materi</h3>
                <form action="{{ route('pertemuan.materi.store', $session->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
                    @csrf
                    <input type="hidden" name="tab" value="materi">
                    <div>
                        <label class="block text-xs font-semibold text-text-muted mb-1">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-3 py-2 bg-canvas-bg border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                        @error('title')<span class="text-xs text-danger mt-1 block">{{ $message }}</span>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-text-muted mb-1">Teks / Catatan</label>
                        <textarea name="description" rows="3" class="w-full px-3 py-2 bg-canvas-bg border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none" placeholder="Tulis instruksi atau rangkuman...">{{ old('description') }}</textarea>
                        @error('description')<span class="text-xs text-danger mt-1 block">{{ $message }}</span>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-text-muted mb-1">Upload File <span class="font-normal">(Opsional)</span></label>
                        <input type="file" name="file_path" class="w-full px-3 py-2 bg-canvas-bg border border-border-subtle rounded-lg text-sm outline-none file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer text-text-muted">
                        @error('file_path')<span class="text-xs text-danger mt-1 block">{{ $message }}</span>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-text-muted mb-1">Link YouTube <span class="font-normal">(Opsional)</span></label>
                        <input type="url" name="youtube_link" value="{{ old('youtube_link') }}" placeholder="https://youtube.com/watch?v=..." class="w-full px-3 py-2 bg-canvas-bg border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                        @error('youtube_link')<span class="text-xs text-danger mt-1 block">{{ $message }}</span>@enderror
                    </div>
                    <button type="submit" class="w-full bg-primary hover:bg-primary/90 text-white py-2 rounded-full font-semibold transition-colors mt-2 shadow-sm flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">upload</span> Simpan Materi
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Tab Content: Absensi --}}
    <div x-show="tab === 'absensi'" x-cloak>
        <div class="bg-surface-card rounded-2xl border border-border-subtle shadow-sm p-space-md flex flex-col items-center justify-center py-12">
            <span class="material-symbols-outlined text-5xl text-border-subtle mb-3">how_to_reg</span>
            <p class="text-on-surface font-semibold mb-1">Manajemen Absensi</p>
            <p class="text-text-muted text-sm text-center max-w-md mb-6">Kelola absensi untuk seluruh siswa pada pertemuan ini secara langsung.</p>
            <a href="{{ route('absensi.index', ['session_id' => $session->id]) }}" class="bg-primary hover:bg-primary/90 text-white px-6 py-2.5 rounded-full font-semibold transition-colors shadow-sm">
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
            <a href="{{ route('nilai.index', ['subject_id' => $session->subject_id, 'school_class_id' => $session->school_class_id]) }}" class="bg-primary hover:bg-primary/90 text-white px-6 py-2.5 rounded-full font-semibold transition-colors shadow-sm">
                Kelola Nilai
            </a>
        </div>
    </div>
</div>
@endsection

