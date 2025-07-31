<x-app-layout>
    <div class="max-w-2xl mx-auto py-10 px-6">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Add New Region</h2>

        <form action="{{ route('admin.regions.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Region Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('name')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end space-x-2 mt-6">
                <a href="{{ route('admin.regions.index') }}"
                   class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 text-gray-800">Cancel</a>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
            </div>
        </form>
    </div>
</x-app-layout>
