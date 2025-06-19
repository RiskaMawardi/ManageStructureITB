<?php

namespace App\Imports;

use App\Models\EmployeeList;
use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeeImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
      
        $joinDate = null;
        if (!empty($row['join_date'])) {
            $joinDate = is_numeric($row['join_date'])
                ? Carbon::instance(Date::excelToDateTimeObject($row['join_date']))
                : Carbon::parse($row['join_date']);
                
        }

       
        $year = $joinDate->format('Y');
        $month = $joinDate->format('m');
        $prefix = 'IB';
        $defaultCode = '01';

        $lastEmployee = EmployeeList::where('EmployeeID', 'like', "{$prefix}{$year}{$month}{$defaultCode}%")
            ->orderBy('EmployeeID', 'desc')
            ->first();

        $lastNumber = $lastEmployee ? (int)substr($lastEmployee->EmployeeID, -3) : 0;
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        $generatedEmpID = "{$prefix}{$year}{$month}{$defaultCode}{$newNumber}";

        return new EmployeeList([
            'EmployeeID'     => $generatedEmpID,
            'EmployeeName'   => $row['employee_name'] ?? '-',
            'JoinDate'       => $joinDate,
            'StatusVacant'   => $row['status_vacant'] ?? '-',
            'EndDate'        => '4009-12-31',
            'EmailID'        => $row['email_id'] ?? null,
            'PhoneNumber'    => $row['phone_number'] ?? null,
            'UserID'         => 'ImportExcel',
            'CompanyID'      => 'IBT',
            'EmployeeStatus' => 'A',
            'LastUpdate'     => now(),
        ]);
    }
}
