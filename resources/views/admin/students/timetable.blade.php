<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Student Timetable') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @php
                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                @endphp

                @foreach($days as $day)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200">{{ __($day) }}</h3>
                    <ul>
                        @foreach($groupSchedules as $schedule)
                        @if($schedule->day_of_week === $day)
                        <li class="mt-2">
                            <span class="font-semibold">{{ $schedule->courseLecturerAssignment->course->name }}</span> ({{ ucfirst($schedule->class_type) }}):
                            {{ date('H:i', strtotime($schedule->start_time)) }} - {{ date('H:i', strtotime($schedule->end_time)) }}
                        </li>
                        @endif
                        @endforeach
                    </ul>
                </div>
                @endforeach
            </div>
        </div>
    </div>


</x-admin-layout>