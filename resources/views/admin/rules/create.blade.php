<x-app-layout>
    <x-slot name="header">Traffic Rules</x-slot>
    <div class="mt-5 text-center">
        <h1 class="text-6xl text-shadow-2xl text-black">Traffic Rules List</h1>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 rounded">
            <ul class="list-disc list-inside text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.rules.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="rule_name" class="block text-sm font-medium text-gray-700">Rule Name <span class="text-red-500">*</span></label>
            <input type="text" name="rule_name" id="rule_name" value="{{ old('rule_name') }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="4"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="photo" class="block text-sm font-medium text-gray-700">Photo</label>
            <input type="file" name="photo" id="photo"
                class="mt-1 block w-full text-sm text-gray-600 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.rules.index') }}"
                class="mr-4 inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-300">
                Cancel
            </a>
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-blue-700">
                Save
            </button>
        </div>
    </form>
</x-app-layout>