<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{  __('Major') . " " . $major->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:p-6 lg:p-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="flex items-center justify-between">
                    <div class="p-6 text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ __('Study Plans') }}
                    </div>
                    <div class="m-5">
                        <a href="/study-plans/create" class="font-medium bg-blue-500 hover:bg-blue-600 text-white py-2 px-8 rounded-md">{{ __('New study plan') }}</a>
                    </div>

                </div>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                    <div class="py-2">
                        @foreach ($major->studyPlans as $studyPlan)
                        <p class="px-6 py-2"><a href="{{ route('admin.studyplans.show', $studyPlan) }}" class="text-blue-500 hover:underline" >{{ $studyPlan->title }}</a></p>
                        @endforeach
                    </div>


                </div>

            </div>
        </div>
    </div>


</x-admin-layout>