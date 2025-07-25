<x-app-layout>
    <x-slot name="header">Edit City / Municipality</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <form method="POST" action="{{ route('admin.cities.update', $city->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label for="city_code" class="block text-gray-700 font-medium mb-2">City / Municipality Code</label>
                <input type="text" name="city_code" id="city_code"
                    value="{{ old('city_code', $city->city_code) }}"
                    class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter code" required>
            </div>

            <div class="mb-6">
                <label for="city_name" class="block text-gray-700 font-medium mb-2">City / Municipality Name</label>
                <input type="text" name="city_name" id="city_name"
                    value="{{ old('city_name', $city->city_name) }}"
                    class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter city name" required>
            </div>

            <div class="mb-6">
                <label for="psgc_code" class="block text-gray-700 font-medium mb-2">PSGC Code</label>
                <input type="text" name="psgc_code" id="psgc_code"
                    value="{{ old('psgc_code', $city->psgc_code) }}"
                    class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter PSGC code">
            </div>

            <div class="mb-6">
                <label for="province_id" class="block text-gray-700 font-medium mb-2">Province</label>
                <select name="province_id" id="province_id"
                    class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select a Province</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province->id }}" {{ $city->province_id == $province->id ? 'selected' : '' }}>
                            {{ $province->province_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.cities.index') }}"
                class="px-5 py-2 rounded-full border border-gray-300 text-gray-700 hover:bg-gray-100">
                    Cancel
                </a>
                <button type="submit"
                    class="px-6 py-2 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition">
                    Update City
                </button>
            </div>
        </form>
    </div>
</x-app-layout>