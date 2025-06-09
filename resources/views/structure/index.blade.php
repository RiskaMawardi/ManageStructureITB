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
                        <select id="rayonID" name="RayonID"
                            class="mt-1 block w-1/3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">-- Pilih RayonID --</option>
                            @foreach($rayonIDs as $rayonID)
                            <option value="{{ $rayonID }}">{{ $rayonID }}</option>
                            @endforeach
                        </select>

                        {{-- Button Tampilkan --}}
                        <button id="loadDataBtn"
                            class="mt-1 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                            Tampilkan
                        </button>

                        {{-- Button Generate PDF --}}
                        <form id="pdfForm" method="GET" action="{{ route('rayon.generatePdf') }}">
                            <input type="hidden" name="RayonID" id="rayonIDForPdf" />
                            <button type="submit"
                                class="mt-1 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                                Generate PDF
                            </button>
                        </form>
                    </div>
                </div>


                {{-- Tabel --}}
                <table id="positionsTable" class="min-w-full divide-y divide-gray-200 border">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Position ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Start Date Structure</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Start Date Map</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modals --}}
    @include('structure.modal-manage')
    @include('structure.modal-update-emp')

    @push('scripts')
        <script>
            //helpers
                // Format datetime-local
                function formatDateTimeLocal(datetime) {
                     if (!datetime) return '';
                    const dt = new Date(datetime);
                    const year = dt.getFullYear();
                    const month = String(dt.getMonth() + 1).padStart(2, '0');
                    const day = String(dt.getDate()).padStart(2, '0');
                    return `${year}-${month}-${day}`;  // Format: YYYY-MM-DD
                }
            $(document).ready(function () {
                 let employeeIndex = 0;
                let globalEmpIDs = [];
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
                        { data: 'PositionID',name: 'PositionID',},
                        { 
                            data: 'StartDatePosStructure', 
                            name: 'StartDatePosStructure',
                            render: function(data) {
                                return formatDateTimeLocal(data) || '-';
                            }
                        },
                        { 
                            data: 'StartDatePosMap', 
                            name: 'StartDatePosMap',
                            render: function(data) {
                                return formatDateTimeLocal(data) || '-';
                            }
                        },
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

            });

            function openManageModal() {
                $('#manageModal').removeClass('hidden');
            }

            function closeManageModal() {
                $('#manageModal').addClass('hidden');
            }

            function generateEmployeeBlock(data = {}, index = 0) {
                const structure = data.position_structure || {};
                return `
                    <div class="employee-block border rounded-lg p-4 mb-6 bg-white shadow-sm">
                        <input type="hidden" name="data[${index}][PositionID]" value="${data.PositionID || ''}">
                        <input type="hidden" name="data[${index}][EmpID]" value="${data.EmpID || ''}">
                        <input type="hidden" name="data[${index}][EmployeePosition]" value="${data.EmployeePosition || ''}">
                        <input type="hidden" name="data[${index}][ID]" value="${data.ID || ''}">

                        <h3 class="text-lg font-semibold text-indigo-700 mb-4">Employee</h3>
                        
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
                        <label for="vacantDate" class="block text-sm mb-1">Start Date</label>
                        <input type="date" id="vacantDate" class="swal2-input" value="${getDefaultDate()}">

                        <label for="vacantReason" class="block text-sm mt-4 mb-1">Reason</label>
                        <select id="vacantReason" class="swal2-input">
                            <option value="">-- Pilih Alasan --</option>
                            <option value="Resign">Employee Resign</option>
                            <option value="Mutasi">Employee Mutasi</option>
                        </select>
                    `,
                    focusConfirm: false,
                    showCancelButton: true,
                    confirmButtonText: 'Set Vacant',
                    cancelButtonText: 'Batal',
                    preConfirm: () => {
                        const dateInput = document.getElementById('vacantDate').value;
                        const reason = document.getElementById('vacantReason').value;

                        if (!dateInput || !reason) {
                            Swal.showValidationMessage('Tanggal dan alasan wajib diisi');
                            return false;
                        }

                        return { date: dateInput, reason };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const inputTanggal = result.value.date;
                        const reason = result.value.reason;

                        const positionData = [];

                        $('.employee-block').each(function () {
                            const block = $(this);
                            const indexMatch = block.find('input[name^="data["]').attr('name').match(/\d+/);
                            const index = indexMatch ? indexMatch[0] : 0;

                            const empID = block.find(`input[name="data[${index}][EmpID]"]`).val();
                            const positionID = block.find(`input[name="data[${index}][PositionID]"]`).val();
                            const employeePosition = block.find(`input[name="data[${index}][EmployeePosition]"]`).val();
                            const oldID = block.find(`input[name="data[${index}][ID]"]`).val();

                            positionData.push({
                                oldID: oldID,
                                PositionID: positionID,
                                EmpID: empID,
                                EmployeePosition: employeePosition
                            });
                        });

                        if (positionData.length === 0) {
                            Swal.fire('Gagal', 'Tidak ada data posisi yang diproses.', 'error');
                            return;
                        }
                        Swal.fire({
                            title: 'Yakin ingin set ke Vacant?',
                            text: `Data akan disimpan sebagai posisi kosong mulai ${inputTanggal} (${reason})`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, Set Vacant',
                            cancelButtonText: 'Batal'
                        }).then((confirmResult) => {
                            if (confirmResult.isConfirmed) {
                                $.ajax({
                                    url: '/position-map/set-vacant',
                                    type: 'POST',
                                    contentType: 'application/json',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    data: JSON.stringify({
                                        vacantStartDate: inputTanggal,
                                        reason: reason,
                                        positions: positionData,
                                    }),
                                    success: function () {
                                        Swal.fire('Berhasil', 'Data telah di-set ke Vacant.', 'success')
                                            .then(() => {
                                                closeManageModal();
                                                location.reload();
                                            });
                                    },
                                    error: function (xhr) {
                                        Swal.fire('Gagal', xhr.responseJSON?.error || 'Terjadi kesalahan saat menyimpan data.', 'error');
                                    }
                                });
                            }
                        });
                    }
                });
            });

            function getDefaultDate() {
                const now = new Date();
                return now.toISOString().slice(0, 10); // Format YYYY-MM-DD tanpa waktu
            }

            $('#updateEmployeeBtn').on('click', function () {
                const firstBlock = $('.employee-block').first();
                const indexMatch = firstBlock.find('input[name^="data["]').attr('name').match(/\d+/);
                const index = indexMatch ? indexMatch[0] : 0;
                const empID = firstBlock.find(`input[name="data[${index}][EmpID]"]`).val();
                const posID = firstBlock.find(`input[name="data[${index}][PositionID]"]`).val();
                const oldID = firstBlock.find(`input[name="data[${index}][ID]"]`).val();

                $('#posID').val(posID);
                $('#oldEmpID').val(empID);
                $('#oldID').val(oldID);
                $('#newEmpID').html('<option value="">-- Pilih Employee ID --</option>');

                // Fetch employee list
                $.ajax({
                    url: '/employee-list',
                    method: 'GET',
                    success: function (employees) {
                        $('#newEmpID').empty().append('<option value="">-- Pilih Employee ID --</option>');
                        employees.forEach(emp => {
                            $('#newEmpID').append(`<option value="${emp.EmployeeID}">${emp.EmployeeID} - ${emp.EmployeeName}</option>`);
                        });
                    },

                    error: function () {
                        alert('Gagal mengambil daftar employee.');
                    }
                });

                // Show modal
                $('#manageModal').addClass('hidden');
                $('#updateEmployeeModal').removeClass('hidden');
            });


            // Cancel update modal
            $('#cancelUpdateModalBtn').on('click', function () {
                $('#updateEmployeeModal').addClass('hidden');
                $('#manageModal').removeClass('hidden');
            });



            $('#updateEmployeeForm').on('submit', function(e) {
                e.preventDefault();

                const oldEmpID = $('#oldEmpID').val();
                const newEmpID = $('#newEmpID').val();
                const newStartDate = $('#newStartDate').val();
                const posID = $('#posID').val();
                const oldID = $('#oldID').val();
                const isResign = $('#isResign').is(':checked') ? 'Resign' : null;

                // Validasi sederhana
                if (!newEmpID || !newStartDate) {
                    Swal.fire('Gagal', 'Employee ID dan Start Date wajib diisi.', 'warning');
                    return;
                }

                Swal.fire({
                    title: 'Konfirmasi Update',
                    html: `
                        <div class="text-sm text-left">
                            <p><strong>Old EmpID:</strong> ${oldEmpID}</p>
                            <p><strong>New EmpID:</strong> ${newEmpID}</p>
                            <p><strong>Start Date:</strong> ${newStartDate}</p>
                            ${isResign ? '<p><strong>Status:</strong> Resign</p>' : ''}
                        </div>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Update',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/position-map/update-emp',
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                oldEmpID,
                                newEmpID,
                                posID,
                                oldID,
                                newStartDate,
                                reason: isResign
                            },
                            success: function(response) {
                                Swal.fire('Berhasil', 'Employee berhasil diperbarui.', 'success').then(() => {
                                    $('#updateEmployeeModal').addClass('hidden');
                                    $('#manageModal').removeClass('hidden');
                                    location.reload(); // Optional: reload jika perlu refresh data
                                });
                            },
                            error: function(xhr) {
                                Swal.fire('Error', xhr.responseJSON?.message || 'Update gagal.', 'error');
                            }
                        });
                    }
                });
            });

        </script>
    @endpush

</x-app-layout>
