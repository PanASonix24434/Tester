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
					<table style="width: 100%;">
						<tr>
							<td style="text-align: center;">
								<img src="{{ public_path('images/kru/logo_dof.png') }}" alt="DOF Logo" height="100">
							</td>
						</tr>
					</table>
					<hr style="height:1px;border-width:0;color:black;background-color:black">
					<div class="row">
						<div style="text-align: center;"><b>KELULUSAN PENGGUNAAN KRU BUKAN WARGANEGARA DI ATAS VESEL</b></div>
						<div style="text-align: center;"><b>PENANGKAPAN IKAN TEMPATAN DI BAWAH SEKSYEN 10(1)(b)(c)</b></div>
						<div style="text-align: center;"><b>AKTA PERIKANAN 1985</b></div>
					</div>
					<div class="row">
						<!-- <div style="text-align: right;">Rujukan:..........</div> -->
					</div>
					<div class="row">
						<div style="text-align: center;">AKTA PERIKANAN 1985 (AKTA 317)</div>
						<div style="text-align: center;">PENGGUNAAN KRU BUKAN WARGANEGARA</div>
						<div style="text-align: center;">DI BAWAH SEKSYEN 10(1)(b)(c)</div>
					</div>
					<br/>
					<div class="row">
						<div style="text-align: center;"><b>NAMA PEMILIK VESEL/MAJIKAN : {{$owner}}</b></div>
						<div style="text-align: center;"><b>SENARAI NO. VESEL MILIK MAJIKAN : (seperti Lampiran)</b></div>
					</div>
					<br/>
					<div class="row">
						<div style="text-align: justify;">1.&nbsp;&nbsp;&nbsp;&nbsp;Pada menjalankan kuasa yang diberikan di bawah Seksyen 10(1)(b)(c) Akta Perikanan 1985, Ketua Pengarah Perikanan dengan ini memberikan kelulusan untuk penggunaan sejumlah <b>{{$foreignCrews->count()}}</b> orang Kru Bukan Warganegara untuk bekerja di atas vesel penangkapan ikan tempatan seperti di <b><i><u>Lampiran 1</u></i></b> surat ini.</div>
					</div>
					<br/>
					<div class="row">
						<div style="text-align: justify;">2.&nbsp;&nbsp;&nbsp;&nbsp;Syarat-syarat seperti di <b><i><u>Lampiran 2</u></i></b> hendaklah dikembarkan bersama-sama dan adalah sebahagian daripada lesen vesel dan peralatan menangkap ikan.</div>
					</div>
					<br/>
					<div class="row">
						<div style="text-align: justify;">3.&nbsp;&nbsp;&nbsp;&nbsp;Surat kelulusan ini tertakluk kepada tempoh sah PLKS Jangka Pendek bagi setiap kru.</div>
					</div>
					<br/>
					<div class="row">
						<div style="text-align: justify;">Tarikh Cetak: {{Carbon\Carbon::now()->format('d/m/Y')}}</div>
					</div>
				</div>
			</div>
		</div>
		<div class="page-break"></div>
		<div>
			<div class="card card-info">
				<div class="card-body">
					<span style="float:right;"><b><u>LAMPIRAN</u></b></span>
					<br/><br/>
					<div class="row">
						<div style="text-align: center;"><b>SENARAI NOMBOR VESEL DI BAWAH MAJIKAN</b></div>
					</div>
					<div class="row">
						<table style="width: 100%; margin-left: auto;margin-right: auto;">
							<tr>
								<th style="text-align: left;">Nama Majikan/Pemilik Vesel</th>
								<th style="text-align: center;">:</th>
								<th style="text-align: left;">{{$owner}}</th>
							</tr>
							<tr>
								<th style="text-align: left;">Senarai No. Vesel</th>
								<th style="text-align: center;">:</th>
								<th style="text-align: left;"></th>
							</tr>
						</table>
					</div>
					<br/>
					<ol>
						@foreach ( $allVessel as  $v)
							<li>{{$v->no_pendaftaran}}</li>
						@endforeach
					</ol>
				</div>
			</div>
		</div>
		<div class="page-break"></div>
		<div>
			<div class="card card-info">
				<div class="card-body">
					<span style="float:right;"><b><u>LAMPIRAN 1</u></b></span>
					<br/><br/>
					<div class="row">
						<div style="text-align: center;"><b>MAKLUMAT KRU BUKAN WARGANEGARA YANG BEKERJA DI ATAS VESEL PENANGKAPAN IKAN</b></div>
					</div>
					<br/>
					<div class="row">
						<table style="width: 100%; margin-left: auto;margin-right: auto;">
							<tr>
								<td style="text-align: left;">Nama Majikan/Pemilik Vesel</td>
								<td style="text-align: center;">:</td>
								<td style="text-align: left;">{{$owner}}</td>
							</tr>
							<tr>
								<td style="text-align: left;">Senarai No. Vesel</td>
								<td style="text-align: center;">:</td>
								<td style="text-align: left;">SEPERTI LAMPIRAN</td>
							</tr>
							<tr>
								<td style="text-align: left;">Bil. Kru Bukan Warganegara Yang Diluluskan</td>
								<td style="text-align: center;">:</td>
								<td style="text-align: left;"></td>
							</tr>
						</table>
					</div>
					<br/>
					<div class="row">
						<div>
							<table style="width: 100%; margin-left: auto;margin-right: auto; border: 1px solid black; border-collapse: collapse;">
								<tr>
									<th rowspan="2" style="border: 1px solid black; border-collapse: collapse; text-align: center;">BIL.</th>
									<th rowspan="2" style="border: 1px solid black; border-collapse: collapse; text-align: center;">NAMA KRU BUKAN WARGANEGARA</th>
									<th rowspan="2" style="border: 1px solid black; border-collapse: collapse; text-align: center;">WARGANEGARA</th>
									<th rowspan="2" style="border: 1px solid black; border-collapse: collapse; text-align: center;">JAWATAN</th>
									<th colspan="2" style="border: 1px solid black; border-collapse: collapse; text-align: center;">PASPORT</th>
									<th colspan="2" style="border: 1px solid black; border-collapse: collapse; text-align: center;">PLKS</th>
								</tr>
								<tr>
									<th style="border: 1px solid black; border-collapse: collapse; text-align: center;">NO. PASPORT</th>
									<th style="border: 1px solid black; border-collapse: collapse; text-align: center;">TARIKH TAMAT TEMPOH</th>
									<th style="border: 1px solid black; border-collapse: collapse; text-align: center;">NO. PLKS</th>
									<th style="border: 1px solid black; border-collapse: collapse; text-align: center;">TARIKH TAMAT TEMPOH</th>
								</tr>
								@php
									$count=0;
								@endphp
								@foreach ( $foreignCrews as $foreignKru )
									<tr>
										<td style="border: 1px solid black; border-collapse: collapse; text-align: center;">{{++$count}}</td>
										<td style="border: 1px solid black; border-collapse: collapse; text-align: center;">{{$foreignKru->name}}</td>
										<td style="border: 1px solid black; border-collapse: collapse; text-align: center;">{{ optional(App\Models\CodeMaster::find($foreignKru->source_country_id))->name_ms }}</td>
										<td style="border: 1px solid black; border-collapse: collapse; text-align: center;">{{App\Models\CodeMaster::find($foreignKru->foreign_kru_position_id)->name_ms}}</td>
										<td style="border: 1px solid black; border-collapse: collapse; text-align: center;">{{$foreignKru->passport_number}}</td>
										<td style="border: 1px solid black; border-collapse: collapse; text-align: center;">{{optional($foreignKru->passport_end_date)->format('d/m/Y')}}</td>
										<td style="border: 1px solid black; border-collapse: collapse; text-align: center;">{{$foreignKru->plks_number}}</td>
										<td style="border: 1px solid black; border-collapse: collapse; text-align: center;">{{optional($foreignKru->plks_end_date)->format('d/m/Y')}}</td>
									</tr>
								@endforeach
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="page-break"></div>
		<div>
			<div class="card card-info">
				<div class="card-body">
					<span style="float:right;"><b><u>LAMPIRAN 2</u></b></span>
					<br/><br/>
					<div class="row">
						<div style="text-align: center;"><b>SYARAT-SYARAT PENGGUNAAN KRU BUKAN WARGANEGARA DI ATAS VESEL PENANGKAPAN IKAN</b></div>
						<div style="text-align: center;"><b>(NAMA MAJIKAN/PEMILIK VESEL: {{$owner}})</b></div>
						<div style="text-align: center;"><b>(SENARAI NO VESEL: ...................(SEPERTI LAMPIRAN)................................................)</b></div>
					</div>
					<br/>
					<div class="row">
						<div style="text-align: justify;">1.&nbsp;&nbsp;&nbsp;&nbsp;Surat Kelulusan Penggunaan Kru Bukan Warganegara Di Atas Vesel Penangkapan Ikan hendaklah dibawa bersama di atas vesel dengan pasport antarabangsa yang dicetak pelekat PLKS setiap kali vesel beroperasi.</div>
					</div>
					<br/>
					<div class="row">
						<div style="text-align: justify;">2.&nbsp;&nbsp;&nbsp;&nbsp;Surat kelulusan Kelulusan Penggunaan Kru Bukan Warganegara Di Atas Vesel Penangkapan Ikan Tempatan ini tidak boleh dipindah milik kecuali dengan kebenaran Jabatan Perikanan Malaysia.</div>
					</div>
					<br/>
					<div class="row">
						<div style="text-align: justify;">3.&nbsp;&nbsp;&nbsp;&nbsp;Empunya vesel bertanggungjawab sepenuhnya ke atas kru bukan warganegara di bawah jagaannya dan hendaklah memaklumkan Jabatan Perikanan tentang pergerakan dan juga apabila berlakunya pertukaran kru masing-masing.</div>
					</div>
					<br/>
					<div class="row">
						<div style="text-align: justify;">4.&nbsp;&nbsp;&nbsp;&nbsp;Empunya vesel bertanggungjawab menanggung semua perbelanjaan yang dikenakan dalam urusan membawa masuk dan keluar kru bukan warganegara masing-masing termasuk menghantar kembali kru bukan warganegara ke negara masing-masing apabila perkhidmatan kru tersebut tamat atau diberhentikan.</div>
					</div>
					<br/>
					<div class="row">
						<div style="text-align: justify;">5.&nbsp;&nbsp;&nbsp;&nbsp;Kru bukan warganegara hanya dibenarkan bekerja di atas senarai vesel yang telah diluluskan dan tidak boleh berpindah ke vesel majikan lain kecuali mendapat kelulusan bertulis daripada Ketua Pengarah Perikanan.</div>
					</div>
					<br/>
					<div class="row">
						<div style="text-align: justify;">6.&nbsp;&nbsp;&nbsp;&nbsp;Empunya vesel hendaklah bertanggungjawab memastikan kru bukan warganegara mematuhi undang-undang di bawah Akta Perikanan 1985 dan Peraturan, undang-undang lain yang terpakai serta syarat-syarat lain yang akan dikenakan dari semasa ke semasa.</div>
					</div>
					<br/>
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