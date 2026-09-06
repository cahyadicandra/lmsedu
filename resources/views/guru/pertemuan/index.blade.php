@extends('layouts.app')

@section('content')
<div x-data="{
    showModal: false, showViewModal: false, isEdit: false,
    form: { id:null, subject_id:'', school_class_id:'', meeting_number:'', title:'', date:'', time:'', description:'', status:'Belum Dimulai' },
    viewData: {},
    openAdd() { this.isEdit=false; this.form={id:null,subject_id:'',school_class_id:'',meeting_number:'',title:'',date:'',time:'',description:'',status:'Belum Dimulai'}; this.showModal=true; },
    openEdit(r) { this.isEdit=true; this.form={...r, subject_id:r.subject_id||'', school_class_id:r.school_class_id||''}; this.showModal=true; },
    openView(r) { window.location.href = '{{ url('/pertemuan') }}/' + r.id; }
}">

    <div class="flex items-center justify-between mb-space-lg">
        <div>
            <h1 class="font-headline-lg text-headline-lg font-bold text-on-surface">Pertemuan Pembelajaran</h1>
            <p class="font-body-md text-text-muted mt-1">Kelola jadwal dan data pertemuan mengajar Anda.</p>
        </div>
        <button @click="openAdd" class="bg-primary hover:bg-primary/90 text-white px-space-md py-2.5 rounded-full font-semibold flex items-center gap-2 transition-colors shadow-sm">
            <span class="material-symbols-outlined text-sm">add</span>Tambah Pertemuan
        </button>
    </div>

    @if(session('success'))
    <div class="bg-success/10 text-success border border-success/20 px-4 py-3 rounded-xl mb-space-md flex items-center gap-2">
        <span class="material-symbols-outlined">check_circle</span>{{ session('success') }}
    </div>
    @endif

    {{-- Filter Form --}}
    <div class="bg-surface-card rounded-2xl p-space-md border border-border-subtle shadow-sm mb-space-md flex flex-wrap gap-4 items-end">
        <form action="{{ route('pertemuan.index') }}" method="GET" class="flex flex-wrap gap-4 items-end w-full">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-semibold text-text-muted mb-1 uppercase tracking-wider">Pencarian Judul</label>
                <div class="relative flex items-center">
                    <span class="material-symbols-outlined absolute left-3 text-text-muted text-[18px]">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari topik..." class="w-full pl-9 pr-3 py-2 bg-canvas-bg/50 border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                </div>
            </div>
            <div class="flex-1 min-w-[150px]">
                <label class="block text-xs font-semibold text-text-muted mb-1 uppercase tracking-wider">Mata Pelajaran</label>
                <select name="subject_id" class="w-full px-3 py-2 bg-canvas-bg/50 border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                    <option value="">Semua Mapel</option>
                    @foreach($subjects as $sub)
                        <option value="{{ $sub->id }}" {{ request('subject_id') == $sub->id ? 'selected' : '' }}>{{ $sub->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-[150px]">
                <label class="block text-xs font-semibold text-text-muted mb-1 uppercase tracking-wider">Kelas</label>
                <select name="school_class_id" class="w-full px-3 py-2 bg-canvas-bg/50 border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                    <option value="">Semua Kelas</option>
                    @foreach($classes as $c)
                        <option value="{{ $c->id }}" {{ request('school_class_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="px-4 py-2 bg-surface-variant text-text-muted hover:bg-border-subtle rounded-full text-sm font-semibold transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">filter_list</span> Filter
                </button>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-space-md">
        @php
            // Using explicit hex colors to bypass Tailwind JIT compilation limitations
            $themes = [
                ['color' => '#3b82f6', 'bg' => '#eff6ff', 'border' => '#bfdbfe'], // blue
                ['color' => '#10b981', 'bg' => '#ecfdf5', 'border' => '#a7f3d0'], // emerald
                ['color' => '#8b5cf6', 'bg' => '#f5f3ff', 'border' => '#ddd6fe'], // purple
                ['color' => '#ec4899', 'bg' => '#fdf2f8', 'border' => '#fbcfe8'], // pink
                ['color' => '#f97316', 'bg' => '#fff7ed', 'border' => '#fed7aa'], // orange
                ['color' => '#14b8a6', 'bg' => '#f0fdfa', 'border' => '#99f6e4'], // teal
            ];
        @endphp
        
        @forelse($sessions as $s)
        @php
            $theme = $themes[($s->schoolClass->id ?? 0) % count($themes)];
        @endphp
        <div class="bg-surface-card rounded-2xl p-space-md shadow-sm hover:shadow-md transition-all flex flex-col gap-4 relative hover:-translate-y-1 duration-300"
             style="border: 1px solid var(--color-border-subtle, #e5e7eb); border-bottom: 4px solid {{ $theme['color'] }};">
            <div class="flex items-start justify-between">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg shadow-sm mb-3 transition-colors"
                         style="background-color: {{ $theme['bg'] }}; border: 1px solid {{ $theme['border'] }}; color: {{ $theme['color'] }};">
                        <span class="material-symbols-outlined text-[14px]">door_open</span>
                        <span class="font-bold text-xs">{{ $s->schoolClass->name ?? '-' }}</span>
                    </div>
                    <h3 class="font-bold text-on-surface text-lg line-clamp-1" title="{{ $s->title }}">{{ $s->title }}</h3>
                    <p class="text-sm text-text-muted mt-1 font-medium">{{ $s->subject->name ?? '-' }} • <span class="text-primary font-bold">Ke-{{ $s->meeting_number }}</span></p>
                </div>
                
                {{-- Status Badge --}}
                @if($s->status === 'Berlangsung')
                    <span class="inline-flex items-center gap-1 bg-warning/10 text-warning px-2 py-1 rounded-md text-xs font-bold"><span class="w-1.5 h-1.5 rounded-full bg-warning animate-pulse"></span> Berlangsung</span>
                @elseif($s->status === 'Selesai')
                    <span class="inline-flex items-center gap-1 bg-success/10 text-success px-2 py-1 rounded-md text-xs font-bold"><span class="w-1.5 h-1.5 rounded-full bg-success"></span> Selesai</span>
                @else
                    <span class="inline-flex items-center gap-1 bg-surface-container-highest text-text-muted px-2 py-1 rounded-md text-xs font-bold"><span class="w-1.5 h-1.5 rounded-full bg-border-subtle"></span> Belum Dimulai</span>
                @endif
            </div>

            <div class="flex items-center gap-2 text-sm text-text-muted bg-canvas-bg/50 p-2.5 rounded-xl border border-border-subtle/50">
                <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                <span class="font-medium">{{ date('d M Y', strtotime($s->date)) }}</span>
                <span class="mx-1 text-border-subtle">|</span>
                <span class="material-symbols-outlined text-[16px]">schedule</span>
                <span class="font-medium">{{ $s->time ? date('H:i', strtotime($s->time)) : '-' }}</span>
            </div>

            <div class="pt-4 border-t border-border-subtle mt-auto flex items-center justify-between">
                <a href="{{ route('pertemuan.show', $s->id) }}" class="text-sm font-bold text-primary hover:text-primary/80 transition-colors flex items-center gap-1">
                    Detail Sesi <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
                
                <div class="flex items-center gap-1">
                    <button @click="openEdit({{ json_encode($s) }})" class="p-1.5 text-text-muted hover:text-primary hover:bg-primary/10 rounded-full transition-colors" title="Edit">
                        <span class="material-symbols-outlined text-sm">edit</span>
                    </button>
                    <form action="{{ route('pertemuan.destroy', $s->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pertemuan ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-1.5 text-text-muted hover:text-danger hover:bg-danger/10 rounded-full transition-colors" title="Hapus">
                            <span class="material-symbols-outlined text-sm">delete</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 flex flex-col items-center justify-center text-center bg-surface-card rounded-2xl border border-border-subtle border-dashed">
            <span class="material-symbols-outlined text-6xl text-border-subtle mb-4">calendar_month</span>
            <p class="text-lg font-bold text-on-surface">Belum ada data pertemuan.</p>
            <p class="text-text-muted text-sm mt-1">Buat pertemuan baru untuk memulai kelas Anda.</p>
        </div>
        @endforelse
    </div>
    
    @if($sessions->hasPages())
    <div class="mt-space-md">
        {{ $sessions->links() }}
    </div>
    @endif

    {{-- Modal Form Tambah/Edit --}}
    <div x-show="showModal" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center bg-on-surface/40 backdrop-blur-sm" x-transition.opacity style="display:none">
        <div class="bg-surface-card w-full max-w-md rounded-2xl shadow-xl overflow-hidden" @click.away="showModal=false">
            <div class="px-space-md py-4 border-b border-border-subtle flex items-center justify-between bg-canvas-bg/30">
                <h3 class="font-headline-md font-bold text-on-surface" x-text="isEdit ? 'Edit Pertemuan' : 'Tambah Pertemuan'"></h3>
                <button @click="showModal=false" class="text-text-muted hover:text-danger"><span class="material-symbols-outlined">close</span></button>
            </div>
            <form :action="isEdit ? '{{ url('pertemuan') }}/' + form.id : '{{ route('pertemuan.store') }}'" method="POST" class="p-space-md flex flex-col gap-4 max-h-[75vh] overflow-y-auto">
                @csrf
                <template x-if="isEdit"><input type="hidden" name="_method" value="PUT"></template>
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2 lg:col-span-1">
                        <label class="block text-sm font-semibold text-on-surface mb-1">Mata Pelajaran <span class="text-danger">*</span></label>
                        <select name="subject_id" x-model="form.subject_id" required class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                            <option value="">-- Pilih --</option>
                            @foreach($subjects as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-2 lg:col-span-1">
                        <label class="block text-sm font-semibold text-on-surface mb-1">Kelas <span class="text-danger">*</span></label>
                        <select name="school_class_id" x-model="form.school_class_id" required class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                            <option value="">-- Pilih --</option>
                            @foreach($classes as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-on-surface mb-1">Pertemuan Ke- <span class="text-danger">*</span></label>
                        <input type="number" min="1" name="meeting_number" x-model="form.meeting_number" required class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-on-surface mb-1">Status</label>
                        <select name="status" x-model="form.status" class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                            <option value="Belum Dimulai">Belum Dimulai</option>
                            <option value="Berlangsung">Berlangsung</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-semibold text-on-surface mb-1">Topik / Judul Pertemuan <span class="text-danger">*</span></label>
                        <input type="text" name="title" x-model="form.title" required class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-on-surface mb-1">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="date" x-model="form.date" required class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-on-surface mb-1">Waktu Mulai <span class="text-danger">*</span></label>
                        <input type="time" name="time" x-model="form.time" required class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-semibold text-on-surface mb-1">Deskripsi</label>
                        <textarea name="description" x-model="form.description" rows="2" class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none"></textarea>
                    </div>
                </div>
                <div class="pt-space-md border-t border-border-subtle flex justify-end gap-2">
                    <button type="button" @click="showModal=false" class="px-4 py-2 rounded-full text-sm font-semibold text-text-muted hover:bg-canvas-bg transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-full text-sm font-semibold bg-primary text-white hover:bg-primary/90 shadow-sm" x-text="isEdit ? 'Simpan Perubahan' : 'Simpan Data'"></button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

