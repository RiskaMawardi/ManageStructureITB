<div id="detailModal" class="fixed inset-0 flex items-center justify-center z-50 hidden bg-black bg-opacity-50">
    <div class="bg-white w-full max-w-5xl rounded-lg shadow-lg p-6 overflow-y-auto max-h-[90vh]">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Detail Rayon</h3>
            <button id="closeModalBtn" class="text-gray-600 hover:text-gray-800 text-2xl">&times;</button>
        </div>

        <form id="updatePositionStructureForm">
            @csrf
            @method('PUT')
            <input type="hidden" id="structureId" name="ID">

            <!-- Informasi Rayon -->
            <div class="mb-6">
                <h4 class="text-md font-semibold mb-2">Informasi Rayon</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="PositionID">Position ID</label>
                        <input type="text" id="position_structure_PositionID" name="PositionID" class="form-input w-full" />
                    </div>
                    <div>
                        <label for="AreaID">Area ID</label>
                        <input type="text" id="position_structure_AreaID" name="AreaID" class="form-input w-full" />
                    </div>
                    <div>
                        <label for="AreaBaseID">Area Base ID</label>
                        <input type="text" id="position_structure_AreaBaseID" name="AreaBaseID" class="form-input w-full" />
                    </div>
                    <div>
                        <label for="AreaFF">Area FF</label>
                        <input type="text" id="position_structure_AreaFF" name="AreaFF" class="form-input w-full" />
                    </div>
                    <div>
                        <label for="RayonID">Rayon ID</label>
                        <input type="text" id="position_structure_RayonID" name="RayonID" class="form-input w-full" />
                    </div>
                    <div>
                        <label for="LineID">Line ID</label>
                        <input type="text" id="position_structure_LineID" name="LineID" class="form-input w-full" />
                    </div>
                    <div>
                        <label for="LineBaseID">Line Base ID</label>
                        <input type="text" id="position_structure_LineBaseID" name="LineBaseID" class="form-input w-full" />
                    </div>
                    <div>
                        <label for="LinePositionFF">Line Position FF</label>
                        <input type="text" id="position_structure_LinePositionFF" name="LinePositionFF" class="form-input w-full" />
                    </div>
                    <div>
                        <label for="AmPos">AM Position</label>
                        <input type="text" id="position_structure_AmPos" name="AmPos" class="form-input w-full" />
                    </div>
                    <div>
                        <label for="RmPos">RM Position</label>
                        <input type="text" id="position_structure_RmPos" name="RmPos" class="form-input w-full" />
                    </div>
                    <div>
                        <label for="SMPos">SM Position</label>
                        <input type="text" id="position_structure_SMPos" name="SMPos" class="form-input w-full" />
                    </div>
                    <div>
                        <label for="NSMPos">NSM Position</label>
                        <input type="text" id="position_structure_NSMPos" name="NSMPos" class="form-input w-full" />
                    </div>
                    <div>
                        <label for="MMPos">MM Position</label>
                        <input type="text" id="position_structure_MMPos" name="MMPos" class="form-input w-full" />
                    </div>
                    <div>
                        <label for="GMPos">GM Position</label>
                        <input type="text" id="position_structure_GMPos" name="GMPos" class="form-input w-full" />
                    </div>
                    <div>
                        <label for="MDPos">MD Position</label>
                        <input type="text" id="position_structure_MDPos" name="MDPos" class="form-input w-full" />
                    </div>
                    <div>
                        <label for="StartDate">Start Date</label>
                        <input type="datetime-local" id="position_structure_StartDate" name="StartDate" class="form-input w-full" />
                    </div>
                    <div>
                        <label for="EndDate">End Date</label>
                        <input type="datetime-local" id="position_structure_EndDate" name="EndDate" class="form-input w-full" />
                    </div>
                    <div>
                        <label for="Status_Default">Position Status</label>
                        <input type="text" id="position_structure_PositionStatus" name="Status_Default" class="form-input w-full" />
                    </div>
                </div>
            </div>

            <!-- Employee -->
            <!-- <div class="mb-4">
                <h4 class="text-md font-semibold mb-2">Employee</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="EmpID">Employee ID</label>
                        <input type="text" id="employee_EmployeeID" name="EmpID" class="form-input w-full" />
                    </div>
                    <div>
                        <label for="EmployeePosition">Employee Position</label>
                        <input type="text" id="EmployeePosition" name="EmployeePosition" class="form-input w-full" />
                    </div>
                    <div class="col-span-2">
                        <label for="EmployeeName">Employee Name</label>
                        <input type="text" id="employee_EmployeeName" name="EmployeeName" class="form-input w-full" />
                    </div>
                </div>
            </div> -->

            <!-- Buttons -->
            <!-- <div class="flex justify-end gap-2 mt-6">
                <button type="button" id="cancelBtn" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
            </div> -->
        </form>
    </div>
</div>
