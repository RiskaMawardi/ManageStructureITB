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
                        <select id="rayonID" name="RayonID" class="mt-1 block w-1/3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">-- Pilih RayonID --</option>
                            @foreach($rayonIDs as $rayonID)
                                <option value="{{ $rayonID }}">{{ $rayonID }}</option>
                            @endforeach
                        </select>

                        <button id="loadDataBtn" class="mt-1 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                            Tampilkan
                        </button>
                    </div>
                </div>

                <table id="positionsTable" class="min-w-full divide-y divide-gray-200 border">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date Structure</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date Map</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

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
                    { data: 'PositionID', name: 'PositionID' },
                    { data: 'StartDatePosStructure', name: 'StartDatePosStructure' },
                    { data: 'StartDatePosMap', name: 'StartDatePosMap' },
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

            $('#loadDataBtn').click(function () {
                const selectedRayon = $('#rayonID').val();
                if (!selectedRayon) {
                    alert('Silakan pilih RayonID terlebih dahulu.');
                    return;
                }
                table.ajax.reload();
            });
        });
    </script>
    @endpush
</x-app-layout>
