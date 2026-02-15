<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Msomi Clan') }} - {{ __('auth.login_title') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts (Using CDN for Glassmorphism reliability) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="antialiased">
    <!-- Background Image with Overlay -->
    <div class="relative min-h-screen flex items-center justify-center bg-gray-900 bg-[url('/images/login-bg.jpg')] bg-cover bg-center">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

        <!-- Language Switcher (Top Right) -->
        <div class="absolute top-6 right-6 z-20 flex space-x-4">
            <a href="{{ route('language.switch', 'sw') }}" class="text-sm font-medium {{ app()->getLocale() == 'sw' ? 'text-white border-b-2 border-cyan-400' : 'text-gray-400 hover:text-white' }} transition-colors">KISWAHILI</a>
            <a href="{{ route('language.switch', 'en') }}" class="text-sm font-medium {{ app()->getLocale() == 'en' ? 'text-white border-b-2 border-cyan-400' : 'text-gray-400 hover:text-white' }} transition-colors">ENGLISH</a>
        </div>

        <!-- Glass Card -->
        <div class="relative z-10 w-full max-w-md p-8 bg-white/10 border border-white/20 rounded-2xl shadow-2xl backdrop-blur-md">
            
            <!-- Logo Area -->
            <div class="flex flex-col items-center mb-8">
                <div class="w-20 h-20 bg-gradient-to-tr from-cyan-500 to-blue-600 rounded-full flex items-center justify-center shadow-lg mb-4 text-white text-3xl font-bold border-4 border-white/10">
                    M
                </div>
                <h2 class="text-2xl font-bold text-white tracking-wider uppercase">{{ config('app.name') }}</h2>
                <p class="text-cyan-200 text-xs tracking-widest uppercase mt-1">{{ __('auth.management_portal') }}</p>
            </div>

            <!-- Title -->
            <h3 class="text-3xl font-bold text-white text-center mb-8 tracking-wide uppercase">{{ __('auth.login_title') }}</h3>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div class="relative group">
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                           class="peer block w-full py-3 pl-2 bg-transparent border-b-2 border-gray-500 text-white placeholder-transparent focus:outline-none focus:border-cyan-400 transition-colors" 
                           placeholder="{{ __('auth.email_address') }}" />
                    <label for="email" class="absolute left-0 -top-3.5 text-gray-400 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-cyan-400 peer-focus:text-sm">
                        {{ __('auth.email_address') }}
                    </label>
                    <!-- Icon -->
                    <div class="absolute right-0 top-3 text-gray-400 peer-focus:text-cyan-400 transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300 text-xs" />
                </div>

                <!-- Password -->
                <div class="relative group mt-6">
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                           class="peer block w-full py-3 pl-2 bg-transparent border-b-2 border-gray-500 text-white placeholder-transparent focus:outline-none focus:border-cyan-400 transition-colors" 
                           placeholder="{{ __('auth.password_field') }}" />
                    <label for="password" class="absolute left-0 -top-3.5 text-gray-400 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-cyan-400 peer-focus:text-sm">
                        {{ __('auth.password_field') }}
                    </label>
                    <!-- Icon -->
                    <div class="absolute right-0 top-3 text-gray-400 peer-focus:text-cyan-400 transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300 text-xs" />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between text-sm">
                    <label for="remember_me" class="inline-flex items-center text-gray-300 hover:text-white cursor-pointer select-none">
                        <input id="remember_me" type="checkbox" class="rounded bg-white/10 border-gray-500 text-cyan-500 shadow-sm focus:ring-cyan-500 focus:ring-offset-gray-900" name="remember">
                        <span class="ml-2">{{ __('auth.remember_me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-cyan-300 hover:text-white transition-colors" href="{{ route('password.request') }}">
                            {{ __('auth.forgot_password') }}
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <div>
                    <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-white font-bold rounded-full shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 focus:ring-offset-gray-900 uppercase tracking-wider">
                        {{ __('auth.login') }}
                    </button>
                </div>

                <!-- Register Link -->
                <div class="text-center mt-6">
                    <p class="text-gray-400 text-sm">
                        {{ __("auth.dont_have_account") }}
                        <a href="{{ route('register') }}" class="text-white hover:text-cyan-300 font-semibold transition-colors ml-1">
                            {{ __('auth.register') }}
                        </a>
                    </p>
                </div>
            </form>
        </div>
        
        <!-- Footer -->
        <div class="absolute bottom-6 w-full text-center z-10">
            <p class="text-gray-500 text-xs uppercase tracking-widest opacity-70">&copy; {{ date('Y') }} {{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>
