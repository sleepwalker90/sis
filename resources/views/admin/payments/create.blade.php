<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Payment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div x-data="paymentForm({{ json_encode($students) }})">
                    <form method="POST" action="{{ route('admin.payments.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="payment_option" class="block text-sm font-medium text-gray-700">Payment Option</label>
                            <select id="payment_option" name="payment_option" x-model="paymentOption" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <option value="individual">Individual</option>
                                <option value="study_plan">Study Plan</option>
                                <option value="dormitory">Dormitory</option>
                            </select>
                        </div>

                        <div class="mb-4" x-show="paymentOption === 'individual'">
                            <label for="student_search" class="block text-sm font-medium text-gray-700">Search and Select Student</label>
                            <input type="text" id="student_search" x-model="searchQuery" @input="searchStudents()" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Search by name, FN, or EGN">
                            <select name="student_id" id="student_id" required class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <template x-for="student in filteredStudents" :key="student.id">
                                    <option :value="student.id" x-text="`${student.user.first_name} ${student.user.last_name} (${student.fn}, ${student.egn})`"></option>
                                </template>
                            </select>
                        </div>

                        <div class="mb-4" x-show="paymentOption === 'study_plan'">
                            <label for="study_plan_id" class="block text-sm font-medium text-gray-700">Select Study Plan</label>
                            <select id="study_plan_id" name="study_plan_id" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @foreach($studyPlans as $studyPlan)
                                <option value="{{ $studyPlan->id }}">{{ $studyPlan->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4" x-show="paymentOption === 'dormitory'">
                            <label for="dormitory_id" class="block text-sm font-medium text-gray-700">Select Dormitory</label>
                            <select id="dormitory_id" name="dormitory_id" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @foreach($dormitories as $dormitory)
                                <option value="{{ $dormitory->id }}">{{ $dormitory->building }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="payment_type" class="block text-sm font-medium text-gray-700">Payment Type</label>
                            <select id="payment_type" name="payment_type" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <option value="semester_tax">Semester Tax</option>
                                <option value="dorm_rent">Dorm Rent</option>
                                <option value="utilities">Utilities</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-700">Amount (BGN)</label>
                            <input type="number" id="amount" name="amount" step="0.01" required class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <x-error></x-error>

                        <div class="flex justify-end">
                            <x-primary-button>Create Payment</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function paymentForm(students) {
            return {
                paymentOption: 'individual',
                searchQuery: '',
                students: students,
                filteredStudents: students,

                searchStudents() {
                    if (this.searchQuery.length > 0) {
                        fetch(`{{ route('admin.payments.search') }}?query=${this.searchQuery}`)
                            .then(response => response.json())
                            .then(data => {
                                this.filteredStudents = data;
                            });
                    } else {
                        this.filteredStudents = this.students;
                    }
                }
            }
        }
    </script>
</x-admin-layout>