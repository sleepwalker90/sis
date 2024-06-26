<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:p-6 lg:p-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="flex items-center justify-between">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ __("Major: " . $major->name) }}
                    </div>
                    <div class="m-5">
                        <a href="/study-plans/create" class="font-medium bg-blue-500 hover:bg-blue-600 text-white py-2 px-8 rounded-md">New study plan</a>
                    </div>

                </div>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">


                    <div class="py-2">
                        <p class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ $major->name }}</p>
                    </div>

                    <div class="py-2">
                        @foreach ($major->studyPlans as $studyPlan)
                        <p>{{ $studyPlan->title }}</p>
                        @endforeach
                    </div>


                </div>

            </div>
        </div>
    </div>


</x-admin-layout>