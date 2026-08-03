<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F3F3F3]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'HOT STRAP - Lanyard & ID Card' }}</title>
    
    <!-- Google Fonts: IBM Plex Sans Thai & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@300;400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Font Awesome 6 Free -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'IBM Plex Sans Thai', 'Inter', sans-serif;
            background-color: #F3F3F3;
            color: #000000;
        }
        .scrollbar-none::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-none {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    @stack('styles')
</head>
<body class="min-h-full flex flex-col justify-between text-black bg-[#F3F3F3] antialiased selection:bg-[#122244] selection:text-white">
    
    <!-- 1. Global Header Component -->
    <x-header />

    <!-- Main Page Content Slot -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- 2. Global Footer Component -->
    <x-footer />

    <!-- 4. Global Floating Contact Bar Component -->
    <x-floating-contact />

    @stack('scripts')
</body>
</html>
