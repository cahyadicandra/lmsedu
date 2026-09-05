@extends('layouts.app')

@section('content')
<div class="h-full flex flex-col">
    <div class="flex items-center justify-between mb-space-lg">
        <div>
            <h1 class="font-headline-lg text-headline-lg font-bold text-on-surface">Papan Pesan</h1>
            <p class="font-body-md text-text-muted mt-1">Kumpulan pesan dari siswa dan wali murid untuk Anda.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-success/10 text-success border border-success/20 px-4 py-3 rounded-xl mb-space-md flex items-center gap-2">
        <span class="material-symbols-outlined">check_circle</span>{{ session('success') }}
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

    {{-- Papan --}}
    <div x-data="{ showReplyModal: false, selectedMsgId: null, selectedMsgSender: '' }" class="flex-1 bg-white rounded-2xl border border-border-subtle shadow-sm p-8 overflow-hidden relative">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 gap-y-10">
            @forelse($messages as $msg)
            @php
                $styles = [
                    ['bg' => 'bg-cyan-200', 'text' => 'text-gray-900', 'pattern' => 'note-lines', 'sticker' => null], // Blue
                    ['bg' => 'bg-lime-300', 'text' => 'text-gray-900', 'pattern' => 'note-grid', 'sticker' => ['bg' => 'bg-blue-700', 'text' => 'FYI!']], // Green
                    ['bg' => 'bg-rose-400', 'text' => 'text-white', 'pattern' => 'note-lines-white', 'sticker' => null], // Coral
                    ['bg' => 'bg-slate-900', 'text' => 'text-white', 'pattern' => 'note-lines-white', 'sticker' => ['bg' => 'bg-orange-600', 'text' => 'ASAP']], // Black
                    ['bg' => 'bg-yellow-200', 'text' => 'text-gray-900', 'pattern' => 'note-lines', 'sticker' => null], // Yellow
                    ['bg' => 'bg-indigo-300', 'text' => 'text-white', 'pattern' => 'note-grid', 'sticker' => ['bg' => 'bg-black', 'text' => '!!']], // Purple
                    ['bg' => 'bg-orange-300', 'text' => 'text-gray-900', 'pattern' => 'note-lines', 'sticker' => null], // Orange
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

                    <div class="flex items-center gap-2 mb-3">
                        <div>
                            <h3 class="font-bold text-lg leading-tight">{{ $msg->sender_name }}</h3>
                            @php
                                $roleDisplay = $msg->sender_role;
                                if (str_starts_with($msg->sender_role, 'Siswa')) {
                                    $studentUser = \App\Models\User::where('name', $msg->sender_name)->where('role', 'Siswa')->first();
                                    if ($studentUser && $studentUser->schoolClass) {
                                        $roleDisplay = 'Siswa - Kelas ' . $studentUser->schoolClass->name;
                                    }
                                } elseif ($msg->sender_role === 'Wali Murid') {
                                    $studentName = trim(str_replace('Wali Murid', '', $msg->sender_name));
                                    if ($studentName) {
                                        $roleDisplay = 'Wali Murid - Siswa: ' . $studentName;
                                    }
                                }
                            @endphp
                            <span class="text-xs uppercase font-bold tracking-wider opacity-75">{{ $roleDisplay }}</span>
                        </div>
                    </div>
                    
                    <p class="flex-1 leading-relaxed text-base font-medium">
                        {{ $msg->content }}
                    </p>

                    @if($msg->reply)
                    <div class="mt-3 pt-3 border-t border-black/10">
                        <p class="text-xs font-bold opacity-75 mb-1">Balasan Anda:</p>
                        <p class="text-sm font-medium leading-tight">
                            {{ $msg->reply }}
                        </p>
                    </div>
                    @endif

                    <div class="mt-4 pt-3 flex items-center justify-between opacity-60 group-hover:opacity-100 transition-opacity">
                        <span class="text-xs font-semibold">{{ $msg->created_at->diffForHumans() }}</span>
                        
                        <div class="flex items-center gap-1">
                            @if(!$msg->reply)
                            <button @click="showReplyModal = true; selectedMsgId = '{{ $msg->id }}'; selectedMsgSender = '{{ $msg->sender_name }}'" type="button" class="p-1 hover:text-blue-600 rounded transition-colors" title="Balas Pesan">
                                <span class="material-symbols-outlined text-[20px]">reply</span>
                            </button>
                            @endif

                            <form action="{{ route('pesan.destroy', $msg->id) }}" method="POST">
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
                <p class="text-lg font-medium">Papan pesan masih kosong.</p>
            </div>
            @endforelse
        </div>

        {{-- Reply Modal --}}
        <div x-show="showReplyModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" style="display: none;">
            <div @click.away="showReplyModal = false" class="bg-surface-card w-full max-w-md rounded-2xl shadow-xl overflow-hidden">
                <div class="p-4 border-b border-border-subtle flex items-center justify-between bg-surface-container-low">
                    <h3 class="font-bold text-on-surface flex items-center gap-2"><span class="material-symbols-outlined">reply</span> Balas Pesan <span x-text="selectedMsgSender" class="text-primary ml-1"></span></h3>
                    <button @click="showReplyModal = false" class="text-text-muted hover:text-danger"><span class="material-symbols-outlined">close</span></button>
                </div>
                
                <form :action="`/pesan/${selectedMsgId}/reply`" method="POST" class="p-space-lg flex flex-col gap-4">
                    @csrf
                    <div>
                        <label class="text-sm font-bold text-on-surface mb-1 block">Balasan Anda</label>
                        <textarea name="reply" rows="4" class="input-standard w-full bg-blue-50 focus:bg-blue-50" style="font-family: 'Kalam', cursive;" placeholder="Tulis balasan Anda..." required></textarea>
                    </div>
                    
                    <div class="flex justify-end gap-3 mt-2">
                        <button type="button" @click="showReplyModal = false" class="btn-secondary py-2 px-4">Batal</button>
                        <button type="submit" class="btn-primary py-2 px-4">Kirim Balasan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
