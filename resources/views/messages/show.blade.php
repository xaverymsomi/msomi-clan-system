@extends('layouts.admin')

@section('header')
    {{ __('messages.messages') }}
@endsection

@section('content')
<div class="flex flex-col h-[calc(100vh-12rem)] bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    @php
        $otherUser = $conversation->getOtherUser(auth()->user());
    @endphp
    
    <!-- Chat Header -->
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
        <div class="flex items-center">
            <a href="{{ route('messages.index') }}" class="mr-4 text-gray-500 hover:text-gray-700">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                </svg>
            </a>
            <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold border-2 border-white shadow-sm mr-3">
                @if($otherUser->avatar)
                    <img class="h-full w-full rounded-full object-cover" src="{{ asset('storage/' . $otherUser->avatar) }}" alt="{{ $otherUser->name }}">
                @else
                    {{ substr($otherUser->name, 0, 1) }}
                @endif
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-800 leading-tight">{{ $otherUser->name }}</h2>
                <p class="text-xs text-gray-500">{{ __('messages.role_' . Str::slug($otherUser->getRoleNames()->first() ?? 'Member', '_')) }}</p>
            </div>
        </div>
    </div>

    <!-- Messages Area -->
    <div class="flex-1 overflow-y-auto p-6 space-y-4 bg-gray-50/30" id="messages-container">
        @foreach($messages as $message)
            @php
                $isMine = $message->sender_id === auth()->id();
            @endphp
            <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[75%] {{ $isMine ? 'order-1' : 'order-2' }}">
                    <div class="px-4 py-2 rounded-2xl shadow-sm {{ $isMine ? 'bg-indigo-600 text-white rounded-tr-none' : 'bg-white border border-gray-200 text-gray-800 rounded-tl-none' }}">
                        <p class="text-sm whitespace-pre-wrap">{{ $message->body }}</p>
                    </div>
                    <p class="text-[10px] text-gray-400 mt-1 {{ $isMine ? 'text-right' : 'text-left' }}">
                        {{ $message->created_at->format('H:i') }} · {{ $message->created_at->format('M d') }}
                    </p>
                </div>
            </div>
        @endforeach
        
        @if($messages->hasPages())
            <div class="py-4">
                {{ $messages->links() }}
            </div>
        @endif
    </div>

    <!-- Reply Area -->
    <div class="px-6 py-4 border-t border-gray-200 bg-white">
        <form action="{{ route('messages.reply', $conversation) }}" method="POST" class="flex items-end">
            @csrf
            <div class="flex-1">
                <textarea 
                    name="body" 
                    rows="3" 
                    class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3 resize-none"
                    placeholder="{{ __('messages.type_message') }}..."
                    required
                ></textarea>
            </div>
            <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150 h-12">
                <svg class="h-5 w-5 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
            </button>
        </form>
    </div>
</div>

<script>
    // Scroll to bottom of messages
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('messages-container');
        container.scrollTop = container.scrollHeight;
    });
</script>
@endsection
