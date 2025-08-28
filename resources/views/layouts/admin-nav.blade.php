<x-nav-link href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.users.*')">
    {{ __('Users') }}
</x-nav-link>
<x-nav-link href="{{ route('admin.violations.index') }}" :active="request()->routeIs('admin.violations.*')">
    {{ __('Violations') }}
</x-nav-link>
<x-nav-link href="{{ route('admin.rules.index') }}" :active="request()->routeIs('admin.rules.*')">
    {{ __('Rules') }}
</x-nav-link>
<x-nav-link href="{{ route('admin.categories.index') }}" :active="request()->routeIs('admin.categories.*')">
    {{ __('Violation Categories') }}
</x-nav-link>
@php
    $isLocalInfoActive = request()->routeIs([
        'admin.regions.*',
        'admin.provinces.*',
        'admin.cities.*',
        'admin.barangays.*',
    ]);
    $active = 'block px-4 py-2 text-sm text-indigo-700 bg-indigo-100';
    $inactive = 'block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900';

    $localLinks = [
        ['route' => 'admin.regions.index', 'label' => __('Regions')],
        ['route' => 'admin.provinces.index', 'label' => __('Provinces')],
        ['route' => 'admin.cities.index', 'label' => __('Cities/Municipalities')],
        ['route' => 'admin.barangays.index', 'label' => __('Barangays')],
    ];
@endphp

<div x-data="{ open: {{ $isLocalInfoActive ? 'true' : 'false' }} }" class="relative hidden sm:flex sm:ms-10 sm:items-center">
    <button @click="open = !open"
        class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 rounded-md transition ease-in-out duration-150
               {{ $isLocalInfoActive ? 'text-indigo-700 bg-indigo-100 font-semibold' : 'text-gray-700 bg-white hover:text-gray-500' }}">
        {{ __('Local Info') }}
        <svg class="ms-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div x-show="open" x-cloak @click.away="open = false"
        class="absolute mt-2 top-11 w-56 rounded-md shadow-lg z-50 bg-white ring-1 ring-black ring-opacity-5 py-1">
        @foreach ($localLinks as $link)
            @php
                $isRouteActive = request()->routeIs(Str::beforeLast($link['route'], '.') . '.*');
            @endphp
            <x-dropdown-link
                :href="route($link['route'])"
                :active="request()->routeIs($link['route'])"
                class="{{ $isRouteActive ? $active : $inactive }}">
                {{ $link['label'] }}
            </x-dropdown-link>
        @endforeach
    </div>
</div>
