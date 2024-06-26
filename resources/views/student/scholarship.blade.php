<x-student-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Student') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:p-6 lg:p-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Scholarship") }}
                </div>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <form method="POST" action="{{ route('student.scholarship.apply') }}">
                        @csrf

                        
                        <div class="ps-6 p-3 text-gray-900 dark:text-gray-100">
                            @if ($result['eligible'])
                            With GPA of {{ number_format($result['gpa'],2) }}, you are eligible for scholarship of {{ $result['amount'] }} Lv.
                            @else
                            With GPA of {{ number_format($result['gpa'],2) ?? 0 }} You are not eligible for scholarship. Reason: {{ $result['reason'] }}
                            @endif
                        </div>

                        @if ($result['hasApplied'])
                        <p class="ps-6 p-3 text-bold text-gray-900 dark:text-gray-100">You have already applied for scholarship for this semester!</p>
                        <p class="ps-6 p-3 text-bold text-gray-900 dark:text-gray-100 font-bold">Scholarship Application Status: {{ ucwords($result['applicationStatus']) }}</p>
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

                        @if($result['eligible'] && !$result['hasApplied'])
                        <x-primary-button class="m-3">Apply for Scholarship</x-primary-button>
                        @endif


                    </form>


                </div>

            </div>
        </div>
    </div>


</x-student-layout>