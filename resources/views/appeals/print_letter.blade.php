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
            padding: 2rem;
            line-height: 1.6;
        }
        .letter-container { 
            max-width: 800px; 
            margin: 0 auto; 
            background: white;
            padding: 3rem;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header { 
            text-align: center; 
            margin-bottom: 3rem;
            border-bottom: 2px solid #333;
            padding-bottom: 1rem;
        }
        .header h1 { 
            color: #2c3e50; 
            margin: 0;
            font-size: 24px;
        }
        .header h2 { 
            color: #7f8c8d; 
            margin: 0.5rem 0 0 0;
            font-size: 18px;
            font-weight: normal;
        }
        .content { 
            margin-bottom: 2rem; 
        }
        .content p { 
            font-size: 14px; 
            margin-bottom: 1rem;
            text-align: justify;
        }
        .reference { 
            font-weight: bold; 
            margin-bottom: 1rem;
        }
        .signature-section { 
            margin-top: 3rem; 
            text-align: right;
        }
        .signature-line { 
            border-bottom: 1px solid #333; 
            width: 200px; 
            margin: 2rem 0 0.5rem auto;
        }
        .date { 
            margin-top: 2rem; 
            text-align: right;
        }
        .footer { 
            margin-top: 3rem; 
            font-size: 12px; 
            color: #7f8c8d;
            text-align: center;
        }
        @media print {
            body { margin: 0; padding: 1rem; }
            .letter-container { box-shadow: none; }
            .download-section { display: none; }
        }
        .download-section {
            text-align: center;
            margin: 2rem 0;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .download-btn {
            background: #007bff;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            margin: 0 10px;
        }
        .download-btn:hover {
            background: #0056b3;
        }
        .print-btn {
            background: #28a745;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            margin: 0 10px;
        }
        .print-btn:hover {
            background: #1e7e34;
        }
    </style>
</head>
<body>
    <div class="download-section">
        <h3>📄 Surat Kelulusan Siap</h3>
        <p>Surat kelulusan telah dijana. Anda boleh memuat turun sebagai PDF atau mencetak terus.</p>
        <a href="{{ route('appeals.download_letter_pdf', $appeal->id) }}" class="download-btn">
            <i class="fas fa-download"></i> Muat Turun PDF
        </a>
        <button class="print-btn" onclick="window.print()">
            <i class="fas fa-print"></i> Cetak Surat
        </button>
    </div>

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

            @if($perakuan && $perakuan->type === 'kvp08')
                <p><strong>Subjek: Kelulusan Permohonan Lanjutan Tempoh Sah Kelulusan Perolehan</strong></p>
                
                <p>Dengan hormatnya dimaklumkan bahawa permohonan lanjutan tempoh sah kelulusan perolehan anda telah diluluskan oleh pihak kami.</p>
                
                @php
                    $kvp08Applications = \App\Models\Kpv08Application::where('appeal_id', $perakuan->appeal_id)->get();
                @endphp
                
                @if($kvp08Applications->count() > 0)
                    <p>Permohonan lanjutan tempoh untuk permit berikut telah diluluskan:</p>
                    <ul>
                        @foreach($kvp08Applications as $kvp08App)
                            <li><strong>{{ $kvp08App->permit->permit_number }}</strong> - {{ $kvp08App->permit->getApplicationCountText() }}</li>
                        @endforeach
                    </ul>
                @endif
            @else
                <p><strong>Subjek: Kelulusan Permohonan Pindaan Syarat Lesen Perikanan</strong></p>
                
                <p>Dengan hormatnya dimaklumkan bahawa permohonan pindaan syarat lesen perikanan anda telah diluluskan oleh pihak kami.</p>
            @endif

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

    <script>
        // Auto-focus on download button when page loads
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.download-btn').focus();
        });
    </script>
</body>
</html> 