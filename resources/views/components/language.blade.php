<div x-data="{ open: false }" {{ $attributes->merge(['class' => 'relative inline-block text-left']) }}>
    <div>
        <button @click="open = !open" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="options-menu" aria-haspopup="true" aria-expanded="true">
            @if (App::getLocale() == 'en')
            <img src="https://upload.wikimedia.org/wikipedia/commons/0/0b/English_language.svg" alt="English" class="h-5 w-5 rounded-full mr-2">
            English
            @else
            <img src="https://upload.wikimedia.org/wikipedia/commons/9/9a/Flag_of_Bulgaria.svg" alt="Български" class="h-5 w-5 rounded-full mr-2">
            Български
            @endif
            <!-- Heroicon name: chevron-down -->
            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>
    <div x-show="open" x-cloak @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
        <div class="py-1" role="none">
            <a href="{{ route('lang.switch', 'en') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 @if (App::getLocale() == 'en') font-bold @endif" role="menuitem">
                <img src="https://upload.wikimedia.org/wikipedia/commons/0/0b/English_language.svg" alt="English" class="h-5 w-5 rounded-full mr-2"> English
            </a>
            <a href="{{ route('lang.switch', 'bg') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 @if (App::getLocale() == 'bg') font-bold @endif" role="menuitem">
                <img src="https://upload.wikimedia.org/wikipedia/commons/9/9a/Flag_of_Bulgaria.svg" alt="Български" class="h-5 w-5 rounded-full mr-2"> Български
            </a>
        </div>
    </div>
</div>