@extends('layouts.app')

@section('content')
<div x-data="{
    showModal: false, showViewModal: false, isEdit: false,
    form: { id:null, name:'', code:'', teacher_id:'', school_class_id:'', academic_year_id:'', status:'Aktif' },
    viewData: {},
    openAdd() { this.isEdit=false; this.form={id:null,name:'',code:'',teacher_id:'',school_class_id:'',academic_year_id:'',status:'Aktif'}; this.showModal=true; },
    openEdit(r) { this.isEdit=true; this.form={...r, teacher_id:r.teacher_id||'', school_class_id:r.school_class_id||'', academic_year_id:r.academic_year_id||''}; this.showModal=true; },
    openView(r) { this.viewData={...r}; this.showViewModal=true; }
}">

    <div class="flex items-center justify-between mb-space-lg">
        <div>
            <h1 class="font-headline-lg text-headline-lg font-bold text-on-surface">Mata Pelajaran</h1>
            <p class="font-body-md text-text-muted mt-1">Kelola mata pelajaran dan assign guru pengampu.</p>
        </div>
        <button @click="openAdd" class="bg-primary hover:bg-primary/90 text-white px-space-md py-2.5 rounded-lg font-semibold flex items-center gap-2 transition-colors shadow-sm">
            <span class="material-symbols-outlined text-sm">add</span>Tambah Mata Pelajaran
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
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Mata Pelajaran</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Kode</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Guru Pengampu</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Kelas</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Tahun Akademik</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Status</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-subtle text-sm">
                    @forelse($subjects as $s)
                    <tr class="hover:bg-canvas-bg/30 transition-colors">
                        <td class="py-3 px-space-md font-semibold text-on-surface">{{ $s->name }}</td>
                        <td class="py-3 px-space-md"><span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold bg-primary-fixed text-on-primary-fixed">{{ $s->code }}</span></td>
                        <td class="py-3 px-space-md text-text-muted">{{ $s->teacher->name ?? '-' }}</td>
                        <td class="py-3 px-space-md text-text-muted">{{ $s->schoolClass->name ?? '-' }}</td>
                        <td class="py-3 px-space-md text-text-muted">{{ $s->academicYear->name ?? '-' }}</td>
                        <td class="py-3 px-space-md">
                            @if($s->status === 'Aktif')
                                <span class="inline-flex items-center gap-1 text-success font-medium text-xs"><span class="w-1.5 h-1.5 rounded-full bg-success"></span>Aktif</span>
                            @else
                                <span class="inline-flex items-center gap-1 text-text-muted font-medium text-xs"><span class="w-1.5 h-1.5 rounded-full bg-text-muted"></span>Nonaktif</span>
                            @endif
                        </td>
                        <td class="py-3 px-space-md text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button @click="openView({{ json_encode($s->load('teacher','schoolClass','academicYear')) }})" class="p-1.5 text-text-muted hover:text-success hover:bg-success/10 rounded-lg transition-colors" title="Lihat">
                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                </button>
                                <button @click="openEdit({{ json_encode($s) }})" class="p-1.5 text-text-muted hover:text-primary hover:bg-primary/10 rounded-lg transition-colors" title="Edit">
                                    <span class="material-symbols-outlined text-sm">edit</span>
                                </button>
                                <form action="{{ route('mata-pelajaran.destroy', $s->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus mata pelajaran ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-text-muted hover:text-danger hover:bg-danger/10 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined text-sm">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="py-8 text-center text-text-muted">
                        <div class="flex flex-col items-center gap-2">
                            <span class="material-symbols-outlined text-4xl text-border-subtle">menu_book</span>
                            <p>Belum ada data mata pelajaran.</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($subjects->hasPages())<div class="p-space-md border-t border-border-subtle">{{ $subjects->links() }}</div>@endif
    </div>

    {{-- Modal Lihat --}}
    <div x-show="showViewModal" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center bg-on-surface/40 backdrop-blur-sm" x-transition.opacity style="display:none">
        <div class="bg-surface-card w-full max-w-md rounded-2xl shadow-xl overflow-hidden" @click.away="showViewModal=false">
            <div class="px-space-md py-4 border-b border-border-subtle flex items-center justify-between bg-canvas-bg/30">
                <h3 class="font-headline-md font-bold text-on-surface">Detail Mata Pelajaran</h3>
                <button @click="showViewModal=false" class="text-text-muted hover:text-danger"><span class="material-symbols-outlined">close</span></button>
            </div>
            <div class="p-space-md flex flex-col gap-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2"><p class="text-xs text-text-muted font-semibold uppercase tracking-wider mb-0.5">Nama Mata Pelajaran</p><p class="text-sm font-semibold" x-text="viewData.name"></p></div>
                    <div><p class="text-xs text-text-muted font-semibold uppercase tracking-wider mb-0.5">Kode</p><p class="text-sm font-medium" x-text="viewData.code"></p></div>
                    <div><p class="text-xs text-text-muted font-semibold uppercase tracking-wider mb-0.5">Status</p>
                        <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold" :class="viewData.status==='Aktif'?'bg-success/20 text-success':'bg-surface-variant text-text-muted'" x-text="viewData.status"></span>
                    </div>
                    <div><p class="text-xs text-text-muted font-semibold uppercase tracking-wider mb-0.5">Guru Pengampu</p><p class="text-sm font-medium" x-text="viewData.teacher ? viewData.teacher.name : '-'"></p></div>
                    <div><p class="text-xs text-text-muted font-semibold uppercase tracking-wider mb-0.5">Kelas</p><p class="text-sm font-medium" x-text="viewData.school_class ? viewData.school_class.name : '-'"></p></div>
                    <div class="col-span-2"><p class="text-xs text-text-muted font-semibold uppercase tracking-wider mb-0.5">Tahun Akademik</p><p class="text-sm font-medium" x-text="viewData.academic_year ? viewData.academic_year.name : '-'"></p></div>
                </div>
            </div>
            <div class="p-space-md border-t border-border-subtle bg-canvas-bg/30 text-right">
                <button @click="showViewModal=false" class="px-4 py-2 rounded-lg text-sm font-semibold bg-primary text-white hover:bg-primary/90">Tutup</button>
            </div>
        </div>
    </div>

    {{-- Modal Form --}}
    <div x-show="showModal" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center bg-on-surface/40 backdrop-blur-sm" x-transition.opacity style="display:none">
        <div class="bg-surface-card w-full max-w-md rounded-2xl shadow-xl overflow-hidden" @click.away="showModal=false">
            <div class="px-space-md py-4 border-b border-border-subtle flex items-center justify-between bg-canvas-bg/30">
                <h3 class="font-headline-md font-bold text-on-surface" x-text="isEdit ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran'"></h3>
                <button @click="showModal=false" class="text-text-muted hover:text-danger"><span class="material-symbols-outlined">close</span></button>
            </div>
            <form :action="isEdit ? '{{ url('mata-pelajaran') }}/' + form.id : '{{ route('mata-pelajaran.store') }}'" method="POST" class="p-space-md flex flex-col gap-4">
                @csrf
                <template x-if="isEdit"><input type="hidden" name="_method" value="PUT"></template>
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-semibold text-on-surface mb-1">Nama Mata Pelajaran <span class="text-danger">*</span></label>
                        <input type="text" name="name" x-model="form.name" required class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-on-surface mb-1">Kode <span class="text-danger">*</span></label>
                        <input type="text" name="code" x-model="form.code" placeholder="MTK" required class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-on-surface mb-1">Status</label>
                        <select name="status" x-model="form.status" class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                            <option value="Aktif">Aktif</option>
                            <option value="Nonaktif">Nonaktif</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-semibold text-on-surface mb-1">Guru Pengampu</label>
                        <select name="teacher_id" x-model="form.teacher_id" class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                            <option value="">-- Pilih Guru --</option>
                            @foreach($teachers as $t)
                            <option value="{{ $t->id }}">{{ $t->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-on-surface mb-1">Kelas</label>
                        <select name="school_class_id" x-model="form.school_class_id" class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($classes as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-on-surface mb-1">Tahun Akademik</label>
                        <select name="academic_year_id" x-model="form.academic_year_id" class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                            <option value="">-- Pilih --</option>
                            @foreach($academicYears as $ay)
                            <option value="{{ $ay->id }}">{{ $ay->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="pt-space-md border-t border-border-subtle flex justify-end gap-2">
                    <button type="button" @click="showModal=false" class="px-4 py-2 rounded-lg text-sm font-semibold text-text-muted hover:bg-canvas-bg transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-lg text-sm font-semibold bg-primary text-white hover:bg-primary/90 shadow-sm" x-text="isEdit ? 'Simpan Perubahan' : 'Simpan Data'"></button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
