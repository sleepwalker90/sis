<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Group') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.groups.update', $group->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="number" class="block text-sm font-medium text-gray-700">{{ __('Group Number') }}</label>
                        <input type="text" id="number" name="number" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('number', $group->number) }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="stream_id" class="block text-sm font-medium text-gray-700">{{ __('Stream') }}</label>
                        <input type="text" id="stream_id" name="stream_id" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('stream_id', $group->stream->number) }}" disabled>
                    </div>

                    <div class="mb-4">
                        <label for="academic_year_id" class="block text-sm font-medium text-gray-700">{{ __('Academic Year') }}</label>
                        <input type="text" id="academic_year_id" name="academic_year_id" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('academic_year_id', $group->academicYear->year) }}" disabled>
                    </div>

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="flex justify-end">
                        <x-primary-button>{{ __('Update Group') }}</x-primary-button>
                    </div>
                </form>

                <div class="mt-4 flex justify-end">
                    <a href="{{ route('admin.groups.addStudent', $group->id) }}">
                        <button class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-3 rounded-md">{{ __('Add Student') }}</button>
                    </a>
                </div>

                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('Assigned Students') }} ({{ $group->students->count() }})</h3>
                    @if($group->students->isEmpty())
                    <p>No students assigned to this group.</p>
                    @else
                    <table class="min-w-full bg-white dark:bg-gray-800">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">{{ __('Faculty Number') }}</th>
                                <th class="px-4 py-2">{{ __('Name') }}</th>
                                <th class="px-4 py-2">{{ __('Email') }}</th>
                                <th class="px-4 py-2">{{ __('EGN') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($group->students as $student)
                            <tr>
                                <td class="border px-4 py-2">{{ $student->fn }}</td>
                                <td class="border px-4 py-2">{{ $student->user->first_name }} {{ $student->user->last_name }}</td>
                                <td class="border px-4 py-2">{{ $student->user->email }}</td>
                                <td class="border px-4 py-2">{{ $student->egn }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
