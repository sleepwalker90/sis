<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Assign lecturer to the course') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200">{{ __('Study Plan') }}: {{ $studyPlan->title }}</h3>
                    <h4 class="text-md font-medium text-gray-700 dark:text-gray-400">{{ __('Course') }}: {{ $course->name }}</h4>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="col-span-3">
                        <h4 class="text-md font-medium text-gray-700 dark:text-gray-400 mb-2">{{ __('Assigned Lecturers') }}</h4>
                        <table class="min-w-full bg-white dark:bg-gray-800 border rounded-sm border-separate">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border">{{ __('Lecturer') }}</th>
                                    <th class="px-4 py-2 border">{{ __('Stream') }}</th>
                                    <th class="px-4 py-2 border">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assignedLecturers as $assignment)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $assignment->lecturer->user->first_name }} {{ $assignment->lecturer->user->last_name }}</td>
                                        <td class="border px-4 py-2">{{ $assignment->stream->number }}</td>
                                        <td class="border px-4 py-2 text-center flex space-x-2 justify-center">
                                            <form action="{{ route('admin.course-assignments.unassign', $assignment) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded">{{ __('Unassign') }}</button>
                                            </form>
                                            <a href="{{ route('admin.course_schedules.create', $assignment) }}">
                                                <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded">{{ __('Schedule') }}</button>
                                            </a>
                                            <a href="{{ route('admin.attestations.show', $assignment) }}">
                                                <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 rounded">{{ __('Attestations') }}</button>
                                            </a>
                                            <a href="{{ route('admin.marks.show', $assignment) }}">
                                                <button class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-1 px-3 rounded">{{ __('Marks') }}</button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="col-span-1">
                        <h4 class="text-md font-medium text-gray-700 dark:text-gray-400 mb-2">{{ __('Assign Lecturer') }}</h4>
                        <form method="POST" action="{{ route('admin.course-assignments.assign') }}">
                            @csrf

                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                            <input type="hidden" name="study_plan_id" value="{{ $studyPlan->id }}">

                            <div class="mb-4">
                                <label for="lecturer_id" class="block text-sm font-medium text-gray-700">{{ __('Lecturer') }}</label>
                                <select id="lecturer_id" name="lecturer_id" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                    @foreach($lecturers as $lecturer)
                                        <option value="{{ $lecturer->id }}">{{ $lecturer->user->first_name }} {{ $lecturer->user->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="stream_id" class="block text-sm font-medium text-gray-700">{{ __('Stream') }}</label>
                                <select id="stream_id" name="stream_id" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                    @foreach($streams as $stream)
                                        <option value="{{ $stream->id }}">{{ $stream->number }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex justify-end">
                                <x-primary-button>{{ __('Assign Lecturer') }}</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
