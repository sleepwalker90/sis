<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create new major') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:p-6 lg:p-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <form method="POST" action="{{ route('admin.majors.store') }}" class="max-w-2xl mx-auto my-8">
                        @csrf

                        <div class="py-2">
                            <x-input-label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Major Name') }}:</x-input-label>
                            <x-text-input type="text" name="name" id="name" :value="old('name')" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required autofocus autocomplete="" />
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mt-4">
                            <label for="faculty_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Faculty')}}:</label>
                            <select id="faculty_id" name="faculty_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md w-full">
                                <option selected>{{ __('Choose a faculty') }}</option>
                                @foreach ($faculties as $faculty)
                                <option value="{{ $faculty->id }}" {{ old('faculty_id') == $faculty->id || old('faculty_id') ? 'selected' : ''}}>{{ $faculty->name }}</option>

                                @endforeach
                            </select>
                            @error('semester')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex mt-4">
                            <div>
                                <label for="education_type_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Вид обучение:</label>
                                <select id="education_type_id" name="education_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md">
                                    <option selected>{{ __('Choose an education type') }}</option>
                                    @foreach ($educationTypes as $educationType)
                                    <option value="{{ $educationType->id }}" {{ $educationType->type == old('education_type_id') ? 'selected' : ''}}>{{ $educationType->type }}</option>

                                    @endforeach
                                </select>
                            </div>
                            <div class="ml-4">
                                <label for="degree_type_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ОКС:</label>
                                <select id="degree_type_id" name="degree_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md">
                                    <option selected>{{ __('Choose a degree type') }}</option>
                                    @foreach ($degreeTypes as $degreeType)
                                    <option value="{{ $degreeType->id }}" {{ $degreeType->type == old('degree_type_id') ? 'selected' : ''}}>{{ $degreeType->type }}</option>

                                    @endforeach
                                </select>
                                @error('education_type')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="ml-4">
                                <label for="semesters" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Семестри:</label>
                                <select id="semesters" name="semesters" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md">
                                    <option selected>{{ __('Choose number of semesters') }}</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                </select>
                                @error('semesters')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        

                        </div>

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="py-6">
                            <x-primary-button>{{ __('Create major') }}</x-primary-button>
                        </div>


                    </form>
                </div>

            </div>
        </div>
    </div>


</x-admin-layout>