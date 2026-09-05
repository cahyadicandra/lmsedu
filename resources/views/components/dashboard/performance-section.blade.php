@props(['totalSchools' => 0, 'totalUsers' => 0, 'totalSiswa' => 0, 'totalGuru' => 0, 'totalAdmin' => 0, 'totalWali' => 0])
<div class="grid grid-cols-1 md:grid-cols-2 gap-space-lg">
    <!-- Card 1: Total Sekolah -->
    <div class="bg-surface-card rounded-[20px] p-space-lg shadow-sm flex items-center gap-space-md">
        <div class="w-16 h-16 rounded-2xl bg-primary-container/10 text-primary-container flex items-center justify-center flex-shrink-0">
            <span class="material-symbols-outlined text-3xl">account_balance</span>
        </div>
        <div>
            <p class="font-caption text-caption uppercase tracking-wider text-text-muted font-semibold mb-1">Total Mitra</p>
            <h2 class="font-display-metric text-display-metric font-bold text-on-surface leading-none">{{ number_format($totalSchools, 0, ',', '.') }}</h2>
            <p class="font-caption text-caption text-success font-medium mt-1">Sekolah Aktif Terdaftar</p>
        </div>
    </div>

    <!-- Card 2: Total Pengguna -->
    <div class="bg-surface-card rounded-[20px] p-space-lg shadow-sm flex items-center gap-space-md">
        <div class="w-16 h-16 rounded-2xl bg-secondary-container/20 text-secondary flex items-center justify-center flex-shrink-0">
            <span class="material-symbols-outlined text-3xl">groups</span>
        </div>
        <div>
            <p class="font-caption text-caption uppercase tracking-wider text-text-muted font-semibold mb-1">Manajemen Pengguna</p>
            <h2 class="font-display-metric text-display-metric font-bold text-on-surface leading-none">{{ number_format($totalUsers, 0, ',', '.') }}</h2>
            <p class="font-caption text-caption text-text-muted mt-1"><span class="text-primary font-semibold">{{ number_format($totalSiswa, 0, ',', '.') }}</span> Siswa • <span class="text-secondary font-semibold">{{ number_format($totalGuru, 0, ',', '.') }}</span> Guru • <span class="text-warning font-semibold">{{ number_format($totalAdmin, 0, ',', '.') }}</span> Admin Sekolah • <span class="text-success font-semibold">{{ number_format($totalWali, 0, ',', '.') }}</span> Wali Murid</p>
        </div>
    </div>
</div>