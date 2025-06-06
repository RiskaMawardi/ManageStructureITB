<!-- Modal Manage -->
<div id="manageModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white rounded-lg shadow-lg w-[600px] p-6 relative">
    
        <h2 class="text-xl font-bold mb-6">Position Map</h2>

        <form id="editStructureForm" class="space-y-4">
            <div id="employee-section"></div>

            <div class="flex space-x-4">
                <button id="setVacant" type="button" 
                        class="px-4 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-700 transition">
                    Set to Vacant
                </button>
                <button id="updateEmployeeBtn" type="button" 
                        class="px-4 py-2 bg-green-600 text-white rounded shadow hover:bg-green-700 transition">
                    Update Employee
                </button>
            </div>

            <div class="flex justify-end space-x-2 mt-6">
                <button type="button" id="cancelManageBtn" 
                        class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400 transition">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>
