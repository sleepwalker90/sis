<x-student-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Student') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase sticky top-0 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="pl-8 p-3">Предмет</th>
                        <th scope="col" class="p-3 text-center">Форма на контрол</th>
                        <th scope="col" class="p-3 text-center" colspan="3">Заверки</th>
                        <th scope="col" class="p-3 text-center">Оценка</th>
                    </tr>
                    <tr class="border-b">
                        <th scope="col" class="pl-8 p-3"></th>
                        <th scope="col" class="p-3 text-center"></th>
                        <th scope="col" class="p-3 text-center">Лекции</th>
                        <th scope="col" class="p-3 text-center">Лаб. упр.</th>
                        <th scope="col" class="p-3 text-center">Сем. упр.</th>
                        <th scope="col" class="p-3 text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($coursesBySemester as $semester =>$courses)
                    <tr>
                        <th colspan="6" class="p-4 text-center text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">Семестър {{ $semester }}</th>
                    </tr>
                    @foreach ($courses as $course)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                            <div class="ps-3">
                                <div class="text-base font-semibold">
                                    <a href="{{ route('student.courses.lecturer', $course->id) }}" class="text-blue-500 hover:underline">{{ $course->name }}</a>
                                </div>
                            </div>
                        </th>
                        <td class="px-6 py-4 text-center">
                            @if ($course->hasOa)
                            Текуща оценка
                            @elseif ($course->hasExam)
                            Изпит
                            @else
                            Няма форма на контрол
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if ($course->hasLectures)
                            <span class="{{ $course->attestations->firstWhere('type', 'Lecture') ? 'text-green-500' : 'text-red-500' }}">
                                {{ $course->attestations->firstWhere('type', 'Lecture')?->is_attested ? '✅' : '❌' }}
                            </span>
                            @else
                            <span class="text-gray-500">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if ($course->hasLabs)
                            <span class="{{ $course->attestations->firstWhere('type', 'Lab') ? 'text-green-500' : 'text-red-500' }}">
                                {{ $course->attestations->firstWhere('type', 'Lab')?->is_attested ? '✅' : '❌' }}
                            </span>
                            @else
                            <span class="text-gray-500">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if ($course->hasSeminars)
                            <span class="{{ $course->attestations->firstWhere('type', 'Seminar') ? 'text-green-500' : 'text-red-500' }}">
                                {{ $course->attestations->firstWhere('type', 'Seminar')?->is_attested ? '✅' : '❌' }}
                            </span>
                            @else
                            <span class="text-gray-500">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="{{ $course->marks->first() && $course->marks->first()->mark >= 3 ? '' : 'text-red-500' }} font-bold">
                                {{ $course->marks->first() ? number_format($course->marks->first()->mark, 2) : '❌' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-student-layout>
