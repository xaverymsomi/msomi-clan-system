<section>
    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('patch')

        <div class="flex flex-col md:flex-row gap-8">
            <!-- Avatar Section -->
            <div class="flex-shrink-0 flex flex-col items-center space-y-4">
                <div class="relative group">
                    <div class="h-32 w-32 rounded-full overflow-hidden border-4 border-indigo-100 shadow-sm transition-all duration-300 group-hover:border-indigo-200">
                        @if($user->avatar)
                            <img id="avatar-preview" class="h-full w-full object-cover" src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                        @else
                            <div id="avatar-placeholder" class="h-full w-full bg-indigo-50 flex items-center justify-center text-indigo-300">
                                <svg class="h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>
                <div>
                    <label for="avatar" class="cursor-pointer inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        {{ __('profile.avatar') }}
                    </label>
                    <input type="file" name="avatar" id="avatar" class="hidden" accept="image/*" onchange="previewAvatar(this)">
                    @error('avatar')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Fields Section -->
            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="col-span-1 md:col-span-2">
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-1">{{ __('messages.name') }}</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-1">{{ __('messages.email') }}</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-bold text-gray-700 mb-1">{{ __('profile.phone') }}</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Language -->
                <div>
                    <label for="language_preference" class="block text-sm font-bold text-gray-700 mb-1">{{ __('profile.language') }}</label>
                    <select name="language_preference" id="language_preference" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="en" {{ old('language_preference', $user->language_preference) == 'en' ? 'selected' : '' }}>{{ __('messages.english') }}</option>
                        <option value="sw" {{ old('language_preference', $user->language_preference) == 'sw' ? 'selected' : '' }}>{{ __('messages.swahili') }}</option>
                    </select>
                    @error('language_preference')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
            <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-indigo-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('profile.save') }}
            </button>

            @if (session('success'))
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-medium"
                >{{ session('success') }}</p>
            @endif
        </div>
    </form>
</section>

<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            let preview = document.getElementById('avatar-preview');
            let placeholder = document.getElementById('avatar-placeholder');
            
            if (preview) {
                preview.src = e.target.result;
            } else {
                let img = document.createElement('img');
                img.id = 'avatar-preview';
                img.className = 'h-full w-full object-cover';
                img.src = e.target.result;
                if (placeholder) {
                    placeholder.parentNode.replaceChild(img, placeholder);
                } else {
                    // fall back if something is wrong
                    location.reload(); 
                }
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
