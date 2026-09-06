@extends('layouts.app')

@section('content')
<div>
    {{-- Breadcrumb & Header --}}
    <div class="flex items-center gap-2 text-sm text-text-muted mb-4">
        <a href="{{ route('absensi.index') }}" class="hover:text-primary transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span> Kembali
        </a>
        <span>/</span>
        <a href="{{ route('pertemuan.show', $session->id) }}" class="hover:text-primary transition-colors flex items-center gap-1">
            Pertemuan Ke-{{ $session->meeting_number }}
        </a>
        <span>/</span>
        <span class="font-semibold text-on-surface">Isi Absensi</span>
    </div>

    <div class="flex items-center justify-between mb-space-lg">
        <div>
            <h1 class="font-headline-lg text-headline-lg font-bold text-on-surface">Isi Absensi: Pertemuan Ke-{{ $session->meeting_number }}</h1>
            <p class="font-body-md text-text-muted mt-1">{{ $session->subject->name ?? '-' }} | Kelas {{ $session->schoolClass->name ?? '-' }} | {{ date('d M Y', strtotime($session->date)) }}</p>
        </div>
    </div>

    <div class="bg-surface-card rounded-2xl shadow-sm border border-border-subtle overflow-hidden p-space-md">
        <form action="{{ route('absensi.store') }}" method="POST">
            @csrf
            <input type="hidden" name="session_id" value="{{ $session->id }}">
            
            <div class="overflow-x-auto mb-space-md">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-canvas-bg/50 border-b border-border-subtle">
                            <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold w-12">No</th>
                            <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Nama Siswa</th>
                            <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">NIS</th>
                            <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold text-center w-64">Status Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-subtle text-sm">
                        @forelse($session->schoolClass->students as $index => $student)
                        <tr class="hover:bg-canvas-bg/30 transition-colors">
                            <td class="py-3 px-space-md text-text-muted">{{ $index + 1 }}</td>
                            <td class="py-3 px-space-md font-semibold text-on-surface">{{ $student->name }}</td>
                            <td class="py-3 px-space-md text-text-muted">{{ $student->studentData->nis ?? '-' }}</td>
                            <td class="py-3 px-space-md">
                                @php
                                    $currentStatus = $attendances[$student->id]->status ?? 'Hadir';
                                @endphp
                                <div class="flex items-center justify-center gap-2">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="attendance[{{ $student->id }}]" value="Hadir" class="peer sr-only" {{ $currentStatus === 'Hadir' ? 'checked' : '' }}>
                                        <div class="px-3 py-1.5 rounded-lg text-xs font-semibold border peer-checked:bg-success peer-checked:text-white peer-checked:border-success border-border-subtle text-text-muted hover:bg-canvas-bg transition-colors">
                                            Hadir
                                        </div>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="attendance[{{ $student->id }}]" value="Sakit" class="peer sr-only" {{ $currentStatus === 'Sakit' ? 'checked' : '' }}>
                                        <div class="px-3 py-1.5 rounded-lg text-xs font-semibold border peer-checked:bg-warning peer-checked:text-white peer-checked:border-warning border-border-subtle text-text-muted hover:bg-canvas-bg transition-colors">
                                            Sakit
                                        </div>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="attendance[{{ $student->id }}]" value="Izin" class="peer sr-only" {{ $currentStatus === 'Izin' ? 'checked' : '' }}>
                                        <div class="px-3 py-1.5 rounded-lg text-xs font-semibold border peer-checked:bg-primary peer-checked:text-white peer-checked:border-primary border-border-subtle text-text-muted hover:bg-canvas-bg transition-colors">
                                            Izin
                                        </div>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="attendance[{{ $student->id }}]" value="Alpa" class="peer sr-only" {{ $currentStatus === 'Alpa' ? 'checked' : '' }}>
                                        <div class="px-3 py-1.5 rounded-lg text-xs font-semibold border peer-checked:bg-danger peer-checked:text-white peer-checked:border-danger border-border-subtle text-text-muted hover:bg-canvas-bg transition-colors">
                                            Alpa
                                        </div>
                                    </label>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-text-muted">Belum ada siswa di kelas ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end gap-3 pt-space-md border-t border-border-subtle">
                <a href="{{ route('pertemuan.show', $session->id) }}" class="px-4 py-2 rounded-lg text-sm font-semibold text-text-muted hover:bg-canvas-bg transition-colors">Batal</a>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-full text-sm font-semibold hover:bg-primary/90 transition-colors shadow-sm">
                    Simpan Absensi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

