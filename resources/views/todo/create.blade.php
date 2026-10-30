@extends('layouts.app')

@section('title', 'Tulis Agenda Baru • Kota Klasik')

@section('content')

<div class="max-w-xl mx-auto w-full min-w-0">
    <!-- Back Navigation -->
    <div class="mb-5 sm:mb-6">
        <a href="{{ route('todos.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-[#8c7d75] hover:text-[#b85d38] transition-colors">
            <span>←</span>
            <span>Kembali ke Jurnal</span>
        </a>
    </div>

    <!-- Main Card -->
    <div class="aesthetic-card rounded-2xl sm:rounded-3xl p-5 sm:p-8 md:p-9 relative">
        <div class="flex items-center gap-3 sm:gap-3.5 mb-2">
            <div class="w-10 h-10 rounded-2xl bg-[#f5ede2] border border-[#ebdccb] flex items-center justify-center text-xl shrink-0">
                📝
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-[#382d27] font-aesthetic-title tracking-tight">
                    Tulis Agenda Baru
                </h1>
                <p class="text-[#8c7d75] text-xs sm:text-sm mt-0.5">
                    Catatkan ide kegiatan, tugas harian, atau target santaimu.
                </p>
            </div>
        </div>

        <div class="w-full h-px bg-[#f0e6dc] my-4 sm:my-5"></div>

        <form action="{{ route('todos.store') }}" method="POST" class="space-y-4 sm:space-y-5">
            @csrf

            <!-- Title Input -->
            <div class="space-y-1.5">
                <label for="title" class="block text-xs font-bold uppercase tracking-wider text-[#6e5d53]">
                    Judul Agenda <span class="text-[#c04b33]">*</span>
                </label>
                <input type="text" 
                       id="title"
                       name="title" 
                       value="{{ old('title') }}" 
                       required
                       class="w-full bg-[#fdfaf7] border border-[#e2d5c7] rounded-xl sm:rounded-2xl px-4 py-3 text-[#382d27] placeholder-[#a89b91] focus:outline-none focus:ring-2 focus:ring-[#b85d38]/30 focus:border-[#b85d38] transition-all text-base sm:text-sm font-medium shadow-2xs"
                       placeholder="Contoh: Beli cold brew & baca buku di cafe ☕">
                @error('title')
                <p class="text-xs text-[#c04b33] mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description Textarea -->
            <div class="space-y-1.5">
                <div class="flex items-center justify-between">
                    <label for="description" class="block text-xs font-bold uppercase tracking-wider text-[#6e5d53]">
                        Catatan & Detail Tambahan
                    </label>
                    <span class="font-aesthetic-hand text-sm text-[#b85d38]">opsional ya ~</span>
                </div>
                <textarea id="description"
                          name="description" 
                          rows="4"
                          class="w-full bg-[#fdfaf7] border border-[#e2d5c7] rounded-xl sm:rounded-2xl px-4 py-3 text-[#382d27] placeholder-[#a89b91] focus:outline-none focus:ring-2 focus:ring-[#b85d38]/30 focus:border-[#b85d38] transition-all text-base sm:text-sm font-normal shadow-2xs"
                          placeholder="Tulis detail rencana, bahan tugas, atau hal penting lainnya di sini...">{{ old('description') }}</textarea>
                @error('description')
                <p class="text-xs text-[#c04b33] mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Completed Checkbox -->
            <label class="flex items-center gap-3 sm:gap-3.5 p-3.5 sm:p-4 bg-[#fbf7f2] border border-[#ebdcd0] rounded-xl sm:rounded-2xl cursor-pointer hover:bg-[#f6eee3] transition-colors">
                <input type="checkbox" 
                       name="is_completed" 
                       value="1" 
                       {{ old('is_completed') ? 'checked' : '' }}
                       class="w-5 h-5 rounded-lg border-[#cfc0b2] text-[#b85d38] focus:ring-[#b85d38]/30 cursor-pointer shrink-0">
                <div>
                    <span class="text-xs sm:text-sm font-semibold text-[#382d27] block">Tandai sudah selesai</span>
                    <span class="text-[11px] text-[#8c7d75]">Kalau tugas ini kebetulan baru dicatat setelah rampung dikerjakan ✨</span>
                </div>
            </label>

            <!-- Buttons (Responsive stack on small mobile, row on tablet+) -->
            <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-2.5 sm:gap-3 pt-3">
                <a href="{{ route('todos.index') }}" 
                   class="px-5 py-2.5 sm:py-2.5 rounded-full text-xs font-semibold text-[#6e5d53] hover:text-[#382d27] hover:bg-[#f2e7db] transition-all text-center border border-[#e5d8cb] sm:border-transparent min-h-[40px] flex items-center justify-center">
                    Batal
                </a>

                <button type="submit" 
                        class="px-6 py-2.5 sm:py-2.5 rounded-full bg-[#b85d38] hover:bg-[#a04e2c] text-white font-semibold text-xs tracking-wide shadow-sm hover:shadow-md transition-all duration-200 active:scale-95 cursor-pointer flex items-center justify-center gap-2 min-h-[40px]">
                    <span>✨</span>
                    <span>Simpan ke Jurnal</span>
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
