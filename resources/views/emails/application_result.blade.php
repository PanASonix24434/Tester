<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keputusan Permohonan</title>

    <style>
        body {
            background-color: #ddd;
            font-family: Arial;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }

        table {
            background-color: #fff;
            width: 100%;
            padding: 20px;
            border-spacing: 0;
            border-collapse: collapse;
        }

        .content {
            margin: 0 30px;
        }

        h1 {
            text-align: center;
        }

        .logo {
            text-align: center;
        }

        .email-body {
            text-align: justify;
            line-height: 1.5;
        }

        .footer {
            font-size: 12px;
            text-align: left;
            color: #888;
            margin-top: 20px;
        }
    </style>

</head>

<body>

    <?php
    // Use the public path instead of asset() to ensure images are accessible outside the app.
    $imageUrl = public_path('images/logo_jata_dof.jpeg');
    $message->embed($imageUrl, 'Acra Logo');
    ?>

    <div class="logo">
        <img src="{{ $message->embed($imageUrl) }}" alt="DOF Logo" height="130" width="200">
    </div>

    <table cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td>
                <!-- Email content here -->
                <div class="content">
                    <p class="email-body"><strong>Assalamualaikum & Salam Sejahtera,</strong></p>
                    <p class="email-body">{{ strtoupper($resultDetails['applicant_name']) }},</p>

                    <p class="email-body">Dengan segala hormatnya perkara di atas adalah dirujuk.</p>
                    <p class="email-body">Adalah dimaklumkan bahawa anda menerima mesej hebahan ini dari <b>Sistem e-Lesen 2.0 Jabatan Perikanan Malaysia</b>.</p>

                    <p class="email-body"><strong>Butiran Permohonan:</strong></p>
                    <ul class="email-body">
                        <li><strong>No. Rujukan:</strong> {{ $resultDetails['no_rujukan'] }}</li>
                        <li><strong>Jenis Permohonan:</strong> {{ $resultDetails['application_type'] }}</li>                       
                        <li><strong>Nota:</strong> {{ $resultDetails['ulasan'] }}</li>
                        @if (!empty($resultDetails['pin_number']))
                            <li><strong>No. Pin:</strong> {{ $resultDetails['pin_number'] }}</li>
                        @endif
                        <li><strong>Alamat Pejabat:</strong> {{  strtoupper($resultDetails['office_address']) }}</li>
                    </ul>
                  
                    <p class="email-body">Sila hadir ke alamat pejabat di atas untuk melengkapkan urusan permohonan anda.</p>

                    <p class="email-body">Sekian, Terima Kasih.</p>
                    <p class="email-body">Daripada,</p>

                    <p class="email-body">
                        Pentadbir Sistem e-Lesen 2.0, <br>
                        Jabatan Perikanan Malaysia, <br>
                        Aras 1-6, Blok Menara 4G2, <br>
                        Presint 4, 62628 Putrajaya.
                    </p>

                    <div class="footer">
                        <p><b><i>Nota : Ini adalah maklum balas automatik. Anda tidak perlu membalas emel ini.</i></b></p>
                    </div>
                </div>
            </td>
        </tr>
    </table>

</body>

</html>
