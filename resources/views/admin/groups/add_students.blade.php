<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Students to Group') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.groups.storeStudent', $group->id) }}">
                    @csrf
                    <div class="mb-4">
                        <label for="student_id" class="block text-sm font-medium text-gray-700">{{ __('Select Student') }}</label>
                        <select id="student_id" name="student_id" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            <option value="">{{ __('Select a Student') }}</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}">
                                    {{ $student->user->first_name }} {{ $student->user->last_name }} - {{ $student->fn }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end">
                        <x-primary-button>{{ __('Add Student to Group') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
