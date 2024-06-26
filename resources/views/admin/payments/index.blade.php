<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Payments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="GET" action="{{ route('admin.payments.index') }}" class="mb-4">
                    <div class="mb-4 flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700">Search by FN, EGN or Name</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700">Filter by Payment Type</label>
                                <select name="type" id="type" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <option value="">All</option>
                                    <option value="semester_tax" {{ request('type') == 'semester_tax' ? 'selected' : '' }}>Semester Tax</option>
                                    <option value="dorm_rent" {{ request('type') == 'dorm_rent' ? 'selected' : '' }}>Dorm Rent</option>
                                    <option value="utilities" {{ request('type') == 'utilities' ? 'selected' : '' }}>Utilities</option>
                                </select>
                            </div>
                            <div class="pt-6">
                                <x-primary-button type="submit">Filter</x-primary-button>
                            </div>
                            
                        </div>

                        <div>
                            <a href="{{ route('admin.payments.create') }}" class="font-medium bg-blue-500 hover:bg-blue-600 text-white py-2 px-8 rounded-md">Create Payment</a>
                        </div>

                    </div>
                    
                </form>
                <div>
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="p-3">Student Name</th>
                                <th scope="col" class="p-3">FN</th>
                                <th scope="col" class="p-3">EGN</th>
                                <th scope="col" class="p-3">Payment Type</th>
                                <th scope="col" class="p-3">Amount (BGN)</th>
                                <th scope="col" class="p-3">Status</th>
                                <th scope="col" class="p-3 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-3 py-4">{{ $payment->student->user->first_name }} {{ $payment->student->user->last_name }}</td>
                                <td class="px-3 py-4">{{ $payment->student->fn }}</td>
                                <td class="px-3 py-4">{{ $payment->student->egn }}</td>
                                <td class="px-3 py-4">{{ ucfirst(str_replace('_', ' ', $payment->type)) }}</td>
                                <td class="px-3 py-4">{{ $payment->amount }}</td>
                                <td class="px-3 py-4">{{ $payment->status }}</td>
                                <td class="px-3 py-4 text-end">
                                    @if ($payment->status == 'pending')
                                    <form method="POST" action="{{ route('admin.payments.destroy', $payment->id) }}" onsubmit="return confirm('Are you sure you want to delete this payment?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-medium bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-md">Delete</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $payments->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
