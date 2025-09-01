<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Disahkan - E-Lesen Perikanan</title>

    <style>
        body { 
            background-color: #ddd;
            font-family: Arial;
            padding: 15px 20px;
        }

        table {
            background-color: #fff;
            width: 100%;
            max-width: 80%;
            margin: auto;
            padding: 0;
        }
    </style>
</head>
<body>

    <?php
        $imageUrl = public_path('images/logo_jata_dof.jpeg');
        $message->embed($imageUrl, 'DOF Logo');
    ?>

    <div style="text-align: center;">
        <img src="{{ $message->embed($imageUrl) }}" alt="DOF Logo" height="130" width="200">
    </div>

    <table cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td>
                <p style="margin: 20px 30px;">Assalamualaikum & Salam Sejahtera YBhg. Dato/Dr./Tuan/Puan,</p>
                <p style="margin: 0 30px;">Dengan segala hormatnya perkara di atas adalah dirujuk.</p><br>
                <p style="margin: 0 30px;">Adalah dimaklumkan bahawa profil anda telah <b>BERJAYA DISAHKAN</b> dalam Sistem e-Lesen Perikanan.</p><br>
                <p style="margin: 0 30px;"><b>Maklumat Pengguna:</b></p>
                <p style="margin: 0 30px;">1. Nama : <b>{{ $name }}</b></p>
                <p style="margin: 0 30px;">2. No. Kad Pengenalan : <b>{{ $icno }}</b></p>
                <br/>
                <p style="margin: 0 30px;">Anda kini boleh log masuk ke sistem melalui pautan berikut:</p>
                <p style="margin: 0 30px;"><a href="http://10.19.119.137/elesen2/public/login">Log Masuk ke e-Lesen</a></p>

                <p style="margin: 0 30px;">Sekian, Terima Kasih.</p><br>
                <p style="margin: 0 30px;">Daripada,</p><br>
                <br>
                <p style="margin: 0 30px;">
                Pentadbir Sistem e-Lesen 2.0, <br>
                Jabatan Perikanan Malaysia, <br>
                Aras 1-6, Blok Menara 4G2, <br>
                Presint 4, 62628 Putrajaya.
                </p>

                <br>
                <p style="margin: 0 30px; margin-bottom:20px;"><b><i>Nota : Ini adalah maklum balas automatik. Anda tidak perlu membalas emel ini.</i></b></p>
            </td>
        </tr>
    </table>

</body>
</html>
