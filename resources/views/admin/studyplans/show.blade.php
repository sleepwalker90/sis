<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:p-6 lg:p-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
            x-data="{ 
                     showConfirmation: false, 
                     studyPlanId: '',
                     studyPlanCourseName: '',
                     studyPlanCourseId: '',
                     openConfirmationModal(studyPlanId, studyPlanCourseName, studyPlanCourseId) {
                         this.studyPlanId = studyPlanId;
                         this.studyPlanCourseName = studyPlanCourseName;
                         this.studyPlanCourseId = studyPlanCourseId;
                         this.showConfirmation = true;
                     } 
                 }">

                <div class="flex items-center justify-between">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ __("Study Plan: " . $studyPlan->title) }}
                    </div>
                    <div class="m-5">
                        <a href="{{ route('admin.studyplans.courses.attach.form', $studyPlan) }}" class="font-medium bg-blue-500 hover:bg-blue-600 text-white py-2 px-8 rounded-md">Add course</a>
                    </div>
                </div>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                    <div class="py-2">
                        <p class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ $studyPlan->title }}</p>
                    </div>

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="p-3">
                                        Предмет
                                    </th>
                                    <th scope="col" class="p-3">
                                        Код
                                    </th>
                                    <th scope="col" class="p-3">
                                        Изпит
                                    </th>
                                    <th scope="col" class="p-3 text-end">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coursesBySemester as $semester => $courses)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th colspan="6" class="p-4 text-center text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">Семестър {{ $semester }}</th>
                                </tr>
                                    @foreach ($courses as $course)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <td class="px-3 py-4">
                                                <div class="font-semibold text-black">
                                                    <a href="{{ route('admin.course-assignments.show', ['study_plan_id' => $studyPlan->id, 'course_id' => $course->id]) }}">
                                                        {{ $course->name }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="px-3 py-4">
                                                {{ $course->code }}
                                            </td>
                                            <td class="px-3 py-4">
                                                {{ $course->hasExam ? 'Yes' : 'No' }}
                                            </td>
                                            <td class="px-3 py-4 text-end">
                                                <div class="flex items-center justify-end space-x-4">
                                                    <form method="POST" action="{{ route('admin.studyplans.courses.detach', ['studyPlan' => $studyPlan, 'course' => $course->id]) }}" id="{{ $course->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="bg-red-500 hover:bg-red-600 text-white py-2 px-8 rounded-md" type="button" x-on:click="openConfirmationModal('{{ $studyPlan->id }}', '{{ $course->name }}', '{{ $course->id }}')">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-cloak x-show="showConfirmation">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" x-show="showConfirmation" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" x-show="showConfirmation" @click.away="showConfirmation = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-50" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-50">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start">
                                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                        </div>
                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                                Delete study plan course
                                            </h3>
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-500">
                                                    Are you sure you want to delete study plan course <strong x-text="studyPlanCourseName"></strong>? This action cannot be undone.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="button" x-on:click="document.getElementById(studyPlanCourseId).submit()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        Delete
                                    </button>
                                    <button type="button" x-on:click="showConfirmation = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
