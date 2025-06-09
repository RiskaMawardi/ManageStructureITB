<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Employee List') }}
        </h2>
        <p class="text-sm text-gray-600 mt-1">View and manage all employee records</p>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="mb-4 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-medium text-gray-800">Employee Data Table</h3>
                    <p class="text-sm text-gray-500">Below is a list of all active employees.</p>
                </div>
                <!-- Tombol Add Employee -->
                <button id="openModalBtn" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition">
                    Add Employee
                </button>
            </div>

            <div class="overflow-x-auto">
                <table id="employeeTable" class="stripe hover w-full text-sm text-left">
                    <thead class="bg-gray-100 text-xs uppercase text-gray-700">
                        <tr>
                            <th class="px-4 py-3">Employee ID</th>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Status Vacant</th>
                            <th class="px-4 py-3">Join Date</th>
                            <th class="px-4 py-3 text-center">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    {{-- Panggil modal terpisah --}}
    @include('employee.modal-add')
    @include('employee.modal-edit')

    @push('scripts')
    <script>
        $(document).ready(function () {
            var table = $('#employeeTable').DataTable({
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
                        render: function (data, type, row) {
                            if (!data) return '';
                            return data.substring(0, 10); // Format YYYY-MM-DD (no time)
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: "text-center",
                        render: function (data, type, row) {
                            return `<button 
                                        class="edit-btn inline-block px-3 py-1 rounded bg-blue-600 text-white hover:bg-blue-700 transition" 
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
                    infoFiltered: "(filtered from _MAX_ total entries)",
                }
            });

            // Open modal
            $('#openModalBtn').on('click', function () {
                $('#employeeModal').removeClass('hidden');
            });

            // Close modal
            $('#closeModalBtn').on('click', function () {
                $('#employeeModal').addClass('hidden');
            });

            // Close modal on outside click
            $('#employeeModal').on('click', function (e) {
                if (e.target === this) {
                    $(this).addClass('hidden');
                }
            });
        });

        // Handle edit button click
        $('#employeeTable').on('click', '.edit-btn', function (e) {
            e.preventDefault();

            const url = $(this).data('url');

            $.get(url, function (data) {
                // Set values in modal
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

                // Open edit modal
                $('#editEmployeeModal').removeClass('hidden');

                // Set form action
                $('#editEmployeeForm').attr('action', `/employee/update/${data.RefEmpID}`);
            }).fail(function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Cannot fetch employee data.',
                });
            });
        });

        // Close edit modal
        $('#closeEditModalBtn').on('click', function () {
            $('#editEmployeeModal').addClass('hidden');
        });

        $('#editEmployeeModal').on('click', function (e) {
            if (e.target === this) {
                $(this).addClass('hidden');
            }
        });
    </script>
    @endpush


</x-app-layout>
