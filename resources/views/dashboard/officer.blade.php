<x-app-layout>
    <x-slot name="header">Officer Dashboard</x-slot>
    <div class="mt-5 text-center">
        <h1 class="text-6xl text-shadow-2xl text-black">Welcome, officer!</h1>
        <div class="mt-5">
            @if(auth()->user()?->on_duty)
                <form method="POST" action="{{ route('officer.endDuty') }}">
                    @csrf
                    <button class="bg-red-500 text-white px-4 py-2 rounded">End Duty</button>
                </form>
            @else
                <form method="POST" action="{{ route('officer.startDuty') }}">
                    @csrf
                    <button class="bg-green-500 text-white px-4 py-2 rounded">Start Duty</button>
                </form>
            @endif
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
                            <a href="{{ route('officer.violations.show', $violation->id) }}">
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
                        <a class="block p-3 rounded-lg text-white bg-blue-500 hover:bg-blue-600 transition" href="{{ route('officer.violations.index') }}">View All Violations</a>
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

    setInterval(() => {
        fetch("{{ route('officer.heartbeat') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            }
        });
    }, 5 * 60 * 1000); // every 5 minutes
</script>