<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PositionStructure extends Model
{
    protected $table = 'CRM.Position_Structure_IBT';
    protected $primaryKey = 'PositionRecord';
    public $timestamps = false;
    protected $fillable = [
        'PositionID',
        'EmployeePosition', 
        'CompanyID',
        'AreaID',
        'AreaBaseID',
        'AreaFF',
        'RayonID',
        'LineID',
        'LineBaseID',
        'LinePositionFF',
        'AmPos',
        'RmPos',
        'SMPos',
        'NSMPos',
        'MMPos',
        'GMPos',
        'MDPos',
        'Station',
        'StartDate',
        'EndDate',
        'PositionStatus',
        'UserID',
        'LastUpdate',
        'AreaGroupID',
    ];
}
