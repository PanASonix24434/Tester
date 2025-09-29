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
            margin-bottom:5px;
            border-bottom: 2px solid #333;
            padding-bottom: 0px;
        }
        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            width: 100%;
        }
        .jata-section {
            flex: 0 0 120px;
        }
        .jata-logo {
            width: 100px;
            height: auto;
        }
        .department-info {
            text-align: left;
            flex: 1;
            margin: 0px;
        }
        .contact-info {
            text-align: right;
            flex: 0 0 150px;
            align-self: flex-end;
        }
        .department-info h1 { 
            color: #2c3e50; 
            margin: 0 0 3px 0;
            font-size: 20px;
            font-weight: bold;
        }
        .department-info h2 { 
            color: #2c3e50; 
            margin: 0 0 3px 0;
            font-size: 18px;
            font-weight: bold;
        }
        .department-info h3 {
            color: #2c3e50;
            margin: 3px 0 5px 0;
            font-size: 16px;
            font-weight: bold;
        }
        .english-names {
            font-size: 12px;
            color: #666;
            margin: 0 0 3px 0;
            font-style: italic;
        }
        .address {
            font-size: 11px;
            color: #666;
            margin: 0 0 5px 0;
            line-height: 1.2;
        }
        .contact-info p {
            font-size: 12px;
            margin: 2px 0;
            color: #666;
        }
        .contact-info a {
            color: #007bff;
            text-decoration: none;
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
            margin: 0 0 5px 0;
            text-align: right;
        }
        .reference p {
            margin: 0;
            line-height: 1.2;
        }
        .signature-section { 
            margin-top: 3rem;
        }
        .closing-remark {
            margin: 2rem 0 1rem 0;
            font-size: 14px;
        }
        .malaysia-madani-section {
            text-align: left;
            margin: 2rem 0;
        }
        .malaysia-madani {
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
            margin: 0.5rem 0;
        }
        .berkhidmat-negara {
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
            margin: 0.5rem 0;
        }
        .signature-text {
            margin: 2rem 0 1rem 0;
            font-size: 14px;
        }
        .signature-block {
            text-align: left;
            margin: 2rem 0;
        }
        .signature-line { 
            border-bottom: 1px solid #333; 
            width: 200px; 
            margin: 0 0 0.5rem 0;
        }
        .signature-name {
            font-weight: bold;
            margin: 0.5rem 0;
            font-size: 14px;
        }
        .signature-title {
            margin: 0.2rem 0;
            font-size: 14px;
        }
        .signature-dept {
            margin: 0.2rem 0;
            font-size: 14px;
        }
        .signature-location {
            margin: 0.2rem 0;
            font-size: 14px;
            font-weight: bold;
        }
        .carbon-copy {
            margin-top: 2rem;
        }
        .cc-title {
            font-size: 14px;
            margin: 0 0 0.5rem 0;
        }
        .cc-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .cc-list li {
            font-size: 14px;
            margin: 0.2rem 0;
        }
        .footer { 
            margin-top: 3rem; 
            font-size: 10px; 
            color: #666;
        }
        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }
        .quality-logos {
            display: flex;
            gap: 15px;
        }
        .cert-logo {
            text-align: center;
            flex: 1;
        }
        .cert-image {
            width: 40px;
            height: 40px;
            margin-bottom: 5px;
        }
        .cert-text {
            font-size: 8px;
            color: #666;
            margin: 0;
            line-height: 1.2;
        }
        .department-motto {
            text-align: right;
            flex: 1;
        }
        .motto-main {
            font-size: 12px;
            font-weight: bold;
            color: #2c3e50;
            margin: 0 0 2px 0;
        }
        .motto-english {
            font-size: 10px;
            color: #666;
            margin: 0 0 10px 0;
            font-style: italic;
        }
        .mydof-logo {
            text-align: right;
        }
        .mydof-text {
            font-size: 14px;
            font-weight: bold;
            color: #e74c3c;
            margin: 0;
        }
        .mydof-tagline {
            font-size: 8px;
            color: #666;
            margin: 0;
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
            background-color: #17A2B8;
            color: #000;
            padding: 12px 24px;
            border: 1px solid #ddd;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            margin: 0 10px;
        }
        .download-btn:hover {
            background-color: #17A2B8;
            color: #000;
        }
        .print-btn {
            background-color: #1A73E8;
            color: #000;
            padding: 12px 24px;
            border: 1px solid #ddd;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            margin: 0 10px;
        }
        .print-btn:hover {
            background-color: #1A73E8;
            color: #000;
        }
    </style>
</head>
<body>
    <x-watermark />

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
            <div class="header-top">
                <div class="jata-section">
                    <img src="{{ asset('images/jata.png') }}" alt="Jata Negara" class="jata-logo">
                </div>
                <div class="department-info">
                    <h1>JABATAN PERIKANAN MALAYSIA</h1>
                    <h2>KEMENTERIAN PERTANIAN DAN KETERJAMINAN MAKANAN</h2>
                    <p class="english-names">Department of Fisheries Malaysia<br>Ministry of Agriculture and Food Security</p>
                    <h3>PEJABAT KETUA PENGARAH PERIKANAN</h3>
                    <p class="address">ARAS 6, BLOK 4G2, WISMA TANI,<br>NO. 30, PERSIARAN PERDANA, PRESINT 4,<br>62628 PUTRAJAYA.</p>
                </div>
                <div class="contact-info">
                    <p>03-88704408</p>
                    <p>03-8889 1233</p>
                    <p><a href="https://www.dof.gov.my">https://www.dof.gov.my</a></p>
                </div>
            </div>
        </div>

        <div class="reference">
            <p><strong>Ruj. Kami:</strong> {{ $appeal->kpp_ref_no ?? 'Prk. ML.50/8 (LD) 921 (14)' }}</p>
            <p><strong>Tarikh:</strong> {{ date('d F Y') }}</p>
        </div>

        <div class="content">

            {{ $applicant->name ?? 'DH Bentara Setia Sdn Bhd.' }}<br>
            @if($applicant && $applicant->address1)
                {{ $applicant->address1 }}<br>
                @if($applicant->address2)
                    {{ $applicant->address2 }}<br>
                @endif
                @if($applicant->address3)
                    {{ $applicant->address3 }}<br>
                @endif
                @if($applicant->postcode && $applicant->city)
                    {{ $applicant->postcode }} {{ $applicant->city }}<br>
                @endif
                @if($applicant->state)
                    <strong>{{ $applicant->state }}</strong>
                @endif
            @else
                No.38-2F, Jalan Setia Perdana BB U13/BB<br>
                Seksyen U13, Setia Alam<br>
                40170 Shah Alam<br>
                <strong>SELANGOR DARUL EHSAN</strong>
            @endif
            </p>

            <p><strong>Tuan,</strong></p>

            @if($perakuan && $perakuan->type === 'kvp08')
                {{-- KVP08: Lanjut Tempoh Sah Kelulusan Perolehan --}}
                <p><strong>PERMOHONAN LANJUTAN TEMPOH SAH KELULUSAN PEROLEHAN VESEL DAN PERALATAN MENANGKAP IKAN LAUT DALAM (ZON C2) UNIT BAHARU BAGI TUJUAN PELESENAN - NO. SIRI: 1178</strong></p>
                
                <p>Dengan hormatnya, saya merujuk perkara di atas.</p>
                
                <p>2. Jabatan Perikanan Malaysia (DOF) telah menerima permohonan tuan untuk melanjutkan tempoh sah kelulusan perolehan vesel dan peralatan menangkap ikan laut dalam (zon C2) unit baharu bagi tujuan pelesenan yang telah diluluskan sebelumnya.</p>
                
                <p>3. Berdasarkan permohonan yang dikemukakan dan setelah meneliti justifikasi yang diberikan, DOF bersetuju untuk melanjutkan tempoh sah kelulusan perolehan vesel berkenaan dengan syarat-syarat yang telah ditetapkan.</p>
                
                <p>4. Kelulusan lanjutan tempoh ini adalah tertakluk kepada pematuhan segala dasar dan syarat yang ditetapkan oleh DOF. Tuan dinasihatkan agar sentiasa mematuhi segala peraturan yang berkaitan dengan perolehan vesel penangkapan ikan laut dalam (zon C2).</p>
                
                <p>5. DOF tidak dapat mempertimbangkan pengeluaran lesen baharu untuk vesel berkenaan sekiranya terdapat pelanggaran dasar dan syarat pada masa hadapan. Kelulusan juga akan terbatal dengan sendirinya sekiranya tuan gagal mendaftar dan melesenkan vesel berkenaan dalam tempoh masa yang telah ditetapkan.</p>
                
                <p>6. Segala kerjasama tuan berhubung perkara ini didahului dengan ucapan ribuan terima kasih.</p>
                
            @elseif($perakuan && $perakuan->jenis_pindaan_syarat === 'Jenis bahan binaan vesel')
                {{-- Jenis Bahan Binaan Vesel --}}
                <p><strong>PERMOHONAN MEMINDA SYARAT KELULUSAN (JENIS BAHAN BINAAN VESEL) BAGI SIJIL KELULUSAN PEROLEHAN VESEL DAN PERALATAN MENANGKAP IKAN LAUT DALAM (ZON C2) UNIT BAHARU BAGI TUJUAN PELESENAN - NO. SIRI: 1178</strong></p>
                
                <p>Dengan hormatnya, saya merujuk perkara di atas.</p>
                
                <p>2. Jabatan Perikanan Malaysia (DOF) telah menerima permohonan tuan untuk menukar jenis bahan binaan vesel seperti yang ditetapkan dalam surat kelulusan perolehan vesel dan peralatan menangkap ikan laut dalam (zon C2) unit baharu bagi tujuan pelesenan yang mensyaratkan perolehan vesel adalah secara bina baharu dalam negara dengan mematuhi garis panduan pemodenan vesel penangkapan ikan DOF, di mana binaan kayu adalah tidak dibenarkan.</p>
                
                <p>3. Berdasarkan permohonan yang dikemukakan, DOF bersetuju untuk mempertimbangkan permohonan tuan selaras dengan Pekeliling Pelesenan Bil. 4 Tahun 2022 : "Pemakluman Berhubung Kebenaran Perolehan Vesel Kayu Bina Baharu Untuk Didaftar Dan Dilesenkan Sebagai Vesel Penangkapan Ikan Laut Dalam (ZON C2)" dengan syarat-syarat yang telah ditetapkan.</p>
                
                <p>4. Justeru, tuan diminta untuk mengemukakan Pelan Susun Atur Am Vesel (General Arrangement / GA) yang ingin dibina dan laporan kemajuan pembinaan vesel untuk semakan serta pemantauan pihak DOF seterusnya.</p>
                
                <p>5. Tuan dinasihatkan agar sentiasa mematuhi segala dasar dan syarat yang ditetapkan oleh DOF mengikut kelulusan perolehan vesel penangkapan ikan laut dalam (zon C2). DOF tidak dapat mempertimbangkan pengeluaran lesen baharu untuk vesel berkenaan sekiranya terdapat pelanggaran dasar dan syarat pada masa hadapan. Kelulusan juga akan terbatal dengan sendirinya sekiranya tuan gagal mendaftar dan melesenkan vesel berkenaan dalam tempoh masa yang telah ditetapkan.</p>
                
                <p>6. Segala kerjasama tuan berhubung perkara ini didahului dengan ucapan ribuan terima kasih.</p>
                
            @elseif($perakuan && $perakuan->jenis_pindaan_syarat === 'Tukar Jenis Peralatan')
                {{-- Tukar Jenis Peralatan --}}
                <p><strong>PERMOHONAN MEMINDA SYARAT KELULUSAN (PERTUKARAN PERALATAN MENANGKAP IKAN) BAGI SIJIL KELULUSAN PEROLEHAN VESEL DAN PERALATAN MENANGKAP IKAN LAUT DALAM (ZON C2) UNIT BAHARU BAGI TUJUAN PELESENAN - NO. SIRI: 1162</strong></p>
                
                <p>Dengan segala hormatnya, saya merujuk perkara di atas.</p>
                
                <p>2. Berdasarkan permohonan yang dikemukakan, Jabatan Perikanan Malaysia (DOF) bersetuju untuk mempertimbangkan permohonan tuan dengan pertukaran kepada dua (2) unit pukat jerut ikan daripada asalnya satu (1) unit pukat tunda dan satu (1) unit pukat jerut ikan.</p>
                
                <p>3. Kelulusan ini dipertimbangkan bagi memberi peluang dan ruang kepada syarikat tuan untuk urusan perolehan / pembinaan vesel, seterusnya mendaftar dan melesenkan vesel tersebut oleh Jabatan ini. Tuan diingatkan supaya melaporkan kemajuan perolehan vesel kepada Jabatan ini dari semasa ke semasa (laporan sebelum pembinaan, laporan kemajuan pembinaan dan laporan vesel siap dibina).</p>
                
                <p>4. Sebarang perolehan / pembinaan vesel untuk tujuan pelesenan vesel penangkapan ikan hendaklah mematuhi Akta Perikanan 1985 serta syarat dan prosedur pelesenan yang berkuat kuasa. Segala kerjasama tuan berhubung perkara ini didahului dengan ucapan ribuan terima kasih.</p>
                
            @elseif($perakuan && $perakuan->jenis_pindaan_syarat === 'Pangkalan')
                {{-- Pangkalan --}}
                <p>Dengan segala hormatnya, saya merujuk perkara di atas.</p>
                
                <p>2. Berdasarkan permohonan yang dikemukakan, Jabatan Perikanan Malaysia (DOF) bersetuju untuk mempertimbangkan permohonan tuan dengan pertukaran pangkalan daripada {{ $perakuan->pangkalan_asal ?? 'Pelabuhan LKIM Chendering, Terengganu' }} ke {{ $perakuan->pangkalan_baru ?? 'Pelabuhan LKIM Tok Bali, Kelantan' }}.</p>
                
                <p>3. Kelulusan ini dipertimbangkan bagi memberi peluang dan ruang kepada syarikat tuan untuk urusan perolehan / pembinaan vesel, seterusnya mendaftar dan melesenkan vesel tersebut oleh Jabatan ini. Tuan diingatkan supaya melaporkan kemajuan perolehan vesel kepada Jabatan ini dari semasa ke semasa (laporan sebelum pembinaan, laporan kemajuan pembinaan dan laporan vesel siap dibina).</p>
                
                <p>4. Sebarang perolehan / pembinaan vesel untuk tujuan pelesenan vesel penangkapan ikan hendaklah mematuhi Akta Perikanan 1985 serta syarat dan prosedur pelesenan yang berkuat kuasa. Segala kerjasama tuan berhubung perkara ini didahului dengan ucapan ribuan terima kasih.</p>
                
            @else
                {{-- Fallback content --}}
                <p><strong>PERMOHONAN MEMINDA SYARAT KELULUSAN BAGI SIJIL KELULUSAN PEROLEHAN VESEL DAN PERALATAN MENANGKAP IKAN LAUT DALAM (ZON C2) UNIT BAHARU BAGI TUJUAN PELESENAN - NO. SIRI: 1178</strong></p>
                
                <p>Dengan hormatnya, saya merujuk perkara di atas.</p>
                
                <p>2. Jabatan Perikanan Malaysia (DOF) telah menerima permohonan tuan untuk meminda syarat kelulusan perolehan vesel dan peralatan menangkap ikan laut dalam (zon C2) unit baharu bagi tujuan pelesenan.</p>
                
                <p>3. Berdasarkan permohonan yang dikemukakan, DOF bersetuju untuk mempertimbangkan permohonan tuan dengan syarat-syarat yang telah ditetapkan.</p>
                
                <p>4. Tuan dinasihatkan agar sentiasa mematuhi segala dasar dan syarat yang ditetapkan oleh DOF mengikut kelulusan perolehan vesel penangkapan ikan laut dalam (zon C2).</p>
                
                <p>5. DOF tidak dapat mempertimbangkan pengeluaran lesen baharu untuk vesel berkenaan sekiranya terdapat pelanggaran dasar dan syarat pada masa hadapan. Kelulusan juga akan terbatal dengan sendirinya sekiranya tuan gagal mendaftar dan melesenkan vesel berkenaan dalam tempoh masa yang telah ditetapkan.</p>
                
                <p>6. Segala kerjasama tuan berhubung perkara ini didahului dengan ucapan ribuan terima kasih.</p>
            @endif
        </div>

        <div class="signature-section">
            <p class="closing-remark">Sekian. Terima kasih.</p>
            
            <div class="malaysia-madani-section">
                <p class="malaysia-madani">"MALAYSIA MADANI"</p>
                <p class="berkhidmat-negara">"BERKHIDMAT UNTUK NEGARA"</p>
            </div>
            
            <p class="signature-text">Saya yang menjalankan amanah,</p>
            
            <div class="signature-block">
                <p class="signature-name">({{ $approver->name ?? 'KETUA PENGARAH PERIKANAN' }})</p>
                <p class="signature-title">{{ $approver->peranan ?? 'Ketua Pengarah Perikanan' }}</p>
                <p class="signature-dept">Jabatan Perikanan Malaysia</p>
                <p class="signature-location">PUTRAJAYA</p>
            </div>
        </div>

        <div class="carbon-copy">
            <p class="cc-title">s.k.</p>
            <ul class="cc-list">
                <li>- Timbalan Ketua Pengarah Perikanan (Pengurusan)</li>
                <li>- Pengarah Kanan Bhg. Sumber Perikanan Tangkapan</li>
                <li>- Pengarah Perikanan Negeri Terengganu</li>
                <li>- Pengarah Perikanan Negeri Kelantan</li>
                <li>- Ketua Cawangan Pembangunan Laut Dalam</li>
            </ul>
        </div>

        <div class="footer">
            <div class="footer-content">
                <div class="quality-logos">
                    <div class="cert-logo">
                        <img src="{{ asset('images/sirim_logo.png') }}" alt="SIRIM Certified" class="cert-image">
                        <p class="cert-text">SIRIM CERTIFIED TO ISO 9001:2015<br>CERT. NO.: QMS 03900</p>
                    </div>
                    <div class="cert-logo">
                        <img src="{{ asset('images/ukas_logo.png') }}" alt="UKAS" class="cert-image">
                        <p class="cert-text">SIRIM CERTIFIED TO ISO 9001:2015<br>CERT. NO.: QMS 03900</p>
                    </div>
                    <div class="cert-logo">
                        <img src="{{ asset('images/iqnet_logo.png') }}" alt="IQNET" class="cert-image">
                        <p class="cert-text">SIRIM CERTIFIED TO ISO 9001:2015<br>CERT. NO.: QMS 03900</p>
                    </div>
                </div>
                <div class="department-motto">
                    <p class="motto-main">PERIKANAN PRODUKTIF MENJANA TRANSFORMASI</p>
                    <p class="motto-english">PRODUCTIVE FISHERIES TOWARDS TRANSFORMATION</p>
                    <div class="mydof-logo">
                        <span class="mydof-text">myDOF</span>
                        <p class="mydof-tagline">Peneraju Perikanan</p>
                    </div>
                </div>
            </div>
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