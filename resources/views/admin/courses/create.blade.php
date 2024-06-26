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
                    {{ __("Create new course") }}
                </div>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <form method="POST" action="{{ route('admin.courses.store') }}" class="max-w-2xl mx-auto my-8">
                        @csrf

                        <div class="py-2">
                            <x-input-label for="name">Course Title</x-input-label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" >
                        </div>
                        @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <div class="flex items-center space-x-2 mb-3">
                            <x-input-label for="is_elective_group" >The course is a placeholder for elective group</x-input-label>
                            <input type="checkbox" class="rounded" name="is_elective_group">
                        </div>

                        <div class="py-2">
                            <x-input-label for="credits">Course Credits</x-input-label>
                            <input type="number" name="credits" id="credits" value="{{ old('credits') }}" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        @error('credits')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <div class="py-2">
                            <x-input-label for="semester" class="block text-sm font-medium text-gray-700">Course Semester</x-input-label>
                            <input type="number" name="semester" value="{{ old('semester') }}" id="semester" required min="1" max="8" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        @error('semester')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <div class="py-2">
                            <x-input-label for="code" class="block text-sm font-medium text-gray-700">Course Code</x-input-label>
                            <input type="text" name="code" id="code" value="{{ old('semester') }}" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        @error('code')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <x-input-label for="major_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Major</x-input-label>
                        <select id="major_id" name="major_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md">
                            <option value="">Choose a major</option>
                            @foreach ($majors as $major)
                            <option value="{{ $major->id }}" {{ old('major_id') == $major->id ? 'selected' : ''}}>{{ $major->name }}</option>

                            @endforeach
                        </select>
                        <x-input-label class="my-2">Course type:</x-input-label>
                        <div class="flex items-center space-x-2 mb-3">
                            <x-input-label for="lecture">Lectures</x-input-label>
                            <input type="checkbox" class="rounded" name="hasLectures">
                            <x-input-label for="seminars">Seminars</x-input-label>
                            <input type="checkbox" class="rounded" name="hasSeminars">
                            <x-input-label for="labs">Labs</x-input-label>
                            <input type="checkbox" class="rounded" name="hasLabs">
                        </div>
                        <x-input-label class="my-2">Control type:</x-input-label>
                        <div class="flex items-center space-x-2 mb-3">
                            <x-input-label for="exam">Exam</x-input-label>
                            <input type="checkbox" class="rounded" id="exam" name="hasExam">
                            <x-input-label for="oa">Ongoing Assessment</x-input-label>
                            <input type="checkbox" class="rounded" id="oa" name="hasOa">
                            <x-input-label for="cp">Course Project</x-input-label>
                            <input type="checkbox" class="rounded" id="cp" name="hasCp">
                            <x-input-label for="cw">Course Work</x-input-label>
                            <input type="checkbox" class="rounded" id="cw" name="hasCw">
                        </div>

                        <x-input-label for="elective_course_group_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select a elective group to attach the course to:</x-input-label>
                        <select id="elective_course_group_id" name="elective_course_group_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md">
                            
                            @if ($ecourses->isEmpty())
                                <option selected disabled>No elective groups available</option>
                            @else
                                <option value="">Choose an elective group</option>
                                @foreach ($ecourses as $ecourse)
                                    <option value="{{ $ecourse->id }}" {{ old('elective_course_group_id') == $ecourse->id ? 'selected' : ''}}>{{ $ecourse->name }}</option>
                                @endforeach
                            @endif
                            
                            
                        </select>

                        @if ($errors->any())
                        <div class="alert alert-danger dark:text-white">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="py-6">
                            <x-primary-button>Add Course</x-primary-button>
                        </div>


                    </form>
                </div>

            </div>
        </div>
    </div>


</x-admin-layout>