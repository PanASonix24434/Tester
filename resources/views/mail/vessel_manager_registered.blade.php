<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hebahan</title>

    <style>

        body {
            background-color: #ddd;
            font-family: Arial;
            padding-left : 20px;
            padding-right : 20px;
            padding-top : 15px;
            padding-bottom : 15px;
        }

        table {
            background-color: #fff;
            width: 100%;
            max-width: 80%;
            margin: auto;
            padding:0px;
        }

    </style>

</head>
<body>

    <?php
        // Use the public path instead of asset() to ensure images are accessible outside the app.
        $imageUrl = public_path('images/logo_jata_dof.jpeg');
        $message->embed($imageUrl, 'Acra Logo');
    ?>

    <div style="text-align: center;">
        <img src="{{ $message->embed($imageUrl) }}" alt="DOF Logo" height="130" width="200">
    </div>

    <table cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td>
                <!-- Email content here -->
                <p style="margin-left:30px; margin-right:30px; margin-top:20px;">Assalamualaikum & Salam Sejahtera YBhg. Dato/Dr./Tuan/Puan,</p><br>
                <p style="margin-left:30px; margin-right:30px;">Dengan segala hormatnya perkara di atas adalah dirujuk.</p>
                @if (strcasecmp($type, 'new') === 0)
                <p style="margin-left:30px; margin-right:30px;">Adalah dimaklumkan bahawa anda telah didaftarkan menjadi pengurus bagi vesel bernombor {{ $vessel_no }}. Sila log masuk menggunakan No. Kad Pengenalan dan Kata Laluan berikut:</p><br>
                <p style="margin-left:30px; margin-right:30px;">Kata Laluan : <b>{{ $password }}</b></p>
                @else
                <p style="margin-left:30px; margin-right:30px;">Adalah dimaklumkan bahawa anda telah didaftarkan menjadi pengurus bagi vesel bernombor {{ $vessel_no }}.</p>
                @endif
                <br/>
                <p style="margin-left:30px; margin-right:30px;"><a href="{{ route('login') }}" target="_blank">Log Masuk</a></p>
                <br/>

                <p style="margin-left:30px; margin-right:30px;">Sekian, Terima Kasih.</p>
                <p style="margin-left:30px; margin-right:30px;">Daripada,</p>
				<br>
                <p style="margin-left:30px; margin-right:30px;">
                Pentadbir Sistem e-Lesen 2.0, <br>
                Jabatan Perikanan Malaysia, <br>
                Aras 1-6, Blok Menara 4G2, <br>
                Presint 4, 62628 Putrajaya.
                </p>

                <br>
                <p style="margin-left:30px; margin-right:30px; margin-bottom:20px;"><b><i>Nota : Ini adalah maklum balas automatik. Anda tidak perlu membalas emel ini.</i></b></p>

            </td>
        </tr>
    </table>

</body>
</html>
