<div id="editEmployeeModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white w-full max-w-3xl p-6 rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Edit Employee</h2>

        <form id="editEmployeeForm" method="POST" action="#">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="id" id="editEmpId">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="editEmployeeID">Employee ID</label>
                    <input type="text" name="EmployeeID" id="editEmployeeID" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label for="editEmployeeName">Name</label>
                    <input type="text" name="EmployeeName" id="editEmployeeName" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label for="editEmployeeStatus">Status</label>
                    <input type="text" name="EmployeeStatus" id="editEmployeeStatus" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label for="editJoinDate">Join Date</label>
                    <input type="datetime-local" name="JoinDate" id="editJoinDate" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label for="editEndDate">End Date</label>
                    <input type="datetime-local" name="EndDate" id="editEndDate" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label for="editStatusVacant">Status Vacant</label>
                    <input type="text" name="StatusVacant" id="editStatusVacant" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label for="editEmailID">Email</label>
                    <input type="email" name="EmailID" id="editEmailID" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label for="editUserID">User ID</label>
                    <input type="text" name="UserID" id="editUserID" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label for="editLastUpdate">Last Update</label>
                    <input type="datetime-local" name="LastUpdate" id="editLastUpdate" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label for="editPhoneNumber">Phone Number</label>
                    <input type="text" name="PhoneNumber" id="editPhoneNumber" class="w-full border rounded px-3 py-2">
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="button" id="closeEditModalBtn" class="px-4 py-2 bg-gray-600 text-white rounded mr-2">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('#editEmployeeForm').submit(function(e) {
        e.preventDefault();

        let id = $('#editEmpId').val();
        if (!id) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Employee ID belum di-set!',
            });
            return;
        }

        // Konfirmasi sebelum mengirim data
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to save the changes?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, save it!',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#aaa'
        }).then((result) => {
            if (result.isConfirmed) {
                let url = '/employee/update/' + id;

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: response.message || 'Data berhasil diupdate',
                        }).then(() => {
                            location.reload(); // reload halaman setelah OK diklik
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessages = '';
                            $.each(errors, function(key, value) {
                                errorMessages += value[0] + '<br>';
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                html: errorMessages,
                            });
                        } else if (xhr.status === 404) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Not Found',
                                text: 'Data tidak ditemukan (404).',
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan saat mengupdate data.',
                            });
                        }
                    }
                });
            }
        });
    });

    $('#closeEditModalBtn').click(function() {
        $('#editEmployeeModal').addClass('hidden');
    });
});
</script>

