<div id="banModal"
     class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50">
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2
                bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
        <h2 class="text-xl font-semibold mb-4">Ban User</h2>

        <form method="POST" action="{{ route('officer.users.ban', $user) }}">
            @csrf
            <label for="ban_reason" class="block text-sm font-medium text-gray-700 mb-2">
                Reason for Ban
            </label>
            <textarea 
                name="ban_reason" 
                id="ban_reason" 
                rows="3" 
                class="w-full border rounded p-2 mb-4 focus:ring focus:ring-red-200"
                placeholder="Enter reason..." 
                required
            ></textarea>

            <div class="flex justify-end gap-2">
                <button 
                    type="button" 
                    id="closeBanModal" 
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    Cancel
                </button>
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Confirm Ban
                </button>
            </div>
        </form>
    </div>
</div>
