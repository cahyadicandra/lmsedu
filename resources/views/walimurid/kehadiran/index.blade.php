@extends('layouts.app')

@section('content')
<div class="flex flex-col w-full gap-space-lg pb-space-3xl ">

    {{-- Breadcrumb & Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-sm mb-4">
        <div>
            <h1 class="font-headline-lg text-headline-lg font-bold text-on-surface">Kehadiran Anak</h1>
            <p class="font-body-md text-text-muted mt-1">Pantau kehadiran <span class="font-bold text-primary">{{ $student->name ?? 'Anak' }}</span> selama mengikuti pembelajaran.</p>
        </div>
    </div>

    @if(!$student)
    <div class="bg-surface-card p-10 rounded-2xl border border-border-subtle shadow-sm flex flex-col items-center justify-center text-center">
        <span class="material-symbols-outlined text-6xl text-text-muted mb-4 opacity-30">person_off</span>
        <h3 class="text-xl font-bold text-on-surface mb-2">Belum ada anak yang dipantau</h3>
        <p class="text-text-muted">Akun Anda belum dikaitkan dengan data siswa mana pun.</p>
    </div>
    @else
    
    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-space-sm">
        <div class="bg-surface-card p-4 rounded-xl border border-border-subtle shadow-sm text-center">
            <p class="text-xs font-semibold text-text-muted mb-1">Total Pertemuan</p>
            <p class="text-2xl font-black text-on-surface">{{ $totalMeetings }}</p>
        </div>
        <div class="bg-surface-card p-4 rounded-xl border border-border-subtle shadow-sm text-center">
            <p class="text-xs font-semibold text-text-muted mb-1">Hadir</p>
            <p class="text-2xl font-black text-blue-600">{{ $hadir }}</p>
        </div>
        <div class="bg-surface-card p-4 rounded-xl border border-border-subtle shadow-sm text-center">
            <p class="text-xs font-semibold text-text-muted mb-1">Izin</p>
            <p class="text-2xl font-black text-warning">{{ $izin }}</p>
        </div>
        <div class="bg-surface-card p-4 rounded-xl border border-border-subtle shadow-sm text-center">
            <p class="text-xs font-semibold text-text-muted mb-1">Sakit</p>
            <p class="text-2xl font-black text-orange-500">{{ $sakit }}</p>
        </div>
        <div class="bg-surface-card p-4 rounded-xl border border-border-subtle shadow-sm text-center">
            <p class="text-xs font-semibold text-text-muted mb-1">Alpa</p>
            <p class="text-2xl font-black text-danger">{{ $alpa }}</p>
        </div>
    </div>

    {{-- Filter & Table Card --}}
    <div class="bg-surface-card rounded-2xl border border-border-subtle shadow-sm overflow-hidden flex flex-col">
        
        {{-- Toolbar --}}
        <div class="p-space-lg border-b border-border-subtle bg-surface-container-low flex flex-col md:flex-row gap-4 justify-between items-center">
            <form action="{{ route('walimurid.kehadiran.index') }}" method="GET" class="w-full flex flex-col sm:flex-row gap-3">
                <select name="subject_id" class="input-standard flex-1 sm:max-w-xs" onchange="this.form.submit()">
                    <option value="">Semua Mata Pelajaran</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}
                        </option>
                    @endforeach
                </select>
                
                <select name="status" class="input-standard flex-1 sm:max-w-[180px]" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="Hadir" {{ request('status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="Izin" {{ request('status') == 'Izin' ? 'selected' : '' }}>Izin</option>
                    <option value="Sakit" {{ request('status') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                    <option value="Alpa" {{ request('status') == 'Alpa' ? 'selected' : '' }}>Alpa</option>
                </select>
                
                @if(request('subject_id') || request('status'))
                <a href="{{ route('walimurid.kehadiran.index') }}" class="btn-secondary py-2 px-4 rounded-xl text-sm font-semibold flex items-center justify-center">
                    Reset Filter
                </a>
                @endif
            </form>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low/50">
                        <th class="py-4 px-6 font-semibold text-sm text-text-muted border-b border-border-subtle w-1/4">Tanggal</th>
                        <th class="py-4 px-6 font-semibold text-sm text-text-muted border-b border-border-subtle w-1/3">Mata Pelajaran & Guru</th>
                        <th class="py-4 px-6 font-semibold text-sm text-text-muted border-b border-border-subtle w-1/6">Pertemuan</th>
                        <th class="py-4 px-6 font-semibold text-sm text-text-muted border-b border-border-subtle w-1/6">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $attendance)
                    <tr class="border-b border-border-subtle last:border-0 hover:bg-surface-container-lowest transition-colors">
                        <td class="py-4 px-6">
                            <span class="font-semibold text-on-surface">{{ $attendance->created_at->format('d M Y') }}</span>
                            <span class="text-xs text-text-muted block mt-0.5">{{ $attendance->created_at->format('H:i') }} WIB</span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="font-bold text-primary block">{{ $attendance->learningSession->subject->name ?? '-' }}</span>
                            <span class="text-sm text-text-muted block mt-0.5">Guru: {{ $attendance->learningSession->subject->teacher->name ?? '-' }}</span>
                        </td>
                        <td class="py-4 px-6 text-sm text-on-surface">
                            Ke-{{ $attendance->learningSession->meeting_number ?? '-' }}
                        </td>
                        <td class="py-4 px-6">
                            @php
                                $badgeClass = match($attendance->status) {
                                    'Hadir' => 'bg-success/10 text-success border-success/20',
                                    'Izin' => 'bg-warning/10 text-warning border-warning/20',
                                    'Sakit' => 'bg-orange-500/10 text-orange-600 border-orange-500/20',
                                    'Alpa' => 'bg-danger/10 text-danger border-danger/20',
                                    default => 'bg-gray-100 text-gray-700 border-gray-200'
                                };
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $badgeClass }}">
                                {{ $attendance->status }}
                            </span>
                            @if($attendance->notes)
                            <p class="text-xs text-text-muted mt-1 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">comment</span>
                                <span class="line-clamp-1" title="{{ $attendance->notes }}">{{ $attendance->notes }}</span>
                            </p>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-12 px-6 text-center">
                            <div class="flex flex-col items-center justify-center text-text-muted">
                                <span class="material-symbols-outlined text-6xl mb-4 opacity-30">fact_check</span>
                                <h3 class="text-lg font-bold text-on-surface">Belum ada data kehadiran</h3>
                                <p class="text-sm mt-1">Data absensi anak Anda belum tersedia untuk periode ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
