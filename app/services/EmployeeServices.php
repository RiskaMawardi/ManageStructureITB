<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class EmployeeServices
{
    public function getAllEmployees()
    {
        return DB::connection('sqlsrv_hr_ibt')
            ->table('EMPLOYEE.Employee')
            ->get();
    }

    public function getEmployeeById($employeeId)
    {
        return DB::connection('sqlsrv_hr_ibt')
            ->table('EMPLOYEE.Employee')
            ->where('employeeId', $employeeId)
            ->first();
    }
}
