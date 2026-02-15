@extends('layouts.admin')

@section('header')
    {{ __('events.create_event') }}
@endsection

@section('content')
    <div class="mb-6">
        <a href="{{ route('events.index') }}" class="text-purple-600 hover:text-purple-800 flex items-center transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            {{ __('messages.back') }}
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-800">{{ __('events.create_event') }}</h2>
        </div>
        
        <form action="{{ route('events.store') }}" method="POST" class="p-6">
            @csrf
            
            @include('events._form', ['event' => null])
        </form>
    </div>
@endsection
