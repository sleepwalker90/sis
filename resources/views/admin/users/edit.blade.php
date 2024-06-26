<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin') }}
        </h2>
    </x-slot>

    <div class="container max-w-7xl mx-auto py-8">
        <div class="bg-white shadow rounded-lg p-6 items-center">
            <form action="{{ route('admin.users.update',['user' => $user ]) }}" method="POST" class="max-w-3xl mx-auto">
                @csrf
                @method('PATCH')
                <div class="flex items-center">
                    <img src="https://i.pravatar.cc/150?img={{$user->id}}" class="w-32 h-32 bg-gray-300 rounded-full mb-4 shrink-0">

                    </img>

                    <div class="ml-6 flex justify-end">
                        <label for="photo" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-8 rounded-md">Upload new photo</label>
                        <input type="file" id="photo" class="hidden" name="photos"></input>
                        <a href="#" class="bg-gray-300 hover:bg-gray-400 text-gray-700 ml-4 py-2 px-4 rounded-md">Delete</a>
                    </div>
                </div>
                <div class="flex items-center">
                    <x-input-label for="first_name" :value="__('First Name')" class="w-32" />
                    <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name', $user->first_name)" required autofocus autocomplete="first-name" />
                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                </div>

                <div class="flex items-center">
                    <x-input-label for="middle_name" :value="__('Middle Name')" class="w-32" />
                    <x-text-input id="middle_name" class="block mt-1 w-full" type="text" name="middle_name" :value="old('middle_name', $user->middle_name)" autofocus autocomplete="middle-name" />
                    <x-input-error :messages="$errors->get('middle_name')" class="mt-2 block" />
                </div>

                <div class="flex items-center">
                    <x-input-label for="last_name" :value="__('Last Name')" class="w-32" />
                    <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name', $user->last_name)" required autofocus autocomplete="last-name" />
                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                </div>

                <div class="flex items-center">
                    <x-input-label for="email" :value="__('Email ')" class="w-32" />
                    <x-text-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email', $user->email)" required autofocus autocomplete="email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 block" />
                </div>

                <div class="flex items-center">
                    <x-input-label for="phone_number" :value="__('Phone number')" class="w-32" />
                    <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number', $user->phone_number)" required autofocus autocomplete="phone_number" />
                    <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ms-4">
                        {{ __('Save') }}
                    </x-primary-button>


                    <a href="{{ route('admin.users') }}" class="inline-flex items-center ml-4 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">{{ __('Cancel') }}</a>

                </div>




            </form>
        </div>


    </div>


</x-admin-layout>