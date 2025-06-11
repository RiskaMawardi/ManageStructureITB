<div id="editEmployeeModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white w-full max-w-3xl rounded-2xl shadow-lg overflow-hidden">
        <div class="px-6 py-5 border-b">
            <h2 class="text-2xl font-bold text-gray-800">Edit Employee</h2>
        </div>

        <form id="editEmployeeForm" method="POST" class="px-6 py-5 space-y-6">
            @csrf
            <input type="hidden" name="id" id="editEmpId">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="editEmployeeID" class="block text-sm font-medium text-gray-700 mb-1">Employee ID</label>
                    <input type="text" name="EmployeeID" id="editEmployeeID"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div>
                    <label for="editEmployeeName" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="EmployeeName" id="editEmployeeName"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div>
                    <label for="editJoinDate" class="block text-sm font-medium text-gray-700 mb-1">Join Date</label>
                    <input type="datetime-local" name="JoinDate" id="editJoinDate"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="editEndDate" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input type="datetime-local" name="EndDate" id="editEndDate"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="editStatusVacant" class="block text-sm font-medium text-gray-700 mb-1">Status Vacant</label>
                    <input type="text" name="StatusVacant" id="editStatusVacant"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="editEmailID" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="EmailID" id="editEmailID"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="md:col-span-2">
                    <label for="editPhoneNumber" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <input type="text" name="PhoneNumber" id="editPhoneNumber"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t mt-6">
                <button type="button" id="closeEditModalBtn"
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition mr-2">
                    Cancel
                </button>
                <button type="button" id="saveEditBtn"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>
