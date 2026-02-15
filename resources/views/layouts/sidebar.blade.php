<div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>

<aside :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-gray-900 lg:translate-x-0 lg:static lg:inset-0">
    
    <!-- Logo -->
    <div class="flex items-center justify-center h-16 bg-gray-900 border-b border-gray-800">
        <span class="text-white text-2xl font-semibold uppercase tracking-wider">{{ __('messages.admin_panel') }}</span>
    </div>

    <!-- Navigation -->
    <nav class="mt-5 px-4 space-y-2">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" 
           class="{{ request()->routeIs('dashboard') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} group flex items-center px-4 py-3 text-base font-medium rounded-md transition-colors duration-200">
            <svg class="mr-4 h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            {{ __('messages.dashboard') }}
        </a>

        <!-- Members Module -->
        <div x-data="{ open: {{ request()->routeIs('members.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="text-gray-400 hover:bg-gray-800 hover:text-white group w-full flex items-center justify-between px-4 py-3 text-base font-medium rounded-md transition-colors duration-200">
                <div class="flex items-center">
                    <svg class="mr-4 h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    {{ __('members.members') }}
                </div>
                <svg :class="{'rotate-90': open}" class="h-4 w-4 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
            <div x-show="open" x-collapse class="space-y-1 pl-12 pr-4 pb-2">
                <a href="{{ route('members.index') }}" class="{{ request()->routeIs('members.index') ? 'text-white' : 'text-gray-400 hover:text-white' }} block py-2 text-sm font-medium rounded-md">
                    {{ __('members.member_directory') }}
                </a>
                <a href="{{ route('members.tree') }}" class="{{ request()->routeIs('members.tree') ? 'text-white' : 'text-gray-400 hover:text-white' }} block py-2 text-sm font-medium rounded-md">
                    {{ __('members.family_tree') }}
                </a>
                <a href="{{ route('members.map') }}" class="{{ request()->routeIs('members.map') ? 'text-white' : 'text-gray-400 hover:text-white' }} block py-2 text-sm font-medium rounded-md">
                    {{ __('members.clan_map') ?? 'Clan Map' }}
                </a>
                <a href="{{ route('members.directory') }}" class="{{ request()->routeIs('members.directory') ? 'text-white' : 'text-gray-400 hover:text-white' }} block py-2 text-sm font-medium rounded-md">
                    {{ __('members.professional_directory') ?? 'Professional Directory' }}
                </a>
            </div>
        </div>

        <!-- Traditions -->
        <a href="{{ route('traditions.index') }}" 
           class="{{ request()->routeIs('traditions.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} group flex items-center px-4 py-3 text-base font-medium rounded-md transition-colors duration-200">
            <svg class="mr-4 h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            {{ __('traditions.traditions') }}
        </a>

        <!-- Events -->
        <a href="{{ route('events.index') }}" 
           class="{{ request()->routeIs('events.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} group flex items-center px-4 py-3 text-base font-medium rounded-md transition-colors duration-200">
            <svg class="mr-4 h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            {{ __('events.events') }}
        </a>
        
        <!-- Announcements -->
        <a href="{{ route('announcements.index') }}" 
           class="{{ request()->routeIs('announcements.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} group flex items-center px-4 py-3 text-base font-medium rounded-md transition-colors duration-200">
            <svg class="mr-4 h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
            </svg>
            {{ __('announcements.announcements') }}
        </a>

        <!-- Financials (Admin) -->
        @can('view contributions')
        <a href="{{ route('contributions.index') }}" 
           class="{{ request()->routeIs('contributions.index') || request()->routeIs('contributions.create') || request()->routeIs('contributions.show') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} group flex items-center px-4 py-3 text-base font-medium rounded-md transition-colors duration-200">
            <svg class="mr-4 h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ __('contributions.financial_records') }}
        </a>
        @endcan

        @auth
        <!-- My Contributions (Member) -->
        <a href="{{ route('contributions.my') }}" 
           class="{{ request()->routeIs('contributions.my') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} group flex items-center px-4 py-3 text-base font-medium rounded-md transition-colors duration-200">
            <svg class="mr-4 h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            {{ __('contributions.my_contributions') }}
        </a>
        @endauth

        <!-- Documents -->
        <a href="{{ route('documents.index') }}" 
           class="{{ request()->routeIs('documents.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} group flex items-center px-4 py-3 text-base font-medium rounded-md transition-colors duration-200">
            <svg class="mr-4 h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            {{ __('documents.documents') }}
        </a>


        @auth
        <!-- Messaging -->
        <a href="{{ route('messages.index') }}" 
           class="{{ request()->routeIs('messages.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} group flex items-center px-4 py-3 text-base font-medium rounded-md transition-colors duration-200">
            <svg class="mr-4 h-6 w-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
            {{ __('messages.messages') }}
        </a>

        <!-- Profile -->
        <a href="{{ route('profile.edit') }}" 
           class="{{ request()->routeIs('profile.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} group flex items-center px-4 py-3 text-base font-medium rounded-md transition-colors duration-200">
            <svg class="mr-4 h-6 w-6 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            {{ __('messages.profile') }}
        </a>
        @endauth

        @hasanyrole('super-admin|admin')
        <a href="{{ route('admin.activity-logs.index') }}" 
           class="{{ request()->routeIs('admin.activity-logs.index') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} group flex items-center px-4 py-3 text-base font-medium rounded-md transition-colors duration-200">
            <svg class="mr-4 h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            {{ __('messages.audit_logs') ?? 'Audit Logs' }}
        </a>
        @endhasanyrole

        @can('manage roles')
        <a href="{{ route('roles.index') }}" 
           class="{{ request()->routeIs('roles.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} group flex items-center px-4 py-3 text-base font-medium rounded-md transition-colors duration-200">
            <svg class="mr-4 h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            {{ __('messages.roles_permissions') }}
        </a>
        @endcan
    </nav>
</aside>
