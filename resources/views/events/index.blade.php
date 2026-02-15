@extends('layouts.admin')

@section('header')
    {{ __('events.events') }}
@endsection

@section('content')
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                {{ __('events.upcoming_events') }}
            </h2>
        </div>
        @can('create', App\Models\Event::class)
        <div class="mt-4 flex md:mt-0 md:ml-4">
            <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                {{ __('events.add_event') }}
            </a>
        </div>
        @endcan
    </div>

    <!-- Filters -->
    <div class="mb-8 bg-white p-4 rounded-lg shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <form action="{{ route('events.index') }}" method="GET" class="flex items-center space-x-4">
            <select name="type" class="block rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm" onchange="this.form.submit()">
                <option value="">{{ __('events.all_types') }}</option>
                @foreach(['meeting', 'ceremony', 'celebration', 'funeral', 'other'] as $type)
                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                        {{ __('events.' . $type) }}
                    </option>
                @endforeach
            </select>
            
            <select name="view" class="block rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm" onchange="this.form.submit()">
                <option value="upcoming" {{ request('view') != 'past' ? 'selected' : '' }}>{{ __('events.upcoming') }}</option>
                <option value="past" {{ request('view') == 'past' ? 'selected' : '' }}>{{ __('events.past') }}</option>
            </select>
        </form>
    </div>

    <!-- Events Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($events as $event)
            <article class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden flex flex-col h-full border-l-4 border-l-{{ $event->event_type == 'funeral' ? 'gray' : ($event->event_type == 'celebration' ? 'yellow' : 'green') }}-500">
                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex items-center justify-between mb-2">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600 uppercase">
                            {{ __('events.' . $event->event_type) }}
                        </span>
                        @if($event->is_full)
                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-red-100 text-red-600 uppercase">
                                {{ __('events.full') }}
                            </span>
                        @endif
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 mb-2">
                        <a href="{{ route('events.show', $event) }}" class="hover:text-green-600 transition-colors">
                            {{ $event->title }}
                        </a>
                    </h3>
                    
                    <div class="flex items-center text-sm text-gray-500 mb-2">
                        <svg class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $event->start_date->format('M d, Y - h:i A') }}
                    </div>
                    
                    @if($event->location)
                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <svg class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ $event->location }}
                    </div>
                    @endif
                    
                    <p class="text-gray-600 mb-4 line-clamp-3 text-sm flex-1">
                        {{ Str::limit($event->description, 100) }}
                    </p>
                    
                    <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                        <div class="text-xs text-gray-500">
                            {{ $event->attendees()->where('status', 'registered')->count() }} {{ __('events.attendees') }}
                        </div>
                        <a href="{{ route('events.show', $event) }}" class="text-green-600 font-semibold hover:text-green-800 text-sm">
                            {{ __('events.details') }} &rarr;
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-1 md:col-span-3 text-center py-12 bg-white rounded-lg shadow-sm">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('events.no_events_found') }}</h3>
                <p class="mt-1 text-sm text-gray-500">{{ __('events.try_changing_filters') }}</p>
                @can('create', App\Models\Event::class)
                <div class="mt-6">
                    <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        {{ __('events.add_event') }}
                    </a>
                </div>
                @endcan
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $events->links() }}
    </div>
@endsection
