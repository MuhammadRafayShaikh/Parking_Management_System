<!DOCTYPE html>
<html>

<head>
    <title>Vehicle Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2>Incoming Vehicle Report</h2>

    <table>
        <thead>
            <tr>
                <th>Parking Number</th>
                <th>Owner Name</th>
                <th>Vehicle Reg Number</th>
                <th>Vehicle DateTime</th>
                <th>Status</th>
                <th>Parking Charge</th>
            </tr>
        </thead>
        <tbody>
            @if ($vehicle->count() > 0)
                <tr>
                    <td>{{ $vehicle->parking_number }}</td>
                    <td>{{ $vehicle->owner_name }}</td>
                    <td>{{ $vehicle->registration_number }}</td>
                    <td>{{ $vehicle->intime }}</td>
                    <td>{{ $vehicle->status == 1 ? 'Vehicle Out' : 'Vehicle In' }}</td>
                    <td>{{ $vehicle->charges }}</td>
                </tr>
            @else
                <tr>
                    <td colspan="6" class="text-center">No Vehicle Found</td>
                </tr>
            @endif
        </tbody>
    </table>
</body>

</html>
