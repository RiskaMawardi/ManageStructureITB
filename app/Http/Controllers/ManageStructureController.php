<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\EmployeeList;
use App\Models\PositionStructure;
use App\Models\PositionMap;
class ManageStructureController extends Controller
{
    public function index(){
        $empIDs = EmployeeList::distinct()->pluck('EmployeeID');
        return view('Manage.index',compact('empIDs'));
    }

    public function addNewRayon(Request $request)
    {
        //dd($request->all());

        $request->validate([
            'PositionID' => 'nullable|string',
            'EmployeePosition' => 'nullable|string',
            'EmployeeID'  => 'nullable|string',
            'AreaID' => 'nullable|string',  
            'AreaBaseID' => 'nullable|string',
            'AreaFF' => 'nullable|string',
            'RayonID' => 'nullable|string',
            'LineBaseID' => 'nullable|string',
            'AmPos' => 'nullable|string',
            'RmPos' => 'nullable|string',
            'SMPos' => 'nullable|string',
            'NSMPos' => 'nullable|string',
            'MMPos' => 'nullable|string',
            'GMPos' => 'nullable|string',
            'MDPos' => 'nullable|string',
            'StartDate' => 'nullable|date',
            'AreaGroupID' => 'nullable|string',
           
        ]);

        //dd('kesini');

        try {
           
            $posStructure = PositionStructure::create([
                'PositionID' => $request->PositionID,
                'EmployeePosition' => $request->EmployeePosition,
                'CompanyID' => 'IBT',
                'AreaID' => $request->AreaID,
                'AreaBaseID' => $request->AreaBaseID,
                'AreaFF' => $request->AreaFF,
                'RayonID' => $request->RayonID,
                'LineID' => 'ETHICAL',
                'LineBaseID' => $request->LineBaseID,
                'LinePositionFF' => 'ETHICAL',
                'AmPos' => $request->AmPos,
                'RmPos' => $request->RmPos,
                'SMPos' => $request->SMPos,
                'NSMPos' => $request->NSMPos,
                'MMPos' => $request->MMPos,
                'GMPos' => $request->GMPos,
                'MDPos' => $request->MDPos,
                'Station' => 'N',
                'StartDate' => $request->StartDate,
                'EndDate' => '4009-12-31',
                'PositionStatus' => 'A',
                'UserID' => Auth::user()->name,
                'LastUpdate' => Carbon::now('Asia/Jakarta'),
                'AreaGroupID' => $request->AreaGroupID,
            ]);

            //dd($posStructure);

          
            $employee = EmployeeList::where('EmployeeID', $request->employeeID)->first();
            $isVacant = $employee ? $employee->StatusVacant : 'N';

          
            $isCoordinator = ($request->EmployeePosition === 'AM') ? 'Y' : 'N';

          
            $PositionMap = PositionMap::create([
                'PositionID' => $request->PositionID,
                'EmpID' => $request->EmployeeID,
                'EmployeePosition' => $posStructure->EmployeePosition,
                'Status_Default' => 'Y',
                'Acting' => 'N',
                'IsVacant' => $isVacant,
                'IsCoordinator' => $isCoordinator,
                'Active' => 'A',
                'StartDate' => $posStructure->StartDate,
                'EndDate' => '4009-12-31',
                'UserID' => Auth::user()->name,
                'LastUpdate' => Carbon::now('Asia/Jakarta'),
            ]);

            //dd($PositionMap);

            return redirect()->back()->with('success', 'Rayon saved successfully!');

        } catch (\Exception $e) {
            
            Log::error('Error in addNewRayon: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to save rayon. Please try again later.');
        }
    }

    public function checkPositionId(Request $request)
    {
        $exists = PositionStructure::where('PositionID', $request->PositionID)->exists();

        return response()->json(['exists' => $exists]);
    }
}
