<!-- Modal Upload Excel -->
<div id="excelUploadModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg w-[400px] p-6 relative">
        <h2 class="text-lg font-semibold mb-4">Upload Excel</h2>

        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="excel_file" accept=".xlsx,.xls"
                class="block w-full text-sm text-gray-500 mb-4 border border-gray-300 rounded p-2" required>

            <div class="flex justify-end gap-2">
                <button type="button" id="closeExcelModalBtn"
                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Batal</button>
                <button type="submit"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Upload</button>
            </div>
        </form>
    </div>
</div>
