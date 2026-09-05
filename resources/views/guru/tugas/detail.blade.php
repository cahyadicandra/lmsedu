@extends('layouts.app')

@section('content')
<div>
    <div class="flex items-center gap-4 mb-space-lg">
        <a href="{{ route('tugas.index') }}" class="w-10 h-10 rounded-full bg-surface-card border border-border-subtle flex items-center justify-center text-text-muted hover:text-primary transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div>
            <h1 class="font-headline-lg text-headline-lg font-bold text-on-surface">Detail Tugas</h1>
            <p class="font-body-md text-text-muted mt-1">{{ $assignment->title }} - {{ $assignment->subject->name ?? '-' }} ({{ $assignment->schoolClass->name ?? '-' }})</p>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-success/10 text-success border border-success/20 px-4 py-3 rounded-xl mb-space-md flex items-center gap-2">
        <span class="material-symbols-outlined">check_circle</span>{{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-space-md">
        <!-- Informasi Tugas -->
        <div class="lg:col-span-1">
            <div class="bg-surface-card rounded-2xl shadow-sm border border-border-subtle p-space-md">
                <h3 class="font-headline-sm font-bold text-on-surface mb-4 border-b border-border-subtle pb-2">Informasi Tugas</h3>
                <div class="flex flex-col gap-3">
                    <div>
                        <p class="text-xs text-text-muted font-semibold uppercase tracking-wider mb-0.5">Status</p>
                        @if($assignment->status === 'Published')
                            <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold bg-success-fixed text-on-success-fixed">Published</span>
                        @elseif($assignment->status === 'Closed')
                            <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold bg-danger-fixed text-on-danger-fixed">Closed</span>
                        @else
                            <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold bg-surface-variant text-text-muted">Draft</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs text-text-muted font-semibold uppercase tracking-wider mb-0.5">Tenggat Waktu</p>
                        <p class="text-sm font-semibold text-on-surface">{{ $assignment->due_date ? $assignment->due_date->format('d M Y') : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-text-muted font-semibold uppercase tracking-wider mb-0.5">Deskripsi</p>
                        <p class="text-sm text-on-surface mt-1 whitespace-pre-wrap">{{ $assignment->description ?: 'Tidak ada deskripsi.' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Pengumpulan -->
        <div class="lg:col-span-2">
            <div class="bg-surface-card rounded-2xl shadow-sm border border-border-subtle overflow-hidden">
                <div class="px-space-md py-4 border-b border-border-subtle flex items-center justify-between bg-canvas-bg/30">
                    <h3 class="font-headline-sm font-bold text-on-surface">Daftar Pengumpulan Siswa</h3>
                    <span class="text-xs font-semibold text-text-muted bg-surface-variant px-2 py-1 rounded-lg">{{ $assignment->submissions->count() }} Terkumpul</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-canvas-bg/50 border-b border-border-subtle">
                                <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Nama Siswa</th>
                                <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Waktu Kumpul</th>
                                <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Status</th>
                                <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Nilai</th>
                                <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-subtle text-sm">
                            @forelse($assignment->submissions as $sub)
                            <tr class="hover:bg-canvas-bg/30 transition-colors" x-data="{ openGradeModal: false, form: { grade: '{{ $sub->grade }}', feedback: '{{ addslashes($sub->feedback) }}' } }">
                                <td class="py-3 px-space-md font-semibold text-on-surface">{{ $sub->student->name ?? 'Unknown' }}</td>
                                <td class="py-3 px-space-md text-text-muted">{{ $sub->updated_at->format('d M Y H:i') }}</td>
                                <td class="py-3 px-space-md">
                                    <span class="inline-flex items-center gap-1 {{ in_array($sub->status, ['Sudah Dikumpulkan', 'Sudah Dinilai']) ? 'text-success' : 'text-text-muted' }} font-medium text-xs">
                                        {{ $sub->status }}
                                    </span>
                                </td>
                                <td class="py-3 px-space-md">
                                    @if($sub->grade !== null)
                                        <span class="font-bold text-primary">{{ $sub->grade }}</span>
                                    @else
                                        <span class="text-text-muted italic">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-space-md text-right">
                                    <button @click="openGradeModal = true" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-primary-fixed text-on-primary-fixed hover:bg-primary hover:text-white transition-colors">
                                        Beri Nilai
                                    </button>

                                    <!-- Grading Modal -->
                                    <div x-show="openGradeModal" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center bg-on-surface/40 backdrop-blur-sm" x-transition.opacity style="display:none; text-align: left;">
                                        <div class="bg-surface-card w-full max-w-sm rounded-2xl shadow-xl overflow-hidden" @click.away="openGradeModal=false">
                                            <div class="px-space-md py-4 border-b border-border-subtle flex items-center justify-between bg-canvas-bg/30">
                                                <h3 class="font-headline-md font-bold text-on-surface">Penilaian: {{ $sub->student->name }}</h3>
                                                <button type="button" @click="openGradeModal=false" class="text-text-muted hover:text-danger"><span class="material-symbols-outlined">close</span></button>
                                            </div>
                                            <form action="{{ route('tugas.grade', $sub->id) }}" method="POST" class="p-space-md flex flex-col gap-4">
                                                @csrf
                                                <div>
                                                    <label class="block text-sm font-semibold text-on-surface mb-1">Jawaban/Konten Siswa</label>
                                                    <div class="p-3 bg-canvas-bg rounded-lg text-sm text-on-surface border border-border-subtle whitespace-pre-wrap max-h-40 overflow-y-auto">{{ $sub->content ?: 'Tidak ada teks yang dikirimkan.' }}</div>
                                                </div>
                                                @if($sub->file_path)
                                                <div>
                                                    <a href="{{ Storage::url($sub->file_path) }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-semibold text-primary hover:underline">
                                                        <span class="material-symbols-outlined text-sm">attach_file</span> Lihat Lampiran
                                                    </a>
                                                </div>
                                                @endif
                                                <div>
                                                    <label class="block text-sm font-semibold text-on-surface mb-1">Nilai (0-100) <span class="text-danger">*</span></label>
                                                    <input type="number" name="grade" x-model="form.grade" @input="if($el.value > 100) $el.value = 100; if($el.value !== '' && $el.value < 0) $el.value = 0; form.grade = $el.value;" min="0" max="100" required class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-semibold text-on-surface mb-1">Komentar / Feedback</label>
                                                    <textarea name="feedback" x-model="form.feedback" rows="2" class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none"></textarea>
                                                </div>
                                                <div class="pt-space-md border-t border-border-subtle flex justify-end gap-2 mt-2">
                                                    <button type="button" @click="openGradeModal=false" class="px-4 py-2 rounded-lg text-sm font-semibold text-text-muted hover:bg-canvas-bg transition-colors">Batal</button>
                                                    <button type="submit" class="px-4 py-2 rounded-lg text-sm font-semibold bg-primary text-white hover:bg-primary/90 shadow-sm">Simpan Nilai</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="py-8 text-center text-text-muted">
                                <p>Belum ada pengumpulan dari siswa.</p>
                            </td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
