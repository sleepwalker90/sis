<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Study Plan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.studyplans.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" id="title" name="title" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('title') }}">
                    </div>

                    <div class="mb-4">
                        <label for="major_id" class="block text-sm font-medium text-gray-700">Major</label>
                        <select id="major_id" name="major_id" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @foreach($majors as $major)
                                <option value="{{ $major->id }}">{{ $major->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="academic_year_id" class="block text-sm font-medium text-gray-700">Academic Year</label>
                        <select id="academic_year_id" name="academic_year_id" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @foreach($academicYears as $academicYear)
                                <option value="{{ $academicYear->id }}">{{ $academicYear->year }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="status" name="status" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button>Create Study Plan</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
