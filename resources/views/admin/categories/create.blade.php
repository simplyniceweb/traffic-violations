<x-app-layout>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 bg-white rounded-sm shadow-sm">
        <h2 class="text-2xl font-bold mb-6">Edit Category</h2>

        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-2">Category Name</label>
                <input type="text" name="name" id="name"
                    value=""
                    class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required>
            </div>

            <div class="mb-4">
                <label for="type" class="block text-gray-700 font-medium mb-2">Type</label>
                @php
                    $types = [
                        'Driver',
                        'Vehicle',
                        'Parking',
                        'Motorcycle',
                        'PUV',
                        'Tricycle',
                        'Behavior',
                        'Other'
                    ];
                @endphp
                <select class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none" name="type" id="type">
                    @foreach ($types as $type)
                        <option value="{{ $type }}">
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('admin.categories.index') }}" class="bg-gray-200 text-gray-800 px-5 py-2 rounded-full hover:bg-gray-300">Cancel</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>