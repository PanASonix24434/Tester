<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <title>Borang Permohonan Pendaftaran Nelayan Darat</title>
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

    <!-- HEADER SECTION - SEPARATE TABLE -->
    <table style="width: 100%; border: none; margin-bottom: 10px;">
        <tr>
            <!-- Left Logo -->
            <td style="width: 20%; text-align: left; border: none;">
                <img src="{{ public_path('images/jata - Copy.png') }}" alt="Left Logo" style="height: 50px;">
            </td>

            <!-- Center Title -->
            <td style="width: 60%; text-align: center; border: none;">
                <div style="font-size:16px; font-weight: bold;">Jabatan Perikanan Malaysia</div>
                <div style="font-size:14px;">Borang Permohonan Pendaftaran Nelayan Darat</div>
            </td>

            <!-- Right Logo -->
            <td style="width: 20%; text-align: right; border: none;">
                <img src="{{ public_path('images/dof-logo.png') }}" alt="Right Logo" style="height: 50px;">
            </td>
        </tr>
    </table>
    <br>

    <table class="">

        <tr>
            <td colspan="2" class="section-title">MAKLUMAT PERIBADI</td>
        </tr>

        <tr class="no-border">
            <td class="no-border" style="width: 35%;">Nama Penuh</td>
            <td class="no-border">: {{ $personalInfo['name'] ?? '-' }}</td>
        </tr>
        <tr class="no-border">
            <td class="no-border">Nombor Kad Pengenalan</td>
            <td class="no-border">: {{ $personalInfo['icno'] ?? '-' }}</td>
        </tr>
        <tr class="no-border">
            <td class="no-border">Nombor Telefon</td>
            <td class="no-border">: {{ $personalInfo['phone_number'] ?? '-' }}</td>
        </tr>
        <tr class="no-border">
            <td class="no-border">Nombor Telefon (Kedua)</td>
            <td class="no-border">: {{ $personalInfo['secondary_phone_number'] ?? '-' }}</td>
        </tr>

        {{-- Alamat Kediaman --}}
        {{-- <tr>
            <td colspan="2" class="section-title">Alamat Kediaman</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>{{ $personalInfo['address'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Poskod</td>
            <td>{{ $personalInfo['poskod'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Daerah</td>
            <td>{{ $personalInfo['district'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Negeri</td>
            <td>{{ $personalInfo['state'] ?? '-' }}</td>
        </tr> --}}

        {{-- <tr>
            <td colspan="2" class="section-title">Alamat Surat-Menyurat</td>
        </tr>
        <tr>
            <td>Alamat Surat-Menyurat</td>
            <td>{{ $personalInfo['mailing_address'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Poskod</td>
            <td>{{ $personalInfo['secondary_postcode '] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Daerah</td>
            <td>{{ $personalInfo['secondary_district'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Negeri</td>
            <td>{{ $personalInfo['secondary_state  '] ?? '-' }}</td>
        </tr> --}}

        <tr>
            <td colspan="2" class="section-title">ALAMAT SURAT-MENYURAT</td>
        </tr>

        <tr class="no-border">
            <td class="no-border" style="width: 35%;">Alamat Surat-Menyurat</td>
            <td class="no-border">: {{ $personalInfo['mailing_address'] ?? '-' }}</td>
        </tr>
        <tr class="no-border">
            <td class="no-border">Poskod</td>
            <td class="no-border">: {{ $personalInfo['secondary_postcode '] ?? '-' }}</td>
        </tr>
        <tr class="no-border">
            <td class="no-border">Daerah</td>
            <td class="no-border">: {{ $personalInfo['secondary_district'] ?? '-' }}</td>
        </tr>
        <tr class="no-border">
            <td class="no-border">Negeri</td>
            <td class="no-border">: {{ $personalInfo['secondary_state  '] ?? '-' }}</td>
        </tr>

        <tr>
            <td colspan="2" class="section-title">MAKLUMAT JETI</td>
        </tr>

        <tr class="no-border">
            <td class="no-border" style="width: 35%;">Negeri</td>
            <td class="no-border">: {{ $jettyData['state_name'] ?? '-' }}</td>
        </tr>
        <tr class="no-border">
            <td class="no-border">Daerah</td>
            <td class="no-border">: {{ $jettyData['district_name'] ?? '-' }}</td>
        </tr>
        <tr class="no-border">
            <td class="no-border">Nama Jeti</td>
            <td class="no-border">: {{ $jettyData['jetty_name'] ?? '-' }}</td>
        </tr>
        <tr class="no-border">
            <td class="no-border">Sungai</td>
            <td class="no-border">: {{ $jettyData['river_name'] ?? '-' }}</td>
        </tr>

        <tr>
            <td colspan="2" class="section-title">MAKLUMAT SEBAGAI NELAYAN</td>
        </tr>

        <tr class="no-border">
            <td class="no-border" style="width: 35%;">Tahun Menjadi Nelayan</td>
            <td class="no-border">: {{ $fishermanInfo['year_become_fisherman'] ?? '-' }}</td>
        </tr>
        <tr class="no-border">
            <td class="no-border">Tempoh Menjadi Nelayan</td>
            <td class="no-border">: {{ $fishermanInfo['becoming_fisherman_duration'] ?? '-' }} Tahun</td>
        </tr>
        <tr class="no-border">
            <td class="no-border">Pendapatan Tahunan Menangkap Ikan</td>
            <td class="no-border">: RM {{ number_format($fishermanInfo['estimated_income_yearly_fishing'] ?? 0, 2) }}
            </td>
        </tr>
        <tr class="no-border">
            <td class="no-border">Pendapatan Dari Pekerjaan Lain</td>
            <td class="no-border">: RM {{ number_format($fishermanInfo['estimated_income_other_job'] ?? 0, 2) }}</td>
        </tr>

        {{-- Maklumat Peralatan --}}
        @if (!empty($mainEquipments) || !empty($additionalEquipments))
        <tr>
            <td colspan="2" class="section-title">MAKLUMAT PERALATAN</td>
        </tr>
        @endif

        {{-- Peralatan Utama --}}
        @if (!empty($mainEquipments))
        <tr class="no-border">
            <td class="no-border" style="width: 35%;">Peralatan Utama</td>
            <td class="no-border">
                :
                <ul style="margin: 0; padding-left: 15px;">
                    @foreach ($mainEquipments as $equipment)
                    <li>{{ $equipment['name'] ?? '-' }} ({{ $equipment['quantity'] ?? 0 }} unit)</li>
                    @endforeach
                </ul>
            </td>
        </tr>
        @endif

        {{-- Peralatan Tambahan --}}
        @if (!empty($additionalEquipments))
        <tr class="no-border">
            <td class="no-border">Peralatan Tambahan</td>
            <td class="no-border">
                :
                <ul style="margin: 0; padding-left: 15px;">
                    @foreach ($additionalEquipments as $equipment)
                    <li>{{ $equipment['name'] ?? '-' }} ({{ $equipment['quantity'] ?? 0 }} unit)</li>
                    @endforeach
                </ul>
            </td>
        </tr>
        @endif

        {{-- Maklumat Vesel --}}
        <tr>
            <td colspan="2" class="section-title">MAKLUMAT VESEL</td>
        </tr>

        <tr class="no-border">
            <td class="no-border" style="width: 35%;">Ada Vesel</td>
            <td class="no-border">: {{ ($vesselData['has_vessel'] ?? '-') == 'yes' ? 'Ya' : 'Tidak' }}</td>
        </tr>

        @if(($vesselData['has_vessel'] ?? '') === 'yes')
        <tr class="no-border">
            <td class="no-border">No Pendaftaran</td>
            <td class="no-border">: {{ $vesselData['vessel_registration_number'] ?? '-' }}</td>
        </tr>
        <tr class="no-border">
            <td class="no-border">Jenis Kulit</td>
            <td class="no-border">: {{ $vesselData['hull_type'] ?? '-' }}</td>
        </tr>
        <tr class="no-border">
            <td class="no-border">Panjang</td>
            <td class="no-border">: {{ $vesselData['length'] ?? '-' }} m</td>
        </tr>
        <tr class="no-border">
            <td class="no-border">Lebar</td>
            <td class="no-border">: {{ $vesselData['width'] ?? '-' }} m</td>
        </tr>
        <tr class="no-border">
            <td class="no-border">Kedalaman</td>
            <td class="no-border">: {{ $vesselData['depth'] ?? '-' }} m</td>
        </tr>
        <tr class="no-border">
            <td class="no-border">Ada Enjin</td>
            <td class="no-border">: {{ ($vesselData['has_engine'] ?? '-') == 'yes' ? 'Ya' : 'Tidak' }}</td>
        </tr>

        @if(($vesselData['has_engine'] ?? '') === 'yes')
        <tr class="no-border">
            <td class="no-border">Jenama Enjin</td>
            <td class="no-border">: {{ $vesselData['engine_brand'] ?? '-' }}</td>
        </tr>
        <tr class="no-border">
            <td class="no-border">Model Enjin</td>
            <td class="no-border">: {{ $vesselData['engine_model'] ?? '-' }}</td>
        </tr>
        <tr class="no-border">
            <td class="no-border">Kapasiti Enjin</td>
            <td class="no-border">: {{ $vesselData['horsepower'] ?? '-' }}</td>
        </tr>
        @endif
        @else
        <tr class="no-border">
            <td class="no-border">Jenis Pengangkutan</td>
            <td class="no-border">: {{ $vesselData['transport_type'] ?? '-' }}</td>
        </tr>
        @endif

         <tr>
            <td colspan="2" class="section-title">PERAKUAN PEMOHON</td>
        </tr>

        <tr>
            <td colspan="2" class="no-border">

                <p>
                    Saya mengaku bahawa maklumat yagn diberikan di atas adalah bena. Jika didapati maklumat yang
                    diberikan ini palsu. Jabatan Perikanan Malaysia berhak menolak menolak permohonan ini.
                </p>
                <br>

                <br>
                <table style="width: 100%; border: none;">
                    <tr>
                        <td style="width: 50%; text-align: left; border: none;">
                            <strong>Tandatangan :</strong> ________________________
                            <br>
                            <small>Nama : </small>
                        </td>
                        <td style="width: 50%; text-align: right; border: none;">
                            <strong>Tarikh :</strong> ________________________
                        </td>
                    </tr>
                </table>
                <br>
            </td>
        </tr>

        <tr>
            <td colspan="2" class="section-title">PERAKUAN PENGESAH</td>
        </tr>

        <tr>
            <td colspan="2" class="no-border">
                <p>
                    Saya *Pengerusi Jawatankuasa Kemajuan dan Keselamatan Kampung / Pengerusi Jawatankuasa Pembangunan
                    dan Keselamatan Kampung (JPKK) /
                    Pengerusi Jawatankuasa Pembangunan dan Keselamatan Kampung Persekutuan (JPKKP) /
                    Pengerusi Majlis Pengurusan Komuniti Kampung (MPKK) / Pegawai Jabatan Kemajuan Orang Asli /
                    Ketua komuniti nelayan kawasan, dengan ini mengesahkan bahawa pemohon adalah merupakan
                    penduduk tetap kampung/kawasan seperti yang dinyatakan di ruangan Butiran Permohonan; dan
                </p>
                <br>
                <ol type="i">
                    <li>
                        Memperakui bahawa ____________________________________ (nama pemohon) adalah seorang Nelayan
                        Darat Tulen sepertimana definisi berikut:
                        <ol type="a">
                            <li>warganegara Malaysia berumur tidak kurang daripada 18 tahun yang terlibat dalam aktiviti
                                penangkapan ikan di perairan sungai; dan</li>
                            <li>menjalankan aktiviti penangkapan ikan tidak kurang daripada 25 hari setiap bulan; dan
                            </li>
                            <li>sekurang-kurangnya 75 peratus jumlah pendapatan adalah daripada penangkapan ikan; dan
                            </li>
                            <li>tiada pekerjaan yang memberikan pendapatan tetap;</li>
                            <li>bebas dari aktiviti penagihan dadah dan menjalani saringan air kencing dari Agensi Anti
                                Dadah Kebangsaan (AADK); dan</li>
                            <li>tidak mempunyai caruman dan akaun KWSP yang aktif; dan</li>
                            <li>mempunyai lesen perkakas atau vesel menangkap ikan atau berdaftar secara pentadbiran
                                dengan Jabatan Perikanan Malaysia bagi Semenanjung Malaysia, Jabatan Pertanian bagi
                                Sarawak dan Jabatan Perikanan Sabah bagi Sabah.</li>
                        </ol>
                    </li>
                    <br>
                    <b>ATAU</b>
                    <br><br>
                    <li>
                        Memperakui bahawa ____________________________________ (nama pemohon) adalah seorang Nelayan
                        Darat Sambilan kerana tidak memenuhi definisi sebagai Nelayan Darat Tulen.
                    </li>
                </ol>
                <br><br>
                <table style="width: 100%; border: none;">
                    <tr>
                        <td style="width: 50%; text-align: left; border: none;">
                            <strong>Tandatangan :</strong> ________________________
                            <br>
                            <small>Nama : </small>
                            <br>
                            <small>Tarikh : </small>
                        </td>
                        <td style="width: 50%; text-align: right; border: none;">
                            <strong>Cop Rasmi :</strong> ________________________
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>

</body>

</html>
