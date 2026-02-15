<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .auth-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 auth-gradient">
        <!-- Logo/Header -->
        <div class="mb-6">
            <a href="/">
                <h1 class="text-4xl font-bold text-white">{{ config('app.name') }}</h1>
            </a>
        </div>

        <!-- Language Switcher -->
        <div class="mb-4 flex space-x-2">
            <a href="{{ route('language.switch', 'sw') }}" 
               class="px-4 py-2 rounded-lg {{ app()->getLocale() == 'sw' ? 'bg-white text-purple-600' : 'bg-purple-500 bg-opacity-30 text-white hover:bg-opacity-50' }} transition">
                Kiswahili
            </a>
            <a href="{{ route('language.switch', 'en') }}" 
               class="px-4 py-2 rounded-lg {{ app()->getLocale() == 'en' ? 'bg-white text-purple-600' : 'bg-purple-500 bg-opacity-30 text-white hover:bg-opacity-50' }} transition">
                English
            </a>
        </div>

        <!-- Auth Card -->
        <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-2xl overflow-hidden sm:rounded-2xl">
            {{ $slot }}
        </div>

        <!-- Footer Link -->
        <div class="mt-6 text-center">
            <a href="{{ route('home') }}" class="text-white hover:text-purple-100 transition">
                ← {{ __('messages.back') }} {{ __('messages.home') }}
            </a>
        </div>
    </div>
</body>
</html>
