<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Attestations for stream') . ' ' . $assignment->stream->number . ' in ' . $assignment->course->name }}
        </h2>
        <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lecturer') .': ' . $assignment->lecturer->user->first_name . ' ' . $assignment->lecturer->user->last_name }}
        </h3>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.attestations.store', $assignment) }}">
                    @csrf
                    <table class="min-w-full bg-white dark:bg-gray-800 border rounded-sm border-separate">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border">{{ __('Student') }}</th>
                                <th class="px-4 py-2 border">{{ __('Group') }}</th>
                                @if($assignment->course->hasLectures)
                                    <th class="px-4 py-2 border">{{ __('Lecture') }}</th>
                                @endif
                                @if($assignment->course->hasSeminars)
                                    <th class="px-4 py-2 border">{{ __('Seminar') }}</th>
                                @endif
                                @if($assignment->course->hasLabs)
                                    <th class="px-4 py-2 border">{{ __('Lab') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td class="border px-4 py-2">{{ $student->user->first_name }} {{ $student->user->last_name }}</td>
                                    <td class="border px-4 py-2">{{ $student->group->number }}</td>
                                    @if($assignment->course->hasLectures)
                                        <td class="border px-4 py-2 text-center">
                                            <input type="hidden" name="attestations[{{ $student->id }}][Lecture][student_id]" value="{{ $student->id }}">
                                            <input type="hidden" name="attestations[{{ $student->id }}][Lecture][type]" value="Lecture">
                                            <input type="hidden" name="attestations[{{ $student->id }}][Lecture][is_attested]" value="0">
                                            <input type="checkbox" name="attestations[{{ $student->id }}][Lecture][is_attested]" value="1"
                                            @if($attestation = $student->attestations->where('course_id', $assignment->course_id)->where('type', 'Lecture')->first())
                                                {{ $attestation->is_attested ? 'checked' : '' }}
                                            @endif
                                            >
                                        </td>
                                    @endif
                                    @if($assignment->course->hasSeminars)
                                        <td class="border px-4 py-2 text-center">
                                            <input type="hidden" name="attestations[{{ $student->id }}][Seminar][student_id]" value="{{ $student->id }}">
                                            <input type="hidden" name="attestations[{{ $student->id }}][Seminar][type]" value="Seminar">
                                            <input type="hidden" name="attestations[{{ $student->id }}][Seminar][is_attested]" value="0">
                                            <input type="checkbox" name="attestations[{{ $student->id }}][Seminar][is_attested]" value="1"
                                            @if($attestation = $student->attestations->where('course_id', $assignment->course_id)->where('type', 'Seminar')->first())
                                                {{ $attestation->is_attested ? 'checked' : '' }}
                                            @endif
                                            >
                                        </td>
                                    @endif
                                    @if($assignment->course->hasLabs)
                                        <td class="border px-4 py-2 text-center">
                                            <input type="hidden" name="attestations[{{ $student->id }}][Lab][student_id]" value="{{ $student->id }}">
                                            <input type="hidden" name="attestations[{{ $student->id }}][Lab][type]" value="Lab">
                                            <input type="hidden" name="attestations[{{ $student->id }}][Lab][is_attested]" value="0">
                                            <input type="checkbox" name="attestations[{{ $student->id }}][Lab][is_attested]" value="1"
                                            @if($attestation = $student->attestations->where('course_id', $assignment->course_id)->where('type', 'Lab')->first())
                                                {{ $attestation->is_attested ? 'checked' : '' }}
                                            @endif
                                            >
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if ($errors->any())
                        <div class="alert alert-danger dark:text-white">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="flex justify-end mt-4">
                        <x-primary-button>{{ __('Save Attestations') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
