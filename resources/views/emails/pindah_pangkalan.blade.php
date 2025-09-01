<!DOCTYPE html>
<html>
<head>
    <title>Pemberitahuan Kelulusan Pangkalan</title>
</head>
<body>
    <h1>Pemberitahuan Kelulusan Pangkalan</h1>
    <p>Assalamualaikum dan Salam Sejahtera, {{ $resultDetails['applicant_name'] }},{{ $resultDetails['ic_no'] }},</p>

    <p>Kami ingin memaklumkan bahawa permohonan anda untuk <strong>Pindah Pangkalan</strong> telah mendapat kelulusan dari <strong>{{ $pangkalan['type'] }}</strong>.</p>

    <p><strong>Butiran Permohonan:</strong></p>
    <ul>
        <li><strong>No Rujukan:</strong> {{ $resultDetails['no_rujukan'] }}</li>
        <li><strong>Jenis Permohonan:</strong> {{ $resultDetails['application_type'] }}</li>
        <li><strong>Tarikh Kelulusan:</strong> {{ $resultDetails['approval_date'] }}</li>
    </ul>

    <p><strong>Maklumat {{ $pangkalan['type'] }}:</strong></p>
    <ul>
        <li><strong>Nama Pangkalan:</strong> {{ $pangkalan['name'] }}</li>
        <li><strong>Lokasi:</strong> {{ $pangkalan['location'] }}</li>
        <li><strong>Hubungi:</strong> {{ $pangkalan['contact'] }}</li>
    </ul>

    <p>Sila teruskan dengan proses berikutnya mengikut arahan yang diberikan.</p>

    <p>Untuk pertanyaan lanjut, sila hubungi {{ config('app.support_email', 'support@example.com') }}.</p>

    <p>Terima kasih.</p>

    <p>Yang benar,</p>
    <p>{{ config('app.name') }}</p>
</body>
</html>
