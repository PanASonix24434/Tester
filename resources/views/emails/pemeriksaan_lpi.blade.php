<!DOCTYPE html>
<html>

<head>
    <title>Pemberitahuan Pemeriksaan Vesel</title>
</head>

<body>
    <h1>Pemberitahuan Pemeriksaan Vesel</h1>
    <p>Assalamualaikum dan Salam Sejahtera,</p>

    <p>Kami ingin memaklumkan bahawa permohonan anda sedang di proses</p>

    <p><strong>Butiran Permohonan:</strong></p>
    <ul>
        <li>No Rujukan: {{ $resultDetails['no_rujukan'] }}</li>
        <li>Nama: {{ $resultDetails['applicant_name'] }}</li>
        <li>No.K/P: {{ $resultDetails['applicant_icno'] }}</li>
        <li>Jenis Permohonan: {{ $resultDetails['application_type'] }}</li>
        <li>Tarikh Surat Di Keluarkan: {{ $resultDetails['approval_date'] }}</li>
    </ul>

    <p><strong>Maklumat Pemeriksaan:</strong></p>
    <p>Anda dikehendaki hadir ke alamat berikut untuk pemeriksaan:</p>
    <ul>
        <li>Alamat Pejabat: {{ strtoupper($resultDetails['office_address']) }}</li>
        <li>Tarikh Pemeriksaan: {{ $resultDetails['inspection_date'] }}</li>

    </ul>

    <p>Sila pastikan anda membawa semua dokumen yang diperlukan seperti yang telah dimaklumkan.</p>

    <p>Untuk sebarang pertanyaan lanjut, sila hubungi kami di {{ config('app.support_email', 'support@example.com') }}.</p>
 
</body>

</html>