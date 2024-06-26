<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Dormitory') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="{
            showEditRoomModal: false, 
            showAssignStudentModal: false, 
            showConfirmModal: false,
            currentRoom: {}, 
            currentAccommodationId: '',
            confirmAction: '',
            confirmMessage: '',
            openEditRoomModal(room) { 
                this.currentRoom = room; 
                this.showEditRoomModal = true; 
            },
            openAssignStudentModal(room) { 
                this.currentRoom = room; 
                this.showAssignStudentModal = true; 
            },
            openConfirmModal(accommodationId, action) {
                this.currentAccommodationId = accommodationId;
                this.confirmAction = action;
                this.confirmMessage = action === 'left' ? 'Are you sure you want to mark the student as left?' : 'Are you sure you want to evict the student?';
                this.showConfirmModal = true;
            }
        }">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.dormitories.update', ['dormitory' => $dormitory->id]) }}" class="max-w-2xl mx-auto my-8">
                        @csrf
                        @method('PUT')

                        <div class="py-2">
                            <label for="building" class="block text-sm font-medium text-gray-700">Building: </label>
                            <input type="text" name="building" id="building" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $dormitory->building }}">
                        </div>
                        @error('building')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <div class="py-6">
                            <x-primary-button>Update Dormitory</x-primary-button>
                        </div>
                    </form>

                    <div class="py-6">
                        <form method="POST" action="{{ route('admin.rooms.store') }}" class="max-w-2xl mx-auto my-8">
                            @csrf
                            <input type="hidden" name="dormitory_id" value="{{ $dormitory->id }}">

                            <div class="py-2">
                                <label for="room_number" class="block text-sm font-medium text-gray-700">Room Number: </label>
                                <input type="text" name="room_number" id="room_number" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('room_number')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror

                            <div class="py-2">
                                <label for="beds" class="block text-sm font-medium text-gray-700">Number of Beds: </label>
                                <input type="number" name="beds" id="beds" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('beds')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror

                            <div class="py-6">
                                <x-primary-button>Add Room</x-primary-button>
                            </div>
                        </form>
                    </div>

                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="p-3">Room</th>
                                <th scope="col" class="p-3">Beds</th>
                                <th scope="col" class="p-3">Occupied Beds</th>
                                <th scope="col" class="p-3">Students</th>
                                <th scope="col" class="p-3 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dormitory->rooms as $room)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-3 py-4">
                                    <div class="font-semibold text-black">{{ $room->room_number }}</div>
                                </td>
                                <td class="px-3 py-4">
                                    <div class="font-semibold text-black">{{ $room->beds }}</div>
                                </td>
                                <td class="px-3 py-4">
                                    <div class="font-semibold text-black">{{ $room->occupied_beds }}</div>
                                </td>
                                <td class="px-3 py-4">
                                    <div>
                                        @foreach ($room->accommodations->where('status', 'active') as $accommodation)
                                        <div class="flex justify-between items-center">
                                            <span>{{ $accommodation->student->user->first_name }} {{ $accommodation->student->user->last_name }} ({{ $accommodation->student->fn }})</span>
                                            <div class="flex space-x-2">
                                                <button type="button" class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-2 rounded-md m-1" x-on:click="openConfirmModal({{ $accommodation->id }}, 'left')">Left</button>
                                                <button type="button" class="bg-red-500 hover:bg-red-600 text-white py-1 px-2 rounded-md m-1" x-on:click="openConfirmModal({{ $accommodation->id }}, 'evicted')">Evict</button>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-3 py-4 text-end">
                                    <div class="flex items-center justify-end space-x-4">
                                        <button class="font-medium bg-blue-500 hover:bg-blue-600 text-white py-2 px-8 rounded-md" type="button" x-on:click="openEditRoomModal({{ $room }})">Edit</button>
                                        <form method="POST" action="{{ route('admin.rooms.destroy', ['room' => $room->id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="bg-red-500 hover:bg-red-600 text-white py-2 px-8 rounded-md" type="submit">Delete</button>
                                        </form>
                                        <button class="font-medium bg-green-500 hover:bg-green-600 text-white py-2 px-8 rounded-md" type="button" x-on:click="openAssignStudentModal({{ $room }})">Assign Student</button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Edit Room Modal -->
            <div x-show="showEditRoomModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow p-8">
                    <h2 class="text-xl font-semibold mb-4">Edit Room</h2>
                    <form method="POST" :action="`/admin/rooms/${currentRoom.id}`">
                        @csrf
                        @method('PUT')

                        <div class="py-2">
                            <label for="beds" class="block text-sm font-medium text-gray-700">Number of Beds: </label>
                            <input type="number" name="beds" id="beds" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" x-model="currentRoom.beds">
                        </div>
                        <div class="py-6">
                            <x-primary-button>Update Room</x-primary-button>
                            <x-secondary-button type="button" x-on:click="showEditRoomModal = false">Cancel</x-secondary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Assign Student Modal -->
            <div x-show="showAssignStudentModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow p-8">
                    <h2 class="text-xl font-semibold mb-4">Assign Student to Room</h2>
                    <form method="POST" action="{{ route('admin.accommodations.assign') }}">
                        @csrf

                        <input type="hidden" name="room_id" x-bind:value="currentRoom.id">

                        <div class="py-2">
                            <label for="student_id" class="block text-sm font-medium text-gray-700">Student: </label>
                            <select name="student_id" id="student_id" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <option value="">Select Student</option>
                                @foreach ($students as $student)
                                <option value="{{ $student->id }}">{{ $student->user->first_name }} {{ $student->user->last_name }} ({{ $student->fn }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="py-6">
                            <x-primary-button>Assign Student</x-primary-button>
                            <x-secondary-button type="button" x-on:click="showAssignStudentModal = false">Cancel</x-secondary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Confirm Modal -->
            <div x-show="showConfirmModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow p-8">
                    <h2 class="text-xl font-semibold mb-4">Confirm Action</h2>
                    <p class="mb-4" x-text="confirmMessage"></p>
                    <form method="POST" :action="`/admin/accommodations/${currentAccommodationId}`">
                        @csrf
                        @method('PATCH')

                        <input type="hidden" name="status" x-bind:value="confirmAction">

                        <div class="py-6">
                            <x-primary-button>Confirm</x-primary-button>
                            <x-secondary-button type="button" x-on:click="showConfirmModal = false">Cancel</x-secondary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
