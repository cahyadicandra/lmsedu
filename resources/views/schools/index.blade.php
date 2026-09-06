@extends('layouts.app')

@section('content')
<div x-data="{ 
        showModal: false, 
        showViewModal: false,
        isEdit: false, 
        form: { id: null, name: '', npsn: '', level: 'SD', status: 'Aktif', address: '', phone: '' },
        openAddModal() {
            this.isEdit = false;
            this.form = { id: null, name: '', npsn: '', level: 'SD', status: 'Aktif', address: '', phone: '' };
            this.showModal = true;
        },
        openEditModal(school) {
            this.isEdit = true;
            this.form = { ...school };
            this.showModal = true;
        },
        openViewModal(school) {
            this.form = { ...school };
            this.showViewModal = true;
        },
        showDeleteModal: false,
        deleteUrl: '',
        deleteName: '',
        openDeleteModal(url, name) {
            this.deleteUrl = url;
            this.deleteName = name;
            this.showDeleteModal = true;
        }
    }">

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-space-lg">
        <div>
            <h1 class="font-headline-lg text-headline-lg font-bold text-on-surface">Data Sekolah</h1>
            <p class="font-body-md text-text-muted mt-1">Kelola data sekolah mitra yang terdaftar dalam sistem Asalink Edu.</p>
        </div>
        <button @click="openAddModal" class="bg-primary hover:bg-primary/90 text-white px-space-md py-2.5 rounded-full font-semibold flex items-center gap-2 transition-colors shadow-sm">
            <span class="material-symbols-outlined text-sm">add</span>
            Tambah Sekolah
        </button>
    </div>

    @if(session('success'))
    <div class="bg-success/10 text-success border border-success/20 px-4 py-3 rounded-xl mb-space-md flex items-center gap-2">
        <span class="material-symbols-outlined">check_circle</span>
        {{ session('success') }}
    </div>
    @endif
    @if($errors->any())
    <div class="bg-danger/10 text-danger border border-danger/20 px-4 py-3 rounded-xl mb-space-md flex items-center gap-2">
        <span class="material-symbols-outlined">error</span>
        {{ $errors->has('error') ? $errors->first('error') : 'Terdapat kesalahan pada input form.' }}
    </div>
    @endif

    <!-- Filter & Table Card -->
    <div class="bg-surface-card rounded-2xl shadow-sm border border-border-subtle overflow-hidden">
        
        <!-- Toolbar -->
        <div class="p-space-md border-b border-border-subtle bg-canvas-bg/30 flex items-center justify-between gap-space-md">
            <form action="{{ route('data-sekolah.index') }}" method="GET" class="flex items-center gap-space-sm w-full max-w-2xl">
                <!-- Search -->
                <div class="relative flex-1">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-muted text-sm">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NPSN..." class="w-full pl-9 pr-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                </div>
                <!-- Filter Jenjang -->
                <select name="level" class="py-2 px-3 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none text-text-muted">
                    <option value="">Semua Jenjang</option>
                    @foreach(['SD', 'MI', 'SMP', 'MTS', 'SMA', 'MA', 'SMK'] as $lvl)
                        <option value="{{ $lvl }}" {{ request('level') == $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-surface-variant text-on-surface-variant hover:bg-surface-container px-4 py-2 rounded-full text-sm font-semibold transition-colors">
                    Filter
                </button>
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-canvas-bg/50 border-b border-border-subtle">
                        <th class="py-3 px-space-md font-semibold text-xs uppercase tracking-wider text-text-muted">NPSN</th>
                        <th class="py-3 px-space-md font-semibold text-xs uppercase tracking-wider text-text-muted">Nama Sekolah</th>
                        <th class="py-3 px-space-md font-semibold text-xs uppercase tracking-wider text-text-muted">Jenjang</th>
                        <th class="py-3 px-space-md font-semibold text-xs uppercase tracking-wider text-text-muted">Status</th>
                        <th class="py-3 px-space-md font-semibold text-xs uppercase tracking-wider text-text-muted text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-subtle text-sm">
                    @forelse($schools as $school)
                    <tr class="hover:bg-canvas-bg/30 transition-colors">
                        <td class="py-3 px-space-md text-text-muted">{{ $school->npsn }}</td>
                        <td class="py-3 px-space-md font-semibold text-on-surface">{{ $school->name }}</td>
                        <td class="py-3 px-space-md">
                            <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold bg-primary-fixed text-on-primary-fixed">{{ $school->level }}</span>
                        </td>
                        <td class="py-3 px-space-md">
                            @if($school->status == 'Aktif')
                                <span class="inline-flex items-center gap-1 text-success font-medium text-xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-success"></span> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-text-muted font-medium text-xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-text-muted"></span> Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-space-md text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button @click="openViewModal({{ json_encode($school) }})" class="p-1.5 text-text-muted hover:text-success hover:bg-success/10 rounded-full transition-colors" title="Lihat">
                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                </button>
                                <button @click="openEditModal({{ json_encode($school) }})" class="p-1.5 text-text-muted hover:text-primary hover:bg-primary/10 rounded-full transition-colors" title="Edit">
                                    <span class="material-symbols-outlined text-sm">edit</span>
                                </button>
                                <button @click="openDeleteModal('{{ route('data-sekolah.destroy', $school->id) }}', '{{ $school->name }}')" class="p-1.5 text-text-muted hover:text-danger hover:bg-danger/10 rounded-lg transition-colors" title="Hapus">
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-text-muted">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-4xl text-border-subtle">domain_disabled</span>
                                <p>Tidak ada data sekolah yang ditemukan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($schools->hasPages())
        <div class="p-space-md border-t border-border-subtle bg-canvas-bg/30">
            {{ $schools->links() }}
        </div>
        @endif
    </div>

    <!-- Modal Detail (Lihat) -->
    <div x-show="showViewModal" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center bg-on-surface/40 backdrop-blur-sm" x-transition.opacity style="display: none;">
        <div class="bg-surface-card w-full max-w-md rounded-2xl shadow-xl overflow-hidden" @click.away="showViewModal = false" x-transition.scale.origin.bottom>
            <!-- Header -->
            <div class="px-space-md py-4 border-b border-border-subtle flex items-center justify-between bg-canvas-bg/30">
                <h3 class="font-headline-md text-headline-md font-bold text-on-surface">Detail Data Sekolah</h3>
                <button @click="showViewModal = false" class="text-text-muted hover:text-danger transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <!-- Content -->
            <div class="p-space-md flex flex-col gap-4">
                <div>
                    <p class="text-xs text-text-muted font-semibold uppercase tracking-wider mb-0.5">Nama Sekolah</p>
                    <p class="text-sm font-semibold text-on-surface" x-text="form.name"></p>
                </div>
                <div>
                    <p class="text-xs text-text-muted font-semibold uppercase tracking-wider mb-0.5">NPSN</p>
                    <p class="text-sm font-medium text-on-surface" x-text="form.npsn"></p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-text-muted font-semibold uppercase tracking-wider mb-0.5">Jenjang</p>
                        <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold bg-primary-fixed text-on-primary-fixed" x-text="form.level"></span>
                    </div>
                    <div>
                        <p class="text-xs text-text-muted font-semibold uppercase tracking-wider mb-0.5">Status</p>
                        <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold" 
                              :class="form.status === 'Aktif' ? 'bg-success/20 text-success' : 'bg-surface-variant text-text-muted'" 
                              x-text="form.status"></span>
                    </div>
                </div>
                <div>
                    <p class="text-xs text-text-muted font-semibold uppercase tracking-wider mb-0.5">Kontak / Telepon</p>
                    <p class="text-sm font-medium text-on-surface" x-text="form.phone || '-'"></p>
                </div>
                <div>
                    <p class="text-xs text-text-muted font-semibold uppercase tracking-wider mb-0.5">Alamat Lengkap</p>
                    <p class="text-sm font-medium text-on-surface" x-text="form.address || '-'"></p>
                </div>
            </div>
            <!-- Footer -->
            <div class="p-space-md border-t border-border-subtle bg-canvas-bg/30 text-right">
                <button @click="showViewModal = false" class="px-4 py-2 rounded-full text-sm font-semibold bg-primary text-white hover:bg-primary/90 transition-colors shadow-sm">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Modal Form (AlpineJS) -->
    <div x-show="showModal" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center bg-on-surface/40 backdrop-blur-sm" x-transition.opacity style="display: none;">
        <div class="bg-surface-card w-full max-w-lg rounded-2xl shadow-xl overflow-hidden" @click.away="showModal = false" x-transition.scale.origin.bottom>
            <!-- Header -->
            <div class="px-space-md py-4 border-b border-border-subtle flex items-center justify-between bg-canvas-bg/30">
                <h3 class="font-headline-md text-headline-md font-bold text-on-surface" x-text="isEdit ? 'Edit Data Sekolah' : 'Tambah Sekolah Baru'"></h3>
                <button @click="showModal = false" class="text-text-muted hover:text-danger transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            
            <!-- Form -->
            <form :action="isEdit ? '{{ url('data-sekolah') }}/' + form.id : '{{ route('data-sekolah.store') }}'" method="POST" class="p-space-md flex flex-col gap-space-sm">
                @csrf
                <template x-if="isEdit">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div class="grid grid-cols-2 gap-space-sm">
                    <div class="col-span-2">
                        <label class="block text-sm font-semibold text-on-surface mb-1">Nama Sekolah <span class="text-danger">*</span></label>
                        <input type="text" name="name" x-model="form.name" required class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-on-surface mb-1">NPSN <span class="text-danger">*</span></label>
                        <input type="text" name="npsn" x-model="form.npsn" required class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-on-surface mb-1">Jenjang <span class="text-danger">*</span></label>
                        <select name="level" x-model="form.level" required class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                            <option value="SD">SD</option>
                            <option value="MI">MI</option>
                            <option value="SMP">SMP</option>
                            <option value="MTS">MTS</option>
                            <option value="SMA">SMA</option>
                            <option value="MA">MA</option>
                            <option value="SMK">SMK</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-semibold text-on-surface mb-1">Status <span class="text-danger">*</span></label>
                        <div class="flex gap-4 mt-2">
                            <label class="flex items-center gap-2 text-sm cursor-pointer">
                                <input type="radio" name="status" value="Aktif" x-model="form.status" class="text-primary focus:ring-primary h-4 w-4">
                                <span>Aktif</span>
                            </label>
                            <label class="flex items-center gap-2 text-sm cursor-pointer">
                                <input type="radio" name="status" value="Nonaktif" x-model="form.status" class="text-text-muted focus:ring-text-muted h-4 w-4">
                                <span>Nonaktif</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-semibold text-on-surface mb-1">Alamat Lengkap</label>
                        <textarea name="address" x-model="form.address" rows="3" class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none resize-none"></textarea>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-semibold text-on-surface mb-1">No. Telepon / Kontak</label>
                        <input type="text" name="phone" x-model="form.phone" class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                    </div>
                </div>

                <div class="mt-space-md pt-space-md border-t border-border-subtle flex justify-end gap-2">
                    <button type="button" @click="showModal = false" class="px-4 py-2 rounded-full text-sm font-semibold text-text-muted hover:bg-canvas-bg transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-full text-sm font-semibold bg-primary text-white hover:bg-primary/90 transition-colors shadow-sm" x-text="isEdit ? 'Simpan Perubahan' : 'Simpan Data'"></button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Hapus (AlpineJS) -->
    <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center bg-on-surface/40 backdrop-blur-sm" x-transition.opacity style="display: none;">
        <div class="bg-surface-card w-full max-w-sm rounded-2xl shadow-xl overflow-hidden text-center p-6" @click.away="showDeleteModal = false" x-transition.scale.origin.bottom>
            <div class="w-16 h-16 rounded-full bg-danger/10 text-danger flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-3xl">warning</span>
            </div>
            <h3 class="font-headline-md text-headline-md font-bold text-on-surface mb-2">Hapus Data Sekolah?</h3>
            <p class="text-sm text-text-muted mb-6">Anda yakin ingin menghapus <span class="font-bold text-on-surface" x-text="deleteName"></span>? Tindakan ini tidak dapat dibatalkan.</p>
            
            <form :action="deleteUrl" method="POST" class="flex gap-3 justify-center">
                @csrf
                @method('DELETE')
                <button type="button" @click="showDeleteModal = false" class="px-5 py-2.5 rounded-full text-sm font-semibold text-text-muted bg-surface-variant hover:bg-surface-container transition-colors flex-1">Batal</button>
                <button type="submit" class="px-5 py-2.5 rounded-full text-sm font-semibold text-white bg-danger hover:bg-danger/90 transition-colors shadow-sm flex-1">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>
@endsection

