<!DOCTYPE html>
<html lang="id" class="h-full overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>@yield('title', 'Kota Klasik • Aesthetic Daily Planner')</title>

    <!-- Google Fonts: Fraunces (Chic Vintage Serif), Plus Jakarta Sans, Caveat (Aesthetic Handwritten) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@500;600;700&family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,400&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html, body {
            overflow-x: hidden;
            max-width: 100vw;
        }

        body {
            background-color: #faf7f2;
            background-image: radial-gradient(#e5ddd0 1.2px, transparent 1.2px);
            background-size: 24px 24px;
            font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: #382d27;
        }

        .font-aesthetic-title {
            font-family: 'Fraunces', Georgia, serif;
        }

        .font-aesthetic-hand {
            font-family: 'Caveat', cursive;
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col selection:bg-[#dfcbbe] selection:text-[#382d27] overflow-x-hidden w-full max-w-full">

    <!-- Aesthetic Header Bar (100% Mobile Responsive & Anti-Cutoff) -->
    <header class="sticky top-0 z-50 bg-[#faf7f2]/95 backdrop-blur-md border-b border-[#e8dfd3] shadow-[0_2px_15px_rgba(92,70,58,0.03)] w-full">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between gap-2 sm:gap-4 w-full">
            
            <!-- Brand Logo -->
            <a href="{{ route('todos.index') }}" class="flex items-center gap-2 sm:gap-2.5 min-w-0 group">
                <div class="w-9 h-9 rounded-xl bg-[#efe7dc] border border-[#dfd4c5] flex items-center justify-center text-lg shadow-2xs group-hover:scale-105 group-hover:bg-[#e8dec0] transition-transform shrink-0">
                    ☕
                </div>
                <div class="min-w-0">
                    <div class="flex items-center gap-1.5">
                        <span class="text-base sm:text-xl font-bold tracking-tight text-[#382d27] font-aesthetic-title group-hover:text-[#b85d38] transition-colors truncate">
                            KOTA KLASIK
                        </span>
                        <span class="text-[10px] px-1.5 py-0.5 rounded-full bg-[#f2e7db] text-[#8c6b58] font-semibold tracking-wide shrink-0">
                            Journal
                        </span>
                    </div>
                </div>
            </a>

            <!-- Right Controls: Date Pill & Quick Add Button -->
            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                <!-- Date Pill (Hidden on mobile, visible on desktop) -->
                <div class="hidden md:flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/90 border border-[#e8dfd3] text-xs font-medium text-[#6e5d53] shadow-2xs">
                    <span>🌿</span>
                    <span>{{ date('d M Y') }}</span>
                    <span class="text-[#c7b5a8]">•</span>
                    <span class="font-aesthetic-hand text-base text-[#b85d38] leading-none">stay chill ✨</span>
                </div>

                <!-- Add Button (Responsive size & touch-friendly) -->
                <a href="{{ route('todos.create') }}" 
                   class="inline-flex items-center gap-1 sm:gap-1.5 px-3.5 sm:px-5 py-2 sm:py-2.5 rounded-full bg-[#382d27] hover:bg-[#b85d38] text-[#faf7f2] font-semibold text-xs tracking-wide shadow-sm hover:shadow-md transition-all duration-200 active:scale-95 shrink-0">
                    <span class="text-base leading-none font-bold">+</span>
                    <span>Tulis</span>
                    <span class="hidden sm:inline">Agenda</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="max-w-5xl mx-auto w-full px-4 sm:px-6 py-5 sm:py-8 flex-1 min-w-0">
        <!-- Alert Success -->
        @if(session('success'))
        <div class="mb-5 sm:mb-6 p-3.5 sm:p-4 rounded-2xl bg-white border border-[#cbe1d3] shadow-xs flex items-center gap-3 text-[#2d6a4f] animate-fade-in w-full">
            <span class="text-xl shrink-0">✨</span>
            <div class="flex-1 min-w-0">
                <p class="text-[10px] sm:text-[11px] font-bold uppercase tracking-wider text-[#387a5c]">Catatan Tersimpan</p>
                <p class="text-xs sm:text-sm font-medium text-[#2d6a4f] break-words">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <!-- Alert Error -->
        @if(isset($errors) && $errors->any())
        <div class="mb-5 sm:mb-6 p-3.5 sm:p-4 rounded-2xl bg-white border border-[#f3cfc6] shadow-xs text-[#a64028] w-full">
            <strong class="flex items-center gap-2 font-semibold text-xs sm:text-sm mb-1.5">
                <span>💭</span> Periksa kembali data formulir:
            </strong>
            <ul class="list-disc ml-6 space-y-1 text-xs text-[#a64028]/90 font-medium">
                @foreach($errors->all() as $error)
                <li class="break-words">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @yield('content')
    </main>

    <!-- Aesthetic Minimalist Footer -->
    <footer class="mt-auto border-t border-[#e8dfd3] bg-[#faf7f2] text-[#8c7d75] py-6 sm:py-8 px-4 sm:px-6 text-xs text-center w-full">
        <div class="max-w-5xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 w-full">
            <div class="flex items-center gap-2 font-medium">
                <span>☕</span>
                <span class="font-aesthetic-title text-sm text-[#382d27]">Kota Klasik Journal</span>
            </div>
            <p class="font-aesthetic-hand text-base sm:text-lg text-[#8c6b58] break-words">
                "Satu per satu, nikmati prosesnya & semoga harimu menyenangkan ✨"
            </p>
            <p class="text-[11px] text-[#a89b91]">
                &copy; {{ date('Y') }} Daily Routine
            </p>
        </div>
    </footer>

</body>
</html>
