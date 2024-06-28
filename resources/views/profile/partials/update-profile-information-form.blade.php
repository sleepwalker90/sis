<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile picture.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="flex">
            <div>
                <x-input-label for="photo" :value="__('Photo')" />
                <input id="photo" name="photo" type="file" class="mt-1 rounded-none" />
                <x-input-error class="mt-2" :messages="$errors->get('photo')" />
            </div>
            @if (Auth::user()->photo)
            <div>
                <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="{{ Auth::user()->photo }}" class="w-24 h-24 rounded-full border border-gray-300" />
            </div>
            @endif


        </div>





        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>