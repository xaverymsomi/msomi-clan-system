@extends('layouts.admin')

@section('header')
    {{ __('announcements.edit_announcement') }}
@endsection

@section('content')
    <div class="mb-6">
        <a href="{{ route('announcements.show', $announcement) }}" class="text-indigo-600 hover:text-indigo-800 flex items-center transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            {{ __('messages.back') }}
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden max-w-4xl mx-auto">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-800">{{ __('announcements.edit_announcement') }}</h2>
        </div>
        
        <form action="{{ route('announcements.update', $announcement) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title_sw" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('announcements.title') }} (Swahili) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title_sw" id="title_sw" value="{{ old('title_sw', $announcement->title_sw) }}" required 
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('title_sw')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="title_en" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('announcements.title') }} (English) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title_en" id="title_en" value="{{ old('title_en', $announcement->title_en) }}" required 
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('title_en')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="content_sw" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('announcements.content') }} (Swahili) <span class="text-red-500">*</span>
                    </label>
                    <textarea name="content_sw" id="content_sw" rows="8" required 
                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('content_sw', $announcement->content_sw) }}</textarea>
                    @error('content_sw')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="content_en" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('announcements.content') }} (English) <span class="text-red-500">*</span>
                    </label>
                    <textarea name="content_en" id="content_en" rows="8" required 
                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('content_en', $announcement->content_en) }}</textarea>
                    @error('content_en')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('announcements.category') }} <span class="text-red-500">*</span>
                    </label>
                    <select name="category" id="category" required 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="general" {{ old('category', $announcement->category) == 'general' ? 'selected' : '' }}>{{ __('announcements.general') }}</option>
                        <option value="urgent" {{ old('category', $announcement->category) == 'urgent' ? 'selected' : '' }}>{{ __('announcements.urgent') }}</option>
                        <option value="event" {{ old('category', $announcement->category) == 'event' ? 'selected' : '' }}>{{ __('announcements.event') }}</option>
                        <option value="financial" {{ old('category', $announcement->category) == 'financial' ? 'selected' : '' }}>{{ __('announcements.financial') }}</option>
                    </select>
                    @error('category')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('announcements.priority') }} <span class="text-red-500">*</span>
                    </label>
                    <select name="priority" id="priority" required 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="low" {{ old('priority', $announcement->priority) == 'low' ? 'selected' : '' }}>{{ __('announcements.low') }}</option>
                        <option value="medium" {{ old('priority', $announcement->priority) == 'medium' ? 'selected' : '' }}>{{ __('announcements.medium') }}</option>
                        <option value="high" {{ old('priority', $announcement->priority) == 'high' ? 'selected' : '' }}>{{ __('announcements.high') }}</option>
                    </select>
                    @error('priority')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('announcements.publish_date') }}
                    </label>
                    <input type="datetime-local" name="published_at" id="published_at" 
                           value="{{ old('published_at', $announcement->published_at?->format('Y-m-d\TH:i')) }}" 
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('published_at')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="expires_at" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('announcements.expire_date') }}
                    </label>
                    <input type="datetime-local" name="expires_at" id="expires_at" 
                           value="{{ old('expires_at', $announcement->expires_at?->format('Y-m-d\TH:i')) }}" 
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('expires_at')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-4 flex justify-end space-x-3">
                <a href="{{ route('announcements.show', $announcement) }}" 
                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-6 rounded shadow transition-colors">
                    {{ __('messages.cancel') }}
                </a>
                <button type="submit" 
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded shadow transition-colors">
                    {{ __('messages.save') }}
                </button>
            </div>
        </form>
    </div>
@endsection
