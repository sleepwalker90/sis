<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Course Schedules') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Manage Course Schedules") }}
                </div>
                <div class="flex justify-end mb-4">
                    <a href="{{ route('admin.course-schedules.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Create Course Schedule</a>
                </div>
                <table class="min-w-full bg-white dark:bg-gray-800">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Course</th>
                            <th class="px-4 py-2">Lecturer</th>
                            <th class="px-4 py-2">Study Plan</th>
                            <th class="px-4 py-2">Stream</th>
                            <th class="px-4 py-2">Group</th>
                            <th class="px-4 py-2">Class Type</th>
                            <th class="px-4 py-2">Day of Week</th>
                            <th class="px-4 py-2">Start Time</th>
                            <th class="px-4 py-2">End Time</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courseSchedules as $courseSchedule)
                        <tr>
                            <td class="border px-4 py-2">{{ $courseSchedule->courseLecturerAssignment->course->name }}</td>
                            <td class="border px-4 py-2">{{ $courseSchedule->courseLecturerAssignment->lecturer->user->first_name }} {{ $courseSchedule->courseLecturerAssignment->lecturer->user->last_name }}</td>
                            <td class="border px-4 py-2">{{ $courseSchedule->courseLecturerAssignment->studyPlan->title }}</td>
                            <td class="border px-4 py-2">{{ $courseSchedule->courseLecturerAssignment->stream->number }}</td>
                            <td class="border px-4 py-2">{{ optional($courseSchedule->group)->number }}</td>
                            <td class="border px-4 py-2">{{ ucfirst($courseSchedule->class_type) }}</td>
                            <td class="border px-4 py-2">{{ $courseSchedule->day_of_week }}</td>
                            <td class="border px-4 py-2">{{ $courseSchedule->start_time }}</td>
                            <td class="border px-4 py-2">{{ $courseSchedule->end_time }}</td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('admin.course-schedules.edit', $courseSchedule) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded">Edit</a>
                                <form action="{{ route('admin.course-schedules.destroy', $courseSchedule) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
