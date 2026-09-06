@extends('layouts.app')

@section('content')
<div class="flex flex-col w-full gap-space-lg pb-space-3xl" x-data="{ showModal: false }">

    {{-- Breadcrumb & Header in a Card --}}
    <div class="bg-white rounded-2xl border border-border-subtle shadow-sm p-6 mb-4 flex flex-wrap items-center justify-between gap-space-sm">
        <div>
            <h1 class="font-headline-lg text-headline-lg font-bold text-on-surface">Pesan (Sticky Notes)</h1>
            <p class="font-body-md text-text-muted mt-1">Kirim catatan singkat kepada guru Anda.</p>
        </div>
        <button @click="showModal = true" class="bg-primary hover:bg-primary/90 text-white font-semibold py-2.5 px-5 rounded-full flex items-center gap-2 transition-colors shadow-sm">
            <span class="material-symbols-outlined text-[18px]">edit_square</span> Tulis Pesan
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
        <span class="material-symbols-outlined">error</span>{{ $errors->first() }}
    </div>
    @endif

    {{-- Include a cute font from Google Fonts --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kalam:wght@400;700&display=swap');
        
        .note-lines {
            background-image: repeating-linear-gradient(transparent, transparent 28px, rgba(0,0,0,0.08) 28px, rgba(0,0,0,0.08) 29px);
            background-position: 0 10px;
        }
        .note-lines-white {
            background-image: repeating-linear-gradient(transparent, transparent 28px, rgba(255,255,255,0.15) 28px, rgba(255,255,255,0.15) 29px);
            background-position: 0 10px;
        }
        .note-grid {
            background-image: linear-gradient(rgba(0,0,0,0.08) 1px, transparent 1px), linear-gradient(90deg, rgba(0,0,0,0.08) 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>

    {{-- Sticky Notes Grid in a Card --}}
    <div class="flex-1 bg-white rounded-2xl border border-border-subtle shadow-sm p-8 overflow-hidden relative mt-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 gap-y-10">
            @forelse($messages as $msg)
            @php
                $styles = [
                    ['bg' => 'bg-cyan-200', 'text' => 'text-gray-900', 'pattern' => 'note-lines', 'sticker' => null],
                    ['bg' => 'bg-lime-300', 'text' => 'text-gray-900', 'pattern' => 'note-grid', 'sticker' => ['bg' => 'bg-blue-700', 'text' => 'FYI!']],
                    ['bg' => 'bg-rose-400', 'text' => 'text-white', 'pattern' => 'note-lines-white', 'sticker' => null],
                    ['bg' => 'bg-slate-900', 'text' => 'text-white', 'pattern' => 'note-lines-white', 'sticker' => ['bg' => 'bg-orange-600', 'text' => 'ASAP']],
                    ['bg' => 'bg-yellow-200', 'text' => 'text-gray-900', 'pattern' => 'note-lines', 'sticker' => null],
                    ['bg' => 'bg-indigo-300', 'text' => 'text-white', 'pattern' => 'note-grid', 'sticker' => ['bg' => 'bg-black', 'text' => '!!']],
                    ['bg' => 'bg-orange-300', 'text' => 'text-gray-900', 'pattern' => 'note-lines', 'sticker' => null],
                ];
                $style = $styles[crc32($msg->id) % count($styles)];
                $rotations = ['-rotate-3', 'rotate-2', '-rotate-2', 'rotate-3', '-rotate-1', 'rotate-1'];
                $rotation = $rotations[crc32($msg->id) % count($rotations)];
            @endphp
            <div class="relative group {{ $rotation }} transition-transform hover:rotate-0 hover:z-10 hover:scale-[1.02] duration-300">
                
                @if($style['sticker'])
                {{-- Decorative Sticker --}}
                <div class="absolute -top-4 -left-3 w-10 h-10 rounded-full {{ $style['sticker']['bg'] }} text-white flex items-center justify-center font-black text-[11px] shadow-md z-10" style="clip-path: polygon(50% 0%, 61% 15%, 79% 10%, 82% 28%, 98% 35%, 89% 50%, 98% 65%, 82% 72%, 79% 90%, 61% 85%, 50% 100%, 39% 85%, 21% 90%, 18% 72%, 2% 65%, 11% 50%, 2% 35%, 18% 28%, 21% 10%, 39% 15%); transform: rotate(-15deg);">
                    {{ $style['sticker']['text'] }}
                </div>
                @endif

                {{-- Note --}}
                <div class="{{ $style['bg'] }} {{ $style['text'] }} {{ $style['pattern'] }} p-6 shadow-[2px_6px_12px_rgba(0,0,0,0.12)] min-h-[220px] flex flex-col relative" style="font-family: 'Kalam', cursive;">

                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <h3 class="font-bold text-lg leading-tight">{{ $msg->teacher->name ?? 'Guru' }}</h3>
                            <span class="text-xs uppercase font-bold tracking-wider opacity-75">Tujuan Guru</span>
                        </div>
                        @if($msg->reply)
                            <span class="material-symbols-outlined text-[20px]" title="Dibalas">mark_email_read</span>
                        @elseif($msg->is_read)
                            <span class="material-symbols-outlined text-[20px]" title="Sudah dibaca">done_all</span>
                        @else
                            <span class="material-symbols-outlined text-[20px] opacity-70" title="Terkirim">check</span>
                        @endif
                    </div>
                    
                    <p class="flex-1 leading-relaxed text-base font-medium">
                        {{ $msg->content }}
                    </p>

                    @if($msg->reply)
                    <div class="mt-3 pt-3 border-t border-black/10">
                        <p class="text-xs font-bold opacity-75 mb-1">Balasan Guru:</p>
                        <p class="text-sm font-medium leading-tight">
                            {{ $msg->reply }}
                        </p>
                    </div>
                    @endif

                    <div class="mt-4 pt-3 flex items-center justify-between opacity-60 group-hover:opacity-100 transition-opacity">
                        <span class="text-xs font-semibold">{{ $msg->created_at->diffForHumans() }}</span>
                        
                        <div class="flex items-center gap-1">
                            <form action="{{ route('siswa.pesan.destroy', $msg->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 hover:text-red-500 rounded transition-colors" title="Hapus Pesan">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full h-64 flex flex-col items-center justify-center text-gray-500/70">
                <span class="material-symbols-outlined text-6xl mb-4">inbox</span>
                <p class="text-lg font-medium">Anda belum mengirim pesan.</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Modal Tulis Pesan --}}
    <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-transition.opacity style="display: none;">
        <div @click.away="showModal = false" class="bg-surface-card w-full max-w-md rounded-2xl shadow-xl overflow-hidden" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="p-4 border-b border-border-subtle flex items-center justify-between bg-surface-container-low">
                <h3 class="font-bold text-on-surface flex items-center gap-2"><span class="material-symbols-outlined">edit_square</span> Tulis Sticky Note</h3>
                <button @click="showModal = false" class="text-text-muted hover:text-danger"><span class="material-symbols-outlined">close</span></button>
            </div>
            
            <form action="{{ route('siswa.pesan.store') }}" method="POST" class="p-space-lg flex flex-col gap-4">
                @csrf
                <div>
                    <label class="text-sm font-bold text-on-surface mb-1 block">Kepada Guru</label>
                    <select name="teacher_id" class="w-full px-4 py-2.5 bg-canvas-bg border border-border-subtle rounded-full text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all cursor-pointer" required>
                        <option value="">Pilih Guru...</option>
                        @foreach($teachers as $t)
                            <option value="{{ $t->id }}">{{ $t->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="text-sm font-bold text-on-surface mb-1 block">Catatan Anda</label>
                    <textarea name="content" rows="4" class="input-standard w-full bg-yellow-50 focus:bg-yellow-50" style="font-family: 'Comic Sans MS', 'Chalkboard SE', sans-serif;" placeholder="Tulis catatan singkat..." required></textarea>
                </div>
                
                <div class="flex justify-end gap-3 mt-2">
                    <button type="button" @click="showModal = false" class="btn-secondary py-2 px-4">Batal</button>
                    <button type="submit" class="btn-primary py-2 px-4">Kirim Pesan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


