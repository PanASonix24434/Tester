<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memo</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        /* table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; } */
    </style>
</head>
<body>

    <h3 style="text-align: center;">Senarai Permohonan</h3>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Pemohon</th>
                <th>No Kad Pengenalan</th>
                <th>Tarikh Permohonan</th>
            </tr>
        </thead>
        <tbody>
            {{--
            @foreach($applications as $index => $app)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $app->fullname }}</td>
                    <td>{{ $app->icno }}</td>
                    <td>{{ \Carbon\Carbon::parse($app->created_at)->format('d M Y') }}</td>
                </tr>
            @endforeach
            --}}
        </tbody>
    </table>

</body>
</html>
