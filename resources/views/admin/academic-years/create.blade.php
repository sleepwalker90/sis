<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ isset($academicYear->id) ? 'Edit Academic Year' : 'Create Academic Year' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ isset($academicYear->id) ? route('admin.academic-years.update', $academicYear) : route('admin.academic-years.store') }}">
                    @csrf
                    @if(isset($academicYear->id))
                    @method('PUT')
                    @endif

                    <div class="mb-4">
                        <label for="year" class="block text-sm font-medium text-gray-700">Academic Year</label>
                        <input type="text" id="year" name="year" class="block mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $academicYear->year ?? old('year') }}" required>
                        @error('year')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button>{{ isset($academicYear->id) ? 'Update Academic Year' : 'Create Academic Year' }}</x-primary-button>
                    </div>


                </form>
            </div>
        </div>
    </div>
</x-admin-layout>