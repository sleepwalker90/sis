<x-student-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Payments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('success'))
                    <div class="bg-green-500 text-white p-4 rounded mb-6">
                        {{ session('success') }}
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="bg-red-500 text-white p-4 rounded mb-6">
                        {{ session('error') }}
                    </div>
                    @endif

                    <!-- Pending Payments -->
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 leading-tight mb-4">{{ __('Pending Payments') }}</h3>
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mb-6">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                            <th scope="col" class="p-3">{{ __('Payment Type') }}</th>
                                <th scope="col" class="p-3">{{ __('Amount') }} (BGN)</th>
                                <th scope="col" class="p-3">{{ __('Create Date') }}</th>
                                <th scope="col" class="p-3 text-center">{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pendingPayments as $payment)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-3 py-4">{{ __(ucfirst(str_replace('_', ' ', $payment->type))) }}</td>
                                <td class="px-3 py-4">{{ number_format($payment->amount, 2) }}</td>
                                <td class="px-3 py-4">{{ $payment->created_at->format('d-m-Y') }}</td>
                                <td class="px-3 py-4 text-center">
                                    <button class="font-medium bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md" type="button"><a href="{{ route('student.payments.pay', $payment->id) }}">{{ __('Pay Now') }}</a></button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 py-4">{{ __('There are no pending payments!') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- History Payments -->
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 leading-tight mb-4">{{ __('Payment History') }}</h3>
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="p-3">{{ __('Payment Type') }}</th>
                                <th scope="col" class="p-3">{{ __('Amount') }} (BGN)</th>
                                <th scope="col" class="p-3">{{ __('Payment Date') }}</th>
                                <th scope="col" class="p-3 text-center">{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($paidPayments as $payment)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-3 py-4">{{ __(ucfirst(str_replace('_', ' ', $payment->type))) }}</td>
                                <td class="px-3 py-4">{{ number_format($payment->amount, 2) }}</td>
                                <td class="px-3 py-4">{{ $payment->updated_at->format('d-m-Y') }}</td>
                                <td class="px-3 py-4 text-center">
                                    <span class="text-gray-500">{{ __(ucfirst($payment->status)) }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 py-4">{{ __('There are no paid payments!') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $paidPayments->links() }}
                </div>
            </div>
        </div>
    </div>
</x-student-layout>