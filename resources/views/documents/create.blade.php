@extends('layouts.admin')

@section('header')
    {{ __('documents.upload_document') }}
@endsection

@section('content')
    <div class="mb-6">
        <a href="{{ route('documents.index') }}" class="text-indigo-600 hover:text-indigo-800 flex items-center transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            {{ __('messages.back') }}
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden max-w-3xl mx-auto">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-800">{{ __('documents.upload_new_document') }}</h2>
            <p class="text-sm text-gray-600 mt-1">{{ __('documents.upload_description') }}</p>
        </div>
        
        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            
            <!-- File Upload -->
            <div>
                <label for="file" class="block text-sm font-medium text-gray-700 mb-1">
                    {{ __('documents.file') }} <span class="text-red-500">*</span>
                </label>
                <input type="file" name="file" id="file" required 
                       accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.gif,.zip,.rar"
                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <p class="text-xs text-gray-500 mt-1">{{ __('documents.file_requirements') }}</p>
                @error('file')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">
                    {{ __('documents.category') }} <span class="text-red-500">*</span>
                </label>
                <select name="category_id" id="category_id" required 
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">{{ __('messages.select') }}...</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Access Level -->
            <div>
                <label for="access_level" class="block text-sm font-medium text-gray-700 mb-1">
                    {{ __('documents.access_level') }} <span class="text-red-500">*</span>
                </label>
                <select name="access_level" id="access_level" required 
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="public">{{ __('documents.public') }} - {{ __('documents.public_desc') }}</option>
                    <option value="members" selected>{{ __('documents.members') }} - {{ __('documents.members_desc') }}</option>
                    <option value="elders">{{ __('documents.elders') }} - {{ __('documents.elders_desc') }}</option>
                    <option value="admin">{{ __('documents.admin') }} - {{ __('documents.admin_desc') }}</option>
                </select>
                @error('access_level')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title Swahili -->
                <div>
                    <label for="title_sw" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('documents.title') }} (Swahili) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title_sw" id="title_sw" value="{{ old('title_sw') }}" required 
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('title_sw')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Title English -->
                <div>
                    <label for="title_en" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('documents.title') }} (English) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title_en" id="title_en" value="{{ old('title_en') }}" required 
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('title_en')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Description Swahili -->
                <div>
                    <label for="description_sw" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('documents.description') }} (Swahili)
                    </label>
                    <textarea name="description_sw" id="description_sw" rows="4" 
                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('description_sw') }}</textarea>
                    @error('description_sw')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description English -->
                <div>
                    <label for="description_en" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('documents.description') }} (English)
                    </label>
                    <textarea name="description_en" id="description_en" rows="4" 
                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('description_en') }}</textarea>
                    @error('description_en')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-4 flex justify-end space-x-3">
                <a href="{{ route('documents.index') }}" 
                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-6 rounded shadow transition-colors">
                    {{ __('messages.cancel') }}
                </a>
                <button type="submit" 
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded shadow transition-colors">
                    {{ __('documents.upload') }}
                </button>
            </div>
        </form>
    </div>
@endsection
