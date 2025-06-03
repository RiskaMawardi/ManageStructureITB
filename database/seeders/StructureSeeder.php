<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            ['PositionID' => 'BTMAESA01011', 'EmployeePosition' => 'MR'],
            ['PositionID' => 'BTMAESRMA01', 'EmployeePosition' => 'RM'],
            ['PositionID' => 'BTMAESSA0101', 'EmployeePosition' => 'AM'],
            ['PositionID' => 'BTMOGBIBTSN1', 'EmployeePosition' => 'AM'],
            ['PositionID' => 'BTMREGB35011', 'EmployeePosition' => 'MR'],
            ['PositionID' => 'BTMREGB35012', 'EmployeePosition' => 'MR'],
            ['PositionID' => 'BTMREGB35021', 'EmployeePosition' => 'MR'],
            ['PositionID' => 'BTMREGB35022', 'EmployeePosition' => 'MR'],
            ['PositionID' => 'BTMREGB35031', 'EmployeePosition' => 'MR'],
            ['PositionID' => 'BTMREGB35032', 'EmployeePosition' => 'MR'],
            ['PositionID' => 'BTMREGB35041', 'EmployeePosition' => 'MR'],
            ['PositionID' => 'BTMREGB35042', 'EmployeePosition' => 'MR'],
        ];

        // Daftar employee IDs yang sudah ada
        $employeeIds = [
            'IB20250501001',
            'IB20250501002',
            'IB20250501003',
            'IB20250501004',
            'IB20250501005',
            'IB20250501006',
            'IB20250501007',
            'IB20250501008',
            'IB20250501009',
            'IB20250501010',
            'IB20250501011',
            'IB20250501012',
        ];

        $now = Carbon::now();

        $data = [];

        // Kita akan mapping posisi ke employee secara berulang
        // Contohnya, assign posisi secara bergilir ke employeeId yg ada
        $empCount = count($employeeIds);
        foreach ($positions as $index => $pos) {
            $data[] = [
                'PositionID' => $pos['PositionID'],
                'EmpID' => $employeeIds[$index % $empCount],
                'EmployeePosition' => $pos['EmployeePosition'],
                'Status_Default' => 'Y',        // contoh default aktif
                'Acting' => 'N',                // contoh acting = no
                'IsVacant' => 'N',              // contoh posisi tidak kosong
                'IsCoordinator' => 'N',         // contoh bukan koordinator
                'Active' => 'Y',                // aktif
                'StartDate' => $now,
                'EndDate' => '4009-12-31 00:00:00',
                'UserID' => 'system',
                'LastUpdate' => $now,
            ];
        }

        DB::table('Position_Map_IBT')->insert($data);
    }
}
