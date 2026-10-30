@extends('layouts.app')

@section('title', $todo->title . ' • Detail Agenda')

@section('content')

<div class="max-w-2xl mx-auto w-full min-w-0">
    <!-- Back Navigation -->
    <div class="mb-5 sm:mb-6">
        <a href="{{ route('todos.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-[#8c7d75] hover:text-[#b85d38] transition-colors">
            <span>←</span>
            <span>Kembali ke Jurnal</span>
        </a>
    </div>

    <!-- Main Card -->
    <div class="aesthetic-card rounded-2xl sm:rounded-3xl p-5 sm:p-8 md:p-9 relative">
        <!-- Top Tape Decor (Fixed to avoid clipping) -->
        <div class="hidden sm:block absolute -top-3 left-1/2 -translate-x-1/2 w-24 h-6 bg-[#eae1d5]/80 rounded-xs shadow-2xs rotate-[-1deg]"></div>

        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between sm:items-start gap-3 sm:gap-4 mb-4 sm:mb-5">
            <div class="min-w-0">
                <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#f3eae0] text-[#8a5b45] mb-2">
                    Entry #{{ str_pad($todo->id, 3, '0', STR_PAD_LEFT) }}
                </span>
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-[#382d27] font-aesthetic-title tracking-tight leading-snug">
                    {{ $todo->title }}
                </h1>
            </div>

            <!-- Status Pill & Quick Toggle Button -->
            <div class="flex items-center gap-2 shrink-0">
                <!-- Status badge -->
                @if($todo->is_completed)
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-[#eef6f1] text-[#2d6a4f] border border-[#cbe1d3]">
                    <span>🌿</span>
                    <span>Selesai Mantap</span>
                </span>
                @else
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-[#fdf5ed] text-[#b85d38] border border-[#f3d9c8]">
                    <span>☕</span>
                    <span>Sedang Jalan</span>
                </span>
                @endif

                <!-- Inline Quick Toggle Button -->
                <form action="{{ route('todos.toggle', $todo) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            class="px-3 py-1.5 rounded-full border text-xs font-semibold transition-all cursor-pointer @if($todo->is_completed) bg-white text-[#8c7d75] border-[#dfcbbe] hover:border-[#b85d38] hover:text-[#b85d38] @else bg-[#2d6a4f] text-white border-[#2d6a4f] hover:bg-[#23533e] @endif"
                            title="Ubah Status">
                        {{ $todo->is_completed ? 'Buka Kembali' : 'Tandai Selesai' }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Date Info Bar (Fully responsive wrap) -->
        <div class="flex flex-wrap items-center gap-2 sm:gap-3 py-2.5 px-3.5 sm:px-4 rounded-xl sm:rounded-2xl bg-[#faf7f2] border border-[#ebdcd0] text-[11px] sm:text-xs text-[#8c7d75] mb-5 sm:mb-6">
            <span class="flex items-center gap-1.5">
                <span>📅</span>
                <span>Dibuat: <strong class="text-[#5c4a3f]">{{ $todo->created_at ? $todo->created_at->format('d M Y, H:i') : '-' }}</strong></span>
            </span>
            @if($todo->updated_at && $todo->updated_at != $todo->created_at)
            <span class="text-[#cfc0b2]">•</span>
            <span class="flex items-center gap-1.5">
                <span>🔄</span>
                <span>Diperbarui: <strong class="text-[#5c4a3f]">{{ $todo->updated_at->format('d M Y, H:i') }}</strong></span>
            </span>
            @endif
        </div>

        <!-- Content Area -->
        <div class="mb-6 sm:mb-8">
            <h2 class="text-xs font-bold uppercase tracking-wider text-[#8c7d75] mb-2">
                Catatan Lengkap
            </h2>

            <div class="bg-[#fdfaf7] border border-[#ebdcd0] rounded-xl sm:rounded-2xl p-4 sm:p-5 text-[#4a3b32] text-sm sm:text-base leading-relaxed min-h-[100px]">
                @if($todo->description)
                    {!! nl2br(e($todo->description)) !!}
                @else
                    <span class="text-[#a89b91] italic font-aesthetic-hand text-base sm:text-lg">
                        Tidak ada catatan tambahan untuk agenda ini ✨
                    </span>
                @endif
            </div>
        </div>

        <!-- Footer Actions (Responsive touch-friendly buttons) -->
        <div class="flex flex-col-reverse xs:flex-row items-stretch xs:items-center justify-between gap-2.5 sm:gap-3 pt-4 sm:pt-5 border-t border-[#f0e6dc]">
            <a href="{{ route('todos.index') }}" 
               class="px-4 py-2 sm:px-5 sm:py-2.5 rounded-full text-xs font-semibold text-[#6e5d53] hover:text-[#382d27] hover:bg-[#f2e7db] transition-all text-center border border-[#e5d8cb] xs:border-transparent min-h-[38px] flex items-center justify-center">
                ← Kembali
            </a>

            <div class="flex items-center gap-2">
                <a href="{{ route('todos.edit', $todo) }}" 
                   class="flex-1 xs:flex-none px-4 py-2 sm:px-5 sm:py-2.5 rounded-full bg-[#fdf5ed] hover:bg-[#faeae0] text-[#b85d38] border border-[#f3d9c8] text-xs font-semibold tracking-wide transition-all flex items-center justify-center gap-1.5 min-h-[38px]">
                    <span>✏️</span>
                    <span>Edit Agenda</span>
                </a>

                <form action="{{ route('todos.destroy', $todo) }}" method="POST" onsubmit="return confirm('Hapus agenda ini dari jurnalmu?')">
                    @csrf 
                    @method('DELETE')
                    <button type="submit" 
                            class="px-3.5 py-2 sm:px-4 sm:py-2.5 rounded-full bg-[#faf0ed] hover:bg-[#f7dfd9] text-[#c04b33] border border-[#f5d0c7] text-xs font-semibold transition-all cursor-pointer min-h-[38px] flex items-center justify-center gap-1"
                            title="Hapus Agenda">
                        <span>🗑️</span>
                        <span class="xs:hidden sm:inline">Hapus</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
