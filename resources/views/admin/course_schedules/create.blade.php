<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Course Schedule') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ classType: '', validClassTypes: @js($validClassTypes) }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200 mb-4">
                    {{ __('Course') }}: {{ $courseLecturerAssignment->course->name }}
                </h3>
                <h4 class="text-md font-medium text-gray-700 dark:text-gray-400 mb-4">
                    {{ __('Lecturer') }}: {{ $courseLecturerAssignment->lecturer->user->first_name }} {{ $courseLecturerAssignment->lecturer->user->last_name }}
                </h4>
                <h4 class="text-md font-medium text-gray-700 dark:text-gray-400 mb-4">
                    {{ __('Study Plan') }}: {{ $courseLecturerAssignment->studyPlan->title }}
                </h4>
                <h4 class="text-md font-medium text-gray-700 dark:text-gray-400 mb-4">
                    {{ __('Stream') }}: {{ $courseLecturerAssignment->stream->number }}
                </h4>

                <div class="mb-6">
                    <h5 class="text-md font-medium text-gray-700 dark:text-gray-400">{{ __('Lecturer\'s Existing Schedules') }}</h5>
                    @if($lecturerSchedules->isEmpty())
                    <p>{{ __('No schedules found.') }}</p>
                    @else
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        @foreach($lecturerSchedules->groupBy('day_of_week') as $day => $schedules)
                        <div>
                            <h6 class="font-semibold">{{ $day }}:</h6>
                            <ul class="mb-2">
                                @foreach($schedules as $schedule)
                                <li class="flex items-center justify-between">
                                    <span>{{ date('H:i', strtotime($schedule->start_time)) }} - {{ date('H:i', strtotime($schedule->end_time)) }} - {{ $schedule->courseLecturerAssignment->course->name }} ({{ ucfirst($schedule->class_type) }})</span>
                                    @if($schedule->course_lecturer_assignment_id == $courseLecturerAssignment->id)
                                    <form action="{{ route('admin.course_schedules.destroy', $schedule) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endforeach

                    </div>
                    @endif
                </div>

                <div class="mb-6">
                    <h5 class="text-md font-medium text-gray-700 dark:text-gray-400">{{ __('Stream\'s Existing Schedules') }}</h5>
                    @if($streamSchedules->isEmpty())
                    <p>{{ __('No schedules found.') }}</p>
                    @else
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($streamSchedules->groupBy('day_of_week') as $day => $schedules)
                        <div>
                            <h6 class="font-semibold">{{ $day }}:</h6>
                            <ul class="mb-2">
                                @foreach($schedules as $schedule)
                                <li class="flex items-center justify-between">
                                    <span>{{ date('H:i', strtotime($schedule->start_time)) }} - {{ date('H:i', strtotime($schedule->end_time)) }} - {{ $schedule->courseLecturerAssignment->course->name }} ({{ ucfirst($schedule->class_type) }})</span>
                                    @if($schedule->course_lecturer_assignment_id == $courseLecturerAssignment->id)
                                    <form action="{{ route('admin.course_schedules.destroy', $schedule) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <div class="mb-6">
                    <h5 class="text-md font-medium text-gray-700 dark:text-gray-400">{{ __('Groups\' Existing Schedules') }}</h5>
                    @if($groupSchedules->isEmpty())
                    <p>{{ __('No schedules found.') }}</p>
                    @else
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($groupSchedules->groupBy('day_of_week') as $day => $schedules)
                        <div>
                            <h6 class="font-semibold">{{ $day }}:</h6>
                            @foreach($schedules->groupBy('group_id') as $groupId => $groupSchedules)
                            <h6 class="ml-4">{{ __('Group') }} {{ $groupId }}:</h6>
                            <ul class="mb-2 ml-6">
                                @foreach($groupSchedules as $schedule)
                                <li class="flex items-center justify-between">
                                    <span>{{ date('H:i', strtotime($schedule->start_time)) }} - {{ date('H:i', strtotime($schedule->end_time)) }} - {{ $schedule->courseLecturerAssignment->course->name }} ({{ ucfirst($schedule->class_type) }})</span>
                                    @if($schedule->course_lecturer_assignment_id == $courseLecturerAssignment->id)
                                    <form action="{{ route('admin.course_schedules.destroy', $schedule) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                </li>
                                @endforeach
                            </ul>

                            @endforeach
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <form method="POST" action="{{ route('admin.course_schedules.store') }}">
                    @csrf

                    <input type="hidden" name="course_lecturer_assignment_id" value="{{ $courseLecturerAssignment->id }}">

                    <div class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="class_type" class="block text-sm font-medium text-gray-700">{{ __('Class Type') }}</label>
                            <select id="class_type" name="class_type" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" required x-model="classType">
                                <option value="">{{ __('Select Class Type') }}</option>
                                <template x-for="type in validClassTypes" :key="type">
                                    <option :value="type" x-text="{{ __('type.charAt(0).toUpperCase() + type.slice(1)') }}"></option>
                                </template>
                            </select>
                        </div>


                        <div>
                            <label for="day_of_week" class="block text-sm font-medium text-gray-700">{{ __('Day of the week') }}</label>
                            <select id="day_of_week" name="day_of_week" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                @php
                                    $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];                                 
                                @endphp
                                @foreach($daysOfWeek as $day)
                                    <option value="{{ $day }}">{{ __($day) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="start_time" class="block text-sm font-medium text-gray-700">{{ __('Start Time') }} </label>
                            <input type="time" id="start_time" name="start_time" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                        </div>
                        <div>
                            <label for="end_time" class="block text-sm font-medium text-gray-700">{{ __('End Time') }}</label>
                            <input type="time" id="end_time" name="end_time" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                        </div>
                        <div class="mb-4" x-show="classType === 'seminar' || classType === 'lab'" x-cloak>
                            <label for="group_id" class="block text-sm font-medium text-gray-700">{{ __('Group') }} </label>
                            <select id="group_id" name="group_id" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" :required="classType === 'seminar' || classType === 'lab'">
                                <option value="">{{ __('Select Group') }}</option>
                                @foreach($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->number }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>



                    @if ($errors->any())
                    <div class="alert alert-danger dark:text-white">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="flex justify-end">
                        <x-primary-button>{{ __('Save Schedule') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>