<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Manage Structure - Add New Rayon') }}
        </h2>
    </x-slot>

    <div class="py-10 max-w-6xl mx-auto px-6">
        <div class="bg-white p-8 rounded-2xl shadow-lg space-y-8">
            <h3 class="text-xl font-semibold text-indigo-700">Form Tambah Rayon Baru</h3>

            <form method="POST" action="{{ route('addNewRayon') }}">
                @csrf

                {{-- Position Details --}}
                <div class="border rounded-xl p-6 bg-gray-50">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Position Details</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="PositionID" class="text-sm font-medium text-gray-700">Position ID</label>
                            <input type="text" name="PositionID" id="PositionID"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                value="{{ old('PositionID') }}"
                                placeholder="Masukkan Position ID">
                            <p id="position-id-feedback" class="text-sm mt-1 hidden"></p>
                        </div>

                        <div>
                            <label for="EmployeePosition" class="text-sm font-medium text-gray-700">Employee Position</label>
                            <select name="EmployeePosition" id="EmployeePosition"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">-- Pilih Posisi --</option>
                                <option value="MR" {{ old('EmployeePosition') == 'MR' ? 'selected' : '' }}>MR</option>
                                <option value="AM" {{ old('EmployeePosition') == 'AM' ? 'selected' : '' }}>AM</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label for="EmployeeID" class="text-sm font-medium text-gray-700">Employee ID</label>
                            <select name="EmployeeID" id="EmployeeID"
                                class="select2 mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">-- Pilih Employee ID --</option>
                                @foreach($empIDs as $emp)
                                    <option value="{{ $emp->EmployeeID }}" {{ old('EmployeeID') == $emp->EmployeeID ? 'selected' : '' }}>
                                        {{ $emp->EmployeeID }} - {{ $emp->EmployeeName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Area Details --}}
                <div class="border rounded-xl p-6 bg-gray-50 mt-5">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">🌍 Area Details</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach (['AreaID', 'AreaBaseID', 'AreaFF', 'RayonID'] as $field)
                            <div>
                                <label for="{{ $field }}" class="text-sm font-medium text-gray-700">
                                    {{ str_replace('ID', ' ID', $field) }}
                                </label>
                                <input type="text" name="{{ $field }}" id="{{ $field }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    placeholder="Masukkan {{ str_replace('ID', ' ID', $field) }}"
                                    value="{{ old($field) }}">
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Line Details --}}
                <div class="border rounded-xl p-6 bg-gray-50 mt-5">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">📏 Line Details</h4>
                    <div>
                        <label for="LineBaseID" class="text-sm font-medium text-gray-700">Line Base ID</label>
                        <input type="text" name="LineBaseID" id="LineBaseID"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                            placeholder="Masukkan Line Base ID"
                            value="{{ old('LineBaseID') }}">
                    </div>
                </div>

                {{-- Position Roles --}}
                <div class="border rounded-xl p-6 bg-gray-50 mt-5">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">🧩 Position Roles</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach (['AmPos'=>'AM', 'RmPos'=>'RM', 'SMPos'=>'SM', 'NSMPos'=>'NSM', 'MMPos'=>'MM', 'GMPos'=>'GM', 'MDPos'=>'MD'] as $key => $label)
                            <div>
                                <label for="{{ $key }}" class="text-sm font-medium text-gray-700">{{ $label }} Position</label>
                                <input type="text" name="{{ $key }}" id="{{ $key }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    placeholder="Masukkan {{ $label }} Position"
                                    value="{{ old($key) }}">
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Dates and Group --}}
                <div class="border rounded-xl p-6 bg-gray-50 mt-5">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">📅 Dates & Area Group</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="StartDate" class="text-sm font-medium text-gray-700">Start Date</label>
                            <input type="date" name="StartDate" id="StartDate"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                value="{{ old('StartDate') }}">
                        </div>

                        <div>
                            <label for="AreaGroupID" class="text-sm font-medium text-gray-700">Area Group ID</label>
                            <input type="text" name="AreaGroupID" id="AreaGroupID"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                placeholder="Masukkan Area Group ID"
                                value="{{ old('AreaGroupID') }}">
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="text-right pt-6">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-lg shadow transition-all">
                         Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
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
                                feedback.classList.remove('hidden', 'text-green-500');
                                feedback.classList.add('text-red-500');
                            } else {
                                feedback.textContent = '✅ Position ID tersedia.';
                                feedback.classList.remove('hidden', 'text-red-500');
                                feedback.classList.add('text-green-500');
                            }
                        });
                }, 400);
            });
        });
    </script>
    @endpush
</x-app-layout>
