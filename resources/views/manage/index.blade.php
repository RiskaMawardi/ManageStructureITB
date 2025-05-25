<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Structure') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow sm:rounded-lg">
            {{-- Section 1: Tambah/Hapus Rayon --}}
            <div class="mb-10">
                <h3 class="text-lg font-bold mb-4">Kelola Rayon</h3>

                <form method="POST" action="" class="mb-4 flex items-center gap-4">
                    @csrf
                    <input type="text" name="RayonID" placeholder="Masukkan RayonID baru" class="border p-2 rounded w-1/3">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Tambah Rayon
                    </button>
                </form>

                <table class="min-w-full divide-y divide-gray-200 border mt-4">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rayon ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>

            {{-- Section 2: Mutasi Employee ke Position --}}
            <div>
                <h3 class="text-lg font-bold mb-4">Mutasi Employee</h3>

                <form method="POST" action="" class="space-y-4">
                    @csrf
                    <div class="flex flex-wrap gap-6">
                        <div class="w-full sm:w-1/3">
                            <label class="block text-sm font-medium text-gray-700">Employee ID</label>
                            <select name="EmployeeID" required class="border p-2 w-full rounded">
                                <option value="">-- Pilih --</option>
                              
                            </select>
                        </div>

                        <div class="w-full sm:w-1/3">
                            <label class="block text-sm font-medium text-gray-700">Position ID Baru</label>
                            <select name="PositionID" required class="border p-2 w-full rounded">
                                <option value="">-- Pilih --</option>
                               
                            </select>
                        </div>

                        <div class="w-full sm:w-1/3 flex items-end">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full">
                                Mutasi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
