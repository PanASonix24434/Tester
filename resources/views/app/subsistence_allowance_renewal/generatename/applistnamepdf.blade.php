<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senarai Permohonan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <h3 style="text-align: center;">Senarai Permohonan</h3>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Status Kuota</th>
                <th>Tarikh Permohonan</th>
                <th>No Fail</th>
                <th>Nama Pemohon</th>
                <th>No Kad Pengenalan</th>
                <th>Jenis Permohonan</th>
                <th>Negeri</th>
                <th>Daerah</th>
                <th>Tangkapan Bulanan (KG)</th>
                <th>Pendapatan Sebulan (RM)</th>
                <th>Hasil Tangkapan (RM)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($applications as $index => $app)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ strtoupper($app->status_quota) }}</td>
                    <td>{{ \Carbon\Carbon::parse($app->created_at)->format('d M Y') }}</td>
                    <td>{{ $app->registration_no }}</td>
                    <td>{{ $app->fullname }}</td>
                    <td>{{ $app->icno }}</td>
                    
                    @if($app->type_registration == 'Renew')
                    <td>Pembaharuan</td>
                    @else
                    <td>{{ $app->type_registration}}</td>
                    @endif

                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>{{ $app->tot_incomefish}}</td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
