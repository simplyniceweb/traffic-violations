<x-app-layout>
    <x-slot name="header">Violation Categories</x-slot>
    <div class="mt-5 text-center">
        <h1 class="text-6xl text-shadow-2xl text-black">List of Violation Categories</h1>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        @if (session('success'))
            <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 flex justify-between items-center flex-wrap gap-4">
            <!-- Left: Create Button -->
            <a href="{{ route('admin.categories.create') }}" class="bg-green-500 text-white rounded px-5 py-3 font-bold">
                Create a Category
            </a>
        </div>

        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded">
            <table class="w-full text-sm text-left text-gray-700 dark:text-gray-200">
                <thead class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                    <tr class="bg-gray-100">
                        <th class="py-2 px-4 border-b">Name</th>
                        <th class="py-2 px-4 border-b">Type</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                    <tr @if($category->trashed()) style="opacity: 0.6;" @endif>
                        <td class="py-2 px-4 border-b">{{ $category->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $category->type }}</td>
                        <td class="py-2 px-4 border-b">
                            <div class="inline-flex rounded-md shadow-sm overflow-hidden" role="group">
                                @if ($category->trashed())
                                    <form action="{{ route('admin.categories.restore', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                        class="px-4 py-2 text-sm font-medium text-white bg-green-500 hover:bg-green-600 focus:z-10 focus:outline-none border-l border-white">
                                        Restore
                                    </button>
                                    </form>
                                @else
                                <!-- View Button -->
                                <a href="{{ route('admin.categories.show', $category->id) }}"
                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 focus:z-10 focus:outline-none">
                                    View
                                </a>

                                <!-- Edit Button -->
                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                    class="px-4 py-2 text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:z-10 focus:outline-none border-l border-white">
                                    Edit
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 text-sm font-medium text-white bg-red-500 hover:bg-red-600 focus:z-10 focus:outline-none border-l border-white">
                                        Delete
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>
</x-app-layout>