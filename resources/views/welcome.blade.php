<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - {{ __('messages.welcome') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Scripts (Using CDN for Glassmorphism reliability) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="antialiased font-sans text-gray-900">
    
    <!-- Hero Section with Navigation -->
    <div class="relative min-h-screen flex flex-col bg-gray-900 bg-[url('/images/login-bg.jpg')] bg-cover bg-center">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

        <!-- Navigation -->
        <nav class="relative z-20 px-6 py-4">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-tr from-cyan-500 to-blue-600 rounded-full flex items-center justify-center shadow-lg text-white font-bold border-2 border-white/20 mr-3">
                        M
                    </div>
                    <h1 class="text-xl font-bold text-white tracking-wider uppercase">{{ config('app.name') }}</h1>
                </div>
                
                <div class="hidden md:flex items-center space-x-6">
                    <!-- Language Switcher -->
                    <div class="flex space-x-4 border-r border-white/20 pr-6">
                        <a href="{{ route('language.switch', 'sw') }}" 
                           class="text-sm font-medium {{ app()->getLocale() == 'sw' ? 'text-cyan-400' : 'text-gray-300 hover:text-white' }} transition-colors">
                            KISWAHILI
                        </a>
                        <a href="{{ route('language.switch', 'en') }}" 
                           class="text-sm font-medium {{ app()->getLocale() == 'en' ? 'text-cyan-400' : 'text-gray-300 hover:text-white' }} transition-colors">
                            ENGLISH
                        </a>
                    </div>
                    
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-white hover:text-cyan-400 font-medium transition-colors">
                            {{ __('messages.dashboard') }}
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-white hover:text-cyan-400 font-medium transition-colors">
                            {{ __('auth.login') }}
                        </a>
                        <a href="{{ route('register') }}" class="bg-cyan-500 hover:bg-cyan-400 text-white px-5 py-2 rounded-full font-medium transition-colors shadow-lg shadow-cyan-500/30">
                            {{ __('auth.register') }}
                        </a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Hero Content -->
        <div class="relative z-10 flex-1 flex flex-col items-center justify-center text-center px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <span class="inline-block py-1 px-3 rounded-full bg-white/10 border border-white/20 text-cyan-300 text-sm font-semibold mb-6 backdrop-blur-md uppercase tracking-wider">
                    {{ __('messages.welcome') }}
                </span>
                <h2 class="text-5xl md:text-7xl font-bold text-white mb-6 tracking-tight leading-tight">
                    {!! __('welcome.preserving_legacy') !!}
                </h2>
                <p class="text-xl md:text-2xl text-gray-300 mb-10 max-w-2xl mx-auto leading-relaxed">
                    {{ __('welcome.hero_desc') }}
                </p>
                
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('traditions.index') }}" class="w-full sm:w-auto px-8 py-3 bg-white text-gray-900 font-bold rounded-full hover:bg-gray-100 transition-colors shadow-lg">
                        {{ __('welcome.explore_traditions') }}
                    </a>
                    <a href="{{ route('events.index') }}" class="w-full sm:w-auto px-8 py-3 bg-transparent border-2 border-white/30 text-white font-bold rounded-full hover:bg-white/10 transition-colors backdrop-blur-sm">
                        {{ __('welcome.upcoming_events') }}
                    </a>
                </div>
            </div>

            <!-- Stats Ribbon -->
            <div class="mt-20 grid grid-cols-3 gap-8 md:gap-16 border-t border-white/10 pt-8">
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-white mb-1">{{ $stats['total_members'] }}+</div>
                    <div class="text-xs md:text-sm text-cyan-400 uppercase tracking-widest">{{ __('members.members') }}</div>
                </div>
                <div class="text-center border-l border-white/10 pl-8 md:pl-16">
                    <div class="text-3xl md:text-4xl font-bold text-white mb-1">{{ $stats['total_traditions'] }}+</div>
                    <div class="text-xs md:text-sm text-cyan-400 uppercase tracking-widest">{{ __('traditions.traditions') }}</div>
                </div>
                <div class="text-center border-l border-white/10 pl-8 md:pl-16">
                    <div class="text-3xl md:text-4xl font-bold text-white mb-1">{{ $stats['upcoming_events'] }}</div>
                    <div class="text-xs md:text-sm text-cyan-400 uppercase tracking-widest">{{ __('events.events') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Traditions -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex justify-between items-center mb-8">
            <h3 class="text-3xl font-bold text-gray-900">{{ __('traditions.traditions') }}</h3>
            <a href="{{ route('traditions.index') }}" class="text-purple-600 hover:text-purple-700 font-medium">
                {{ __('messages.view') }} {{ __('messages.all') }} →
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($traditions as $tradition)
                <a href="{{ route('traditions.show', $tradition) }}" class="card-hover bg-white rounded-lg shadow-md overflow-hidden">
                    @if($tradition->featured_image)
                        <img src="{{ Storage::url($tradition->featured_image) }}" alt="{{ $tradition->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-purple-400 to-indigo-600"></div>
                    @endif
                    <div class="p-6">
                        <h4 class="text-xl font-semibold text-gray-900 mb-2">{{ $tradition->title }}</h4>
                        <p class="text-gray-600 line-clamp-3">{{ Str::limit($tradition->description, 120) }}</p>
                        <div class="mt-4 flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            {{ $tradition->views_count }} {{ __('traditions.views') }}
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-3 text-center py-12 text-gray-500">
                    {{ __('traditions.no_traditions') }}
                </div>
            @endforelse
        </div>
    </div>

    <!-- Upcoming Events -->
    <div class="bg-gray-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-3xl font-bold text-gray-900">{{ __('events.upcoming_events') }}</h3>
                <a href="{{ route('events.index') }}" class="text-purple-600 hover:text-purple-700 font-medium">
                    {{ __('messages.view') }} {{ __('messages.all') }} →
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($events as $event)
                    <div class="bg-white rounded-lg shadow-md p-6 card-hover">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="bg-purple-100 rounded-lg p-3 text-center">
                                    <div class="text-2xl font-bold text-purple-600">{{ $event->start_date->format('d') }}</div>
                                    <div class="text-sm text-purple-600">{{ $event->start_date->format('M') }}</div>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <h4 class="text-xl font-semibold text-gray-900 mb-2">{{ $event->title }}</h4>
                                <p class="text-gray-600 mb-3">{{ Str::limit($event->description, 100) }}</p>
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $event->location }}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 text-center py-12 text-gray-500">
                        {{ __('events.no_events') }}
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h4 class="text-xl font-bold mb-4">{{ config('app.name') }}</h4>
                    <p class="text-gray-400">
                        {{ __('welcome.mission_statement') }}
                    </p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">{{ __('messages.quick_links') }}</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('traditions.index') }}" class="hover:text-white">{{ __('traditions.traditions') }}</a></li>
                        <li><a href="{{ route('events.index') }}" class="hover:text-white">{{ __('events.events') }}</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white">{{ __('auth.login') }}</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">{{ __('messages.contact') }}</h4>
                    <p class="text-gray-400">
                        {{ __('welcome.contact_us_desc') }}
                    </p>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('messages.all_rights_reserved') }}</p>
            </div>
        </div>
    </footer>
</body>
</html>
