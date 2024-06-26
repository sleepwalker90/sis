<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Student') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6" x-data="studentForm({{ $studyPlans }})">
                <form method="POST" action="{{ route('admin.students.store') }}">
                    @csrf
                    <div class="grid grid-cols-3 gap-3">
                        <div class="mb-4">
                            <label for="first_name" class="block text-sm font-medium text-gray-700">{{ __('First Name') }} </label>
                            <input type="text" id="first_name" name="first_name" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                        </div>

                        <div class="mb-4">
                            <label for="middle_name" class="block text-sm font-medium text-gray-700">{{ __('Middle Name') }} </label>
                            <input type="text" id="middle_name" name="middle_name" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                        </div>

                        <div class="mb-4">
                            <label for="last_name" class="block text-sm font-medium text-gray-700">{{ __('Last Name') }} </label>
                            <input type="text" id="last_name" name="last_name" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                        </div>

                        <div class="mb-4">
                            <label for="egn" class="block text-sm font-medium text-gray-700">{{ __('EGN') }} </label>
                            <input type="text" id="egn" name="egn" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                            <input type="email" id="email" name="email" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                        </div>

                        <div class="mb-4">
                            <label for="phone_number" class="block text-sm font-medium text-gray-700">{{ __('Phone Number') }}</label>
                            <input type="text" id="phone_number" name="phone_number" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <div class="mb-4">
                            <label for="major_id" class="block text-sm font-medium text-gray-700">{{ __('Major') }}</label>
                            <select id="major_id" name="major_id" x-model="selectedMajor" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                <option value="">{{ __('Select Major') }}</option>
                                @foreach ($majors as $major)
                                <option value="{{ $major->id }}">{{ $major->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="study_plan_id" class="block text-sm font-medium text-gray-700">{{ __('Study Plan') }}</label>
                            <select id="study_plan_id" name="study_plan_id" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                <option value="">{{ __('Select Study Plan') }}</option>
                                <template x-for="studyPlan in filteredStudyPlans" :key="studyPlan.id">
                                    <option :value="studyPlan.id" x-text="studyPlan.title"></option>
                                </template>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="tuition_id" class="block text-sm font-medium text-gray-700">{{ __('Tuition') }}</label>
                            <select id="tuition_id" name="tuition_id" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                <option value="">{{ __('Select Tuition') }}</option>
                                @foreach ($tuitions as $tuition)
                                <option value="{{ $tuition->id }}">{{ $tuition->name }} - {{ $tuition->slug }}</option>
                                @endforeach
                            </select>
                        </div>
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
                        <x-primary-button>{{ __('Create Student') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function studentForm(initialStudyPlans) {
            return {
                selectedMajor: '',
                studyPlans: initialStudyPlans,
                get filteredStudyPlans() {
                    if (!this.selectedMajor) {
                        return [];
                    }
                    return this.studyPlans.filter(plan => plan.major_id == this.selectedMajor);
                }
            };
        }
    </script>
</x-admin-layout>