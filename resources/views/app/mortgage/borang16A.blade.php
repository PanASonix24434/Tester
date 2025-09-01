<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borang 16A & Lampiran KPKT 1028.pdf</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
        }
        .container {
            border: 1px solid black;
            padding: 10px;
        }
        .container-2 {
            margin: 50px;
        }
        .header {
            text-align: center;
            font-style: italic;
        }
        .section-title {
            text-align: center;
        }
        .form-table {
            width: 100%;
            border-collapse: collapse;
        }
        .form-table td {
            border: 1px solid black;
            padding: 5px;
        }
        .input-line {
            display: inline-block;
            border-bottom: 1px dotted black;
            height: 12px;
        }
        .input-line-2 {
            display: inline-block;
            border-bottom: 1px dotted black;
            width: 100%;
            height: 12px;
        }
        .input-line-3 {
            display: inline-block;
            border-bottom: 1px dotted black;
            height: 12px;
        }
        .side-note {
            font-size: 9px;
            position: absolute;
            left: 0;
            top: 50px;
            width: 150px;
            text-align: left;
        }
        .main-content {
            text-align: left;
        }
        .page-break {
            page-break-after: always;
        }
        .input-line-4 {
            display: inline-block;
            border-bottom: 1px solid black;
            height: 12px;
        }
        

    </style>
</head>
<body>
    <div style="font-size:12px; text-align:right;">
        <p>N.L.C 27A - Pg. 39</p>
    </div>

    <div>
        <p class="section-title"><i>Kanun Tanah Negara</i></p>
        <p class="section-title">Borang 16A</p>
        <p class="section-title">(Seksyen 242)</p>
        <p class="section-title" style="font-size:14px;"><b>GADAIAN</b></p>
        <p class="section-title">(Untuk menjamin pembayaran wang pokok)</p>

        <table class="form-table">
            <tr>
                <td colspan="2" style="height:8%;  text-align:center; vertical-align: top;"> <i>(Setem hendaklah dilekatkan - atau pembayaran cukai diperakui - dalam ruang ini)</i></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;"> UNTUK KEGUNAAN PEJABAT PENDAFTARAN</td>
            </tr>
            <tr>
                <td style="width:50%">
                    <p>Ingatan pendaftaran dibuat dalam Dokumen / Dokumen-<br>Dokumen Hakmilik Daftar yang dijadualkan di bawah ini mulai <br>dari pukul <span class="input-line-3" style="width:20%">{{ $register_time }}</span> pada <span class="input-line-3" style="width:10%">{{ $date }}</span> haribulan <span class="input-line-3" style="width:15%">{{ $month }}</span></p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pendaftar/Pentadbir Tanah <span class="input-line-3" style="width:38%">{{ $land_officer }}</span></p>
                    <p>T.M. </p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Negeri/Daerah <span class="input-line-3" style="width:60%">{{ $state_district }}</span></p>
                </td>
                <td style="width:50%">
                    <p class="form-label">Fail mengenai-</p>
                    <p><span class="input-line-3" style="width:100%"></span></p>
                    <p class="form-label">Jilid:<span class="input-line-3" style="width:90%"></span></p>
                    <p class="form-label">Folio: <span class="input-line-3" style="width:88%"></span></p>
                    <p class="form-label">No. Perserahan:<span class="input-line-3" style="width:72%"></span></p>
                </td>
            </tr>
        </table>

        <br>

        <p>Saya, <span class="input-line" style="width:94.5%">{{ $borrower_name }}</span></p>
        <p><span class="input-line-2"></span></p>
        <p>beralamat di <span class="input-line" style="width:89%">{{ $borrower_address }}</span></p>
        <p><span class="input-line-2"></span></p>

        <p>*tuan punya tanah/bahagian yang tak dipecahkan atas tanah yang diperihalkan dalam Jadual di bawah ini;</p>
        <p>*penerima pajak/penerima pajak kecil dalam *pajakan/pajakan kecil yang diperihalkan dalam Jadual dibawah ini bagi tanah yang tersebut itu;</p>

        <p>Bagi maksud menjamin:</p>

        <p>*a) pembayaran balik pinjaman sebanyak<span class="input-line-3" style="width:20%">{{ $security_payment }}</span>, ringgit, yang dengan ini saya mengaku telah terima, <br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;kepada pemegang gadaian yang tersebut namanya di bawah ini, berserta/tanpa faedah;</p>
        <p>*b) pembayaran jumlah wang sebanyak<span class="input-line-3" style="width:20%">{{ $security_payment }}</span>, ringgit, kepada pemegang gadaian yang tersebut <br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;namanya di bawah ini, berserta/tanpa faedah, dan sebagai balasan—</p>
        <p><span class="input-line-2"></span></p>
        <p><span class="input-line-2"></span></p>
        <p>c) pembayaran kepada pemegang gadaian yang tersebut namanya di bawah ini. berserta faedah, akan wang yang dari <br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;semasa ke semasa kena dibayar kepadanya daripada *akaun semasa saya/a kaun yang berikut yang disimpan di <br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;antara kami;</p>
    </div>

    <!-- PAGE 2 -->

        <p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dengan ini menggadaikan *tanah/bahagian yang tak dipecahkan atas tanah/pajakan/pajakan kecil tersebut untuk <br>
           membayar kepadanya jumlah wang yang tersebut itu *berserta/tanpa faedah atasnya mengikut peruntukan-peruntukan <br>
           yang dilampirkan bersama ini</p>

           <br><br>

           <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Bertarikh pada<span class="input-line-3" style="width:10%"></span>haribulan<span class="input-line-3" style="width:10%"></p>

            <br><br><br>
            <p style="text-align:right;"><span class="input-line-3" style="width:30%"></span></p>
            <br>
            <p style="text-align:right;"> Tandatangan (atau lain-lain cara penyempurnaan)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
            oleh atau bagi pihak penggadai&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>

            <br><br>
        
       
        
        <div>
        <!-- Left Side Note -->
        <div class="side-note">
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            Disini masukkan <br>
            nama penuh dan  <br>
            kelayakan orang  <br>
            yang menyaksikan.
        </div>
        
        <!-- Main Content -->
        <div>
       
            <p>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               Saya, <span class="input-line-3" style="width:80%"></span> <br>
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               <span class="input-line-3" style="width:85%"></span> <br>
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               dengan ini mengaku bahawa *tandatangan/cap ibu jari yang di atas itu telah *ditulis/dicapkan di hadapan 
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               saya pada<span class="input-line-3" style="width:25%"> </span>
               haribulan <span class="input-line-3" style="width:30%"> </span> dan adalah 
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               *tandatangan/cap ibujari yang benar bagi-
            </p>
            
        </div>

        <br>
   

    <div>
        <!-- Left Side Note -->
        <div class="side-note">
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <br><br><br><br><br><br><br><br> <br><br>
            Di sini masukkan <br>
            nama orang yang <br>
            menyempurnakan
        </div>
        
        <!-- Main Content -->
        <div>
       
            <p>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               <span class="input-line-3" style="width:80%"></span> <br>
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               yang telah mengaku kepada saya- <br><br>

               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               (i) bahawa dia adalah cukup umur; <br> 
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              *(ii) bahawa dia adalah warganegara Malaysia; <br>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               (iii) bahawa dia telah menyempurnakan suratcara ini dengan kerelaan hatinya sendiri; dan <br>
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               (iv) bahawa dia faham akan kandungan serta natijahnya. <br>
            </p>

            <br>
            
            <p>  <p style="text-align:right;"></p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Disaksikan dengan tandatangan saya pada <span class="input-line-3" style="width:10%"></span>haribulan <span class="input-line-3" style="width:10%"></span>
            </p>

            <br><br><br>
            <p style="text-align:right;"><span class="input-line-3" style="width:30%"></span></p>
            <p style="text-align:right;">Tandatangan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
            <br>
            
        </div>
  

    <br><br><br><br><br><br><br>

   

</div>

<!-- PAGE 3 -->


        <p> Saya, Pesuruhjaya Tanah Persekutuan, suatu Perbadanan tunggal yang ditubuhkan di bawah Seksyen 3, Akta <br>
            Pesuruhjaya Tanah Persekutuan 1957 beralamat di Jabatan Ketua Pengarah Tanah dan Galian, Aras 2, Blok <br>
            Menara, Lot 4G3, Presint 4, Pusat Pentadbiran Kerajaan Persekutuan, 62574 Putrajaya menerima gadaian ini.</p>
          <p>  ( KD/4096 ) </p>

          <br><br><br><br><br><br><br>

          <p style="text-align:right;"><b>COP MOHOR</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>

          <br><br><br><br>

          <p>Cap mohor ini telah dimeteraikan di hadapan saya pada</p>   
          <p><span class="input-line-3" style="width:45%"></span></p>
          

          <br><br><br><br><br><br><br> <br><br><br>

          <p style="text-align:right;"><span class="input-line-3" style="width:50%"></span></p>
          <p style="text-align:right;">Tandatangan (atau lain-lain cara penyempurnaan)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
          oleh atau bagi pihak pemegang gadaian.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;</p>

          <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<!-- PAGE 4-->

        <table class="form-table">
            <tr>
                <td colspan="6" style="height:10%;  text-align:center; vertical-align: top;"> <i>Jika alamat orang yang berhak di bawah suratcara ini ialah di luar Persekutuan maka suatu alamatdi dalam
                Persekutuan untuk penyampaian notis-notis hendaklah ditambah dalam ruangan ini</i>
                <br><br>
               <span class="input-line-3" style="width:90%"></span><br><br>
               <span class="input-line-3" style="width:90%"></span><br><br>
            </td>
               
            </tr>
            <tr>
                <td colspan="6" style="text-align:center;"> JADUAL TANAH * DAN KEPENTINGAN</td>
            </tr>
            <tr>
                <td style="text-align:center;width:15%">
                Bandar/Pekan/<br>
                Mukim
                </td>
                <td style="text-align:center;width:15%">
                No. *Lot/<br>
                Petak/P.T.
                </td>
                <td style="text-align:center;width:15%">
                Jenis dan No.
                Hakmilik
                </td>
                <td style="text-align:center;width:15%">
                Bahagian <br>
                Tanah <br>
                (jika ada)
                </td>
                <td style="text-align:center;width:15%">
                No. Berdaftar
                *pajakan/pajakan
                kecil (jika ada)
                </td>
                <td style="text-align:center;width:15%">
                No. Berdaftar
                Gadaian
                (jika ada)
                </td>
            </tr>

            <tr style="vertical-align: top;">
                <td style="text-align:center;width:15%; height:30%">(1)</td>
                <td style="text-align:center;width:15%; height:30%">(2)</td>
                <td style="text-align:center;width:15%; height:30%">(3)</td>
                <td style="text-align:center;width:15%; height:30%">(4) <br><br> SEMUA</td>
                <td style="text-align:center;width:15%; height:30%">(5) <br><br> TIADA</td>
                <td style="text-align:center;width:15%; height:30%">(6)</td>

            </tr>
        </table>

        <br><br><br>

        <p style="text-align:center;">LAMPIRAN</p>

        <br><br>
        <p style="text-align:center;">(<span class="input-line-3" style="width:70%"></span>)</p>
        <p style="text-align:center;"> <i>(Peruntukan-peruntukan mengenai pembayaran, kadar faedah, jika ada dsb.)</i></p>

        <br><br><br>
       
        <p style="text-align:center;"><span class="input-line-4" style="width:100%"></span>
        *Potong sebagaimana yang sesuai. <br>
        <span class="input-line-4" style="width:100%"></span></p>

        <p style="font-size:11px;">[Borang ini diterjemahkan oleh Peguam Negara, Malaysia, menurut Pemberitahu Undangan No. 12 tahun1964-A.G. 3309 S.F. 1;P.T. TM.5/65 (4).]</p>

        <br>
        <p><span class="input-line-4" style="width:15%"></span>
            <br> PNMB., K.L</p>



<!-- PAGE 5-->

<div style="font-size:12px; text-align:left;">
        <p>KPKT 1028/2</p>
</div>

    <p style="text-align:center;">LAMPIRAN</p>
    <br>

    <p style="text-align: justify;">Penggadai, apabila dituntut, hendaklah membayar wang pokok serta bunganya  <br>
    sebagaimana diperuntukkan kemudian daripada ini dengan ansuran bulanan <br>
    sebanyak Ringgit Malaysia :<span class="input-line-3" style="width:44%"></span> <br>
    (<span class="input-line-3" style="width:20%"></span>) atau sebanyak apa-apa jumlah lain sebagaimana ditentukan <br>
    mengikut Fasal 4 di bawah ini sehingga kesemua wang pokok itu serta bunganya <br>
    dibayar dan dijelaskan sepenuhnya. Ansuran portama hendaklah dibayar pada hari <br>
    akhir dalam bulan yang berikut selepas tarikh siapnya rumah kediaman yang tersebut <br>
    di dalam ini atau pada bari akhir dalam bulan yang berikut selepas bulan kelapan <br>
    belas dari tarikh pembayaran kemajuan pertama mengikut mana yang terdahulu <br>
    dan tiap-tiap satu ansuran yang kemudian hendaklah dibayar pada hari akhir dalam  <br>
    tiap-tap bulan yang berikutnya. <i>Tarikh penerimaan bayaran kemajuan pertama <br>
    hendakiah dikira sebagai satu minggu selepas tarikh yang terdapat di atas Cek. </i></p>

    <p style="text-align: justify;font-size:16px;">
    Penggadai, apabila dituntut, hendaklah membayar wang pokok serta bunganya <br>
    sebagaimana diperuntukkan kemudian daripada ini dengan ansuran bulanan <br>
    sebanyak Ringgit Malaysia :<span class="input-line-3" style="width:44%"></span> <br>
    (<span class="input-line-3" style="width:20%"></span>) atau sebanyak apa-apa jumlah lain sebagaimana ditentukan <br>
    mengikut Fasal 4 di bawah ini sehingga kesemua wang pokok itu serta bunganya <br>
    dibayar dan dijelaskan sepenuhnya. Ansuran pertama hendaklah dibayar pada hari <br>
    akhir dalam bulan yang berikut selepas tarikh siapnya rumah kediaman yang tersebut <br>
    di dalam ini atau pada hari akhir dalam bulan yang berikut selepas bulan kelapan <br>
    belas dari tarikh pembayaran kemajuan pertama mengikut mana yang terdahulu <br>
    dan tiap-tiap satu ansuran yang kemudian hendaklah dibayar pada hari akhir dalam <br>
    tiap-tiap bulan yang berikutnya. <i>Tarikh penerimaan bayaran kemajuan pertama <br>
    hendaklah dikira sebagai satu minggu selepas tarikh yang terdapat di atas Cek.</i>
</p>


</body>
</html>
