@extends('layouts.app')

@section('content')
<div x-data="{
    showModal: false, showViewModal: false, isEdit: false,
    form: { id:null, name:'', email:'', password:'', school_class_id:'', status:'Aktif' },
    viewData: {},
    openAdd() { this.isEdit=false; this.form={id:null,name:'',email:'',password:'',school_class_id:'',status:'Aktif'}; this.showModal=true; },
    openEdit(r) { this.isEdit=true; this.form={...r, password:'', school_class_id:r.school_class_id||''}; this.showModal=true; },
    openView(r) { this.viewData={...r}; this.showViewModal=true; }
}">

    <div class="flex items-center justify-between mb-space-lg">
        <div>
            <h1 class="font-headline-lg text-headline-lg font-bold text-on-surface">Data Siswa</h1>
            <p class="font-body-md text-text-muted mt-1">Kelola data dan penempatan siswa ke kelas.</p>
        </div>
        <button @click="openAdd" class="bg-primary hover:bg-primary/90 text-white px-space-md py-2.5 rounded-full font-semibold flex items-center gap-2 transition-colors shadow-sm">
            <span class="material-symbols-outlined text-sm">person_add</span>Tambah Siswa
        </button>
    </div>

    @if(session('success'))
    <div class="bg-success/10 text-success border border-success/20 px-4 py-3 rounded-xl mb-space-md flex items-center gap-2">
        <span class="material-symbols-outlined">check_circle</span>{{ session('success') }}
    </div>
    @endif

    <div class="bg-surface-card rounded-2xl shadow-sm border border-border-subtle overflow-hidden">
        <div class="p-space-md border-b border-border-subtle bg-canvas-bg/30 flex items-center gap-space-sm">
            <form action="{{ route('data-siswa.index') }}" method="GET" class="flex items-center gap-space-sm flex-1 max-w-2xl">
                <div class="relative flex-1">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-muted text-sm">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="w-full pl-9 pr-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                </div>
                <select name="kelas" class="py-2 px-3 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none text-text-muted">
                    <option value="">Semua Kelas</option>
                    @foreach($classes as $c)
                    <option value="{{ $c->id }}" {{ request('kelas') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-surface-variant text-on-surface-variant hover:bg-surface-container px-4 py-2 rounded-full text-sm font-semibold transition-colors">Filter</button>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-canvas-bg/50 border-b border-border-subtle">
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Nama Siswa</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Email</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Kelas</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold">Status Akun</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-subtle text-sm">
                    @forelse($users as $usr)
                    <tr class="hover:bg-canvas-bg/30 transition-colors">
                        <td class="py-3 px-space-md font-semibold text-on-surface">
                            <div class="flex items-center gap-3">
                                @if($usr->profile_photo)
                                    <img src="{{ asset('storage/' . $usr->profile_photo) }}" alt="Foto {{ $usr->name }}" class="w-8 h-8 rounded-full object-cover border border-border-subtle">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-success/10 text-success flex items-center justify-center font-bold text-xs uppercase">{{ substr($usr->name, 0, 2) }}</div>
                                @endif
                                {{ $usr->name }}
                            </div>
                        </td>
                        <td class="py-3 px-space-md text-text-muted">{{ $usr->email }}</td>
                        <td class="py-3 px-space-md">
                            @if($usr->schoolClass)
                                <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold bg-primary/10 text-primary">{{ $usr->schoolClass->name }}</span>
                            @else
                                <span class="text-text-muted text-xs">-</span>
                            @endif
                        </td>
                        <td class="py-3 px-space-md">
                            @if(($usr->status ?? 'Aktif') === 'Aktif')
                                <span class="inline-flex items-center gap-1 text-success font-medium text-xs"><span class="w-1.5 h-1.5 rounded-full bg-success"></span>Aktif</span>
                            @else
                                <span class="inline-flex items-center gap-1 text-text-muted font-medium text-xs"><span class="w-1.5 h-1.5 rounded-full bg-text-muted"></span>Nonaktif</span>
                            @endif
                        </td>
                        <td class="py-3 px-space-md text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button @click="openView({{ json_encode($usr) }})" class="p-1.5 text-text-muted hover:text-success hover:bg-success/10 rounded-full transition-colors" title="Lihat">
                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                </button>
                                <button @click="openEdit({{ json_encode($usr) }})" class="p-1.5 text-text-muted hover:text-primary hover:bg-primary/10 rounded-full transition-colors" title="Edit">
                                    <span class="material-symbols-outlined text-sm">edit</span>
                                </button>
                                <form action="{{ route('data-siswa.destroy', $usr->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data siswa ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-text-muted hover:text-danger hover:bg-danger/10 rounded-full transition-colors">
                                        <span class="material-symbols-outlined text-sm">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="py-8 text-center text-text-muted">
                        <div class="flex flex-col items-center gap-2">
                            <span class="material-symbols-outlined text-4xl text-border-subtle">face</span>
                            <p>Belum ada data siswa.</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())<div class="p-space-md border-t border-border-subtle">{{ $users->links() }}</div>@endif
    </div>

    {{-- Modal Lihat --}}
    <div x-show="showViewModal" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center bg-on-surface/40 backdrop-blur-sm" x-transition.opacity style="display:none">
        <div class="bg-surface-card w-full max-w-sm rounded-2xl shadow-xl overflow-hidden" @click.away="showViewModal=false">
            <div class="px-space-md py-4 border-b border-border-subtle flex items-center justify-between bg-canvas-bg/30">
                <h3 class="font-headline-md font-bold text-on-surface">Profil Siswa</h3>
                <button @click="showViewModal=false" class="text-text-muted hover:text-danger"><span class="material-symbols-outlined">close</span></button>
            </div>
            <div class="p-space-md flex flex-col items-center text-center gap-3">
                <template x-if="viewData.profile_photo">
                    <img :src="`{{ asset('storage') }}/${viewData.profile_photo}`" alt="Foto Profil" class="w-20 h-20 rounded-full object-cover border border-border-subtle shadow-sm">
                </template>
                <template x-if="!viewData.profile_photo">
                    <div class="w-20 h-20 rounded-full bg-success/10 text-success flex items-center justify-center font-bold text-2xl uppercase">
                        <span x-text="viewData.name ? viewData.name.substring(0,2) : ''"></span>
                    </div>
                </template>
                <div>
                    <p class="text-lg font-semibold text-on-surface" x-text="viewData.name"></p>
                    <p class="text-sm text-text-muted" x-text="viewData.email"></p>
                </div>
                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-success/10 text-success" x-text="viewData.role"></span>
                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold" :class="(viewData.status||'Aktif')==='Aktif'?'bg-success/20 text-success':'bg-surface-variant text-text-muted'" x-text="viewData.status||'Aktif'"></span>
            </div>
            <div class="p-space-md border-t border-border-subtle bg-canvas-bg/30 text-center">
                <button @click="showViewModal=false" class="px-6 py-2 rounded-full text-sm font-semibold bg-primary text-white hover:bg-primary/90">Tutup</button>
            </div>
        </div>
    </div>

    {{-- Modal Form --}}
    <div x-show="showModal" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center bg-on-surface/40 backdrop-blur-sm" x-transition.opacity style="display:none">
        <div class="bg-surface-card w-full max-w-md rounded-2xl shadow-xl overflow-hidden" @click.away="showModal=false">
            <div class="px-space-md py-4 border-b border-border-subtle flex items-center justify-between bg-canvas-bg/30">
                <h3 class="font-headline-md font-bold text-on-surface" x-text="isEdit ? 'Edit Data Siswa' : 'Tambah Siswa Baru'"></h3>
                <button @click="showModal=false" class="text-text-muted hover:text-danger"><span class="material-symbols-outlined">close</span></button>
            </div>
            <form :action="isEdit ? '{{ url('data-siswa') }}/' + form.id : '{{ route('data-siswa.store') }}'" method="POST" class="p-space-md flex flex-col gap-4">
                @csrf
                <template x-if="isEdit"><input type="hidden" name="_method" value="PUT"></template>
                <input type="hidden" name="role" value="Siswa">
                <div>
                    <label class="block text-sm font-semibold text-on-surface mb-1">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="name" x-model="form.name" required class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-on-surface mb-1">Alamat Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" x-model="form.email" required class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-on-surface mb-1">Tempatkan ke Kelas</label>
                    <select name="school_class_id" x-model="form.school_class_id" class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($classes as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-on-surface mb-1">Status Akun</label>
                    <select name="status" x-model="form.status" class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                        <option value="Aktif">Aktif</option>
                        <option value="Nonaktif">Nonaktif</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-on-surface mb-1">
                        Kata Sandi
                        <span x-show="!isEdit" class="text-danger">*</span>
                        <span x-show="isEdit" class="text-text-muted font-normal text-xs">(Kosongkan jika tidak diubah)</span>
                    </label>
                    <input type="password" name="password" x-model="form.password" :required="!isEdit" class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
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

