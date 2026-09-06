@extends('layouts.app')

@section('content')
<div x-data="{ 
        showModal: false, 
        showViewModal: false,
        isEdit: false, 
        form: { id: null, name: '', email: '', role: 'Siswa', password: '', school_id: '' },
        openAddModal() {
            this.isEdit = false;
            this.form = { id: null, name: '', email: '', role: 'Siswa', password: '', school_id: '' };
            this.showModal = true;
        },
        openEditModal(usr) {
            this.isEdit = true;
            this.form = { ...usr, password: '', school_id: usr.school_id || '' };
            this.showModal = true;
        },
        openViewModal(usr) {
            this.form = { ...usr };
            this.showViewModal = true;
        }
    }">

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-space-lg">
        <div>
            <h1 class="font-headline-lg text-headline-lg font-bold text-on-surface">Manajemen Pengguna</h1>
            <p class="font-body-md text-text-muted mt-1">Kelola data seluruh pengguna sistem dengan berbagai hak akses.</p>
        </div>
        <button @click="openAddModal" class="bg-primary hover:bg-primary/90 text-white px-space-md py-2.5 rounded-full font-semibold flex items-center gap-2 transition-colors shadow-sm">
            <span class="material-symbols-outlined text-sm">person_add</span>
            Tambah Pengguna
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
        {{ $errors->first() ?: 'Terdapat kesalahan pada input form.' }}
    </div>
    @endif

    <!-- Filter & Table Card -->
    <div class="bg-surface-card rounded-2xl shadow-sm border border-border-subtle overflow-hidden">
        
        <!-- Toolbar -->
        <div class="p-space-md border-b border-border-subtle bg-canvas-bg/30 flex items-center justify-between gap-space-md">
            <form action="{{ route('manajemen-pengguna.index') }}" method="GET" class="flex items-center gap-space-sm w-full max-w-2xl">
                <!-- Search -->
                <div class="relative flex-1">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-muted text-sm">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="w-full pl-9 pr-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                </div>
                <!-- Filter Role -->
                <select name="role" class="py-2 px-3 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none text-text-muted">
                    <option value="">Semua Peran (Role)</option>
                    @foreach(['Admin Sekolah', 'Guru', 'Siswa', 'Wali Murid', 'Super Admin'] as $r)
                        <option value="{{ $r }}" {{ request('role') == $r ? 'selected' : '' }}>{{ $r }}</option>
                    @endforeach
                </select>
                <!-- Filter Sekolah -->
                <select name="school_id" class="py-2 px-3 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none text-text-muted">
                    <option value="">Semua Sekolah</option>
                    @foreach($schools as $school)
                        <option value="{{ $school->id }}" {{ request('school_id') == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
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
                        <th class="py-3 px-space-md font-semibold text-xs uppercase tracking-wider text-text-muted">Pengguna</th>
                        <th class="py-3 px-space-md font-semibold text-xs uppercase tracking-wider text-text-muted">Email</th>
                        <th class="py-3 px-space-md font-semibold text-xs uppercase tracking-wider text-text-muted">Role / Akses</th>
                        <th class="py-3 px-space-md font-semibold text-xs uppercase tracking-wider text-text-muted">Terdaftar</th>
                        <th class="py-3 px-space-md font-semibold text-xs uppercase tracking-wider text-text-muted text-right">Aksi</th>
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
                                    <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-xs uppercase">
                                        {{ substr($usr->name, 0, 2) }}
                                    </div>
                                @endif
                                {{ $usr->name }}
                            </div>
                        </td>
                        <td class="py-3 px-space-md text-text-muted">{{ $usr->email }}</td>
                        <td class="py-3 px-space-md">
                            @php
                                $roleColors = [
                                    'Super Admin' => 'bg-danger/10 text-danger',
                                    'Admin Sekolah' => 'bg-warning/20 text-warning',
                                    'Guru' => 'bg-primary/20 text-primary',
                                    'Siswa' => 'bg-success/20 text-success',
                                    'Wali Murid' => 'bg-surface-variant text-text-muted',
                                    'admin' => 'bg-warning/20 text-warning',
                                    'mentor' => 'bg-primary/20 text-primary',
                                    'siswa' => 'bg-success/20 text-success',
                                    'super_admin' => 'bg-danger/10 text-danger',
                                ];
                                $color = $roleColors[$usr->role] ?? 'bg-surface-variant text-text-muted';
                                $displayRole = ucwords(str_replace('_', ' ', $usr->role));
                            @endphp
                            <div class="flex flex-col items-start gap-1">
                                <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold {{ $color }}">{{ $displayRole }}</span>
                                @if($usr->school)
                                    <span class="text-[11px] text-text-muted flex items-center gap-1"><span class="material-symbols-outlined text-[12px]">domain</span>{{ $usr->school->name }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="py-3 px-space-md text-text-muted text-xs">
                            {{ $usr->created_at ? $usr->created_at->format('d M Y') : '-' }}
                        </td>
                        <td class="py-3 px-space-md text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button @click="openViewModal({{ json_encode($usr) }})" class="p-1.5 text-text-muted hover:text-success hover:bg-success/10 rounded-full transition-colors" title="Lihat">
                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                </button>
                                <button @click="openEditModal({{ json_encode($usr) }})" class="p-1.5 text-text-muted hover:text-primary hover:bg-primary/10 rounded-full transition-colors" title="Edit">
                                    <span class="material-symbols-outlined text-sm">edit</span>
                                </button>
                                @if($usr->email !== 'admin@asalink.edu')
                                <form action="{{ route('manajemen-pengguna.destroy', $usr->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-text-muted hover:text-danger hover:bg-danger/10 rounded-full transition-colors" title="Hapus">
                                        <span class="material-symbols-outlined text-sm">delete</span>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-text-muted">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-4xl text-border-subtle">group_off</span>
                                <p>Tidak ada pengguna yang ditemukan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($users->hasPages())
        <div class="p-space-md border-t border-border-subtle bg-canvas-bg/30">
            {{ $users->links() }}
        </div>
        @endif
    </div>

    <!-- Modal Detail (Lihat) -->
    <div x-show="showViewModal" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center bg-on-surface/40 backdrop-blur-sm" x-transition.opacity style="display: none;">
        <div class="bg-surface-card w-full max-w-sm rounded-2xl shadow-xl overflow-hidden" @click.away="showViewModal = false" x-transition.scale.origin.bottom>
            <!-- Header -->
            <div class="px-space-md py-4 border-b border-border-subtle flex items-center justify-between bg-canvas-bg/30">
                <h3 class="font-headline-md text-headline-md font-bold text-on-surface">Profil Pengguna</h3>
                <button @click="showViewModal = false" class="text-text-muted hover:text-danger transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <!-- Content -->
            <div class="p-space-md flex flex-col items-center text-center gap-3">
                <template x-if="form.profile_photo">
                    <img :src="`{{ asset('storage') }}/${form.profile_photo}`" alt="Foto Profil" class="w-20 h-20 rounded-full object-cover border border-border-subtle shadow-sm mb-2">
                </template>
                <template x-if="!form.profile_photo">
                    <div class="w-20 h-20 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-2xl uppercase mb-2">
                        <span x-text="form.name ? form.name.substring(0,2) : ''"></span>
                    </div>
                </template>
                <div>
                    <p class="text-lg font-semibold text-on-surface" x-text="form.name"></p>
                    <p class="text-sm text-text-muted" x-text="form.email"></p>
                </div>
                <div class="mt-2 flex flex-col items-center gap-2">
                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-surface-variant text-on-surface-variant uppercase tracking-wider" x-text="form.role"></span>
                    <template x-if="form.school_id">
                        <span class="text-xs text-text-muted flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">domain</span> <span x-text="'ID Sekolah: ' + form.school_id"></span></span>
                    </template>
                </div>
            </div>
            <!-- Footer -->
            <div class="p-space-md border-t border-border-subtle bg-canvas-bg/30 text-center">
                <button @click="showViewModal = false" class="px-6 py-2 rounded-full text-sm font-semibold bg-primary text-white hover:bg-primary/90 transition-colors shadow-sm">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Modal Form (AlpineJS) -->
    <div x-show="showModal" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center bg-on-surface/40 backdrop-blur-sm" x-transition.opacity style="display: none;">
        <div class="bg-surface-card w-full max-w-md rounded-2xl shadow-xl overflow-hidden" @click.away="showModal = false" x-transition.scale.origin.bottom>
            <!-- Header -->
            <div class="px-space-md py-4 border-b border-border-subtle flex items-center justify-between bg-canvas-bg/30">
                <h3 class="font-headline-md text-headline-md font-bold text-on-surface" x-text="isEdit ? 'Edit Pengguna' : 'Tambah Pengguna Baru'"></h3>
                <button @click="showModal = false" class="text-text-muted hover:text-danger transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            
            <!-- Form -->
            <form :action="isEdit ? '{{ url('manajemen-pengguna') }}/' + form.id : '{{ route('manajemen-pengguna.store') }}'" method="POST" class="p-space-md flex flex-col gap-space-sm">
                @csrf
                <template x-if="isEdit">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div class="flex flex-col gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-on-surface mb-1">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" x-model="form.name" required class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-on-surface mb-1">Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" x-model="form.email" required class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-on-surface mb-1">Role / Hak Akses <span class="text-danger">*</span></label>
                        <select name="role" x-model="form.role" required class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                            <option value="Admin Sekolah">Admin Sekolah</option>
                            <option value="Guru">Guru</option>
                            <option value="Siswa">Siswa</option>
                            <option value="Wali Murid">Wali Murid</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-on-surface mb-1">Pilih Sekolah (Opsional)</label>
                        <select name="school_id" x-model="form.school_id" class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                            <option value="">-- Tanpa Sekolah (Hanya untuk Super Admin) --</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-on-surface mb-1">
                            Kata Sandi
                            <span x-show="!isEdit" class="text-danger">*</span>
                            <span x-show="isEdit" class="text-text-muted font-normal text-xs">(Kosongkan jika tidak ingin mengubah)</span>
                        </label>
                        <input type="password" name="password" x-model="form.password" :required="!isEdit" class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                    </div>
                </div>

                <div class="mt-space-md pt-space-md border-t border-border-subtle flex justify-end gap-2">
                    <button type="button" @click="showModal = false" class="px-4 py-2 rounded-full text-sm font-semibold text-text-muted hover:bg-canvas-bg transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-full text-sm font-semibold bg-primary text-white hover:bg-primary/90 transition-colors shadow-sm" x-text="isEdit ? 'Simpan Perubahan' : 'Simpan Data'"></button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

