@extends('layouts.admin')

@section('header')
    {{ __('contributions.record_payment') }}
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

    <div class="bg-white rounded-lg shadow-md overflow-hidden max-w-2xl mx-auto">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-800">{{ __('contributions.payment_details') }}</h2>
        </div>
        
        <form action="{{ route('contributions.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            
            <!-- Member Selection -->
            <div>
                <label for="member_id" class="block text-sm font-medium text-gray-700 mb-1">{{ __('members.member') }} <span class="text-red-500">*</span></label>
                <select name="member_id" id="member_id" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                    <option value="">{{ __('messages.select') }}...</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                            {{ $member->full_name }} ({{ $member->member_id }})
                        </option>
                    @endforeach
                </select>
                @error('member_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Contribution Type -->
            <div x-data="{ type: '{{ old('contribution_type', 'dues') }}' }">
                <div>
                    <label for="contribution_type" class="block text-sm font-medium text-gray-700 mb-1">{{ __('contributions.type') }} <span class="text-red-500">*</span></label>
                    <select name="contribution_type" id="contribution_type" x-model="type" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                        <option value="dues">{{ __('contributions.dues') }}</option>
                        <option value="event">{{ __('contributions.event') }}</option>
                        <option value="project">{{ __('contributions.project') }}</option>
                        <option value="donation">{{ __('contributions.donation') }}</option>
                    </select>
                    @error('contribution_type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Conditional Event Selection -->
                <div class="mt-4" x-show="type === 'event'">
                    <label for="event_id" class="block text-sm font-medium text-gray-700 mb-1">{{ __('events.event') }} <span class="text-red-500">*</span></label>
                    <select name="event_id" id="event_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                        <option value="">{{ __('messages.select') }}...</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                                {{ $event->title }} ({{ $event->start_date->format('d M') }})
                            </option>
                        @endforeach
                    </select>
                    @error('event_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Amount -->
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">{{ __('contributions.amount') }} (TZS) <span class="text-red-500">*</span></label>
                    <input type="number" name="amount" id="amount" value="{{ old('amount') }}" required min="0" step="0.01" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                    @error('amount')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Payment Date -->
                <div>
                    <label for="payment_date" class="block text-sm font-medium text-gray-700 mb-1">{{ __('contributions.payment_date') }}</label>
                    <input type="date" name="payment_date" id="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                    @error('payment_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Payment Method -->
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">{{ __('contributions.payment_method') }} <span class="text-red-500">*</span></label>
                    <select name="payment_method" id="payment_method" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                        <option value="Cash">{{ __('contributions.cash') }}</option>
                        <option value="Mobile Money">{{ __('contributions.mobile_money') }}</option>
                        <option value="Bank Transfer">{{ __('contributions.bank_transfer') }}</option>
                        <option value="Cheque">{{ __('contributions.cheque') }}</option>
                    </select>
                    @error('payment_method')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Reference Number -->
                <div>
                    <label for="reference_number" class="block text-sm font-medium text-gray-700 mb-1">{{ __('contributions.reference_number') }}</label>
                    <input type="text" name="reference_number" id="reference_number" value="{{ old('reference_number') }}" placeholder="e.g. 5X78Y9..." class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                    @error('reference_number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">{{ __('contributions.status') }} <span class="text-red-500">*</span></label>
                <select name="status" id="status" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                    <option value="completed">{{ __('contributions.completed') }}</option>
                    <option value="pending">{{ __('contributions.pending') }}</option>
                    <option value="failed">{{ __('contributions.failed') }}</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div>
                <label for="purpose_en" class="block text-sm font-medium text-gray-700 mb-1">{{ __('contributions.notes') }}</label>
                <textarea name="purpose_en" id="purpose_en" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">{{ old('purpose_en') }}</textarea>
            </div>

            <div class="pt-4 flex justify-end space-x-3">
                <a href="{{ route('contributions.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-6 rounded shadow transition-colors">
                    {{ __('messages.cancel') }}
                </a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded shadow transition-colors">
                    {{ __('messages.save') }}
                </button>
            </div>
        </form>
    </div>
@endsection
