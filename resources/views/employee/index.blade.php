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
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- DataTables -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        {{-- SweetAlert2 --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if($errors->any())
                let errorMessages = {!! json_encode($errors->all()) !!};
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: errorMessages.join('<br>'),
                });
            @endif
        </script>


        <style>
            table.dataTable tbody tr:hover {
                background-color: #f9fafb;
            }
            .dataTables_wrapper .dataTables_paginate .paginate_button {
                padding: 0.3rem 0.6rem;
                border-radius: 0.375rem;
                border: 1px solid transparent;
                margin-left: 0.25rem;
                font-size: 0.875rem;
                color: #4b5563;
                background: #f3f4f6;
            }
            .dataTables_wrapper .dataTables_paginate .paginate_button.current {
                background: #3b82f6;
                color: white !important;
            }
            .dataTables_wrapper .dataTables_filter {
                margin-bottom: 1rem;
            }
            .dataTables_wrapper .dataTables_paginate {
                margin-top: 1rem;
            }
            #employeeTable {
                margin-top: 0.25rem;
            }
        </style>

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
                        { data: 'JoinDate', name: 'JoinDate' },
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
                $('#employeeModal').on('click', function(e) {
                    if (e.target === this) {
                        $(this).addClass('hidden');
                    }
                });
            });
        </script>
        <script>
             // Tangkap klik tombol edit
            $('#employeeTable').on('click', '.edit-btn', function (e) {
                e.preventDefault();

                const url = $(this).data('url');

                $.get(url, function (data) {
                    // Isi nilai input di modal
                    $('#editEmpId').val(data.RefEmpID); // id untuk keperluan form PUT
                    $('#editEmployeeID').val(data.EmployeeID);
                    $('#editEmployeeName').val(data.EmployeeName);
                    $('#editEmployeeStatus').val(data.EmployeeStatus);
                    $('#editJoinDate').val(data.JoinDate);
                    $('#editEndDate').val(data.EndDate);
                    $('#editStatusVacant').val(data.StatusVacant);
                    $('#editEmailID').val(data.EmailID);
                    $('#editUserID').val(data.UserID);
                    $('#editLastUpdate').val(data.LastUpdate ? data.LastUpdate.replace(' ', 'T') : '');
                    $('#editPhoneNumber').val(data.PhoneNumber);

                    // Buka modal
                    $('#editEmployeeModal').removeClass('hidden');

                    // Update form action
                    $('#editEmployeeForm').attr('action', `/employee/update/${data.RefEmpID}`);
                }).fail(function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: 'Cannot fetch employee data.',
                    });
                });
            });

            // Tutup modal
            $('#closeEditModalBtn').on('click', function () {
                $('#editEmployeeModal').addClass('hidden');
            });

            // Tutup modal jika klik di luar kotak
            $('#editEmployeeModal').on('click', function (e) {
                if (e.target === this) {
                    $(this).addClass('hidden');
                }
            });

        </script>
    @endpush

</x-app-layout>
