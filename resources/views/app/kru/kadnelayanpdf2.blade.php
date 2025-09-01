<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>{{ __('module.users') }}.pdf</title>
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
			.rectangle {
				/* Set dimensions directly in mm */
				width: 50mm;
				height: 35mm;
				/* border: 1px solid black; A border to make it visible */
				background-color: white; /* Example fill color */
				display: inline-block;
			}
			.no-border-table {
				/* width: 80%;
				margin: 20px auto; */
				border-collapse: collapse; /* Important: Collapses the table borders into a single model */
			}

			.no-border-table th,
			.no-border-table td {
				border: none; /* Removes the borders from individual cells (th, td) */
				/* padding: 8px;
				text-align: left; */
			}

			
	    </style>
	</head>
	<body>
		<table class="no-border-table" style="width: 40%;">
			<thead>
				<tr>
					<th style="text-align: center; background-color: yellow">Jabatan Perikanan Malaysia</th>
				</tr>
			</thead>
			<tbody style="background-color: lightblue;">
				<tr>
					<td style="text-align: center;">
						<br/>
						<div class="rectangle" style="width: 35mm; height: 50mm;">
						</div>
					</td>
				</tr>
				<tr>
					<td style="text-align: center;">
						<br/>
						<div>KAD PENDAFTARAN NELAYAN</div>
						<div style="font-size: 0.8rem;">{{ $appKru->name }}</div>
						<div style="font-size: 0.8rem;">No. KP : {{ $appKru->ic_number }}</div>
						<div style="font-size: 0.8rem;">{{ $vessel->no_pendaftaran }}</div>
						<div style="font-size: 0.8rem;">{{ $appKru->address1 }}</div>
						<div style="font-size: 0.8rem;">{{ $appKru->address2 }}</div>
						<div style="font-size: 0.8rem;">{{ $appKru->address3 }}</div>
						<div style="font-size: 0.8rem;">{{ $appKru->postcode }} {{ $appKru->city }}</div>
						<div style="font-size: 0.8rem;">{{ optional($app->registration_start)->format('d/m/Y') }} - {{ optional($app->registration_end)->format('d/m/Y') }}</div>
						<div style="font-size: 0.8rem; color: red;">No. Siri : {{ $appKru->ssd_number }}</div>
						<br/>
					</td>
				</tr>
			</tbody>
		</table>
		<br/>
		<table class="no-border-table" style="width: 40%;">
			<tbody>
				<tr>
					<td></td>
					<td style="text-align: center;">
						<br/>
						<div><b>SYARAT KAD PENDAFTARAN NELAYAN</b></div>
						<br/>
					</td>
				</tr>
				<tr>
					<td style="font-size: 0.7rem; vertical-align: top;">1.</td>
					<td>
						<div style="font-size: 0.7rem;">Penama ini adalah pemegang Kad pendaftaran Nelayan (KPN) yang berdaftar secara sah dengan Jabatan Perikanan Malaysia.</div>
					</td>
				</tr>
				<tr>
					<td style="font-size: 0.7rem; vertical-align: top;">2.</td>
					<td>
						<div style="font-size: 0.7rem;">Tempoh sah laku KPN adalah selama satu tahun. KPN boleh diperbaharui seawal 30 hari sebelum tamat tempoh melalui sistem eLesen.</div>
					</td>
				</tr>
				<tr>
					<td style="font-size: 0.7rem; vertical-align: top;">3.</td>
					<td>
						<div style="font-size: 0.7rem;">KPN ini tidak boleh dipindah milik dan perlu diserahkan kembali kepada Pejabat Perikanan Daerah sekiranya berlaku kematian penama.</div>
					</td>
				</tr>
				<tr>
					<td style="font-size: 0.7rem; vertical-align: top;">4.</td>
					<td>
						<div style="font-size: 0.7rem;">KPN perlu dibawa bersama semasa berada di laut untuk semakan dan pengesahan oleh mana-mana Agensi Penguatkuasa.</div>
					</td>
				</tr>
				<tr>
					<td style="font-size: 0.7rem; vertical-align: top;">5.</td>
					<td>
						<div style="font-size: 0.7rem;">Warganegara bewarna biru sementara KPN Pemastautin Tetap bewarna merah.</div>
					</td>
				</tr>
				<tr>
					<td style="font-size: 0.7rem; vertical-align: top;">6.</td>
					<td>
						<div style="font-size: 0.7rem;">Sebarang kesilapan butiran KPN perlu dirujuk kepada Pejabat Perikanan Daerah untuk pembetulan.</div>
					</td>
				</tr>
				<tr>
					<td style="font-size: 0.7rem; vertical-align: top;">7.</td>
					<td>
						<div style="font-size: 0.7rem;">Kad ini adalah milik Jabatan Perikanan Malaysia. Sekiranya terjumpa, sila pulangkan ke Balai Polis atau Pejabat Perikanan Daerah terdekat.</div>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: center;">
						<br/>
						<div style="font-size: 0.7rem;">Tandatangan Ketua Daerah Perikanan</div>
						<br/>
					</td>
				</tr>
			</tbody>
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