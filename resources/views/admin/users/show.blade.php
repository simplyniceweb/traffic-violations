<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-gray-800">👤 User Details</h1>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-200">
            
            <!-- Profile Header -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6 ">
                @if ($user->photo)
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full border-2 border-white">
                @endif
                <h2 class="text-xl font-semibold">{{ $user->name }}</h2>
                <p class="text-sm opacity-90">{{ $user->email }}</p>
            </div>

            <!-- Profile Content -->
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-gray-600 font-medium">Role</span>
                    <span class="px-3 py-1 rounded-full text-sm font-semibold 
                        {{ $user->role === 'officer' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                        {{ Str::ucfirst($user->role) }}
                    </span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-gray-600 font-medium">City</span>
                    <span class="text-gray-800 font-semibold">
                        {{ $user->city->city_name ?? 'N/A' }}
                    </span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-gray-600 font-medium">Phone</span>
                    <span class="text-gray-800 font-semibold">
                        {{ $user->phone ?? 'N/A' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
