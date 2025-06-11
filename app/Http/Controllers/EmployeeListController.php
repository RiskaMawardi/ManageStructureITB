<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\EmployeeList;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class EmployeeListController extends Controller
{
    public function index(){
        return view('employee.index');
    }

    public function fetchDataEmployee(Request $request){
        if($request->ajax()){
            $today = Carbon::today()->toDateString();

            $data = EmployeeList::where(function($query) use ($today) {
                $query->whereNull('EndDate')
                    ->orWhere('EndDate', '>', $today);
            });

            return DataTables::of($data)->make(true);
        }
    }

    public function getEmployeeList(){
        $today = Carbon::today()->toDateString();

        $empData = EmployeeList::where(function($query) use ($today) {
            $query->whereNull('EndDate')
                ->orWhere('EndDate', '>', $today);
        })
        ->select('EmployeeID', 'EmployeeName')
        ->distinct()
        ->get();

        return response()->json($empData);
    }



    public function store(Request $request){
        //dd($request->all());
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'status_vacant' => 'required|in:Y,N',
            'join_date' => 'required|date',
        ]);

        //dd("masuk sini");

        $joinDate = Carbon::parse($request->join_date);
        $year = $joinDate->format('Y');    // ex: 2025
        $month = $joinDate->format('m');   // ex: 05

        // Prefix tetap IB
        $prefix = 'IB';

        // Kode default setelah bulan, fixed "01"
        $defaultCode = '01';

        // Ambil nomor urut terakhir yang sudah ada di bulan dan tahun tersebut
        // Misal EmployeeID: IB20250501xxx
        $lastEmployee = EmployeeList::where('EmployeeID', 'like', $prefix . $year . $month . $defaultCode . '%')
            ->orderBy('EmployeeID', 'desc')
            ->first();

        //dd("masuk sini jg");

        if (!$lastEmployee) {
            // Belum ada employee di bulan dan tahun tersebut, mulai nomor urut 001
            $number = 1;
            //dd("masuk");
        } else {
            // Ambil 3 digit nomor urut terakhir
            $lastNumber = (int)substr($lastEmployee->EmployeeID, -3);
            $number = $lastNumber + 1;
            //dd("sini");
        }

        // Format nomor urut jadi 3 digit dengan leading zero
        $numberPadded = str_pad($number, 3, '0', STR_PAD_LEFT);
        //dd("masuk si");

        // Gabungkan semua bagian jadi EmployeeID
        $employeeID = $prefix . $year . $month . $defaultCode . $numberPadded;
        //dd($employeeID);

        // Simpan data baru
        $employee = new EmployeeList();
        $employee->EmployeeID = $employeeID;
        $employee->EmployeeName = $request->name;
        $employee->EmailID = $request->email;
        $employee->PhoneNumber = $request->phone;
        $employee->StatusVacant = $request->status_vacant;
        $employee->JoinDate = $request->join_date;
        $employee->EmployeeStatus = 'A';
        $employee->EndDate = '4009-12-31';
        $employee->UserID = Auth::user()->name;
        $employee->LastUpdate = Carbon::now();
        $employee->save();

        //dd("ke save"); 

        return redirect()->route('employee.index')->with('success', 'Employee added successfully!');

    }


    public function edit($id)
    {
        $employee = EmployeeList::findOrFail($id);
        return response()->json($employee);
    }

    public function update(Request $request, $id)
    {
        $employee = EmployeeList::findOrFail($id);

        $data = $request->except('EmployeeID', '_token');

        // Convert ISO 8601 datetime to SQL Server compatible format
        if (!empty($data['JoinDate'])) {
            $data['JoinDate'] = Carbon::parse($data['JoinDate'])->format('Y-m-d H:i:s');
        }

        if (!empty($data['EndDate'])) {
            $data['EndDate'] = Carbon::parse($data['EndDate'])->format('Y-m-d H:i:s');
        }

        $data['LastUpdate'] = Carbon::now();

        $employee->update($data);

        if ($request->ajax()) {
            return response()->json(['message' => 'Employee updated successfully.']);
        }

        return response()->json(['message' => 'Employee updated successfully.']);
    }


}
