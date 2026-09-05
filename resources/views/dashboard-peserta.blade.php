@extends('layouts.app')

@section('content')
<div class="flex flex-col w-full gap-space-lg pb-space-3xl">
    <!-- Top Breadcrumb & Status Bar -->
    <div class="flex flex-wrap items-center justify-between gap-space-sm">
        <div class="flex items-center gap-space-xs">
            <span class="font-label-md text-label-md font-semibold text-primary">Dashboard</span>
        </div>
        <div class="flex items-center gap-space-sm" 
             x-data="{ time: new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit', second:'2-digit'}), date: new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }" 
             x-init="setInterval(() => { let d = new Date(); time = d.toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit', second:'2-digit'}); date = d.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }, 1000)">
            <span class="inline-flex items-center gap-1.5 px-space-sm py-1 rounded-full bg-surface-container-high text-primary font-label-sm text-label-sm font-semibold">
                <span class="material-symbols-outlined text-sm">calendar_month</span>
                <span x-text="date"></span>
            </span>
            <div class="flex items-center gap-1.5 bg-surface-card px-space-sm py-1 rounded-full shadow-sm text-primary">
                <span class="material-symbols-outlined text-sm">schedule</span>
                <span class="font-label-sm text-label-sm font-bold text-on-surface" x-text="time"></span>
            </div>
        </div>
    </div>

    <!-- Primary Workspace (Full Width) -->
    <div class="flex flex-col gap-space-lg w-full">
        <!-- 1. Welcome Hero Banner Card -->
        <x-dashboard.welcome-banner :user="auth()->user()" />

        <!-- 2. Performance Section -->
        <x-dashboard.performance-section 
            :totalSchools="$totalSchools ?? 0"
            :totalUsers="$totalUsers ?? 0"
            :totalSiswa="$totalSiswa ?? 0"
            :totalGuru="$totalGuru ?? 0"
            :totalAdmin="$totalAdmin ?? 0"
            :totalWali="$totalWali ?? 0"
        />

        <!-- 3. Tutor & Mentor Pembimbing -->
        <x-dashboard.mentors :studentDistribution="$studentDistribution ?? []" />
    </div>

</div>
@endsection
