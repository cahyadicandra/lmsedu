@extends('layouts.app')

@section('content')
<div class="flex flex-col w-full gap-space-lg pb-space-3xl ">

    {{-- Breadcrumb & Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-sm mb-4">
        <div>
            <h1 class="font-headline-lg text-headline-lg font-bold text-on-surface">Nilai Akademik</h1>
            <p class="font-body-md text-text-muted mt-1">Pantau hasil belajar dan perkembangan <span class="font-bold text-primary">{{ $student->name ?? 'Anak' }}</span>.</p>
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
    <div class="grid grid-cols-2 md:grid-cols-4 gap-space-sm">
        <div class="bg-surface-card p-4 rounded-xl border border-border-subtle shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-2xl">functions</span>
            </div>
            <div>
                <p class="text-xs font-semibold text-text-muted mb-0.5">Rata-rata Nilai</p>
                <p class="text-2xl font-black text-on-surface">{{ $averageGrade }}</p>
            </div>
        </div>
        <div class="bg-surface-card p-4 rounded-xl border border-border-subtle shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-success/10 text-success rounded-lg flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-2xl">trending_up</span>
            </div>
            <div>
                <p class="text-xs font-semibold text-text-muted mb-0.5">Nilai Tertinggi</p>
                <p class="text-2xl font-black text-on-surface">{{ $highestGrade }}</p>
            </div>
        </div>
        <div class="bg-surface-card p-4 rounded-xl border border-border-subtle shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-danger/10 text-danger rounded-lg flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-2xl">trending_down</span>
            </div>
            <div>
                <p class="text-xs font-semibold text-text-muted mb-0.5">Nilai Terendah</p>
                <p class="text-2xl font-black text-on-surface">{{ $lowestGrade }}</p>
            </div>
        </div>
        <div class="bg-surface-card p-4 rounded-xl border border-border-subtle shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-gray-100 text-gray-500 rounded-lg flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-2xl">assessment</span>
            </div>
            <div>
                <p class="text-xs font-semibold text-text-muted mb-0.5">Total Penilaian</p>
                <p class="text-2xl font-black text-on-surface">{{ $totalGrades }}</p>
            </div>
        </div>
    </div>

    {{-- Filter & Table Card --}}
    <div class="bg-surface-card rounded-2xl border border-border-subtle shadow-sm overflow-hidden flex flex-col">
        
        {{-- Toolbar --}}
        <div class="p-space-lg border-b border-border-subtle bg-surface-container-low flex flex-col md:flex-row gap-4 justify-between items-center">
            <form action="{{ route('walimurid.nilai.index') }}" method="GET" class="w-full flex flex-col sm:flex-row gap-3">
                <select name="subject_id" class="input-standard flex-1 sm:max-w-xs" onchange="this.form.submit()">
                    <option value="">Semua Mata Pelajaran</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}
                        </option>
                    @endforeach
                </select>
                
                <select name="type" class="input-standard flex-1 sm:max-w-[180px]" onchange="this.form.submit()">
                    <option value="">Semua Jenis</option>
                    @foreach($types as $type)
                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
                
                @if(request('subject_id') || request('type'))
                <a href="{{ route('walimurid.nilai.index') }}" class="btn-secondary py-2 px-4 rounded-xl text-sm font-semibold flex items-center justify-center">
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
                        <th class="py-4 px-6 font-semibold text-sm text-text-muted border-b border-border-subtle w-1/4">Mata Pelajaran & Guru</th>
                        <th class="py-4 px-6 font-semibold text-sm text-text-muted border-b border-border-subtle w-1/5">Jenis & Judul</th>
                        <th class="py-4 px-6 font-semibold text-sm text-text-muted border-b border-border-subtle w-1/6">Nilai</th>
                        <th class="py-4 px-6 font-semibold text-sm text-text-muted border-b border-border-subtle w-1/6">Tanggal</th>
                        <th class="py-4 px-6 font-semibold text-sm text-text-muted border-b border-border-subtle w-1/6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($grades as $grade)
                    <tr class="border-b border-border-subtle last:border-0 hover:bg-surface-container-lowest transition-colors" x-data="{ showDetail: false }">
                        <td class="py-4 px-6">
                            <span class="font-bold text-primary block">{{ $grade->subject->name ?? '-' }}</span>
                            <span class="text-sm text-text-muted block mt-0.5">Guru: {{ $grade->subject->teacher->name ?? '-' }}</span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-block px-2 py-0.5 bg-gray-100 border border-gray-200 rounded text-xs font-semibold text-gray-700 mb-1">{{ $grade->type }}</span>
                            <span class="block text-sm text-on-surface font-medium">{{ $grade->type }}</span>
                        </td>
                        <td class="py-4 px-6">
                            @php
                                $badgeClass = $grade->score >= 85 ? 'bg-success/10 text-success border-success/20' : 
                                             ($grade->score >= 70 ? 'bg-primary/10 text-primary border-primary/20' : 
                                             'bg-danger/10 text-danger border-danger/20');
                            @endphp
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-lg border {{ $badgeClass }} font-black text-lg">
                                {{ $grade->score }}
                            </div>
                        </td>
                        <td class="py-4 px-6 text-sm text-on-surface">
                            {{ $grade->created_at->format('d M Y') }}
                        </td>
                        <td class="py-4 px-6 text-right">
                            <button @click="showDetail = true" class="btn-secondary py-1.5 px-3 rounded-full text-sm flex items-center gap-1.5 ml-auto">
                                <span class="material-symbols-outlined text-[16px]">visibility</span> Detail
                            </button>

                            {{-- Modal Detail --}}
                            <div x-show="showDetail" x-cloak class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-black/50 backdrop-blur-sm">
                                <div @click.away="showDetail = false" class="relative w-full max-w-md p-6 bg-surface-card rounded-2xl shadow-xl text-left"
                                     x-transition:enter="ease-out duration-300"
                                     x-transition:enter-start="opacity-0 translate-y-4"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     x-transition:leave="ease-in duration-200"
                                     x-transition:leave-start="opacity-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 translate-y-4">
                                     
                                    <div class="flex items-center justify-between border-b border-border-subtle pb-4 mb-4">
                                        <h3 class="text-xl font-bold text-on-surface">Detail Nilai</h3>
                                        <button @click="showDetail = false" class="text-text-muted hover:text-on-surface transition-colors">
                                            <span class="material-symbols-outlined">close</span>
                                        </button>
                                    </div>
                                    
                                    <div class="space-y-4">
                                        <div class="flex flex-col gap-1 text-center py-4">
                                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl border mx-auto {{ $badgeClass }} font-black text-4xl shadow-sm">
                                                {{ $grade->score }}
                                            </div>
                                            <h4 class="font-bold text-lg mt-2 text-on-surface">{{ $grade->type }}</h4>
                                            <p class="text-sm text-text-muted">{{ $grade->type }} • {{ $grade->subject->name ?? '-' }}</p>
                                        </div>
                                        
                                        <div class="grid grid-cols-2 gap-4 bg-surface-container-lowest p-4 rounded-xl border border-border-subtle">
                                            <div>
                                                <span class="text-xs text-text-muted block mb-0.5">Nama Siswa</span>
                                                <span class="font-semibold text-sm text-on-surface">{{ $student->name }}</span>
                                            </div>
                                            <div>
                                                <span class="text-xs text-text-muted block mb-0.5">Guru Penilai</span>
                                                <span class="font-semibold text-sm text-on-surface">{{ $grade->subject->teacher->name ?? '-' }}</span>
                                            </div>
                                            <div>
                                                <span class="text-xs text-text-muted block mb-0.5">Tanggal Penilaian</span>
                                                <span class="font-semibold text-sm text-on-surface">{{ $grade->created_at->format('d M Y') }}</span>
                                            </div>
                                        </div>
                                        
                                        @if($grade->notes)
                                        <div>
                                            <span class="text-xs font-semibold text-text-muted block mb-1">Catatan dari Guru:</span>
                                            <div class="p-3 bg-blue-50 text-blue-900 border border-blue-100 rounded-lg text-sm italic">
                                                "{{ $grade->notes }}"
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 px-6 text-center">
                            <div class="flex flex-col items-center justify-center text-text-muted">
                                <span class="material-symbols-outlined text-6xl mb-4 opacity-30">history_edu</span>
                                <h3 class="text-lg font-bold text-on-surface">Belum ada nilai yang tersedia</h3>
                                <p class="text-sm mt-1">Siswa belum memiliki riwayat penilaian untuk kriteria ini.</p>
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

