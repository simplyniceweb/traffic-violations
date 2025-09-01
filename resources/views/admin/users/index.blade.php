<x-app-layout>
    <x-slot name="header">Users</x-slot>
    <div class="mt-5 text-center">
        <h1 class="text-6xl text-shadow-2xl text-black">List of Users</h1>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        @if (session('success'))
            <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded">
            <table class="w-full text-sm text-left text-gray-700 dark:text-gray-200">
                <thead class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                    <tr class="bg-gray-100">
                        <th class="py-2 px-4 border-b">Name</th>
                        <th class="py-2 px-4 border-b">Email</th>
                        <th class="py-2 px-4 border-b">Role</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr @if($user->trashed()) style="opacity: 0.6;" @endif>
                        <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                        <td class="py-2 px-4 border-b">{{ Str::ucfirst($user->role) }}</td>
                        <td class="py-2 px-4 border-b">
                            <div class="inline-flex rounded-md shadow-sm overflow-hidden" role="group">
                            @if ($user->trashed())
                                <form action="{{ route('admin.users.restore', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                    class="px-4 py-2 text-sm font-medium text-white bg-green-500 hover:bg-green-600 focus:z-10 focus:outline-none border-l border-white">
                                    Restore
                                </button>
                                </form>
                            @else
                            <a href="{{ route('admin.users.show', $user->id) }}"
                                class="px-4 py-2 text-sm font-medium text-white bg-green-500 hover:bg-green-600 focus:z-10 focus:outline-none border-l border-white">
                                View
                            </a>
                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                class="px-4 py-2 text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:z-10 focus:outline-none border-l border-white">
                                Edit
                            </a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Delete this user?')"
                                    class="px-4 py-2 text-sm font-medium text-white bg-red-500 hover:bg-red-600 focus:z-10 focus:outline-none border-l border-white">Delete</button>
                            </form>
                            @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>