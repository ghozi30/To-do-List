@extends('layouts.app')

@section('title', 'Kota Klasik • Aesthetic Daily Planner')

@section('content')

<!-- 1. HERO BANNER: 100% RESPONSIVE AESTHETIC PLANNER -->
<div class="w-full rounded-2xl sm:rounded-3xl p-4 sm:p-7 md:p-9 mb-6 sm:mb-8 bg-gradient-to-br from-white via-[#fbf7f1] to-[#f4ebe1] border border-[#ebdcd0] shadow-[0_8px_30px_-10px_rgba(92,70,58,0.06)] overflow-hidden">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5 sm:gap-7 w-full">
        <!-- Content -->
        <div class="w-full lg:max-w-xl min-w-0">
            <!-- Badges (Wrap gracefully without border collision) -->
            <div class="flex flex-wrap items-center gap-1.5 sm:gap-2 mb-2.5 sm:mb-3">
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-[#f3eae0] border border-[#dfd0c1] text-[10px] sm:text-xs font-semibold text-[#8a5b45]">
                    <span>✨</span>
                    <span>Daily Flow & Chill Routine</span>
                </span>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-white/95 border border-[#e5d8cb] text-[10px] sm:text-xs font-medium text-[#7d685c] shadow-2xs">
                    <span>🎧</span>
                    <span>Lofi Coffee Vibes</span>
                </span>
            </div>

            <h1 class="text-xl sm:text-3xl md:text-4xl font-bold text-[#382d27] font-aesthetic-title tracking-tight leading-snug">
                Semangat Hari Ini! ☕
            </h1>

            <p class="text-[#6e5d53] mt-2 text-xs sm:text-sm md:text-base leading-relaxed font-normal break-words">
                Tata rencana harianmu dengan santai. Satu cangkir kopi, langkah demi langkah, dan nikmati setiap prosesnya di sudut kota favoritmu.
            </p>
        </div>

        <!-- Stats Bar (Clean 3-column responsive grid) -->
        <div class="w-full lg:w-auto shrink-0">
            <div class="grid grid-cols-3 gap-1.5 sm:gap-3 bg-white/90 backdrop-blur-xs p-2 sm:p-3 rounded-2xl border border-[#ebdcd0] shadow-2xs w-full">
                <!-- Total -->
                <div class="text-center px-1.5 py-2 sm:px-3 sm:py-2.5 rounded-xl bg-[#faf7f2]/80">
                    <div class="text-base sm:text-2xl font-bold font-aesthetic-title text-[#382d27]">
                        {{ $todos->count() }}
                    </div>
                    <div class="text-[10px] sm:text-xs text-[#8c7d75] font-medium mt-0.5">
                        Total
                    </div>
                </div>

                <!-- Active -->
                <div class="text-center px-1.5 py-2 sm:px-3 sm:py-2.5 rounded-xl bg-[#fdf8f3]">
                    <div class="text-base sm:text-2xl font-bold font-aesthetic-title text-[#b85d38] flex items-center justify-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#b85d38] animate-pulse"></span>
                        <span>{{ $todos->where('is_completed', false)->count() }}</span>
                    </div>
                    <div class="text-[10px] sm:text-xs text-[#b85d38] font-medium mt-0.5">
                        Berjalan
                    </div>
                </div>

                <!-- Finished -->
                <div class="text-center px-1.5 py-2 sm:px-3 sm:py-2.5 rounded-xl bg-[#f2f7f4]">
                    <div class="text-base sm:text-2xl font-bold font-aesthetic-title text-[#2d6a4f] flex items-center justify-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#2d6a4f]"></span>
                        <span>{{ $todos->where('is_completed', true)->count() }}</span>
                    </div>
                    <div class="text-[10px] sm:text-xs text-[#2d6a4f] font-medium mt-0.5">
                        Selesai
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 2. SECTION HEADER & ACTION BUTTON -->
<div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center mb-5 sm:mb-6 gap-3 sm:gap-4 w-full">
    <div class="min-w-0">
        <h2 class="text-lg sm:text-2xl md:text-3xl font-bold text-[#382d27] font-aesthetic-title tracking-tight flex items-center gap-2">
            <span>📖</span> Daftar Agenda Hari Ini
        </h2>
        <p class="text-[#8c7d75] text-xs sm:text-sm mt-0.5">
            Klik lingkaran untuk menandai tugas yang sudah tuntas ✨
        </p>
    </div>

    <a href="{{ route('todos.create') }}"
       class="inline-flex items-center justify-center gap-2 px-5 py-2.5 sm:px-6 sm:py-3 rounded-full bg-[#b85d38] hover:bg-[#a04e2c] text-white font-semibold text-xs tracking-wide shadow-sm hover:shadow-md transition-all duration-200 active:scale-95 text-center shrink-0">
        <span class="text-base leading-none font-bold">+</span>
        <span>Tulis Agenda Baru</span>
    </a>
</div>

<!-- 3. CARDS LIST -->
<div class="grid gap-3 sm:gap-4 w-full">
    @forelse($todos as $todo)
    <div class="aesthetic-card rounded-2xl sm:rounded-3xl p-4 sm:p-5 transition-all duration-200 group hover:-translate-y-0.5 w-full overflow-hidden">
        
        <!-- Header row inside card: Checkbox + Title & Status Badge -->
        <div class="flex items-start gap-3 w-full">
            
            <!-- Quick Completion Toggle Button -->
            <form action="{{ route('todos.toggle', $todo) }}" method="POST" class="shrink-0 mt-0.5">
                @csrf
                @method('PATCH')
                <button type="submit" 
                        class="w-7 h-7 sm:w-8 sm:h-8 rounded-full border-2 transition-all flex items-center justify-center cursor-pointer active:scale-90 @if($todo->is_completed) bg-[#2d6a4f] border-[#2d6a4f] text-white shadow-xs @else border-[#cfc0b2] bg-white hover:border-[#b85d38] text-transparent hover:text-[#b85d38]/30 @endif"
                        title="{{ $todo->is_completed ? 'Tandai belum selesai' : 'Tandai selesai' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                    </svg>
                </button>
            </form>

            <!-- Title & Status Badge (Wraps naturally on mobile) -->
            <div class="flex-1 min-w-0">
                <div class="flex flex-wrap items-center gap-2 mb-1">
                    <a href="{{ route('todos.show', $todo) }}" 
                       class="text-base sm:text-lg font-bold font-aesthetic-title tracking-tight transition-colors hover:text-[#b85d38] break-words @if($todo->is_completed) text-[#9c8e85] line-through decoration-[#c4b5aa] @else text-[#382d27] @endif">
                        {{ $todo->title }}
                    </a>

                    @if($todo->is_completed)
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-[#eef6f1] text-[#2d6a4f] border border-[#cbe1d3] shrink-0">
                        <span>🌿</span>
                        <span>Selesai</span>
                    </span>
                    @else
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-[#fdf5ed] text-[#b85d38] border border-[#f3d9c8] shrink-0">
                        <span>☕</span>
                        <span>Aktif</span>
                    </span>
                    @endif
                </div>

                <!-- Description Snippet (Wraps and truncates vertically, never horizontally) -->
                @if($todo->description)
                <p class="text-[#6e5d53] text-xs sm:text-sm leading-relaxed line-clamp-2 mt-1 break-words">
                    {{ $todo->description }}
                </p>
                @endif

                <!-- Card Bottom Row: Timestamp & Action Buttons -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-3 mt-2 border-t border-[#f0e6dc]/80 w-full">
                    <!-- Date -->
                    <div class="flex items-center gap-1 text-[11px] text-[#9c8e85] font-medium">
                        <span>🕒</span>
                        <span>{{ $todo->created_at ? $todo->created_at->format('d M Y, H:i') : 'Baru saja' }}</span>
                        @if($todo->updated_at && $todo->updated_at != $todo->created_at)
                        <span class="hidden md:inline-block text-[#bdafa6]">• Diperbarui: {{ $todo->updated_at->format('d M') }}</span>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
                        <a href="{{ route('todos.show', $todo) }}" 
                           class="px-3 py-1.5 rounded-full bg-[#f7f2ea] hover:bg-[#eee5d8] text-[#5c4a3f] text-xs font-semibold tracking-wide transition-all duration-150 flex items-center gap-1 border border-[#e5d8cb] min-h-[34px]">
                            <span>👁️</span>
                            <span>Detail</span>
                        </a>

                        <a href="{{ route('todos.edit', $todo) }}" 
                           class="px-3 py-1.5 rounded-full bg-[#fdf5ed] hover:bg-[#faeae0] text-[#b85d38] text-xs font-semibold tracking-wide transition-all duration-150 flex items-center gap-1 border border-[#f3d9c8] min-h-[34px]">
                            <span>✏️</span>
                            <span>Edit</span>
                        </a>

                        <form action="{{ route('todos.destroy', $todo) }}" method="POST" onsubmit="return confirm('Hapus agenda ini dari jurnalmu?')">
                            @csrf 
                            @method('DELETE')
                            <button type="submit" 
                                    class="px-3 py-1.5 rounded-full bg-[#faf0ed] hover:bg-[#f7dfd9] text-[#c04b33] text-xs font-semibold tracking-wide transition-all duration-150 flex items-center gap-1 border border-[#f5d0c7] cursor-pointer min-h-[34px]"
                                    title="Hapus Agenda">
                                <span>🗑️</span>
                                <span>Hapus</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <!-- 4. EMPTY STATE: AESTHETIC CHILL VIBE -->
    <div class="text-center py-10 sm:py-16 px-5 aesthetic-card rounded-2xl sm:rounded-3xl my-4 sm:my-6 bg-white/90 w-full">
        <div class="w-14 h-14 sm:w-16 sm:h-16 mx-auto rounded-2xl sm:rounded-3xl bg-[#f5ede2] border border-[#ebdccb] flex items-center justify-center text-2xl sm:text-3xl mb-3 sm:mb-4 shadow-2xs">
            ☕
        </div>

        <h3 class="text-lg sm:text-2xl font-bold text-[#382d27] font-aesthetic-title tracking-tight mb-1.5">
            Belum Ada Catatan Hari Ini
        </h3>

        <p class="text-[#7d685c] max-w-md mx-auto text-xs sm:text-sm leading-relaxed mb-5 font-aesthetic-hand text-base sm:text-lg">
            "Waktunya menikmati kopi atau mulai tulis rencana seru pertamamu ✨"
        </p>

        <a href="{{ route('todos.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 sm:px-6 sm:py-3 rounded-full bg-[#382d27] hover:bg-[#b85d38] text-white font-semibold text-xs tracking-wide shadow-sm hover:shadow-md transition-all duration-200">
            <span class="text-base leading-none font-bold">+</span>
            <span>Bikin Catatan Pertama ✨</span>
        </a>
    </div>
    @endforelse
</div>

@endsection
