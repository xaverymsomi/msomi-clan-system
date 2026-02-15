@extends('layouts.admin')

@section('header')
    {{ __('contributions.contribution_details') }}
@endsection

@section('content')
    <div class="mb-6">
        <a href="{{ route('contributions.index') }}" class="text-green-600 hover:text-green-800 flex items-center transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            {{ __('messages.back') }}
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden max-w-3xl mx-auto printable" id="receipt">
        <div class="p-8 border-b-2 border-gray-100 flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ __('contributions.receipt') }}</h1>
                <p class="text-gray-500 mt-1">#{{ $contribution->id + 1000 }}</p>
                <p class="text-gray-500 text-sm mt-1">
                    {{ $contribution->created_at->format('d M Y, h:i A') }}
                </p>
            </div>
            <div class="text-right">
                <div class="text-2xl font-bold text-green-600">
                    {{ number_format($contribution->amount) }} {{ $contribution->currency }}
                </div>
                <div class="mt-2">
                    @if($contribution->status == 'completed')
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                            {{ __('contributions.paid') }}
                        </span>
                    @elseif($contribution->status == 'pending')
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                            {{ __('contributions.pending') }}
                        </span>
                    @else
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800 border border-red-200">
                            {{ __('contributions.failed') }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('contributions.payment_from') }}</h3>
                <p class="text-lg font-bold text-gray-900">{{ $contribution->member->full_name }}</p>
                <p class="text-gray-600">{{ $contribution->member->phone_primary }}</p>
                <p class="text-gray-600">{{ $contribution->member->email }}</p>
            </div>
            
            <div>
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('contributions.payment_details') }}</h3>
                <dl class="space-y-1">
                    <div class="flex justify-between">
                        <dt class="text-gray-600">{{ __('contributions.type') }}:</dt>
                        <dd class="font-medium capitalize">{{ $contribution->contribution_type }}</dd>
                    </div>
                    @if($contribution->event)
                    <div class="flex justify-between">
                        <dt class="text-gray-600">{{ __('events.event') }}:</dt>
                        <dd class="font-medium">{{ $contribution->event->title }}</dd>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <dt class="text-gray-600">{{ __('contributions.method') }}:</dt>
                        <dd class="font-medium">{{ $contribution->payment_method }}</dd>
                    </div>
                    @if($contribution->reference_number)
                    <div class="flex justify-between">
                        <dt class="text-gray-600">{{ __('contributions.reference') }}:</dt>
                        <dd class="font-medium">{{ $contribution->reference_number }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>

        @if($contribution->purpose_en)
        <div class="px-8 pb-8">
            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('contributions.notes') }}</h3>
            <p class="text-gray-700 bg-gray-50 p-4 rounded-md">{{ $contribution->purpose_en }}</p>
        </div>
        @endif

            <div class="flex space-x-2 no-print">
                @if($contribution->status !== 'completed')
                    <form action="{{ route('payments.pay', $contribution) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 flex items-center font-bold">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            {{ __('contributions.pay_now') ?? 'Pay Now' }}
                        </button>
                    </form>
                @endif
                <button onclick="window.print()" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 00-2 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    {{ __('messages.print') }}
                </button>
            </div>
    </div>
@endsection
