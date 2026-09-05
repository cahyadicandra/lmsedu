@extends('layouts.app')

@section('content')
<div x-data="{
    showAddModal: false, showDeleteModal: false,
    newType: '', deleteType: ''
}">
    {{-- Breadcrumb & Header --}}
    <div class="flex items-center gap-2 text-sm text-text-muted mb-4">
        <a href="{{ route('nilai.index') }}" class="hover:text-primary transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span> Kembali
        </a>
        <span>/</span>
        <span class="font-semibold text-on-surface">Kelola Nilai</span>
    </div>

    <div class="flex items-center justify-between mb-space-lg">
        <div>
            <h1 class="font-headline-lg text-headline-lg font-bold text-on-surface">Nilai: {{ $subject->name }}</h1>
            <p class="font-body-md text-text-muted mt-1">Kelas {{ $schoolClass->name }}</p>
        </div>
        <div class="flex gap-2">
            <button @click="showDeleteModal=true" class="bg-surface-variant text-danger hover:bg-danger/10 px-4 py-2 rounded-lg font-semibold flex items-center gap-2 transition-colors">
                <span class="material-symbols-outlined text-sm">delete</span> Hapus Kolom Nilai
            </button>
            <button @click="showAddModal=true" class="bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-lg font-semibold flex items-center gap-2 transition-colors shadow-sm">
                <span class="material-symbols-outlined text-sm">add</span> Tambah Kolom Nilai
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-success/10 text-success border border-success/20 px-4 py-3 rounded-xl mb-space-md flex items-center gap-2">
        <span class="material-symbols-outlined">check_circle</span>{{ session('success') }}
    </div>
    @endif

    <div class="bg-surface-card rounded-2xl shadow-sm border border-border-subtle overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-canvas-bg/50 border-b border-border-subtle">
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold w-12">No</th>
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold sticky left-0 bg-canvas-bg/50 z-10">Nama Siswa</th>
                        @foreach($existingTypes as $type)
                        <th class="py-3 px-space-md text-xs uppercase tracking-wider text-text-muted font-semibold text-center w-32 border-l border-border-subtle">{{ $type }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-subtle text-sm">
                    @forelse($schoolClass->students as $index => $student)
                    <tr class="hover:bg-canvas-bg/30 transition-colors">
                        <td class="py-3 px-space-md text-text-muted">{{ $index + 1 }}</td>
                        <td class="py-3 px-space-md font-semibold text-on-surface sticky left-0 bg-surface-card z-10">
                            {{ $student->name }}
                            <div class="text-xs text-text-muted font-normal mt-0.5">{{ $student->email }}</div>
                        </td>
                        @foreach($existingTypes as $type)
                        @php
                            $score = $grades->has($student->id) ? $grades[$student->id]->where('type', $type)->first()->score ?? '' : '';
                        @endphp
                        <td class="py-3 px-space-md text-center border-l border-border-subtle font-medium {{ $score !== '' ? 'text-on-surface' : 'text-text-muted' }}">
                            {{ $score !== '' ? $score : '-' }}
                        </td>
                        @endforeach
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ count($existingTypes) + 2 }}" class="py-8 text-center text-text-muted">Belum ada siswa di kelas ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Tambah Nilai --}}
    <div x-show="showAddModal" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center bg-on-surface/40 backdrop-blur-sm" x-transition.opacity style="display:none">
        <div class="bg-surface-card w-full max-w-3xl rounded-2xl shadow-xl overflow-hidden flex flex-col max-h-[90vh]" @click.away="showAddModal=false">
            <div class="px-space-md py-4 border-b border-border-subtle flex items-center justify-between bg-canvas-bg/30">
                <h3 class="font-headline-md font-bold text-on-surface">Tambah / Update Nilai</h3>
                <button @click="showAddModal=false" class="text-text-muted hover:text-danger"><span class="material-symbols-outlined">close</span></button>
            </div>
            
            <form action="{{ route('nilai.store') }}" method="POST" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                <input type="hidden" name="school_class_id" value="{{ $schoolClass->id }}">
                
                <div class="p-space-md border-b border-border-subtle bg-canvas-bg/10">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-on-surface mb-1">Jenis Nilai <span class="text-danger">*</span></label>
                            <input type="text" name="type" x-model="newType" required placeholder="Cth: Tugas 1, UTS, UAS" list="existing-types" class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                            <datalist id="existing-types">
                                @foreach($existingTypes as $type)
                                <option value="{{ $type }}">
                                @endforeach
                            </datalist>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-on-surface mb-1">Deskripsi (Opsional)</label>
                            <input type="text" name="description" placeholder="Catatan tambahan..." class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                        </div>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto p-space-md">
                    <div class="bg-canvas-bg/30 rounded-xl border border-border-subtle p-4 mb-4 text-sm text-text-muted flex items-start gap-2">
                        <span class="material-symbols-outlined text-info text-xl">info</span>
                        <p>Masukkan nilai (0-100) untuk setiap siswa. Kosongkan kotak jika siswa belum mendapatkan nilai.</p>
                    </div>

                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-border-subtle text-xs uppercase text-text-muted font-semibold">
                                <th class="pb-2 w-12">No</th>
                                <th class="pb-2">Nama Siswa</th>
                                <th class="pb-2 w-32 text-center">Nilai</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-subtle text-sm">
                            @foreach($schoolClass->students as $index => $student)
                            <tr class="hover:bg-canvas-bg/30">
                                <td class="py-3 text-text-muted">{{ $index + 1 }}</td>
                                <td class="py-3 font-medium text-on-surface">{{ $student->name }}</td>
                                <td class="py-3">
                                    <input type="number" step="0.01" min="0" max="100" name="grades[{{ $student->id }}]" class="w-full px-3 py-1.5 bg-white border border-border-subtle rounded-lg text-sm text-center focus:ring-1 focus:ring-primary outline-none" placeholder="-">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-space-md border-t border-border-subtle flex justify-end gap-2 bg-canvas-bg/30">
                    <button type="button" @click="showAddModal=false" class="px-4 py-2 rounded-lg text-sm font-semibold text-text-muted hover:bg-canvas-bg transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-lg text-sm font-semibold bg-primary text-white hover:bg-primary/90 shadow-sm">Simpan Nilai</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Hapus Nilai --}}
    <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center bg-on-surface/40 backdrop-blur-sm" x-transition.opacity style="display:none">
        <div class="bg-surface-card w-full max-w-md rounded-2xl shadow-xl overflow-hidden" @click.away="showDeleteModal=false">
            <div class="px-space-md py-4 border-b border-border-subtle flex items-center justify-between bg-danger/5">
                <h3 class="font-headline-md font-bold text-danger flex items-center gap-2"><span class="material-symbols-outlined">warning</span> Hapus Kolom Nilai</h3>
                <button @click="showDeleteModal=false" class="text-text-muted hover:text-danger"><span class="material-symbols-outlined">close</span></button>
            </div>
            
            <form action="{{ route('nilai.destroyType') }}" method="POST" class="p-space-md flex flex-col gap-4">
                @csrf
                @method('DELETE')
                <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                
                <p class="text-sm text-on-surface">Pilih kolom nilai (jenis nilai) yang ingin dihapus. <strong>Perhatian:</strong> Tindakan ini akan menghapus nilai tersebut untuk <u>seluruh siswa</u> di mata pelajaran ini.</p>

                <div>
                    <label class="block text-sm font-semibold text-on-surface mb-1">Pilih Kolom Nilai</label>
                    <select name="type" required class="w-full px-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-danger outline-none">
                        <option value="">-- Pilih --</option>
                        @foreach($existingTypes as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="pt-4 border-t border-border-subtle flex justify-end gap-2 mt-2">
                    <button type="button" @click="showDeleteModal=false" class="px-4 py-2 rounded-lg text-sm font-semibold text-text-muted hover:bg-canvas-bg transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-lg text-sm font-semibold bg-danger text-white hover:bg-danger/90 shadow-sm" onclick="return confirm('Anda yakin ingin menghapus kolom nilai ini secara permanen?')">Hapus Permanen</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
