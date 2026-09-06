@extends('layouts.app')

@section('content')
<div x-data="{
    showModal: false, showViewModal: false, isEdit: false,
    form: { id:null, name:'', level:'VII', teacher_id:'', academic_year_id:'', status:'Aktif' },
    viewData: {},
    openAdd() { this.isEdit=false; this.form={id:null,name:'',level:'VII',teacher_id:'',academic_year_id:'',status:'Aktif'}; this.showModal=true; },
    openEdit(r) { this.isEdit=true; this.form={...r, teacher_id: r.teacher_id||'', academic_year_id: r.academic_year_id||''}; this.showModal=true; },
    openView(r) { this.viewData={...r}; this.showViewModal=true; }
}">

    <div class="flex items-center justify-between mb-space-lg">
        <div>
            <h1 class="font-headline-lg text-headline-lg font-bold text-on-surface">Kelas / Rombel</h1>
            <p class="font-body-md text-text-muted mt-1">Kelola rombongan belajar dan wali kelas.</p>
        </div>
        <button @click="openAdd" class="bg-primary hover:bg-primary/90 text-white px-space-md py-2.5 rounded-full font-semibold flex items-center gap-2 transition-colors shadow-sm">
            <span class="material-symbols-outlined text-sm">add</span>Tambah Kelas
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
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Nama Kelas</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Tingkat</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Wali Kelas</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Tahun Akademik</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Jml Siswa</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Status</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-subtle text-sm">
                    @forelse($classes as $kelas)
                    <tr class="hover:bg-canvas-bg/30 transition-colors">
                        <td class="py-3 px-space-md font-semibold text-on-surface">{{ $kelas->name }}</td>
                        <td class="py-3 px-space-md"><span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold bg-primary/10 text-primary">{{ $kelas->level }}</span></td>
                        <td class="py-3 px-space-md text-text-muted">{{ $kelas->teacher->name ?? '-' }}</td>
                        <td class="py-3 px-space-md text-text-muted">{{ $kelas->academicYear->name ?? '-' }}</td>
                        <td class="py-3 px-space-md font-semibold text-on-surface">{{ $kelas->students->count() }}</td>
                        <td class="py-3 px-space-md">
                            @if($kelas->status === 'Aktif')
                                <span class="inline-flex items-center gap-1 text-success font-medium text-xs"><span class="w-1.5 h-1.5 rounded-full bg-success"></span>Aktif</span>
                            @else
                                <span class="inline-flex items-center gap-1 text-text-muted font-medium text-xs"><span class="w-1.5 h-1.5 rounded-full bg-text-muted"></span>Nonaktif</span>
                            @endif
                        </td>
                        <td class="py-3 px-space-md text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button @click="openView({{ json_encode($kelas->load('teacher','academicYear','students')) }})" class="p-1.5 text-text-muted hover:text-success hover:bg-success/10 rounded-lg transition-colors" title="Lihat">
                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                </button>
                                <button @click="openEdit({{ json_encode($kelas) }})" class="p-1.5 text-text-muted hover:text-primary hover:bg-primary/10 rounded-full transition-colors" title="Edit">
                                    <span class="material-symbols-outlined text-sm">edit</span>
                                </button>
                                <form action="{{ route('kelas.destroy', $kelas->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kelas ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-text-muted hover:text-danger hover:bg-danger/10 rounded-full transition-colors">
                                        <span class="material-symbols-outlined text-sm">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="py-8 text-center text-text-muted">
                        <div class="flex flex-col items-center gap-2">
                            <span class="material-symbols-outlined text-4xl text-border-subtle">meeting_room</span>
                            <p>Belum ada data kelas.</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($classes->hasPages())<div class="p-space-md border-t border-border-subtle">{{ $classes->links() }}</div>@endif
    </div>

    {{-- Modal Lihat Detail Kelas --}}
    <div x-show="showViewModal" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center bg-on-surface/40 backdrop-blur-sm" x-transition.opacity style="display:none">
        <div class="bg-surface-card w-full max-w-md rounded-2xl shadow-xl overflow-hidden" @click.away="showViewModal=false">
            <div class="px-space-md py-4 border-b border-border-subtle flex items-center justify-between bg-canvas-bg/30">
                <h3 class="font-headline-md font-bold text-on-surface">Detail Kelas</h3>
                <button @click="showViewModal=false" class="text-text-muted hover:text-danger"><span class="material-symbols-outlined">close</span></button>
            </div>
            <div class="p-space-md flex flex-col gap-4">
                <div class="grid grid-cols-2 gap-4">
                    <div><p class="text-xs text-text-muted font-semibold uppercase tracking-wider mb-0.5">Nama Kelas</p><p class="text-sm font-semibold" x-text="viewData.name"></p></div>
                    <div><p class="text-xs text-text-muted font-semibold uppercase tracking-wider mb-0.5">Tingkat</p><p class="text-sm font-medium" x-text="viewData.level"></p></div>
                    <div><p class="text-xs text-text-muted font-semibold uppercase tracking-wider mb-0.5">Wali Kelas</p><p class="text-sm font-medium" x-text="viewData.teacher ? viewData.teacher.name : '-'"></p></div>
                    <div><p class="text-xs text-text-muted font-semibold uppercase tracking-wider mb-0.5">Tahun Akademik</p><p class="text-sm font-medium" x-text="viewData.academic_year ? viewData.academic_year.name : '-'"></p></div>
                    <div><p class="text-xs text-text-muted font-semibold uppercase tracking-wider mb-0.5">Status</p>
                        <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold" :class="viewData.status==='Aktif'?'bg-success/20 text-success':'bg-surface-variant text-text-muted'" x-text="viewData.status"></span>
                    </div>
                    <div><p class="text-xs text-text-muted font-semibold uppercase tracking-wider mb-0.5">Jml Siswa</p>
                        <p class="text-sm font-semibold" x-text="viewData.students ? viewData.students.length + ' Siswa' : '0 Siswa'"></p>
                    </div>
                </div>
                <div>
                    <p class="text-xs text-text-muted font-semibold uppercase tracking-wider mb-2">Daftar Siswa</p>
                    <template x-if="viewData.students && viewData.students.length > 0">
                        <div class="flex flex-col gap-2 max-h-40 overflow-y-auto">
                            <template x-for="s in viewData.students" :key="s.id">
                                <div class="flex items-center gap-2 text-sm">
                                    <div class="w-6 h-6 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-xs uppercase flex-shrink-0" x-text="s.name.substring(0,2)"></div>
                                    <span class="font-medium text-on-surface" x-text="s.name"></span>
                                </div>
                            </template>
                        </div>
                    </template>
                    <template x-if="!viewData.students || viewData.students.length === 0">
                        <p class="text-sm text-text-muted">Belum ada siswa di kelas ini.</p>
                    </template>
                </div>
            </div>
            <div class="p-space-md border-t border-border-subtle bg-canvas-bg/30 text-right">
                <button @click="showViewModal=false" class="px-4 py-2 rounded-full text-sm font-semibold bg-primary text-white hover:bg-primary/90">Tutup</button>
            </div>
        </div>
    </div>

    {{-- Modal Form --}}
    <div x-show="showModal" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center bg-on-surface/40 backdrop-blur-sm" x-transition.opacity style="display:none">
        <div class="bg-surface-card w-full max-w-md rounded-2xl shadow-xl overflow-hidden" @click.away="showModal=false">
            <div class="px-space-md py-4 border-b border-border-subtle flex items-center justify-between bg-canvas-bg/30">
                <h3 class="font-headline-md font-bold text-on-surface" x-text="isEdit ? 'Edit Kelas' : 'Tambah Kelas Baru'"></h3>
                <button @click="showModal=false" class="text-text-muted hover:text-danger"><span class="material-symbols-outlined">close</span></button>
            </div>
            <form :action="isEdit ? '{{ url('kelas') }}/' + form.id : '{{ route('kelas.store') }}'" method="POST" class="p-space-md flex flex-col gap-4">
                @csrf
                <template x-if="isEdit"><input type="hidden" name="_method" value="PUT"></template>
                <div>
                    <label class="block text-sm font-semibold text-on-surface mb-1">Nama Kelas <span class="text-danger">*</span></label>
                    <input type="text" name="name" x-model="form.name" placeholder="Contoh: VII A" required class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-on-surface mb-1">Tingkat <span class="text-danger">*</span></label>
                    <select name="level" x-model="form.level" required class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                        @foreach(['I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'] as $lvl)
                        <option value="{{ $lvl }}">{{ $lvl }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-on-surface mb-1">Wali Kelas</label>
                    <select name="teacher_id" x-model="form.teacher_id" class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                        <option value="">-- Pilih Guru --</option>
                        @foreach($teachers as $t)
                        <option value="{{ $t->id }}">{{ $t->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-on-surface mb-1">Tahun Akademik</label>
                    <select name="academic_year_id" x-model="form.academic_year_id" class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                        <option value="">-- Pilih Tahun Akademik --</option>
                        @foreach($academicYears as $ay)
                        <option value="{{ $ay->id }}">{{ $ay->name }} - {{ $ay->semester }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-on-surface mb-2">Status</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 text-sm cursor-pointer"><input type="radio" name="status" value="Aktif" x-model="form.status" class="text-primary h-4 w-4"><span>Aktif</span></label>
                        <label class="flex items-center gap-2 text-sm cursor-pointer"><input type="radio" name="status" value="Nonaktif" x-model="form.status" class="h-4 w-4"><span>Nonaktif</span></label>
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

