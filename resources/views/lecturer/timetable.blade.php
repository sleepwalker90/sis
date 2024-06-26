<x-lecturer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lecturer Timetable') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-5 gap-4">
            @php
            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
            @endphp

            @foreach($days as $day)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200">{{ __($day) }}</h3>
                @if (isset($lecturerSchedules) && count($lecturerSchedules) > 0)
                <ul>
                    @foreach($lecturerSchedules as $schedule)
                    @if($schedule->day_of_week === $day)
                    <li class="mt-2">
                        <span class="font-semibold">{{ $schedule->courseLecturerAssignment->course->name }}</span> ({{ ucfirst($schedule->class_type) }}):
                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                    </li>
                    @endif
                    @endforeach
                </ul>

                @endif

            </div>
            @endforeach
        </div>
    </div>
</x-lecturer-layout>