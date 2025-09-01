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
      <a class="nav-link" id="custom-content-form-tab" href="" role="tab" aria-controls="custom-content-form" aria-selected="false">PARTICULARS OF APPLICANT</a>
    </li>
	<li class="nav-item">
        <a class="nav-link" id="custom-content-guarantor-tab" href="{{ route('application.formguarantor', $application->id) }}" role="tab" aria-controls="custom-content-guarantor" aria-selected="false">PARTICULARS OF GUARANTOR</a>
    </li>
	<li class="nav-item">
        <a class="nav-link active" id="custom-content-vehicle-tab" data-toggle="pill" href="#custom-content-vehicle" role="tab" aria-controls="custom-content-vehicle" aria-selected="true">PARTICULARS OF VEHICLE</a>
    </li>
	<li class="nav-item">
        <a class="nav-link" id="custom-content-financing-tab" href="{{ route('application.formfinancing', $application->id) }}" role="tab" aria-controls="custom-content-financing" aria-selected="false">PARTICULARS OF FINANCING</a>
    </li>
	<li class="nav-item">
        <a class="nav-link" id="custom-content-document-tab" href="{{ route('application.formdocument', $application->id) }}" role="tab" aria-controls="custom-content-document" aria-selected="false">PARTICULARS OF DOCUMENTS</a>
    </li>
</ul>
<br />
<div class="tab-content" id="custom-content-vehicle">
<form id="form-application-vehicle" method="POST" enctype="multipart/form-data" action="{{ route('application.storevehicle') }}" autocomplete="off">
	@csrf
    <input type="hidden" id="hide_aid" name="hide_aid" value="{{ Helper::uuid() }}">
	<input type="hidden" id="hide_appid" name="hide_appid" value="{{ $application->id }}">
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
								<input type="text" id="txtVehicleDesc" name="txtVehicleDesc" value="" class="form-control" required>
							</div>
							<div class="form-group">	
								<label class="col-form-label">Vehicle Classification : </label>
								<select class="form-control select2" id="selVehicleClass" name="selVehicleClass" required autocomplete="off">
									<option value="">{{ __('app.please_select')}}</option>
									@foreach($vehicleClass as $vc)
										<option value="{{$vc->id}}">{{ (App::getLocale() == 'en') ? $vc->name : $vc->name_ms }}</option>
									@endforeach	
								</select>
							</div>
							<div class="form-group">
								<label class="col-form-label">Production Year : </label>
								<input type="number" id="txtProdYear" name="txtProdYear" value="" class="form-control">
							</div>
							<div class="form-group">
								<label class="col-form-label">Engine No. : </label>
								<input type="text" id="txtEngineNo" name="txtEngineNo" value="" class="form-control">
							</div>
							<div class="form-group">
								<label class="col-form-label">Address Vehicle To Be Kept  : </label>
								<input type="text" id="txtAddress1" name="txtAddress1" value="{{ strtoupper($application->home_address1) }}" class="form-control" required>
								<input type="text" id="txtAddress2" name="txtAddress2" value="{{ strtoupper($application->home_address2) }}" class="form-control">
								<input type="text" id="txtAddress3" name="txtAddress3" value="{{ strtoupper($application->home_address3) }}" class="form-control">
							</div>
							<div class="form-group">
								<label class="col-form-label">Postcode : </label>
								<input type="number" id="txtPostcode" name="txtPostcode" value="{{ strtoupper($application->home_postcode) }}" maxlength="5" minlength="5" class="form-control" required>
							</div>
							<div class="form-group">
								<label class="col-form-label">City : </label>
								<input type="text" id="txtCity" name="txtCity" value="{{ strtoupper($application->home_city) }}" class="form-control" required>
							</div>
							<div class="form-group">	
								<label class="col-form-label">State : </label>
								<select class="form-control select2" id="selState" name="selState" required autocomplete="off">
									<option value="">{{ __('app.please_select')}}</option>
									@foreach($states as $st)

										@if ($application->home_state_id == $st->id)
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
										<option value="{{$vct->id}}">{{ (App::getLocale() == 'en') ? $vct->name : $vct->name_ms }}</option>
									@endforeach	
								</select>
							</div>
							<div class="form-group">	
								<label class="col-form-label">Vehicle Promotion Code : </label>
								<select class="form-control select2" id="selVehicleCode" name="selVehicleCode" required autocomplete="off">
									<option value="">{{ __('app.please_select')}}</option>
									@foreach($vehicleCode as $vpc)
										<option value="{{$vpc->id}}">{{ (App::getLocale() == 'en') ? $vpc->name : $vpc->name_ms }}</option>
									@endforeach	
								</select>
							</div>
							<div class="form-group">
								<label class="col-form-label">Registration No. : </label>
								<input type="text" id="txtRegNo" name="txtRegNo" value="" class="form-control">
							</div>
							<div class="form-group">
								<label class="col-form-label">Chassis No. : </label>
								<input type="text" id="txtChassisNo" name="txtChassisNo" value="" class="form-control">
							</div>								
						</div>
					</div>

					<div class="row">
						<div class="col-12 text-center">
							<a href="" class="btn btn-default btn-sm"><i class="fas fa-arrow-left"></i><span class="hidden-xs"> {{ __('app.back') }}</span></a>
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

