<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($tiles as $tile)
                        <a href="{{ route($tile['route']) }}" class="block bg-gray-100 dark:bg-gray-900 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-lg shadow p-6">
                            <div class="flex items-center">
                                <div class="text-4xl text-blue-500 mr-4">
                                    <i class="{{ $tile['icon'] }}"></i>
                                </div>
                                <div class="text-lg font-medium text-gray-800 dark:text-gray-200">
                                    {{ __($tile['title']) }}
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
