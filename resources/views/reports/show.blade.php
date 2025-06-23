<x-app-layout>
    <div class="block mb-14 w-full"></div>
    <div class="max-w-7xl mx-auto p-6 bg-white rounded shadow-md mt-14">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">📋 Report Details</h1>

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
                                <img src="{{ asset('storage/' . $attachment->file_path) }}" alt="Attachment" class="w-full h-48 object-cover rounded" />
                            @else
                                <video controls class="w-full h-48 rounded">
                                    <source src="{{ asset('storage/' . $attachment->file_path) }}" type="video/{{ pathinfo($attachment->file_path, PATHINFO_EXTENSION) }}">
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>