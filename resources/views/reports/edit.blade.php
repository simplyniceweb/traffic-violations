<x-app-layout>
    <div class="block mb-14 w-full"></div>
    <div class="max-w-7xl mx-auto p-6 bg-white rounded shadow-md mt-14">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">📋 Update Report</h1>

        <form action="{{ route('reports.update', $report->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="incident_date" class="block font-semibold">Incident Date</label>
                <input type="datetime-local" name="incident_date" id="incident_date"
                    value="{{ old('incident_date', $report->incident_date ? date('Y-m-d\TH:i', strtotime($report->incident_date)) : '') }}"
                    class="w-full border p-2 rounded">
            </div>


            <div
                x-data="locationDropdowns"
                x-init="init()"
                data-initial-region="{{ $report->region_id }}"
                data-initial-province="{{ $report->province_id }}"
                data-initial-city="{{ $report->city_municipality_id }}"
                data-initial-barangay="{{ $report->barangay_id }}"
            >
                <!-- Region -->
                <div class="mb-4">
                    <label class="block font-semibold">Region</label>
                    <select name="region_id" x-model="selectedRegion" @change="loadProvinces()" class="w-full border p-2 rounded text-black">
                        <option value="">Select Region</option>
                        @foreach ($regions as $region)
                            <option value="{{ $region->id }}"  {{ $report->region_id == $region->id ? 'selected' : '' }}>{{ $region->region_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Province -->
                <div class="mb-4">
                    <label class="block font-semibold">Province</label>
                    <select name="province_id" x-model="selectedProvince" @change="loadCities()" class="w-full border p-2 rounded text-black">
                        <option value="">Select Province</option>
                        <template x-if="isLoadingProvinces">
                            <option disabled>Loading...</option>
                        </template>
                        <template x-for="province in provinces" :key="province.id">
                            <option :value="province.id" x-text="province.province_name"></option>
                        </template>
                    </select>
                </div>

                <!-- City -->
                <div class="mb-4">
                    <label class="block font-semibold">City</label>
                    <select name="city_municipality_id" x-model="selectedCity" @change="loadBarangays()" class="w-full border p-2 rounded text-black">
                        <option value="">Select City</option>
                        <template x-if="isLoadingCities">
                            <option disabled>Loading...</option>
                        </template>
                        <template x-for="city in cities" :key="city.id">
                            <option :value="city.id" x-text="city.city_name"></option>
                        </template>
                    </select>
                </div>

                <!-- Barangay -->
                <div class="mb-4">
                    <label class="block font-semibold">Barangay</label>
                    <select name="barangay_id" x-model="selectedBarangay" class="w-full border p-2 rounded text-black">
                        <option value="">Select Barangay</option>
                        <template x-if="isLoadingBarangays">
                            <option disabled>Loading...</option>
                        </template>
                        <template x-for="barangay in barangays" :key="barangay.id">
                            <option :value="barangay.id" x-text="barangay.brgy_name"></option>
                        </template>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block font-semibold">Street</label>
                    <input type="text" name="" id="" class="w-full border p-2 rounded text-black">
                </div>
                <div class="mb-4">
                    <label class="block font-semibold">Landmark</label>
                    <input type="text" name="" id="" class="w-full border p-2 rounded text-black">
                </div>
            </div>

            <div class="mb-4">
                <label for="description" class="block font-semibold">Description</label>
                <textarea name="description" id="description" class="w-full border p-2 rounded">{{ old('description', $report->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label for="violation_type" class="block font-semibold">Violation Types</label>
                <select name="violation_type[]" id="violation_type" class="w-full border p-2 rounded select2" multiple>
                    @foreach ($violations as $violation)
                        <option value="{{ $violation->id }}" 
                            {{ $report->violations->contains($violation->id) ? 'selected' : '' }}>
                            {{ $violation->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="evidence" class="block font-semibold">Upload Additional Evidence</label>
                <input type="file" name="evidence[]" id="evidence" multiple
                    accept=".jpg,.jpeg,.png,.mp4,.mov,.avi" class="w-full border p-2 rounded">
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update Report</button>
        </form>

        <h3 class="text-lg font-semibold text-blue-600 mb-2 mt-6">Current Attachments</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-4">
            @foreach ($report->attachments as $attachment)
                <div class="relative">
                    @if ($attachment->type === 'photo')
                        <img src="{{ asset('storage/' . $attachment->file_path) }}" alt="Attachment" class="w-full h-40 object-cover rounded">
                    @else
                        <video controls class="w-full h-40 rounded">
                            <source src="{{ asset('storage/' . $attachment->file_path) }}">
                        </video>
                    @endif

                    <!-- Optional delete attachment button -->
                    <form action="{{ route('attachments.destroy', $attachment->id) }}" method="POST" class="absolute top-1 right-1">
                        @csrf
                        @method('DELETE')
                        <button class="text-white bg-red-500 rounded-full px-2 text-xs" onclick="return confirm('Remove this file?')">✕</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() {
        $('#violation_type').select2({
            placeholder: "Select violation(s)",
            allowClear: true,
            width: '100%' // Optional: force full width
        });
    });
</script>