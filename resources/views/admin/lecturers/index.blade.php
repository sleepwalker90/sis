<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lecturers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-end mb-4">
                    <a href="{{ route('admin.lecturers.create') }}" class="font-medium bg-blue-500 hover:bg-blue-600 text-white py-2 px-8 rounded-md">{{ __('Create Lecturer') }}</a>
                </div>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="p-3">{{ __('Name') }}</th>
                            <th scope="col" class="p-3">{{ __('Title') }} </th>
                            <th scope="col" class="p-3">{{ __('Phone Number') }}</th>
                            <th scope="col" class="p-3">{{ __('Room Number') }}</th>
                            <th scope="col" class="p-3 text-end">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lecturers as $lecturer)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-3 py-4">{{ $lecturer->user->first_name }} {{ $lecturer->user->last_name }}</td>
                            <td class="px-3 py-4">{{ __($lecturer->title) }}</td>
                            <td class="px-3 py-4">{{ $lecturer->phone_number }}</td>
                            <td class="px-3 py-4">{{ $lecturer->room_number }}</td>
                            <td class="px-3 py-4 text-end">
                                <div class="flex items-center justify-end space-x-4">
                                    <a href="{{ route('admin.lecturers.edit', $lecturer->id) }}" class="font-medium bg-blue-500 hover:bg-blue-600 text-white py-2 px-8 rounded-md">{{ __('Edit') }}</a>
                                    <form method="POST" action="{{ route('admin.lecturers.destroy', $lecturer->id) }}" onsubmit="return confirm('Are you sure you want to delete this lecturer?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-medium bg-red-500 hover:bg-red-600 text-white py-2 px-8 rounded-md">{{ __('Delete') }}</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
