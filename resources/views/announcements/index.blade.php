@extends('layouts.admin')

@section('header')
    {{ __('announcements.announcements') }}
@endsection

@section('content')
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
        <div>
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                {{ __('announcements.news_feed') }}
            </h2>
        </div>
        @can('create', App\Models\Announcement::class)
        <div class="mt-4 flex md:mt-0 md:ml-4">
            <a href="{{ route('announcements.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                {{ __('announcements.create_announcement') }}
            </a>
        </div>
        @endcan
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <form action="{{ route('announcements.index') }}" method="GET" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">{{ __('announcements.category') }}</label>
                <select name="category" id="category" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">{{ __('announcements.all_categories') }}</option>
                    <option value="general" {{ request('category') == 'general' ? 'selected' : '' }}>{{ __('announcements.general') }}</option>
                    <option value="urgent" {{ request('category') == 'urgent' ? 'selected' : '' }}>{{ __('announcements.urgent') }}</option>
                    <option value="event" {{ request('category') == 'event' ? 'selected' : '' }}>{{ __('announcements.event') }}</option>
                    <option value="financial" {{ request('category') == 'financial' ? 'selected' : '' }}>{{ __('announcements.financial') }}</option>
                </select>
            </div>
            <div class="flex-1 min-w-[200px]">
                <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">{{ __('announcements.priority') }}</label>
                <select name="priority" id="priority" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">{{ __('announcements.all_priorities') }}</option>
                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>{{ __('announcements.high') }}</option>
                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>{{ __('announcements.medium') }}</option>
                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>{{ __('announcements.low') }}</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-6 rounded-md text-sm">
                    {{ __('messages.filter') }}
                </button>
            </div>
        </form>
    </div>

    <!-- Urgent Announcements (Pinned) -->
    @if($urgentAnnouncements->count() > 0)
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                <svg class="h-5 w-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                {{ __('announcements.urgent_announcements') }}
            </h3>
            @foreach($urgentAnnouncements as $announcement)
                <div class="bg-red-50 border-l-4 border-red-500 rounded-lg shadow p-6 mb-3">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h4 class="text-lg font-bold text-gray-900 mb-2">{{ $announcement->title }}</h4>
                            <p class="text-gray-700 mb-3">{{ $announcement->getExcerpt(200) }}</p>
                            <div class="flex items-center gap-3 text-sm text-gray-600">
                                <span>{{ $announcement->creator->name ?? 'System' }}</span>
                                <span>•</span>
                                <span>{{ $announcement->published_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <a href="{{ route('announcements.show', $announcement) }}" class="ml-4 text-red-600 hover:text-red-800 font-medium">
                            {{ __('messages.read_more') }} →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Regular Announcements Timeline -->
    <div class="space-y-6">
        @forelse($announcements as $announcement)
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow overflow-hidden">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $announcement->getCategoryBadgeClass() }}">
                                    {{ __('announcements.' . $announcement->category) }}
                                </span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $announcement->getPriorityBadgeClass() }}">
                                    {{ __('announcements.' . $announcement->priority) }}
                                </span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">{{ $announcement->title }}</h3>
                        </div>
                        @can('update', $announcement)
                            <a href="{{ route('announcements.edit', $announcement) }}" class="text-gray-400 hover:text-gray-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                        @endcan
                    </div>

                    <!-- Content -->
                    <p class="text-gray-700 mb-4">{{ $announcement->getExcerpt() }}</p>

                    <!-- Footer -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <span class="flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ $announcement->creator->name ?? 'System' }}
                            </span>
                            <span>•</span>
                            <span>{{ $announcement->published_at->format('d M Y') }}</span>
                            <span>•</span>
                            <span class="flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                {{ $announcement->allComments->count() }}
                            </span>
                        </div>
                        <a href="{{ route('announcements.show', $announcement) }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                            {{ __('messages.read_more') }} →
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('announcements.no_announcements') }}</h3>
                <p class="mt-1 text-sm text-gray-500">{{ __('announcements.no_announcements_message') }}</p>
            </div>
        @endforelse
    </div>

    @if($announcements->hasPages())
        <div class="mt-6">
            {{ $announcements->links() }}
        </div>
    @endif
@endsection
