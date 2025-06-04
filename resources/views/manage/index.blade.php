<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Structure') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow sm:rounded-lg">
            <h3 class="text-lg font-bold mb-6">Add New Rayon</h3>

            <form method="POST" action="{{ route('addNewRayon') }}">
                @csrf
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 shadow-sm space-y-8">

                    {{-- Position Details --}}
                    <fieldset class="border p-5 rounded-md">
                        <legend class="font-semibold text-gray-700 px-2">Position Details</legend>
                        <div class="space-y-4 mt-4">
                            <div>
                                <label for="PositionID" class="block text-sm font-medium text-gray-700">Position ID</label>
                                <input 
                                    type="text" name="PositionID" id="PositionID" 
                                    placeholder="Masukkan Position ID"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    value="{{ old('PositionID') }}">
                                <p id="position-id-feedback" class="text-sm mt-1 hidden"></p>
                            </div>

                            <div>
                                <label for="EmployeePosition" class="block text-sm font-medium text-gray-700">Employee Position</label>
                                <select 
                                    id="EmployeePosition" name="EmployeePosition"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                >
                                    <option value="">-- Select Employee Position --</option>
                                    <option value="MR" {{ old('EmployeePosition') == 'MR' ? 'selected' : '' }}>MR</option>
                                    <option value="AM" {{ old('EmployeePosition') == 'AM' ? 'selected' : '' }}>AM</option>
                                </select>
                            </div>

                            <div>
                                <label for="EmployeeID" class="block text-sm font-medium text-gray-700">Employee ID</label>
                                <select 
                                    id="EmployeeID" name="EmployeeID" 
                                    class="select2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                >
                                    <option value="">-- Select Employee ID --</option>
                                    @foreach($empIDs as $empID)
                                        <option value="{{ $empID }}" {{ old('EmployeeID') == $empID ? 'selected' : '' }}>
                                            {{ $empID }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </fieldset>

                    {{-- Area Details --}}
                    <fieldset class="border p-5 rounded-md">
                        <legend class="font-semibold text-gray-700 px-2">Area Details</legend>
                        <div class="space-y-4 mt-4">
                            @foreach (['AreaID', 'AreaBaseID', 'AreaFF', 'RayonID'] as $field)
                                <div>
                                    <label for="{{ $field }}" class="block text-sm font-medium text-gray-700">{{ str_replace('ID', ' ID', $field) }}</label>
                                    <input 
                                        type="text" name="{{ $field }}" id="{{ $field }}" 
                                        placeholder="Masukkan {{ str_replace('ID', ' ID', $field) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                        value="{{ old($field) }}">
                                </div>
                            @endforeach
                        </div>
                    </fieldset>

                    {{-- Line Details --}}
                    <fieldset class="border p-5 rounded-md">
                        <legend class="font-semibold text-gray-700 px-2">Line Details</legend>
                        <div class="mt-4">
                            <label for="LineBaseID" class="block text-sm font-medium text-gray-700">Line Base ID</label>
                            <input 
                                type="text" name="LineBaseID" id="LineBaseID" placeholder="Masukkan Line Base ID"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                value="{{ old('LineBaseID') }}">
                        </div>
                    </fieldset>

                    {{-- Position Roles --}}
                    <fieldset class="border p-5 rounded-md">
                        <legend class="font-semibold text-gray-700 px-2">Position Roles</legend>
                        <div class="space-y-4 mt-4">
                            @foreach (['AmPos' => 'AM Position', 'RmPos' => 'RM Position', 'SMPos' => 'SM Position', 'NSMPos' => 'NSM Position', 'MMPos' => 'MM Position', 'GMPos' => 'GM Position', 'MDPos' => 'MD Position'] as $key => $label)
                                <div>
                                    <label for="{{ $key }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
                                    <input 
                                        type="text" name="{{ $key }}" id="{{ $key }}" 
                                        placeholder="Masukkan {{ $label }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                        value="{{ old($key) }}">
                                </div>
                            @endforeach
                        </div>
                    </fieldset>

                    {{-- Dates and Area Group --}}
                    <fieldset class="border p-5 rounded-md">
                        <legend class="font-semibold text-gray-700 px-2">Dates and Area Group</legend>
                        <div class="space-y-4 mt-4">
                            <div>
                                <label for="StartDate" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input 
                                    type="date" name="StartDate" id="StartDate"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    value="{{ old('StartDate') }}">
                            </div>

                            <div>
                                <label for="AreaGroupID" class="block text-sm font-medium text-gray-700">Area Group ID</label>
                                <input 
                                    type="text" name="AreaGroupID" id="AreaGroupID" placeholder="Masukkan Area Group ID"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    value="{{ old('AreaGroupID') }}">
                            </div>
                        </div>
                    </fieldset>

                    <div class="text-right">
                        <button 
                            type="submit"
                            class="inline-flex items-center px-6 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 transition duration-200 ease-in-out"
                        >
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
            const input = document.getElementById('PositionID');
            const feedback = document.getElementById('position-id-feedback');
            let timeout = null;

            input.addEventListener('input', function () {
                clearTimeout(timeout);

                const positionId = input.value.trim();

                if (!positionId) {
                    feedback.textContent = '';
                    feedback.classList.add('hidden');
                    return;
                }

                timeout = setTimeout(() => {
                    fetch(`/check-position-id?PositionID=${encodeURIComponent(positionId)}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.exists) {
                                feedback.textContent = '❌ Position ID sudah ada.';
                                feedback.classList.remove('hidden');
                                feedback.classList.add('text-red-500');
                                feedback.classList.remove('text-green-500');
                            } else {
                                feedback.textContent = '✅ Position ID tersedia.';
                                feedback.classList.remove('hidden');
                                feedback.classList.remove('text-red-500');
                                feedback.classList.add('text-green-500');
                            }
                        });
                }, 400);
            });
        });
    </script>
    @endpush
</x-app-layout>
