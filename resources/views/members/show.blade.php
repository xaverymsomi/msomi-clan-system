@extends('layouts.admin')

@section('header')
    {{ __('members.view_member') }}
@endsection

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('members.index') }}" class="text-purple-600 hover:text-purple-800 flex items-center transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            {{ __('messages.back') }}
        </a>
            <a href="{{ route('members.id-card', $member) }}" target="_blank" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow transition-colors flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
                </svg>
                {{ __('members.download_id_card') ?? 'Download ID Card' }}
            </a>
            <a href="{{ route('members.edit', $member) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition-colors flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                </svg>
                {{ __('messages.edit') }}
            </a>
            <form action="{{ route('members.destroy', $member) }}" method="POST" onsubmit="return confirm('{{ __('messages.confirm_delete') }}')" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow transition-colors flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    {{ __('messages.delete') }}
                </button>
            </form>
        </div>
    </div>

    <!-- Member Profile Header -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="md:flex">
            <div class="md:flex-shrink-0 bg-gray-100 flex items-center justify-center w-full md:w-48 h-48">
                @if($member->profile_photo)
                    <img class="h-48 w-full object-cover" src="{{ Storage::url($member->profile_photo) }}" alt="{{ $member->full_name }}">
                @else
                    <div class="text-4xl font-bold text-gray-400">
                        {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                    </div>
                @endif
            </div>
            <div class="p-8 w-full">
                <div class="uppercase tracking-wide text-sm text-purple-600 font-semibold">{{ $member->member_number }}</div>
                <h1 class="block mt-1 text-3xl leading-tight font-bold text-gray-900">{{ $member->full_name }}</h1>
                <p class="mt-2 text-gray-500">{{ $member->occupation ?? __('members.occupation') . ' N/A' }}</p>
                <div class="mt-4 flex items-center">
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                        {{ $member->membership_status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $member->membership_status === 'inactive' ? 'bg-gray-100 text-gray-800' : '' }}
                        {{ $member->membership_status === 'deceased' ? 'bg-red-100 text-red-800' : '' }}
                    ">
                        {{ ucfirst($member->membership_status) }}
                    </span>
                    <span class="ml-4 text-sm text-gray-500">{{ __('members.joined_date') }}: {{ $member->joined_date ? $member->joined_date->format('M d, Y') : '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Personal Details -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-800">{{ __('members.member_details') }}</h3>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">{{ __('members.gender') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($member->gender) }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">{{ __('members.date_of_birth') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $member->date_of_birth ? $member->date_of_birth->format('M d, Y') : '-' }} ({{ $member->age ?? '-' }} yrs)</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">{{ __('members.marital_status') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($member->marital_status ?? '-') }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">{{ __('members.user_account') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $member->user ? 'Linked' : 'None' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Contact & Location -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-800">{{ __('members.contact') }} & {{ __('members.location') }}</h3>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">{{ __('auth.email') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $member->email ?? $member->user?->email ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">{{ __('members.phone') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $member->phone ?? $member->user?->phone ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">{{ __('members.region') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $member->region ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">{{ __('members.district') }} / {{ __('members.village') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $member->district ?? '-' }} / {{ $member->village ?? '-' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Family Tree (Basic) -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-800">{{ __('members.family_tree') }}</h3>
            </div>
            <div class="p-6">
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <span class="text-sm font-medium text-gray-500 w-20">{{ __('members.father') }}:</span>
                        <span class="text-sm text-gray-900">
                            @if($member->father)
                                <a href="{{ route('members.show', $member->father) }}" class="text-purple-600 hover:text-purple-800">{{ $member->father->full_name }}</a>
                            @else
                                -
                            @endif
                        </span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-sm font-medium text-gray-500 w-20">{{ __('members.mother') }}:</span>
                        <span class="text-sm text-gray-900">
                            @if($member->mother)
                                <a href="{{ route('members.show', $member->mother) }}" class="text-purple-600 hover:text-purple-800">{{ $member->mother->full_name }}</a>
                            @else
                                -
                            @endif
                        </span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-sm font-medium text-gray-500 w-20">{{ __('members.children') }}:</span>
                        <span class="text-sm text-gray-900">
                            @if($member->children->count() > 0)
                                <ul class="list-disc list-inside">
                                    @foreach($member->children as $child)
                                        <li><a href="{{ route('members.show', $child) }}" class="text-purple-600 hover:text-purple-800">{{ $child->full_name }}</a></li>
                                    @endforeach
                                </ul>
                            @else
                                -
                            @endif
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
