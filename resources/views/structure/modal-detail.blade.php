<div id="detailModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-4xl p-6 relative max-h-[90vh] overflow-y-auto">

    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold">Detail Struktur Posisi</h2>
      <button id="closeModalBtn" class="text-gray-600 hover:text-red-500 text-3xl font-bold">&times;</button>
    </div>

    <form id="updateForm">
      @csrf
      @method('PUT')
      <input type="hidden" id="structureId" name="ID" />

      <!-- SECTION 1: Position Map -->
      <section class="mb-6">
        <h3 class="text-xl font-semibold border-b pb-2 mb-4">Position Map</h3>
        <div class="grid grid-cols-2 gap-4 text-sm">

          <div>
            <label class="font-medium">Position ID</label>
            <input type="text" id="PositionID" name="PositionID" class="w-full border rounded px-2 py-1" readonly>
          </div>

          <div>
            <label class="font-medium">EmpID</label>
            <input type="text" id="EmpID" name="EmpID" class="w-full border rounded px-2 py-1">
          </div>

          <div>
            <label class="font-medium">Employee Position</label>
            <input type="text" id="EmployeePosition" name="EmployeePosition" class="w-full border rounded px-2 py-1">
          </div>

          <div>
            <label class="font-medium">Status Default</label>
            <input type="text" id="Status_Default" name="Status_Default" class="w-full border rounded px-2 py-1" readonly>
          </div>

          <div>
            <label class="font-medium">Acting</label>
            <input type="text" id="Acting" name="Acting" class="w-full border rounded px-2 py-1" readonly>
          </div>

          <div>
            <label class="font-medium">Active</label>
            <input type="text" id="Active" name="Active" class="w-full border rounded px-2 py-1" readonly>
          </div>

          <div>
            <label class="font-medium">Is Coordinator</label>
            <input type="text" id="IsCoordinator" name="IsCoordinator" class="w-full border rounded px-2 py-1" readonly>
          </div>

          <div>
            <label class="font-medium">Is Vacant</label>
            <input type="text" id="IsVacant" name="IsVacant" class="w-full border rounded px-2 py-1" readonly>
          </div>

          <div>
            <label class="font-medium">Last Update</label>
            <input type="text" id="LastUpdate" name="LastUpdate" class="w-full border rounded px-2 py-1" readonly>
          </div>

          <div>
            <label class="font-medium">Start Date</label>
            <input type="datetime-local" id="StartDate" name="StartDate" class="w-full border rounded px-2 py-1">
          </div>

          <div>
            <label class="font-medium">End Date</label>
            <input type="datetime-local" id="EndDate" name="EndDate" class="w-full border rounded px-2 py-1">
          </div>

          <div>
            <label class="font-medium">User ID</label>
            <input type="text" id="UserID" name="UserID" class="w-full border rounded px-2 py-1" readonly>
          </div>

        </div>
      </section>

      <!-- SECTION 2: Employee -->
      <section class="mb-6">
        <h3 class="text-xl font-semibold border-b pb-2 mb-4">Employee</h3>
        <div class="grid grid-cols-2 gap-4 text-sm">

          <div>
            <label class="font-medium">RefEmpID</label>
            <input type="text" id="employee_RefEmpID" class="w-full border rounded px-2 py-1" readonly>
          </div>

          <div>
            <label class="font-medium">EmployeeID</label>
            <input type="text" id="employee_EmployeeID" class="w-full border rounded px-2 py-1" readonly>
          </div>

          <div class="col-span-2">
            <label class="font-medium">EmployeeName</label>
            <input type="text" id="employee_EmployeeName" class="w-full border rounded px-2 py-1" readonly>
          </div>

        </div>
      </section>

      <!-- SECTION 3: Position Structure -->
      <section class="mb-6">
        <h3 class="text-xl font-semibold border-b pb-2 mb-4">Position Structure</h3>
        <div class="grid grid-cols-2 gap-4 text-sm">

          <div>
            <label class="font-medium">Position Record</label>
            <input type="text" id="position_structure_PositionRecord" class="w-full border rounded px-2 py-1" readonly>
          </div>

          <div>
            <label class="font-medium">Position ID</label>
            <input type="text" id="position_structure_PositionID" class="w-full border rounded px-2 py-1" readonly>
          </div>

          <div>
            <label class="font-medium">Employee Position</label>
            <input type="text" id="position_structure_EmployeePosition" class="w-full border rounded px-2 py-1" readonly>
          </div>

          <div>
            <label class="font-medium">Company ID</label>
            <input type="text" id="position_structure_CompanyID" class="w-full border rounded px-2 py-1" readonly>
          </div>

          <div>
            <label class="font-medium">Area ID</label>
            <input type="text" id="position_structure_AreaID" class="w-full border rounded px-2 py-1" readonly>
          </div>

        </div>
      </section>

      <div class="flex justify-end gap-2">
        <button type="button" id="cancelBtn" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Batal</button>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
      </div>

    </form>
  </div>
</div>
