<!DOCTYPE html>
<html lang="{{-- str_replace('_', '-', app()->getLocale()) --}}">
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>memo.pdf</title>
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

			.bordered-table {
				border-collapse: collapse;
			}

			.bordered-table th,
			.bordered-table td {
				border: 1px solid black;
				padding: 8px;
				text-align: left; /* Optional: Align text left within cells */
				vertical-align: top;
			}
			
			.bordered-table-centered {
				border-collapse: collapse;
			}

			.bordered-table-centered th,
			.bordered-table-centered td {
				border: 1px solid black;
				padding: 8px;
				text-align: center; /* Optional: Align text left within cells */
				vertical-align: top;
			}
	        
	    </style>
		@php
			$month = Carbon\Carbon::create($subPaymentHq->year, $subPaymentHq->month, 1)->isoFormat('MMMM');
		@endphp
	</head>
	<body>
		<div class="row">
			<div class="card">
				<div class="card-body">
					<div style="text-align: center;">
						<img src="{{ public_path('images/esh/jata_negara.png') }}" alt="DOF Logo" height="100">
					</div>
					<br/>
					<div style="text-align: center;"><b>MEMO</b></div>
					<div style="text-align: center;"><b>BAHAGIAN SUMBER PERIKANAN TANGKAPAN</b></div>
					<br/>
					<table class="bordered-table" style="width: 100%;">
						<tr>
							<td style="width: 55%;">
								<div><b>Kepada :</b></div>
								<div>Pengarah</div>
								<div>Bahagian Khidmat Pengurusan</div>
								<div>(u.p. Ketua Cawangan Kewangan dan Perolehan)</div>
							</td>
							<td>
								<b>Salinan :</b>
							</td>
						</tr>
						<tr>
							<td>
								<div><b>Daripada :</b></div>
								<div>Pengarah Kanan</div>
								<div>Bahagian Sumber Perikanan Tangkapan</div>
							</td>
							<td>
								<div><b>Tarikh :</b></div>
								<div>&nbsp;</div>
								<div><b>Rujukan Kami :</b></div>
							</td>
						</tr>
					</table>
					<br/>
					<div>Tuan</div>
					<br/>
					<div style="text-align: justify;"><b>SENARAI PENERIMA ELAUN SARA HIDUP NELAYAN DARAT (ESHND) BAGI BAYARAN BULAN {{ strtoupper($month) }} {{$subPaymentHq->year}}</b></div>
					<br/>
					<div>Dengan hormatnya perkara diatas adalah dirujuk</div>
					<br/>
					<div style="text-align: justify;">
						2.&nbsp;&nbsp;&nbsp;&nbsp;Dimaklumkan bahawa jumlah keseluruhan penerima elaun sara hidup nelayan darat bagi bayaran bulan {{ $month }} {{$subPaymentHq->year}} ialah seramai <b>{{ $count }} orang</b> yang melibatkan peruntukan sebanyak <b>RM{{ $count * 250 }}.00</b>.
						Untuk makluman juga. terdapat penerima ESHND yang tertangguh bagi bayaran bulan lepas kerana tidak mengemukakan borang pendaratan (PDP Darat 01/2014) akan dibayar bersama bayaran bulan {{ $month }} {{$subPaymentHq->year}}.
					</div>
					<br/>
					<div style="text-align: justify;">
						3.&nbsp;&nbsp;&nbsp;&nbsp;Sehubungan dengan itu, Bahagian ini memohon kerjasama pihak tuan untuk menyalurkan peruntukan sejumlah <b>RM{{ $count * 250 }}.00</b> kepada pihak Agrobank bagi tujuan pembayaran elaun sara hidup nelayan darat bagi bayaran bulan {{ $month }} {{$subPaymentHq->year}}.
					</div>
					<br/>
					<div style="text-align: justify;">
						4.&nbsp;&nbsp;&nbsp;&nbsp;Bersama ini disertakan salinan surat dari pihak Agrobank berkaitan maklumat akaun bagi penyaluran peruntukan elaun sara hidup tersebut dan senarai penerima elaun mengikut negeri untuk perhatian dan tindakan pihak tuan selanjutnya.
					</div>
					<br/>
					<div style="text-align: justify;">
						5.&nbsp;&nbsp;&nbsp;&nbsp;Kerjasama dan perhatian pihak tuan berhubung perkara ini amatlah dihargai dan didahului dengan ucapan ribuan terima kasih.
					</div>
					<br/>
					<br/>
					<div>
						Sekian.
					</div>
				</div>
			</div>
		</div>
		<div class="page-break"></div>
		<div>
			<div class="card">
				<div class="card-body">
					<div style="text-align: center;">
						<b>BILANGAN PENERIMA DAN JUMLAH AMAUN</b>
					</div>
					<div style="text-align: center;">
						<b>BAYARAN ELAUN SARA HIDUP NELAYAN DARAT (ESHND)</b>
					</div>
					<div style="text-align: center;">
						<b>BAGI BULAN {{ strtoupper($month) }} {{$subPaymentHq->year}}</b>
					</div>
					<br/>
					<table class="bordered-table-centered" style="width: 100%;">
						<tr style="background-color: lightgrey;">
							<td>Bil.</td>
							<td>Negeri</td>
							<td>Bilangan Penerima (Orang)</td>
							<td>Jumlah Amaun (RM)</td>
						</tr>
						<tr>
							<td>1</td><td>Perlis</td>
							<td>{{ $payeesPls->count() }}</td><td>{{ $payeesPls->count() * 250 }}</td>
						</tr>
						<tr>
							<td>2</td><td>Kedah</td>
							<td>{{ $payeesKdh->count() }}</td><td>{{ $payeesKdh->count() * 250 }}</td>
						</tr>
						<tr>
							<td>3</td><td>P. Pinang</td>
							<td>{{ $payeesPng->count() }}</td><td>{{ $payeesPng->count() * 250 }}</td>
						</tr>
						<tr>
							<td>4</td><td>Perak</td>
							<td>{{ $payeesPrk->count() }}</td><td>{{ $payeesPrk->count() * 250 }}</td>
						</tr>
						<tr>
							<td>5</td><td>Selangor</td>
							<td>{{ $payeesSlg->count() }}</td><td>{{ $payeesSlg->count() * 250 }}</td>
						</tr>
						<tr>
							<td>6</td><td>Negeri Sembilan</td>
							<td>{{ $payeesN9->count() }}</td><td>{{ $payeesN9->count() * 250 }}</td>
						</tr>
						<tr>
							<td>7</td><td>Melaka</td>
							<td>{{ $payeesMlk->count() }}</td><td>{{ $payeesMlk->count() * 250 }}</td>
						</tr>
						<tr>
							<td>8</td><td>Johor</td>
							<td>{{ $payeesJhr->count() }}</td><td>{{ $payeesJhr->count() * 250 }}</td>
						</tr>
						<tr>
							<td>9</td><td>Pahang</td>
							<td>{{ $payeesPhg->count() }}</td><td>{{ $payeesPhg->count() * 250 }}</td>
						</tr>
						<tr>
							<td>10</td><td>Terengganu</td>
							<td>{{ $payeesTrg->count() }}</td><td>{{ $payeesTrg->count() * 250 }}</td>
						</tr>
						<tr>
							<td>11</td><td>Kelantan</td>
							<td>{{ $payeesKln->count() }}</td><td>{{ $payeesKln->count() * 250 }}</td>
						</tr>
						<tr>
							<td>12</td><td>Sarawak</td>
							<td>{{ $payeesSwk->count() }}</td><td>{{ $payeesSwk->count() * 250 }}</td>
						</tr>
						<tr>
							<td>13</td><td>Sabah</td>
							<td>{{ $payeesSbh->count() }}</td><td>{{ $payeesSbh->count() * 250 }}</td>
						</tr>
						<tr>
							<td colspan="2"><b>Jumlah</b></td>
							<td><b>{{ $count }}</b></td><td><b>{{ $count * 250 }}</b></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="page-break"></div>
		<div>
			<div class="card">
				<div class="card-body">
					<div style="text-align: center;">
						<b>SENARAI PENERIMA ELAUN SARA HIDUP NELAYAN DARAT (ESHND)</b>
					</div>
					<div style="text-align: center;">
						<b>NEGERI PERLIS BULAN {{ strtoupper($month) }} {{$subPaymentHq->year}}</b>
					</div>
					<br/>
					<table class="bordered-table-centered" style="width: 100%;">
						@php
							$payeeCount = 0;
							$amountTotal = 0;
						@endphp
						<tr style="background-color: lightgrey;">
							<td>Bil</td>
							<td>Nama Nelayan</td>
							<td>No. Kad Pengenalan Baru</td>
							<td>Amount (RM)</td>
						</tr>
						@if ($payeesPls->count() > 0)
							@foreach ( $payeesPls as $payee )
								@php
									$rm = 250 * 1;
									$amountTotal += $rm;
								@endphp
								<tr>
									<td>{{ ++$payeeCount }}</td>
									<td>{{ $payee->name }}</td>
									<td>{{ $payee->icno }}</td>
									<td>{{ $rm }}.00</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="4">-Tiada Penerima Elaun-</td>
							</tr>
						@endif
						<tr>
							<td colspan="3"><b>JUMLAH</b></td>
							<td><b>{{ $amountTotal }}.00</b></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="page-break"></div>
		<div>
			<div class="card">
				<div class="card-body">
					<div style="text-align: center;">
						<b>SENARAI PENERIMA ELAUN SARA HIDUP NELAYAN DARAT (ESHND)</b>
					</div>
					<div style="text-align: center;">
						<b>NEGERI KEDAH BULAN {{ strtoupper($month) }} {{$subPaymentHq->year}}</b>
					</div>
					<br/>
					<table class="bordered-table-centered" style="width: 100%;">
						@php
							$payeeCount = 0;
							$amountTotal = 0;
						@endphp
						<tr style="background-color: lightgrey;">
							<td>Bil</td>
							<td>Nama Nelayan</td>
							<td>No. Kad Pengenalan Baru</td>
							<td>Amount (RM)</td>
						</tr>
						@if ($payeesKdh->count() > 0)
							@foreach ( $payeesKdh as $payee )
								@php
									$rm = 250 * 1;
									$amountTotal += $rm;
								@endphp
								<tr>
									<td>{{ ++$payeeCount }}</td>
									<td>{{ $payee->name }}</td>
									<td>{{ $payee->icno }}</td>
									<td>{{ $rm }}.00</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="4">-Tiada Penerima Elaun-</td>
							</tr>
						@endif
						<tr>
							<td colspan="3"><b>JUMLAH</b></td>
							<td><b>{{ $amountTotal }}.00</b></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="page-break"></div>
		<div>
			<div class="card">
				<div class="card-body">
					<div style="text-align: center;">
						<b>SENARAI PENERIMA ELAUN SARA HIDUP NELAYAN DARAT (ESHND)</b>
					</div>
					<div style="text-align: center;">
						<b>NEGERI PULAU PINANG BULAN {{ strtoupper($month) }} {{$subPaymentHq->year}}</b>
					</div>
					<br/>
					<table class="bordered-table-centered" style="width: 100%;">
						@php
							$payeeCount = 0;
							$amountTotal = 0;
						@endphp
						<tr style="background-color: lightgrey;">
							<td>Bil</td>
							<td>Nama Nelayan</td>
							<td>No. Kad Pengenalan Baru</td>
							<td>Amount (RM)</td>
						</tr>
						@if ($payeesPng->count() > 0)
							@foreach ( $payeesPng as $payee )
								@php
									$rm = 250 * 1;
									$amountTotal += $rm;
								@endphp
								<tr>
									<td>{{ ++$payeeCount }}</td>
									<td>{{ $payee->name }}</td>
									<td>{{ $payee->icno }}</td>
									<td>{{ $rm }}.00</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="4">-Tiada Penerima Elaun-</td>
							</tr>
						@endif
						<tr>
							<td colspan="3"><b>JUMLAH</b></td>
							<td><b>{{ $amountTotal }}.00</b></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="page-break"></div>
		<div>
			<div class="card">
				<div class="card-body">
					<div style="text-align: center;">
						<b>SENARAI PENERIMA ELAUN SARA HIDUP NELAYAN DARAT (ESHND)</b>
					</div>
					<div style="text-align: center;">
						<b>NEGERI PERAK BULAN {{ strtoupper($month) }} {{$subPaymentHq->year}}</b>
					</div>
					<br/>
					<table class="bordered-table-centered" style="width: 100%;">
						@php
							$payeeCount = 0;
							$amountTotal = 0;
						@endphp
						<tr style="background-color: lightgrey;">
							<td>Bil</td>
							<td>Nama Nelayan</td>
							<td>No. Kad Pengenalan Baru</td>
							<td>Amount (RM)</td>
						</tr>
						@if ($payeesPrk->count() > 0)
							@foreach ( $payeesPrk as $payee )
								@php
									$rm = 250 * 1;
									$amountTotal += $rm;
								@endphp
								<tr>
									<td>{{ ++$payeeCount }}</td>
									<td>{{ $payee->name }}</td>
									<td>{{ $payee->icno }}</td>
									<td>{{ $rm }}.00</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="4">-Tiada Penerima Elaun-</td>
							</tr>
						@endif
						<tr>
							<td colspan="3"><b>JUMLAH</b></td>
							<td><b>{{ $amountTotal }}.00</b></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="page-break"></div>
		<div>
			<div class="card">
				<div class="card-body">
					<div style="text-align: center;">
						<b>SENARAI PENERIMA ELAUN SARA HIDUP NELAYAN DARAT (ESHND)</b>
					</div>
					<div style="text-align: center;">
						<b>NEGERI SELANGOR BULAN {{ strtoupper($month) }} {{$subPaymentHq->year}}</b>
					</div>
					<br/>
					<table class="bordered-table-centered" style="width: 100%;">
						@php
							$payeeCount = 0;
							$amountTotal = 0;
						@endphp
						<tr style="background-color: lightgrey;">
							<td>Bil</td>
							<td>Nama Nelayan</td>
							<td>No. Kad Pengenalan Baru</td>
							<td>Amount (RM)</td>
						</tr>
						@if ($payeesSlg->count() > 0)
							@foreach ( $payeesSlg as $payee )
								@php
									$rm = 250 * 1;
									$amountTotal += $rm;
								@endphp
								<tr>
									<td>{{ ++$payeeCount }}</td>
									<td>{{ $payee->name }}</td>
									<td>{{ $payee->icno }}</td>
									<td>{{ $rm }}.00</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="4">-Tiada Penerima Elaun-</td>
							</tr>
						@endif
						<tr>
							<td colspan="3"><b>JUMLAH</b></td>
							<td><b>{{ $amountTotal }}.00</b></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="page-break"></div>
		<div>
			<div class="card">
				<div class="card-body">
					<div style="text-align: center;">
						<b>SENARAI PENERIMA ELAUN SARA HIDUP NELAYAN DARAT (ESHND)</b>
					</div>
					<div style="text-align: center;">
						<b>NEGERI SEMBILAN BULAN {{ strtoupper($month) }} {{$subPaymentHq->year}}</b>
					</div>
					<br/>
					<table class="bordered-table-centered" style="width: 100%;">
						@php
							$payeeCount = 0;
							$amountTotal = 0;
						@endphp
						<tr style="background-color: lightgrey;">
							<td>Bil</td>
							<td>Nama Nelayan</td>
							<td>No. Kad Pengenalan Baru</td>
							<td>Amount (RM)</td>
						</tr>
						@if ($payeesN9->count() > 0)
							@foreach ( $payeesN9 as $payee )
								@php
									$rm = 250 * 1;
									$amountTotal += $rm;
								@endphp
								<tr>
									<td>{{ ++$payeeCount }}</td>
									<td>{{ $payee->name }}</td>
									<td>{{ $payee->icno }}</td>
									<td>{{ $rm }}.00</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="4">-Tiada Penerima Elaun-</td>
							</tr>
						@endif
						<tr>
							<td colspan="3"><b>JUMLAH</b></td>
							<td><b>{{ $amountTotal }}.00</b></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="page-break"></div>
		<div>
			<div class="card">
				<div class="card-body">
					<div style="text-align: center;">
						<b>SENARAI PENERIMA ELAUN SARA HIDUP NELAYAN DARAT (ESHND)</b>
					</div>
					<div style="text-align: center;">
						<b>NEGERI MELAKA BULAN {{ strtoupper($month) }} {{$subPaymentHq->year}}</b>
					</div>
					<br/>
					<table class="bordered-table-centered" style="width: 100%;">
						@php
							$payeeCount = 0;
							$amountTotal = 0;
						@endphp
						<tr style="background-color: lightgrey;">
							<td>Bil</td>
							<td>Nama Nelayan</td>
							<td>No. Kad Pengenalan Baru</td>
							<td>Amount (RM)</td>
						</tr>
						@if ($payeesMlk->count() > 0)
							@foreach ( $payeesMlk as $payee )
								@php
									$rm = 250 * 1;
									$amountTotal += $rm;
								@endphp
								<tr>
									<td>{{ ++$payeeCount }}</td>
									<td>{{ $payee->name }}</td>
									<td>{{ $payee->icno }}</td>
									<td>{{ $rm }}.00</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="4">-Tiada Penerima Elaun-</td>
							</tr>
						@endif
						<tr>
							<td colspan="3"><b>JUMLAH</b></td>
							<td><b>{{ $amountTotal }}.00</b></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="page-break"></div>
		<div>
			<div class="card">
				<div class="card-body">
					<div style="text-align: center;">
						<b>SENARAI PENERIMA ELAUN SARA HIDUP NELAYAN DARAT (ESHND)</b>
					</div>
					<div style="text-align: center;">
						<b>NEGERI JOHOR BULAN {{ strtoupper($month) }} {{$subPaymentHq->year}}</b>
					</div>
					<br/>
					<table class="bordered-table-centered" style="width: 100%;">
						@php
							$payeeCount = 0;
							$amountTotal = 0;
						@endphp
						<tr style="background-color: lightgrey;">
							<td>Bil</td>
							<td>Nama Nelayan</td>
							<td>No. Kad Pengenalan Baru</td>
							<td>Amount (RM)</td>
						</tr>
						@if ($payeesJhr->count() > 0)
							@foreach ( $payeesJhr as $payee )
								@php
									$rm = 250 * 1;
									$amountTotal += $rm;
								@endphp
								<tr>
									<td>{{ ++$payeeCount }}</td>
									<td>{{ $payee->name }}</td>
									<td>{{ $payee->icno }}</td>
									<td>{{ $rm }}.00</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="4">-Tiada Penerima Elaun-</td>
							</tr>
						@endif
						<tr>
							<td colspan="3"><b>JUMLAH</b></td>
							<td><b>{{ $amountTotal }}.00</b></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="page-break"></div>
		<div>
			<div class="card">
				<div class="card-body">
					<div style="text-align: center;">
						<b>SENARAI PENERIMA ELAUN SARA HIDUP NELAYAN DARAT (ESHND)</b>
					</div>
					<div style="text-align: center;">
						<b>NEGERI PAHANG BULAN {{ strtoupper($month) }} {{$subPaymentHq->year}}</b>
					</div>
					<br/>
					<table class="bordered-table-centered" style="width: 100%;">
						@php
							$payeeCount = 0;
							$amountTotal = 0;
						@endphp
						<tr style="background-color: lightgrey;">
							<td>Bil</td>
							<td>Nama Nelayan</td>
							<td>No. Kad Pengenalan Baru</td>
							<td>Amount (RM)</td>
						</tr>
						@if ($payeesPhg->count() > 0)
							@foreach ( $payeesPhg as $payee )
								@php
									$rm = 250 * 1;
									$amountTotal += $rm;
								@endphp
								<tr>
									<td>{{ ++$payeeCount }}</td>
									<td>{{ $payee->name }}</td>
									<td>{{ $payee->icno }}</td>
									<td>{{ $rm }}.00</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="4">-Tiada Penerima Elaun-</td>
							</tr>
						@endif
						<tr>
							<td colspan="3"><b>JUMLAH</b></td>
							<td><b>{{ $amountTotal }}.00</b></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="page-break"></div>
		<div>
			<div class="card">
				<div class="card-body">
					<div style="text-align: center;">
						<b>SENARAI PENERIMA ELAUN SARA HIDUP NELAYAN DARAT (ESHND)</b>
					</div>
					<div style="text-align: center;">
						<b>NEGERI TERENGGANU BULAN {{ strtoupper($month) }} {{$subPaymentHq->year}}</b>
					</div>
					<br/>
					<table class="bordered-table-centered" style="width: 100%;">
						@php
							$payeeCount = 0;
							$amountTotal = 0;
						@endphp
						<tr style="background-color: lightgrey;">
							<td>Bil</td>
							<td>Nama Nelayan</td>
							<td>No. Kad Pengenalan Baru</td>
							<td>Amount (RM)</td>
						</tr>
						@if ($payeesTrg->count() > 0)
							@foreach ( $payeesTrg as $payee )
								@php
									$rm = 250 * 1;
									$amountTotal += $rm;
								@endphp
								<tr>
									<td>{{ ++$payeeCount }}</td>
									<td>{{ $payee->name }}</td>
									<td>{{ $payee->icno }}</td>
									<td>{{ $rm }}.00</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="4">-Tiada Penerima Elaun-</td>
							</tr>
						@endif
						<tr>
							<td colspan="3"><b>JUMLAH</b></td>
							<td><b>{{ $amountTotal }}.00</b></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="page-break"></div>
		<div>
			<div class="card">
				<div class="card-body">
					<div style="text-align: center;">
						<b>SENARAI PENERIMA ELAUN SARA HIDUP NELAYAN DARAT (ESHND)</b>
					</div>
					<div style="text-align: center;">
						<b>NEGERI KELANTAN BULAN {{ strtoupper($month) }} {{$subPaymentHq->year}}</b>
					</div>
					<br/>
					<table class="bordered-table-centered" style="width: 100%;">
						@php
							$payeeCount = 0;
							$amountTotal = 0;
						@endphp
						<tr style="background-color: lightgrey;">
							<td>Bil</td>
							<td>Nama Nelayan</td>
							<td>No. Kad Pengenalan Baru</td>
							<td>Amount (RM)</td>
						</tr>
						@if ($payeesKln->count() > 0)
							@foreach ( $payeesKln as $payee )
								@php
									$rm = 250 * 1;
									$amountTotal += $rm;
								@endphp
								<tr>
									<td>{{ ++$payeeCount }}</td>
									<td>{{ $payee->name }}</td>
									<td>{{ $payee->icno }}</td>
									<td>{{ $rm }}.00</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="4">-Tiada Penerima Elaun-</td>
							</tr>
						@endif
						<tr>
							<td colspan="3"><b>JUMLAH</b></td>
							<td><b>{{ $amountTotal }}.00</b></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="page-break"></div>
		<div>
			<div class="card">
				<div class="card-body">
					<div style="text-align: center;">
						<b>SENARAI PENERIMA ELAUN SARA HIDUP NELAYAN DARAT (ESHND)</b>
					</div>
					<div style="text-align: center;">
						<b>NEGERI SARAWAK BULAN {{ strtoupper($month) }} {{$subPaymentHq->year}}</b>
					</div>
					<br/>
					<table class="bordered-table-centered" style="width: 100%;">
						@php
							$payeeCount = 0;
							$amountTotal = 0;
						@endphp
						<tr style="background-color: lightgrey;">
							<td>Bil</td>
							<td>Nama Nelayan</td>
							<td>No. Kad Pengenalan Baru</td>
							<td>Amount (RM)</td>
						</tr>
						@if ($payeesSwk->count() > 0)
							@foreach ( $payeesSwk as $payee )
								@php
									$rm = 250 * 1;
									$amountTotal += $rm;
								@endphp
								<tr>
									<td>{{ ++$payeeCount }}</td>
									<td>{{ $payee->name }}</td>
									<td>{{ $payee->icno }}</td>
									<td>{{ $rm }}.00</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="4">-Tiada Penerima Elaun-</td>
							</tr>
						@endif
						<tr>
							<td colspan="3"><b>JUMLAH</b></td>
							<td><b>{{ $amountTotal }}.00</b></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="page-break"></div>
		<div>
			<div class="card">
				<div class="card-body">
					<div style="text-align: center;">
						<b>SENARAI PENERIMA ELAUN SARA HIDUP NELAYAN DARAT (ESHND)</b>
					</div>
					<div style="text-align: center;">
						<b>NEGERI SABAH BULAN {{ strtoupper($month) }} {{$subPaymentHq->year}}</b>
					</div>
					<br/>
					<table class="bordered-table-centered" style="width: 100%;">
						@php
							$payeeCount = 0;
							$amountTotal = 0;
						@endphp
						<tr style="background-color: lightgrey;">
							<td>Bil</td>
							<td>Nama Nelayan</td>
							<td>No. Kad Pengenalan Baru</td>
							<td>Amount (RM)</td>
						</tr>
						@if ($payeesSbh->count() > 0)
							@foreach ( $payeesSbh as $payee )
								@php
									$rm = 250 * 1;
									$amountTotal += $rm;
								@endphp
								<tr>
									<td>{{ ++$payeeCount }}</td>
									<td>{{ $payee->name }}</td>
									<td>{{ $payee->icno }}</td>
									<td>{{ $rm }}.00</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="4">-Tiada Penerima Elaun-</td>
							</tr>
						@endif
						<tr>
							<td colspan="3"><b>JUMLAH</b></td>
							<td><b>{{ $amountTotal }}.00</b></td>
						</tr>
					</table>
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