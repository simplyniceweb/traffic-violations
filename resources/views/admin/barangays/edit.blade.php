<x-app-layout>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h2 class="text-2xl font-bold mb-6">Edit Barangay</h2>

    <form action="{{ route('admin.barangays.update', $barangay->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="brgy_code" class="block text-gray-700 font-medium mb-2">Barangay Code</label>
            <input type="text" name="brgy_code" id="brgy_code"
                   value="{{ old('brgy_code', $barangay->brgy_code) }}"
                   class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                   required>
        </div>

        <div class="mb-4">
            <label for="brgy_name" class="block text-gray-700 font-medium mb-2">Barangay Name</label>
            <input type="text" name="brgy_name" id="brgy_name"
                   value="{{ old('brgy_name', $barangay->brgy_name) }}"
                   class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                   required>
        </div>

        <div class="mb-4">
            <label for="city_municipality_id" class="block text-gray-700 font-medium mb-2">City / Municipality</label>
            <select name="city_municipality_id" id="city_municipality_id"
                    class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}" {{ $barangay->city_municipality_id == $city->id ? 'selected' : '' }}>
                        {{ $city->city_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('admin.barangays.index') }}" class="bg-gray-200 text-gray-800 px-5 py-2 rounded-full hover:bg-gray-300">Cancel</a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700">Update</button>
        </div>
    </form>
    </div>
</x-app-layout>