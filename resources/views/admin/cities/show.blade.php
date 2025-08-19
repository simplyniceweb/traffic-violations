<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold leading-tight text-gray-800">
            City/Municipality Details
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 bg-white shadow rounded-lg">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">
                {{ $city->city_name }}
            </h1>
            <p class="text-gray-600 text-lg">
                Province: <span class="font-semibold">{{ $city->province->province_name }}</span>
            </p>
        </div>

        <div class="space-y-4">
            <div>
                <p class="text-lg text-gray-700"><span class="font-medium">PSGC Code:</span> {{ $city->province->psgc_code }}</p>
            </div>
            <div>
                <p class="text-lg text-gray-700"><span class="font-medium">City Code:</span> {{ $city->city_code }}</p>
            </div>
        </div>

        <div class="mt-8">
            <a href="{{ route('admin.cities.edit', $city->id) }}" 
                class="mb-5 inline-flex items-center px-4 py-2 text-sm font-medium border text-black bg-green-600 hover:bg-green-700 rounded-md transition duration-200">
                ✏️ Edit
            </a>
        </div>
    </div>
</x-app-layout>
