<x-app-layout>
    <x-slot name="header">Violations</x-slot>
    <div class="mt-5 text-center">
        <h1 class="text-6xl text-shadow-2xl text-black"><i class="fa-solid fa-triangle-exclamation"></i> List of Violations</h1>
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
                        <th class="py-2 px-4 border-b">Reporter</th>
                        <th class="py-2 px-4 border-b">Officer</th>
                        <th class="py-2 px-4 border-b">Categories</th>
                        <th class="py-2 px-4 border-b">Barangay</th>
                        <th class="py-2 px-4 border-b">Status</th>
                        <th class="py-2 px-4 border-b">Accept</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($violations as $violation)
                    <tr @if($violation->trashed()) style="opacity: 0.6;" @endif>
                        <td class="py-2 px-4 border-b">{{ $violation->reporter?->name }}</td>
                        <td class="py-2 px-4 border-b">@if ($violation->officer) {{ $violation->officer?->name }} @else <span class="text-gray-500">N/A</span> @endif</td>
                        <td class="py-2 px-4 border-b">
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs font-medium mr-2 p-1 rounded">
                                @php
                                    $cats = $violation->category->pluck('name');
                                    $limited = $cats->take(1)->implode(', ');
                                    $remaining = $cats->count() - 1;
                                @endphp
                                {{ $limited }}
                            </span>
                            @if($remaining > 0) +{{ $remaining }} more @endif
                        </td>
                        <td class="py-2 px-4 border-b">{{ $violation->barangay?->brgy_name }}</td>
                        <td class="py-2 px-4 border-b">
                            @switch($violation->status)
                                @case('pending')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                    @break

                                @case('under_review')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Under Review
                                    </span>
                                    @break

                                @case('resolved')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Resolved
                                    </span>
                                    @break

                                @case('rejected')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Rejected
                                    </span>
                                    @break
                            @endswitch
                        </td>
                        <td class="py-2 px-4 border-b">
                            <div class="flex items-center space-x-3">
                                <span class="text-gray-700">Off</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" value="" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none rounded-full peer dark:bg-gray-700 
                                                peer-checked:after:translate-x-full peer-checked:after:border-white 
                                                after:content-[''] after:absolute after:top-[2px] after:left-[2px] 
                                                after:bg-white after:border-gray-300 after:border after:rounded-full 
                                                after:h-5 after:w-5 after:transition-all 
                                                peer-checked:bg-blue-600"></div>
                                </label>
                            <span class="text-gray-700">On</span>
                            </div>
                        </td>
                        <td class="py-2 px-4 border-b">
                            <div class="inline-flex rounded-md shadow-sm overflow-hidden" role="group">
                                @if ($violation->trashed())
                                    <form class="hidden" action="{{ route('officer.violations.restore', $violation->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                        class="px-4 py-2 text-sm font-medium text-white bg-green-500 hover:bg-green-600 focus:z-10 focus:outline-none border-l border-white">
                                        Restore
                                    </button>
                                    </form>
                                    <span class="bg-gray p-2">No Action Available</span>
                                @else
                                <a href="{{ route('officer.violations.show', $violation->id) }}"
                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 focus:z-10 focus:outline-none border-l border-white">
                                    <i class="fa-solid fa-eye"></i> View
                                </a>
                                <a href="{{ route('officer.violations.edit', $violation->id) }}"
                                    class="px-4 py-2 text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:z-10 focus:outline-none border-l border-white">
                                    Edit
                                </a>
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