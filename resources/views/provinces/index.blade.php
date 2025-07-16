<x-app-layout>
    <x-slot name="header">Provinces</x-slot>
    <div class="mt-5 text-center">
        <h1 class="text-6xl text-shadow-2xl text-black">List of Provinces</h1>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        @if (session('success'))
            <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 flex justify-between items-center flex-wrap gap-4">
            <!-- Left: Create Button -->
            <a href="{{ route('admin.provinces.create') }}" class="bg-green-500 text-white rounded px-5 py-3 font-bold">
                Create a Province
            </a>
        </div>
    </div>
</x-app-layout>