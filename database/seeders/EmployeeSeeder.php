<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        $prefix = 'IB';
        $defaultCode = '01';

        $joinDate = Carbon::create(2025, 5, 15); // Bisa ubah sesuai keinginan
        $year = $joinDate->format('Y');
        $month = $joinDate->format('m');

        // Loop untuk buat 5 data contoh
        for ($i = 1; $i <= 12; $i++) {
            $numberPadded = str_pad($i, 3, '0', STR_PAD_LEFT);
            $employeeID = $prefix . $year . $month . $defaultCode . $numberPadded;

            DB::table('EmployeeList_IBT')->insert([
                'EmployeeID' => $employeeID,
                'EmployeeName' => 'Employee ' . $i,
                'EmailID' => 'employee' . $i . '@example.com',
                'PhoneNumber' => '08123456789' . $i,
                'StatusVacant' => $i % 2 == 0 ? 'N' : 'Y',
                'JoinDate' => $joinDate->toDateString(),
                'EmployeeStatus' => 'A',
                'EndDate' => '4009-12-31',
                'UserID' => 'Seeder',
                'LastUpdate' => Carbon::now(),
            ]);
        }
    }
}
