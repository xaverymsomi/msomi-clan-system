@extends('layouts.admin')

@section('header')
    {{ $document->title }}
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Header -->
                <div class="p-6 border-b border-gray-100">
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $document->title }}</h1>
                    <div class="flex items-center gap-3 text-sm text-gray-600">
                        <span class="flex items-center">
                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            {{ $document->category->name }}
                        </span>
                        <span>•</span>
                        <span>{{ $document->getFileSizeFormatted() }}</span>
                        <span>•</span>
                        <span>{{ $document->created_at->format('d M Y') }}</span>
                    </div>
                </div>

                <!-- Preview / Download -->
                <div class="p-6">
                    @if($document->isPdf())
                        <div class="mb-4">
                            <iframe src="{{ $document->getFileUrl() }}" class="w-full h-96 border rounded"></iframe>
                        </div>
                    @elseif($document->isImage())
                        <div class="mb-4">
                            <img src="{{ $document->getFileUrl() }}" alt="{{ $document->title }}" class="w-full h-auto rounded">
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-lg p-12 text-center mb-4">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                            </svg>
                            <p class="mt-4 text-gray-600">{{ __('documents.preview_not_available') }}</p>
                        </div>
                    @endif

                    <a href="{{ route('documents.download', $document) }}" 
                       class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg text-center transition-colors">
                        <svg class="inline-block h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        {{ __('documents.download') }}
                    </a>
                </div>

                <!-- Description -->
                @if($document->description)
                    <div class="p-6 border-t border-gray-100">
                        <h3 class="font-bold text-gray-900 mb-2">{{ __('documents.description') }}</h3>
                        <p class="text-gray-700 whitespace-pre-line">{{ $document->description }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Document Info -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="font-bold text-gray-900 mb-4">{{ __('documents.document_info') }}</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">{{ __('documents.access_level') }}</dt>
                        <dd class="mt-1">
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
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">{{ __('documents.file_type') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ strtoupper($document->getFileExtension()) }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">{{ __('documents.file_size') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $document->getFileSizeFormatted() }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">{{ __('documents.uploaded_by') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $document->uploader->name ?? 'System' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">{{ __('documents.uploaded_on') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $document->created_at->format('d M Y, h:i A') }}</dd>
                    </div>
                </dl>

                @can('delete', $document)
                    <form action="{{ route('documents.destroy', $document) }}" method="POST" class="mt-6">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('{{ __('documents.confirm_delete') }}')" 
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md text-sm">
                            {{ __('messages.delete') }}
                        </button>
                    </form>
                @endcan
            </div>

            <!-- Related Documents -->
            @if($relatedDocuments->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-bold text-gray-900 mb-4">{{ __('documents.related_documents') }}</h3>
                    <ul class="space-y-3">
                        @foreach($relatedDocuments as $related)
                            <li>
                                <a href="{{ route('documents.show', $related) }}" class="block hover:bg-gray-50 p-2 rounded transition-colors">
                                    <p class="text-sm font-medium text-gray-900 line-clamp-2">{{ $related->title }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $related->getFileSizeFormatted() }}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
@endsection
