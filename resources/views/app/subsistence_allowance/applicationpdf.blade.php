<!DOCTYPE html>
<html lang="{{-- str_replace('_', '-', app()->getLocale()) --}}">
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>suratkebenaran.pdf</title>
		<style type="text/css">
	        .page-break {
	            page-break-after: always;
	        }

	        .section {
	            page-break-inside: avoid;
	        }

	        @page { margin: 50px 100px; }

			/* Bootstrap Style */
	        body {
	        	margin: 0px;
	        	font-family: Arial, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
	        	/* font-size: 1rem; */
				font-size: 14px;
	        	font-weight: 400;
	        	line-height: 1.2;
	        	color: #212529;
	        	text-align: left;
	        	background-color: #fff;
	        }
			
			th {
				vertical-align: top;
				text-align: left;
			}

			u.dotted{
				border-bottom: 1px dotted #999;
				text-decoration: none; 
			}
	        
	    </style>
	</head>
	<body>
		<div class="row">
			<div class="card card-info">
				<div class="card-body">
					<!-- Page 1 -->
					<div style="text-align: center;">
						<img src="{{ public_path('images/esh/dof_logo.png') }}" alt="DOF Logo" height="50">
						<img src="{{ public_path('images/esh/jata_negara.png') }}" alt="Jata Negara" height="50">
						<img src="{{ public_path('images/esh/moa_logo.png') }}" alt="MOA Logo" height="50">
					</div>
					<div style="text-align: center;">
						<b>BORANG PERMOHONAN</b>
					</div>
					<div style="text-align: center;">
						<b>PROGRAM BAYARAN ELAUN SARA HIDUP NELAYAN DARAT</b>
					</div>
					<br\>
					<div>
						<b>1. BUTIRAN PEMOHON</b>
					</div>
					<table style="margin-left: 10px;">
						<tr>
							<td style="vertical-align: text-top;">a.</td>
							<td>Nama Pemohon : {{$app->fullname}}</td>
						</tr>
						<tr>
							<td style="vertical-align: text-top;">b.</td>
							<td>No. Kad Pengenalan (Baru) : {{$app->icno}}</td>
						</tr>
						<tr>
							<td style="vertical-align: text-top;">c.</td>
							<td>Umur : {{$app->icno != null ? Helper::convertIcToAge($app->icno) : ''}}</td>
						</tr>
						<tr>
							<td style="vertical-align: text-top;">d.</td>
							<td>Alamat Surat Menyurat : {{$app->address1 ?? ''}}</td>
						</tr>
						<tr>
							<td style="vertical-align: text-top;">e.</td>
							<td>Daerah :{{$app->district_id != null ? strtoupper(Helper::getCodeMasterNameById($app->district_id)) : '-'}}</td>
						</tr>
						<tr>
							<td style="vertical-align: text-top;">f.</td>
							<td>Poskod : {{$app->postcode}}</td>
						</tr>
						<tr>
							<td style="vertical-align: text-top;">g.</td>
							<td>Negeri : {{$app->state_id != null ? strtoupper(Helper::getCodeMasterNameById($app->state_id)) : '-'}}</td>
						</tr>
						<tr>
							<td style="vertical-align: text-top;">h.</td>
							<td>No. Telefon Rumah/Bimbit : {{$app->contact_number ?? ''}}</td>
						</tr>
						<tr>
							<td style="vertical-align: text-top;">i.</td>
							<td>Nama Bank : {{$app->bank_id != null ? Helper::getCodeMasterNameById($app->bank_id) : ''}}</td>
						</tr>
						<tr>
							<td style="vertical-align: text-top;">j.</td>
							<td>No. Akaun Bank : {{$app->no_account}}</td>
						</tr>
						<tr>
							<td style="vertical-align: text-top;">k.</td>
							<td>Cawangan Bank : {{$app->state_bank_id != null ? strtoupper(Helper::getCodeMasterNameById($app->state_bank_id)) : ''}}</td>
						</tr>
					</table>
					<br\>
					<div>
						<b>2. BUTIRAN PEKERJAAN</b>
					</div>
					<table style="margin-left: 10px;">
						<tr>
							<td style="vertical-align: text-top;">a.</td>
							<td>Sebagai nelayan: {{ $app->fisherman_type_id != null ? Helper::getCodeMasterNameById($app->fisherman_type_id) : '' }}</td>
						</tr>
						<tr>
							<td style="vertical-align: text-top;">b.</td>
							<td>Bilangan hari menangkap ikan sebulan: {{ $app->working_days_fishing_per_month }}</td>
						</tr>
						<tr>
							<td style="vertical-align: text-top;">c.</td>
							<td>
								<div>Pendapatan Sebulan</div>
								<table>
									<tr>
										<td>i.</td>
										<td>Hasil daripada menangkap ikan</td>
										<td>:</td>
										<td>RM{{$app->tot_incomefish}}</td>
									</tr>
									<tr>
										<td>i.</td>
										<td>Hasil daripada pekerjaan lain</td>
										<td>:</td>
										<td>RM{{$app->tot_incomeother}}</td>
									</tr>
									<tr>
										<td></td>
										<td>Jumlah</td>
										<td>:</td>
										<td>RM{{$app->tot_allincome}}</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<br\>
					<div>
						<b>3. BUTIRAN TANGGUNGAN</b>
					</div>
					<table style="margin-left: 10px;">
						<tr>
							<td style="vertical-align: text-top;">a.</td>
							<td>
								<div>Jumlah Tanggungan: {{$app->tot_allchild}} orang</div>
								<table>
									<tr>
										<td>i.</td>
										<td>Bil Anak</td>
										<td>:</td>
										<td>{{$app->tot_child}} orang</td>
									</tr>
									<tr>
										<td>i.</td>
										<td>Lain-lain</td>
										<td>:</td>
										<td>{{$app->tot_otherchild}} orang</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<br\>
					<div>
						<b>4. TAHAP PENDIDIKAN</b>
					</div>
					<table style="margin-left: 10px; width: 70%;">
						<tr>
							<td>
								<input type="checkbox" style="vertical-align: middle;" {{$app->is_primary == 1 ? 'checked' : ''}}><span style="vertical-align: middle;">Sekolah Rendah</span>
							</td>
							<td>
								<input type="checkbox" style="vertical-align: middle;" {{$app->is_secondary == 1 ? 'checked' : ''}}><span style="vertical-align: middle;">Sekolah Menengah</span>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" style="vertical-align: middle;" {{$app->is_uni == 1 ? 'checked' : ''}}><span style="vertical-align: middle;">Kolej/Universiti</span>
							</td>
							<td>
								<input type="checkbox" style="vertical-align: middle;" {{$app->is_notschool == 1 ? 'checked' : ''}}><span style="vertical-align: middle;">Tidak Bersekolah</span>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="page-break"></div>
		<div>
			<div class="card card-info">
				<div class="card-body">
					<hr style="height:1px;border-width:0;color:black;background-color:black">
					<br\>
					<div style="text-align: center;">
						<b><u>AMARAN</u></b>
					</div>
					<br\>
					<div style="text-align: justify;">
						<b>"Mana-mana orang yang mengemukakan pernyataan atau akuan yang mempunyai butiran matan yang palsu adalah melakukan suatu kesalahan di bawah Seksyen 18 Akta Suruhanjaya Pencegahan Rasuah Malaysia 2009 dan jika disabit kesalahan boleh dihukum penjara tidak melebihi 20 tahun dan denda tidak kurang lima kali ganda jumlah/nilai butiran yang palsu itu ataupun sepuluh ribu ringgit (RM10,000.00) mengikut mana yang lebih tinggi"</b>
					</div>
					<br\>
					<br\>
					<div style="text-align: center;">
						<b><u>Akuan Bersumpah:</u></b>
					</div>
					<br\>
					<div style="text-align: justify;">
						Saya membuat perakuan ini dengan kepercayaan bahawa apa-apa yang tersebut di atas adalah benar serta menurut Undang-Undang Surat Akuan 1960 dan mematuhi peruntukan-peruntukan yang termaktub di dalam Akta Akuan Berkanun 1960
					</div>
					<br\>
					<br\>
					<table style="border: 1px solid black; border-collapse: collapse; width: 80%; margin-left: 10%; margin-right: 10%;">
						<tr style="border: 1px solid black;">
							<td style="width: 49%; border: 1px solid black;">Diperbuat dan dengan sebenarnya</td>
							<td style="border: 1px solid black;">)</td>
							<td style="width: 49%; border: 1px solid black;"></td>
						</tr>
						<tr>
							<td style="border: 1px solid black;">Diakui oleh yang tersebut namanya</td>
							<td style="border: 1px solid black;">)</td>
							<td style="border: 1px solid black;"></td>
						</tr>
						<tr>
							<td style="border: 1px solid black;">di atas iaitu:-</td>
							<td style="border: 1px solid black;">)</td>
							<td style="border: 1px solid black;"></td>
						</tr>
						<tr>
							<td style="border: 1px solid black;"></td>
							<td style="border: 1px solid black;">)</td>
							<td style="border: 1px solid black;"></td>
						</tr>
						<tr>
							<td style="border: 1px solid black;">Nama:</td>
							<td style="border: 1px solid black;">)</td>
							<td style="border: 1px solid black;"></td>
						</tr>
						<tr>
							<td style="border: 1px solid black;"></td>
							<td style="border: 1px solid black;">)</td>
							<td style="border: 1px solid black;">Nama:</td>
						</tr>
						<tr>
							<td style="border: 1px solid black;">Alamat:</td>
							<td style="border: 1px solid black;">)</td>
							<td style="border: 1px solid black;">No.K/P:</td>
						</tr>
						<tr>
							<td style="border: 1px solid black;"></td>
							<td style="border: 1px solid black;">)</td>
							<td style="border: 1px solid black;">Tarikh:</td>
						</tr>
						<tr>
							<td style="border: 1px solid black;"></td>
							<td style="border: 1px solid black;">)</td>
							<td style="border: 1px solid black;"></td>
						</tr>
						<tr>
							<td style="border: 1px solid black;"></td>
							<td style="border: 1px solid black;">)</td>
							<td style="border: 1px solid black;"></td>
						</tr>
					</table>
					<br\>
					<div style="text-align: center;">Dihadapan saya,</div>
					<br\>
					<br\>
					<div style="text-align: center;">........................................................................</div>
					<div style="text-align: center;">(Pesuruhjaya Sumpah)</div>
				</div>
			</div>
		</div>
		<script type="text/php">
	        if (isset($pdf)) {
	            $x = 570; // potrait: 570, landscape: 815
	            $y = 815; // potrait: 815, landscape: 570
	            //$text = "{PAGE_NUM}/{PAGE_COUNT}";
				$text = "";
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