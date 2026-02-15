@extends('layouts.admin')

@section('header')
    {{ __('documents.documents') }}
@endsection

@section('content')
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
        <div>
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                {{ __('documents.document_repository') }}
            </h2>
        </div>
        @can('create', App\Models\Document::class)
        <div class="mt-4 flex md:mt-0 md:ml-4">
            <a href="{{ route('documents.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                {{ __('documents.upload_document') }}
            </a>
        </div>
        @endcan
    </div>

    <div class="flex flex-col md:flex-row gap-6">
        <!-- Sidebar -->
        <div class="w-full md:w-64 flex-shrink-0">
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="font-bold text-gray-900 mb-4">{{ __('documents.categories') }}</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('documents.index') }}" 
                           class="{{ !request('category') ? 'bg-indigo-50 text-indigo-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }} block px-3 py-2 rounded-md text-sm">
                            {{ __('documents.all_documents') }}
                            <span class="float-right text-gray-500">{{ \App\Models\Document::count() }}</span>
                        </a>
                    </li>
                    @foreach($categories as $category)
                        <li>
                            <a href="{{ route('documents.index', ['category' => $category->id]) }}" 
                               class="{{ request('category') == $category->id ? 'bg-indigo-50 text-indigo-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }} block px-3 py-2 rounded-md text-sm">
                                {{ $category->name }}
                                <span class="float-right text-gray-500">{{ $category->documents_count }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Search -->
            <div class="bg-white rounded-lg shadow p-4 mt-4">
                <form action="{{ route('documents.index') }}" method="GET">
                    <input type="hidden" name="category" value="{{ request('category') }}">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">{{ __('documents.search') }}</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           placeholder="{{ __('documents.search_placeholder') }}"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <button type="submit" class="mt-2 w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-md text-sm">
                        {{ __('messages.search') }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Documents Grid -->
        <div class="flex-1">
            @if($documents->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($documents as $document)
                        <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow overflow-hidden">
                            <div class="p-6">
                                <!-- File Icon -->
                                <div class="flex items-center justify-center h-24 mb-4">
                                    @if($document->isPdf())
                                        <svg class="h-20 w-20 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                        </svg>
                                    @elseif($document->isImage())
                                        <img src="{{ $document->getFileUrl() }}" alt="{{ $document->title }}" class="h-20 w-auto object-cover rounded">
                                    @else
                                        <svg class="h-20 w-20 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </div>

                                <!-- Title -->
                                <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                    {{ $document->title }}
                                </h3>

                                <!-- Category & Access Level -->
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs text-gray-500">{{ $document->category->name }}</span>
                                    @if($document->access_level === 'public')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ __('documents.public') }}
                                        </span>
                                    @elseif($document->access_level === 'members')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ __('documents.members') }}
                                        </span>
                                    @elseif($document->access_level === 'elders')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                            {{ __('documents.elders') }}
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            {{ __('documents.admin') }}
                                        </span>
                                    @endif
                                </div>

                                <!-- File Info -->
                                <p class="text-xs text-gray-500 mb-4">
                                    {{ $document->getFileSizeFormatted() }} • {{ strtoupper($document->getFileExtension()) }}
                                </p>

                                <!-- Actions -->
                                <div class="flex gap-2">
                                    <a href="{{ route('documents.show', $document) }}" 
                                       class="flex-1 text-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md text-sm">
                                        {{ __('messages.view') }}
                                    </a>
                                    @can('delete', $document)
                                        <form action="{{ route('documents.destroy', $document) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('{{ __('documents.confirm_delete') }}')" 
                                                    class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md text-sm">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $documents->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg shadow p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('documents.no_documents') }}</h3>
                    <p class="mt-1 text-sm text-gray-500">{{ __('documents.no_documents_message') }}</p>
                </div>
            @endif
        </div>
    </div>
@endsection
