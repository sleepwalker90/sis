<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Students') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="studentFilter({{ json_encode($students) }}, {{ json_encode($studyPlans) }})" x-init="init()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-4 flex justify-end">
                    <a href="{{ route('admin.students.create') }}">
                        <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">{{ __('Create Student') }}</button>
                    </a>
                </div>
                <div class="mb-4 flex items-center space-x-4">
                    <div>
                        <label for="major_id" class="block text-sm font-medium text-gray-700">{{ __('Major') }}</label>
                        <select id="major_id" name="major_id" x-model="selectedMajor" @change="filterStudyPlans" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <option value="">{{ __('Select Major') }}</option>
                            @foreach($majors as $major)
                                <option value="{{ $major->id }}">{{ $major->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="study_plan_id" class="block text-sm font-medium text-gray-700">{{ __('Study Plan') }}</label>
                        <select id="study_plan_id" name="study_plan_id" x-model="selectedStudyPlan" @change="filterStudents" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <option value="">{{ __('Select Study Plan') }}</option>
                            <template x-for="plan in filteredStudyPlans" :key="plan.id">
                                <option :value="plan.id" x-text="plan.title"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700">{{ __('Search') }}</label>
                        <form @submit.prevent="filterStudents">
                            <input type="text" id="search" x-model="searchQuery" placeholder="{{ __('Search by name, FN, email, or EGN') }}" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </form>
                    </div>
                </div>
                <div>
                    <table class="min-w-full bg-white dark:bg-gray-800">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">{{ __('Faculty Number') }}</th>
                                <th class="px-4 py-2">{{ __('Name') }}</th>
                                <th class="px-4 py-2">{{ __('Email') }}</th>
                                <th class="px-4 py-2">{{ __('EGN') }}</th>
                                <th class="px-4 py-2">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="student in filteredStudents" :key="student.id">
                                <tr>
                                    <td class="border px-4 py-2" x-text="student.fn"></td>
                                    <td class="border px-4 py-2" x-text="`${student.user?.first_name || ''} ${student.user?.last_name || ''}`"></td>
                                    <td class="border px-4 py-2" x-text="student.user?.email || ''"></td>
                                    <td class="border px-4 py-2" x-text="student.egn"></td>
                                    <td class="border px-4 py-2">
                                        <a :href="`/admin/students/${student.id}/edit`"><button type="button" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded md:mb-2 mb-0">{{ __('Edit') }}</button></a>
                                        <form :action="`/admin/students/${student.id}`" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded">{{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function studentFilter(students, studyPlans) {
            return {
                students: students,
                studyPlans: studyPlans,
                selectedMajor: '',
                selectedStudyPlan: '',
                searchQuery: '',
                filteredStudyPlans: [],
                filteredStudents: [],

                init() {
                    this.filterStudyPlans();
                    this.filterStudents();
                },

                filterStudyPlans() {
                    this.filteredStudyPlans = this.studyPlans.filter(studyPlan => {
                        return !this.selectedMajor || studyPlan.major_id == this.selectedMajor;
                    });
                    this.selectedStudyPlan = '';
                    this.filterStudents();
                },

                filterStudents() {
                    this.filteredStudents = this.students.filter(student => {
                        const matchesMajor = !this.selectedMajor || student.major_id == this.selectedMajor;
                        const matchesStudyPlan = !this.selectedStudyPlan || student.study_plan_id == this.selectedStudyPlan;
                        const search = this.searchQuery.toLowerCase();
                        const matchesSearch = !this.searchQuery || student.fn.toString().includes(search) || (student.egn ? student.egn.toString().includes(search) : false) || student.user?.first_name?.toLowerCase().includes(search) || student.user?.last_name?.toLowerCase().includes(search) || student.user?.email?.toLowerCase().includes(search);

                        return matchesMajor && matchesStudyPlan && matchesSearch;
                    });
                }
            }
        }
    </script>
</x-admin-layout>
