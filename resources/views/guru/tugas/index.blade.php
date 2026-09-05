@extends('layouts.app')

@section('content')
<div x-data="{
    showModal: false, showDeleteModal: false, isEdit: false, deleteUrl: '', deleteName: '',
    form: { id:null, subject_id:'', school_class_id:'', title:'', description:'', youtube_link:'', due_date:'', status:'Draft' },
    openAdd() { this.isEdit=false; this.form={id:null,subject_id:'',school_class_id:'',title:'',description:'',youtube_link:'',due_date:'',status:'Draft'}; this.showModal=true; },
    openEdit(r) { 
        this.isEdit=true; 
        this.form={...r, subject_id:r.subject_id||'', school_class_id:r.school_class_id||'', youtube_link:r.youtube_link||'', due_date: r.due_date ? r.due_date.split('T')[0] : ''}; 
        this.showModal=true; 
    },
    openDelete(url, name) { this.deleteUrl = url; this.deleteName = name; this.showDeleteModal = true; }
}">

    <div class="flex items-center justify-between mb-space-lg">
        <div>
            <h1 class="font-headline-lg text-headline-lg font-bold text-on-surface">Manajemen Tugas</h1>
            <p class="font-body-md text-text-muted mt-1">Kelola pemberian tugas untuk siswa Anda.</p>
        </div>
        <button @click="openAdd" class="bg-primary hover:bg-primary/90 text-white px-space-md py-2.5 rounded-lg font-semibold flex items-center gap-2 transition-colors shadow-sm">
            <span class="material-symbols-outlined text-sm">add</span>Tambah Tugas
        </button>
    </div>

    @if(session('success'))
    <div class="bg-success/10 text-success border border-success/20 px-4 py-3 rounded-xl mb-space-md flex items-center gap-2">
        <span class="material-symbols-outlined">check_circle</span>{{ session('success') }}
    </div>
    @endif

    {{-- Filter Form --}}
    <div class="bg-surface-card rounded-2xl p-space-md border border-border-subtle shadow-sm mb-space-md flex flex-wrap gap-4 items-end">
        <form action="{{ route('tugas.index') }}" method="GET" class="flex flex-wrap gap-4 items-end w-full">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-semibold text-text-muted mb-1 uppercase tracking-wider">Pencarian Judul</label>
                <div class="relative flex items-center">
                    <span class="material-symbols-outlined absolute left-3 text-text-muted text-[18px]">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul tugas..." class="w-full pl-9 pr-3 py-2 bg-canvas-bg/50 border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
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
                <button type="submit" class="px-4 py-2 bg-surface-variant text-text-muted hover:bg-border-subtle rounded-lg text-sm font-semibold transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">filter_list</span> Filter
                </button>
            </div>
        </form>
    </div>

    <div class="bg-surface-card rounded-2xl shadow-sm border border-border-subtle overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-canvas-bg/50 border-b border-border-subtle">
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Tenggat Waktu</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Mata Pelajaran</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Kelas</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Judul Tugas</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Status</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-subtle text-sm">
                    @forelse($assignments as $s)
                    <tr class="hover:bg-canvas-bg/30 transition-colors">
                        <td class="py-3 px-space-md">
                            <span class="font-semibold text-on-surface block">{{ date('d M Y', strtotime($s->due_date)) }}</span>
                        </td>
                        <td class="py-3 px-space-md font-semibold text-primary">{{ $s->subject->name ?? '-' }}</td>
                        <td class="py-3 px-space-md font-medium">{{ $s->schoolClass->name ?? '-' }}</td>
                        <td class="py-3 px-space-md font-semibold text-on-surface truncate max-w-[200px]">{{ $s->title }}</td>
                        <td class="py-3 px-space-md">
                            @if($s->status === 'Published')
                                <span class="inline-flex items-center gap-1 bg-success/10 text-success px-2 py-0.5 rounded text-xs font-semibold">Published</span>
                            @elseif($s->status === 'Closed')
                                <span class="inline-flex items-center gap-1 bg-danger/10 text-danger px-2 py-0.5 rounded text-xs font-semibold">Closed</span>
                            @else
                                <span class="inline-flex items-center gap-1 bg-surface-container-highest text-text-muted px-2 py-0.5 rounded text-xs font-semibold">Draft</span>
                            @endif
                        </td>
                        <td class="py-3 px-space-md text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('tugas.show', $s->id) }}" class="p-1.5 text-text-muted hover:text-success hover:bg-success/10 rounded-lg transition-colors" title="Lihat & Nilai">
                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                </a>
                                <button @click="openEdit({{ json_encode($s) }})" class="p-1.5 text-text-muted hover:text-primary hover:bg-primary/10 rounded-lg transition-colors" title="Edit">
                                    <span class="material-symbols-outlined text-sm">edit</span>
                                </button>
                                <button @click="openDelete('{{ route('tugas.destroy', $s->id) }}', '{{ addslashes($s->title) }}')" class="p-1.5 text-text-muted hover:text-danger hover:bg-danger/10 rounded-lg transition-colors">
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="py-8 text-center text-text-muted">
                        <div class="flex flex-col items-center gap-2">
                            <span class="material-symbols-outlined text-4xl text-border-subtle">assignment</span>
                            <p>Belum ada data tugas.</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($assignments->hasPages())<div class="p-space-md border-t border-border-subtle">{{ $assignments->links() }}</div>@endif
    </div>

    {{-- Modal Form Tambah/Edit --}}
    <div x-show="showModal" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center bg-on-surface/40 backdrop-blur-sm" x-transition.opacity style="display:none">
        <div class="bg-surface-card w-full max-w-md rounded-2xl shadow-xl overflow-hidden" @click.away="showModal=false">
            <div class="px-space-md py-4 border-b border-border-subtle flex items-center justify-between bg-canvas-bg/30">
                <h3 class="font-headline-md font-bold text-on-surface" x-text="isEdit ? 'Edit Tugas' : 'Tambah Tugas'"></h3>
                <button @click="showModal=false" class="text-text-muted hover:text-danger"><span class="material-symbols-outlined">close</span></button>
            </div>
            <form :action="isEdit ? '{{ url('tugas') }}/' + form.id : '{{ route('tugas.store') }}'" method="POST" enctype="multipart/form-data" class="p-space-md flex flex-col gap-4 max-h-[75vh] overflow-y-auto">
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
                    
                    <div class="col-span-2">
                        <label class="block text-sm font-semibold text-on-surface mb-1">Judul Tugas <span class="text-danger">*</span></label>
                        <input type="text" name="title" x-model="form.title" required class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                    </div>

                    <div class="col-span-2 lg:col-span-1">
                        <label class="block text-sm font-semibold text-on-surface mb-1">Tenggat Waktu <span class="text-danger">*</span></label>
                        <input type="date" name="due_date" x-model="form.due_date" required class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                    </div>
                    
                    <div class="col-span-2 lg:col-span-1">
                        <label class="block text-sm font-semibold text-on-surface mb-1">Status</label>
                        <select name="status" x-model="form.status" class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                            <option value="Draft">Draft</option>
                            <option value="Published">Published</option>
                            <option value="Closed">Closed</option>
                        </select>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-semibold text-on-surface mb-1">Deskripsi</label>
                        <textarea name="description" x-model="form.description" rows="3" class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none"></textarea>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-semibold text-on-surface mb-1">Tautan YouTube <span class="text-xs font-normal text-text-muted">(Opsional)</span></label>
                        <div class="relative flex items-center">
                            <span class="material-symbols-outlined absolute left-3 text-text-muted text-[18px]">play_circle</span>
                            <input type="url" name="youtube_link" x-model="form.youtube_link" placeholder="Contoh: https://youtube.com/watch?v=..." class="w-full pl-9 pr-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                        </div>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-semibold text-on-surface mb-1">File Lampiran <span class="text-xs font-normal text-text-muted">(Opsional, Maks 10MB)</span></label>
                        <input type="file" name="file" class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-colors">
                    </div>
                </div>
                <div class="pt-space-md border-t border-border-subtle flex justify-end gap-2 mt-2">
                    <button type="button" @click="showModal=false" class="px-4 py-2 rounded-lg text-sm font-semibold text-text-muted hover:bg-canvas-bg transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-lg text-sm font-semibold bg-primary text-white hover:bg-primary/90 shadow-sm" x-text="isEdit ? 'Simpan Perubahan' : 'Simpan Tugas'"></button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Hapus -->
    <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center bg-on-surface/40 backdrop-blur-sm" x-transition.opacity style="display: none;">
        <div class="bg-surface-card w-full max-w-sm rounded-2xl shadow-xl overflow-hidden text-center p-6" @click.away="showDeleteModal = false" x-transition.scale.origin.bottom>
            <div class="w-16 h-16 rounded-full bg-danger/10 text-danger flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-3xl">warning</span>
            </div>
            <h3 class="font-headline-md font-bold text-on-surface mb-2">Hapus Tugas?</h3>
            <p class="text-sm text-text-muted mb-6">Anda yakin ingin menghapus tugas <span class="font-bold text-on-surface" x-text="deleteName"></span>?</p>
            
            <form :action="deleteUrl" method="POST" class="flex gap-3 justify-center">
                @csrf
                @method('DELETE')
                <button type="button" @click="showDeleteModal = false" class="px-5 py-2.5 rounded-lg text-sm font-semibold text-text-muted bg-surface-variant hover:bg-surface-container transition-colors flex-1">Batal</button>
                <button type="submit" class="px-5 py-2.5 rounded-lg text-sm font-semibold text-white bg-danger hover:bg-danger/90 shadow-sm flex-1">Hapus</button>
            </form>
        </div>
    </div>
</div>
@endsection
