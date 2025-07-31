<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">🚦 Traffic Rules</h1>

        @if($trafficRules->isEmpty())
            <div class="bg-yellow-100 text-yellow-800 p-4 rounded">
                No traffic rules available at the moment.
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($trafficRules as $rule)
                    <div class="bg-white shadow rounded-lg p-6 border hover:shadow-md transition">
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">
                            {{ $rule->rule_name }}
                        </h2>

                        @if($rule->photo)
                            <img src="{{ asset('storage/' . $rule->photo) }}" alt="Rule Photo" class="w-full h-40 object-cover rounded mb-4">
                        @else
                            <div class="h-40 bg-gray-100 flex items-center justify-center text-gray-400 italic rounded mb-4">
                                No photo
                            </div>
                        @endif

                        <p class="text-gray-700 text-sm">
                            {{ $rule->description ?? 'No description available.' }}
                        </p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
