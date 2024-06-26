@if (session()->has('success') || session()->has('error'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" class="fixed {{ session()->has('success') ? 'bg-blue-500' : 'bg-red-500' }}  text-white py-2 px-4 rounded-xl bottom-3 right-3 text-sm">
        <p>{{ session('success') ?? session('error') }}</p>
    </div>
@endif