<!-- Modal Manage -->
<div id="manageModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white rounded-lg shadow-lg w-[600px] p-6 relative">
        <button id="closeModalManage" class="absolute top-2 right-2 text-gray-500 hover:text-black text-xl">&times;</button>

        <h2 class="text-xl font-bold mb-4">Edit Position Map</h2>

        <form id="editStructureForm">
    <div id="employee-section"></div>
    <!-- Tombol tambah -->
<button id="addEmployeeBtn" type="button" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-700">
    + Tambah Employee
</button>

    <div class="flex justify-end space-x-2 mt-4">
        <button type="button" id="cancelManageBtn" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
    </div>
</form>

    </div>
</div>
