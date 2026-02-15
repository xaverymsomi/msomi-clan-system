<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Title (Swahili) -->
    <div>
        <label for="title_sw" class="block text-sm font-medium text-gray-700 mb-1">{{ __('events.title_sw') }} <span class="text-red-500">*</span></label>
        <input type="text" name="title_sw" id="title_sw" value="{{ old('title_sw', $event->title_sw ?? '') }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
        @error('title_sw')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Title (English) -->
    <div>
        <label for="title_en" class="block text-sm font-medium text-gray-700 mb-1">{{ __('events.title_en') }} <span class="text-red-500">*</span></label>
        <input type="text" name="title_en" id="title_en" value="{{ old('title_en', $event->title_en ?? '') }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
        @error('title_en')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Event Type -->
    <div>
        <label for="event_type" class="block text-sm font-medium text-gray-700 mb-1">{{ __('events.event_type') }} <span class="text-red-500">*</span></label>
        <select name="event_type" id="event_type" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
            <option value="">{{ __('messages.select') }}...</option>
            @foreach(['meeting', 'ceremony', 'celebration', 'funeral', 'other'] as $type)
                <option value="{{ $type }}" {{ (old('event_type') ?? $event->event_type ?? '') == $type ? 'selected' : '' }}>
                    {{ __('events.' . $type) }}
                </option>
            @endforeach
        </select>
        @error('event_type')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Max Attendees -->
    <div>
        <label for="max_attendees" class="block text-sm font-medium text-gray-700 mb-1">{{ __('events.max_attendees') }}</label>
        <input type="number" name="max_attendees" id="max_attendees" value="{{ old('max_attendees', $event->max_attendees ?? '') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
        <p class="text-xs text-gray-500 mt-1">{{ __('events.leave_blank_unlimited') }}</p>
        @error('max_attendees')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Start Date -->
    <div>
        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">{{ __('events.start_date') }} <span class="text-red-500">*</span></label>
        <input type="datetime-local" name="start_date" id="start_date" value="{{ old('start_date', isset($event->start_date) ? $event->start_date->format('Y-m-d\TH:i') : '') }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
        @error('start_date')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- End Date -->
    <div>
        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">{{ __('events.end_date') }}</label>
        <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date', isset($event->end_date) ? $event->end_date->format('Y-m-d\TH:i') : '') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
        @error('end_date')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Location -->
    <div>
        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">{{ __('events.location') }}</label>
        <input type="text" name="location" id="location" value="{{ old('location', $event->location ?? '') }}" placeholder="e.g. Dar es Salaam" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
        @error('location')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Venue -->
    <div>
        <label for="venue" class="block text-sm font-medium text-gray-700 mb-1">{{ __('events.venue') }}</label>
        <input type="text" name="venue" id="venue" value="{{ old('venue', $event->venue ?? '') }}" placeholder="e.g. Mlimani City Hall" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
        @error('venue')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Description (Swahili) -->
    <div class="col-span-1 md:col-span-2">
        <label for="description_sw" class="block text-sm font-medium text-gray-700 mb-1">{{ __('events.description_sw') }}</label>
        <textarea name="description_sw" id="description_sw" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">{{ old('description_sw', $event->description_sw ?? '') }}</textarea>
        @error('description_sw')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Description (English) -->
    <div class="col-span-1 md:col-span-2">
        <label for="description_en" class="block text-sm font-medium text-gray-700 mb-1">{{ __('events.description_en') }}</label>
        <textarea name="description_en" id="description_en" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">{{ old('description_en', $event->description_en ?? '') }}</textarea>
        @error('description_en')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-8 flex justify-end space-x-3">
    <a href="{{ route('events.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-6 rounded shadow transition-colors">
        {{ __('messages.cancel') }}
    </a>
    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded shadow transition-colors">
        {{ __('messages.save') }}
    </button>
</div>
