@extends('layouts.admin')

@section('header')
    <a href="{{ route('events.index') }}" class="text-purple-200 hover:text-white mr-2">
        &larr; {{ __('events.back_to_events') }}
    </a>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-lg shadow-md overflow-hidden p-6 md:p-8">
                <div class="flex items-center justify-between mb-4">
                    <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm font-bold uppercase tracking-wider">
                        {{ __('events.' . $event->event_type) }}
                    </span>
                    @if($event->is_full)
                         <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-bold uppercase tracking-wider">
                            {{ __('events.full') }}
                        </span>
                    @endif
                </div>

                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $event->title }}</h1>
                
                <div class="flex flex-col space-y-2 mb-8 text-gray-600">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 mr-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="font-medium">{{ $event->start_date->format('l, F j, Y') }}</span>
                        <span class="mx-2">&bull;</span>
                        <span>{{ $event->start_date->format('h:i A') }} - {{ $event->end_date ? $event->end_date->format('h:i A') : __('events.till_late') }}</span>
                    </div>
                    @if($event->location)
                    <div class="flex items-center">
                        <svg class="h-5 w-5 mr-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>{{ $event->venue ? $event->venue . ', ' : '' }}{{ $event->location }}</span>
                    </div>
                    @endif
                </div>

                <div class="prose prose-purple max-w-none text-gray-700">
                    {!! nl2br(e($event->description)) !!}
                </div>

                @can('update', $event)
                <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end space-x-3">
                    <a href="{{ route('events.edit', $event) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                        {{ __('messages.edit') }}
                    </a>
                    
                    @can('delete', $event)
                    <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('messages.are_you_sure') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium ml-4">
                            {{ __('messages.delete') }}
                        </button>
                    </form>
                    @endcan
                </div>
                @endcan
            </div>
        </div>

        <!-- Sidebar / RSVP -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-green-500">
                <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('events.rsvp') }}</h3>
                
                @auth
                    @if($attendance)
                        <div class="bg-green-50 rounded-md p-4 mb-4 border border-green-200">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-green-800">
                                        {{ $attendance->status == 'registered' ? __('events.you_are_registered') : __('events.you_cancelled') }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('events.register', $event) }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('events.attendance_status') }}</label>
                            <select name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                <option value="registered" {{ ($attendance->status ?? '') == 'registered' ? 'selected' : '' }}>{{ __('events.attending') }}</option>
                                <option value="cancelled" {{ ($attendance->status ?? '') == 'cancelled' ? 'selected' : '' }}>{{ __('events.not_attending') }}</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('events.guests') }}</label>
                            <select name="guests_count" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                @for($i = 0; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ ($attendance->guests_count ?? 0) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                            <p class="text-xs text-gray-500 mt-1">{{ __('events.guests_help') }}</p>
                        </div>

                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            {{ $attendance ? __('events.update_rsvp') : __('events.rsvp_now') }}
                        </button>
                    </form>
                @else
                    <div class="text-center py-4">
                        <p class="text-gray-600 mb-4">{{ __('events.login_to_rsvp') }}</p>
                        <a href="{{ route('login') }}" class="inline-block bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700">
                            {{ __('auth.login') }}
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Stats -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
                <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('events.attendance_stats') }}</h4>
                <div class="flex items-baseline">
                    <span class="text-3xl font-extrabold text-gray-900">
                        {{ $event->attendees()->where('status', 'registered')->count() }}
                    </span>
                    <span class="ml-2 text-sm text-gray-500">
                        / {{ $event->max_attendees ? $event->max_attendees : '∞' }}
                    </span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                    @php
                        $percentage = $event->max_attendees ? ($event->attendees()->where('status', 'registered')->count() / $event->max_attendees) * 100 : 0;
                    @endphp
                    <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ min($percentage, 100) }}%"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
