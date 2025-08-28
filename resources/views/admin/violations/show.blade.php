<x-app-layout>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Title -->
        <h1 class="text-4xl font-bold mb-6 text-gray-800">{{ $violation->title }}</h1>

        <!-- Details Card -->
        <div class="bg-white shadow rounded-lg p-6 space-y-4">
            <h2 class="text-2xl font-semibold text-gray-700 border-b pb-2">Details</h2>

            <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                <!-- Reporter -->
                <div>
                    <p class="text-sm font-medium text-gray-500">Reporter</p>
                    <p class="text-md text-gray-800">{{ $violation->reporter?->name ?? 'N/A' }}</p>
                </div>

                <!-- Officer -->
                <div>
                    <p class="text-sm font-medium text-gray-500">Officer</p>
                    <p class="text-md text-gray-800">{{ $violation->officer?->name ?? 'N/A' }}</p>
                </div>

                <!-- Barangay -->
                <div>
                    <p class="text-sm font-medium text-gray-500">Barangay</p>
                    <p class="text-md text-gray-800">{{ $violation->barangay?->brgy_name ?? 'N/A' }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500">Description</p>
                    <p class="text-md text-gray-800">{{ $violation->description ?? 'N/A' }}</p>
                </div>

                <div>
                    @if ($violation->attachments->isNotEmpty())
                            <p class="text-sm font-medium text-gray-500">Attachments</p>
                            @foreach ($violation->attachments as $attachment)
                                <div class="bg-gray-50 p-2 rounded shadow">
                                    @if($attachment->type === 'photo')
                                    <a href="{{ asset('storage/' . $attachment->file_path) }}" class="glightbox" data-gallery="attachments" data-width="100%" data-height="auto">
                                        <img src="{{ asset('storage/' . $attachment->file_path) }}" alt="Attachment" class="w-full h-48 object-cover rounded" />
                                    </a>
                                    @else
                                    <a href="{{ asset('storage/' . $attachment->file_path) }}" class="glightbox" data-type="video" data-gallery="attachments" data-width="100%" data-height="100vh">
                                        <video controls class="w-full h-48 rounded">
                                            <source src="{{ asset('storage/' . $attachment->file_path) }}" type="video/{{ pathinfo($attachment->file_path, PATHINFO_EXTENSION) }}">
                                            Your browser does not support the video tag.
                                        </video>
                                    </a>
                                    @endif
                                </div>
                            @endforeach
                    @endif
                </div>

                <div>
                    @if ($violation->reason !== '')
                        <p class="text-sm font-medium text-gray-500">Reason</p>
                        <p class="text-md text-gray-800">{{ $violation->reason ?? 'N/A' }}</p>
                    @endif
                </div>

                <!-- Status -->
                <div>
                    <p class="text-sm font-medium text-gray-500">Status</p>
                    @switch($violation->status)
                        @case('pending')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            @break
                        @case('under_review')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Under Review</span>
                            @break
                        @case('resolved')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Resolved</span>
                            @break
                        @case('rejected')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                            @break
                    @endswitch
                </div>

                <div>
                    <h2 class="text-sm text-gray-600 mb-2"><i class="fa-solid fa-landmark-flag"></i> Landmark: {{ $violation->landmark }}</h2>
                </div>

                <div>
                    <h2 class="text-sm text-gray-600 mb-2"><i class="fa-solid fa-street-view"></i> Street: {{ $violation->street }}</h2>
                </div>
            </div>

            <!-- Categories -->
            <div>
                <p class="text-sm font-medium text-gray-500 mb-2">Categories</p>
                <div class="flex flex-wrap gap-2">
                    @foreach ($violation->category as $category)
                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-indigo-100 text-indigo-800">
                            {{ $category->name }}
                        </span>
                    @endforeach
                </div>
            </div>

            <div>
                <a href="{{ route('admin.violations.index') }}" class="p-3 rounded-lg text-white bg-blue-500 hover:bg-blue-200 cursor-pointer mt-10"><i class="fa-solid fa-arrow-left-long"></i> Back to list</a>
            </div>
        </div>
    </div>
</x-app-layout>
