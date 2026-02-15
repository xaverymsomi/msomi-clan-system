<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Msomi Clan') }} - {{ __('auth.register_title') }}</title>

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
    <div class="relative min-h-screen flex items-center justify-center bg-gray-900 bg-[url('/images/login-bg.jpg')] bg-cover bg-center py-12">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

        <!-- Language Switcher (Top Right) -->
        <div class="absolute top-6 right-6 z-20 flex space-x-4">
            <a href="{{ route('language.switch', 'sw') }}" class="text-sm font-medium {{ app()->getLocale() == 'sw' ? 'text-white border-b-2 border-cyan-400' : 'text-gray-400 hover:text-white' }} transition-colors">KISWAHILI</a>
            <a href="{{ route('language.switch', 'en') }}" class="text-sm font-medium {{ app()->getLocale() == 'en' ? 'text-white border-b-2 border-cyan-400' : 'text-gray-400 hover:text-white' }} transition-colors">ENGLISH</a>
        </div>

        <!-- Glass Card -->
        <div class="relative z-10 w-full max-w-md p-8 bg-white/10 border border-white/20 rounded-2xl shadow-2xl backdrop-blur-md">
            
            <!-- Logo Area -->
            <div class="flex flex-col items-center mb-6">
                <div class="w-16 h-16 bg-gradient-to-tr from-cyan-500 to-blue-600 rounded-full flex items-center justify-center shadow-lg mb-4 text-white text-2xl font-bold border-4 border-white/10">
                    M
                </div>
                <h2 class="text-xl font-bold text-white tracking-wider uppercase">{{ config('app.name') }}</h2>
                <p class="text-cyan-200 text-xs tracking-widest uppercase mt-1">{{ __('auth.join_portal') }}</p>
            </div>

            <!-- Title -->
            <h3 class="text-2xl font-bold text-white text-center mb-6 tracking-wide uppercase">{{ __('auth.register_title') }}</h3>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Name -->
                <div class="relative group">
                    <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                           class="peer block w-full py-3 pl-2 bg-transparent border-b-2 border-gray-500 text-white placeholder-transparent focus:outline-none focus:border-cyan-400 transition-colors" 
                           placeholder="{{ __('auth.full_name') }}" />
                    <label for="name" class="absolute left-0 -top-3.5 text-gray-400 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-cyan-400 peer-focus:text-sm">
                        {{ __('auth.full_name') }}
                    </label>
                    <!-- Icon -->
                    <div class="absolute right-0 top-3 text-gray-400 peer-focus:text-cyan-400 transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-300 text-xs" />
                </div>

                <!-- Email Address -->
                <div class="relative group mt-5">
                    <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                           class="peer block w-full py-3 pl-2 bg-transparent border-b-2 border-gray-500 text-white placeholder-transparent focus:outline-none focus:border-cyan-400 transition-colors" 
                           placeholder="{{ __('auth.email_address') }}" />
                    <label for="email" class="absolute left-0 -top-3.5 text-gray-400 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-cyan-400 peer-focus:text-sm">
                        {{ __('auth.email_address') }}
                    </label>
                    <!-- Icon -->
                    <div class="absolute right-0 top-3 text-gray-400 peer-focus:text-cyan-400 transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300 text-xs" />
                </div>

                <!-- Phone (Optional) -->
                <div class="relative group mt-5">
                    <input id="phone" type="text" name="phone" :value="old('phone')" autocomplete="tel"
                           class="peer block w-full py-3 pl-2 bg-transparent border-b-2 border-gray-500 text-white placeholder-transparent focus:outline-none focus:border-cyan-400 transition-colors" 
                           placeholder="{{ __('auth.phone_optional') }}" />
                    <label for="phone" class="absolute left-0 -top-3.5 text-gray-400 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-cyan-400 peer-focus:text-sm">
                        {{ __('auth.phone_optional') }}
                    </label>
                    <!-- Icon -->
                    <div class="absolute right-0 top-3 text-gray-400 peer-focus:text-cyan-400 transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <x-input-error :messages="$errors->get('phone')" class="mt-2 text-red-300 text-xs" />
                </div>

                <!-- Password -->
                <div class="relative group mt-5">
                    <input id="password" type="password" name="password" required autocomplete="new-password"
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

                <!-- Confirm Password -->
                <div class="relative group mt-5">
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                           class="peer block w-full py-3 pl-2 bg-transparent border-b-2 border-gray-500 text-white placeholder-transparent focus:outline-none focus:border-cyan-400 transition-colors" 
                           placeholder="{{ __('auth.confirm_password') }}" />
                    <label for="password_confirmation" class="absolute left-0 -top-3.5 text-gray-400 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-cyan-400 peer-focus:text-sm">
                        {{ __('auth.confirm_password') }}
                    </label>
                    <div class="absolute right-0 top-3 text-gray-400 peer-focus:text-cyan-400 transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-300 text-xs" />
                </div>


                <!-- Register Button -->
                <div class="mt-8">
                    <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-white font-bold rounded-full shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 focus:ring-offset-gray-900 uppercase tracking-wider">
                        {{ __('auth.register') }}
                    </button>
                </div>

                <!-- Login Link -->
                <div class="text-center mt-6">
                    <p class="text-gray-400 text-sm">
                        {{ __("auth.already_have_account") }}
                        <a href="{{ route('login') }}" class="text-white hover:text-cyan-300 font-semibold transition-colors ml-1">
                            {{ __('auth.login') }}
                        </a>
                    </p>
                </div>
            </form>
        </div>
        
        <!-- Footer -->
        <div class="absolute bottom-4 w-full text-center z-10">
            <p class="text-gray-500 text-xs uppercase tracking-widest opacity-70">&copy; {{ date('Y') }} {{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>
