@extends('layouts.app')

@section('content')
<div class="p-6 md:p-8 space-y-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-on-surface">Data Sekolah</h1>
            <p class="text-text-muted mt-1">Kelola informasi profil dan identitas sekolah.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-success/10 text-success border border-success/20 p-4 rounded-xl flex items-center gap-3">
            <span class="material-symbols-outlined">check_circle</span>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-surface-card rounded-2xl border border-border-subtle shadow-sm overflow-hidden">
        <form action="{{ route('admin.sekolah.update') }}" method="POST" class="p-6 md:p-8">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Nama Sekolah --}}
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-semibold text-on-surface mb-2">Nama Sekolah</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $school->name) }}" class="w-full px-4 py-2.5 bg-white border border-border-subtle rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" required>
                    @error('name') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- NPSN --}}
                <div>
                    <label for="npsn" class="block text-sm font-semibold text-on-surface mb-2">NPSN</label>
                    <input type="text" name="npsn" id="npsn" value="{{ old('npsn', $school->npsn) }}" class="w-full px-4 py-2.5 bg-white border border-border-subtle rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                    @error('npsn') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Jenjang (Level) --}}
                <div>
                    <label for="level" class="block text-sm font-semibold text-on-surface mb-2">Jenjang Pendidikan</label>
                    <select name="level" id="level" class="w-full px-4 py-2.5 bg-white border border-border-subtle rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" required>
                        <option value="SD" {{ old('level', $school->level) == 'SD' ? 'selected' : '' }}>SD</option>
                        <option value="SMP" {{ old('level', $school->level) == 'SMP' ? 'selected' : '' }}>SMP</option>
                        <option value="SMA" {{ old('level', $school->level) == 'SMA' ? 'selected' : '' }}>SMA</option>
                        <option value="SMK" {{ old('level', $school->level) == 'SMK' ? 'selected' : '' }}>SMK</option>
                    </select>
                    @error('level') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label for="status" class="block text-sm font-semibold text-on-surface mb-2">Status Sekolah</label>
                    <select name="status" id="status" class="w-full px-4 py-2.5 bg-white border border-border-subtle rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" required>
                        <option value="Negeri" {{ old('status', $school->status) == 'Negeri' ? 'selected' : '' }}>Negeri</option>
                        <option value="Swasta" {{ old('status', $school->status) == 'Swasta' ? 'selected' : '' }}>Swasta</option>
                    </select>
                    @error('status') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Telepon --}}
                <div>
                    <label for="phone" class="block text-sm font-semibold text-on-surface mb-2">Nomor Telepon</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $school->phone) }}" class="w-full px-4 py-2.5 bg-white border border-border-subtle rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                    @error('phone') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Alamat --}}
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-semibold text-on-surface mb-2">Alamat Lengkap</label>
                    <textarea name="address" id="address" rows="3" class="w-full px-4 py-2.5 bg-white border border-border-subtle rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">{{ old('address', $school->address) }}</textarea>
                    @error('address') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                </div>

            </div>
            
            <div class="mt-8 flex justify-end">
                <button type="submit" class="px-6 py-2.5 rounded-lg text-sm font-semibold bg-primary text-white hover:bg-primary/90 transition-colors shadow-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">save</span> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
