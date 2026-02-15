@extends('layouts.admin')

@section('header')
    {{ __('notifications.preferences') }}
@endsection

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('notifications.index') }}" class="text-indigo-600 hover:text-indigo-800 flex items-center">
                <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                {{ __('messages.back') }}
            </a>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">{{ __('notifications.notification_preferences') }}</h2>
            <p class="text-sm text-gray-600 mb-6">{{ __('notifications.preferences_description') }}</p>

            <form action="{{ route('notifications.preferences.update') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    @foreach($types as $type => $label)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <label for="{{ $type }}" class="font-medium text-gray-900">{{ __('notifications.' . $type) }}</label>
                                <p class="text-sm text-gray-500">{{ __('notifications.' . $type . '_desc') }}</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="{{ $type }}" id="{{ $type }}" class="sr-only peer" {{ ($preferences[$type] ?? true) ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                            </label>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-6 rounded-md">
                        {{ __('messages.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
