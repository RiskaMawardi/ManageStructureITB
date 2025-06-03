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
                            render: function (data, type, row) {
                                return `<a href="#" class="position-link text-blue-600 hover:underline view-detail" data-id="${row.PositionID}">${data}</a>`;
                            }
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
                function generateEmployeeBlock(data = {}, index = 0, empIDs = []) {
                    return `
                        <div class="employee-block border rounded p-4 mb-4 bg-gray-50 shadow-sm relative">
                            <button type="button" class="delete-btn absolute top-2 right-2 text-red-500 hover:text-red-700">
                                &times;
                            </button>
                            <input type="hidden" name="data[${index}][ID]" value="${data.ID || ''}" />
                            <div class="grid grid-cols-2 gap-4">
                                <div class="mb-4 col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Employee ID</label>
                                    <select 
                                        name="data[${index}][EmpID]" 
                                        class="select2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    >
                                        <option value="">-- Select Employee ID --</option>
                                        ${empIDs.map(empID => `
                                            <option value="${empID}" ${empID === data.EmpID ? 'selected' : ''}>${empID}</option>
                                        `).join('')}
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Employee Position</label>
                                    <input 
                                        type="text" 
                                        name="data[${index}][EmployeePosition]" 
                                        value="${data.EmployeePosition || ''}" 
                                        class="form-input w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" 
                                    />
                                </div>

                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Employee Name</label>
                                    <input 
                                        type="text" 
                                        name="data[${index}][EmployeeName]" 
                                        value="${data.employee?.EmployeeName || ''}" 
                                        class="form-input w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" 
                                    />
                                </div>

                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Date Map</label>
                                    <input 
                                        type="datetime-local" 
                                        name="data[${index}][StartDate]" 
                                        value="${formatDateTimeLocal(data.StartDate)}" 
                                        class="form-input w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" 
                                    />
                                </div>

                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">End Date Map</label>
                                    <input 
                                        type="datetime-local" 
                                        name="data[${index}][EndDate]" 
                                        value="${formatDateTimeLocal(data.EndDate)}" 
                                        class="form-input w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" 
                                    />
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

                // Tambah Employee
                $('#addEmployeeBtn').on('click', function () {
                    const newBlock = generateEmployeeBlock({}, employeeIndex, globalEmpIDs);
                    $('#employee-section').append(newBlock);

                    // Re-initialize select2 for the last appended element
                    $('#employee-section .employee-block:last .select2').select2({
                        placeholder: "-- Pilih Employee ID --",
                        allowClear: true,
                        width: '100%'
                    });

                    employeeIndex++;
                });

                // Hapus Employee Block
                $(document).on('click', '.delete-btn', function () {
                    $(this).closest('.employee-block').remove();
                });

                // Submit update manage form
                $('#editStructureForm').on('submit', function (e) {
                    e.preventDefault();

                    $.ajax({
                        url: `/structure/update-multiple`,
                        method: 'PUT',
                        data: $(this).serialize(),
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function () {
                            alert('Data berhasil disimpan!');
                            closeManageModal();
                            table.ajax.reload();
                        },
                        error: function () {
                            alert('Gagal menyimpan data.');
                        }
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>
