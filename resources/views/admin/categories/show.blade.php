<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold leading-tight text-gray-800">
            Category Details
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 bg-white shadow rounded-lg">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">
                {{ $category->name }}
            </h1>
            <p class="text-gray-600 text-lg">
                Type: <span class="font-semibold">{{ $category->type }}</span>
            </p>
        </div>

        <div class="mt-8">
            <a href="{{ route('admin.categories.edit', $category->id) }}" 
                class="mb-5 inline-flex items-center px-4 py-2 text-sm font-medium border text-black bg-green-600 hover:bg-green-700 rounded-md transition duration-200">
                ✏️ Edit
            </a>
        </div>
    </div>
</x-app-layout>