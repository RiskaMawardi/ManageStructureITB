<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PositionMap;
use App\Models\EmployeeList;
use App\Models\PositionStructure;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DataTables;
use Barryvdh\DomPDF\Facade\Pdf;


class StructureController extends Controller
{
    public function index()
    {
       $rayonIDs = PositionStructure::where('LineID', 'ETHICAL')
        ->where(function($query) {
            $query->whereNull('EndDate')
                ->orWhere('EndDate', '>', Carbon::now());
        })
        ->distinct()
        ->orderBy('RayonID')
        ->pluck('RayonID');
        //dd($rayonIDs);
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
            ->addColumn('StartDatePosStructure', function ($position) {
                return optional($position->positionStructure)->StartDate ?? '-';
            })
            ->addColumn('StartDatePosMap', function ($position) {
                return $position->StartDate ?? '-';
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
      
        PositionMap::where('ID', $pos['oldID'])->update([
                    'EndDate' => $vacantStartDate,
                    'LastUpdate' => Carbon::now('Asia/Jakarta'),
                    'UserID' => Auth::user()->name,
                ]);
    
        return response()->json(['message' => 'Updated or created successfully']);
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

            foreach ($request->positions as $pos) {
                // 1. Update posisi lama
                PositionMap::where('ID', $pos['oldID'])->update([
                    'EndDate' => $vacantStartDate,
                    'LastUpdate' => Carbon::now('Asia/Jakarta'),
                    'UserID' => Auth::user()->name,
                ]);

                // 2. Update data employee lama
                EmployeeList::where('EmployeeID', $pos['EmpID'])->update([
                    'EndDate' => $vacantStartDate,
                    'LastUpdate' => Carbon::now('Asia/Jakarta'),
                    'UserID' => Auth::user()->name,
                ]);

                // 3. Ambil kode rayon dari PositionID
                preg_match('/[A-Z]\d{5}$/', $pos['PositionID'], $match);
                $kodeRayon = $match[0] ?? 'AXXXXX'; // fallback
                $employeeName = "{$pos['EmployeePosition']} X {$kodeRayon}";

                // 4. Generate EmployeeID unik
                $joinDate = $vacantStartDate;
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

                // 5. Insert dummy employee baru
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

                // 6. Insert posisi baru (vacant)
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

}
