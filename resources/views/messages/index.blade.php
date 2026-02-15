@extends('layouts.admin')

@section('header')
    {{ __('messages.messages') }}
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
        <h2 class="text-xl font-bold text-gray-800">{{ __('messages.inbox') }}</h2>
        <a href="{{ route('messages.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
            {{ __('messages.new_message') }}
        </a>
    </div>

    <div class="divide-y divide-gray-200">
        @forelse($conversations as $conversation)
            @php
                $otherUser = $conversation->getOtherUser(auth()->user());
                $hasUnread = $conversation->hasUnread(auth()->user());
                $lastMsg = $conversation->lastMessage;
            @endphp
            <a href="{{ route('messages.show', $conversation) }}" class="block hover:bg-gray-50 transition duration-150 {{ $hasUnread ? 'bg-indigo-50/50' : '' }}">
                <div class="px-6 py-4 flex items-center">
                    <div class="flex-shrink-0 h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-lg border-2 border-white shadow-sm">
                        @if($otherUser->avatar)
                            <img class="h-full w-full rounded-full object-cover" src="{{ asset('storage/' . $otherUser->avatar) }}" alt="{{ $otherUser->name }}">
                        @else
                            {{ substr($otherUser->name, 0, 1) }}
                        @endif
                    </div>
                    <div class="ml-4 flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-bold text-indigo-900 truncate {{ $hasUnread ? '' : 'font-medium' }}">
                                {{ $otherUser->name }}
                                @if($hasUnread)
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        {{ __('messages.unread') }}
                                    </span>
                                @endif
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $conversation->last_message_at ? $conversation->last_message_at->diffForHumans() : '' }}
                            </p>
                        </div>
                        <p class="text-sm text-gray-600 truncate mt-1">
                            @if($lastMsg)
                                <span class="font-medium">{{ $lastMsg->sender_id === auth()->id() ? __('messages.you') . ': ' : '' }}</span>
                                {{ $lastMsg->body }}
                            @else
                                <span class="italic text-gray-400">{{ __('messages.no_messages') }}</span>
                            @endif
                        </p>
                    </div>
                    <div class="ml-4 flex-shrink-0">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>
        @empty
            <div class="px-6 py-12 text-center">
                <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-gray-100 mb-4">
                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">{{ __('messages.no_conversations') }}</h3>
                <p class="text-gray-500 mt-1">{{ __('messages.no_conversations_desc') }}</p>
                <div class="mt-6">
                    <a href="{{ route('messages.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('messages.start_conversation') }}
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    @if($conversations->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $conversations->links() }}
        </div>
    @endif
</div>
@endsection
