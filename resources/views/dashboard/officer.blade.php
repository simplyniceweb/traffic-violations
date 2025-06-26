<x-app-layout>
    <x-slot name="header">Officer Dashboard</x-slot>
    <div class="mt-5 text-center">
        <h1 class="text-6xl text-shadow-2xl text-black">Welcome, officer!</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6 bg-gray-100">
            <!-- Column 1: Reports -->
            <div class="bg-white rounded-2xl shadow p-4">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold">Traffic violations list</h2>
                    <button class="bg-blue-500 text-white text-sm px-4 py-2 rounded-full hover:bg-blue-600">Add Violation</button>
                </div>
                <ul class="space-y-2">
                    <li class="p-3 rounded-lg bg-gray-100 hover:bg-gray-200 cursor-pointer">Report #1</li>
                    <li class="p-3 rounded-lg bg-gray-100 hover:bg-gray-200 cursor-pointer">Report #2</li>
                    <li class="p-3 rounded-lg bg-gray-100 hover:bg-gray-200 cursor-pointer">Report #3</li>
                    <li class="p-3 rounded-lg bg-gray-100 hover:bg-gray-200 cursor-pointer">Report #4</li>
                    <li class="p-3 rounded-lg bg-gray-100 hover:bg-gray-200 cursor-pointer">Report #5</li>
                </ul>
            </div>

            <!-- Column 2: Officer Info -->
            <div class="bg-white rounded-2xl shadow p-4 flex flex-col items-center">
                <img src="{{ asset('assets/officer.png') }}" alt="Officer" class="rounded-full w-24 h-24 object-cover mb-3">
                <h3 class="text-lg font-semibold">Officer John Doe</h3>
                <p class="text-gray-500 mb-4">Traffic Officer</p>
                <div class="text-center mt-5">
                    <p class="text-4xl text-gray-600">Number of Violations</p>
                    <p class="text-6xl font-bold text-orange-600">20</p>
                </div>
            </div>

            <!-- Column 3: Chart -->
            <div class="bg-white rounded-2xl shadow p-4 flex flex-col items-center justify-center">
                <h2 class="text-xl font-bold mb-4">Report Status</h2>
                <div class="w-[250px] h-[250px]">
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
                    data: [25, 25, 25, 25],
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
</script>