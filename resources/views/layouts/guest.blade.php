<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://kit.fontawesome.com/593edd7fd9.js" crossorigin="anonymous"></script>

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="moving-background">
            <div class="cloud" style="top: 50px; animation-duration: 12s;"></div>
            <div class="cloud" style="top: 200px; animation-duration: 15s;"></div>
            <div class="cloud" style="top: 350px; animation-duration: 18s;"></div>
        </div>
        <div class="balloon-container">
            @for ($i = 0; $i < 10; $i++)
                <div class="balloon" style="left: {{ rand(0, 100) }}%; animation-duration: {{ rand(10, 20) }}s; background-color: {{ sprintf('#%06X', mt_rand(0, 0xFFFFFF)) }};"></div>
            @endfor
        </div>
        @for ($i = 0; $i < 5; $i++)
            <div class="bird-container" style="top: {{ rand(10, 80) }}%; animation-duration: {{ rand(8, 15) }}s; animation-delay: -{{ rand(0, 10) }}s;">
                <div class="bird"></div>
            </div>
        @endfor


        <x-banner />

        <div class="bg-transparent">

            <!-- Page Content -->
            <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 md:mt-0 mt-16 bg-transparent">
                {{ $slot }}
            </main>
        </div>


        @livewireScripts
    </body>
</html>
