<x-lecturer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Marks for') . ' ' . $assignment->course->name . ' ('. __('Stream') . ' '  . $assignment->stream->number . ')' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('lecturer.marks.store', $assignment) }}">
                    @csrf

                    <table class="min-w-full bg-white dark:bg-gray-800 border rounded-sm border-separate">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">{{ __('Student Name') }}</th>
                                <th class="border px-4 py-2">{{ __('Faculty Number') }}</th>
                                @if ($assignment->course->hasLectures)
                                    <th class="border px-4 py-2">{{ __('Lecture') }} </th>
                                @endif
                                @if ($assignment->course->hasSeminars)
                                    <th class="border px-4 py-2">{{ __('Seminar') }}</th>
                                @endif
                                @if ($assignment->course->hasLabs)
                                    <th class="border px-4 py-2">{{ __('Lab') }}</th>
                                @endif
                                @if ($assignment->course->hasExam)
                                    <th class="border px-4 py-2">{{ __('Exam') }}</th>
                                @endif
                                @if ($assignment->course->hasCw)
                                    <th class="border px-4 py-2">{{ __('Course Work') }}</th>
                                @endif
                                @if ($assignment->course->hasOa)
                                    <th class="border px-4 py-2">{{ __('Ongoing Assessment') }}</th>
                                @endif
                                @if ($assignment->course->hasCp)
                                    <th class="border px-4 py-2">{{ __('Course Project') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td class="border px-4 py-2">{{ $student->user->first_name }} {{ $student->user->last_name }}</td>
                                    <td class="border px-4 py-2">{{ $student->fn }}</td>
                                    @if ($assignment->course->hasLectures)
                                        @php
                                            $lectureAttested = $student->attestations->where('course_id', $assignment->course_id)->where('type', 'Lecture')->first();
                                        @endphp
                                        <td class="border px-4 py-2 text-center">
                                            @if($lectureAttested)
                                                @if($lectureAttested->is_attested)
                                                    <span class="text-green-500 font-bold">&#x2714;</span>
                                                @else
                                                    <span class="text-red-500 font-bold">&#x2718;</span>
                                                @endif
                                            @else
                                                <span class="text-gray-500 font-bold">N/A</span>
                                            @endif
                                        </td>
                                    @endif
                                    @if ($assignment->course->hasSeminars)
                                        @php
                                            $seminarAttested = $student->attestations->where('course_id', $assignment->course_id)->where('type', 'Seminar')->first();
                                        @endphp
                                        <td class="border px-4 py-2 text-center">
                                            @if($seminarAttested)
                                                @if($seminarAttested->is_attested)
                                                    <span class="text-green-500 font-bold">&#x2714;</span>
                                                @else
                                                    <span class="text-red-500 font-bold">&#x2718;</span>
                                                @endif
                                            @else
                                                <span class="text-gray-500 font-bold">N/A</span>
                                            @endif
                                        </td>
                                    @endif
                                    @if ($assignment->course->hasLabs)
                                        @php
                                            $labAttested = $student->attestations->where('course_id', $assignment->course_id)->where('type', 'Lab')->first();
                                        @endphp
                                        <td class="border px-4 py-2 text-center">
                                            @if($labAttested)
                                                @if($labAttested->is_attested)
                                                    <span class="text-green-500 font-bold">&#x2714;</span>
                                                @else
                                                    <span class="text-red-500 font-bold">&#x2718;</span>
                                                @endif
                                            @else
                                                <span class="text-gray-500 font-bold">N/A</span>
                                            @endif
                                        </td>
                                    @endif
                                    @if ($assignment->course->hasExam)
                                        <td class="border px-4 py-2">
                                            <input type="hidden" name="marks[{{ $student->id }}][exam][student_id]" value="{{ $student->id }}">
                                            <input type="hidden" name="marks[{{ $student->id }}][exam][type]" value="exam">
                                            <input type="number" name="marks[{{ $student->id }}][exam][mark]" value="{{ $student->marks->where('course_id', $assignment->course_id)->where('type', 'exam')->first()->mark ?? '' }}" min="2" max="6" class="w-full text-center disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" @if($assignment->course->hasLectures && (!$lectureAttested || !$lectureAttested->is_attested) || $assignment->course->hasSeminars && (!$seminarAttested || !$seminarAttested->is_attested) || $assignment->course->hasLabs && (!$labAttested || !$labAttested->is_attested)) disabled @endif>
                                        </td>
                                    @endif
                                    @if ($assignment->course->hasCw)
                                        <td class="border px-4 py-2">
                                            <input type="hidden" name="marks[{{ $student->id }}][cw][student_id]" value="{{ $student->id }}">
                                            <input type="hidden" name="marks[{{ $student->id }}][cw][type]" value="cw">
                                            <input type="number" name="marks[{{ $student->id }}][cw][mark]" value="{{ $student->marks->where('course_id', $assignment->course_id)->where('type', 'cw')->first()->mark ?? '' }}" min="2" max="6" class="w-full text-center disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" @if($assignment->course->hasLectures && (!$lectureAttested || !$lectureAttested->is_attested) || $assignment->course->hasSeminars && (!$seminarAttested || !$seminarAttested->is_attested) || $assignment->course->hasLabs && (!$labAttested || !$labAttested->is_attested)) disabled @endif>
                                        </td>
                                    @endif
                                    @if ($assignment->course->hasOa)
                                        <td class="border px-4 py-2">
                                            <input type="hidden" name="marks[{{ $student->id }}][oa][student_id]" value="{{ $student->id }}">
                                            <input type="hidden" name="marks[{{ $student->id }}][oa][type]" value="oa">
                                            <input type="number" name="marks[{{ $student->id }}][oa][mark]" value="{{ $student->marks->where('course_id', $assignment->course_id)->where('type', 'oa')->first()->mark ?? '' }}" min="2" max="6" class="w-full text-center disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" @if($assignment->course->hasLectures && (!$lectureAttested || !$lectureAttested->is_attested) || $assignment->course->hasSeminars && (!$seminarAttested || !$seminarAttested->is_attested) || $assignment->course->hasLabs && (!$labAttested || !$labAttested->is_attested)) disabled @endif>
                                        </td>
                                    @endif
                                    @if ($assignment->course->hasCp)
                                        <td class="border px-4 py-2">
                                            <input type="hidden" name="marks[{{ $student->id }}][cp][student_id]" value="{{ $student->id }}">
                                            <input type="hidden" name="marks[{{ $student->id }}][cp][type]" value="cp">
                                            <input type="number" name="marks[{{ $student->id }}][cp][mark]" value="{{ $student->marks->where('course_id', $assignment->course_id)->where('type', 'cp')->first()->mark ?? '' }}" min="2" max="6" class="w-full text-center disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" @if($assignment->course->hasLectures && (!$lectureAttested || !$lectureAttested->is_attested) || $assignment->course->hasSeminars && (!$seminarAttested || !$seminarAttested->is_attested) || $assignment->course->hasLabs && (!$labAttested || !$labAttested->is_attested)) disabled @endif>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="flex justify-end mt-4">
                        <x-primary-button>{{ __('Save Marks') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-lecturer-layout>
