@extends('layouts.app')

@section('content')
<div class="flex flex-col w-full gap-space-lg pb-space-3xl">

    {{-- Breadcrumb --}}
    <div class="flex flex-wrap items-center justify-between gap-space-sm">
        <span class="font-label-md text-label-md font-semibold text-primary">Tugas</span>
        <div class="flex items-center gap-space-sm">
            <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-text-muted hover:text-primary transition-colors">Dashboard</a>
            <span class="material-symbols-outlined text-sm text-text-muted">chevron_right</span>
            <span class="text-sm font-bold text-on-surface">Tugas</span>
        </div>
    </div>

    {{-- Filter Form --}}
    <form method="GET" action="{{ route('siswa.tugas.index') }}" class="flex items-center gap-3 bg-surface-card p-4 rounded-2xl border border-border-subtle shadow-sm">
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

    {{-- Assignments List --}}
    <div class="bg-surface-card border border-border-subtle rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low text-text-muted text-xs uppercase tracking-wider">
                        <th class="p-4 font-semibold">Tugas</th>
                        <th class="p-4 font-semibold">Mata Pelajaran</th>
                        <th class="p-4 font-semibold">Tenggat Waktu</th>
                        <th class="p-4 font-semibold">Status</th>
                        <th class="p-4 font-semibold text-center">Nilai</th>
                        <th class="p-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @forelse($assignments as $assignment)
                    @php
                        $submission = $assignment->submissions->where('student_id', auth()->id())->first();
                        $status = $submission ? $submission->status : 'Belum Dikerjakan';
                        $statusColor = match($status) {
                            'Sudah Dikumpulkan', 'Sudah Dinilai' => 'bg-success/10 text-success',
                            'Terlambat' => 'bg-danger/10 text-danger',
                            'Sedang Dikerjakan' => 'bg-warning/10 text-warning',
                            default => 'bg-surface-container-high text-text-muted'
                        };
                    @endphp
                    <tr class="border-b border-border-subtle last:border-0 hover:bg-surface-container/50 transition-colors">
                        <td class="p-4">
                            <p class="text-sm font-bold text-on-surface">{{ $assignment->title }}</p>
                        </td>
                        <td class="p-4">
                            <span class="text-sm font-medium text-text-muted">{{ $assignment->subject->name ?? '-' }}</span>
                        </td>
                        <td class="p-4">
                            <span class="text-sm font-medium {{ $assignment->due_date && $assignment->due_date < now() && !in_array($status, ['Sudah Dikumpulkan', 'Sudah Dinilai']) ? 'text-danger font-bold' : 'text-text-muted' }}">
                                {{ $assignment->due_date ? $assignment->due_date->format('d M Y, H:i') : 'Tidak ada tenggat' }}
                            </span>
                        </td>
                        <td class="p-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold {{ $statusColor }}">
                                {{ $status }}
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            @if($submission && $submission->grade !== null)
                                <span class="font-bold text-lg text-primary">{{ $submission->grade }}</span>
                            @else
                                <span class="text-text-muted">-</span>
                            @endif
                        </td>
                        <td class="p-4 text-right">
                            <a href="{{ route('siswa.tugas.show', $assignment->id) }}" class="btn-primary py-1.5 px-3 text-xs bg-primary/10 text-primary border-none hover:bg-primary/20 inline-flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">visibility</span> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-text-muted text-sm italic">Belum ada tugas yang diberikan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
