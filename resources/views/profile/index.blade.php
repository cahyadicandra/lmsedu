@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto pb-space-3xl">

    <div class="flex items-center gap-2 text-sm text-text-muted mb-4">
        <a href="{{ url('/') }}" class="hover:text-primary transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-[18px]">home</span> Dashboard
        </a>
        <span>/</span>
        <span class="font-semibold text-on-surface">Profil Saya</span>
    </div>

    <div class="mb-space-lg">
        <h1 class="font-headline-lg text-headline-lg font-bold text-on-surface">Profil Saya</h1>
        <p class="font-body-md text-text-muted mt-1">Kelola informasi profil, foto, dan keamanan akun Anda.</p>
    </div>

    @if(session('success'))
    <div class="bg-success/10 text-success border border-success/20 px-4 py-3 rounded-xl mb-space-md flex items-center gap-2">
        <span class="material-symbols-outlined">check_circle</span>{{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="bg-danger/10 text-danger border border-danger/20 px-4 py-3 rounded-xl mb-space-md flex flex-col gap-1">
        <div class="flex items-center gap-2 font-semibold">
            <span class="material-symbols-outlined">error</span> Terjadi kesalahan:
        </div>
        <ul class="list-disc list-inside text-sm ml-7">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-surface-card rounded-2xl shadow-sm border border-border-subtle overflow-hidden">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="p-space-xl flex flex-col md:flex-row gap-8">
                
                {{-- Foto Profil Section --}}
                <div class="w-[160px] flex-shrink-0 flex flex-col items-center gap-4" 
                     x-data="{ 
                        previewUrl: '{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : '' }}',
                        fileChosen(event) {
                            const file = event.target.files[0];
                            if (file) {
                                this.previewUrl = URL.createObjectURL(file);
                            }
                        }
                     }">
                    
                    <div class="relative group w-[128px] h-[128px] min-w-[128px] min-h-[128px] flex-shrink-0 mx-auto" style="width: 128px; height: 128px; min-width: 128px; min-height: 128px;">
                        <div :class="previewUrl ? 'rounded-full' : 'rounded-2xl'" class="w-full h-full border-4 border-white shadow-md overflow-hidden bg-canvas-bg flex items-center justify-center relative transition-all duration-300">
                            <template x-if="previewUrl">
                                <img :src="previewUrl" alt="Preview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!previewUrl">
                                <div class="w-full h-full bg-primary/10 text-primary flex items-center justify-center text-4xl font-bold uppercase">
                                    {{ substr($user->name, 0, 2) }}
                                </div>
                            </template>
                            
                            {{-- Overlay Upload --}}
                            <div class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer text-white" @click="$refs.photoInput.click()">
                                <span class="material-symbols-outlined text-2xl">photo_camera</span>
                                <span class="text-[10px] font-semibold mt-1">Ganti Foto</span>
                            </div>
                        </div>
                    </div>
                    
                    <input type="file" name="profile_photo" x-ref="photoInput" @change="fileChosen" accept="image/*" class="hidden">
                    
                    <button type="button" @click="$refs.photoInput.click()" class="px-4 py-1.5 text-xs font-semibold bg-surface-variant text-text-muted hover:bg-border-subtle rounded-full transition-colors flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px]">upload</span> Pilih Foto
                    </button>
                    <p class="text-[11px] text-text-muted text-center max-w-[150px]">JPG, PNG, atau GIF. Maksimal 2MB.</p>
                </div>

                {{-- Form Fields Section --}}
                {{-- Form Fields Section --}}
                <div class="flex-1">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                        {{-- Kolom Kiri: Informasi Dasar --}}
                        <div class="flex flex-col gap-5">
                            <div>
                                <h3 class="text-sm font-bold text-on-surface uppercase tracking-wider mb-3 pb-1 border-b border-border-subtle">Informasi Dasar</h3>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-on-surface mb-1">Nama Lengkap <span class="text-danger">*</span></label>
                                <div class="relative flex items-center">
                                    <span class="material-symbols-outlined absolute left-3 text-text-muted text-[20px]">person</span>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full pl-10 pr-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-on-surface mb-1">Alamat Email <span class="text-danger">*</span></label>
                                <div class="relative flex items-center">
                                    <span class="material-symbols-outlined absolute left-3 text-text-muted text-[20px]">mail</span>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full pl-10 pr-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                                </div>
                            </div>
                            
                            @if(auth()->user()->role === 'Siswa')
                            <div class="mt-5">
                                <label class="block text-sm font-semibold text-on-surface mb-1">Kelas Saat Ini</label>
                                <div class="relative flex items-center">
                                    <span class="material-symbols-outlined absolute left-3 text-text-muted text-[20px]">meeting_room</span>
                                    <input type="text" value="{{ auth()->user()->schoolClass->name ?? 'Belum terdaftar di kelas' }}" readonly disabled class="w-full pl-10 pr-3 py-2 bg-surface-container-low border border-border-subtle rounded-lg text-sm text-text-muted cursor-not-allowed">
                                </div>
                            </div>
                            @endif
                        </div>

                        {{-- Kolom Kanan: Keamanan --}}
                        <div class="flex flex-col gap-5">
                            <div>
                                <h3 class="text-sm font-bold text-on-surface uppercase tracking-wider mb-3 pb-1 border-b border-border-subtle">Keamanan</h3>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-on-surface mb-1">Kata Sandi Baru</label>
                                <div class="relative flex items-center">
                                    <span class="material-symbols-outlined absolute left-3 text-text-muted text-[20px]">lock</span>
                                    <input type="password" name="password" autocomplete="new-password" placeholder="Minimal 8 karakter..." class="w-full pl-10 pr-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-on-surface mb-1">Konfirmasi Kata Sandi</label>
                                <div class="relative flex items-center">
                                    <span class="material-symbols-outlined absolute left-3 text-text-muted text-[20px]">lock_reset</span>
                                    <input type="password" name="password_confirmation" autocomplete="new-password" placeholder="Ulangi kata sandi..." class="w-full pl-10 pr-3 py-2 bg-white border border-border-subtle rounded-lg text-sm focus:ring-1 focus:ring-primary outline-none">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="p-space-md border-t border-border-subtle bg-canvas-bg/30 flex justify-end">
                <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-semibold bg-primary text-white hover:bg-primary/90 transition-colors shadow-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">save</span> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
