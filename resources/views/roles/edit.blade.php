@extends('layouts.admin')

@section('header')
    {{ __('messages.edit_role') }}
@endsection

@section('content')
    <div class="mb-6">
        <a href="{{ route('roles.index') }}" class="text-purple-600 hover:text-purple-800 flex items-center transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            {{ __('messages.back') }}
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">{{ __('messages.role_details') }} - {{ $role->name }}</h2>
        </div>
        
        <form action="{{ route('roles.update', $role) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.role_name') }} <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" {{ $role->name === 'Super Admin' ? 'readonly' : '' }}>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                @if($role->name === 'Super Admin')
                    <p class="text-xs text-gray-500 mt-1">Super Admin name cannot be changed.</p>
                @endif
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">{{ __('messages.permissions') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($permissions as $group => $perms)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-bold text-gray-800 mb-2 capitalize">{{ $group }}</h4>
                            <div class="space-y-2">
                                @foreach($perms as $permission)
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                                            class="rounded text-purple-600 focus:ring-purple-500 border-gray-300"
                                            {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                            {{ $role->name === 'Super Admin' ? 'disabled checked' : '' }}
                                        >
                                        <span class="text-sm text-gray-700">{{ $permission->name }}</span>
                                    </label>
                                    @if($role->name === 'Super Admin')
                                        <input type="hidden" name="permissions[]" value="{{ $permission->name }}">
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('roles.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-6 rounded shadow transition-colors">
                    {{ __('messages.cancel') }}
                </a>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded shadow transition-colors">
                    {{ __('messages.update') }}
                </button>
            </div>
        </form>
    </div>
@endsection
