<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Academic Years') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-end mb-4">
                    <a href="{{ route('admin.academic-years.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Create Academic Year</a>
                </div>
                <table class="min-w-full bg-white dark:bg-gray-800">
                    <thead class="bg-gray-50 dark:bg-gray-700 border">
                        <tr>
                            <th class="w-1/3 px-4 py-2 border">Year</th>
                            <th class="w-1/3 px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 dark:text-gray-400">
                        @foreach($academicYears as $academicYear)
                        <tr>
                            <td class="border px-4 py-2">{{ $academicYear->year }}</td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('admin.academic-years.edit', $academicYear) }}">
                                    <button type="button" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded">
                                        Edit
                                    </button>
                                </a>
                                <form action="{{ route('admin.academic-years.destroy', $academicYear) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this academic year?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>