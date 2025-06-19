<div id="promoteModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white rounded-lg shadow-lg w-[500px] p-6 relative">
        <h2 class="text-xl font-bold mb-4">Promote Employee</h2>
        <form method="POST" action="">
            @csrf
            <div class="space-y-4">
                <input type="hidden" name="ID" id="promoteID">
                <input type="hidden" name="posID" id="posPromoteID">
                <div>
                     <label class="block text-sm font-medium">EmployeeID</label>
                    <input type="text" name="EmpID" id="EmpID" 
                        class="form-input w-full border border-gray-300 rounded p-2 bg-gray-100" 
                        readonly>
                </div>

                <div>
                    <label class="block text-sm font-medium">Pilih PositionID</label>
                     <select id="PositionID" name="PositionID" class="select2 w-full border px-3 py-2 rounded" required>
                        <option value="">-- Pilih Position ID --</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium">Jabatan Baru</label>
                    <select name="EmployeePosition" class="form-select w-full border border-gray-300 rounded p-2">
                        <option value="AM">AM</option>
                        <option value="RM">RM</option>
                        <option value="GSM">GSM</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium">Start Date</label>
                    <input type="date" name="StartDate" class="form-input w-full border border-gray-300 rounded p-2">
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" id="closePromoteModalBtn" class="bg-gray-300 px-4 py-2 rounded">Batal</button>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Promote</button>
            </div>
        </form>
    </div>
</div>
