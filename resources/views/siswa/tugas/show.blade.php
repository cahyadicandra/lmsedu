@extends('layouts.app')

@section('content')
<div class="flex flex-col w-full gap-space-lg pb-space-3xl max-w-5xl mx-auto">

    {{-- Breadcrumb --}}
    <div class="flex flex-wrap items-center gap-space-sm mb-4">
        <a href="{{ route('siswa.tugas.index') }}" class="btn-secondary py-1.5 px-3 text-sm flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali
        </a>
        <span class="material-symbols-outlined text-sm text-text-muted">chevron_right</span>
        <span class="text-sm font-bold text-on-surface truncate">{{ $assignment->title }}</span>
    </div>

    @if(session('success'))
    <div class="p-4 bg-success/10 border border-success/20 rounded-xl text-success font-medium text-sm flex items-center gap-2 mb-2">
        <span class="material-symbols-outlined">check_circle</span>
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-space-lg">
        {{-- Main Content: Assignment Details --}}
        <div class="lg:col-span-2 flex flex-col gap-space-md">
            <div class="bg-surface-card border border-border-subtle rounded-2xl shadow-sm overflow-hidden">
                <div class="p-space-lg border-b border-border-subtle bg-surface-container-low">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <span class="px-3 py-1 bg-primary/10 text-primary rounded-md text-xs font-bold uppercase tracking-wider">{{ $assignment->subject->name ?? 'Umum' }}</span>
                        <span class="text-sm font-medium {{ $assignment->due_date && $assignment->due_date < now() ? 'text-danger font-bold' : 'text-text-muted' }} flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">event</span>
                            Tenggat: {{ $assignment->due_date ? $assignment->due_date->format('d M Y, H:i') : 'Tidak ada tenggat' }}
                        </span>
                    </div>
                    <h1 class="font-headline-lg text-headline-lg font-bold text-on-surface mt-4">{{ $assignment->title }}</h1>
                    <div class="flex items-center gap-2 mt-4 text-sm text-text-muted">
                        <div class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center">
                            <span class="material-symbols-outlined text-sm">person</span>
                        </div>
                        <span>Oleh: <span class="font-bold text-on-surface">{{ $assignment->teacher->name ?? 'Guru' }}</span></span>
                    </div>
                </div>

                <div class="p-space-lg">
                    <h3 class="text-sm font-bold text-on-surface mb-3 uppercase tracking-wider text-text-muted">Instruksi Tugas</h3>
                    <div class="prose prose-sm md:prose-base max-w-none text-on-surface">
                        @if($assignment->description)
                            {!! nl2br(e($assignment->description)) !!}
                        @else
                            <p class="text-text-muted italic">Tidak ada instruksi tertulis.</p>
                        @endif
                    </div>

                    @if($assignment->youtube_link)
                    <div class="mt-6 border-t border-border-subtle pt-4">
                        <h4 class="text-xs font-bold text-text-muted mb-3 uppercase tracking-wider flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px]">play_circle</span> Video Pembelajaran</h4>
                        <div class="relative w-full overflow-hidden rounded-xl bg-surface-container-high" style="padding-top: 56.25%;">
                            @php
                                $ytId = '';
                                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $assignment->youtube_link, $match);
                                if (isset($match[1])) $ytId = $match[1];
                            @endphp
                            @if($ytId)
                                <iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/{{ $ytId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            @else
                                <a href="{{ $assignment->youtube_link }}" target="_blank" class="absolute top-0 left-0 w-full h-full flex flex-col items-center justify-center text-primary hover:bg-primary/5 transition-colors">
                                    <span class="material-symbols-outlined text-4xl mb-2">open_in_new</span>
                                    <span class="font-bold text-sm">Buka Link YouTube</span>
                                </a>
                            @endif
                        </div>
                    </div>
                    @endif

                    @if($assignment->file_path)
                    <div class="mt-6 border-t border-border-subtle pt-4">
                        <h4 class="text-xs font-bold text-text-muted mb-3 uppercase tracking-wider flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px]">attach_file</span> File Lampiran</h4>
                        <div class="flex items-center justify-between p-3 rounded-xl border border-border-subtle bg-surface-container-low hover:bg-surface-container transition-colors group w-full sm:w-auto">
                            <a href="{{ Storage::url($assignment->file_path) }}" target="_blank" class="flex items-center gap-3 flex-1 min-w-0" title="Pratinjau Lampiran">
                                <div class="w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined">description</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-on-surface truncate group-hover:text-primary transition-colors">Lihat Lampiran Tugas</p>
                                    <p class="text-xs text-text-muted truncate">{{ basename($assignment->file_path) }}</p>
                                </div>
                            </a>
                            <a href="{{ Storage::url($assignment->file_path) }}" download class="p-2 ml-2 rounded-lg text-text-muted hover:text-primary hover:bg-primary/10 transition-colors shrink-0" title="Unduh Lampiran">
                                <span class="material-symbols-outlined">download</span>
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Form Pengumpulan --}}
            <div class="bg-surface-card border border-border-subtle rounded-2xl shadow-sm overflow-hidden">
                <div class="p-space-lg border-b border-border-subtle bg-surface-container-low">
                    <h2 class="font-headline-md font-bold text-on-surface">Pengumpulan Tugas</h2>
                </div>
                <div class="p-space-lg">
                    @php
                        $isSubmitted = $submission && in_array($submission->status, ['Sudah Dikumpulkan', 'Sudah Dinilai', 'Terlambat']);
                        $isGraded = $submission && $submission->status === 'Sudah Dinilai';
                    @endphp

                    @if($isGraded)
                        <div class="p-4 bg-success/10 border border-success/20 rounded-xl mb-6">
                            <h3 class="font-bold text-success mb-2 flex items-center gap-2"><span class="material-symbols-outlined">military_tech</span> Tugas Sudah Dinilai</h3>
                            <p class="text-sm text-on-surface">Nilai Anda: <span class="text-2xl font-black text-success">{{ $submission->grade }}</span></p>
                            @if($submission->feedback)
                                <div class="mt-3 p-3 bg-white rounded-lg border border-success/10">
                                    <p class="text-xs font-bold text-text-muted uppercase mb-1">Catatan Guru:</p>
                                    <p class="text-sm text-on-surface">{{ $submission->feedback }}</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div x-data="{ showConfirmModal: false }">
                        <form id="submitForm" action="{{ route('siswa.tugas.submit', $assignment->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="flex flex-col gap-4">
                                <div>
                                    <label for="content" class="text-sm font-bold text-on-surface mb-1 block">Jawaban Text (Opsional jika melampirkan file)</label>
                                    <textarea name="content" id="content" rows="6" class="input-standard w-full p-3" {{ $isGraded ? 'readonly disabled' : '' }} placeholder="Tuliskan jawaban Anda di sini...">{{ old('content', $submission->content ?? '') }}</textarea>
                                    @error('content')
                                        <p class="text-danger text-xs font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                @if(!$isGraded)
                                <div>
                                    <label class="text-sm font-bold text-on-surface mb-1 block">File Lampiran (Maks 10MB)</label>
                                    @if($submission && $submission->file_path)
                                        <p class="text-sm text-success font-medium mb-2">Anda sudah mengunggah file sebelumnya. Unggah lagi untuk menggantinya.</p>
                                    @endif
                                    <input type="file" name="file" class="w-full px-3 py-2 bg-canvas-bg border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-colors">
                                    @error('file')
                                        <p class="text-danger text-xs font-medium mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                @else
                                    @if($submission && $submission->file_path)
                                    <div>
                                        <label class="text-sm font-bold text-on-surface mb-1 block">File Lampiran Anda</label>
                                        <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-semibold text-primary hover:underline">
                                            <span class="material-symbols-outlined text-sm">attach_file</span> Lihat File yang Dikumpulkan
                                        </a>
                                    </div>
                                    @endif
                                @endif
                            </div>

                            @if(!$isGraded)
                            <div class="flex items-center justify-end gap-3 mt-6">
                                <button type="button" class="btn-primary" @click="showConfirmModal = true">
                                    {{ $isSubmitted ? 'Perbarui Pengumpulan' : 'Kirim Tugas' }}
                                </button>
                            </div>
                            @endif
                        </form>

                        <!-- Custom Confirm Modal -->
                        <div x-show="showConfirmModal" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center bg-on-surface/40 backdrop-blur-sm" x-transition.opacity style="display:none;">
                            <div class="bg-surface-card w-full max-w-sm rounded-2xl shadow-xl overflow-hidden" @click.away="showConfirmModal=false">
                                <div class="px-space-md py-4 border-b border-border-subtle flex items-center justify-between bg-canvas-bg/30">
                                    <h3 class="font-headline-md font-bold text-on-surface">Konfirmasi Pengumpulan</h3>
                                    <button @click="showConfirmModal=false" class="text-text-muted hover:text-danger"><span class="material-symbols-outlined">close</span></button>
                                </div>
                                <div class="p-space-md">
                                    <p class="text-sm text-text-muted">Apakah Anda yakin ingin mengumpulkan tugas ini? Anda mungkin tidak dapat mengubahnya lagi setelah dinilai oleh Guru.</p>
                                </div>
                                <div class="pt-space-md border-t border-border-subtle flex justify-end gap-2 p-space-md bg-canvas-bg/30 mt-0">
                                    <button type="button" @click="showConfirmModal=false" class="px-4 py-2 rounded-lg text-sm font-semibold text-text-muted hover:bg-canvas-bg transition-colors">Batal</button>
                                    <button type="button" @click="document.getElementById('submitForm').submit()" class="px-4 py-2 rounded-lg text-sm font-semibold bg-primary text-white hover:bg-primary/90 shadow-sm">Ya, Kumpulkan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar: Status --}}
        <div class="flex flex-col gap-space-md">
            <div class="bg-surface-card border border-border-subtle rounded-2xl shadow-sm p-space-md">
                <h3 class="font-headline-sm font-bold text-on-surface mb-4">Status Tugas</h3>
                
                @php
                    $status = $submission ? $submission->status : 'Belum Dikerjakan';
                    $statusColor = match($status) {
                        'Sudah Dikumpulkan', 'Sudah Dinilai' => 'bg-success text-white',
                        'Terlambat' => 'bg-danger text-white',
                        'Sedang Dikerjakan' => 'bg-warning text-white',
                        default => 'bg-surface-container-high text-text-muted'
                    };
                @endphp
                <div class="w-full py-2 px-3 rounded-lg text-center font-bold text-sm {{ $statusColor }} mb-4">
                    {{ $status }}
                </div>

                <div class="flex flex-col gap-3 text-sm">
                    <div class="flex justify-between items-center py-2 border-b border-border-subtle">
                        <span class="text-text-muted font-medium">Batas Waktu</span>
                        <span class="font-bold text-on-surface">{{ $assignment->due_date ? $assignment->due_date->format('d/m/Y H:i') : '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-border-subtle">
                        <span class="text-text-muted font-medium">Waktu Pengumpulan</span>
                        <span class="font-bold text-on-surface">{{ $isSubmitted ? $submission->updated_at->format('d/m/Y H:i') : '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
