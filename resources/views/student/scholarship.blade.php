<x-student-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __("Scholarship") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:p-6 lg:p-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <form method="POST" action="{{ route('student.scholarship.apply') }}">
                        @csrf

                        
                        <div class="ps-6 p-3 text-gray-900 dark:text-gray-100">
                            @if ($result['eligible'])
                            {{ __('GPA') . ': ' . number_format($result['gpa'],2) . ' - ' . __('you are eligible for scholarship of') . ' '. $result['amount'] . ' ' . __('BGN') . '!' }} 
                            @else
                            {{ __('GPA') . ': ' .  number_format($result['gpa'],2) . ' - ' . __('you are not eligible for scholarship. Reason: ') . __($result['reason']) }}
                            @endif
                        </div>

                        @if ($result['hasApplied'])
                        <p class="ps-6 p-3 text-bold text-gray-900 dark:text-gray-100">{{ __('You have already applied for scholarship for this semester!') }}</p>
                        <p class="ps-6 p-3 text-bold text-gray-900 dark:text-gray-100 font-bold">{{ __('Scholarship Application Status:') . ' ' . __(ucwords($result['applicationStatus'])) }}</p>
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
                        <x-primary-button class="m-3">{{ __('Apply for Scholarship') }}</x-primary-button>
                        @endif


                    </form>


                </div>

            </div>
        </div>
    </div>


</x-student-layout>