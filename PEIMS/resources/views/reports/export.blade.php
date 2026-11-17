<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #1e293b; font-size: 10px; }
        h1 { margin-bottom: 4px; color: #065f46; font-size: 20px; }
        p { color: #64748b; }
        table { width: 100%; border-collapse: collapse; margin-top: 18px; }
        th, td { border: 1px solid #cbd5e1; padding: 7px; text-align: left; vertical-align: top; }
        th { background: #dcefe8; color: #064e3b; }
        tr:nth-child(even) { background: #f8fafc; }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>Generated {{ now()->format('M j, Y H:i') }} · {{ $equipment->count() }} records</p>
    <table>
        <thead>
            <tr>
                <th>Equipment name</th>
                <th>Category</th>
                <th>Unit price</th>
                <th>Availability</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($equipment as $item)
                <tr>
                    <td>{{ $item->equipment_name }}</td>
                    <td>{{ ucfirst($item->category) }}</td>
                    <td>${{ number_format((float) $item->unit_price, 2) }}</td>
                    <td>{{ ucfirst($item->availability_status) }}</td>
                    <td>{{ $item->description }}</td>
                </tr>
            @empty
                <tr><td colspan="5">No equipment records match the selected filters.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
