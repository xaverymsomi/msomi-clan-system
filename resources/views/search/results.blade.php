@extends('layouts.admin')

@section('header')
    Search Results for "{{ $query }}"
@endsection

@section('content')
    <div class="space-y-8">
        <!-- Members -->
        @if($results['members']->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Members ({{ $results['members']->count() }})</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @foreach($results['members'] as $member)
                <a href="{{ route('members.show', $member) }}" class="block px-6 py-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold uppercase">
                            {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">{{ $member->full_name }}</p>
                            <p class="text-xs text-gray-500">{{ $member->region }}, {{ $member->village }}</p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Traditions -->
        @if($results['traditions']->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 text-purple-700">Mila na Desturi ({{ $results['traditions']->count() }})</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @foreach($results['traditions'] as $tradition)
                <a href="{{ route('traditions.show', $tradition) }}" class="block px-6 py-4 hover:bg-gray-50 transition-colors">
                    <p class="text-sm font-medium text-gray-900">{{ $tradition->title }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ Str::limit(strip_tags($tradition->description), 150) }}</p>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Events -->
        @if($results['events']->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 text-green-700">Events ({{ $results['events']->count() }})</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @foreach($results['events'] as $event)
                <a href="{{ route('events.show', $event) }}" class="block px-6 py-4 hover:bg-gray-50 transition-colors">
                    <p class="text-sm font-medium text-gray-900">{{ $event->title }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $event->start_date->format('M d, Y') }} - {{ $event->location }}</p>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Announcements -->
        @if($results['announcements']->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 text-yellow-700">Announcements ({{ $results['announcements']->count() }})</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @foreach($results['announcements'] as $announcement)
                <a href="{{ route('announcements.index') }}" class="block px-6 py-4 hover:bg-gray-50 transition-colors">
                    <p class="text-sm font-medium text-gray-900">{{ $announcement->title }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ Str::limit(strip_tags($announcement->content), 150) }}</p>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Documents -->
        @if($results['documents']->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 text-indigo-700">Documents ({{ $results['documents']->count() }})</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @foreach($results['documents'] as $document)
                <a href="{{ route('documents.index') }}" class="block px-6 py-4 hover:bg-gray-50 transition-colors">
                    <p class="text-sm font-medium text-gray-900">{{ $document->title }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $document->category->name }}</p>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        @if(collect($results)->flatten()->count() === 0)
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No results found</h3>
            <p class="mt-1 text-sm text-gray-500">We couldn't find anything matching your search term.</p>
        </div>
        @endif
    </div>
@endsection
