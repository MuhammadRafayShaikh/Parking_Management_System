<!DOCTYPE html>
<html>

<head>
    <title>Category Report</title>
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
    <h2>Categories Report</h2>

    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Category Name</th>
                <th>Parking Charge</th>
                <th>Category Status</th>
            </tr>
        </thead>
        <tbody>
            @if ($category->count() > 0)
                @foreach ($category as $categories)
                    <tr>
                        <td>{{ $categories->id }}</td>
                        <td>{{ $categories->category_name }}</td>
                        <td>{{ $categories->parking_charge }}</td>
                        <td>{{ $categories->category_status }}</td>

                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-center">No Category Found</td>
                </tr>
            @endif
        </tbody>
    </table>
</body>

</html>
