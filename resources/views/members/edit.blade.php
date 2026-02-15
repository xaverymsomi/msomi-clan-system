@extends('layouts.admin')

@section('header')
    {{ __('members.edit_member') }}
@endsection

@section('content')
    <div class="mb-6">
        <a href="{{ route('members.show', $member) }}" class="text-purple-600 hover:text-purple-800 flex items-center transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            {{ __('messages.back') }}
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">{{ __('members.member_details') }} - {{ $member->member_number }}</h2>
        </div>
        
        <form action="{{ route('members.update', $member) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Personal Information -->
                <div class="col-span-1 md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">{{ __('messages.profile') }}</h3>
                </div>

                <!-- First Name -->
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('members.first_name') }} <span class="text-red-500">*</span></label>
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $member->first_name) }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                    @error('first_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Middle Name -->
                <div>
                    <label for="middle_name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('members.middle_name') }}</label>
                    <input type="text" name="middle_name" id="middle_name" value="{{ old('middle_name', $member->middle_name) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                    @error('middle_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Last Name -->
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('members.last_name') }} <span class="text-red-500">*</span></label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $member->last_name) }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                    @error('last_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gender -->
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">{{ __('members.gender') }} <span class="text-red-500">*</span></label>
                    <select name="gender" id="gender" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                        <option value="">{{ __('messages.select') }}...</option>
                        <option value="male" {{ old('gender', $member->gender) == 'male' ? 'selected' : '' }}>{{ __('members.male') }}</option>
                        <option value="female" {{ old('gender', $member->gender) == 'female' ? 'selected' : '' }}>{{ __('members.female') }}</option>
                    </select>
                    @error('gender')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date of Birth -->
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">{{ __('members.date_of_birth') }}</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $member->date_of_birth ? $member->date_of_birth->format('Y-m-d') : '') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                    @error('date_of_birth')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Marital Status -->
                <div>
                    <label for="marital_status" class="block text-sm font-medium text-gray-700 mb-1">{{ __('members.marital_status') }}</label>
                    <select name="marital_status" id="marital_status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                        <option value="">{{ __('messages.select') }}...</option>
                        <option value="single" {{ old('marital_status', $member->marital_status) == 'single' ? 'selected' : '' }}>{{ __('members.single') }}</option>
                        <option value="married" {{ old('marital_status', $member->marital_status) == 'married' ? 'selected' : '' }}>{{ __('members.married') }}</option>
                        <option value="divorced" {{ old('marital_status', $member->marital_status) == 'divorced' ? 'selected' : '' }}>{{ __('members.divorced') }}</option>
                        <option value="widowed" {{ old('marital_status', $member->marital_status) == 'widowed' ? 'selected' : '' }}>{{ __('members.widowed') }}</option>
                    </select>
                    @error('marital_status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Family Information -->
                <div class="col-span-1 md:col-span-2 mt-4">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">{{ __('members.family_info') }}</h3>
                </div>

                <!-- Father -->
                <div>
                    <label for="father_id" class="block text-sm font-medium text-gray-700 mb-1">{{ __('members.father') }}</label>
                    <select name="father_id" id="father_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                        <option value="">{{ __('messages.select') }}...</option>
                        @foreach($males as $male)
                            <option value="{{ $male->id }}" {{ old('father_id', $member->father_id) == $male->id ? 'selected' : '' }}>{{ $male->full_name }} ({{ $male->member_number }})</option>
                        @endforeach
                    </select>
                    @error('father_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mother -->
                <div>
                    <label for="mother_id" class="block text-sm font-medium text-gray-700 mb-1">{{ __('members.mother') }}</label>
                    <select name="mother_id" id="mother_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                        <option value="">{{ __('messages.select') }}...</option>
                        @foreach($females as $female)
                            <option value="{{ $female->id }}" {{ old('mother_id', $member->mother_id) == $female->id ? 'selected' : '' }}>{{ $female->full_name }} ({{ $female->member_number }})</option>
                        @endforeach
                    </select>
                    @error('mother_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Membership Status -->
                <div>
                    <label for="membership_status" class="block text-sm font-medium text-gray-700 mb-1">{{ __('members.membership_status') }} <span class="text-red-500">*</span></label>
                    <select name="membership_status" id="membership_status" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                        <option value="active" {{ old('membership_status', $member->membership_status) == 'active' ? 'selected' : '' }}>{{ __('members.active') }}</option>
                        <option value="inactive" {{ old('membership_status', $member->membership_status) == 'inactive' ? 'selected' : '' }}>{{ __('members.inactive') }}</option>
                        <option value="deceased" {{ old('membership_status', $member->membership_status) == 'deceased' ? 'selected' : '' }}>{{ __('members.deceased') }}</option>
                        <option value="suspended" {{ old('membership_status', $member->membership_status) == 'suspended' ? 'selected' : '' }}>{{ __('members.suspended') }}</option>
                    </select>
                    @error('membership_status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contact & Location -->
                <div class="col-span-1 md:col-span-2 mt-4">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">{{ __('members.contact') }} & {{ __('members.location') }}</h3>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">{{ __('auth.email') }}</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $member->email) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">{{ __('members.phone') }}</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $member->phone) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Region -->
                <div>
                    <label for="region" class="block text-sm font-medium text-gray-700 mb-1">{{ __('members.region') }}</label>
                    <input type="text" name="region" id="region" value="{{ old('region', $member->region) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                    @error('region')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- District -->
                <div>
                    <label for="district" class="block text-sm font-medium text-gray-700 mb-1">{{ __('members.district') }}</label>
                    <input type="text" name="district" id="district" value="{{ old('district', $member->district) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                    @error('district')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Village -->
                <div>
                    <label for="village" class="block text-sm font-medium text-gray-700 mb-1">{{ __('members.village') }}</label>
                    <input type="text" name="village" id="village" value="{{ old('village', $member->village) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                    @error('village')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Occupation -->
                <div>
                    <label for="occupation" class="block text-sm font-medium text-gray-700 mb-1">{{ __('members.occupation') }}</label>
                    <input type="text" name="occupation" id="occupation" value="{{ old('occupation', $member->occupation) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                    @error('occupation')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Profession -->
                <div>
                    <label for="profession" class="block text-sm font-medium text-gray-700 mb-1">{{ __('members.profession') ?? 'Profession' }}</label>
                    <input type="text" name="profession" id="profession" value="{{ old('profession', $member->profession) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" placeholder="e.g. Software Engineer">
                    @error('profession')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Skills -->
                <div class="col-span-1 md:col-span-2">
                    <label for="skills" class="block text-sm font-medium text-gray-700 mb-1">{{ __('members.skills') ?? 'Skills (Comma separated)' }}</label>
                    <input type="text" name="skills" id="skills" value="{{ old('skills', $member->skills ? implode(', ', $member->skills) : '') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" placeholder="e.g. Leadership, Accounting, Teaching">
                    <p class="text-xs text-gray-500 mt-1">{{ __('members.skills_help') ?? 'Enter skills separated by commas' }}</p>
                    @error('skills')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Others -->
                <div class="col-span-1 md:col-span-2 mt-4">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">{{ __('messages.other') }}</h3>
                </div>

                <!-- Profile Photo -->
                <div class="col-span-1 md:col-span-2">
                    <label for="profile_photo" class="block text-sm font-medium text-gray-700 mb-1">{{ __('members.profile_photo') }}</label>
                    @if($member->profile_photo)
                        <div class="mb-2">
                            <img src="{{ Storage::url($member->profile_photo) }}" alt="Current Photo" class="h-16 w-16 rounded-full object-cover">
                        </div>
                    @endif
                    <input type="file" name="profile_photo" id="profile_photo" accept="image/*" class="w-full border border-gray-300 rounded-md shadow-sm p-2 bg-white focus:outline-none focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                    <p class="text-xs text-gray-500 mt-1">Leave blank to keep current photo.</p>
                    @error('profile_photo')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('members.show', $member) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-6 rounded shadow transition-colors">
                    {{ __('messages.cancel') }}
                </a>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded shadow transition-colors">
                    {{ __('messages.update') }}
                </button>
            </div>
        </form>
    </div>
@endsection
