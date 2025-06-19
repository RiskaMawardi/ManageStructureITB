<div id="importEmployeeModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
        <h2 class="text-lg font-semibold mb-4">Import Employees from Excel</h2>
        <form action="{{ route('employee.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" accept=".xlsx, .xls" required class="mb-4 w-full border p-2 rounded" />
            <div class="flex justify-end">
                <button type="button" id="closeImportModalBtn" class="mr-2 px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Import</button>
            </div>                     
        </form>
    </div>
</div>
