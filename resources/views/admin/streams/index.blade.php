<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Streams') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-end mb-4">
                    <a href="{{ route('admin.streams.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Create Stream</a>
                </div>
                <table class="min-w-full bg-white dark:bg-gray-800">
                    <thead class="bg-gray-50 dark:bg-gray-700 border">
                        <tr>
                            <th class="px-4 py-2 border">{{__('Stream')}}</th>
                            <th class="px-4 py-2 border">{{__('Study Plan')}}</th>
                            <th class="px-4 py-2 border">{{__('Academic Year')}}</th>
                            <th class="px-4 py-2 border">{{__('Actions')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($streams as $stream)
                        <tr>
                            <td class="border px-4 py-2">{{ $stream->number }}</td>
                            <td class="border px-4 py-2">{{ $stream->studyPlan->title }}</td>
                            <td class="border px-4 py-2">{{ $stream->academicYear->year }}</td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('admin.streams.edit', $stream) }}">
                                    <button class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded">
                                        Edit
                                    </button>
                                </a>
                                <form action="{{ route('admin.streams.destroy', $stream) }}" method="POST" class="inline-block">
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