<x-app-layout>
    <x-slot name="header">Edit Region</x-slot>

    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-300 rounded text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-300 rounded text-red-800">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.regions.update', $region->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="mb-6">
            <label for="psgc_code" class="block text-gray-700 font-medium mb-2">PSGC Code</label>
            <input type="text" name="psgc_code" id="psgc_code" value="{{ old('psgc_code', $region->psgc_code) }}" placeholder="Enter PSGC Code"
                class="rounded-xl w-full px-4 py-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                required>
        </div>
        
        <div class="mb-6">
            <label for="region_name" class="block text-gray-700 font-medium mb-2">Region Name</label>
            <input type="text" name="region_name" id="region_name" value="{{ old('region_name', $region->region_name) }}" placeholder="Enter region name"
                class="rounded-xl w-full px-4 py-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                required>
        </div>
        
        <div class="mb-6">
            <label for="region_code" class="block text-gray-700 font-medium mb-2">Region Code</label>
            <input type="text" name="region_code" id="region_code" value="{{ old('region_code', $region->region_code) }}" placeholder="Enter region code"
                class="rounded-xl w-full px-4 py-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                required>
        </div>

        <div class="flex justify-end">
            <div class="inline-flex overflow-hidden rounded-lg border border-gray-300">
                <a href="{{ route('admin.regions.index') }}"
                    class="px-5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium transition-all duration-200 focus:outline-none">
                    Cancel
                </a>
                <button type="submit"
                    class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium transition-all duration-200 focus:outline-none">
                    Update
                </button>
            </div>
        </div>
    </form>
    </div>
</x-app-layout>