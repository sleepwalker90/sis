<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Lecturer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.lecturers.update', $lecturer->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" id="first_name" name="first_name" value="{{ $lecturer->user->first_name }}" required class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label for="middle_name" class="block text-sm font-medium text-gray-700">Middle Name</label>
                        <input type="text" id="middle_name" name="middle_name" value="{{ $lecturer->user->middle_name }}" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" id="last_name" name="last_name" value="{{ $lecturer->user->last_name }}" required class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" value="{{ $lecturer->user->email }}" required class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="text" id="phone_number" name="phone_number" value="{{ $lecturer->phone_number }}" required class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label for="room_number" class="block text-sm font-medium text-gray-700">Room Number</label>
                        <input type="text" id="room_number" name="room_number" value="{{ $lecturer->room_number }}" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" id="title" name="title" value="{{ $lecturer->title }}" class="block w-full mt-1 shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    @if ($errors->any())
                    <div class="alert alert-danger dark:text-white">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="flex justify-end">
                        <x-primary-button>Update Lecturer</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>