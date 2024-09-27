<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex items-center justify-between">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ __('Admins') }}
                    </div>
                    <div class="m-5">
                        <a href="{{ route('admin.users.create') }}" class="font-medium bg-blue-500 hover:bg-blue-600 text-white py-2 px-8 rounded-md">{{ __('New user') }}</a>
                    </div>
                </div>

                <div x-data="{ 
                    showConfirmation: false, 
                    userId: '', 
                    userName: '', 
                    openConfirmationModal(userId, userName) {
                        this.userId = userId;
                        this.userName = userName;
                        this.showConfirmation = true;
                    } 
                }">

                    <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 mx-5 bg-white dark:bg-gray-900">
                        <div></div>
                        <label for="table-search" class="sr-only">Search</label>
                        <form method="GET" action="{{ route('admin.users') }}" class="relative">
                            <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="text" name="search" id="table-search-users" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ __('Search for users') }}" value="{{ request()->query('search') }}">
                        </form>
                    </div>

                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Name') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Role') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Phone Number') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    {{ __('Actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                        @if ($user->photo)
                                            <img src="{{ asset('storage/' . $user->photo) }}" alt="Profile Photo" class="w-10 h-10 rounded-full">
                                        @else
                                            <img class="w-10 h-10 rounded-full" src="https://i.pravatar.cc/150?img={{Auth::user()->id}}" alt="Avatar image">
                                        @endif
                                        <div class="ps-3">
                                            <div class="text-base font-semibold">{{ $user->first_name." ".$user->last_name}}</div>
                                            <div class="font-normal text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $user->roles->first->name ? ucwords($user->roles->first()->name) : 'None' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div> {{ $user->phone_number }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-end">
                                        <div class="flex items-center justify-end space-x-4">
                                            <a href="{{ route('admin.users.edit',['user' => $user->id]) }}" class="font-medium bg-blue-500 hover:bg-blue-600 text-white py-2 px-8 rounded-md">{{ __('Edit') }}</a>
                                            <form method="POST" action="/admin/users/{{ $user->id }}" id="{{ $user->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="bg-red-500 hover:bg-red-600 text-white py-2 px-8 rounded-md" x-on:click="openConfirmationModal('{{ $user->id }}', '{{ $user->first_name }}')" type="button">{{ __('Delete') }}</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mx-5 my-2">
                        {{ $users->links() }}
                    </div>

                    <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-cloak x-show="showConfirmation">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" x-show="showConfirmation" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" x-show="showConfirmation" @click.away="showConfirmation = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-50" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-50">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start">
                                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                        </div>
                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                                {{ __('Delete user') }}
                                            </h3>
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-500">
                                                    {{ __('Are you sure you want to delete user') }} <strong x-text="userName"></strong>? {{ __('This action cannot be undone.') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="button" x-on:click="document.getElementById(userId).submit()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        {{ __('Delete') }}
                                    </button>
                                    <button type="button" x-on:click="showConfirmation = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        {{ __('Cancel') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-admin-layout>
