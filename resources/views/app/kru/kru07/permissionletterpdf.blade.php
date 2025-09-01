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
					<table>
						<tr>
							<td>
								<img src="{{ public_path('images/kru/jata_negara.png') }}" alt="DOF Logo" height="130">
							</td>
							<td style="vertical-align: top;">
								<div>{{ $stateEntity->entity_name }}</div>
								<div>{{ $stateEntity->address1 }}</div>
								@if ($stateEntity->address2 != null)
									<div>{{ $stateEntity->address2 }}</div>
								@endif
								@if ($stateEntity->address3 != null)
									<div>{{ $stateEntity->address3 }}</div>
								@endif
								<div>{{ $stateEntity->postcode }} {{ $stateEntity->city }}</div>
								<div>Faks: {{ $stateEntity->fax_no }}</div>
								<div>Telefon Pejabat: {{ $stateEntity->entity_phone_no }}</div>
							</td>
						</tr>
					</table>
					<hr style="height:1px;border-width:0;color:black;background-color:black">
					<div>
						<b><i>SEGERA DENGAN FAKS</i></b>
					</div>
					<br/>
					{{----Alamat----}}
					<div class="row">
						<div class="col-sm-12">
							<div>
								Ketua {{ $immigrationOffice }}
							</div>
							<div>
								<b>{{--$name--}}</b>
							</div>
							<div>
								<b>{{--$address1--}}</b>
							</div>
							<div>
								<b>{{--$address2--}}</b>
							</div>
							<div>
								<b>{{--$address3--}}</b>
							</div>
							<div>
								<b>{{--$postcode--}} {{--$city--}}</b>
							</div>
							<div>
								<b>{{--$state--}}</b>
								<span style="float:right;">{{--$approvedDate--}}</span>
							</div>
						</div>
					</div>
					<br/>
					<div class="row">
						<div>Tuan,</div>
						<div><b>KEBENARAN PENGGUNAAN KRU BUKAN WARGANEGARA DI ATAS VESEL PENANGKAPAN IKAN TEMPATAN</b></div>
						<div><b>NAMA SYARIKAT/INDIVIDU DALAM BUKU LESEN: {{$owner}}</b></div>
						<div><b>SENARAI NOMBOR VESEL: (SEPERTI DI LAMPIRAN)</b></div>
						<br/>
						<div>Dengan segala hormatnya perkara diatas dirujuk</div>
						<br/>
					</div>
					<div class="row">
						<div style="text-align: justify;">2.&nbsp;&nbsp;&nbsp;&nbsp;Dengan ini, Jabatan Perikanan Malaysia membenarkan penggunaan kru bukan warganegara bagi vesel berkenaan adalah seperti berikut:</div>
					</div>
					<div class="row">
						<div>
							<table style="width: 100%; margin-left: auto;margin-right: auto; border: 1px solid black; border-collapse: collapse;">
								<tr>
									<th style="border: 1px solid black; border-collapse: collapse; text-align: center;">SENARAI NO VESEL</th>
									<th style="border: 1px solid black; border-collapse: collapse; text-align: center;">ZON</th>
									<th style="border: 1px solid black; border-collapse: collapse; text-align: center;">PANGKALAN / NEGERI</th>
									<th style="border: 1px solid black; border-collapse: collapse; text-align: center;">MUATAN (GRT)</th>
									<th style="border: 1px solid black; border-collapse: collapse; text-align: center;">PERALATAN MENANGKAP IKAN</th>
									<th style="border: 1px solid black; border-collapse: collapse; text-align: center;">TEMPOH SAH LESEN VESEL</th>
									<th style="border: 1px solid black; border-collapse: collapse; text-align: center;">KUOTA KRU MAKSIMUM MAJIKAN</th>
									<th style="border: 1px solid black; border-collapse: collapse; text-align: center;">BIL KRU DIPOHON</th>
								</tr>
								<tr>
									<th style="border: 1px solid black; border-collapse: collapse; text-align: center;">{{$vessel->no_pendaftaran}}</th>
									<th style="border: 1px solid black; border-collapse: collapse; text-align: center;">{{$vessel->zon}}</th>
									<th style="border: 1px solid black; border-collapse: collapse; text-align: center;">{{ App\Models\Entity::find($vessel->entity_id)->entity_name }}</th>
									<th style="border: 1px solid black; border-collapse: collapse; text-align: center;">{{$vessel->grt}}</th>
									<th style="border: 1px solid black; border-collapse: collapse; text-align: center;">{{ App\Models\CodeMaster::find($vessel->peralatan_utama)->name_ms}}</th>
									<th style="border: 1px solid black; border-collapse: collapse; text-align: center;">{{$vessel->license_end}}</th>
									<th style="border: 1px solid black; border-collapse: collapse; text-align: center;">{{$vessel->maximumForeignKru()}}</th>
									<th style="border: 1px solid black; border-collapse: collapse; text-align: center;">{{$foreignKrus->count()}}</th>
								</tr>
							</table>
						</div>
					</div>
					<br/>
					<div class="row">
						<div style="text-align: justify;">3.&nbsp;&nbsp;&nbsp;&nbsp;Untuk makluman tuan, kru berkenaan telah berada di dalam negara dan kini kru berkenaan ditempatkan di <b>{{$appForeign->crew_placement}}</b> di bawah pengawasan <b>{{$appForeign->supervised}}</b>.</div>
					</div>
					<br/>
					<div class="row">
						<div style="text-align: justify;">4.&nbsp;&nbsp;&nbsp;&nbsp;Bersama-sama ini disertakan senarai maklumat kru yang dipohon seperti di Lampiran 1 untuk rujukan tuan selanjutnya.</div>
					</div>
					<br/>
					<div class="row">
						<div style="text-align: justify;">Sekian, terima kasih.</div>
					</div>
					<br/>
					<div class="row">
						<div style="text-align: justify;"><b>“MALAYSIA MADANI”</b></div>
						<div style="text-align: justify;"><b>“BERKHIDMAT UNTUK NEGARA”</b></div>
					</div>
					<!-- PPN Role & Entity Name -->
					<br/>
					<div class="row">
						<div>
							<table>
								<tr>
									<td>Saya yang menjalankan amanah,</td>
								</tr>
								<tr><td>&nbsp;</td></tr>
								<tr>
									<td >{{strtoupper($approver->name)}}</td>
								</tr>
								<tr>
									<td >Ketua Daerah Perikanan {{$entity->entity_name}}</td>
								</tr>
								<tr>
									<td >b/p Ketua Pengarah Perikanan Malaysia</td>
								</tr>
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
					<span style="float:right;"><b><i>Lampiran</i></b></span>
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
					<span style="float:right;"><b><i>Lampiran 1</i></b></span>
					<br/><br/>
					<div class="row">
						<div style="text-align: center;"><b>SENARAI MAKLUMAT KRU BUKAN WARGANEGARA YANG DIBENARKAN BEKERJA DI ATAS VESEL PENANGKAPAN IKAN TEMPATAN</b></div>
					</div>
					<div class="row">
						<div style="text-align: center;">(Tertakluk kepada Akta Perikanan 1985 & Akta Imigresen 1959/63 dan Peraturan-Peraturan)</div>
					</div>
					<br/>
					<div class="row">
						<table style="width: 100%; margin-left: auto;margin-right: auto;">
							<tr>
								<th style="text-align: left;">NAMA SYARIKAT/INDIVIDU PEMEGANG LESEN</th>
								<th style="text-align: center;">:</th>
								<th style="text-align: left;">{{$owner}}</th>
							</tr>
							<tr>
								<th style="text-align: left;">NOMBOR VESEL</th>
								<th style="text-align: center;">:</th>
								<th style="text-align: left;"><i>SEPERTI DI LAMPIRAN</i></th>
							</tr>
						</table>
					</div>
					<br/>
					<div class="row">
						<div>
							<table style="width: 100%; margin-left: auto;margin-right: auto; border: 1px solid black; border-collapse: collapse;">
								<tr>
									<th style="border: 1px solid black; border-collapse: collapse; text-align: center;">BIL</th>
									<th style="border: 1px solid black; border-collapse: collapse; text-align: center;">NAMA KRU</th>
									<th style="border: 1px solid black; border-collapse: collapse; text-align: center;">WARGANEGARA</th>
									<th style="border: 1px solid black; border-collapse: collapse; text-align: center;">TARIKH LAHIR</th>
									<th style="border: 1px solid black; border-collapse: collapse; text-align: center;">UMUR</th>
									<th style="border: 1px solid black; border-collapse: collapse; text-align: center;">JANTINA</th>
									<th style="border: 1px solid black; border-collapse: collapse; text-align: center;">NO. PASPORT</th>
									<th style="border: 1px solid black; border-collapse: collapse; text-align: center;">JAWATAN</th>
									<th style="border: 1px solid black; border-collapse: collapse; text-align: center;">STATUS KEBERADAAN KRU</th>
								</tr>
								@php
									$count=0;
								@endphp
								@foreach ( $foreignKrus as $foreignKru )
									<tr>
										<td style="border: 1px solid black; border-collapse: collapse; text-align: center;">{{++$count}}</td>
										<td style="border: 1px solid black; border-collapse: collapse; text-align: center;">{{$foreignKru->name}}</td>
										<td style="border: 1px solid black; border-collapse: collapse; text-align: center;">{{App\Models\CodeMaster::find($foreignKru->source_country_id)->name_ms }}</td>
										<td style="border: 1px solid black; border-collapse: collapse; text-align: center;">{{$foreignKru->birth_date->format('d/m/Y')}}</td>
										<td style="border: 1px solid black; border-collapse: collapse; text-align: center;">{{$foreignKru->birth_date->age}}</td>
										<td style="border: 1px solid black; border-collapse: collapse; text-align: center;">{{App\Models\CodeMaster::find($foreignKru->gender_id)->name_ms}}</td>
										<td style="border: 1px solid black; border-collapse: collapse; text-align: center;">{{$foreignKru->passport_number}}</td>
										<td style="border: 1px solid black; border-collapse: collapse; text-align: center;">{{App\Models\CodeMaster::find($foreignKru->foreign_kru_position_id)->name_ms}}</td>
										<td style="border: 1px solid black; border-collapse: collapse; text-align: center;">{{$foreignKru->crew_whereabout}}</td>
									</tr>
								@endforeach
							</table>
						</div>
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