<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __("Create new course") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:p-6 lg:p-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <form method="POST" action="{{ route('admin.courses.store') }}" class="max-w-2xl mx-auto my-8">
                        @csrf

                        <div class="py-2">
                            <x-input-label for="name">{{ __('Course Title') }}:</x-input-label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" >
                        </div>
                        @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <div class="flex items-center space-x-2 mb-3">
                            <x-input-label for="is_elective_group" >{{ __('The course is a placeholder for elective group') }}</x-input-label>
                            <input type="checkbox" class="rounded" name="is_elective_group">
                        </div>

                        <div class="py-2">
                            <x-input-label for="credits">{{ __('Credits') }}</x-input-label>
                            <input type="number" name="credits" id="credits" value="{{ old('credits') }}" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        @error('credits')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <div class="py-2">
                            <x-input-label for="code" class="block text-sm font-medium text-gray-700">{{ __('Code') }}</x-input-label>
                            <input type="text" name="code" id="code" value="{{ old('semester') }}" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        @error('code')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <x-input-label for="major_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Major') }} </x-input-label>
                        <select id="major_id" name="major_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md">
                            <option value="">{{ __('Choose a major') }}</option>
                            @foreach ($majors as $major)
                            <option value="{{ $major->id }}" {{ old('major_id') == $major->id ? 'selected' : ''}}>{{ $major->name }}</option>

                            @endforeach
                        </select>
                        <x-input-label class="my-2">{{ __('Course type') }}:</x-input-label>
                        <div class="flex items-center space-x-2 mb-3">
                            <x-input-label for="lecture">{{ __('Lectures') }}</x-input-label>
                            <input type="checkbox" class="rounded" name="hasLectures">
                            <x-input-label for="seminars">{{ __('Seminars') }}</x-input-label>
                            <input type="checkbox" class="rounded" name="hasSeminars">
                            <x-input-label for="labs">{{ __('Labs') }}</x-input-label>
                            <input type="checkbox" class="rounded" name="hasLabs">
                        </div>
                        <x-input-label class="my-2">{{ __('Control type') }}:</x-input-label>
                        <div class="flex items-center space-x-2 mb-3">
                            <x-input-label for="exam">{{ __('Exam') }}</x-input-label>
                            <input type="checkbox" class="rounded" id="exam" name="hasExam">
                            <x-input-label for="oa">{{ __('Ongoing Assessment') }}</x-input-label>
                            <input type="checkbox" class="rounded" id="oa" name="hasOa">
                            <x-input-label for="cp">{{ __('Course Project') }}</x-input-label>
                            <input type="checkbox" class="rounded" id="cp" name="hasCp">
                            <x-input-label for="cw">{{ __('Course Work') }}</x-input-label>
                            <input type="checkbox" class="rounded" id="cw" name="hasCw">
                        </div>

                        <x-input-label for="elective_course_group_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Select a elective group to attach the course to') }}:</x-input-label>
                        <select id="elective_course_group_id" name="elective_course_group_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md">
                            
                            @if ($ecourses->isEmpty())
                                <option selected disabled>{{ __('No elective groups available') }}</option>
                            @else
                                <option value="">{{ __('Choose an elective group') }}</option>
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
                            <x-primary-button>{{ __('Create Course') }}</x-primary-button>
                        </div>


                    </form>
                </div>

            </div>
        </div>
    </div>


</x-admin-layout>