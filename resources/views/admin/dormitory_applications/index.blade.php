<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pending Dormitory Applications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="{
            showUpdateApplicationModal: false, 
            currentApplicationId: '', 
            updateStatus: '', 
            updateMessage: '', 
            showBulkApproveModal: false,
            openUpdateApplicationModal(applicationId, status) { 
                this.currentApplicationId = applicationId; 
                this.updateStatus = status; 
                this.updateMessage = status === 'approved' ? 'Are you sure you want to approve this application?' : 'Are you sure you want to deny this application?'; 
                this.showUpdateApplicationModal = true; 
            },
            openBulkApproveModal() {
                this.showBulkApproveModal = true;
            } 
        }">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('success'))
                        <div class="bg-green-500 text-white p-4 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Pending Applications</h3>
                        <button class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md"
                                x-bind:class="{ 'opacity-50 cursor-not-allowed': {{ $pendingApplications->isEmpty() ? 'true' : 'false' }} }"
                                x-bind:disabled="{{ $pendingApplications->isEmpty() ? 'true' : 'false' }}"
                                x-on:click="openBulkApproveModal"
                        >
                            Approve All
                        </button>
                    </div>
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-4">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="p-3">Name</th>
                                <th scope="col" class="p-3">Faculty Number</th>
                                <th scope="col" class="p-3">Status</th>
                                <th scope="col" class="p-3 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pendingApplications as $application)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-3 py-4">
                                        <div class="font-semibold text-black">{{ $application->student->user->first_name }} {{ $application->student->user->last_name }}</div>
                                    </td>
                                    <td class="px-3 py-4">
                                        {{ $application->student->fn }}
                                    </td>
                                    <td class="px-3 py-4">
                                        {{ ucfirst($application->status) }}
                                    </td>
                                    <td class="px-3 py-4 text-center">
                                        <div class="flex items-center justify-center space-x-4">
                                            <button class="font-medium bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-md" type="button" x-on:click="openUpdateApplicationModal({{ $application->id }}, 'approved')">Approve</button>
                                            <button class="font-medium bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-md" type="button" x-on:click="openUpdateApplicationModal({{ $application->id }}, 'denied')">Deny</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">No pending applications.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Update Application Modal -->
            <div x-show="showUpdateApplicationModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-cloak>
                <div class="bg-white rounded-lg shadow p-8">
                    <h2 class="text-xl font-semibold mb-4">Update Application Status</h2>
                    <p class="mb-4" x-text="updateMessage"></p>
                    <form method="POST" :action="`/admin/dormitory-applications/${currentApplicationId}`">
                        @csrf
                        @method('PATCH')

                        <input type="hidden" name="status" x-bind:value="updateStatus">

                        <div class="py-6">
                            <x-primary-button>Update Status</x-primary-button>
                            <x-secondary-button type="button" x-on:click="showUpdateApplicationModal = false">Cancel</x-secondary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bulk Approve Modal -->
            <div x-show="showBulkApproveModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-cloak>
                <div class="bg-white rounded-lg shadow p-8">
                    <h2 class="text-xl font-semibold mb-4">Bulk Approve Applications</h2>
                    <p class="mb-4">Are you sure you want to approve all pending applications and accommodate students?</p>
                    <form method="POST" action="{{ route('admin.dormitory-applications.bulk-approve') }}">
                        @csrf

                        <div class="py-6">
                            <x-primary-button>Yes, Approve All</x-primary-button>
                            <x-secondary-button type="button" x-on:click="showBulkApproveModal = false">Cancel</x-secondary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div>

    </div>
</x-admin-layout>
