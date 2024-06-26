<x-lecturer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Attestations and Marks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($assignments as $assignment)
                        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg p-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200">{{ $assignment->course->name }}</h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('Stream') }}: {{ $assignment->stream->number }}</p>
                            <div class="mt-4">
                                <a href="{{ route('lecturer.attestations.show', $assignment) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue disabled:opacity-25 transition ease-in-out duration-150">{{ __('Manage Attestations') }}</a>
                                <a href="{{ route('lecturer.marks.show', $assignment) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green disabled:opacity-25 transition ease-in-out duration-150">{{ __('Manage Marks') }}</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-lecturer-layout>
