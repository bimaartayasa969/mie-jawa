<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mie Jawa Masak Anglo Arang - Kenikmatan Tradisional Autentik')</title>
    <meta name="description" content="@yield('description', 'Warung kuliner Mie Jawa bercita rasa autentik khas wajan anglo arang di Pontianak. Kaldu ayam kampung gurih, bumbu rempah ulekan segar.')">
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FFF8EE] text-[#2B1B10] font-sans antialiased min-h-screen flex flex-col selection:bg-[#B3281A] selection:text-white">

    <!-- Komponen Navbar Publik -->
    <x-navbar />

    <!-- Area Konten Utama -->
    <main class="flex-1">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
            <x-alert />
        </div>
        @yield('content')
    </main>

    <!-- Komponen Footer Publik -->
    <x-footer />

</body>
</html>

