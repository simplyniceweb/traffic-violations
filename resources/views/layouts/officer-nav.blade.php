<x-nav-link href="{{ route('officer.violations.index') }}" :active="request()->routeIs('officer.violations.*')">
    {{ __('Violations') }}
</x-nav-link>