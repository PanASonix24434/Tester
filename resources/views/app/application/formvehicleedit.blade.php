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

<ul class="nav nav-tabs" id="custom-content-tab" role="tablist">
    <li class="nav-item">
      <a class="nav-link" id="custom-content-form-tab" href="{{ route('application.formedit', $app[0]->id) }}" role="tab" aria-controls="custom-content-form" aria-selected="false">PARTICULARS OF APPLICANT</a>
    </li>
	@if (strtoupper(Helper::getCodeMasterNameEnById($app[0]->applicant_type_id)) == "WITH GUARANTOR")
		<li class="nav-item">
			<a class="nav-link" id="custom-content-guarantor-tab" href="{{ route('application.formguarantoredit', $app[0]->id) }}" role="tab" aria-controls="custom-content-guarantor" aria-selected="false">PARTICULARS OF GUARANTOR</a>
		</li>
	@endif
	<li class="nav-item">
        <a class="nav-link active" id="custom-content-vehicle-tab" data-toggle="pill" href="#custom-content-vehicle" role="tab" aria-controls="custom-content-vehicle" aria-selected="true">PARTICULARS OF VEHICLE</a>
    </li>
	<li class="nav-item">
        <a class="nav-link" id="custom-content-financing-tab" href="{{ route('application.formfinancingedit', $app[0]->id) }}" role="tab" aria-controls="custom-content-financing" aria-selected="false">PARTICULARS OF FINANCING</a>
    </li>
	<li class="nav-item">
        <a class="nav-link" id="custom-content-document-tab" href="{{ route('application.formdocumentedit', $app[0]->id) }}" role="tab" aria-controls="custom-content-document" aria-selected="false">PARTICULARS OF DOCUMENTS</a>
    </li>
</ul>
<br />
<div class="tab-content" id="custom-content-vehicle">
<form id="form-application-vehicle" method="POST" enctype="multipart/form-data" action="{{ route('application.updateformvehicleedit', $app[0]->id) }}" autocomplete="off">
	@csrf
    <input type="hidden" id="hide_aid" name="hide_aid" value="{{ Helper::uuid() }}">
	<input type="hidden" id="hide_appid" name="hide_appid" value="{{ $app[0]->id }}">
	<div class="row">
        <div class="col-md-12">
           	<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title bold">C. PARTICULARS OF VEHICLE</h3>
				</div>
				<div class="card-body">
					<div class="row"> 
						<div class="col-sm-6"> 
							<div class="form-group">
								<label class="col-form-label">Description Of Vehicle : </label>
								<input type="text" id="txtVehicleDesc" name="txtVehicleDesc" value="{{ strtoupper($app[0]->vehicle_desc) }}" class="form-control" required>
							</div>
							<div class="form-group">	
								<label class="col-form-label">Vehicle Classification : </label>
								<select class="form-control select2" id="selVehicleClass" name="selVehicleClass" required autocomplete="off">
									<option value="">{{ __('app.please_select')}}</option>
									@foreach($vehicleClass as $vc)

										@if ($app[0]->vehicle_class_id == $vc->id)
											<option value="{{$vc->id}}" selected>{{ (App::getLocale() == 'en') ? $vc->name : $vc->name_ms }}</option>	
										@else
											<option value="{{$vc->id}}">{{ (App::getLocale() == 'en') ? $vc->name : $vc->name_ms }}</option>
										@endif

									@endforeach	
								</select>
							</div>
							<div class="form-group">
								<label class="col-form-label">Production Year : </label>
								<input type="number" id="txtProdYear" name="txtProdYear" value="{{ strtoupper($app[0]->production_year) }}" class="form-control">
							</div>
							<div class="form-group">
								<label class="col-form-label">Engine No. : </label>
								<input type="text" id="txtEngineNo" name="txtEngineNo" value="{{ strtoupper($app[0]->engine_no) }}" class="form-control">
							</div>
							<div class="form-group">
								<label class="col-form-label">Address Vehicle To Be Kept  : </label>
								@if ($app[0]->v_address1 != null || $app[0]->v_address1 != '')
									<input type="text" id="txtAddress1" name="txtAddress1" value="{{ strtoupper($app[0]->v_address1) }}" class="form-control" required>
								@elseif($app[0]->home_address1 != null || $app[0]->home_address1 != '')
									<input type="text" id="txtAddress1" name="txtAddress1" value="{{ strtoupper($app[0]->home_address1) }}" class="form-control" required>
								@else
									<input type="text" id="txtAddress1" name="txtAddress1" value="{{ strtoupper($app[0]->v_address1) }}" class="form-control" required>
								@endif

								@if ($app[0]->v_address2 != null || $app[0]->v_address2 != '')
									<input type="text" id="txtAddress2" name="txtAddress2" value="{{ strtoupper($app[0]->v_address2) }}" class="form-control">
								@elseif($app[0]->home_address2 != null || $app[0]->home_address2 != '')
									<input type="text" id="txtAddress2" name="txtAddress2" value="{{ strtoupper($app[0]->home_address2) }}" class="form-control">
								@else
									<input type="text" id="txtAddress2" name="txtAddress2" value="{{ strtoupper($app[0]->v_address2) }}" class="form-control">
								@endif
								
								@if ($app[0]->v_address3 != null || $app[0]->v_address3 != '')
									<input type="text" id="txtAddress3" name="txtAddress3" value="{{ strtoupper($app[0]->v_address3) }}" class="form-control">
								@elseif($app[0]->home_address3 != null || $app[0]->home_address3 != '')
									<input type="text" id="txtAddress3" name="txtAddress3" value="{{ strtoupper($app[0]->home_address3) }}" class="form-control">
								@else
									<input type="text" id="txtAddress3" name="txtAddress3" value="{{ strtoupper($app[0]->v_address3) }}" class="form-control">
								@endif
								
							</div>
							<div class="form-group">
								<label class="col-form-label">Postcode : </label>
								@if ($app[0]->v_postcode != null || $app[0]->v_postcode != '')
									<input type="number" id="txtPostcode" name="txtPostcode" value="{{ strtoupper($app[0]->v_postcode) }}" class="form-control" required>
								@elseif($app[0]->home_postcode != null || $app[0]->home_postcode != '')
									<input type="number" id="txtPostcode" name="txtPostcode" value="{{ strtoupper($app[0]->home_postcode) }}" class="form-control" required>
								@else
								<input type="number" id="txtPostcode" name="txtPostcode" value="{{ strtoupper($app[0]->v_postcode) }}" class="form-control" required>
								@endif
								
							</div>
							<div class="form-group">
								<label class="col-form-label">City : </label>
								@if ($app[0]->v_city != null || $app[0]->v_city != '')
									<input type="text" id="txtCity" name="txtCity" value="{{ strtoupper($app[0]->v_city) }}" class="form-control" required>
								@elseif($app[0]->home_city != null || $app[0]->home_city != '')
									<input type="text" id="txtCity" name="txtCity" value="{{ strtoupper($app[0]->home_city) }}" class="form-control" required>
								@else
									<input type="text" id="txtCity" name="txtCity" value="{{ strtoupper($app[0]->v_city) }}" class="form-control" required>
								@endif
								
							</div>
							<div class="form-group">	
								<label class="col-form-label">State : </label>
								<select class="form-control select2" id="selState" name="selState" required autocomplete="off">
									<option value="">{{ __('app.please_select')}}</option>
									@foreach($states as $st)

										@if ($app[0]->v_state_id == $st->id)
											<option value="{{$st->id}}" selected>{{ (App::getLocale() == 'en') ? $st->name : $st->name_ms }}</option>
										@elseif ($app[0]->home_state_id == $st->id)
											<option value="{{$st->id}}" selected>{{ (App::getLocale() == 'en') ? $st->name : $st->name_ms }}</option>
										@else
											<option value="{{$st->id}}">{{ (App::getLocale() == 'en') ? $st->name : $st->name_ms }}</option>	
										@endif

									@endforeach	
								</select>
							</div>								
						</div>
						<div class="col-sm-6"> 
							<div class="form-group">	
								<label class="col-form-label">Vehicle Category : </label>
								<select class="form-control select2" id="selVehicleCategory" name="selVehicleCategory" required autocomplete="off">
									<option value="">{{ __('app.please_select')}}</option>
									@foreach($vehicleCategory as $vct)
										@if ($app[0]->vehicle_category == $vct->id)
											<option value="{{$vct->id}}" selected>{{ (App::getLocale() == 'en') ? $vct->name : $vct->name_ms }}</option>
										@else
											<option value="{{$vct->id}}">{{ (App::getLocale() == 'en') ? $vct->name : $vct->name_ms }}</option>
										@endif
										
									@endforeach	
								</select>
							</div>
							<div class="form-group">	
								<label class="col-form-label">Vehicle Promotion Code : </label>
								<select class="form-control select2" id="selVehicleCode" name="selVehicleCode" required autocomplete="off">
									<option value="">{{ __('app.please_select')}}</option>
									@foreach($vehicleCode as $vpc)
										@if ($app[0]->vehicle_code_id == $vpc->id)
											<option value="{{$vpc->id}}" selected>{{ (App::getLocale() == 'en') ? $vpc->name : $vpc->name_ms }}</option>
										@else
											<option value="{{$vpc->id}}">{{ (App::getLocale() == 'en') ? $vpc->name : $vpc->name_ms }}</option>
										@endif
									@endforeach	
								</select>
							</div>
							<div class="form-group">
								<label class="col-form-label">Registration No. : </label>
								<input type="text" id="txtRegNo" name="txtRegNo" value="{{ strtoupper($app[0]->registration_no) }}" class="form-control" >
							</div>
							<div class="form-group">
								<label class="col-form-label">Chassis No. : </label>
								<input type="text" id="txtChassisNo" name="txtChassisNo" value="{{ strtoupper($app[0]->chassis_no) }}" class="form-control" >
							</div>								
						</div>
					</div>

					<div class="row">
						<div class="col-12 text-center">
							<a href="{{ route('application.formlist') }}" class="btn btn-default btn-sm"><i class="fas fa-arrow-left"></i><span class="hidden-xs"> {{ __('app.back') }}</span></a>
							<a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="event.preventDefault(); document.getElementById('form-application-vehicle').submit();"><i class="fas fa-save"></i><span class="hidden-xs"> {{ __('app.save') }}</span></a>
						</div>							
					</div>

				</div>
			</div>
		</div>
	</div>

</form>
</div>
		
@endsection

@push('scripts')
	<script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
	<script src="{{ asset('template/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script type="text/javascript">
	    
		bsCustomFileInput.init(); 

    </script>
@endpush

