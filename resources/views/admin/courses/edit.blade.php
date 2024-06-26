<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create new course') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:p-6 lg:p-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg" x-data="{ isElectiveGroup: {{ $course->is_elective_group ? 'true' : 'false' }} }">
                    <form method="POST" action="{{ route('admin.courses.store') }}" class="max-w-2xl mx-auto my-8">
                        @csrf

                        <div class="py-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Course Title') }}</label>
                            <input type="text" name="name" id="name" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $course->name }}">
                        </div>
                        @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <!-- Hide elective course group selector if the course is not elective group and is attached to an elective group -->

                        <div class="flex items-center space-x-2 mb-3">
                            <x-input-label for="is_elective_group">{{ __('The course is a placeholder for elective group') }}</x-input-label>
                            <input type="checkbox" class="rounded" name="is_elective_group" {{ $course->is_elective_group ? 'checked' : ''}} x-model="isElectiveGroup">
                        </div>

                        <div class="py-2">
                            <label for="credits" class="block text-sm font-medium text-gray-700">{{ __('Credits') }}</label>
                            <input type="number" name="credits" id="credits" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $course->credits }}">
                        </div>
                        @error('credits')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <div class="py-2">
                            <label for="code" class="block text-sm font-medium text-gray-700">{{ __('Code') }}</label>
                            <input type="text" name="code" id="code" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $course->code }}">
                        </div>
                        @error('code')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <label for="major_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Major') }}</label>
                        <select id="major_id" name="major_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md">
                            <option selected>{{ __('Choose a major') }}</option>
                            @foreach ($majors as $major)
                            <option value="{{ $major->id }}" {{ $course->major_id == $major->id ? 'selected' : ''}}>{{ $major->name }}</option>
                            @endforeach
                        </select>
                        <p class="font-semibold mt-2">{{ __('Course type') }}:</p>
                        <div class="flex items-center space-x-2 mb-3">
                            <label for="lecture">{{ __('Lectures') }}</label>
                            <input type="checkbox" class="rounded" name="hasLectures" {{ $course->hasLectures ? 'checked' : ''}}>
                            <label for="seminars">{{ __('Seminars') }}</label>
                            <input type="checkbox" class="rounded" name="hasSeminars" {{ $course->hasSeminars ? 'checked' : ''}}>
                            <label for="labs">{{ __('Labs') }}</label>
                            <input type="checkbox" class="rounded" name="hasLabs" {{ $course->hasLabs ? 'checked' : ''}}>
                        </div>
                        <p class="font-semibold">{{ __('Control type') }}:</p>
                        <div class="flex items-center space-x-2 mb-3">
                            <label for="exam">{{ __('Exam') }}</label>
                            <input type="checkbox" class="rounded" id="exam" name="hasExam" {{ $course->hasExam ? 'checked' : ''}}>
                            <label for="oa">{{ __('Ongoing Assessment') }}</label>
                            <input type="checkbox" class="rounded" id="oa" name="hasOa" {{ $course->hasOa ? 'checked' : ''}}>
                            <label for="cp">{{ __('Course Project') }}</label>
                            <input type="checkbox" class="rounded" id="cp" name="hasCp" {{ $course->hasCp ? 'checked' : ''}}>
                            <label for="cw">{{ __('Course Work') }}</label>
                            <input type="checkbox" class="rounded" id="cw" name="hasCw" {{ $course->hasCw ? 'checked' : ''}}>
                        </div>
                        <!-- Hide elective course group id selector if the course is an elective group -->
                        <!-- Show the courses which are attached to an elective course group -->
                        <x-input-label for="elective_course_group_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Select a elective group to attach the course to') }}:</x-input-label>
                        <select id="elective_course_group_id" name="elective_course_group_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md" {{ $course->is_elective_group ? 'disabled' : ''}} :disabled="isElectiveGroup">

                            <option value="">{{ __('Choose an elective group') }}</option>
                            @foreach ($ecourses as $ecourse)
                            <option value="{{ $ecourse->id }}" {{ old('elective_course_group_id') == $ecourse->id ? 'selected' : ''}}>{{ __($ecourse->name) }}</option>
                            @endforeach

                        </select>
                        @if ($course->electiveCourses->isNotEmpty())
                        <div class="py-2">
                            <table>
                                <thead>
                                    <tr>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Code') }}</th>
                                        <th>{{ __('Credits') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>

                                @foreach ($course->electiveCourses as $electiveCourse )
                                <tr>
                                    <td>{{ $electiveCourse->name  }}</td>
                                    <td>{{ $electiveCourse->code }}</td>
                                    <td>{{ $electiveCourse->credits }}</td>
                                    <td>
                                        <form method="POST" action="">
                                            @csrf
                                            @method('DELETE')
                                            <x-primary-button>{{ __('Delete') }}</x-primary-button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </table>

                        </div>
                        @endif


                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="py-6">
                            <x-primary-button>{{ __('Update Course') }}</x-primary-button>
                        </div>


                    </form>
                </div>

            </div>
        </div>
    </div>


</x-admin-layout>