<x-guest-layout>
    <div class="flex items-center justify-center bg-gray-100 p-4">
        <div class="bg-white shadow-lg rounded-2xl p-8 max-w-md text-center">
            <div class="text-red-600 text-6xl mb-4">🚫</div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Account Banned</h1>
            <p class="text-gray-600 mb-6">
                Your account has been banned. Please contact support if you believe this is a mistake.
            </p>
            <p class="m-3">{{ $reason }}</p>
            <a href="{{ route('login') }}" 
               class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 pb-3 mb-3">
                Back to Login
            </a>
        </div>
    </div>
</x-guest-layout>