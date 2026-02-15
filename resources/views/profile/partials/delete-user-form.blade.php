<section class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider">{{ __('profile.delete_account') }}</h3>
            <p class="text-xs text-gray-500 mt-1">{{ __('profile.delete_account_desc') }}</p>
        </div>
        <button 
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="px-4 py-2 bg-red-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
        >
            {{ __('profile.delete_account') }}
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <div class="flex items-center space-x-3 mb-6">
                <div class="p-2 bg-red-100 rounded-full text-red-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">
                    {{ __('profile.delete_confirm') }}
                </h2>
            </div>

            <p class="text-sm text-gray-600 mb-6 bg-red-50 p-4 rounded-lg border border-red-100">
                {{ __('profile.delete_warning') }}
            </p>

            <div class="mb-6">
                <label for="password" class="sr-only">{{ __('profile.current_password') }}</label>
                <input 
                    id="password"
                    name="password"
                    type="password"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 focus:ring-opacity-50"
                    placeholder="{{ __('profile.current_password') }}"
                />
                @error('password', 'userDeletion')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 bg-white border border-gray-300 rounded-lg font-bold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('messages.cancel') }}
                </button>

                <button type="submit" class="px-4 py-2 bg-red-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('profile.delete_account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
