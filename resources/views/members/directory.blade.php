@extends('layouts.admin')

@section('header')
    {{ __('members.professional_directory') ?? 'Professional Directory' }}
@endsection

@section('content')
<div class="mb-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 sm:text-3xl">{{ __('members.clan_expertise') ?? 'Clan Expertise Network' }}</h2>
            <p class="text-sm text-gray-500 mt-1">{{ __('members.directory_desc') ?? 'Connect with professionals and experts within the Msomi Clan.' }}</p>
        </div>
    </div>

    <!-- Search & Filters -->
    <div class="mt-6 bg-white p-4 rounded-lg shadow-sm border border-gray-100">
        <form action="{{ route('members.directory') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" name="q" value="{{ request('q') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm" placeholder="{{ __('messages.search') }}...">
            </div>

            <select name="profession" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="">{{ __('members.all_professions') ?? 'All Professions' }}</option>
                @foreach($professions as $prof)
                    <option value="{{ $prof }}" {{ request('profession') == $prof ? 'selected' : '' }}>{{ $prof }}</option>
                @endforeach
            </select>

            <button type="submit" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('messages.filter') }}
            </button>
        </form>
    </div>
</div>

<!-- Results Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse($members as $member)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
        <div class="p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    @if($member->profile_photo)
                        <img class="h-12 w-12 rounded-lg object-cover" src="{{ Storage::url($member->profile_photo) }}" alt="">
                    @else
                        <div class="h-12 w-12 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold uppercase text-lg">
                            {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-bold text-gray-900 truncate w-32" title="{{ $member->full_name }}">{{ $member->full_name }}</h3>
                    <p class="text-xs font-medium text-indigo-600 truncate">{{ $member->profession ?? __('members.not_specified') }}</p>
                </div>
            </div>

            @if($member->skills)
            <div class="mt-4 flex flex-wrap gap-1">
                @foreach(array_slice($member->skills, 0, 3) as $skill)
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                    {{ $skill }}
                </span>
                @endforeach
                @if(count($member->skills) > 3)
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-50 text-gray-400">
                    +{{ count($member->skills) - 3 }}
                </span>
                @endif
            </div>
            @endif

            <div class="mt-6">
                <a href="{{ route('members.show', $member) }}" class="block w-full text-center px-4 py-2 border border-gray-200 rounded-md text-xs font-bold text-gray-700 hover:bg-gray-50 transition-colors">
                    {{ __('messages.view_details') }}
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full py-12 text-center bg-white rounded-lg border-2 border-dashed border-gray-200">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('messages.no_results_found') }}</h3>
    </div>
    @endforelse
</div>

<div class="mt-8">
    {{ $members->links() }}
</div>
@endsection
