<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">✏️ Edit Traffic Rule</h2>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-sm text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.rules.update', $trafficRule) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="rule_name" class="block text-sm font-medium text-gray-700">Rule Name <span class="text-red-500">*</span></label>
                    <input type="text" name="rule_name" id="rule_name" value="{{ old('rule_name', $trafficRule->rule_name) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="4"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description', $trafficRule->description) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Current Photo</label>
                    @if ($trafficRule->photo)
                        <img src="{{ asset('storage/' . $trafficRule->photo) }}" alt="Current Photo"
                            class="w-24 p-3 h-auto mt-2 rounded border shadow">
                    @else
                        <p class="text-gray-400 italic mt-1">No photo uploaded.</p>
                    @endif
                </div>

                <div>
                    <label for="photo" class="block text-sm font-medium text-gray-700">Change Photo</label>
                    <input type="file" name="photo" id="photo"
                        class="mt-1 block w-full text-sm text-gray-600 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="flex justify-between">
                    <a href="{{ route('admin.rules.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                        ⬅️ Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        💾 Update Rule
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
