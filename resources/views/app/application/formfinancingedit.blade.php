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
        <a class="nav-link" id="custom-content-vehicle-tab" href="{{ route('application.formvehicleedit', $app[0]->id) }}" role="tab" aria-controls="custom-content-vehicle" aria-selected="false">PARTICULARS OF VEHICLE</a>
    </li>
	<li class="nav-item">
        <a class="nav-link active" id="custom-content-financing-tab" data-toggle="pill" href="#custom-content-financing" role="tab" aria-controls="custom-content-financing" aria-selected="true">PARTICULARS OF FINANCING</a>
    </li>
	<li class="nav-item">
        <a class="nav-link" id="custom-content-document-tab" href="{{ route('application.formdocumentedit', $app[0]->id) }}" role="tab" aria-controls="custom-content-document" aria-selected="false">PARTICULARS OF DOCUMENTS</a>
    </li>
</ul>
<br />
<div class="tab-content" id="custom-content-financing">
<form id="form-application-financing" method="POST" enctype="multipart/form-data" action="{{ route('application.storefinancing') }}" autocomplete="off">
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
								<label class="col-form-label">Financing Type : </label>
								<input type="text" id="txtFinancingType" name="txtFinancingType" value="{{ (App::getLocale() == 'en') ? strtoupper(Helper::getCodeMasterNameEnById($app[0]->financing_type_id)) : strtoupper(Helper::getCodeMasterNameMsById($app[0]->financing_type_id)) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Insurance / Takaful (Motor Vehicle) : </label>
								<input type="number" id="txtInsuranceMotor" name="txtInsuranceMotor" value="{{ strtoupper($app[0]->insurance_motor_vehicle) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Deposit : </label>
								<input type="text" id="txtDeposit" name="txtDeposit" value="{{ strtoupper($app[0]->deposit) }}" class="form-control" disabled>
							</div>								
						</div>
						<div class="col-sm-6"> 							
							<div class="form-group">
								<label class="col-form-label">Cash Price : </label>
								<input type="text" id="txtCashPrice" name="txtCashPrice" value="{{ strtoupper($app[0]->cash_price) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Insurance / Takaful (AutoSecure-i1) : </label>
								<input type="number" id="txtInsuranceAutoSecure" name="txtInsuranceAutoSecure" value="{{ strtoupper($app[0]->insurance_autosecure) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Amount Financed : </label>
								<input type="text" id="txtAmountFinanced" name="txtAmountFinanced" value="{{ strtoupper($app[0]->amount_financed) }}" class="form-control" disabled>
							</div>								
						</div>
						<div class="col-sm-5">
							<div class="form-group">
								<label class="col-form-label">Term/Profit Charges (Fixed Rate) : </label>
								<input type="text" id="txtProfitCharge" name="txtProfitCharge" value="{{ strtoupper($app[0]->profit_charge_fixed_rate) }}" class="form-control" disabled>
							</div>
						</div>
						<div class="col-sm-1">
							<div class="form-group">
								<label class="col-form-label" style="margin-top:33px;">% p.a. flat</label>					
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Tenure (Months) : </label>
								<input type="number" id="txtTenure" name="txtTenure" value="{{ strtoupper($app[0]->tenure) }}" class="form-control" disabled>
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

