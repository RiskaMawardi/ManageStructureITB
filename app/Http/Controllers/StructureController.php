<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PositionMap;
use App\Models\PositionStructure;
use Carbon\Carbon;
use DataTables;

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

}
