@extends('layouts.admin')

@section('header')
    {{ __('members.family_tree') }}
@endsection

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-800">{{ __('members.select_root_member') }}</h2>
        <p class="text-gray-600">{{ __('members.start_tree_from_roots') }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($roots as $root)
            <a href="{{ route('members.tree', $root->id) }}" class="block bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow p-6 flex items-center">
                <div class="flex-shrink-0 h-16 w-16">
                    @if($root->profile_photo)
                        <img class="h-16 w-16 rounded-full object-cover" src="{{ Storage::url($root->profile_photo) }}" alt="{{ $root->full_name }}">
                    @else
                        <div class="h-16 w-16 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-bold text-xl">
                            {{ substr($root->first_name, 0, 1) }}{{ substr($root->last_name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $root->full_name }}</h3>
                    <p class="text-sm text-gray-500">{{ $root->member_number }}</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mt-2">
                        {{ __('members.clan_elder') }}
                    </span>
                </div>
            </a>
        @empty
            <div class="col-span-3 bg-white rounded-lg shadow p-6 text-center text-gray-500">
                {{ __('members.no_members_found') }}
            </div>
        @endforelse
    </div>
@endsection
