<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PositionMap extends Model
{
    protected $table = 'CRM.Position_Map_IBT';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = [
        'PositionID',
        'EmpID',
        'EmployeePosition',
        'Status_Default',
        'Acting',
        'IsVacant',
        'IsCoordinator',
        'Active',
        'StartDate',
        'EndDate',
        'UserID',
        'LastUpdate',
    ];

   
    public function employee()
    {
        return $this->belongsTo(EmployeeList::class, 'EmpID', 'EmployeeID');
    }
    public function positionStructure()
{
    return $this->belongsTo(PositionStructure::class, 'PositionID', 'PositionID');
}


}
