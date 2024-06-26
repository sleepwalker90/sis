<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Group') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.groups.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="number" class="block text-sm font-medium text-gray-700">Group Number</label>
                        <input type="number" id="number" name="number" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('number') }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="stream_id" class="block text-sm font-medium text-gray-700">Stream</label>
                        <select id="stream_id" name="stream_id" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            @foreach($streams as $stream)
                                <option value="{{ $stream->id }}">{{ $stream->number }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="academic_year_id" class="block text-sm font-medium text-gray-700">Academic Year</label>
                        <select id="academic_year_id" name="academic_year_id" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            @foreach($academicYears as $academicYear)
                                <option value="{{ $academicYear->id }}">{{ $academicYear->year }}</option>
                            @endforeach
                        </select>
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
                        <x-primary-button>Create Group</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
