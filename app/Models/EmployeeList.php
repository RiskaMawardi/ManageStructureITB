<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeList extends Model
{
    protected $table = 'CRM.EmployeeList_IBT';
    protected $primaryKey = 'RefEmpID';
    public $timestamps = false;
    protected $fillable = [
        'RefEmpID',
        'CompanyID',
        'EmployeeID',
        'EmpOldID',
        'EmployeeName',
        'EmployeeStatus',
        'JoinDate',
        'EndDate',
        'StatusVacant',
        'EmailID',
        'UserID',
        'LastUpdate',
        'PhoneNumber',
    ];
}
