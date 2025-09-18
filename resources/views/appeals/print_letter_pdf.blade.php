<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Kelulusan KPP</title>
    <style>
        body { 
            font-family: 'Times New Roman', serif; 
            margin: 0; 
            padding: 20px;
            line-height: 1.6;
            font-size: 12px;
        }
        .letter-container { 
            max-width: 100%;
            background: white;
        }
        .header { 
            text-align: center; 
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 { 
            color: #2c3e50; 
            margin: 0;
            font-size: 18px;
        }
        .header h2 { 
            color: #7f8c8d; 
            margin: 5px 0 0 0;
            font-size: 14px;
            font-weight: normal;
        }
        .content { 
            margin-bottom: 20px; 
        }
        .content p { 
            font-size: 11px; 
            margin-bottom: 10px;
            text-align: justify;
        }
        .reference { 
            font-weight: bold; 
            margin-bottom: 10px;
        }
        .signature-section { 
            margin-top: 30px; 
            text-align: right;
        }
        .signature-line { 
            border-bottom: 1px solid #333; 
            width: 150px; 
            margin: 15px 0 5px auto;
        }
        .date { 
            margin-top: 15px; 
            text-align: right;
        }
        .footer { 
            margin-top: 20px; 
            font-size: 10px; 
            color: #7f8c8d;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="letter-container">
        <div class="header">
            <h1>KEMENTERIAN PERIKANAN MALAYSIA</h1>
            <h2>JABATAN PERIKANAN MALAYSIA</h2>
        </div>

        <div class="content">
            <div class="reference">
                <p><strong>Rujukan:</strong> {{ $appeal->kpp_ref_no ?? 'KPP/' . date('Ymd') . '/' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT) }}</p>
                <p><strong>Tarikh:</strong> {{ date('d F Y') }}</p>
            </div>

            <p><strong>Kepada:</strong><br>
            {{ $applicant->name ?? 'Pemohon' }}<br>
            {{ $applicant->email ?? '' }}</p>

            <p><strong>Subjek: Kelulusan Permohonan Pindaan Syarat Lesen Perikanan</strong></p>

            <p>Dengan hormatnya dimaklumkan bahawa permohonan pindaan syarat lesen perikanan anda telah diluluskan oleh pihak kami.</p>

            <p>Permohonan dengan ID: <strong>{{ $appeal->id }}</strong> telah disemak dan diputuskan untuk diluluskan berdasarkan syarat-syarat yang ditetapkan.</p>

            <p>Sila ambil tindakan yang perlu berdasarkan kelulusan ini. Sekiranya terdapat sebarang pertanyaan, sila hubungi pihak kami.</p>

            <p>Sekian, terima kasih.</p>
        </div>

        <div class="signature-section">
            <div class="signature-line"></div>
            <p><strong>{{ $approver->name ?? 'PENGARAH KANAN' }}</strong><br>
            {{ $approver->peranan ?? 'PENGARAH KANAN' }}<br>
            Jabatan Perikanan Malaysia</p>
        </div>

        <div class="date">
            <p>{{ date('d F Y') }}</p>
        </div>

        <div class="footer">
            <p>Surat ini dijana secara automatik oleh Sistem E-Lesen</p>
        </div>
    </div>
</body>
</html>
