@extends('layouts.app')

@section('content')
<div class="flex flex-col w-full gap-space-lg pb-space-3xl" x-data="{ showModal: false }">

    {{-- Breadcrumb & Header in a Card --}}
    <div class="bg-white rounded-2xl border border-border-subtle shadow-sm p-6 mb-4 flex flex-wrap items-center justify-between gap-space-sm">
        <div>
            <h1 class="font-headline-lg text-headline-lg font-bold text-on-surface">Pesan (Sticky Notes)</h1>
            <p class="font-body-md text-text-muted mt-1">Kirim pesan singkat kepada guru mengenai perkembangan anak.</p>
        </div>
        <button @click="showModal = true" class="bg-primary hover:bg-primary/90 text-white font-semibold py-2.5 px-5 rounded-full flex items-center gap-2 transition-colors shadow-sm">
            <span class="material-symbols-outlined text-[18px]">edit_square</span> Tulis Pesan
        </button>
    </div>

    {{-- Include a cute font from Google Fonts --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kalam:wght@400;700&display=swap');
        
        .note-lines {
            background-image: repeating-linear-gradient(transparent, transparent 23px, rgba(0,0,0,0.05) 24px);
            background-attachment: local;
        }
    </style>

    {{-- Sticky Notes Grid --}}
    @if($messages->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-4">
        @foreach($messages as $msg)
        @php
            $color = $msg->color ?? 'bg-yellow-100';
            $rotations = ['rotate-1', '-rotate-1', 'rotate-2', '-rotate-2', 'rotate-3', '-rotate-3'];
            $rotation = $rotations[$loop->index % count($rotations)];
        @endphp
        
        <div class="relative group" x-data="{ showDetail: false }">
            {{-- Pin/Tape Effect --}}
            <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-10 h-4 bg-red-400/80 rounded-sm shadow-sm z-20" style="clip-path: polygon(0 0, 100% 0, 95% 100%, 5% 100%);"></div>
            
            {{-- Note Body --}}
            <div class="{{ $color }} {{ $rotation }} note-lines p-5 pt-7 rounded-br-3xl rounded-tl-md rounded-tr-md rounded-bl-md shadow-md border border-black/5 flex flex-col h-full transform transition-all duration-300 hover:rotate-0 hover:scale-[1.03] hover:shadow-lg hover:z-10" style="min-height: 220px;">
                
                {{-- Header --}}
                <div class="flex items-center justify-between mb-3 border-b border-black/10 pb-2">
                    <span class="font-bold text-sm text-black/80">Ke: {{ $msg->teacher->name ?? 'Guru' }}</span>
                    @if($msg->reply)
                        <span class="material-symbols-outlined text-blue-600 text-[18px]" title="Dibalas">mark_email_read</span>
                    @elseif($msg->is_read)
                        <span class="material-symbols-outlined text-success text-[18px]" title="Sudah dibaca">done_all</span>
                    @else
                        <span class="material-symbols-outlined text-text-muted text-[18px]" title="Terkirim">check</span>
                    @endif
                </div>
                
                {{-- Content --}}
                <p class="flex-1 text-black/90 text-lg leading-[24px] overflow-hidden" style="font-family: 'Kalam', cursive;">
                    {{ \Illuminate\Support\Str::limit($msg->content, 120) }}
                </p>

                {{-- Footer --}}
                <div class="mt-4 pt-3 border-t border-black/10 flex items-center justify-between">
                    <span class="text-xs font-semibold text-black/50">{{ $msg->created_at->diffForHumans() }}</span>
                    
                    <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button @click="showDetail = true" class="w-7 h-7 rounded-full bg-white/50 flex items-center justify-center hover:bg-white text-black/70 transition-colors shadow-sm" title="Lihat Detail">
                            <span class="material-symbols-outlined text-[16px]">visibility</span>
                        </button>
                        <form action="{{ route('walimurid.pesan.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-7 h-7 rounded-full bg-white/50 flex items-center justify-center hover:bg-red-500 hover:text-white text-black/70 transition-colors shadow-sm" title="Hapus Pesan">
                                <span class="material-symbols-outlined text-[16px]">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Detail Modal --}}
            <div x-show="showDetail" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
                <div @click.away="showDetail = false" class="relative w-full max-w-lg"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                    
                    {{-- Big Sticky Note --}}
                    <div class="{{ $color }} note-lines p-8 rounded-br-[40px] rounded-tl-xl rounded-tr-xl rounded-bl-xl shadow-2xl relative">
                        <div class="absolute -top-4 left-1/2 -translate-x-1/2 w-16 h-6 bg-red-400/90 rounded-sm shadow-md z-10" style="clip-path: polygon(0 0, 100% 0, 95% 100%, 5% 100%);"></div>
                        
                        <div class="flex justify-between items-start mb-6 border-b border-black/10 pb-4">
                            <div>
                                <h3 class="font-bold text-lg text-black/80">Kepada: {{ $msg->teacher->name ?? 'Guru' }}</h3>
                                <p class="text-sm font-semibold text-black/50 mt-1">Dikirim: {{ $msg->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <button @click="showDetail = false" class="text-black/50 hover:text-black transition-colors p-1 bg-white/30 rounded-full">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </div>
                        
                        <div class="text-black/90 text-2xl leading-[32px] mb-8" style="font-family: 'Kalam', cursive; white-space: pre-wrap;">{{ $msg->content }}</div>
                        
                        @if($msg->reply)
                        <div class="mt-6 pt-4 border-t-2 border-black/10">
                            <p class="font-bold text-sm text-blue-800 mb-2 flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">reply</span> Balasan dari Guru:
                            </p>
                            <div class="text-blue-900 text-xl leading-[28px]" style="font-family: 'Kalam', cursive; white-space: pre-wrap;">{{ $msg->reply }}</div>
                        </div>
                        @endif
                        
                        <div class="absolute bottom-4 right-6 opacity-40">
                            <span class="material-symbols-outlined text-4xl">water_drop</span>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-surface-card p-12 rounded-2xl border border-border-subtle shadow-sm flex flex-col items-center justify-center text-center mt-4">
        <span class="material-symbols-outlined text-6xl text-text-muted mb-4 opacity-30">sticky_note_2</span>
        <h3 class="text-xl font-bold text-on-surface mb-2">Belum ada pesan</h3>
        <p class="text-text-muted">Anda belum mengirimkan sticky note kepada guru.</p>
        <button @click="showModal = true" class="btn-primary mt-6 py-2 px-6 rounded-full font-semibold shadow-sm">
            Tulis Pesan Pertama
        </button>
    </div>
    @endif

    {{-- Modal Tulis Pesan --}}
    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-black/50 backdrop-blur-sm">
        <div @click.away="showModal = false" class="relative w-full max-w-md p-6 bg-surface-card rounded-2xl shadow-xl text-left"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-4">
             
            <div class="flex items-center justify-between border-b border-border-subtle pb-4 mb-4">
                <h3 class="text-xl font-bold text-on-surface">Tulis Pesan (Sticky Note)</h3>
                <button @click="showModal = false" class="text-text-muted hover:text-on-surface transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            
            <form action="{{ route('walimurid.pesan.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-on-surface mb-2">Kepada Guru</label>
                    <select name="teacher_id" class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" required>
                        <option value="">-- Pilih Guru Anak Anda --</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-on-surface mb-2">Pesan Singkat</label>
                    <textarea name="content" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" placeholder="Cth: Pak/Bu, saya ingin menanyakan perkembangan anak saya..." required maxlength="1000"></textarea>
                    <p class="text-xs text-text-muted mt-2 text-right">Maks. 1000 karakter</p>
                </div>
                
                <div class="flex justify-end gap-3 pt-4 border-t border-border-subtle">
                    <button type="button" @click="showModal = false" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-full font-semibold transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-full font-semibold flex items-center gap-2 transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">send</span> Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

