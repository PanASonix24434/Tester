<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>{{ __('module.appointments') }}.pdf</title>
		<style type="text/css">
	        .page-break {
	            page-break-after: always;
	        }

	        .section {
	            page-break-inside: avoid;
	        }

	        @page { margin: 50px 50px; }

	        /* Bootstrap Style */
	        body {
	        	margin: 0px;
	        	font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
	        	font-size: 1rem;
	        	font-weight: 400;
	        	line-height: 1.5;
	        	color: #212529;
	        	text-align: left;
	        	background-color: #fff;
	        }

	        table {
	        	border-collapse: collapse;
	        }

	        .table {
	        	width: 100%;
	        	margin-bottom: 1rem;
	        	background-color: transparent;
	        }

	        .table th,
	        .table td {
	        	padding: 0.75rem;
	        	vertical-align: top;
	        	border-top: 1px solid #dee2e6;
	        }

	        .table thead th {
				text-align: left;
	        	vertical-align: bottom;
	        	border-bottom: 2px solid #dee2e6;
	        }

	        .table tbody + tbody {
	        	border-top: 2px solid #dee2e6;
	        }

	        .table .table {
	        	background-color: #fff;
	        }

	        .table-sm th,
	        .table-sm td {
	        	padding: 0.3rem;
	        }

	        .table-bordered {
	        	border: 1px solid #dee2e6;
	        }

	        .table-bordered th,
	        .table-bordered td {
	        	border: 1px solid #dee2e6;
	        }

	        .table-bordered thead th,
	        .table-bordered thead td {
	        	border-bottom-width: 2px;
	        }

	        .table-borderless th,
	        .table-borderless td,
	        .table-borderless thead th,
	        .table-borderless tbody + tbody {
	        	border: 0;
	        }

	        .table-striped tbody tr:nth-of-type(odd) {
	        	background-color: rgba(0, 0, 0, 0.05);
	        }

	        .table-hover tbody tr:hover {
	        	background-color: rgba(0, 0, 0, 0.075);
	        }

	        .table-primary,
	        .table-primary > th,
	        .table-primary > td {
	        	background-color: #b8daff;
	        }

	        .table-hover .table-primary:hover {
	        	background-color: #9fcdff;
	        }

	        .table-hover .table-primary:hover > td,
	        .table-hover .table-primary:hover > th {
	        	background-color: #9fcdff;
	        }

	        .table-secondary,
	        .table-secondary > th,
	        .table-secondary > td {
	        	background-color: #d6d8db;
	        }

	        .table-hover .table-secondary:hover {
	        	background-color: #c8cbcf;
	        }

	        .table-hover .table-secondary:hover > td,
	        .table-hover .table-secondary:hover > th {
	        	background-color: #c8cbcf;
	        }

	        .table-success,
	        .table-success > th,
	        .table-success > td {
	        	background-color: #c3e6cb;
	        }

	        .table-hover .table-success:hover {
	        	background-color: #b1dfbb;
	        }

	        .table-hover .table-success:hover > td,
	        .table-hover .table-success:hover > th {
	        	background-color: #b1dfbb;
	        }

	        .table-info,
	        .table-info > th,
	        .table-info > td {
	        	background-color: #bee5eb;
	        }

	        .table-hover .table-info:hover {
	        	background-color: #abdde5;
	        }

	        .table-hover .table-info:hover > td,
	        .table-hover .table-info:hover > th {
	        	background-color: #abdde5;
	        }

	        .table-warning,
	        .table-warning > th,
	        .table-warning > td {
	        	background-color: #ffeeba;
	        }

	        .table-hover .table-warning:hover {
	        	background-color: #ffe8a1;
	        }

	        .table-hover .table-warning:hover > td,
	        .table-hover .table-warning:hover > th {
	        	background-color: #ffe8a1;
	        }

	        .table-danger,
	        .table-danger > th,
	        .table-danger > td {
	        	background-color: #f5c6cb;
	        }

	        .table-hover .table-danger:hover {
	        	background-color: #f1b0b7;
	        }

	        .table-hover .table-danger:hover > td,
	        .table-hover .table-danger:hover > th {
	        	background-color: #f1b0b7;
	        }

	        .table-light,
	        .table-light > th,
	        .table-light > td {
	        	background-color: #fdfdfe;
	        }

	        .table-hover .table-light:hover {
	        	background-color: #ececf6;
	        }

	        .table-hover .table-light:hover > td,
	        .table-hover .table-light:hover > th {
	        	background-color: #ececf6;
	        }

	        .table-dark,
	        .table-dark > th,
	        .table-dark > td {
	        	background-color: #c6c8ca;
	        }

	        .table-hover .table-dark:hover {
	        	background-color: #b9bbbe;
	        }

	        .table-hover .table-dark:hover > td,
	        .table-hover .table-dark:hover > th {
	        	background-color: #b9bbbe;
	        }

	        .table-active,
	        .table-active > th,
	        .table-active > td {
	        	background-color: rgba(0, 0, 0, 0.075);
	        }

	        .table-hover .table-active:hover {
	        	background-color: rgba(0, 0, 0, 0.075);
	        }

	        .table-hover .table-active:hover > td,
	        .table-hover .table-active:hover > th {
	        	background-color: rgba(0, 0, 0, 0.075);
	        }

	        .table .thead-dark th {
	        	color: #fff;
	        	background-color: #212529;
	        	border-color: #32383e;
	        }

	        .table .thead-light th {
	        	color: #495057;
	        	background-color: #e9ecef;
	        	border-color: #dee2e6;
	        }

	        .table-dark {
	        	color: #fff;
	        	background-color: #212529;
	        }

	        .table-dark th,
	        .table-dark td,
	        .table-dark thead th {
	        	border-color: #32383e;
	        }

	        .table-dark.table-bordered {
	        	border: 0;
	        }

	        .table-dark.table-striped tbody tr:nth-of-type(odd) {
	        	background-color: rgba(255, 255, 255, 0.05);
	        }

	        .table-dark.table-hover tbody tr:hover {
	        	background-color: rgba(255, 255, 255, 0.075);
	        }

	        @media (max-width: 575.98px) {
	        	.table-responsive-sm {
	        		display: block;
	        		width: 100%;
	        		overflow-x: auto;
	        		-webkit-overflow-scrolling: touch;
	        		-ms-overflow-style: -ms-autohiding-scrollbar;
	        	}
	        	.table-responsive-sm > .table-bordered {
	        		border: 0;
	        	}
	        }

	        @media (max-width: 767.98px) {
	        	.table-responsive-md {
	        		display: block;
	        		width: 100%;
	        		overflow-x: auto;
	        		-webkit-overflow-scrolling: touch;
	        		-ms-overflow-style: -ms-autohiding-scrollbar;
	        	}
	        	.table-responsive-md > .table-bordered {
	        		border: 0;
	        	}
	        }

	        @media (max-width: 991.98px) {
	        	.table-responsive-lg {
	        		display: block;
	        		width: 100%;
	        		overflow-x: auto;
	        		-webkit-overflow-scrolling: touch;
	        		-ms-overflow-style: -ms-autohiding-scrollbar;
	        	}
	        	.table-responsive-lg > .table-bordered {
	        		border: 0;
	        	}
	        }

	        @media (max-width: 1199.98px) {
	        	.table-responsive-xl {
	        		display: block;
	        		width: 100%;
	        		overflow-x: auto;
	        		-webkit-overflow-scrolling: touch;
	        		-ms-overflow-style: -ms-autohiding-scrollbar;
	        	}
	        	.table-responsive-xl > .table-bordered {
	        		border: 0;
	        	}
	        }

	        .table-responsive {
	        	display: block;
	        	width: 100%;
	        	overflow-x: auto;
	        	-webkit-overflow-scrolling: touch;
	        	-ms-overflow-style: -ms-autohiding-scrollbar;
	        }

	        .table-responsive > .table-bordered {
	        	border: 0;
	        }

	        .badge {
	        	display: inline-block;
	        	padding: 0.25em 0.4em;
	        	font-size: 75%;
	        	font-weight: 700;
	        	line-height: 1;
	        	text-align: center;
	        	white-space: nowrap;
	        	vertical-align: baseline;
	        	border-radius: 0.25rem;
	        }

	        .badge-secondary {
	        	color: #fff;
	        	background-color: #6c757d;
	        }

	        .badge-secondary[href]:hover, .badge-secondary[href]:focus {
	        	color: #fff;
	        	text-decoration: none;
	        	background-color: #545b62;
	        }

	        .badge-success {
	        	color: #fff;
	        	background-color: #28a745;
	        }

	        .badge-success[href]:hover, .badge-success[href]:focus {
	        	color: #fff;
	        	text-decoration: none;
	        	background-color: #1e7e34;
	        }

	        .badge-info {
	        	color: #fff;
	        	background-color: #17a2b8;
	        }

	        .badge-info[href]:hover, .badge-info[href]:focus {
	        	color: #fff;
	        	text-decoration: none;
	        	background-color: #117a8b;
	        }

	        .badge-warning {
	        	color: #212529;
	        	background-color: #ffc107;
	        }

	        .badge-warning[href]:hover, .badge-warning[href]:focus {
	        	color: #212529;
	        	text-decoration: none;
	        	background-color: #d39e00;
	        }

	        .badge-danger {
	        	color: #fff;
	        	background-color: #dc3545;
	        }

	        .badge-danger[href]:hover, .badge-danger[href]:focus {
	        	color: #fff;
	        	text-decoration: none;
	        	background-color: #bd2130;
	        }

	        .badge-light {
	        	color: #212529;
	        	background-color: #f8f9fa;
	        }

	        .badge-light[href]:hover, .badge-light[href]:focus {
	        	color: #212529;
	        	text-decoration: none;
	        	background-color: #dae0e5;
	        }

	        .badge-dark {
	        	color: #fff;
	        	background-color: #343a40;
	        }

	        .badge-dark[href]:hover, .badge-dark[href]:focus {
	        	color: #fff;
	        	text-decoration: none;
	        	background-color: #1d2124;
	        }

	        .rounded-circle {
	        	border-radius: 50% !important;
	        }
	    </style>
	</head>
	<body>
		<h3></h3>
        <table width="100%">
            <thead>
                <tr>
				@foreach ($approves as $approves)
                    <td style="text-align: right;">Rujukan Kami : {{ $approves->cert_no }}</td>
				@endforeach
                </tr>
				<tr>
                    <td style="text-align: right;">Tarikh : {{ date('d-m-Y') }}</td>
                </tr>
				<tr>
                    <td style="text-align: left;">Pengarah </td>
                </tr>
				<tr>
				@foreach ($appointments as $key => $appointment)
                    <td style="text-align: left;">{{ $appointment->office_duty }}</td>
				@endforeach
                </tr>
				<tr>
                    <td style="text-align: left;"><strong> {{ $states }} </strong></td>
                </tr>				
				<tr>
                    <td style="text-align: left;">&nbsp;</td>
                </tr>				
				<tr>
                    <td style="text-align: left;"><strong>Tuan,</strong></td>
                </tr>
				<tr>
                    <td style="text-align: left;">&nbsp;</td>
                </tr>				
				<tr>
                    <td style="text-align: left;"><strong>PERWAKILAN KUASA KETUA PENGARAH PERIKANAN MALAYSIA DI BAWAH SEKSYEN 3 (4) AKTA PERIKANAN 1985 BAGI NEGERI {{ $states }}</strong></td>
                </tr>
				<tr>
                    <td style="text-align: left;">&nbsp;</td>
                </tr>				
				<tr>
                    <td style="text-align: left;">Dengan segala hormatnya merujuk kepada perkara yang tersebut di atas.</td>
                </tr>
				<tr>
                    <td style="text-align: left;">&nbsp;</td>
                </tr>				
				<tr>
                    <td style="text-align: left;">2.	Bersama-sama ini dikepilkan surat pewartaan Perwakilan Kuasa Ketua Pengarah Perikanan Malaysia di bawah Seksyen 3(4) Akta Perikanan 1985 yang telah diberi kuasa dalam melaksanakan tugas-tugas berkaitan Pelesenan bagi pegawai dan kakitangan seperti berikut :</td>
                </tr>
            </thead>
		</table>
		<br/>
		<table class="table table-bordered table-sm">
				<thead>
					<tr>
						<th><b>Nama</b></th>
                        <th><b>Jawatan/Tempat Bertugas</b></th>
                        <th><b>Tarikh Kuat Kuasa</b></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($appointments as $key => $appointment)
					<tr>
						<td>{{ $appointment->name }}</td>						
						<td>{{ $appointment->office_duty }}</td>
						<td>{{ $appointment->report_date }}</td>

					</tr>
					@endforeach
				</tbody>
		</table>
		<table width="100%">
            <thead>							
				<tr>
                    <td style="text-align: left;">3.	Dipohon agar tuan dapat memanjangkan surat perwakilan tersebut dan memantau dalam mengikuti Dasar dan Prosedur yang ditetapkan dalam menjalankan tugas dengan penuh integriti.Sekian untuk makluman dan tindakan lanjut pihak tuan. </td>
                </tr>
				<tr>
                    <td style="text-align: left;">&nbsp;</td>
                </tr>				
				<tr>
                    <td style="text-align: left;">Sekian,terima kasih.</td>
                </tr>					
				<tr>
                    <td style="text-align: left;">&nbsp;</td>
                </tr>		
				<tr>
                    <td style="text-align: left;"><strong>"MALAYSIA MADANI"</strong></td>
                </tr>
				<tr>
                    <td style="text-align: left;"><strong>"BERKHIDMAT UNTUK NEGARA"</strong></td>
                </tr>
				<tr>
                    <td style="text-align: left;">&nbsp;</td>
                </tr>		
				<tr>
                    <td style="text-align: left;">&nbsp;</td>
                </tr>		
				<tr>
                    <td style="text-align: left;">&nbsp;</td>
                </tr>
				<tr>
                    <td style="text-align: left;">&nbsp;</td>
                </tr>		
				<tr>
                    <td style="text-align: left;">&nbsp;</td>
                </tr>
				<tr>
                    <td style="text-align: left;">&nbsp;</td>
                </tr>		
				<tr>
                    <td style="text-align: left;">&nbsp;</td>
                </tr>
				<tr>
                    <td style="text-align: left;">&nbsp;</td>
                </tr>		
				<tr>
                    <td style="text-align: left;">&nbsp;</td>
                </tr>		
				<tr>
                    <td style="text-align: left;">Saya yang menjalankan amanah,</td>
                </tr>
				<tr>
                    <td style="text-align: left;">&nbsp;</td>
                </tr>		
				<tr>
                    <td style="text-align: left;">&nbsp;</td>
                </tr>	
				<tr>
                    <td style="text-align: left;">&nbsp;</td>
                </tr>		
				<tr>
                    <td style="text-align: left;">&nbsp;</td>
                </tr>		
				<tr>
				@foreach ($users as $user)
                    <td style="text-align: left;"><strong>{{ $user->name }}</strong></td>
				@endforeach
                </tr>
				<tr>
                    <td style="text-align: left;">Timbalan Pengarah Kanan</td>
                </tr>
				<tr>	
                    <td style="text-align: left;">Bahagian Sumber Perikanan Tangkapan</td>
                </tr>
				<tr>	
                    <td style="text-align: left;">b.p Ketua Pengarah Perikanan Malaysia</td>
                </tr>
				<tr>	
                    <td style="text-align: left;">Ibu Pejabat Perikanan</td>
                </tr>
				<tr>	
                    <td style="text-align: left;"><strong>PUTRAJAYA</strong></td>
                </tr>
				<tr>
                    <td style="text-align: left;">&nbsp;</td>
                </tr>		
				<tr>
                    <td style="text-align: left;">s.k:</td>
                </tr>
				<tr>
                    <td style="text-align: left;">YBhg. Dato' Ketua Pengarah Perikanan</td>
                </tr>
				<tr>
                    <td style="text-align: left;">YBrs. Timbalan Ketua Pengarah Perikanan (Pembangunan)</td>
                </tr>
				<tr>
                    <td style="text-align: left;">YBhg. Dato' Timbalan Ketua Pengarah Perikanan (Pengurusan)</td>
                </tr>
				<tr>
                    <td style="text-align: left;">Penasihat Pejabat Undang-Undang</td>
                </tr>
            </thead>
		</table>
		<div class="page-break"></div>
        <table width="100%">
            <thead>
                <tr>
                    <td style="text-align: center;">AKTA PERIKANAN 1985</td>
                </tr>
				<tr>
                    <td style="text-align: center;">PERWAKILAN KUASA DI BAWAH SUBSEKSYEN 3(4)</td>
                </tr>
				<tr>
                    <td style="text-align: left;">&nbsp;</td>
                </tr>
				<tr>
                    <td style="align=justify; style=line-height: 2.5;">PADA menjalankan kuasa yang diberikan oleh subseksyen 3(4) Akta Perikanan 1985 <i>[Akta 317]</i>, Ketua Pengarah Perikanan dengan ini mewakilkan perjalanan kuasa dan fungsinya di bawah subseksyen 9(1),(2) dan (3),subseksyen 11(1),subseksyen 13(1),(2) dan (3),perenggan 14(2)(a) dan (b),perenggan 14(4)(aa),subseksyen 15(2),seksyen 20,subseksyen 48(1),subseksyen 50(1), dan subseksyen 52(2) kepada Pegawai Perikanan yang dinamakan dalam ruang (1) Jadual selama tempoh Pegawai Perikanan itu berkhidmat di jawatan dan tempat yang dinyatakan di ruang (2) berkuat kuasa mulai tarikh dinyatakan dalam ruang (3) tertakluk kepada dasar dan prosedur yang ditetapkan oleh Ketua Pengarah Perikanan.   </td>
                </tr>
				<tr>
                    <td style="text-align: left;">&nbsp;</td>
                </tr>					
            </thead>
		</table>
		<table width="100%">
            <thead>
				<tr>
                    <td style="text-align: left;">&nbsp;</td>
					<td style="text-align: left;">&nbsp;</td>
					<td style="text-align: left;">&nbsp;</td>
                </tr>
				<tr>
                    <td style="text-align: center;">&nbsp;</td>
					<td style="text-align: center;">JADUAL</td>
					<td style="text-align: left;">&nbsp;</td>
                </tr>
				<tr>
                    <td style="text-align: left;">&nbsp;</td>
					<td style="text-align: left;">&nbsp;</td>
					<td style="text-align: left;">&nbsp;</td>
                </tr>				
				<tr>
                    <td style="text-align: center; width:35%">(1)</td>
					<td style="text-align: center; width:35%">(2)</td>
					<td style="text-align: center; width:30%">(3)</td>
                </tr>
				<tr>
                    <td style="text-align: center; width:35%">Nama</td>
					<td style="text-align: center; width:35%">Jawatan Dan Tempat</td>
					<td style="text-align: center; width:30%">Tarikh</td>
                </tr>	
				<tr>
				@foreach ($appointments as $appointment)
                    <td style="text-align: center; width:35%">{{ $appointment->name }}</td>
					<td style="text-align: center; width:35%">{{ $appointment->office_duty }}</td>
					<td style="text-align: center; width:30%">{{ $appointment->report_date }}</td>
				@endforeach
                </tr>	
				<tr>
                    <td style="text-align: left;">&nbsp;</td>
					<td style="text-align: left;">&nbsp;</td>
					<td style="text-align: left;">&nbsp;</td>
                </tr>
				<tr>
                    <td style="text-align: left;">&nbsp;</td>
					<td style="text-align: left;">&nbsp;</td>
					<td style="text-align: left;">&nbsp;</td>
                </tr>
				<tr>
                    <td style="text-align: left;">Bertarikh {{ date('d-m-Y') }}</td>
					<td style="text-align: left;">&nbsp;</td>
					<td style="text-align: left;">&nbsp;</td>
                </tr>	
				<tr>
                    <td style="text-align: left;"> {{ $approves->cert_no }}</td>
					<td style="text-align: left;">&nbsp;</td>
					<td style="text-align: left;">&nbsp;</td>
                </tr>					
            </thead>
		</table>
		<table width="100%">
			<thead>
				<tr>
					<td style="text-align: center;">&nbsp;</td>
					<td style="text-align: right;">&nbsp;</td>
				</tr>
				<tr>
					<td style="text-align: center;">&nbsp;</td>
					<td style="text-align: right;">&nbsp;</td>
				</tr>
				<tr>
					<td style="text-align: center;">&nbsp;</td>
					@foreach ($ketuausers as $kuser)
                    <td style="text-align: right;"><strong>{{ $kuser->name }}</strong></td>
					@endforeach	
				</tr>
				<tr>
					<td style="text-align: center;">&nbsp;</td>
					<td style="text-align: right;">Ketua Pengarah Perikanan Malaysia</td>
				</tr>
			</thead>
		</table>
		<div class="page-break"></div>
		<h3><center>NOTA SURAT PERWAKILAN KUASA</center></h3>
		<table width="100%" border="1">
            <thead>
				<tr>
                    <td style="width:5%">Bil.</td>
					<td style="width:15%">Seksyen Pemberian Kuasa</td>
					<td style="width:15%">Seksyen Yang Perlu Dibaca Bersama</td>
					<td style="width:65%">Keterangan</td>
                </tr>
				<tr>
                    <td>1.</td>
					<td>9 (1), (2) dan (3)</td>
					<td>9 (4)</td>
					<td>Subseksyen 9(1), (2) dan (3) memperuntukkan kuasa dalam proses permohonan lesen atau permit vesel penangkapan ikan yang baru.Namun dalam melaksanakan kuasa di bawah subseksyen 9(1), (2) dan (3) , WAJIB DIBERI PERHATIAN had kuasa Ketua Pengarah Perikanan untuk mengeluarkan lesen di bawah subseksyen 9(4).<br/>Subseksyen 9(4) tidak dimasukkan kerana tidak melibatkan penurunan kuasa.</td>
                </tr>
				<tr>
					<td>2.</td>
					<td>11(1)</td>
					<td>10(1)(a) (b) dan (c)</td>
					<td>Kuasa untuk mengeluarkan dan meletakkan syarat lesen diperuntukkan di bawah subseksyen 11(1).Namun dalam melaksanakan kuasa tersebut, terdapat syarat-syarat yang WAJIB DIMASUKKAN seperti diperuntukkan di bawah perenggan 10(1)(a) (b) dan (c)<br/>Perenggan 10(1)(a) (b) dan (c) tidak dimasukkan kerana tidak melibatkan penurunan kuasa.</td>
                </tr>				
				<tr>
					<td>3.</td>
					<td>14(4)(aa)</td>
					<td>14(4)(a)</td>
					<td>Kuasa pemindahmilikan lesen atau permit diperuntukkan di bawah perenggan 14(4)(aa).Namun dalam melaksanakan kuasa tersebut, WAJIB DIBERI PERHATIAN asasnya lesen atau permit dikeluarkan atas nama pemohon dan tidak boleh dipindahmilik seperti diperuntukkan di bawah perenggan 14(4)(a).<br/>Perenggan 14(4)(a) tidak dimasukkan kerana tidak melibatkan penurunan kuasa.</td>
                </tr>
				<tr>
					<td>4.</td>
                    <td>48(1)</td>
					<td>48(2)</td>					
					<td>Subseksyen 48(1) memperuntukkan kuasa untuk menjual ikan atau benda lain yang mudah rosak yang disita dan hasil jualan hendaklah ditahan dan diuruskan mengikut peruntukan Akta 317.<br/>Subseksyen 48(2) dikeluarkan kerana tidak melibatkan penurunan kuasa.</td>
                </tr>	
				<tr>
					<td>5.</td>
					<td>50(1)</td>
					<td>50(3)</td>
					<td>Subseksyen 50(1) memperuntukkan kuasa untuk memulangkan sementara vesel dsb yang disita dan penalti pelanggarannya diperuntukkan di bawah subseksyen 50(3).<br/>Perenggan 50(3) dikeluarkan kerana tidak melibatkan penurunan kuasa.</td>
                </tr>							
            </thead>
		</table>
		<script type="text/php">
	        if (isset($pdf)) {
	            $x = 570; // potrait: 570, landscape: 815
	            $y = 815; // potrait: 815, landscape: 570
	            $text = "{PAGE_NUM}/{PAGE_COUNT}";
	            $font = null;
	            $size = 9;
	            $color = array(0,0,0);
	            $word_space = 0.0; // default
	            $char_space = 0.0; // default
	            $angle = 0.0; // default
	            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
	        }
	    </script>
	</body>
</html>