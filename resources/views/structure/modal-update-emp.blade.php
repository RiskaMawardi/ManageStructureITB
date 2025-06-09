<!-- Modal Update Employee -->
<div id="updateEmployeeModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white rounded-lg shadow-lg w-[400px] p-6 relative">
        <h2 class="text-xl font-bold mb-4">Update Employee</h2>

        <form id="updateEmployeeForm" class="space-y-4">
            <input type="hidden" id="oldEmpID" name="oldEmpID" class="w-full border px-3 py-2 rounded bg-gray-100">
            <input type="hidden" id="posID" name="posID" class="w-full border px-3 py-2 rounded bg-gray-100">
            <input type="hidden" id="oldID" name="oldID" class="w-full border px-3 py-2 rounded bg-gray-100">

            <div>
                <label for="newEmpID" class="block text-sm font-medium text-gray-700">Employee ID</label>
                <select id="newEmpID" name="newEmpID" class="select2 w-full border px-3 py-2 rounded" required>
                    <option value="">-- Pilih Employee ID --</option>
                </select>
            </div>

            <div>
                <label for="newStartDate" class="block text-sm font-medium text-gray-700">Start Date</label>
                <input type="date" id="newStartDate" name="newStartDate" class="w-full border px-3 py-2 rounded" required>
            </div>

            <div class="flex items-center space-x-2 mt-2">
                <input type="checkbox" id="isResign" name="isResign" class="rounded" />
                <label for="isResign" class="text-sm font-medium text-gray-700">Is Resign?</label>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" id="cancelUpdateModalBtn" 
                        class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400 transition">
                    Cancel
                </button>
                <button type="submit" 
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>
