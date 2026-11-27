<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="{{ asset('images/logoo.jpg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex">
            
            <!-- KOLOM KIRI: Video & Teks (Hanya tampil di Laptop/Desktop) -->
            <div class="hidden lg:flex lg:w-1/2 relative bg-gray-900 justify-center items-center overflow-hidden">
                <!-- Video -->
                <video autoplay loop muted playsinline class="absolute inset-0 w-full h-full object-cover opacity-50">
                    <source src="{{ asset('images/login-video.mp4') }}" type="video/mp4">
                </video>
                
                <!-- Teks di atas video -->
                <div class="relative z-10 text-center px-8">
                    <h1 class="text-4xl font-bold text-white mb-4">Sistem Inventaris Sekolah</h1>
                    <p class="text-lg text-gray-200">Kelola peminjaman barang sekolah dengan lebih mudah, rapi, dan terorganisir.</p>
                </div>
            </div>

            <!-- KOLOM KANAN: Form Login/Register -->
            <div class="w-full lg:w-1/2 flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-indigo-400">
                
                <!-- Kotak Putih Form -->
                <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-xl overflow-hidden sm:rounded-xl border border-gray-100">
                    
                    <!-- Logo di dalam form (Muncul di HP & Laptop) -->
                    <div class="flex justify-center mb-6">
                        <a href="/">
                          <img src="{{ asset('images/log-reg.jpg') }}" alt="Logo Inventaris" class="h-24 w-auto object-contain">
                        </a>
                    </div>
                    
                    {{ $slot }}
                </div>
            </div>

        </div>
    </body>
</html>