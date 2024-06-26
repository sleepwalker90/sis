<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:p-6 lg:p-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Update $major->name major") }}
                </div>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <form method="POST" action="{{ route('admin.majors.update',['major' => $major->id ]) }}" class="max-w-2xl mx-auto my-8">
                        @csrf
                        @method('PATCH')

                        <div class="py-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">Major Title</label>
                            <input type="text" name="name" id="name" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $major->name }}">
                        </div>
                        @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <label for="faculty_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Факултет:</label>
                        <select id="faculty_id" name="faculty_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md">
                            <option selected>Choose a major</option>
                            @foreach ($faculties as $faculty)
                            <option value="{{ $faculty->id }}" {{ $faculty->id == $major->faculty_id ? 'selected' : ''}}>{{ $faculty->name }}</option>

                            @endforeach
                        </select>
                        @error('semester')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <label for="education_type_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Вид обучение:</label>
                        <select id="education_type_id" name="education_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md">
                            <option selected>Choose a major</option>
                            @foreach ($educationTypes as $educationType)
                            <option value="{{ $educationType->id }}" {{ $educationType->type == $major->educationType->type ? 'selected' : ''}}>{{ $educationType->type }}</option>

                            @endforeach
                        </select>
                        @error('code')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <label for="degree_type_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ОКС:</label>
                        <select id="degree_type_id" name="degree_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md">
                            <option selected>Choose a major</option>
                            @foreach ($degreeTypes as $degreeType)
                            <option value="{{ $degreeType->id }}" {{ $degreeType->type == $major->degreeType->type ? 'selected' : ''}}>{{ $degreeType->type }}</option>

                            @endforeach
                        </select>

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
                            <x-primary-button>Update major</x-primary-button>
                        </div>


                    </form>
                </div>

            </div>
        </div>
    </div>


</x-admin-layout>