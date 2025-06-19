<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Employee List') }}
        </h2>
        <p class="text-sm text-gray-600 mt-1">View and manage all employee records</p>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6">
            {{-- Header and Action Buttons --}}
            <div class="mb-4 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Employee Data Table</h3>
                    <p class="text-sm text-gray-500">Below is a list of all active employees.</p>
                </div>
                <div class="flex space-x-2">
                    <button id="openImportModalBtn"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md transition duration-200">
                        📁 Import Excel
                    </button>
                    <button id="openModalBtn"
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-md transition duration-200">
                        + Add Employee
                    </button>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table id="employeeTable" class="w-full text-sm text-left table-auto stripe hover">
                    <thead class="bg-gray-100 text-xs uppercase text-gray-700">
                        <tr>
                            <th class="px-4 py-3">Employee ID</th>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Status Vacant</th>
                            <th class="px-4 py-3">Join Date</th>
                            <th class="px-4 py-3">Last Update</th>
                            <th class="px-4 py-3">Update By</th>
                            <th class="px-4 py-3 text-center">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    {{-- Modals --}}
    @include('employee.modal-add')
    @include('employee.modal-edit')
    @include('employee.modal-import')

    @push('scripts')
    <script>
        $(document).ready(function () {
            // Initialize DataTable
            const table = $('#employeeTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('employee.data') }}',
                columns: [
                    { data: 'EmployeeID', name: 'EmployeeID' },
                    { data: 'EmployeeName', name: 'EmployeeName' },
                    { data: 'StatusVacant', name: 'StatusVacant' },
                    {
                        data: 'JoinDate',
                        name: 'JoinDate',
                        render: function (data) {
                            return data ? data.substring(0, 10) : '';
                        }
                    },
                    {
                        data: 'LastUpdate',
                        name: 'LastUpdate',
                        render: function (data) {
                            return data ? data.substring(0, 10) : '';
                        }
                    },
                  
                    { data: 'UserID', name: 'UserID' },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: "text-center",
                        render: function (data, type, row) {
                            return `
                                <button class="edit-btn px-3 py-1 rounded bg-blue-600 text-white hover:bg-blue-700 transition duration-200"
                                    data-id="${row.RefEmpID}" 
                                    data-url="/employee/${row.RefEmpID}/edit">
                                    Edit
                                </button>`;
                        }
                    },
                ],
                order: [[3, 'desc']],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search employees...",
                    lengthMenu: "Show _MENU_ entries",
                    zeroRecords: "No matching employees found",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries available",
                    infoFiltered: "(filtered from _MAX_ total entries)"
                }
            });

            // Modal Add
            $('#openModalBtn').click(() => $('#employeeModal').removeClass('hidden'));
            $('#closeModalBtn').click(() => $('#employeeModal').addClass('hidden'));
            $('#employeeModal').click(e => { if (e.target === e.currentTarget) $('#employeeModal').addClass('hidden'); });

            // Modal Edit
            $('#employeeTable').on('click', '.edit-btn', function (e) {
                e.preventDefault();
                const url = $(this).data('url');

                $.get(url, function (data) {
                    $('#editEmpId').val(data.RefEmpID);
                    $('#editEmployeeID').val(data.EmployeeID);
                    $('#editEmployeeName').val(data.EmployeeName);
                    $('#editEmployeeStatus').val(data.EmployeeStatus);
                    $('#editJoinDate').val(data.JoinDate ? data.JoinDate.replace(' ', 'T') : '');
                    $('#editEndDate').val(data.EndDate ? data.EndDate.replace(' ', 'T') : '');
                    $('#editStatusVacant').val(data.StatusVacant);
                    $('#editEmailID').val(data.EmailID);
                    $('#editUserID').val(data.UserID);
                    $('#editLastUpdate').val(data.LastUpdate ? data.LastUpdate.replace(' ', 'T') : '');
                    $('#editPhoneNumber').val(data.PhoneNumber);

                    $('#editEmployeeForm').attr('action', `/employee/update/${data.RefEmpID}`);
                    $('#editEmployeeModal').removeClass('hidden');
                }).fail(function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: 'Cannot fetch employee data.'
                    });
                });
            });

            $('#closeEditModalBtn').click(() => $('#editEmployeeModal').addClass('hidden'));
            $('#editEmployeeModal').click(e => { if (e.target === e.currentTarget) $('#editEmployeeModal').addClass('hidden'); });

            // Save Edit with SweetAlert confirmation
            $('#saveEditBtn').click(function () {
                const id = $('#editEmpId').val();
                const url = '/employee/update/' + id;

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
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: $('#editEmployeeForm').serialize(),
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Updated!',
                                    text: response.message || 'Data berhasil diupdate',
                                }).then(() => {
                                    $('#editEmployeeModal').addClass('hidden');
                                    location.reload();
                                });
                            },
                            error: function (xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Update Failed',
                                    text: xhr.responseJSON?.message || 'Terjadi kesalahan saat update.'
                                });
                            }
                        });
                    }
                });
            });

            // Import Modal
            $('#openImportModalBtn').click(() => $('#importEmployeeModal').removeClass('hidden'));
            $('#closeImportModalBtn').click(() => $('#importEmployeeModal').addClass('hidden'));
            $('#importEmployeeModal').click(e => { if (e.target === e.currentTarget) $('#importEmployeeModal').addClass('hidden'); });
        });
    </script>
    @endpush
</x-app-layout>
