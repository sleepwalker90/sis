<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:p-6 lg:p-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Show course " . $course->name) }}
                </div>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <p class="text-2xl text-semibold text-red-500">{{$course->is_elective_group ? 'Elective course group' : 'Course' }}</p>
                    <div>
                        @if ($course->electiveCourses->isNotEmpty())
                            <p>Elective courses in this course group:</p>
                            @foreach ( $course->electiveCourses as $electiveCourse )
                                <div><a href="{{ route('admin.courses.show', $electiveCourse) }}">{{ $electiveCourse->name }}</a></div>
                            @endforeach 
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>


</x-admin-layout>