@extends('layouts.app')

@section('content')
<div x-data="{
    showModal: false, showViewModal: false, isEdit: false,
    form: { id: null, name: '', semester: 'Ganjil', start_date: '', end_date: '', status: 'Nonaktif' },
    openAdd() { this.isEdit=false; this.form={id:null,name:'',semester:'Ganjil',start_date:'',end_date:'',status:'Nonaktif'}; this.showModal=true; },
    openEdit(r) { this.isEdit=true; this.form={...r}; this.showModal=true; },
    openView(r) { this.form={...r}; this.showViewModal=true; }
}">

    <div class="flex items-center justify-between mb-space-lg">
        <div>
            <h1 class="font-headline-lg text-headline-lg font-bold text-on-surface">Tahun Akademik</h1>
            <p class="font-body-md text-text-muted mt-1">Kelola tahun akademik dan semester aktif sekolah.</p>
        </div>
        <button @click="openAdd" class="bg-primary hover:bg-primary/90 text-white px-space-md py-2.5 rounded-lg font-semibold flex items-center gap-2 transition-colors shadow-sm">
            <span class="material-symbols-outlined text-sm">add</span>Tambah Tahun Akademik
        </button>
    </div>

    @if(session('success'))
    <div class="bg-success/10 text-success border border-success/20 px-4 py-3 rounded-xl mb-space-md flex items-center gap-2">
        <span class="material-symbols-outlined">check_circle</span>{{ session('success') }}
    </div>
    @endif

    <div class="bg-surface-card rounded-2xl shadow-sm border border-border-subtle overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-canvas-bg/50 border-b border-border-subtle">
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Tahun Akademik</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Semester</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Tanggal Mulai</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Tanggal Selesai</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Status</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-subtle text-sm">
                    @forelse($academicYears as $ay)
                    <tr class="hover:bg-canvas-bg/30 transition-colors">
                        <td class="py-3 px-space-md font-semibold text-on-surface">{{ $ay->name }}</td>
                        <td class="py-3 px-space-md text-text-muted">{{ $ay->semester }}</td>
                        <td class="py-3 px-space-md text-text-muted">{{ $ay->start_date ? \Carbon\Carbon::parse($ay->start_date)->format('d M Y') : '-' }}</td>
                        <td class="py-3 px-space-md text-text-muted">{{ $ay->end_date ? \Carbon\Carbon::parse($ay->end_date)->format('d M Y') : '-' }}</td>
                        <td class="py-3 px-space-md">
                            @if($ay->status === 'Aktif')
                                <span class="inline-flex items-center gap-1 text-success font-medium text-xs"><span class="w-1.5 h-1.5 rounded-full bg-success"></span>Aktif</span>
                            @else
                                <span class="inline-flex items-center gap-1 text-text-muted font-medium text-xs"><span class="w-1.5 h-1.5 rounded-full bg-text-muted"></span>Nonaktif</span>
                            @endif
                        </td>
                        <td class="py-3 px-space-md text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button @click="openView({{ json_encode($ay) }})" class="p-1.5 text-text-muted hover:text-success hover:bg-success/10 rounded-lg transition-colors" title="Lihat">
                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                </button>
                                <button @click="openEdit({{ json_encode($ay) }})" class="p-1.5 text-text-muted hover:text-primary hover:bg-primary/10 rounded-lg transition-colors" title="Edit">
                                    <span class="material-symbols-outlined text-sm">edit</span>
                                </button>
                                <form action="{{ route('tahun-akademik.destroy', $ay->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus tahun akademik ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-text-muted hover:text-danger hover:bg-danger/10 rounded-lg transition-colors" title="Hapus">
                                        <span class="material-symbols-outlined text-sm">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="py-8 text-center text-text-muted">
                        <div class="flex flex-col items-center gap-2">
                            <span class="material-symbols-outlined text-4xl text-border-subtle">calendar_today</span>
                            <p>Belum ada data tahun akademik.</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($academicYears->hasPages())
        <div class="p-space-md border-t border-border-subtle">{{ $academicYears->links() }}</div>
        @endif
    </div>

    {{-- Modal Lihat --}}
    <div x-show="showViewModal" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center bg-on-surface/40 backdrop-blur-sm" x-transition.opacity style="display:none">
        <div class="bg-surface-card w-full max-w-sm rounded-2xl shadow-xl overflow-hidden" @click.away="showViewModal=false">
            <div class="px-space-md py-4 border-b border-border-subtle flex items-center justify-between bg-canvas-bg/30">
                <h3 class="font-headline-md font-bold text-on-surface">Detail Tahun Akademik</h3>
                <button @click="showViewModal=false" class="text-text-muted hover:text-danger"><span class="material-symbols-outlined">close</span></button>
            </div>
            <div class="p-space-md flex flex-col gap-4">
                <div><p class="text-xs text-text-muted font-semibold uppercase tracking-wider mb-0.5">Tahun Akademik</p><p class="text-sm font-semibold" x-text="form.name"></p></div>
                <div class="grid grid-cols-2 gap-4">
                    <div><p class="text-xs text-text-muted font-semibold uppercase tracking-wider mb-0.5">Semester</p><p class="text-sm font-medium" x-text="form.semester"></p></div>
                    <div><p class="text-xs text-text-muted font-semibold uppercase tracking-wider mb-0.5">Status</p>
                        <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold" :class="form.status==='Aktif'?'bg-success/20 text-success':'bg-surface-variant text-text-muted'" x-text="form.status"></span>
                    </div>
                    <div><p class="text-xs text-text-muted font-semibold uppercase tracking-wider mb-0.5">Tgl Mulai</p><p class="text-sm font-medium" x-text="form.start_date || '-'"></p></div>
                    <div><p class="text-xs text-text-muted font-semibold uppercase tracking-wider mb-0.5">Tgl Selesai</p><p class="text-sm font-medium" x-text="form.end_date || '-'"></p></div>
                </div>
            </div>
            <div class="p-space-md border-t border-border-subtle bg-canvas-bg/30 text-right">
                <button @click="showViewModal=false" class="px-4 py-2 rounded-lg text-sm font-semibold bg-primary text-white hover:bg-primary/90 transition-colors">Tutup</button>
            </div>
        </div>
    </div>

    {{-- Modal Form --}}
    <div x-show="showModal" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center bg-on-surface/40 backdrop-blur-sm" x-transition.opacity style="display:none">
        <div class="bg-surface-card w-full max-w-md rounded-2xl shadow-xl overflow-hidden" @click.away="showModal=false">
            <div class="px-space-md py-4 border-b border-border-subtle flex items-center justify-between bg-canvas-bg/30">
                <h3 class="font-headline-md font-bold text-on-surface" x-text="isEdit ? 'Edit Tahun Akademik' : 'Tambah Tahun Akademik'"></h3>
                <button @click="showModal=false" class="text-text-muted hover:text-danger"><span class="material-symbols-outlined">close</span></button>
            </div>
            <form :action="isEdit ? '{{ url('tahun-akademik') }}/' + form.id : '{{ route('tahun-akademik.store') }}'" method="POST" class="p-space-md flex flex-col gap-4">
                @csrf
                <template x-if="isEdit"><input type="hidden" name="_method" value="PUT"></template>
                <div>
                    <label class="block text-sm font-semibold text-on-surface mb-1">Tahun Akademik <span class="text-danger">*</span></label>
                    <input type="text" name="name" x-model="form.name" placeholder="2025/2026" required class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-on-surface mb-1">Semester <span class="text-danger">*</span></label>
                    <select name="semester" x-model="form.semester" required class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                        <option value="Ganjil">Ganjil</option>
                        <option value="Genap">Genap</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-on-surface mb-1">Tanggal Mulai</label>
                        <input type="date" name="start_date" x-model="form.start_date" class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-on-surface mb-1">Tanggal Selesai</label>
                        <input type="date" name="end_date" x-model="form.end_date" class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-on-surface mb-2">Status</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 text-sm cursor-pointer"><input type="radio" name="status" value="Aktif" x-model="form.status" class="text-primary h-4 w-4"><span>Aktif</span></label>
                        <label class="flex items-center gap-2 text-sm cursor-pointer"><input type="radio" name="status" value="Nonaktif" x-model="form.status" class="h-4 w-4"><span>Nonaktif</span></label>
                    </div>
                </div>
                <div class="pt-space-md border-t border-border-subtle flex justify-end gap-2">
                    <button type="button" @click="showModal=false" class="px-4 py-2 rounded-lg text-sm font-semibold text-text-muted hover:bg-canvas-bg transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-lg text-sm font-semibold bg-primary text-white hover:bg-primary/90 transition-colors shadow-sm" x-text="isEdit ? 'Simpan Perubahan' : 'Simpan Data'"></button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
