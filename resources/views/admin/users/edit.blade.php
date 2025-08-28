<x-app-layout>
    <x-slot name="header">Edit User</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @if(session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">New Password <span class="text-gray-400">(leave blank to keep current)</span></label>
                <input type="password" name="password"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="role" class="block font-medium text-sm text-gray-700">Register as</label>
                <select id="role" name="role" required class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                    <option value="administrator" {{ $user->role === 'administrator' ? 'selected' : '' }}>Administrator</option>
                    <option value="reporter" {{ $user->role === 'reporter' ? 'selected' : '' }}>Reporter</option>
                    <option value="officer" {{ $user->role === 'officer' ? 'selected' : '' }}>Officer</option>
                </select>
                @error('role')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="city" class="block font-medium text-sm text-gray-700">City/Municipality</label>
                <select id="city" name="city" required class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                    <option value="">Select a city/municipality</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}" {{ $user->city && $user->city->id === $city->id ? 'selected' : '' }}>{{ $city->city_name }} - {{ $city->province->province_name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Photo --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Profile Photo</label>
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 rounded-full overflow-hidden border border-gray-300">
                        @if ($user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="User Photo" class="object-cover w-full h-full">
                        @else
                            <img src="{{ asset('assets/unisex.png') }}" alt="Default" class="object-cover w-full h-full">
                        @endif
                    </div>
                    <input type="file" name="photo"
                        class="ms-3 w-full border border-gray-300 rounded-lg px-4 py-2 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
                @error('photo')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="pt-6 flex justify-end space-x-4">
                <a href="{{ route('admin.users.index') }}"
                class="inline-block px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg text-sm">Cancel</a>
                <button type="submit"
                    class="inline-block px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium shadow-md">
                    💾 Update User
                </button>
            </div>
        </form>
    </div>
</x-app-layout>