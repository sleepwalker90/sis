<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Course Schedule') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.course-schedules.update', $courseSchedule) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="course_lecturer_assignment_id" class="block text-sm font-medium text-gray-700">Course Lecturer Assignment</label>
                        <select id="course_lecturer_assignment_id" name="course_lecturer_assignment_id" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @foreach($courseLecturerAssignments as $assignment)
                            <option value="{{ $assignment->id }}" {{ $courseSchedule->course_lecturer_assignment_id == $assignment->id ? 'selected' : '' }}>
                                {{ $assignment->course->name }} - {{ $assignment->lecturer->user->first_name }} {{ $assignment->lecturer->user->last_name }} ({{ $assignment->studyPlan->title }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="group_id" class="block text-sm font-medium text-gray-700">Group (optional)</label>
                        <select id="group_id" name="group_id" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <option value="">Select Group</option>
                            @foreach($groups as $group)
                            <option value="{{ $group->id }}" {{ $courseSchedule->group_id == $group->id ? 'selected' : '' }}>
                                {{ $group->number }} - {{ $group->academicYear->year }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="class_type" class="block text-sm font-medium text-gray-700">Class Type</label>
                        <select id="class_type" name="class_type" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <option value="lecture" {{ $courseSchedule->class_type == 'lecture' ? 'selected' : '' }}>Lecture</option>
                            <option value="lab" {{ $courseSchedule->class_type == 'lab' ? 'selected' : '' }}>Lab</option>
                            <option value="seminar" {{ $courseSchedule->class_type == 'seminar' ? 'selected' : '' }}>Seminar</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="day_of_week" class="block text-sm font-medium text-gray-700">Day of Week</label>
                        <select id="day_of_week" name="day_of_week" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <option value="Monday" {{ $courseSchedule->day_of_week == 'Monday' ? 'selected' : '' }}>Monday</option>
                            <option value="Tuesday" {{ $courseSchedule->day_of_week == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                            <option value="Wednesday" {{ $courseSchedule->day_of_week == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                            <option value="Thursday" {{ $courseSchedule->day_of_week == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                            <option value="Friday" {{ $courseSchedule->day_of_week == 'Friday' ? 'selected' : '' }}>Friday</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                        <input type="time" id="start_time" name="start_time" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $courseSchedule->start_time }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                        <input type="time" id="end_time" name="end_time" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $courseSchedule->end_time }}" required>
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
                        <x-primary-button>Update Schedule</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
