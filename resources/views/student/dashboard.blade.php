<x-student-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Student Info') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100">
                <div class="container mx-auto py-8">

                    <!-- Profile Card -->
                    <div class="col-span-12 sm:col-span-12">
                        <div class="bg-white overflow-hidden shadow rounded-lg border px-4 py-5">
                            <div class="flex flex-col items-center px-4 py-5">
                                @if (Auth::user()->photo)
                                    <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profile Photo" class="w-32 h-32 rounded-full mb-4 shrink-0">
                                @else
                                    <img class="w-10 h-10 rounded-full" src="https://i.pravatar.cc/150?img={{Auth::user()->id}}" alt="Avatar image">
                                @endif
                                <h1 class="text-xl font-bold">{{ Auth::user()->first_name . " " . Auth::user()->middle_name . " " . Auth::user()->last_name }}</h1>
                                <p class="text-gray-700">{{ Auth::user()->email . " - " . Auth::user()->phone_number }}</p>
                            </div>
                            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                                <dl class="sm:divide-y sm:divide-gray-200 flex justify-between">
                                    <div>
                                        <div class="py-2 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 flex">
                                            <dt class="text-sm font-medium text-gray-500">
                                                {{ __('Degree type') }}
                                            </dt>
                                            <dd class="mx-2 mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                {{ Auth::user()->student->major->degreeType->type }}
                                            </dd>
                                        </div>
                                        <div class="py-2 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 flex">
                                            <dt class="text-sm font-medium text-gray-500">
                                                {{ __('Faculty number') }}
                                            </dt>
                                            <dd class="mx-2 mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                {{ Auth::user()->student->fn }}
                                            </dd>
                                        </div>
                                        <div class="py-2 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 flex">
                                            <dt class="text-sm font-medium text-gray-500">
                                                {{ __('Faculty') }}
                                            </dt>
                                            <dd class="mx-2 mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                {{ Auth::user()->student->major->faculty->name }}
                                            </dd>
                                        </div>
                                        <div class="py-2 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 flex">
                                            <dt class="text-sm font-medium text-gray-500">
                                                {{ __('Major') }}
                                            </dt>
                                            <dd class="mx-2 mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                {{ Auth::user()->student->major->name }}
                                            </dd>
                                        </div>
                                        <div class="py-2 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 flex">
                                            <dt class="text-sm font-medium text-gray-500">
                                                {{ __('Education type') }}
                                            </dt>
                                            <dd class="mx-2 mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                {{ Auth::user()->student->major->educationType->type }}
                                            </dd>
                                        </div>
                                        


                                        <div class="py-2 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 flex">
                                            <dt class="text-sm font-medium text-gray-500">
                                                {{ __('Tuition type') }}
                                            </dt>
                                            <dd class="mx-2 mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                {{ Auth::user()->student->tuition->name }}
                                            </dd>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="py-2 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 flex">
                                            <dt class="text-sm font-medium text-gray-500">
                                                {{ __('Status') }}
                                            </dt>
                                            <dd class="mx-2 mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                {{ Auth::user()->student->studentStatus->status }}
                                            </dd>
                                        </div>
                                        <div class="py-2 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 flex">
                                            <dt class="text-sm font-medium text-gray-500">
                                                {{ __('Started semester') }}
                                            </dt>
                                            <dd class="mx-2 mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                {{ Auth::user()->student->started_semester }}
                                            </dd>
                                        </div>
                                        <div class="py-2 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 flex">
                                            <dt class="text-sm font-medium text-gray-500">
                                                {{ __('Certified semester') }} 
                                            </dt>
                                            <dd class="mx-2 mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                {{ Auth::user()->student->certified_semester }}
                                            </dd>
                                        </div>
                                        <div class="py-2 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 flex">
                                            <dt class="text-sm font-medium text-gray-500">
                                                {{ __('Stream') }} 
                                            </dt>
                                            <dd class="mx-2 mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                {{ Auth::user()->student->group?->stream->number }}
                                            </dd>
                                        </div>
                                        <div class="py-2 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 flex">
                                            <dt class="text-sm font-medium text-gray-500">
                                                {{ __('Group') }}
                                            </dt>
                                            <dd class="mx-2 mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                {{ Auth::user()->student->group?->number }}
                                            </dd>
                                        </div>

                                    </div>

                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-student-layout>