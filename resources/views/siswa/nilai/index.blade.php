@extends('layouts.app')

@section('content')
<div class="flex flex-col w-full gap-space-lg pb-space-3xl">

    {{-- Breadcrumb --}}
    <div class="flex flex-wrap items-center justify-between gap-space-sm">
        <span class="font-label-md text-label-md font-semibold text-primary">Nilai Saya</span>
        <div class="flex items-center gap-space-sm">
            <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-text-muted hover:text-primary transition-colors">Dashboard</a>
            <span class="material-symbols-outlined text-sm text-text-muted">chevron_right</span>
            <span class="text-sm font-bold text-on-surface">Nilai</span>
        </div>
    </div>

    {{-- Filter Form --}}
    <form method="GET" action="{{ route('siswa.nilai.index') }}" class="flex items-center gap-3 bg-surface-card p-4 rounded-2xl border border-border-subtle shadow-sm">
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

    {{-- Grades List --}}
    <div class="bg-surface-card border border-border-subtle rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low text-text-muted text-xs uppercase tracking-wider">
                        <th class="p-4 font-semibold">Tugas / Penilaian</th>
                        <th class="p-4 font-semibold">Mata Pelajaran</th>
                        <th class="p-4 font-semibold">Tanggal Dinilai</th>
                        <th class="p-4 font-semibold text-center">Nilai</th>
                        <th class="p-4 font-semibold">Catatan Guru</th>
                    </tr>
                </thead>
                <tbody class="align-top">
                    @forelse($grades as $submission)
                    <tr class="border-b border-border-subtle last:border-0 hover:bg-surface-container/50 transition-colors">
                        <td class="p-4">
                            <p class="text-sm font-bold text-on-surface">{{ $submission->assignment->title ?? 'Tugas' }}</p>
                        </td>
                        <td class="p-4">
                            <span class="text-sm font-medium text-text-muted">{{ $submission->assignment->subject->name ?? '-' }}</span>
                        </td>
                        <td class="p-4">
                            <span class="text-sm font-medium text-text-muted">
                                {{ $submission->updated_at ? $submission->updated_at->format('d M Y') : '-' }}
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            @php
                                $gradeColor = $submission->grade >= 75 ? 'text-success' : 'text-danger';
                            @endphp
                            <span class="font-bold text-lg {{ $gradeColor }}">{{ $submission->grade }}</span>
                        </td>
                        <td class="p-4">
                            @if($submission->feedback)
                                <p class="text-sm text-on-surface italic max-w-xs line-clamp-3">"{{ $submission->feedback }}"</p>
                            @else
                                <span class="text-text-muted text-sm">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-text-muted text-sm italic">Belum ada nilai yang dipublikasikan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
