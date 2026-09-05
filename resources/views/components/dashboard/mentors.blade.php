@props(['studentDistribution' => []])
<div class="bg-surface-card rounded-[20px] p-space-lg shadow-sm">
    <div class="flex items-center justify-between mb-space-md">
        <div class="flex items-center gap-space-xs">
            <span class="material-symbols-outlined text-primary-container text-xl">bar_chart</span>
            <div>
                <h2 class="font-title-sm text-title-sm text-on-surface font-bold">Statistik Distribusi Peserta Didik per Jenjang</h2>
                <p class="font-caption text-caption text-text-muted">Informasi jumlah siswa aktif yang tersebar berdasarkan jenjang pendidikan.</p>
            </div>
        </div>
        <button class="font-label-sm text-label-sm font-semibold text-primary hover:text-primary-container transition-colors">
            Lihat Laporan Lengkap →
        </button>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-7 gap-space-sm">
        <!-- SD -->
        <div class="flex flex-col items-center justify-center p-space-sm rounded-xl bg-canvas-bg/60 border border-border-subtle hover:border-primary/30 hover:bg-canvas-bg transition-colors">
            <span class="font-title-sm text-title-sm font-bold text-on-surface">SD</span>
            <span class="font-display-metric text-2xl font-bold text-primary mt-1">{{ $studentDistribution['SD'] ?? 0 }}</span>
            <span class="font-caption text-[10px] text-text-muted mt-1 uppercase">Siswa Aktif</span>
        </div>
        <!-- MI -->
        <div class="flex flex-col items-center justify-center p-space-sm rounded-xl bg-canvas-bg/60 border border-border-subtle hover:border-primary/30 hover:bg-canvas-bg transition-colors">
            <span class="font-title-sm text-title-sm font-bold text-on-surface">MI</span>
            <span class="font-display-metric text-2xl font-bold text-primary mt-1">{{ $studentDistribution['MI'] ?? 0 }}</span>
            <span class="font-caption text-[10px] text-text-muted mt-1 uppercase">Siswa Aktif</span>
        </div>
        <!-- SMP -->
        <div class="flex flex-col items-center justify-center p-space-sm rounded-xl bg-canvas-bg/60 border border-border-subtle hover:border-primary/30 hover:bg-canvas-bg transition-colors">
            <span class="font-title-sm text-title-sm font-bold text-on-surface">SMP</span>
            <span class="font-display-metric text-2xl font-bold text-primary mt-1">{{ $studentDistribution['SMP'] ?? 0 }}</span>
            <span class="font-caption text-[10px] text-text-muted mt-1 uppercase">Siswa Aktif</span>
        </div>
        <!-- MTS -->
        <div class="flex flex-col items-center justify-center p-space-sm rounded-xl bg-canvas-bg/60 border border-border-subtle hover:border-primary/30 hover:bg-canvas-bg transition-colors">
            <span class="font-title-sm text-title-sm font-bold text-on-surface">MTS</span>
            <span class="font-display-metric text-2xl font-bold text-primary mt-1">{{ $studentDistribution['MTS'] ?? 0 }}</span>
            <span class="font-caption text-[10px] text-text-muted mt-1 uppercase">Siswa Aktif</span>
        </div>
        <!-- SMA -->
        <div class="flex flex-col items-center justify-center p-space-sm rounded-xl bg-canvas-bg/60 border border-border-subtle hover:border-primary/30 hover:bg-canvas-bg transition-colors">
            <span class="font-title-sm text-title-sm font-bold text-on-surface">SMA</span>
            <span class="font-display-metric text-2xl font-bold text-primary mt-1">{{ $studentDistribution['SMA'] ?? 0 }}</span>
            <span class="font-caption text-[10px] text-text-muted mt-1 uppercase">Siswa Aktif</span>
        </div>
        <!-- MA -->
        <div class="flex flex-col items-center justify-center p-space-sm rounded-xl bg-canvas-bg/60 border border-border-subtle hover:border-primary/30 hover:bg-canvas-bg transition-colors">
            <span class="font-title-sm text-title-sm font-bold text-on-surface">MA</span>
            <span class="font-display-metric text-2xl font-bold text-primary mt-1">{{ $studentDistribution['MA'] ?? 0 }}</span>
            <span class="font-caption text-[10px] text-text-muted mt-1 uppercase">Siswa Aktif</span>
        </div>
        <!-- SMK -->
        <div class="flex flex-col items-center justify-center p-space-sm rounded-xl bg-canvas-bg/60 border border-border-subtle hover:border-primary/30 hover:bg-canvas-bg transition-colors">
            <span class="font-title-sm text-title-sm font-bold text-on-surface">SMK</span>
            <span class="font-display-metric text-2xl font-bold text-primary mt-1">{{ $studentDistribution['SMK'] ?? 0 }}</span>
            <span class="font-caption text-[10px] text-text-muted mt-1 uppercase">Siswa Aktif</span>
        </div>
    </div>
</div>