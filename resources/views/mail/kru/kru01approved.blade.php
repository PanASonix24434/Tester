<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Pengguna</title>

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
                <p style="margin-left:30px; margin-right:30px; margin-top:20px;">Assalamualaikum & Salam Sejahtera YBhg. Dato/Dr./Tuan/Puan,</p>
                <p style="margin-left:30px; margin-right:30px;">Dengan segala hormatnya perkara di atas adalah dirujuk.</p>
                <p style="margin-left:30px; margin-right:30px;">Adalah dimaklumkan bahawa Permohonan Kad Pendaftaran Nelayan dalam <b>Sistem eLesen Perikanan Jabatan Perikanan Malaysia</b> telah diluluskan.</p>
                <p style="margin-left:30px; margin-right:30px;">Maklumat Permohonan : </b></p>
                <p style="margin-left:30px; margin-right:30px;">1. Nombor Rujukan : <b>{{ $ref_no }}</b></p>
                <p style="margin-left:30px; margin-right:30px;">2. No. Vesel : <b>{{ $vessel }}</b></p>
                <p style="margin-left:30px; margin-right:30px;">3. Nama : <b>{{ $kru }}</b></p>
                <p style="margin-left:30px; margin-right:30px;">4. No. Kad Pengenalan : <b>{{ $kru_ic }}</b></p>
                <p style="margin-left:30px; margin-right:30px;">5. Tarikh Diluluskan : <b>{{ $start_date }}</b></p>
                <p style="margin-left:30px; margin-right:30px;">6. Tarikh Tamat : <b>{{ $end_date }}</b></p>
                <br/>
                <p style="margin-left:30px; margin-right:30px;">Sila ke {{$entity_name}} untuk membuat pembayaran dan cetakan Kad Pendaftaran Nelayan. Berikut merupakan nombor pin yang perlu diserahkan kepada pegawai di pejabat berkenaan untuk tujuan cetakan.</a></p>
                <p style="margin-left:30px; margin-right:30px;">1. Nombor Pin : <b>{{ $pin_number }}</b></p>

                <p style="margin-left:30px; margin-right:30px;">Sekian, Terima Kasih.</p>
                <p style="margin-left:30px; margin-right:30px;">Daripada,</p>
				<br>
                <p style="margin-left:30px; margin-right:30px;">
                Pentadbir Sistem eLesen Perikanan, <br>
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
