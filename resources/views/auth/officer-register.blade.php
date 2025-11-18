<x-guest-layout>
    <form method="POST" action="{{ route('officer.register.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="province" class="block font-medium text-sm text-gray-700">Province</label>
            <select id="province" name="province" required class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                <option value="">Select a province</option>
                @foreach ($provinces as $province)
                    <option value="{{ $province->id }}" {{ old('province') == $province->id ? 'selected' : '' }}>{{ $province->province_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <label for="city" class="block font-medium text-sm text-gray-700">City/Municipality</label>
            <select id="city" name="city" required class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
            </select>
        </div>

        <div class="mt-4">
            <label for="phone" class="block font-medium text-sm text-gray-700">Phone</label>
            <input id="phone" name="phone" type="tel" placeholder="09XXXXXXXXX" required class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" value="{{ old('phone') }}">
        </div>

        <div class="mt-4">
            <x-input-label for="photo" :value="__('Valid Identification')" />
            <input type="file" name="photo" id="photo"
                    class="w-full p-2 border border-gray-300 rounded" accept="image/*">
            @error('photo')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
<script>
    $('#province').on('change', function () {
        var provinceId = $(this).val();
        $('#city').html('<option value="">Loading...</option>');

        if (provinceId) {
            $.ajax({
                url: '/get-cities/' + provinceId,
                type: 'GET',
                success: function (data) {
                    $('#city').empty().append('<option value="">Select a city/municipality</option>');
                    $.each(data, function (key, city) {
                        $('#city').append('<option value="' + city.id + '">' + city.city_name + '</option>');
                    });
                }
            });
        } else {
            $('#city').html('<option value="">Select a city/municipality</option>');
        }
    });
</script>