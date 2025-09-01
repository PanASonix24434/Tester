<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <title>Borang Permohonan Lesen Nelayan / Vesel</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            margin: 20px;
        }

        h1,
        h2 {
            text-align: center;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 5px;
            vertical-align: top;
            border: 1px solid #000;
            /* <-- This makes full border */
        }

        .section-title {
            font-size: 10px;
            font-weight: bold;
            text-decoration: underline;
            background-color: #f0f0f0;
        }

        .signature-section td {
            padding-top: 30px;
            border: none;
        }

        .no-border {
            border: none !important;
        }

        ul {
            margin: 0;
            padding-left: 20px;
        }
    </style>
</head>

<body>

    <table>
        <tr>
            <td colspan="2" class="no-border" style="text-align: center;">
                <h1 style="font-size:16px;">Jabatan Perikanan Malaysia</h1>
                <h2 style="font-size:14px;">Borang Permohonan </h2>
            </td>
        </tr>

        {{-- Maklumat Peribadi --}}
        <tr>
            <td colspan="2" class="section-title">Maklumat Peribadi</td>
        </tr>
        <tr>
            <td>Nama Penuh</td>
            <td>{{ $personalInfo['name'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Nombor Kad Pengenalan</td>
            <td>{{ $personalInfo['identity_card_number'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Nombor Telefon</td>
            <td>{{ $personalInfo['phone_number'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Nombor Telefon (Kedua)</td>
            <td>{{ $personalInfo['secondary_phone_number_number'] ?? '-' }}</td>
        </tr>

        {{-- Alamat Kediaman --}}
        <tr>
            <td colspan="2" class="section-title">Alamat Kediaman</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>{{ $personalInfo['address'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Poskod</td>
            <td>{{ $personalInfo['postcode'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Daerah</td>
            <td>{{ $personalInfo['district'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Negeri</td>
            <td>{{ $personalInfo['state'] ?? '-' }}</td>
        </tr>

        {{-- Alamat Surat-Menyurat --}}
        <tr>
            <td colspan="2" class="section-title">Alamat Surat-Menyurat</td>
        </tr>
        <tr>
            <td>Alamat Surat-Menyurat</td>
            <td>{{ $personalInfo['mailing_address'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Poskod</td>
            <td>{{ $personalInfo['mailing_postcode'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Daerah</td>
            <td>{{ $personalInfo['mailing_district'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Negeri</td>
            <td>{{ $personalInfo['mailing_state'] ?? '-' }}</td>
        </tr>

        {{-- Maklumat Jeti --}}
        <tr>
            <td colspan="2" class="section-title">Maklumat Jeti</td>
        </tr>
        <tr>
            <td>Negeri</td>
            <td>{{ $jettyData['state'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Daerah</td>
            <td>{{ $jettyData['district'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Nama Jeti</td>
            <td>{{ $jettyData['jetty_name'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Sungai</td>
            <td>{{ $jettyData['river'] ?? '-' }}</td>
        </tr>

        {{-- Maklumat Sebagai Nelayan --}}
        <tr>
            <td colspan="2" class="section-title">Maklumat Sebagai Nelayan</td>
        </tr>
        <tr>
            <td>Tahun Menjadi Nelayan</td>
            <td>{{ $fishermanInfo['year_become_fisherman'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Tempoh Menjadi Nelayan</td>
            <td>{{ $fishermanInfo['becoming_fisherman_duration'] ?? '-' }} Tahun</td>
        </tr>
        <tr>
            <td>Pendapatan Tahunan Menangkap Ikan</td>
            <td>RM {{ number_format($fishermanInfo['estimated_income_yearly_fishing'] ?? 0, 2) }}</td>
        </tr>
        <tr>
            <td>Pendapatan Dari Pekerjaan Lain</td>
            <td>RM {{ number_format($fishermanInfo['estimated_income_other_job'] ?? 0, 2) }}</td>
        </tr>

        {{-- Maklumat Peralatan --}}
        <tr>
            <td colspan="2" class="section-title">Maklumat Peralatan</td>
        </tr>

        {{-- Peralatan Utama --}}
        @if (!empty($mainEquipments))
        <tr>
            <td>Peralatan Utama</td>
            <td>
                <ul>
                    @foreach ($mainEquipments as $equipment)
                    <li>{{ $equipment['name'] ?? '-' }} ({{ $equipment['quantity'] ?? 0 }} unit)</li>
                    @endforeach
                </ul>
            </td>
        </tr>
        @endif

        {{-- Peralatan Tambahan --}}
        @if (!empty($additionalEquipments))
        <tr>
            <td>Peralatan Tambahan</td>
            <td>
                <ul>
                    @foreach ($additionalEquipments as $equipment)
                    <li>{{ $equipment['name'] ?? '-' }} ({{ $equipment['quantity'] ?? 0 }} unit)</li>
                    @endforeach
                </ul>
            </td>
        </tr>
        @endif


        {{-- Maklumat Vesel --}}
        <tr>
            <td colspan="2" class="section-title">Maklumat Vesel</td>
        </tr>
        <tr>
            <td>Ada Vesel</td>
            <td>{{ ($vesselData['has_vessel'] ?? '-') == 'yes' ? 'Ya' : 'Tidak' }}</td>
        </tr>

        @if(($vesselData['has_vessel'] ?? '') === 'yes')
        <tr>
            <td>No Pendaftaran</td>
            <td>{{ $vesselData['vessel_registration_number'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Jenis Kulit</td>
            <td>{{ $vesselData['hull_type'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Panjang</td>
            <td>{{ $vesselData['length'] ?? '-' }} m</td>
        </tr>
        <tr>
            <td>Lebar</td>
            <td>{{ $vesselData['width'] ?? '-' }} m</td>
        </tr>
        <tr>
            <td>Kedalaman</td>
            <td>{{ $vesselData['depth'] ?? '-' }} m</td>
        </tr>
        <tr>
            <td>Ada Enjin</td>
            <td>{{ ($vesselData['has_engine'] ?? '-') == 'yes' ? 'Ya' : 'Tidak' }}</td>
        </tr>

        @if(($vesselData['has_engine'] ?? '') === 'yes')
        <tr>
            <td>Model Enjin</td>
            <td>{{ $vesselData['engine_model'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Kapasiti Enjin</td>
            <td>{{ $vesselData['horsepower'] ?? '-' }}</td>
        </tr>
        @endif
        @else
        <tr>
            <td>Jenis Pengangkutan</td>
            <td>{{ $vesselData['transport_type'] ?? '-' }}</td>
        </tr>
        @endif

        {{-- Tandatangan --}}
        <tr class="signature-section">
            <td colspan="2" class="no-border">
                <table style="width: 100%; border: none;  ">
                    <tr>
                        <td style="width: 50%; border: none; text-align: left;">
                            <div>Tarikh: _____________________</div>
                            <div style="margin-top: 40px;">___________________________</div>
                            <div>Tandatangan <br> Pemohon</div>
                        </td>
                        <td style="width: 50%; border: none; text-align: right;">
                            <div>Tarikh: _____________________</div>
                            <div style="margin-top: 40px;">___________________________</div>
                            <div>Tandatangan <br> Penghulu / Ketua Kampung <br> / JKKK / JKOA / MyKP</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>

</body>

</html>
