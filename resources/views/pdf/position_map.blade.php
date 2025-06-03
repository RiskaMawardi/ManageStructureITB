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
    </style>
</head>
<body>
    <h2>Position Map - RayonID: {{ $rayonID }}</h2>

    <table>
        <thead>
            <tr>
                <th>Position ID</th>
                <th>Employee ID</th>
                <th>Employee Name</th>
                <th>Position</th>
                <th>Start Date</th>
                <th>End Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                    <td>{{ $item->PositionID }}</td>
                    <td>{{ $item->EmpID }}</td>
                    <td>{{ $item->employee->EmployeeName ?? '-' }}</td>
                    <td>{{ $item->EmployeePosition }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->StartDate)->format('d/m/Y H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->EndDate)->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
