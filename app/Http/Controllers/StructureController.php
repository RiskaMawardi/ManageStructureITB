<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PositionMap;
use App\Models\EmployeeList;
use App\Models\PositionStructure;
use Carbon\Carbon;
use DataTables;
use Barryvdh\DomPDF\Facade\Pdf;


class StructureController extends Controller
{
    public function index()
    {
        $rayonIDs = PositionStructure::distinct()->pluck('RayonID');
        return view('structure.index', compact('rayonIDs'));
    }

    public function fetchDataByArea(Request $request)
    {
        if (!$request->has('RayonID') || !$request->RayonID) {
            return response()->json(['error' => 'RayonID is required'], 400);
        }

        $rayonID = $request->input('RayonID');

        $query = PositionMap::with(['employee', 'positionStructure'])
            ->whereHas('positionStructure', function ($query) use ($rayonID) {
                $query->where('RayonID', $rayonID);
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

        $data = PositionMap::with(['employee'])
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



    public function updateMultiple(Request $request)
    {
        foreach ($request->data as $entry) {
            PositionMap::updateOrCreate(
                ['ID' => $entry['ID']],
                [
                    'EmpID' => $entry['EmpID'],
                    'EmployeePosition' => $entry['EmployeePosition'],
                    'StartDate' => $entry['StartDate'],
                    'EndDate' => $entry['EndDate'],
                ]
            );
        }

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




}
