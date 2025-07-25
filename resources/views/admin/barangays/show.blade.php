<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold leading-tight text-gray-800">
            Barangay Details
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 bg-white shadow rounded-lg">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">
                {{ $barangay->brgy_name }}
            </h1>
            <p class="text-gray-600 text-lg">
                City/Municipality: <span class="font-semibold">{{ $barangay->cityMunicipality->city_name }}</span>
            </p>
        </div>

        <div class="space-y-4">
            <div>
                <p class="text-lg text-gray-700"><span class="font-medium">Brgy Code:</span> {{ $barangay->brgy_code }}</p>
            </div>
            <div>
                <p class="text-lg text-gray-700"><span class="font-medium">City Code:</span> {{ $barangay->cityMunicipality->city_code }}</p>
            </div>
        </div>

        <div class="mt-8">
            <a href="{{ route('admin.barangays.edit', $barangay->id) }}" 
                class="mb-5 inline-flex items-center px-4 py-2 text-sm font-medium border text-black bg-green-600 hover:bg-green-700 rounded-md transition duration-200">
                ✏️ Edit
            </a>
        </div>
    </div>
</x-app-layout>
