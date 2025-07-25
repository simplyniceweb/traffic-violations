<x-app-layout>
    <x-slot name="header">Edit Province</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <form method="POST" action="{{ route('admin.provinces.update', $province->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label for="province_code" class="block text-gray-700 font-medium mb-2">Province Code</label>
                <input type="text" name="province_code" id="province_code"
                    value="{{ old('province_code', $province->province_code) }}"
                    class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter province code" required>
            </div>

            <div class="mb-6">
                <label for="province_name" class="block text-gray-700 font-medium mb-2">Province Name</label>
                <input type="text" name="province_name" id="province_name"
                    value="{{ old('province_name', $province->province_name) }}"
                    class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter province name" required>
            </div>

            <div class="mb-6">
                <label for="psgc_code" class="block text-gray-700 font-medium mb-2">PSGC Code</label>
                <input type="text" name="psgc_code" id="psgc_code"
                    value="{{ old('psgc_code', $province->psgc_code) }}"
                    class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter PSGC code">
            </div>

            <div class="mb-6">
                <label for="region_id" class="block text-gray-700 font-medium mb-2">Region</label>
                <select name="region_id" id="region_id"
                    class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select a Region</option>
                    @foreach ($regions as $region)
                        <option value="{{ $region->id }}" {{ $province->region_id == $region->id ? 'selected' : '' }}>
                            {{ $region->region_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.provinces.index') }}"
                class="px-5 py-2 rounded-full border border-gray-300 text-gray-700 hover:bg-gray-100">
                    Cancel
                </a>
                <button type="submit"
                    class="px-6 py-2 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition">
                    Update Province
                </button>
            </div>
        </form>
    </div>
</x-app-layout>