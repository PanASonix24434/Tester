@extends('layouts.app')
@include('layouts.page_title')
@push('styles')
	<link rel="stylesheet" href="{{ asset('template/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
	<style type="text/css">
		.card-title a {
			font-weight: bold;
		}
	</style>
@endpush
@section('content')
	<div class="row">
        <div class="col-md-12">
		    <form id="form-mortgage" method="POST" action="#" autocomplete="off">
				<input type="hidden" id="hide_aid" name="hide_aid" value="{{ Helper::uuid() }}">		
				<input type="hidden" id="hide_tc" name="hide_tc" value="">	
				<input type="hidden" id="urlLB" name="urlLB" value="">	
					<div class="card card-info">
						<div class="card-header">
							<h3 class="card-title bold">Maklumat Pendaftaran Gadaian</h3>
						</div>
						<div class="card-body">
							<div class="row"> 
								<div class="col-sm-6"> 
									<div class="form-group">	
										<label class="col-form-label">{{ __('app.name_mortgage') }}</label>
										<input type="text" class="form-control" id="name_mortgagor" name="name_mortgagor" value="Norisham binti Abdul Majid" readonly>
									</div>	
									<div class="form-group">
											<label class="col-form-label">{{ __('app.icno_mortgage') }}</label>
											<input type="text" class="form-control" id="icno_mortgagor" name="icno_mortgagor" value="611001-05-5272" readonly>
									</div>	
									<div class="form-group">
											<label class="col-form-label">{{ __('app.icno_old_mortgage') }}</label>
											<input type="text" class="form-control" id="icno_mortgagor" name="icno_mortgagor" value="6250912" readonly>
									</div>	
									<div class="form-group">
											<label class="col-form-label">{{ __('app.address_mortgage') }}</label>
											<input type="text" class="form-control" id="address1_mortgagor" name="address1_mortgagor" value="KA 82, Kampung Kuala Atok" readonly>
											<input type="text" class="form-control" id="address2_mortgagor" name="address2_mortgagor" value="Sega" readonly>
											<input type="text" class="form-control" id="address3_mortgagor" name="address3_mortgagor" value="27660 Raub, Pahang" readonly>
									</div>							
								</div>
								<div class="col-sm-6"> 
									<div class="form-group">	
										<label class="col-form-label">{{ __('app.total_loan') }}</label>
										<input type="text" class="form-control" id="total_loan" name="total_loan" value="46814" readonly>
									</div>	
									<div class="form-group">
											<label class="col-form-label">{{ __('app.total_monthly') }}</label>
											<input type="text" class="form-control" id="total_monthly" name="total_monthly" value="120" readonly>
									</div>	
									<div class="form-group">
											<label class="col-form-label">{{ __('app.remark_mortgage') }} <i style="color: red;"> *(50 patah perkataan sahaja)</i></label>
											<textarea class="form-control" rows="8"id="remark_mortagge" name="remark" tmaxlength="50"></textarea>
									</div>	
														
								</div>
							</div>	
							
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group row">
										<label class="col-sm-12 col-form-label">Jadual Tanah & Kepentingan :</label>
									</div>
									<table class="table table-bordered">
										<thead>                  
											<tr>
												<th>Bandar/Pekan/Mukim</th>
												<th>No Lot*/Petak/P.T.</th>
												<th>Jenis dan No Hakmilik</th>	  
												<th>Bahagian Tanah</th>	
												<th>No Berdaftar* Pajakan/pajakan kecil (jika ada)</th>  
												<th>No Berdaftar Gadaian (jika ada)</th>	
											</tr>
										</thead>
										<tbody id="listLand">
										<tr>
                                            <td>Sega</td>
											<td>LOT 1325</td>
											<td>GM 2390</td>
											<td>SEMUA</td>
											<td>-</td>
											<td>-</td>
										</tr>
										</tbody>
									</table>
								</div>
							</div>				
	                       
							<div class="row">
								<div class="col-12 text-center">
								<a href="{{ route('mortgage.list.index') }}" class="btn btn-default">
										<i class="fas fa-arrow-left"></i> {{ __('app.back') }}
									</a>
									<button id="save_giid" type="submit" class="btn btn-primary">
										<i class="fas fa-save"></i> {{ __('app.save') }}
									</button>
								</div>							
							</div>	
						</div>
					</div>
	        </form>
		</div>
	</div>
		
@endsection
@push('scripts')
	<script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
	<script src="{{ asset('template/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script type="text/javascript">


$(document).ready(function(){
			$(document).on('change', '#selCountry', function(){
				var country = $('#selCountry option:selected').val();
				var state = $('#selState');
				state.empty();
				state.append("<option value=''>{{ __('app.please_select')}}</option>");
				
				if(country){
					$.get("{{ url('app/state') }}/"+country, function(data){
						$.each(data, function(key,value){
							state.append("<option value='"+value.id+"'>"+value.name+"</option>");
						});
					});
				}
				else{
					state.val(null).trigger('change');
				}
			});
			$(document).on('change', '#selState', function(){
				var state = $('#selState option:selected').val();
				var district = $('#selDistrict');
				district.empty();
				district.append("<option value=''>{{ __('app.please_select')}}</option>");
				
				if(state){
					$.get("{{ url('app/district') }}/"+state, function(data){
						$.each(data, function(key,value){
							district.append("<option value='"+value.id+"'>"+value.name+"</option>");
						});
					});
				}
			});
		});



	
		
    </script>
@endpush