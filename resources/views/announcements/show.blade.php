@extends('layouts.admin')

@section('header')
    {{ $announcement->title }}
@endsection

@section('content')
    <div class="mb-6">
        <a href="{{ route('announcements.index') }}" class="text-indigo-600 hover:text-indigo-800 flex items-center transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            {{ __('messages.back') }}
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header -->
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $announcement->getCategoryBadgeClass() }}">
                            {{ __('announcements.' . $announcement->category) }}
                        </span>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $announcement->getPriorityBadgeClass() }}">
                            {{ __('announcements.' . $announcement->priority) }}
                        </span>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-3">{{ $announcement->title }}</h1>
                    <div class="flex items-center gap-4 text-sm text-gray-600">
                        <span class="flex items-center">
                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ $announcement->creator->name ?? 'System' }}
                        </span>
                        <span>•</span>
                        <span>{{ $announcement->published_at->format('d M Y, h:i A') }}</span>
                    </div>
                </div>
                <div class="flex gap-2">
                    @can('update', $announcement)
                        <a href="{{ route('announcements.edit', $announcement) }}" class="text-gray-600 hover:text-gray-800">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                    @endcan
                    @can('delete', $announcement)
                        <form action="{{ route('announcements.destroy', $announcement) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('{{ __('announcements.confirm_delete') }}')" class="text-red-600 hover:text-red-800">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6 prose max-w-none">
            {!! nl2br(e($announcement->content)) !!}
        </div>

        <!-- Comments Section -->
        <div class="p-6 border-t border-gray-100">
            <h3 class="text-lg font-bold text-gray-900 mb-4">
                {{ __('announcements.comments') }} ({{ $announcement->allComments->count() }})
            </h3>

            <!-- Comment Form -->
            @auth
                <form action="{{ route('announcements.comments.store', $announcement) }}" method="POST" class="mb-6">
                    @csrf
                    <textarea name="comment" rows="3" required placeholder="{{ __('announcements.add_comment_placeholder') }}"
                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                    @error('comment')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <button type="submit" class="mt-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md text-sm">
                        {{ __('announcements.post_comment') }}
                    </button>
                </form>
            @else
                <p class="text-gray-600 mb-6">
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800">{{ __('messages.login') }}</a> 
                    {{ __('announcements.to_comment') }}
                </p>
            @endauth

            <!-- Comments List -->
            <div class="space-y-4">
                @forelse($announcement->comments as $comment)
                    <div class="border-l-2 border-gray-200 pl-4">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-semibold text-gray-900">{{ $comment->user->name }}</span>
                                    <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-700">{{ $comment->comment }}</p>
                            </div>
                            @if(auth()->check() && (auth()->id() === $comment->user_id || auth()->user()->hasRole('Super Admin')))
                                <form action="{{ route('announcements.comments.destroy', $comment) }}" method="POST" class="ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('{{ __('announcements.confirm_delete_comment') }}')" class="text-red-600 hover:text-red-800 text-xs">
                                        {{ __('messages.delete') }}
                                    </button>
                                </form>
                            @endif
                        </div>

                        <!-- Reply Form -->
                        @auth
                            <button onclick="toggleReplyForm('reply-{{ $comment->id }}')" class="text-indigo-600 hover:text-indigo-800 text-sm mt-2">
                                {{ __('announcements.reply') }}
                            </button>
                            <form id="reply-{{ $comment->id }}" action="{{ route('announcements.comments.store', $announcement) }}" method="POST" class="mt-2 hidden">
                                @csrf
                                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                <textarea name="comment" rows="2" required placeholder="{{ __('announcements.reply_placeholder') }}"
                                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                <button type="submit" class="mt-1 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-1 px-3 rounded-md text-xs">
                                    {{ __('announcements.post_reply') }}
                                </button>
                            </form>
                        @endauth

                        <!-- Nested Replies -->
                        @if($comment->replies->count() > 0)
                            <div class="mt-3 ml-6 space-y-3">
                                @foreach($comment->replies as $reply)
                                    <div class="border-l-2 border-gray-100 pl-4">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <span class="font-semibold text-gray-900 text-sm">{{ $reply->user->name }}</span>
                                                    <span class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
                                                </div>
                                                <p class="text-gray-700 text-sm">{{ $reply->comment }}</p>
                                            </div>
                                            @if(auth()->check() && (auth()->id() === $reply->user_id || auth()->user()->hasRole('Super Admin')))
                                                <form action="{{ route('announcements.comments.destroy', $reply) }}" method="POST" class="ml-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('{{ __('announcements.confirm_delete_comment') }}')" class="text-red-600 hover:text-red-800 text-xs">
                                                        {{ __('messages.delete') }}
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8">{{ __('announcements.no_comments') }}</p>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        function toggleReplyForm(formId) {
            const form = document.getElementById(formId);
            form.classList.toggle('hidden');
        }
    </script>
@endsection
