<x-app-layout>
    <div class="block mb-8 w-full"></div>
    <div class="max-w-7xl mx-auto p-6 bg-white rounded shadow-md mt-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">📋 Report Details</h1>


        @if ($report->status === 'rejected')
            <div class="mb-4 p-4 rounded bg-red-100 text-red-800 border border-red-300">
                <h2 class="font-semibold">Reason for Rejection:</h2>
                <p>{{ $report->reason }}</p>
            </div>
        @else
        <div class="block mb-5 w-full">
            <a href="{{ route('reports.edit', $report->id) }}"
                class="rounded px-4 py-2 text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:z-10 focus:outline-none border-l border-white">
                Edit Report
            </a>
        </div>
        @endif

        {{-- Report Info --}}
        <div class="mb-6">
            <p class="mb-2"><span class="font-semibold text-gray-700">Description:</span> {{ $report->description }}</p>
            <p class="mb-2"><span class="font-semibold text-gray-700">Submitted On:</span> {{ $report->created_at->format('F j, Y g:i A') }}</p>
        </div>

        {{-- Violations --}}
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-red-600 mb-2">🚫 Violations</h2>
            @if ($report->violations->isNotEmpty())
                <ul class="list-disc list-inside text-gray-800">
                    @foreach($report->violations as $violation)
                        <li>{{ $violation->name }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500 italic">No violations recorded.</p>
            @endif
        </div>

        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-600 mb-2"><i class="fa-solid fa-landmark-flag"></i> Landmark: {{ $report->landmark }}</h2>
        </div>

        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-600 mb-2"><i class="fa-solid fa-street-view"></i> Street: {{ $report->street }}</h2>
        </div>

        {{-- Attachments --}}
        <div>
            <h2 class="text-lg font-semibold text-blue-600 mb-4">📎 Attachments</h2>
            @if ($report->attachments->isEmpty())
                <p class="text-gray-500 italic">No attachments submitted.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($report->attachments as $attachment)
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
                </div>
            @endif
        </div>
    </div>
</x-app-layout>