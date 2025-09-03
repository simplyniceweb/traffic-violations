<x-app-layout>
    <x-slot name="header">Administrator Dashboard</x-slot>
    <div class="mt-5 text-center">
        <h1 class="text-6xl text-shadow-2xl text-black">Welcome, administrator!</h1>

        <div class="w-full text-center">
            <button class="bg-green-500 text-white px-4 py-2 rounded-lg mt-5 generate-invite"><i class="fa-solid fa-link"></i> Generate Invitation</button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6 bg-gray-100">
            <!-- Column 1: Reports -->
            <div class="bg-white rounded-2xl shadow p-4">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold">Traffic violations list</h2>
                </div>
                <ul class="space-y-2">
                    @foreach ($violations as $violation)
                        <li class="p-4 rounded-lg bg-white shadow hover:shadow-md transition cursor-pointer">
                            <a href="{{ route('admin.violations.show', $violation->id) }}">
                            <div class="flex items-center justify-between">
                                <span class="font-semibold text-gray-700">#{{ $violation->id }}</span>
                                <span class="text-sm text-gray-500"><i class="fa-solid fa-thumbtack"></i> {{ $violation->barangay?->brgy_name }}</span>
                            </div>
                            <div class="mt-2 flex flex-wrap gap-2">
                                @foreach ($violation->category as $category)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                            </a>
                        </li>
                    @endforeach
                    <li>
                        <a href="{{ route('admin.violations.index') }}" class="block p-3 rounded-lg text-white bg-blue-500 hover:bg-blue-600 transition">View All Violations</a>
                    </li>
                </ul>
            </div>

            <!-- Column 2: Officer Info -->
            <div class="bg-white rounded-2xl shadow p-4 flex flex-col items-center">
                <img src="{{ asset('assets/officer.png') }}" alt="Officer" class="rounded-full w-24 h-24 object-cover mb-3">
                <h3 class="text-lg font-semibold">{{ Auth::user()->name }}</h3>
                <p class="text-gray-500 mb-4"><i class="fa-solid fa-traffic-light"></i> {{ Str::ucfirst(Auth::user()->role) }}</p>
                <div class="text-center mt-5">
                    <p class="text-4xl text-gray-600">Number of Violations</p>
                    <p class="text-6xl font-bold text-orange-600">{{ $violations_count }}</p>
                </div>
            </div>

            <!-- Column 3: Chart -->
            <div class="bg-white rounded-2xl shadow p-4 flex flex-col items-center justify-center">
                <h2 class="text-xl font-bold mb-4">Report Status</h2>
                <div class="w-[350px] h-[350px]">
                    <canvas id="reportChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('reportChart').getContext('2d');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Under review', 'Rejected', 'Completed'],
                datasets: [{
                    label: 'Reports',
                    data: [
                        {{ $reportCounts->pending }},
                        {{ $reportCounts->under_review }},
                        {{ $reportCounts->rejected }},
                        {{ $reportCounts->resolved }}
                    ],
                    backgroundColor: ['#facc15', '#60a5fa', '#f87171', '#4ade80'],
                    borderColor: ['#eab308', '#3b82f6', '#ef4444', '#22c55e'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'left',
                        labels: {
                            color: '#374151', // text-gray-700
                            font: { size: 14 }
                        }
                    }
                }
            }
        });
    });

    $(document).on('click', '.generate-invite', function() {
        const button = $(this);
        const location = window.location.origin;
        button.prop('disabled', true).text('Generating...');

        $.ajax({
            url: '{{ route('admin.invitations.index') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                button.prop('disabled', false).text('Generate Invitation');
                if (response.code) {
                    const code = location+'/register?invitation='+response.code;
                    navigator.clipboard.writeText(code).then(function() {
                        alert('Invitation code copied to clipboard: ' + code);
                    }).catch(function(err) {
                        console.error('Could not copy text: ', err);
                        alert('Invitation code: ' + response.code);
                    });
                } else {
                    alert('No invitation code returned.');
                }
            },
            error: function(xhr) {
                button.prop('disabled', false).text('Generate Invitation');
                alert('An error occurred. Please try again.');
            }
        });
    });
</script>