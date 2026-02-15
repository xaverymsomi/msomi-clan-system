<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Msomi Clan') }} - Reset Password</title>

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
            <h3 class="text-2xl font-bold text-white text-center mb-8 tracking-wide uppercase">{{ __('Reset Password') }}</h3>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div class="relative group">
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus 
                           class="peer block w-full py-3 pl-2 bg-transparent border-b-2 border-gray-500 text-white placeholder-transparent focus:outline-none focus:border-cyan-400 transition-colors" 
                           placeholder="Email Address" />
                    <label for="email" class="absolute left-0 -top-3.5 text-gray-400 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-cyan-400 peer-focus:text-sm">
                        {{ __('messages.email') }}
                    </label>
                    <div class="absolute right-0 top-3 text-gray-400 peer-focus:text-cyan-400 transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    @error('email')
                        <p class="mt-2 text-red-300 text-xs">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="relative group">
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           class="peer block w-full py-3 pl-2 bg-transparent border-b-2 border-gray-500 text-white placeholder-transparent focus:outline-none focus:border-cyan-400 transition-colors" 
                           placeholder="New Password" />
                    <label for="password" class="absolute left-0 -top-3.5 text-gray-400 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-cyan-400 peer-focus:text-sm">
                        {{ __('profile.new_password') }}
                    </label>
                    <div class="absolute right-0 top-3 text-gray-400 peer-focus:text-cyan-400 transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    @error('password')
                        <p class="mt-2 text-red-300 text-xs">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="relative group">
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                           class="peer block w-full py-3 pl-2 bg-transparent border-b-2 border-gray-500 text-white placeholder-transparent focus:outline-none focus:border-cyan-400 transition-colors" 
                           placeholder="Confirm Password" />
                    <label for="password_confirmation" class="absolute left-0 -top-3.5 text-gray-400 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-cyan-400 peer-focus:text-sm">
                        {{ __('profile.confirm_password') }}
                    </label>
                    <div class="absolute right-0 top-3 text-gray-400 peer-focus:text-cyan-400 transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 21.248a11.955 11.955 0 01-9.618-7.264l1.812-.453a10 10 0 0015.612 0l1.812.453z" />
                        </svg>
                    </div>
                    @error('password_confirmation')
                        <p class="mt-2 text-red-300 text-xs">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-white font-bold rounded-full shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 focus:ring-offset-gray-900 uppercase tracking-wider text-xs">
                        {{ __('Reset Password') }}
                    </button>
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
