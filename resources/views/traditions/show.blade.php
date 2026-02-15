@extends('layouts.admin')

@section('header')
    <a href="{{ route('traditions.index') }}" class="text-purple-200 hover:text-white mr-2">
        &larr; {{ __('traditions.back_to_list') }}
    </a>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <article class="bg-white rounded-lg shadow-md overflow-hidden">
                @if($tradition->featured_image)
                    <div class="h-64 md:h-96 w-full relative">
                        <img src="{{ Storage::url($tradition->featured_image) }}" alt="{{ $tradition->title }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-6 text-white">
                            <span class="bg-{{ $tradition->category->color ?? 'purple' }}-600 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-2 inline-block">
                                {{ $tradition->category->name }}
                            </span>
                            <h1 class="text-3xl md:text-4xl font-bold mb-2">{{ $tradition->title }}</h1>
                        </div>
                    </div>
                @else
                    <div class="p-6 border-b border-gray-100">
                        <span class="bg-{{ $tradition->category->color ?? 'purple' }}-100 text-{{ $tradition->category->color ?? 'purple' }}-800 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-2 inline-block">
                            {{ $tradition->category->name }}
                        </span>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $tradition->title }}</h1>
                    </div>
                @endif
                
                <div class="p-6 md:p-8">
                    <!-- Metadata -->
                    <div class="flex items-center text-sm text-gray-500 mb-8 pb-4 border-b border-gray-100">
                        <div class="flex items-center mr-6">
                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $tradition->created_at->format('M d, Y') }}
                        </div>
                        <div class="flex items-center mr-6">
                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            {{ $tradition->views_count }} {{ __('traditions.views') }}
                        </div>
                        <div class="flex items-center">
                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ $tradition->creator->name ?? 'Admin' }}
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="prose prose-purple max-w-none mb-8 text-lg font-medium text-gray-700 leading-relaxed">
                        {{ $tradition->description }}
                    </div>

                    <!-- Content -->
                    <div class="prose prose-purple max-w-none text-gray-600 mb-8">
                        {!! nl2br(e($tradition->content)) !!}
                    </div>

                    <!-- Media Gallery -->
                    @if($tradition->media->count() > 0)
                    <div class="mt-12 pt-8 border-t border-gray-100">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">{{ __('traditions.media_gallery') }}</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($tradition->media as $media)
                            <div class="group relative aspect-square rounded-lg overflow-hidden bg-gray-100">
                                @if($media->type === 'video')
                                    <div class="absolute inset-0 flex items-center justify-center bg-black/20 group-hover:bg-black/40 transition-colors z-10">
                                        <svg class="h-12 w-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <video class="w-full h-full object-cover">
                                        <source src="{{ Storage::url($media->file_path) }}" type="video/mp4">
                                    </video>
                                @elseif($media->type === 'audio')
                                    <div class="absolute inset-0 flex flex-col items-center justify-center bg-purple-50 group-hover:bg-purple-100 transition-colors z-10 p-4">
                                        <svg class="h-12 w-12 text-purple-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                        </svg>
                                        <span class="text-xs font-bold text-purple-700 uppercase">{{ __('traditions.voice_story') ?? 'Voice Story' }}</span>
                                        <audio class="mt-4 w-full" controls>
                                            <source src="{{ Storage::url($media->file_path) }}" type="audio/mpeg">
                                        </audio>
                                    </div>
                                @else
                                    <img src="{{ Storage::url($media->file_path) }}" alt="{{ $media->caption }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                @endif
                                <div class="absolute inset-x-0 bottom-0 p-2 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                                    <p class="text-xs text-white truncate">{{ $media->caption }}</p>
                                </div>
                                @if($media->type !== 'audio')
                                <a href="{{ Storage::url($media->file_path) }}" target="_blank" class="absolute inset-0 z-20"></a>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                @can('update', $tradition)
                <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3 border-t border-gray-100">
                    <a href="{{ route('traditions.edit', $tradition) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                        {{ __('messages.edit') }}
                    </a>
                    
                    @can('delete', $tradition)
                    <form action="{{ route('traditions.destroy', $tradition) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('messages.are_you_sure') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium ml-4">
                            {{ __('messages.delete') }}
                        </button>
                    </form>
                    @endcan
                </div>
                @endcan
            </article>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-8">
            @can('update', $tradition)
            <div class="mb-8">
                @include('components.voice_recorder', ['tradition' => $tradition])
            </div>
            @endcan

            <!-- Author Card -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">{{ __('traditions.about_author') }}</h3>
                <div class="flex items-center">
                    <div class="h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-bold text-lg mr-3">
                        {{ substr($tradition->creator->name ?? 'A', 0, 1) }}
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900">{{ $tradition->creator->name ?? 'Administrator' }}</h4>
                        <p class="text-xs text-gray-500">{{ __('messages.role_admin') }}</p>
                    </div>
                </div>
            </div>

            <!-- Related Traditions -->
            @if($relatedTraditions->count() > 0)
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">{{ __('traditions.related_topics') }}</h3>
                <ul class="space-y-4">
                    @foreach($relatedTraditions as $related)
                        <li>
                            <a href="{{ route('traditions.show', $related) }}" class="group block">
                                <h4 class="font-medium text-gray-900 group-hover:text-purple-600 transition-colors">{{ $related->title }}</h4>
                                <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ Str::limit($related->description, 60) }}</p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
@endsection
