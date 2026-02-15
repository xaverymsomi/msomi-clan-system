<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Category -->
    <div class="col-span-1 md:col-span-2">
        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">{{ __('traditions.category') }} <span class="text-red-500">*</span></label>
        <select name="category_id" id="category_id" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
            <option value="">{{ __('messages.select') }}...</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ (old('category_id') ?? $tradition->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Title (Swahili) -->
    <div>
        <label for="title_sw" class="block text-sm font-medium text-gray-700 mb-1">{{ __('traditions.title_sw') }} <span class="text-red-500">*</span></label>
        <input type="text" name="title_sw" id="title_sw" value="{{ old('title_sw', $tradition->title_sw ?? '') }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
        @error('title_sw')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Title (English) -->
    <div>
        <label for="title_en" class="block text-sm font-medium text-gray-700 mb-1">{{ __('traditions.title_en') }} <span class="text-red-500">*</span></label>
        <input type="text" name="title_en" id="title_en" value="{{ old('title_en', $tradition->title_en ?? '') }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
        @error('title_en')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Description (Swahili) -->
    <div>
        <label for="description_sw" class="block text-sm font-medium text-gray-700 mb-1">{{ __('traditions.description_sw') }}</label>
        <textarea name="description_sw" id="description_sw" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">{{ old('description_sw', $tradition->description_sw ?? '') }}</textarea>
        @error('description_sw')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Description (English) -->
    <div>
        <label for="description_en" class="block text-sm font-medium text-gray-700 mb-1">{{ __('traditions.description_en') }}</label>
        <textarea name="description_en" id="description_en" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">{{ old('description_en', $tradition->description_en ?? '') }}</textarea>
        @error('description_en')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Content (Swahili) -->
    <div class="col-span-1 md:col-span-2">
        <label for="content_sw" class="block text-sm font-medium text-gray-700 mb-1">{{ __('traditions.content_sw') }}</label>
        <textarea name="content_sw" id="content_sw" rows="6" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">{{ old('content_sw', $tradition->content_sw ?? '') }}</textarea>
        @error('content_sw')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Content (English) -->
    <div class="col-span-1 md:col-span-2">
        <label for="content_en" class="block text-sm font-medium text-gray-700 mb-1">{{ __('traditions.content_en') }}</label>
        <textarea name="content_en" id="content_en" rows="6" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">{{ old('content_en', $tradition->content_en ?? '') }}</textarea>
        @error('content_en')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Featured Image -->
    <div>
        <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-1">{{ __('traditions.featured_image') }}</label>
        @if(isset($tradition) && $tradition->featured_image)
            <div class="mb-2">
                <img src="{{ Storage::url($tradition->featured_image) }}" alt="Current Image" class="h-20 w-auto object-cover rounded">
            </div>
        @endif
        <input type="file" name="featured_image" id="featured_image" accept="image/*" class="w-full border border-gray-300 rounded-md shadow-sm p-2 bg-white focus:outline-none focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
        @error('featured_image')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Status -->
    <div>
        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.status') }} <span class="text-red-500">*</span></label>
        <select name="status" id="status" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
            <option value="draft" {{ (old('status') ?? $tradition->status ?? 'draft') == 'draft' ? 'selected' : '' }}>{{ __('traditions.draft') }}</option>
            <option value="published" {{ (old('status') ?? $tradition->status ?? '') == 'published' ? 'selected' : '' }}>{{ __('traditions.published') }}</option>
        </select>
        @error('status')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-8 flex justify-end space-x-3">
    <a href="{{ route('traditions.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-6 rounded shadow transition-colors">
        {{ __('messages.cancel') }}
    </a>
    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded shadow transition-colors">
        {{ __('messages.save') }}
    </button>
</div>
