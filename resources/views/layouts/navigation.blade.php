<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            @php
                $user = auth()->user();
                $route = 'home';
                if ($user) {
                    $route = match ($user->role) {
                        'admin' => 'admin.dashboard',
                        'reporter' => 'reporter.dashboard',
                        'officer' => 'officer.dashboard',
                        default => '/',
                    };
                }
            @endphp
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route($route) }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>
                @if(!$user)
                <x-nav-link :href="route('home')" :active="request()->routeIs('home')" class="ms-4">
                    {{ __('Home') }}
                </x-nav-link>
                @endif

                @if($user)
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route($route)" :active="request()->routeIs($route)">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @if($user)
                        @if ($user->role === 'admin')
                            @include('layouts.admin-nav')
                        @elseif ($user->role === 'officer')
                            @include('layouts.officer-nav')
                        @elseif ($user->role === 'reporter')
                            @include('layouts.reporter-nav')
                        @endif
                    @endif
                </div>
                @endif
            </div>

            @php
                $unreadCount = 0;
                if ($user) {
                    $unreadCount = Auth::user()->unreadNotifications()->count();
                }
            @endphp

            @if($user)
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>
                                @if($user)
                                    @if (Auth::user()->photo)
                                        <img src="{{ asset('storage/' .Auth::user()->photo) }}" class="h-auto sm:w-18 object-contain inline-flex w-6 mr-2" alt="">
                                    @else
                                        <img src="{{ asset('assets/unisex.png') }}" class="h-auto sm:w-18 object-contain inline-flex w-6 mr-2" alt="">
                                    @endif
                                    {{ Auth::user()->name }}
                                @endif
                            </div>

                            {{-- Notification Red Dot --}}
                            @if($unreadCount > 0)
                                <span class="absolute -top-1 -right-1 flex h-3 w-3" style="top:10px;left:10px;">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-red-600" style="width:10px;height:10px;"></span>
                                </span>
                            @endif

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if(Auth::user()->unreadNotifications->count())
                            <div class="max-h-60 overflow-y-auto">
                                @foreach(Auth::user()->unreadNotifications as $notification)
                                    <a href="{{ route('reports.show', $notification->data['report_id']) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 mr-2">
                                                <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium">
                                                    {{ $notification->data['message'] }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                            <form method="POST" action="{{ route('notifications.read') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-500 hover:bg-gray-100">
                                    Mark all as read
                                </button>
                            </form>
                        @else
                            <div class="px-4 py-2 text-sm text-gray-500">
                                No new notifications
                            </div>
                        @endif

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            @endif
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    @if($user)
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route($route)" :active="request()->routeIs($route)">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.index')">
                {{ __('Reports') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ $user->name ?? '' }}</div>
                <div class="font-medium text-sm text-gray-500">{{ $user->email ?? '' }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
    @endif
</nav>
