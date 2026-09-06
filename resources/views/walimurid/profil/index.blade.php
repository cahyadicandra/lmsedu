@extends('layouts.app')

@section('content')
<div class="flex flex-col w-full gap-space-lg pb-space-3xl ">

    {{-- Breadcrumb & Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-sm mb-4">
        <div>
            <h1 class="font-headline-lg text-headline-lg font-bold text-on-surface">Profil Anak</h1>
            <p class="font-body-md text-text-muted mt-1">Informasi data akademik anak yang sedang dipantau.</p>
        </div>
    </div>

    @if(!$student)
    <div class="bg-surface-card p-12 rounded-2xl border border-border-subtle shadow-sm flex flex-col items-center justify-center text-center">
        <span class="material-symbols-outlined text-6xl text-text-muted mb-4 opacity-30">person_off</span>
        <h3 class="text-xl font-bold text-on-surface mb-2">Belum ada anak yang dipantau</h3>
        <p class="text-text-muted max-w-md mx-auto">Silakan hubungi Admin Sekolah untuk menautkan akun anak Anda dengan akun Wali Murid ini.</p>
    </div>
    @else
    
    {{-- Main Profile Card --}}
    <div class="bg-surface-card rounded-3xl border border-border-subtle shadow-sm overflow-hidden relative">
        {{-- Background Cover & Profile Header (Blue Section) --}}
        <div class="w-full bg-blue-600 relative overflow-hidden text-white rounded-t-3xl border-b border-gray-100">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-20"></div>
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute -left-10 -top-10 w-40 h-40 bg-black/10 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 px-6 md:px-8 py-6 md:py-8 flex flex-col md:flex-row items-center md:items-start gap-5">
                {{-- Avatar --}}
                <div class="rounded-2xl border-4 border-white bg-white shadow-lg shrink-0 overflow-hidden flex items-center justify-center" style="width: 100px; height: 100px;">
                    @if($student->profile_photo)
                        <img src="{{ asset('storage/' . $student->profile_photo) }}" alt="Foto {{ $student->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center font-bold text-5xl uppercase" style="background-color: #eff6ff; color: #2563eb;">
                            {{ substr($student->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                
                {{-- Name & Email --}}
                <div class="flex-1 text-left w-full flex flex-col justify-center mt-2 md:mt-4">
                    <h2 class="text-2xl md:text-3xl font-black text-white flex items-center justify-start gap-2">
                        {{ $student->name }}
                        @if($student->status == 'Aktif')
                            <span class="material-symbols-outlined text-green-300 text-[24px]" title="Siswa Aktif">verified</span>
                        @endif
                    </h2>
                    <p class="text-blue-100 font-medium mt-1">{{ $student->email }}</p>
                </div>
            </div>
        </div>
        
        {{-- Profile Details (White Section) --}}
        <div class="px-6 md:px-8 py-5 bg-white relative">
            {{-- Tags --}}
            <div class="flex flex-row flex-wrap items-center gap-3">
                <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 border border-gray-200 rounded-lg text-sm font-semibold text-gray-700 shadow-sm whitespace-nowrap">
                    <span class="material-symbols-outlined text-[18px] text-gray-500">meeting_room</span>
                    {{ $student->schoolClass->name ?? 'Belum ada kelas' }}
                </span>
                <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 border border-gray-200 rounded-lg text-sm font-semibold text-gray-700 shadow-sm whitespace-nowrap">
                    <span class="material-symbols-outlined text-[18px] text-gray-500">badge</span>
                    NIS: {{ $student->batch ?? '-' }}
                </span>
                @if($student->status == 'Aktif')
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-green-50 text-green-700 border border-green-200 rounded-lg text-sm font-semibold shadow-sm whitespace-nowrap">
                        <span class="material-symbols-outlined text-[18px]">how_to_reg</span> Aktif
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-red-50 text-red-700 border border-red-200 rounded-lg text-sm font-semibold shadow-sm whitespace-nowrap">
                        <span class="material-symbols-outlined text-[18px]">person_off</span> Tidak Aktif
                    </span>
                @endif
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-space-lg mt-2">
        {{-- Quick Stats: Kehadiran --}}
        <div class="bg-surface-card p-6 rounded-2xl border border-border-subtle shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h3 class="font-bold text-lg text-on-surface">Kehadiran</h3>
                    <p class="text-sm text-text-muted">Total kehadiran anak</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-success/10 text-success flex items-center justify-center">
                    <span class="material-symbols-outlined text-[24px]">fact_check</span>
                </div>
            </div>
            
            <div class="flex justify-between items-end">
                <div>
                    @php
                        $totalMeetings = $student->attendances->count();
                        $hadir = $student->attendances->where('status', 'Hadir')->count();
                        $percent = $totalMeetings > 0 ? round(($hadir / $totalMeetings) * 100) : 0;
                    @endphp
                    <div class="text-3xl font-black text-on-surface">{{ $percent }}<span class="text-xl text-text-muted font-bold">%</span></div>
                    <p class="text-sm font-medium text-success mt-1">{{ $hadir }} dari {{ $totalMeetings }} Pertemuan</p>
                </div>
                <a href="{{ route('walimurid.kehadiran.index') }}" class="btn-secondary px-4 py-2 rounded-lg text-sm font-semibold">Lihat Detail</a>
            </div>
        </div>
        
        {{-- Quick Stats: Nilai --}}
        <div class="bg-surface-card p-6 rounded-2xl border border-border-subtle shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h3 class="font-bold text-lg text-on-surface">Nilai Akademik</h3>
                    <p class="text-sm text-text-muted">Rata-rata nilai keseluruhan</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-[24px]">grade</span>
                </div>
            </div>
            
            <div class="flex justify-between items-end">
                <div>
                    @php
                        $avg = $student->grades->count() > 0 ? round($student->grades->avg('score'), 1) : 0;
                    @endphp
                    <div class="text-3xl font-black text-on-surface">{{ $avg }}</div>
                    <p class="text-sm font-medium text-primary mt-1">Total {{ $student->grades->count() }} Penilaian</p>
                </div>
                <a href="{{ route('walimurid.nilai.index') }}" class="btn-secondary px-4 py-2 rounded-lg text-sm font-semibold">Lihat Detail</a>
            </div>
        </div>
    </div>
    
    @endif

</div>
@endsection
