<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Groups') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-end mb-4">
                    <a href="{{ route('admin.groups.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">{{ __('Create Group') }}</a>
                </div>
                <table class="min-w-full bg-white dark:bg-gray-800">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="border px-4 py-2">{{ __('Group Number') }}</th>
                            <th class="border px-4 py-2">{{ __('Stream') }}</th>
                            <th class="border px-4 py-2">{{ __('Study Plan') }}</th>
                            <th class="border px-4 py-2">{{ __('Academic Year') }}</th>
                            <th class="border px-4 py-2">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 dark:text-gray-400">
                        @foreach($groups as $group)
                        <tr>
                            <td class="border px-4 py-2">{{ $group->number }}</td>
                            <td class="border px-4 py-2">{{ $group->stream->number }}</td>
                            <td class="border px-4 py-2">{{ $group->stream->studyPlan->title }}</td>
                            <td class="border px-4 py-2">{{ $group->academicYear->year }}</td>
                            <td class="border px-4 py-2 text-center">
                                <a href="{{ route('admin.groups.edit', $group) }}" ><button class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded mb-2 md:mb-0">{{ __('Edit') }}</button></a>
                                <form action="{{ route('admin.groups.destroy', $group) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this group?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded">{{ __('Delete') }}</button>
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
