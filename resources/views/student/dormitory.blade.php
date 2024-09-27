<x-student-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Apply for Dormitory') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($accommodation != null)
                        <p class="mt-1">{{ __('You are currently accommodated in building') }} {{ $accommodation->dormitory->building }}, {{ __('room') }}  {{ $accommodation->room->room_number }}.</p>
                    @else
                        <p class="mt-1">{{ __('You are currently not accommodated') }}.</p>

                    @endif
                    @if ($application != null)
                        <p class="mt-1">{{ __('You have already submitted an application for dormitory for academic year') }} {{ $application->academic_year }}.</p>
                        <p class="mt-1">{{ __('Your application is') }} {{ __($application->status) }}.</p>
                    @else
                        <form method="POST" action="{{ route('student.dormitory_applications.store') }}">
                            @csrf

                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button>
                                    {{ __('Submit Application') }}
                                </x-primary-button>
                            </div>
                        </form>
                    @endif


                </div>
            </div>
        </div>
    </div>


</x-student-layout>