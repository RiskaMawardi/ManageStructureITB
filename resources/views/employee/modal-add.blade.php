<!-- Modal Background -->
<div id="employeeModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <!-- Modal Content -->
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
        <h2 class="text-xl font-semibold mb-4">Add New Employee</h2>
        <form id="employeeForm" method="POST" action="{{route('employee.store')}}">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-1">Name <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="email" id="email" name="email" placeholder="Optional"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-gray-700 font-medium mb-1">No HP</label>
                <input type="tel" id="phone" name="phone" placeholder="Optional"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div class="mb-4">
                <label for="status_vacant" class="block text-gray-700 font-medium mb-1">Status Vacant <span class="text-red-500">*</span></label>
                <select id="status_vacant" name="status_vacant"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="">Select status</option>
                    <option value="Y">Vacant</option>
                    <option value="N">Non Vacant</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="join_date" class="block text-gray-700 font-medium mb-1">Join Date <span class="text-red-500">*</span></label>
                <input type="date" id="join_date" name="join_date"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" id="closeModalBtn" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Cancel</button>
                <button type="submit" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('employeeForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const form = event.target;
    const name = form.name.value.trim();
    const statusVacant = form.status_vacant.value;
    const joinDate = form.join_date.value;

    let errors = [];
    if (!name) errors.push('Name is required');
    if (!statusVacant) errors.push('Status Vacant is required');
    if (!joinDate) errors.push('Join Date is required');

    if (errors.length > 0) {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: errors.join('<br>'),
            confirmButtonColor: '#d33'
        });
        return;
    }

    // Konfirmasi sebelum submit
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to save this employee data?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#aaa',
        confirmButtonText: 'Yes, Save',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});

// Close modal button functionality
document.getElementById('closeModalBtn').addEventListener('click', function() {
    document.getElementById('employeeModal').classList.add('hidden');
});
</script>

