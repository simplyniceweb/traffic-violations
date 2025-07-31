<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">🚦 Traffic Rule Details</h2>
                <div class="space-x-2">
                    <a href="{{ route('admin.rules.edit', $trafficRule) }}"
                       class="inline-block px-4 py-2 bg-yellow-500 text-white text-sm font-medium rounded hover:bg-yellow-600 transition">
                        ✏️ Edit
                    </a>
                    <a href="{{ route('admin.rules.index') }}"
                       class="inline-block px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded hover:bg-gray-300 transition">
                        ⬅️ Back
                    </a>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="text-sm font-medium text-gray-600">Rule Name:</label>
                    <p class="text-lg font-semibold text-gray-800 mt-1">{{ $trafficRule->rule_name }}</p>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-600">Description:</label>
                    <p class="text-gray-700 mt-1">
                        {{ $trafficRule->description ?? 'No description provided.' }}
                    </p>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-600">Photo:</label>
                    @if ($trafficRule->photo)
                        <img src="{{ asset('storage/' . $trafficRule->photo) }}"
                             alt="Traffic Rule Photo"
                             class="mt-2 w-48 h-auto rounded shadow border border-gray-200">
                    @else
                        <p class="text-gray-400 italic mt-1">No photo available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
