<x-student-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lecturers for'). ' ' . $course->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ $course->name }}</h3>

                @if (session('error'))
                    <div class="bg-red-500 text-white p-4 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">{{ __('Lecturer Name') }}</th>
                            <th scope="col" class="px-6 py-3">{{ __('Room Number') }}</th>
                            <th scope="col" class="px-6 py-3">{{ __('Phone Number') }}</th>
                            <th scope="col" class="px-6 py-3">{{ __('Office Hours') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lecturers as $lecturer)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4">{{ $lecturer->user->first_name }} {{ $lecturer->user->last_name }}</td>
                                <td class="px-6 py-4">{{ $lecturer->room_number }}</td>
                                <td class="px-6 py-4">{{ $lecturer->phone_number }}</td>
                                <td class="px-6 py-4">
                                    @if($lecturer->office_hours)
                                        @foreach ($lecturer->office_hours as $day => $hours)
                                            <div>{{ __($day) }}: {{ $hours }}</div>
                                        @endforeach
                                    @else
                                        <div>N/A</div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-student-layout>
