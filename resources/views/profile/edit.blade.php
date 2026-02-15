@extends('layouts.admin')

@section('header')
    {{ __('profile.profile') }}
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <!-- Profile Information -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-lg font-bold text-gray-800">{{ __('profile.profile_information') }}</h3>
            <p class="text-sm text-gray-500">{{ __('profile.profile_information_desc') }}</p>
        </div>
        <div class="p-6">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <!-- Update Password -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-lg font-bold text-gray-800">{{ __('profile.update_password') }}</h3>
            <p class="text-sm text-gray-500">{{ __('profile.update_password_desc') }}</p>
        </div>
        <div class="p-6">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <!-- Delete Account -->
    <div class="bg-white rounded-xl shadow-sm border border-red-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-red-50 bg-red-50/30">
            <h3 class="text-lg font-bold text-red-800">{{ __('profile.delete_account') }}</h3>
            <p class="text-sm text-red-600">{{ __('profile.delete_account_desc') }}</p>
        </div>
        <div class="p-6">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
