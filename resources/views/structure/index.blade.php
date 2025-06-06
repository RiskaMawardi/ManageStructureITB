<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Structure') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <div class="mb-4">
                <label for="rayonID" class="block text-sm font-medium text-gray-700">Pilih RayonID</label>
                
                <div class="flex gap-4">
                    {{-- Select Rayon --}}
                    <select id="rayonID" name="RayonID" class="mt-1 block w-1/3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">-- Pilih RayonID --</option>
                        @foreach($rayonIDs as $rayonID)
                            <option value="{{ $rayonID }}">{{ $rayonID }}</option>
                        @endforeach
                    </select>

                    {{-- Button Tampilkan --}}
                    <button id="loadDataBtn" class="mt-1 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                        Tampilkan
                    </button>

                    {{-- Button Generate PDF --}}
                    <form id="pdfForm" method="GET" action="{{ route('rayon.generatePdf') }}">
                        <input type="hidden" name="RayonID" id="rayonIDForPdf" />
                        <button type="submit" class="mt-1 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                            Generate PDF
                        </button>
                    </form>
                </div>
            </div>


                {{-- Tabel --}}
                <table id="positionsTable" class="min-w-full divide-y divide-gray-200 border">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date Structure</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date Map</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modals --}}
    @include('structure.modal-detail')
    @include('structure.modal-manage')

    @push('scripts')
        {{-- Libraries --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        {{-- Styling Datatable --}}
        <style>
            table.dataTable tbody tr:hover { background-color: #f9fafb; }
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

        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    placeholder: "-- Pilih Employee ID --",
                    allowClear: true,
                    width: '100%' 
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const rayonSelect = document.getElementById('rayonID');
                const hiddenRayonInput = document.getElementById('rayonIDForPdf');
                const generatePdfForm = document.querySelector('form[action*="generatePdf"]');
                const generatePdfButton = generatePdfForm.querySelector('button[type="submit"]');

                // Atur nilai awal untuk hidden input dan tombol PDF
                const selected = rayonSelect.value;
                hiddenRayonInput.value = selected;
                togglePdfButton(selected);

                // Event saat pilihan RayonID berubah
                rayonSelect.addEventListener('change', function () {
                    const selectedValue = this.value;
                    hiddenRayonInput.value = selectedValue;
                    togglePdfButton(selectedValue);
                });

                function togglePdfButton(selectedValue) {
                    if (selectedValue) {
                        generatePdfButton.disabled = false;
                        generatePdfButton.classList.remove('opacity-50', 'cursor-not-allowed');
                    } else {
                        generatePdfButton.disabled = true;
                        generatePdfButton.classList.add('opacity-50', 'cursor-not-allowed');
                    }
                }
            });
        </script>

        <script>
            document.querySelector('#pdfForm').addEventListener('submit', function (e) {
                const rayon = document.getElementById('rayonID').value;
                if (!rayon) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'RayonID belum dipilih',
                        text: 'Silakan pilih RayonID sebelum generate PDF.',
                    });
                } else {
                    this.setAttribute('target', '_blank');
                }
            });

        </script>



        <script>
            document.getElementById('rayonID').addEventListener('change', function () {
                const selectedRayon = this.value;
                document.getElementById('rayonIDForPdf').value = selectedRayon;
            });

            // Trigger set value saat halaman load jika default value sudah ada
            document.addEventListener('DOMContentLoaded', function () {
                const selected = document.getElementById('rayonID').value;
                document.getElementById('rayonIDForPdf').value = selected;
            });
        </script>


      
        {{-- Main Script --}}
        <script>
            $(document).ready(function () {

                let employeeIndex = 0;
                let globalEmpIDs = [];

                // Format datetime-local
                function formatDateTimeLocal(datetime) {
                    if (!datetime) return '';
                    const dt = new Date(datetime);
                    return dt.toISOString().slice(0, 16); // YYYY-MM-DDTHH:MM
                }

                // Datatable Init
                var table = $('#positionsTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route("structure.fetchData") }}',
                        type: 'POST',
                        data: function (d) {
                            d.RayonID = $('#rayonID').val();
                            d._token = '{{ csrf_token() }}';
                        }
                    },
                    columns: [
                        {
                            data: 'PositionID',
                            name: 'PositionID',
                            
                        },
                        { data: 'StartDatePosStructure', name: 'StartDatePosStructure' },
                        { data: 'StartDatePosMap', name: 'StartDatePosMap' },
                        {
                            data: null,
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            className: 'text-center',
                            render: function (data, type, row) {
                                return `
                                    <button class="edit-btn text-yellow-500 hover:text-yellow-700" data-id="${row.PositionID}" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                `;
                            }
                        }
                    ],
                    deferLoading: 0,
                    order: [[0, 'desc']],
                    responsive: true,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Search...",
                        lengthMenu: "Show _MENU_ entries",
                        zeroRecords: "No matching employees found",
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        infoEmpty: "No entries available",
                        infoFiltered: "(filtered from _MAX_ total entries)",
                    }
                });

                // Load data by RayonID
                $('#loadDataBtn').click(function () {
                    const selectedRayon = $('#rayonID').val();
                    if (!selectedRayon) {
                        alert('Silakan pilih RayonID terlebih dahulu.');
                        return;
                    }
                    table.ajax.reload();
                });

                // Modal Detail Functions
                function openModal() {
                    $('#detailModal').removeClass('hidden');
                }
                function closeModal() {
                    $('#detailModal').addClass('hidden');
                }

                 // Show Detail Modal
                $(document).on('click', '.view-detail', function (e) {
                    e.preventDefault();
                    const id = $(this).data('id');

                    $.ajax({
                        url: `/structure/${id}`,
                        method: 'GET',
                        success: function (data) {
                            // Fill fields
                            $('#structureId').val(data.ID || '');
                            $('#ID').val(data.ID || '');
                            $('#PositionID').val(data.PositionID || '');
                            $('#EmpID').val(data.EmpID || '');
                            $('#EmployeePosition').val(data.EmployeePosition || '');
                            $('#Status_Default').val(data.Status_Default || '');
                            $('#Acting').val(data.Acting || '');
                            $('#Active').val(data.Active || '');
                            $('#IsCoordinator').val(data.IsCoordinator || '');
                            $('#IsVacant').val(data.IsVacant || '');
                            $('#LastUpdate').val(data.LastUpdate || '');
                            $('#UserID').val(data.UserID || '');
                            $('#StartDate').val(formatDateTimeLocal(data.StartDate));
                            $('#EndDate').val(formatDateTimeLocal(data.EndDate));

                            // Fill nested structure
                            const ps = data.position_structure || {};
                            for (const key in ps) {
                                $(`#position_structure_${key}`).val(ps[key] || '');
                            }
                            $('#position_structure_StartDate').val(formatDateTimeLocal(ps.StartDate));
                            $('#position_structure_EndDate').val(formatDateTimeLocal(ps.EndDate));

                            openModal();
                        },
                        error: function () {
                            alert('Gagal mengambil data detail.');
                        }
                    });
                });

                $('#closeModalBtn, #cancelBtn').click(function () {
                    closeModal();
                });

                // Submit update detail form
                $('#updatePositionStructureForm').on('submit', function (e) {
                    e.preventDefault();
                    const id = $('#structureId').val();

                    $.ajax({
                        url: `/structure/${id}`,
                        method: 'PUT',
                        data: $(this).serialize(),
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function () {
                            alert('Data berhasil diperbarui!');
                            closeModal();
                            table.ajax.reload();
                        },
                        error: function () {
                            alert('Gagal menyimpan perubahan.');
                        }
                    });
                });


                function openManageModal() {
                    $('#manageModal').removeClass('hidden');
                }

                function closeManageModal() {
                    $('#manageModal').addClass('hidden');
                }

                // Template generator for employee form block
                function generateEmployeeBlock(data = {}, index = 0) {
                    const structure = data.position_structure || {};

                    return `
                        <div class="employee-block border rounded-lg p-4 mb-6 bg-white shadow-sm">
                            <h3 class="text-lg font-semibold text-indigo-700 mb-4">Employee #${index + 1}</h3>
                            
                            <div class="grid grid-cols-2 gap-4 text-sm text-gray-800">
                                <div class="col-span-2 border-b pb-2">
                                    <p class="text-gray-500">Position ID</p>
                                    <p class="font-medium text-gray-900">${data.PositionID || '-'}</p>
                                </div>
                                
                                <div class="col-span-2 border-b pb-2">
                                    <p class="text-gray-500">Employee ID</p>
                                    <p class="font-medium text-gray-900">${data.EmpID || '-'}</p>
                                </div>

                                <div class="border-b pb-2">
                                    <p class="text-gray-500">Employee Position</p>
                                    <p class="font-medium text-gray-900">${data.EmployeePosition || '-'}</p>
                                </div>

                                <div class="border-b pb-2">
                                    <p class="text-gray-500">Employee Name</p>
                                    <p class="font-medium text-gray-900">${data.employee?.EmployeeName || '-'}</p>
                                </div>

                                <div class="border-b pb-2">
                                    <p class="text-gray-500">Start Date Map</p>
                                    <p class="font-medium text-gray-900">${formatDateTimeLocal(data.StartDate) || '-'}</p>
                                </div>

                                <div class="border-b pb-2">
                                    <p class="text-gray-500">End Date Map</p>
                                    <p class="font-medium text-gray-900">${formatDateTimeLocal(data.EndDate) || '-'}</p>
                                </div>
                            </div>

                            <div class="mt-6 bg-blue-50 border-l-4 border-blue-300 p-4 rounded-md">
                                <h4 class="text-md font-semibold text-blue-800 mb-2">Position Structure Info</h4>
                                <div class="grid grid-cols-2 gap-4 text-sm text-gray-800">
                                    <div>
                                        <p class="text-gray-500">Area</p>
                                        <p class="font-medium">${structure.AreaID || '-'}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Line</p>
                                        <p class="font-medium">${structure.LineID || '-'}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Rayon</p>
                                        <p class="font-medium">${structure.RayonID || '-'}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Company</p>
                                        <p class="font-medium">${structure.CompanyID || '-'}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">AM</p>
                                        <p class="font-medium">${structure.AmPos || '-'}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">RM</p>
                                        <p class="font-medium">${structure.RmPos || '-'}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                }   


                updateEmployeeBtn.addEventListener('click', () => {
                const block = document.querySelector('.employee-block');
                const index = 0; // Ganti sesuai index baris

                Swal.fire({
                    title: 'Update Employee',
                    html: `
                        <label for="selectEmployeeID" class="block text-sm mb-1">Select Employee ID</label>
                        <select id="selectEmployeeID" name="EmployeeID" class="select2 mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">-- Select Employee ID --</option>
                            ${globalEmpIDs.map(empID => `<option value="${empID}">${empID}</option>`).join('')}
                        </select>

                        <label for="startDate" class="block text-sm mt-4 mb-1">Start Date</label>
                        <input type="datetime-local" id="startDate" class="swal2-input" value="${getDefaultDateTime()}">

                        <label for="reason" class="block text-sm mt-4 mb-1">Reason</label>
                        <select id="reason" class="swal2-select w-full mt-1 border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Select Reason --</option>
                            <option value="Resign">Resign</option>
                            <option value="Mutasi">Mutasi</option>
                        </select>
                    `,
                    focusConfirm: false,
                    showCancelButton: true,
                    confirmButtonText: 'Update',
                    cancelButtonText: 'Cancel',
                    didOpen: () => {
                        $('#selectEmployeeID').select2({
                            dropdownParent: $('.swal2-popup'),
                            width: '100%'
                        });
                    },
                    preConfirm: () => {
                        const empID = document.getElementById('selectEmployeeID').value;
                        const startDate = document.getElementById('startDate').value;
                        const reason = document.getElementById('reason').value;

                        if (!empID) {
                            Swal.showValidationMessage('Please select an Employee ID');
                            return false;
                        }
                        if (!startDate) {
                            Swal.showValidationMessage('Start Date cannot be empty');
                            return false;
                        }
                        if (!reason) {
                            Swal.showValidationMessage('Please select a reason');
                            return false;
                        }

                        return { empID, startDate, reason };
                    }
                }).then(result => {
                    if (result.isConfirmed) {
                        const { empID, startDate, reason } = result.value;

                        $('.employee-block').each(function () {
                                const block = $(this);
                                const indexMatch = block.find('input[name^="data"]').attr('name').match(/\d+/);
                                if (!indexMatch) return;

                                const index = indexMatch[0];

                                const positionID = block.find(`input[name="data[${index}][PositionID]"]`).val();
                                const empID = block.find(`select[name="data[${index}][EmpID]"]`).val();
                                const employeePosition = block.find(`input[name="data[${index}][EmployeePosition]"]`).val();
                                const kodeRayon = extractKodeRayon(positionID);
                                const employeeName = `${employeePosition} X ${kodeRayon}`;
                                const oldID = block.find(`input[name="data[${index}][ID]"]`).val();

                                positionData.push({
                                    oldID: oldID,
                                    PositionID: positionID,
                                    EmpID: empID,
                                    EmployeePosition: employeePosition,
                                    EmployeeName: employeeName
                                });
                            });

                        $.ajax({
                            url: '/position-map/update-emp',
                            type: 'POST',
                            contentType: 'application/json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: JSON.stringify({
                                oldID,
                                startDate,
                                reason,
                                empID,
                                positionID
                            }),
                            success: function () {
                                Swal.fire('Berhasil', 'Data telah di-set ke Vacant.', 'success')
                                    .then(() => {
                                        closeManageModal();
                                        location.reload();
                                    });
                            },
                            error: function () {
                                Swal.fire('Gagal', 'Terjadi kesalahan saat menyimpan data.', 'error');
                            }
                        });
                    }
                });
            });

                // Handle open modal with data
                $(document).on('click', '.edit-btn', function (e) {
                    e.preventDefault();
                    const id = $(this).data('id');

                    $.ajax({
                        url: `/position-id/${id}`,
                        method: 'GET',
                        success: function (response) {
                            const dataItems = response.data;
                            globalEmpIDs = response.empIDs;
                            employeeIndex = 0;

                            let html = '';
                             globalEmpIDs = response.empIDs;
                            dataItems.forEach(function(data) {
                                html += generateEmployeeBlock(data, employeeIndex, globalEmpIDs);
                                employeeIndex++;
                            });

                            $('#employee-section').html(html);

                            $('.select2').select2({
                                placeholder: "-- Pilih Employee ID --",
                                allowClear: true,
                                width: '100%'
                            });

                            openManageModal();
                        },
                        error: function () {
                            alert('Gagal mengambil data detail.');
                        }
                    });
                });

                // Close modal
                $('#closeManageModalBtn, #cancelManageBtn').click(function () {
                    closeManageModal();
                });

                

                // Hapus Employee Block
                $(document).on('click', '.delete-btn', function () {
                    $(this).closest('.employee-block').remove();
                });

                $('#setVacant').on('click', function () {
                    Swal.fire({
                        title: 'Set to Vacant',
                        html: `
                            <label for="reason" class="block text-sm mb-1">Reason</label>
                            <select id="reason" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                <option value="">-- Select Reason --</option>
                                <option value="Resign">Resign</option>
                                <option value="Mutasi">Mutasi</option>
                            </select>

                            <label for="vacantDate" class="block text-sm mt-4 mb-1">Start Date</label>
                            <input type="datetime-local" id="vacantDate" class="swal2-input" value="${getDefaultDateTime()}">
                        `,
                        focusConfirm: false,
                        showCancelButton: true,
                        confirmButtonText: 'Set Vacant',
                        cancelButtonText: 'Batal',
                        preConfirm: () => {
                            const dateInput = document.getElementById('vacantDate').value;
                            const reason = document.getElementById('reason').value;

                            if (!dateInput) {
                                Swal.showValidationMessage('Tanggal tidak boleh kosong');
                                return false;
                            }
                            if (!reason) {
                                Swal.showValidationMessage('Reason tidak boleh kosong');
                                return false;
                            }

                            return { dateInput, reason };
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const { dateInput, reason } = result.value;
                            const positionData = [];

                            $('.employee-block').each(function () {
                                const block = $(this);
                                const indexMatch = block.find('input[name^="data"]').attr('name').match(/\d+/);
                                if (!indexMatch) return;

                                const index = indexMatch[0];

                                const positionID = block.find(`input[name="data[${index}][PositionID]"]`).val();
                                const empID = block.find(`select[name="data[${index}][EmpID]"]`).val();
                                const employeePosition = block.find(`input[name="data[${index}][EmployeePosition]"]`).val();
                                const kodeRayon = extractKodeRayon(positionID);
                                const employeeName = `${employeePosition} X ${kodeRayon}`;
                                const oldID = block.find(`input[name="data[${index}][ID]"]`).val();

                                positionData.push({
                                    oldID: oldID,
                                    PositionID: positionID,
                                    EmpID: empID,
                                    EmployeePosition: employeePosition,
                                    EmployeeName: employeeName
                                });
                            });

                            if (positionData.length === 0) {
                                Swal.fire('Gagal', 'Tidak ada data posisi yang diproses.', 'error');
                                return;
                            }

                            $.ajax({
                                url: '/position-map/set-vacant',
                                type: 'POST',
                                contentType: 'application/json',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: JSON.stringify({
                                    vacantStartDate: dateInput,
                                    positions: positionData,
                                    reason: reason
                                }),
                                success: function () {
                                    Swal.fire('Berhasil', 'Data telah di-set ke Vacant.', 'success')
                                        .then(() => {
                                            closeManageModal();
                                            location.reload();
                                        });
                                },
                                error: function () {
                                    Swal.fire('Gagal', 'Terjadi kesalahan saat menyimpan data.', 'error');
                                }
                            });
                        }
                    });
                });


                // Helper functions
                function getDefaultDateTime() {
                    const now = new Date();
                    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                    return now.toISOString().slice(0, 16);
                }

                function extractKodeRayon(positionID) {
                    const match = positionID.match(/D\d{4,5}$/);
                    return match ? match[0] : 'DXXXX';
                }

                
            });
        </script>
    @endpush
</x-app-layout>
