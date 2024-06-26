<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex items-center justify-between">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ __("Admin dashboard coming soon!") }}
                    </div>
                   
                </div>


                <div>

                    <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 mx-5 bg-white dark:bg-gray-900">
                        

                        
                        
                    </div>
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="p-3">
                                    Date
                                </th>
                                <th scope="col" class="p-3">
                                    Ip
                                </th>
                                <th scope="col" class="p-3">
                                    Browser
                                </th>
                                <th scope="col" class="p-3 text-center">
                                    Successful
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loginRecords as $record)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="p-3">
                                    {{ $record->login_at }}
                                </td>
                                <td class="p-3">
                                    {{ $record->ip_address }}
                                </td>
                                <td class="p-3">
                                    {{ $record->client }}
                                </td>
                                <td class="p-3 text-end">
                                    {!! $record->successful ? '<span class="text-green-500">&#10004;</span>' : '<span class="text-red-500">&#10060;</span>' !!}
                                </td>
                            </tr>
                            @endforeach


                        </tbody>
                    </table>
                    
                    </div>
                </div>
            </div>
        </div>
</x-admin-layout>