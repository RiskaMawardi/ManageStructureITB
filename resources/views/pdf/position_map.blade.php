<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Position Map - {{ $rayonID }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .am-row { background-color: #dbeafe; font-weight: bold; }
        .mr-row { background-color: #f0f9ff; }
    </style>
</head>
<body>
        @php
            $ams = $data->filter(fn($item) => $item->EmployeePosition == 'AM');
            $mrs = $data->filter(fn($item) => $item->EmployeePosition == 'MR');
            $rms = $data->filter(fn($item) => $item->EmployeePosition == 'RM');
            // Ambil salah satu AM untuk cari RM-nya
        $firstAM = $ams->first();
        $rm = null;

        if ($firstAM) {
            // Ambil kode region, misalnya dari C2301 → C23
            preg_match('/C\d{3}/', $firstAM->PositionID, $match);
            $areaCode = $match[0] ?? null;
            $regionCode = substr($areaCode, 0, 3); // contoh: C23

            // Cari RM yang PositionID-nya mengandung kode region
            $rm = $rms->first(function($item) use ($regionCode) {
                return strpos($item->PositionID, $regionCode) !== false;
            });
        }
        @endphp
    
    <h2>Position Map - RayonID: {{ $rayonID }}</h2>
     @if($rm)
        <h3>RM: {{ $rm->employee->EmployeeName ?? '-' }} ({{ $rm->PositionID }})</h3>
    @endif


    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Position ID</th>
                <th>Employee ID</th>
                <th>Employee Name</th>
                <th>Position</th>
                <th>Start Date</th>
                <th>End Date</th>
            </tr>
        </thead>
        <tbody>
             @php $no = 1; @endphp <!-- Inisialisasi nomor -->

            @foreach($ams as $am)
                @php
                    // Ambil 4 digit terakhir dari PositionID AM untuk cari MR yang berada di bawahnya
                    $amAreaCode = substr($am->PositionID, -5, 4);
                    $mrBawahan = $mrs->filter(function($mr) use ($amAreaCode) {
                        // Ambil 5 digit terakhir sebelum 2 digit unik dari MR (kode rayon)
                        return strpos($mr->PositionID, $amAreaCode) !== false;
                    });
                @endphp

                <!-- AM -->
                <tr class="am-row">
                     <td>{{ $no++ }}</td> <!-- Nomor -->
                    <td>{{ $am->PositionID }}</td>
                    <td>{{ $am->EmpID }}</td>
                    <td>{{ $am->employee->EmployeeName ?? '-' }}</td>
                    <td>{{ $am->EmployeePosition }}</td>
                    <td>{{ \Carbon\Carbon::parse($am->StartDate)->format('d/m/Y H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($am->EndDate)->format('d/m/Y H:i') }}</td>
                </tr>

                <!-- MR di bawah AM -->
                @foreach($mrBawahan as $mr)
                    <tr class="mr-row">
                        <td>{{ $no++ }}</td> <!-- Nomor -->
                        <td>{{ $mr->PositionID }}</td>
                        <td>{{ $mr->EmpID }}</td>
                        <td>{{ $mr->employee->EmployeeName ?? '-' }}</td>
                        <td>{{ $mr->EmployeePosition }}</td>
                        <td>{{ \Carbon\Carbon::parse($mr->StartDate)->format('d/m/Y H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($mr->EndDate)->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>
