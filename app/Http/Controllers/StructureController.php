<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PositionMap;
use App\Models\EmployeeList;
use App\Models\PositionStructure;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


class StructureController extends Controller
{
    public function index()
    {
       $rayonIDs = PositionStructure::where('LineID', 'ETHICAL')
        ->whereNotNull('RayonID')                 
        ->where('RayonID', '!=', '')             
        ->where(function($query) {
            $query->whereNull('EndDate')
                ->orWhere('EndDate', '>', Carbon::now());
        })
        ->distinct()
        ->orderBy('RayonID')
        ->pluck('RayonID');
      
        return view('structure.index', compact('rayonIDs'));
    }

    public function fetchDataByArea(Request $request)
    {
        if (!$request->has('RayonID') || !$request->RayonID) {
            return response()->json(['error' => 'RayonID is required'], 400);
        }

        $rayonID = $request->input('RayonID');
        $lineID = 'ETHICAL';

        $query = PositionMap::with(['employee', 'positionStructure'])
            ->whereHas('positionStructure', function ($query) use ($rayonID) {
                $query->where('RayonID', $rayonID);
            })
            ->whereHas('positionStructure', function ($query) use ($lineID) {
                $query->where('LineID', $lineID);
            })
            ->where(function ($query) {
                $query->whereNull('EndDate')
                    ->orWhere('EndDate', '>', Carbon::now());
            });

            //dd($query->get());

            return DataTables::eloquent($query)
            ->addColumn('PositionID', function ($position) {
                return $position->PositionID ?? '-';
            })
            ->addColumn('EmployeeID', function ($position) {
                return $position->EmpID ?? '-';
            })
            ->addColumn('EmployeePosition', function ($position) {
                return $position->EmployeePosition ?? '-';
            })
            ->addColumn('StartDatePosStructure', function ($position) {
                return optional($position->positionStructure)->StartDate ?? '-';
            })
            ->addColumn('StartDatePosMap', function ($position) {
                return $position->StartDate ?? '-';
            })
            ->addColumn('PositionRecord', function ($position) {
                return optional($position->positionStructure)->PositionRecord ?? '-';
            })

            ->make(true);
    }

    public function show($id)
    {
        $data = PositionMap::with(['employee', 'positionStructure'])
        ->where('PositionID', $id)
        ->firstOrFail();

        if ($data->EndDate === null || $data->EndDate > Carbon::now()) {
            return response()->json($data);
        }

        return response()->json(['message' => 'Data sudah tidak aktif.'], 404);
    }

    public function getEmpIdByPositionId($posID){

        $data = PositionMap::with(['employee', 'positionStructure'])
        ->where('PositionID', $posID)
        ->where(function ($query) {
            $query->whereNull('EndDate')
                  ->orWhere('EndDate', '>', Carbon::now());
        })
        ->get();

        $empIDs = EmployeeList::distinct()->pluck('EmployeeID');

        return response()->json([
            'data' => $data,
            'empIDs' => $empIDs,
        ]);
    }

    public function updateMap(Request $request)
    {
        try {
            $startDate = Carbon::parse($request->newStartDate);
            $reason = $request->reason;
            $posID = $request->posID;
            $oldID = $request->oldID;
            $oldEmpID = $request->oldEmpID;
            $newEmpID = $request->newEmpID;
          
            if ($reason === 'Resign') {
                // End Employee
                EmployeeList::where('EmployeeID', $oldEmpID)->update([
                    'EndDate' => $startDate,
                    'LastUpdate' => Carbon::now('Asia/Jakarta'),
                    'UserID' => Auth::user()->name,
                ]);
            }

            // End current PositionMap
            PositionMap::where('ID', $oldID)->update([
                'EndDate' => $startDate,
                'LastUpdate' => Carbon::now('Asia/Jakarta'),
                'UserID' => Auth::user()->name,
            ]);

            //Create new PositionMap with new EmployeeID
            PositionMap::create([
                'PositionID'       => $posID,
                'EmployeePosition' => null,
                'EmpID'            => $newEmpID,
                'StartDate'        => $startDate,
                'EndDate'          => '4009-12-31',
                'PositionStatus'   => 'A',
                'Status_Default'   => 'Y',
                'Acting'           => 'N',
                'IsVacant'         => 'Y',
                'Active'           => 'A',
                'UserID'           => Auth::user()->name,
                'LastUpdate'       => Carbon::now('Asia/Jakarta'),
            ]);

            return response()->json(['message' => 'Updated or created successfully']);

        } catch (\Exception $e) {
            \Log::error('Error in updateMap: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal update employee: ' . $e->getMessage()], 500);
        }
    }

    public function generatePdf(Request $request)
    {
        $rayonID = $request->input('RayonID');
        if (!$rayonID) {
            return redirect()->back()->withErrors(['RayonID' => 'RayonID wajib dipilih sebelum mencetak PDF.']);
        }

        $query = PositionMap::with(['employee', 'positionStructure'])
            ->whereHas('positionStructure', function ($query) use ($rayonID) {
                $query->where('RayonID', $rayonID);
            })
            ->where(function ($query) {
                $query->whereNull('EndDate')
                    ->orWhere('EndDate', '>', Carbon::now());
            });

        $data = $query->get();

        if ($data->isEmpty()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // Generate PDF
        $pdf = Pdf::loadView('pdf.position_map', [
            'rayonID' => $rayonID,
            'data' => $data
        ]);

        return $pdf->stream("position_map_rayon_{$rayonID}.pdf");
    }

    public function setVacant(Request $request)
    {
        try {
            $vacantStartDate = Carbon::parse($request->vacantStartDate);
            $reason = $request->reason;

            foreach ($request->positions as $pos) {
                if ($reason === 'Resign') {
                   
                    EmployeeList::where('EmployeeID', $pos['EmpID'])->update([
                        'EndDate' => $vacantStartDate,
                        'LastUpdate' => Carbon::now('Asia/Jakarta'),
                        'UserID' => Auth::user()->name,
                        'EmployeeStatus' => 'R'
                    ]);

                }

                // Update old position
                PositionMap::where('ID', $pos['oldID'])->update([
                    'EndDate' => $vacantStartDate,
                    'LastUpdate' => Carbon::now('Asia/Jakarta'),
                    'UserID' => Auth::user()->name,
                ]);

               
                if (strtoupper($pos['EmployeePosition']) === 'RM') {
                    $rayonSuffix = substr($pos['PositionID'], -3);
                    $employeeName = "MR X RM {$rayonSuffix}";
                } else {
                    preg_match('/[A-Z]\d{5}$/', $pos['PositionID'], $match);
                    $kodeRayon = $match[0] ?? 'AXXXXX';
                    $employeeName = "{$pos['EmployeePosition']} X {$kodeRayon}";
                }

                // Generate EmployeeID dummy
                $year = $vacantStartDate->format('Y');
                $month = $vacantStartDate->format('m');
                $prefix = 'IB';
                $defaultCode = '01';

                $lastEmployee = EmployeeList::where('EmployeeID', 'like', "{$prefix}{$year}{$month}{$defaultCode}%")
                    ->orderBy('EmployeeID', 'desc')
                    ->first();

                $lastNumber = $lastEmployee ? (int)substr($lastEmployee->EmployeeID, -3) : 0;
                $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
                $generatedEmpID = "{$prefix}{$year}{$month}{$defaultCode}{$newNumber}";

                // Buat dummy employee baru
                EmployeeList::create([
                    'EmployeeID'     => $generatedEmpID,
                    'EmployeeName'   => $employeeName,
                    'EmailID'        => null,
                    'PhoneNumber'    => null,
                    'StatusVacant'   => 'Y',
                    'JoinDate'       => $vacantStartDate,
                    'EmployeeStatus' => 'A',
                    'EndDate'        => '4009-12-31',
                    'UserID'         => Auth::user()->name ?? 'System',
                    'LastUpdate'     => Carbon::now('Asia/Jakarta'),
                ]);

                // Buat posisi baru
                PositionMap::create([
                    'PositionID'       => $pos['PositionID'],
                    'EmployeePosition' => $pos['EmployeePosition'],
                    'EmpID'            => $generatedEmpID,
                    'StartDate'        => $vacantStartDate,
                    'EndDate'          => '4009-12-31',
                    'PositionStatus'   => 'A',
                    'EmployeeName'     => $employeeName,
                    'Status_Default'   => 'Y',
                    'Acting'           => 'N',
                    'IsVacant'         => 'Y',
                    'Active'           => 'A',
                    'UserID'           => Auth::user()->name,
                    'LastUpdate'       => Carbon::now('Asia/Jakarta'),
                ]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Error in setVacant: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function promoteToNewPosition(Request $request)
    {
        $request->validate([
            'ID' => 'required',
            'EmpID' => 'required',
            'posID' => 'required',
            'PositionID' => 'required',
            'EmployeePosition' => 'required',
            'StartDate' => 'required|date',
        ]);

        $ID = $request->ID;
        $posID = $request->posID;
        $empID = $request->EmpID;
        $newPositionID = $request->PositionID;
        $newPosition = $request->EmployeePosition;
        $startDate = $request->StartDate;

        DB::beginTransaction();
        try {

            PositionStructure::where('PositionRecord',$posID)->update([
                'EndDate' => Carbon::parse($startDate)->subDay(),
                'LastUpdate' => now(),
                'UserID' => auth()->user()->username ?? 'system',
            ]);

            PositionStructure::insert([
                'PositionID' => $newPositionID,
                'EmployeePosition' => $newPosition,
            ]);

            PositionMap::where('ID', $ID)
            ->where(function ($q) {
                $q->whereNull('EndDate')
                ->orWhere('EndDate', '>', now());
            })
            ->update([
                'EndDate' => Carbon::parse($startDate)->subDay(),
                'LastUpdate' => now(),
                'UserID' => auth()->user()->username ?? 'system',
            ]);

           
            PositionMap::insert([
                'PositionID' => $newPositionID,
                'EmpID' => $empID,
                'EmployeePosition' => $newPosition,
                'Status_Default' => 'N',
                'Acting' => 'N',
                'IsVacant' => 'N',
                'IsCoordinator' => null,
                'Active' => 'Y',
                'StartDate' => $startDate,
                'EndDate' => '4009-12-31',
                'UserID' => auth()->user()->username ?? 'system',
                'LastUpdate' => now(),
            ]);

            DB::commit();
            return back()->with('success', "Promosi ke $newPosition berhasil.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal promosi: ' . $e->getMessage());
        }
    }

}
