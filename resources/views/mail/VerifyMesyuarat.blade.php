<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Mesyuarat</title>

    <style>

        body { 
            background-color: #ddd;
            font-family: Arial;
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

    <table cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td>
                <!-- Email content here -->
                <p>Assalamualaikum & Salam Sejahtera YBhg. Dato/Dr./Tuan/Puan,</p>
                <p>Dengan segala hormatnya perkara di atas adalah dirujuk.</p>
                <p>Sukacita dimaklumkan bahawa YBhg. Dato/Dr./Tuan/Puan adalah dijemput untuk menghadiri <b>{{ $meeting_title }} </b>  yang akan diadakan mengikut ketetapan seperti berikut:</p>
                <p style="margin-left:20px;"><b>Tarikh:</b>  {{ Carbon\Carbon::parse($meeting_date)->format('d/m/Y') }}</p>
                <p style="margin-left:20px;"><b>Masa:</b> {{ Carbon\Carbon::parse($meeting_time)->format('g:i A') }} </p>
                <p style="margin-left:20px;"><b>Tempat :</b> {{ $meeting_place }} </p>
                <br/>

                <p>Kerjasama dan perhatian dari pihak YBhg. Dato/Dr./Tuan/Puan didahului dengan ucapan terima kasih. </p>
                <p>Sekian, Terima Kasih.</p>
                <br>

                <p><b>"BERKHIDMAT UNTUK NEGARA"</b></p>
                
                <br>
                <p>Saya yang menjalankan amanah,</p>
				<br>
                <p>{{ $name }}</p> 
                <p><br>
                Jabatan Perikanan Malaysia, <br>
                Aras 1-6, Blok Menara 4G2, <br>
                Presint 4, 62628 Putrajaya.
                </p>

                <br><br>
                <p><b><i>Nota : Ini adalah maklum balas automatik. Anda tidak perlu membalas emel ini.</i></b></p>

            </td>
        </tr>
    </table>

</body>
</html>
