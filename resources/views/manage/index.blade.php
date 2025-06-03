<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Structure') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow sm:rounded-lg">
            <div class="mb-10">
                <h3 class="text-lg font-bold mb-4">Add New Rayon</h3>
                <form method="POST" action="{{route('addNewRayon')}}">
                    @csrf
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 shadow-sm">

                        <!-- Position Details -->
                        <fieldset class="border p-4 rounded-md mb-6">
                            <legend class="font-semibold text-gray-700">Position Details</legend>
                            <div class="mb-4">
                                <label for="PositionID" class="block text-sm font-medium text-gray-700">Position ID</label>
                                <input type="text" name="PositionID" id="PositionID" placeholder="Masukkan Position ID"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    value="{{ old('PositionID') }}">
                                <p id="position-id-feedback" class="text-sm mt-1 hidden"></p>
                            </div>

                            <div class="mb-4">
                                <label for="EmployeePosition" class="block text-sm font-medium text-gray-700">Employee Position</label>
                                <select id="EmployeePosition" name="EmployeePosition" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">-- Select Employee Position --</option>
                                    <option value="MR">MR</option>
                                    <option value="AM">AM</option>
                                </select>
                            </div>


                            <div class="mb-4">
                                <label for="EmployeeID" class="block text-sm font-medium text-gray-700">Employee ID</label>
                                <select id="EmployeeID" name="EmployeeID" 
                                    class="select2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">-- Select Employee ID --</option>
                                    @foreach($empIDs as $empID)
                                        <option value="{{ $empID }}" {{ old('EmployeeID') == $empID ? 'selected' : '' }}>
                                            {{ $empID }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                        </fieldset>

                        <!-- Area Details -->
                        <fieldset class="border p-4 rounded-md mb-6">
                            <legend class="font-semibold text-gray-700">Area Details</legend>
                            <div class="mb-4">
                                <label for="AreaID" class="block text-sm font-medium text-gray-700">Area ID</label>
                                <input type="text" name="AreaID" id="AreaID" placeholder="Masukkan Area ID"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    value="{{ old('AreaID') }}">
                            </div>

                            <div class="mb-4">
                                <label for="AreaBaseID" class="block text-sm font-medium text-gray-700">Area Base ID</label>
                                <input type="text" name="AreaBaseID" id="AreaBaseID" placeholder="Masukkan Area Base ID"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    value="{{ old('AreaBaseID') }}">
                            </div>

                            <div class="mb-4">
                                <label for="AreaFF" class="block text-sm font-medium text-gray-700">Area FF</label>
                                <input type="text" name="AreaFF" id="AreaFF" placeholder="Masukkan Area FF"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    value="{{ old('AreaFF') }}">
                            </div>

                            <div class="mb-4">
                                <label for="RayonID" class="block text-sm font-medium text-gray-700">Rayon ID</label>
                                <input type="text" name="RayonID" id="RayonID" placeholder="Masukkan Rayon ID"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    value="{{ old('RayonID') }}">
                            </div>
                        </fieldset>

                        <!-- Line Details -->
                        <fieldset class="border p-4 rounded-md mb-6">
                            <legend class="font-semibold text-gray-700">Line Details</legend>
                           
                            <div class="mb-4">
                                <label for="LineBaseID" class="block text-sm font-medium text-gray-700">Line Base ID</label>
                                <input type="text" name="LineBaseID" id="LineBaseID" placeholder="Masukkan Line Base ID"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    value="{{ old('LineBaseID') }}">
                            </div>

                            
                        </fieldset>

                        <!-- Position Roles -->
                        <fieldset class="border p-4 rounded-md mb-6">
                            <legend class="font-semibold text-gray-700">Position Roles</legend>
                            <div class="mb-4">
                                <label for="AmPos" class="block text-sm font-medium text-gray-700">AM Position</label>
                                <input type="text" name="AmPos" id="AmPos" placeholder="Masukkan AM Position"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    value="{{ old('AmPos') }}">
                            </div>

                            <div class="mb-4">
                                <label for="RmPos" class="block text-sm font-medium text-gray-700">RM Position</label>
                                <input type="text" name="RmPos" id="RmPos" placeholder="Masukkan RM Position"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    value="{{ old('RmPos') }}">
                            </div>

                            <div class="mb-4">
                                <label for="SMPos" class="block text-sm font-medium text-gray-700">SM Position</label>
                                <input type="text" name="SMPos" id="SMPos" placeholder="Masukkan SM Position"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    value="{{ old('SMPos') }}">
                            </div>

                            <div class="mb-4">
                                <label for="NSMPos" class="block text-sm font-medium text-gray-700">NSM Position</label>
                                <input type="text" name="NSMPos" id="NSMPos" placeholder="Masukkan NSM Position"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    value="{{ old('NSMPos') }}">
                            </div>

                            <div class="mb-4">
                                <label for="MMPos" class="block text-sm font-medium text-gray-700">MM Position</label>
                                <input type="text" name="MMPos" id="MMPos" placeholder="Masukkan MM Position"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    value="{{ old('MMPos') }}">
                            </div>

                            <div class="mb-4">
                                <label for="GMPos" class="block text-sm font-medium text-gray-700">GM Position</label>
                                <input type="text" name="GMPos" id="GMPos" placeholder="Masukkan GM Position"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    value="{{ old('GMPos') }}">
                            </div>

                            <div class="mb-4">
                                <label for="MDPos" class="block text-sm font-medium text-gray-700">MD Position</label>
                                <input type="text" name="MDPos" id="MDPos" placeholder="Masukkan MD Position"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    value="{{ old('MDPos') }}">
                            </div>
                        </fieldset>

                        <!-- Dates and Area Group -->
                        <fieldset class="border p-4 rounded-md mb-6">
                            <legend class="font-semibold text-gray-700">Dates and Area Group</legend>
                            <div class="mb-4">
                                <label for="StartDate" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="date" name="StartDate" id="StartDate"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    value="{{ old('StartDate') }}">
                            </div>

                            <div class="mb-4">
                                <label for="AreaGroupID" class="block text-sm font-medium text-gray-700">Area Group ID</label>
                                <input type="text" name="AreaGroupID" id="AreaGroupID" placeholder="Masukkan Area Group ID"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    value="{{ old('AreaGroupID') }}">
                            </div>
                        </fieldset>

                        <div class="mt-6 text-right">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 transition duration-200 ease-in-out">
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
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
    @endpush


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('PositionID');
            const feedback = document.getElementById('position-id-feedback');
            let timeout = null;

            input.addEventListener('input', function () {
                clearTimeout(timeout);

                const positionId = input.value.trim();

                if (positionId === '') {
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
                }, 400); // tunggu 400ms sebelum fetch (debounce)
            });
        });
    </script>
</x-app-layout>
