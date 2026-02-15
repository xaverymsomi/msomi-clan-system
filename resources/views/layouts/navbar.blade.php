<header class="flex justify-between items-center py-4 px-6 bg-white border-b border-gray-200">
    <div class="flex items-center">
        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>

        <div class="relative mx-4 lg:mx-0 flex items-center">
            <span class="text-gray-800 text-lg font-semibold ml-4">
                @yield('header')
            </span>

            <form action="{{ route('search.global') }}" method="GET" class="hidden md:flex relative ml-8">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none">
                        <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <input name="q" class="w-64 pl-10 pr-4 py-1.5 text-sm text-gray-700 bg-gray-100 border-transparent focus:bg-white focus:border-indigo-600 rounded-md focus:outline-none focus:ring-0 transition-colors" type="text" placeholder="{{ __('messages.search_placeholder') ?? 'Search everything...' }}">
            </form>
        </div>
    </div>

    <div class="flex items-center">
        @auth
        <!-- Notifications Dropdown -->
        <div x-data="{ notificationOpen: false, unreadCount: 0 }" x-init="
            fetch('{{ route('notifications.unread-count') }}')
                .then(res => res.json())
                .then(data => unreadCount = data.count)
        " class="relative">
            <button @click="notificationOpen = !notificationOpen" class="relative flex mx-4 text-gray-600 hover:text-gray-800 focus:outline-none">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 17H20L18.5951 15.5951C18.2141 15.2141 18 14.6973 18 14.1585V11C18 8.38757 16.3304 6.16509 14 5.34142V5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5V5.34142C7.66962 6.16509 6 8.38757 6 11V14.1585C6 14.6973 5.78595 15.2141 5.40493 15.5951L4 17H9M15 17V18C15 19.6569 13.6569 21 12 21C10.3431 21 9 19.6569 9 18V17M15 17H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span x-show="unreadCount > 0" x-text="unreadCount" class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full min-w-[20px]" style="display: none;"></span>
            </button>

            <div x-show="notificationOpen" @click="notificationOpen = false" class="fixed inset-0 h-full w-full z-10" style="display: none;"></div>

            <div x-show="notificationOpen" class="absolute right-0 mt-2 w-80 bg-white rounded-md overflow-hidden shadow-xl z-20 max-h-96 overflow-y-auto" style="display: none;">
                <div class="py-2 px-4 bg-gray-50 border-b flex justify-between items-center">
                    <span class="font-semibold text-gray-800">{{ __('notifications.notifications') }}</span>
                    <a href="{{ route('notifications.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800">{{ __('messages.view_all') }}</a>
                </div>
                @php
                    $recentNotifications = App\Models\Notification::where('user_id', auth()->id())->latest()->take(5)->get();
                @endphp
                @forelse($recentNotifications as $notification)
                    <a href="{{ $notification->getUrl() ?? route('notifications.index') }}" class="block px-4 py-3 text-sm hover:bg-gray-50 border-b {{ $notification->isRead() ? '' : 'bg-blue-50' }}">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 {{ $notification->getIconColor() }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="font-medium text-gray-900">{{ Str::limit($notification->title, 40) }}</p>
                                <p class="text-xs text-gray-600 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="px-4 py-6 text-center text-gray-500 text-sm">
                        {{ __('notifications.no_notifications') }}
                    </div>
                @endforelse
            </div>
        </div>
        @endauth

        @auth
        <!-- Profile Dropdown -->
        <div x-data="{ dropdownOpen: false }" class="relative flex items-center">
            
            <div class="hidden md:block text-right mr-3">
                <span class="block text-sm font-medium text-gray-900">{{ Auth::user()->name }}</span>
                <span class="block text-xs text-gray-500">{{ __('messages.role_' . Str::slug(Auth::user()->getRoleNames()->first() ?? 'Member', '_')) }}</span>
            </div>

            <button @click="dropdownOpen = !dropdownOpen" class="relative block h-10 w-10 rounded-full overflow-hidden shadow focus:outline-none flex-shrink-0 border-2 border-gray-200">
                @if(Auth::user()->avatar)
                    <img class="h-full w-full object-cover" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
                @else
                    <div class="h-full w-full bg-purple-600 flex items-center justify-center text-white font-bold text-lg">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                @endif
            </button>

            <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10" style="display: none;"></div>

            <div x-show="dropdownOpen" class="absolute right-0 mt-12 w-48 bg-white rounded-md overflow-hidden shadow-xl z-20" style="display: none;">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-600 hover:text-white">{{ __('messages.profile') }}</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-600 hover:text-white">{{ __('auth.logout') }}</a>
                </form>
            </div>
        </div>
        @else
        <div class="flex items-center space-x-4">
            <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 font-medium transition-colors">
                {{ __('auth.login') }}
            </a>
            <a href="{{ route('register') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md font-medium transition-colors shadow-sm">
                {{ __('auth.register') }}
            </a>
        </div>
        @endauth
    </div>
</header>
