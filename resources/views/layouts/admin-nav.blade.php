<x-nav-link>
    {{ __('Users') }}
</x-nav-link>
<x-nav-link>
    {{ __('Officers') }}
</x-nav-link>
<x-nav-link>
    {{ __('Violations') }}
</x-nav-link>
<x-nav-link :href="route('admin.regions.index')" :active="request()->routeIs('admin.regions.index')">
    {{ __('Regions') }}
</x-nav-link>
<x-nav-link :href="route('admin.provinces.index')" :active="request()->routeIs('admin.provinces.index')">
    {{ __('Provinces') }}
</x-nav-link>
<x-nav-link :href="route('admin.cities.index')" :active="request()->routeIs('admin.cities.index')">
    {{ __('Cities/Municipalities') }}
</x-nav-link>
<x-nav-link :href="route('admin.barangays.index')" :active="request()->routeIs('admin.barangays.index')">
    {{ __('Barangays') }}
</x-nav-link>