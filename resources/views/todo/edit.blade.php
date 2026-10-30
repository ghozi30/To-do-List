@extends('layouts.app')

@section('title', 'Perbarui Agenda • Kota Klasik')

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
                ✏️
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-[#382d27] font-aesthetic-title tracking-tight">
                    Perbarui Agenda
                </h1>
                <p class="text-[#8c7d75] text-xs sm:text-sm mt-0.5">
                    Ubah catatan atau ganti status pengerjaan agendamu.
                </p>
            </div>
        </div>

        <div class="w-full h-px bg-[#f0e6dc] my-4 sm:my-5"></div>

        <form action="{{ route('todos.update', $todo) }}" method="POST" class="space-y-4 sm:space-y-5">
            @csrf
            @method('PUT')

            <!-- Title Input -->
            <div class="space-y-1.5">
                <label for="title" class="block text-xs font-bold uppercase tracking-wider text-[#6e5d53]">
                    Judul Agenda <span class="text-[#c04b33]">*</span>
                </label>
                <input type="text" 
                       id="title"
                       name="title" 
                       value="{{ old('title', $todo->title) }}" 
                       required
                       class="w-full bg-[#fdfaf7] border border-[#e2d5c7] rounded-xl sm:rounded-2xl px-4 py-3 text-[#382d27] placeholder-[#a89b91] focus:outline-none focus:ring-2 focus:ring-[#b85d38]/30 focus:border-[#b85d38] transition-all text-base sm:text-sm font-medium shadow-2xs">
                @error('title')
                <p class="text-xs text-[#c04b33] mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description Textarea -->
            <div class="space-y-1.5">
                <label for="description" class="block text-xs font-bold uppercase tracking-wider text-[#6e5d53]">
                    Catatan & Detail Tambahan
                </label>
                <textarea id="description"
                          name="description" 
                          rows="4"
                          class="w-full bg-[#fdfaf7] border border-[#e2d5c7] rounded-xl sm:rounded-2xl px-4 py-3 text-[#382d27] placeholder-[#a89b91] focus:outline-none focus:ring-2 focus:ring-[#b85d38]/30 focus:border-[#b85d38] transition-all text-base sm:text-sm font-normal shadow-2xs">{{ old('description', $todo->description) }}</textarea>
                @error('description')
                <p class="text-xs text-[#c04b33] mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Completed Checkbox -->
            <input type="hidden" name="is_completed" value="0">
            <label class="flex items-center gap-3 sm:gap-3.5 p-3.5 sm:p-4 rounded-xl sm:rounded-2xl cursor-pointer transition-colors border @if($todo->is_completed) bg-[#eef6f1] border-[#cbe1d3] @else bg-[#fbf7f2] border-[#ebdcd0] hover:bg-[#f6eee3] @endif">
                <input type="checkbox" 
                       name="is_completed" 
                       value="1" 
                       @checked(old('is_completed', $todo->is_completed))
                       class="w-5 h-5 rounded-lg border-[#cfc0b2] text-[#2d6a4f] focus:ring-[#2d6a4f]/30 cursor-pointer shrink-0">
                <div>
                    <span class="text-xs sm:text-sm font-semibold text-[#382d27] block">
                        Tandai agenda ini sudah selesai ✨
                    </span>
                    <span class="text-[11px] text-[#8c7d75]">
                        Centang kotak ini jika seluruh kegiatan dalam catatan ini telah rampung.
                    </span>
                </div>
            </label>

            <!-- Buttons (Responsive stack on small mobile, row on tablet+) -->
            <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-2.5 sm:gap-3 pt-3">
                <a href="{{ route('todos.index') }}" 
                   class="px-5 py-2.5 sm:py-2.5 rounded-full text-xs font-semibold text-[#6e5d53] hover:text-[#382d27] hover:bg-[#f2e7db] transition-all text-center border border-[#e5d8cb] sm:border-transparent min-h-[40px] flex items-center justify-center">
                    Batal
                </a>

                <button type="submit" 
                        class="px-6 py-2.5 sm:py-2.5 rounded-full bg-[#382d27] hover:bg-[#b85d38] text-white font-semibold text-xs tracking-wide shadow-sm hover:shadow-md transition-all duration-200 active:scale-95 cursor-pointer flex items-center justify-center gap-2 min-h-[40px]">
                    <span>💾</span>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
