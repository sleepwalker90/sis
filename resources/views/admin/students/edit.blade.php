<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Student') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="studentForm({{ json_encode($student) }}, {{ json_encode($studyPlans) }})">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.students.update', $student) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('first_name', $student->user->first_name) }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('last_name', $student->user->last_name) }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('email', $student->user->email) }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="text" id="phone_number" name="phone_number" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('phone_number', $student->user->phone_number) }}">
                    </div>

                    <div class="mb-4">
                        <label for="major_id" class="block text-sm font-medium text-gray-700">Major</label>
                        <select id="major_id" name="major_id" x-model="selectedMajor" @change="filterStudyPlans" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            @foreach($majors as $major)
                                <option value="{{ $major->id }}" {{ $major->id == old('major_id', $student->major_id) ? 'selected' : '' }}>{{ $major->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="study_plan_id" class="block text-sm font-medium text-gray-700">Study Plan</label>
                        <select id="study_plan_id" name="study_plan_id" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            <template x-for="studyPlan in filteredStudyPlans" :key="studyPlan.id">
                                <option :value="studyPlan.id" x-text="studyPlan.title" :selected="studyPlan.id == {{ old('study_plan_id', $student->study_plan_id) }}"></option>
                            </template>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="tuition_id" class="block text-sm font-medium text-gray-700">Tuition</label>
                        <select id="tuition_id" name="tuition_id" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            @foreach($tuitions as $tuition)
                                <option value="{{ $tuition->id }}" {{ $tuition->id == old('tuition_id', $student->tuition_id) ? 'selected' : '' }}>{{ $tuition->name }} - {{ $tuition->slug }}</option>
                            @endforeach
                        </select>
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
                        <x-primary-button>Update Student</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function studentForm(student, studyPlans) {
            return {
                selectedMajor: student.major_id,
                studyPlans: studyPlans,
                filteredStudyPlans() {
                    return this.studyPlans.filter(studyPlan => studyPlan.major_id == this.selectedMajor);
                }
            };
        }
    </script>
</x-admin-layout>
