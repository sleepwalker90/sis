<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ isset($stream->id) ? __('Update Stream') : __('Create Stream') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ isset($stream->id) ? route('admin.streams.update', $stream) : route('admin.streams.store') }}">
                    @csrf
                    @if(isset($stream->id))
                    @method('PUT')
                    @endif

                    <div class="mb-4">
                        <label for="number" class="block text-sm font-medium text-gray-700">Stream Number</label>
                        <input type="number" id="number" name="number" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $stream->number ?? old('number') }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="study_plan_id" class="block text-sm font-medium text-gray-700">Study Plan</label>
                        <select id="study_plan_id" name="study_plan_id" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            @foreach($studyPlans as $studyPlan)
                            <option value="{{ $studyPlan->id }}" {{ $stream && $stream->study_plan_id == $studyPlan->id ? 'selected' : '' }}>{{ $studyPlan->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="academic_year_id" class="block text-sm font-medium text-gray-700">Academic Year</label>
                        <select id="academic_year_id" name="academic_year_id" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            @foreach($academicYears as $academicYear)
                            <option value="{{ $academicYear->id }}" {{ $stream && $stream->academic_year_id == $academicYear->id ? 'selected' : '' }}>{{ $academicYear->year }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button>{{ isset($stream->id) ? 'Update Stream' : 'Create Stream' }}</x-primary-button>
                    </div>

                    @if (isset($stream->id))
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Assigned Groups ({{ $stream->groups->count() }})</h3>
                        @if($stream->groups->isEmpty())
                        <p>No students assigned to this group.</p>
                        @else
                        <table class="min-w-full bg-white dark:bg-gray-800">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Group Number</th>
                                    <th class="px-4 py-2">Stream</th>
                                    <th class="px-4 py-2">Academic year</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stream->groups as $group)
                                <tr>
                                    <td class="border px-4 py-2"><a href="{{ route('admin.groups.edit', $group) }}">{{ $group->number }}</a></td>
                                    <td class="border px-4 py-2">{{ $stream->number }}</td>
                                    <td class="border px-4 py-2">{{ $group->academicYear->year }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                    @endif

                </form>
            </div>
        </div>
    </div>
</x-admin-layout>