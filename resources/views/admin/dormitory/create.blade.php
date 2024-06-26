<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:p-6 lg:p-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Добави ново общежитие") }}
                </div>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <form method="POST" action="{{ route('admin.dormitories.store') }}" class="max-w-2xl mx-auto my-8">
                        @csrf

                        <div class="py-2">
                            <label for="building" class="block text-sm font-medium text-gray-700">Блок: </label>
                            <input type="text" name="building" id="building" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('building') ?? '' }}">
                        </div>
                        @error('building')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        

                        <div class="py-6">
                            <x-primary-button>Добави общежитие</x-primary-button>
                        </div>


                    </form>
                </div>

            </div>
        </div>
    </div>


</x-admin-layout>