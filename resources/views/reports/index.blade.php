<x-app-layout>
    <x-slot name="header">Reports</x-slot>
    <div class="mt-16 text-center mb-5">
        <h1 class="text-2xl sm:text-6xl text-shadow-2xl text-black">List of reports</h1>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        @if (session('success'))
            <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 flex justify-between items-center flex-wrap gap-4">
            <!-- Left: Create Button -->
            <a href="{{ route('reports.create') }}" class="bg-green-500 text-white rounded px-5 py-3 font-bold">
                Create a Report
            </a>

            <!-- Right: Status Filter -->
            <form method="GET" action="{{ route('reports.index') }}" class="inline-block">
                <label for="status" class="font-semibold mr-2">Filter by Status:</label>
                <select name="status" id="status" onchange="this.form.submit()" class="border rounded px-2 pr-8 py-1 w-40">
                    <option value="">All</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under Review</option>
                </select>
            </form>
        </div>


        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded">
            <table class="w-full text-sm text-left text-gray-700 dark:text-gray-200">
                <thead class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                    <tr class="bg-gray-100">
                        <th class="py-2 px-4 border-b">Reporter</th>
                        <th class="py-2 px-4 border-b">Region</th>
                        <th class="py-2 px-4 border-b">Province</th>
                        <th class="py-2 px-4 border-b">City</th>
                        <th class="py-2 px-4 border-b">Barangay</th>
                        <th class="py-2 px-4 border-b">Description</th>
                        <th class="py-2 px-4 border-b">Date</th>
                        <th class="py-2 px-4 border-b">Status</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $report->user->name ?? 'N/A' }}</td>
                            <td class="py-2 px-4 border-b">{{ $report->region->region_name ?? 'N/A' }}</td>
                            <td class="py-2 px-4 border-b">{{ $report->province->province_name ?? 'N/A' }}</td>
                            <td class="py-2 px-4 border-b">{{ $report->city->city_name ?? 'N/A' }}</td>
                            <td class="py-2 px-4 border-b">{{ $report->barangay->brgy_name ?? 'N/A' }}</td>
                            <td class="py-2 px-4 border-b">{{ \Illuminate\Support\Str::limit($report->description, 150) }}</td>
                            <td class="py-2 px-4 border-b">{{ $report->created_at->format('Y-m-d H:i') }}</td>
                            <td class="py-2 px-4 border-b">
                                @if($report->status === 'pending')
                                    <button class="rounded-full bg-yellow-500 text-white font-bold p-1 px-2 whitespace-nowrap">Pending</button>
                                @elseif($report->status === 'under_review')
                                    <button class="rounded-full bg-blue-500 text-white font-bold p-1 px-2 whitespace-nowrap">In Progress</button>
                                @elseif($report->status === 'resolved')
                                    <button class="rounded-full bg-green-500 text-white font-bold p-1 px-2 whitespace-nowrap">Resolved</button>
                                @elseif($report->status === 'rejected')
                                    <button class="rounded-full bg-red-500 text-white font-bold p-1 px-2 whitespace-nowrap">Rejected</button>
                                @endif
                            </td>
                            <td class="py-2 px-4 border-b">
                                <div class="inline-flex rounded-md shadow-sm overflow-hidden" role="group">
                                    <!-- View Button -->
                                    <a href="{{ route('reports.show', $report->id) }}"
                                        class="px-4 py-2 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 focus:z-10 focus:outline-none">
                                        View
                                    </a>

                                    <!-- Edit Button -->
                                    <a href="{{ route('reports.edit', $report->id) }}"
                                        class="px-4 py-2 text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:z-10 focus:outline-none border-l border-white">
                                        Edit
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('reports.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-4 py-2 text-sm font-medium text-white bg-red-500 hover:bg-red-600 focus:z-10 focus:outline-none border-l border-white">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500">No reports found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $reports->links() }}
        </div>
    </div>
</x-app-layout>