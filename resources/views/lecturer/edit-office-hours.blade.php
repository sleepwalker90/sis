<x-lecturer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Office Hours') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('lecturer.update-office-hours') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="day_of_week" class="block text-sm font-medium text-gray-700">Day of the Week</label>
                        <select id="day_of_week" name="day_of_week" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            <option value="">Select a day</option>
                            <option value="Mon">Monday</option>
                            <option value="Tue">Tuesday</option>
                            <option value="Wed">Wednesday</option>
                            <option value="Thu">Thursday</option>
                            <option value="Fri">Friday</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="time_interval" class="block text-sm font-medium text-gray-700">Time Interval</label>
                        <input type="text" id="time_interval" name="time_interval" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="e.g., 10:00-12:00" required>
                        <small class="text-gray-600">Format: HH:MM-HH:MM</small>
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
                        <x-primary-button>Add Office Hours</x-primary-button>
                    </div>
                </form>
                @if (isset($lecturer->office_hours))
                    <h3 class="mt-6 text-lg font-medium text-gray-900 dark:text-gray-200">Current Office Hours</h3>
                    <ul class="mt-4">
                        
                            @foreach(json_decode($lecturer->office_hours, true) ?? [] as $day => $hours)
                            <li class="mb-2">
                                <span class="font-semibold">{{ $day }}: </span>{{ $hours }}
                                <form method="POST" action="{{ route('lecturer.remove-office-hours') }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="day" value="{{ $day }}">
                                    <button type="submit" class="text-red-500 ml-2">Remove</button>
                                </form>
                            </li>
                            @endforeach
                        

                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-lecturer-layout>