<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Msomi Clan') }} - Forgot Password</title>

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

        <!-- Glass Card -->
        <div class="relative z-10 w-full max-w-md p-8 bg-white/10 border border-white/20 rounded-2xl shadow-2xl backdrop-blur-md">
            
            <!-- Logo Area -->
            <div class="flex flex-col items-center mb-6">
                <div class="w-16 h-16 bg-gradient-to-tr from-cyan-500 to-blue-600 rounded-full flex items-center justify-center shadow-lg mb-4 text-white text-2xl font-bold border-4 border-white/10">
                    M
                </div>
                <h2 class="text-xl font-bold text-white tracking-wider uppercase">Msomi Clan</h2>
            </div>

            <!-- Title -->
            <h3 class="text-2xl font-bold text-white text-center mb-4 tracking-wide">{{ __('Forgot Password') }}</h3>
            
            <div class="mb-6 text-sm text-gray-300 text-center leading-relaxed">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-cyan-300 text-sm font-medium" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div class="relative group">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                           class="peer block w-full py-3 pl-2 bg-transparent border-b-2 border-gray-500 text-white placeholder-transparent focus:outline-none focus:border-cyan-400 transition-colors" 
                           placeholder="Email Address" />
                    <label for="email" class="absolute left-0 -top-3.5 text-gray-400 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-cyan-400 peer-focus:text-sm">
                        {{ __('messages.email') }}
                    </label>
                    <!-- Icon -->
                    <div class="absolute right-0 top-3 text-gray-400 peer-focus:text-cyan-400 transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    @error('email')
                        <p class="mt-2 text-red-300 text-xs">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-white font-bold rounded-full shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 focus:ring-offset-gray-900 uppercase tracking-wider text-xs">
                        {{ __('Email Password Reset Link') }}
                    </button>
                </div>

                <!-- Back to Login -->
                <div class="text-center mt-6">
                    <a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition-colors text-sm flex items-center justify-center">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ __('Back to Login') }}
                    </a>
                </div>
            </form>
        </div>
        
        <!-- Footer -->
        <div class="absolute bottom-6 w-full text-center z-10">
            <p class="text-gray-500 text-xs uppercase tracking-widest opacity-70">&copy; {{ date('Y') }} Msomi Clan System</p>
        </div>
    </div>
</body>
</html>
