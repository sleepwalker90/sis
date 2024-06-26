<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Добави дисциплина към учебен план: " . $studyPlan->title . "!") }}
                </div>

                <div class="container flex justify-between">
                    <div class="mx-auto">
                        @if ($availableCourses->count() > 0)
                        <form method="POST" action="{{ route('admin.studyplans.courses.attach', ['studyPlan' => $studyPlan->id]) }}" class="max-w-2xl mx-auto my-8">
                            @csrf

                            <x-input-label for="course_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Достъпни за добавяне дисциплини: </x-input-label>
                            <select id="course_id" name="course_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md">
                                <option value="">Избери дисциплина</option>
                                @foreach ($availableCourses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : ''}}>{{ $course->name }}</option>
                                @endforeach
                            </select>

                            <x-input-label for="semester" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Семестър</x-input-label>
                            <select id="semester" name="semester" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md">
                                <option value="">Избери семестър</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
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
                                <x-primary-button>Добави Дисциплина</x-primary-button>
                            </div>
                        </form>
                        @else
                            <p>Няма дисциплини за добавяне. Моля добавете нови учебни дисциплини</p>
                        @endif
                    </div>
                    <div class="max-w-2xl mx-auto">
                        <table class="w-xl text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="p-3">
                                        Текущи предмети:
                                    </th>
                                    <th scope="col" class="p-3 text-end">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attachedCourses as $semester => $courses)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th colspan="6" class="p-4 text-center text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">Семестър {{ $semester }}</th>
                                </tr>
                                @foreach ($courses as $course)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-3 py-4">
                                        <div class="font-semibold text-black"><a href="{{ route('admin.courses.show', ['course' => $course->id] ) }}">{{ $course->name }}</a></div>
                                    </td>
                                    <td class="px-3 py-4 text-end">
                                        <form method="POST" action="{{ route('admin.studyplans.courses.detach', ['studyPlan' => $studyPlan->id, 'course' => $course->id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
