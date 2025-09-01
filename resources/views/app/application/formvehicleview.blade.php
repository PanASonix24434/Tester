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
      <a class="nav-link" id="custom-content-form-tab" href="{{ route('application.formview', $app[0]->id) }}" role="tab" aria-controls="custom-content-form" aria-selected="false">PARTICULARS OF APPLICANT</a>
    </li>
	@if (strtoupper(Helper::getCodeMasterNameEnById($app[0]->applicant_type_id)) == "WITH GUARANTOR")
		<li class="nav-item">
			<a class="nav-link" id="custom-content-guarantor-tab" href="{{ route('application.formguarantorview', $app[0]->id) }}" role="tab" aria-controls="custom-content-guarantor" aria-selected="false">PARTICULARS OF GUARANTOR</a>
		</li>
	@endif
	<li class="nav-item">
        <a class="nav-link active" id="custom-content-vehicle-tab" data-toggle="pill" href="#custom-content-vehicle" role="tab" aria-controls="custom-content-vehicle" aria-selected="true">PARTICULARS OF VEHICLE</a>
    </li>
	<li class="nav-item">
        <a class="nav-link" id="custom-content-financing-tab" href="{{ route('application.formfinancingview', $app[0]->id) }}" role="tab" aria-controls="custom-content-financing" aria-selected="false">PARTICULARS OF FINANCING</a>
    </li>
	<li class="nav-item">
        <a class="nav-link" id="custom-content-document-tab" href="{{ route('application.formdocumentview', $app[0]->id) }}" role="tab" aria-controls="custom-content-document" aria-selected="false">PARTICULARS OF DOCUMENTS</a>
    </li>
</ul>
<br />
<div class="tab-content" id="custom-content-vehicle">
<form id="form-application-vehicle" method="POST" enctype="multipart/form-data" action="{{ route('application.storevehicle') }}" autocomplete="off">
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
								<input type="text" id="txtVehicleDesc" name="txtVehicleDesc" value="{{ strtoupper($app[0]->vehicle_desc) }}" class="form-control" disabled>
							</div>
							<div class="form-group">	
								<label class="col-form-label">Vehicle Classification : </label>
								<input type="text" id="txtVehicleClassification" name="txtVehicleClassification" value="{{ (App::getLocale() == 'en') ? strtoupper(Helper::getCodeMasterNameEnById($app[0]->vehicle_class_id)) : strtoupper(Helper::getCodeMasterNameMsById($app[0]->vehicle_class_id)) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Production Year : </label>
								<input type="number" id="txtProdYear" name="txtProdYear" value="{{ strtoupper($app[0]->production_year) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Engine No. : </label>
								<input type="text" id="txtEngineNo" name="txtEngineNo" value="{{ strtoupper($app[0]->engine_no) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Address Vehicle To Be Kept  : </label>
								<input type="text" id="txtAddress1" name="txtAddress1" value="{{ strtoupper($app[0]->v_address1) }}" class="form-control" disabled>
								<input type="text" id="txtAddress2" name="txtAddress2" value="{{ strtoupper($app[0]->v_address2) }}" class="form-control" disabled>
								<input type="text" id="txtAddress3" name="txtAddress3" value="{{ strtoupper($app[0]->v_address3) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Postcode : </label>
								<input type="number" id="txtPostcode" name="txtPostcode" value="{{ strtoupper($app[0]->v_postcode) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">City : </label>
								<input type="text" id="txtCity" name="txtCity" value="{{ strtoupper($app[0]->v_city) }}" class="form-control" disabled>
							</div>
							<div class="form-group">	
								<label class="col-form-label">State : </label>
								<input type="text" id="txtState" name="txtState" value="{{ (App::getLocale() == 'en') ? strtoupper(Helper::getCodeMasterNameEnById($app[0]->v_state_id)) : strtoupper(Helper::getCodeMasterNameMsById($app[0]->v_state_id)) }}" class="form-control" disabled>
							</div>								
						</div>
						<div class="col-sm-6"> 
							<div class="form-group">	
								<label class="col-form-label">Vehicle Category : </label>
								<input type="text" id="txtVehicleCategory" name="txtVehicleCategory" value="{{ (App::getLocale() == 'en') ? strtoupper(Helper::getCodeMasterNameEnById($app[0]->vehicle_category)) : strtoupper(Helper::getCodeMasterNameMsById($app[0]->vehicle_category)) }}" class="form-control" disabled>
							</div>
							<div class="form-group">	
								<label class="col-form-label">Vehicle Promotion Code : </label>
								<input type="text" id="txtVehiclePromoCode" name="txtVehiclePromoCode" value="{{ (App::getLocale() == 'en') ? strtoupper(Helper::getCodeMasterNameEnById($app[0]->vehicle_code_id)) : strtoupper(Helper::getCodeMasterNameMsById($app[0]->vehicle_code_id)) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Registration No. : </label>
								<input type="text" id="txtRegNo" name="txtRegNo" value="{{ strtoupper($app[0]->registration_no) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Chassis No. : </label>
								<input type="text" id="txtChassisNo" name="txtChassisNo" value="{{ strtoupper($app[0]->chassis_no) }}" class="form-control" disabled>
							</div>								
						</div>
					</div>

					<div class="row">
						<div class="col-12 text-center">
							<a href="{{ route('application.formlist') }}" class="btn btn-default btn-sm"><i class="fas fa-arrow-left"></i><span class="hidden-xs"> {{ __('app.back') }}</span></a>
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

