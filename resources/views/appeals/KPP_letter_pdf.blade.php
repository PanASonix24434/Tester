<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Permohonan</title>
    <style>
        body { 
            font-family: 'Times New Roman', serif; 
            margin: 0; 
            padding: 20px;
            line-height: 1.6;
            font-size: 12px;
        }
        .report-container { 
            max-width: 100%;
            background: white;
        }
        .header { 
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .jata-logo {
            width: 60px;
            height: auto;
            margin-bottom: 10px;
        }
        .ministry-name {
            font-size: 14px;
            font-weight: bold;
            color: #000;
            margin: 3px 0;
            text-transform: uppercase;
        }
        .department-name {
            font-size: 16px;
            font-weight: bold;
            color: #000;
            margin: 3px 0;
            text-transform: uppercase;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #000;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .info-table td {
            padding: 5px 0;
            border: none;
            vertical-align: top;
            font-size: 11px;
        }
        .info-table td:first-child {
            font-weight: bold;
            width: 150px;
        }
        .decision-box {
            border: 2px solid #000;
            min-height: 80px;
            padding: 10px;
            margin: 8px 0;
            background-color: #f9f9f9;
        }
        .comments-box {
            border: 2px solid #000;
            min-height: 100px;
            padding: 10px;
            margin: 8px 0;
            background-color: #f9f9f9;
        }
        .signature-section {
            margin-top: 25px;
        }
        .signature-line {
            border-bottom: 1px solid #000;
            width: 250px;
            margin: 15px 0 3px 0;
        }
        .signature-label {
            font-weight: bold;
            margin: 8px 0 3px 0;
            font-size: 11px;
        }
        .date-placeholder {
            font-family: monospace;
            letter-spacing: 1px;
        }
        .status-content {
            margin: 12px 0;
        }
        .status-content p {
            font-size: 11px;
            margin-bottom: 8px;
            text-align: justify;
            line-height: 1.5;
        }
        .status-item {
            margin: 3px 0;
            padding: 0;
        }
        .status-item p {
            margin-bottom: 5px;
        }
        .footer {
            margin-top: 30px;
            font-size: 8px;
            color: #666;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <x-watermark />
    <div class="report-container">
        <div class="header">
            <img src="{{ public_path('images/jata.png') }}" alt="Jata Negara" class="jata-logo">
            <div class="ministry-name">KEMENTERIAN PERTANIAN DAN KETERJAMINAN MAKANAN</div>
            <div class="department-name">JABATAN PERIKANAN MALAYSIA</div>
        </div>

        <div class="section">
            <div class="section-title">1. Laporan Permohonan</div>
            <table class="info-table">
                <tr>
                    <td>No. Rujukan:</td>
                    <td>{{ $appeal->kpp_ref_no ?? 'TEST-KDP_CONFIRM_INSPECTION-1-' . date('Ymd') }}</td>
                </tr>
                <tr>
                    <td>Tarikh Permohonan:</td>
                    <td>{{ $appeal->created_at ? $appeal->created_at->format('d/m/Y') : date('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td>Nama Pemohon:</td>
                    <td>{{ $applicant->name ?? '1' }}</td>
                </tr>
                <tr>
                    <td>No. KP/Pendaftaran:</td>
                    <td>{{ $applicant->username ?? '111111111111' }}</td>
                </tr>
                <tr>
                    <td>Jenis Permohonan:</td>
                    <td>
                        @if($perakuan && $perakuan->type === 'kvp08')
                            Lanjutan Tempoh Sah Kelulusan Perolehan Vesel
                        @elseif($perakuan && $perakuan->jenis_pindaan_syarat === 'Jenis bahan binaan vesel')
                            Pindaan Syarat Kelulusan (Jenis Bahan Binaan Vesel)
                        @elseif($perakuan && $perakuan->jenis_pindaan_syarat === 'Tukar Jenis Peralatan')
                            Pindaan Syarat Kelulusan (Pertukaran Peralatan)
                        @elseif($perakuan && $perakuan->jenis_pindaan_syarat === 'Pangkalan')
                            Pindaan Syarat Kelulusan (Pertukaran Pangkalan)
                        @else
                            Lesen Vessel MPPI (Terpakai)
                        @endif
                    </td>
                </tr>
                @if($appeal->no_siri)
                <tr>
                    <td>No. Siri:</td>
                    <td>{{ $appeal->no_siri }}</td>
                </tr>
                @endif
                @if($appeal->zon)
                <tr>
                    <td>Zon:</td>
                    <td>{{ $appeal->zon }}</td>
                </tr>
                @endif
            </table>
        </div>

        <div class="section">
            <div class="section-title">2. Status Permohonan</div>
            
            <div class="status-content">
                <p><strong>Dengan hormatnya, saya merujuk kepada permohonan di atas dan ingin memaklumkan status terkini permohonan tersebut seperti berikut:</strong></p>
                
                <div class="status-item">
                    <p><strong>1. Hantar Permohonan</strong></p>
                    <p>Permohonan telah dihantar pada <strong>{{ $appeal->created_at ? $appeal->created_at->format('d F Y, h:i A') : '-' }}</strong> oleh <strong>{{ $appeal->applicant->name ?? 'Pemohon' }}</strong>.</p>
                    <p>Status: <strong>DIHANTAR</strong></p>
                    <p>Ulasan: {{ $appeal->perakuan->nyatakan ?? 'PERMOHONAN DITERIMA SISTEM.' }}</p>
                </div>

                <div class="status-item">
                    <p><strong>2. Semakan Dokumen</strong></p>
                    <p>Semakan dokumen telah dilakukan pada <strong>{{ $appeal->updated_at ? $appeal->updated_at->format('d F Y, h:i A') : '-' }}</strong> oleh <strong>{{ $appeal->pplReviewer->name ?? 'PN. SITI BINTI OMAR' }}</strong>.</p>
                    <p>Status: <strong>
                        @if(strtolower($appeal->ppl_status) === 'lengkap')
                            LENGKAP
                        @else
                            TIDAK LENGKAP
                        @endif
                    </strong></p>
                    <p>Ulasan: {{ $appeal->ppl_comments ?? 'Tiada ulasan' }}</p>
                </div>

                @if($appeal->kcl_comments || $appeal->kcl_status)
                <div class="status-item">
                    <p><strong>3. Jadual Pemeriksaan</strong></p>
                    <p>Jadual pemeriksaan telah disemak pada <strong>{{ $appeal->updated_at ? $appeal->updated_at->format('d F Y, h:i A') : '-' }}</strong> oleh <strong>{{ $appeal->kclReviewer->name ?? 'KETUA DAERAH PERIKANAN' }}</strong>.</p>
                    <p>Status: <strong>
                        @if(strtolower($appeal->kcl_status) === 'disokong')
                            DISOKONG
                        @elseif(strtolower($appeal->kcl_status) === 'tidak disokong')
                            TIDAK DISOKONG
                        @elseif(strtolower($appeal->kcl_status) === 'tidak lengkap')
                            TIDAK LENGKAP
                        @else
                            DIJADUALKAN
                        @endif
                    </strong></p>
                    <p>Ulasan: {{ $appeal->kcl_comments ?? 'Tiada ulasan' }}</p>
                </div>
                @endif

                <p><strong>Permohonan ini kini menunggu keputusan daripada Ketua Pengarah Perikanan (KPP) untuk tindakan selanjutnya.</strong></p>
            </div>
        </div>

        <div class="section">
            <div class="section-title">3. Keputusan KPP</div>
            <div class="decision-box">
                <!-- Decision content will be filled by KPP -->
            </div>
        </div>

        <div class="section">
            <div class="section-title">4. Ulasan KPP</div>
            <div class="comments-box">
                <!-- Comments will be filled by KPP -->
            </div>
        </div>

        <div class="section">
            <div class="section-title">5. Tandatangan KPP</div>
            <div class="signature-section">
                <div class="signature-line"></div>
                <div class="signature-line"></div>
                <div class="signature-label">Jawatan:</div>
                <div class="signature-label">Tarikh: <span class="date-placeholder">_ / _ / _</span></div>
            </div>
        </div>

        <div class="footer">
            Laporan ini dijana secara automatik oleh Sistem eLesen. Tiada tandatangan diperlukan bagi tujuan pengesahan elektronik.
        </div>
    </div>
</body>
</html>
