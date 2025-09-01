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
	<li class="nav-item">
        <a class="nav-link active" id="custom-content-guarantor-tab" data-toggle="pill" href="#custom-content-guarantor" role="tab" aria-controls="custom-content-guarantor" aria-selected="true">PARTICULARS OF GUARANTOR</a>
    </li>
	<li class="nav-item">
        <a class="nav-link" id="custom-content-vehicle-tab" href="{{ route('application.formvehicleview', $app[0]->id) }}" role="tab" aria-controls="custom-content-vehicle" aria-selected="false">PARTICULARS OF VEHICLE</a>
    </li>
	<li class="nav-item">
        <a class="nav-link" id="custom-content-financing-tab" href="{{ route('application.formfinancingview', $app[0]->id) }}" role="tab" aria-controls="custom-content-financing" aria-selected="false">PARTICULARS OF FINANCING</a>
    </li>
	<li class="nav-item">
        <a class="nav-link" id="custom-content-document-tab" href="{{ route('application.formdocumentview', $app[0]->id) }}" role="tab" aria-controls="custom-content-document" aria-selected="false">PARTICULARS OF DOCUMENTS</a>
    </li>
</ul>
<br />
<div class="tab-content" id="custom-content-guarantor">
<form id="form-application-guarantor" method="POST" enctype="multipart/form-data" action="{{ route('application.updateformguarantoredit', $app[0]->id) }}" autocomplete="off">
	@csrf
    <input type="hidden" id="hide_aid" name="hide_aid" value="{{ Helper::uuid() }}">
	<input type="hidden" id="hide_appid" name="hide_appid" value="{{ $app[0]->id }}">

	<div class="row">
        <div class="col-md-12">
           	<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title bold">B. PARTICULARS OF GUARANTOR</h3>
				</div>
				<div class="card-body">
					<div class="row"> 
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Relationship With Applicant : </label>
								<input type="text" id="txtRelationship" name="txtRelationship" value="{{ strtoupper($app[0]->g_relationship) }}" class="form-control" disabled>
							</div> 
							<div class="form-group">
								<label class="col-form-label">Full Name : </label>
								<input type="text" id="txtFullName" name="txtFullName" value="{{ strtoupper($app[0]->g_fullname) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">NRIC/ Company Registration No./ No. BAID/ Other ID : </label>
								<input type="text" id="txtICNo" name="txtICNo" value="{{ strtoupper($app[0]->g_icno) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Date Of Birth / Company Registration : </label>
								<input type="date" class="form-control" id="txtDOB" name="txtDOB" value="{{ strtoupper($app[0]->g_date_of_birth) }}" disabled>
							</div>	
							<div class="form-group">
								<label class="col-form-label">Telephone No. - Home : </label>
								<input type="text" id="txtPhoneNo" name="txtPhoneNo" value="{{ strtoupper($app[0]->g_phone_no) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Telephone No. - Mobile : </label>
								<input type="text" id="txtMobilePhoneNo" name="txtMobilePhoneNo" value="{{ strtoupper($app[0]->g_mobile_phone_no) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Email Address : </label>
								<input type="text" id="txtEmail" name="txtEmail" value="{{ $app[0]->g_email }}" class="form-control" disabled>
							</div>
							<div class="form-group">	
								<label class="col-form-label">Marital Status : </label>
								<input type="text" id="txtMaritalStatus" name="txtMaritalStatus" value="{{ (App::getLocale() == 'en') ? strtoupper(Helper::getCodeMasterNameEnById($app[0]->g_marital_status_id)) : strtoupper(Helper::getCodeMasterNameMsById($app[0]->g_marital_status_id)) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Citizenship : </label>
								<input type="text" id="txtCitizenship" name="txtCitizenship" value="{{ strtoupper($app[0]->g_citizenship) }}" class="form-control" disabled>
							</div>														
						</div>
						<div class="col-sm-6"> 
							<div class="form-group">
								<label class="col-form-label">Home Address : </label>
								<input type="text" id="txtHomeAddress1" name="txtHomeAddress1" value="{{ strtoupper($app[0]->g_home_address1) }}" class="form-control" disabled>
								<input type="text" id="txtHomeAddress2" name="txtHomeAddress2" value="{{ strtoupper($app[0]->g_home_address2) }}" class="form-control" disabled>
								<input type="text" id="txtHomeAddress3" name="txtHomeAddress3" value="{{ strtoupper($app[0]->g_home_address3) }}" class="form-control" disabled>
							</div>
							<br/>
							<div class="form-group">
								<label class="col-form-label">Postcode : </label>
								<input type="number" id="txtHomePostcode" name="txtHomePostcode" value="{{ strtoupper($app[0]->g_home_postcode) }}" maxlength="5" minlength="5" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">City : </label>
								<input type="text" id="txtHomeCity" name="txtHomeCity" value="{{ strtoupper($app[0]->g_home_city) }}" class="form-control" disabled>
							</div>
							<div class="form-group">	
								<label class="col-form-label">State : </label>
								<input type="text" id="txtHomeState" name="txtHomeState" value="{{ (App::getLocale() == 'en') ? strtoupper(Helper::getCodeMasterNameEnById($app[0]->g_home_state_id)) : strtoupper(Helper::getCodeMasterNameMsById($app[0]->g_home_state_id)) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">No. Of Years Stayed : </label>
								<input type="number" id="txtNoOfYearsStayed" name="txtNoOfYearsStayed" value="{{ strtoupper($app[0]->g_no_years_stayed) }}" class="form-control" disabled>
							</div>
							<div class="form-group">	
								<label class="col-form-label">Types Of Residence : </label>
								<input type="text" id="txtResidenceType" name="txtResidenceType" value="{{ (App::getLocale() == 'en') ? strtoupper(Helper::getCodeMasterNameEnById($app[0]->g_type_of_residence_id)) : strtoupper(Helper::getCodeMasterNameMsById($app[0]->g_type_of_residence_id)) }}" class="form-control" disabled>
							</div>
							<div class="form-group">	
								<label class="col-form-label">Bumiputera Status : </label>
								@if ($app[0]->g_bumiputera_status == 1)
									<input type="text" id="txtBumiputeraStatus" name="txtBumiputeraStatus" value="YES" class="form-control" disabled>
								@else
									<input type="text" id="txtBumiputeraStatus" name="txtBumiputeraStatus" value="NO" class="form-control" disabled>
								@endif
								
							</div>								
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
        <div class="col-md-12">
           	<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title bold">B2. GUARANTOR EMPLOYMENT INFO</h3>
				</div>
				<div class="card-body">
					<div class="row"> 
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Occupation : </label>
								<input type="text" id="txtOccupation" name="txtOccupation" value="{{ strtoupper($app[0]->g_occupation) }}" class="form-control" disabled>
							</div>	 														
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label class="col-form-label">Length Of Service (Year) : </label>
								<input type="number" id="txtServiceYear" name="txtServiceYear" value="{{ strtoupper($app[0]->g_length_of_service_years) }}" class="form-control" disabled>
							</div> 																						
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label class="col-form-label">(Month) : </label>
								<input type="number" id="txtServiceMonth" name="txtServiceMonth" value="{{ strtoupper($app[0]->g_length_of_service_months) }}" class="form-control" disabled>
							</div>
						</div>

						<div class="col-sm-6">
							
							<div class="form-group">
								<label class="col-form-label">Monthly Income (RM) : </label>
								<input type="number" id="txtIncome" name="txtIncome" value="{{ strtoupper($app[0]->g_monthly_income) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Source Of Fund : </label>
								<input type="text" id="txtSourceFund" name="txtSourceFund" value="{{ strtoupper($app[0]->g_source_of_fund) }}" class="form-control" disabled>
							</div>			
							<div class="form-group">
								<label class="col-form-label">Nature Of Business : </label>
								<input type="text" id="txtNatureBusiness" name="txtNatureBusiness" value="{{ strtoupper($app[0]->g_nature_business) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Nature Of Employer / Business : </label>
								<input type="text" id="txtEmployerName" name="txtEmployerName" value="{{ strtoupper($app[0]->g_name_of_employer) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Number Of Fulltime Employees : </label>
								<input type="number" id="txtFulltimeEmployeeNo" name="txtFulltimeEmployeeNo" value="{{ strtoupper($app[0]->g_no_fulltime_employee) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Office Telephone Number : </label>
								<input type="text" id="txtOfficePhoneNo" name="txtOfficePhoneNo" value="{{ strtoupper($app[0]->g_office_phone_no) }}" class="form-control" disabled>
							</div>
						</div>
						<div class="col-sm-6">							
							<div class="form-group">
								<label class="col-form-label">Annual Sales Turnover : </label>
								<input type="number" id="txtAnnualSales" name="txtAnnualSales" value="{{ strtoupper($app[0]->g_annual_sales_turnover) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Source Of Wealth : </label>
								<input type="text" id="txtSourceWealth" name="txtSourceWealth" value="{{ strtoupper($app[0]->g_source_of_wealth) }}" class="form-control" disabled>
							</div>							
							<div class="form-group">
								<label class="col-form-label">Office Address : </label>
								<input type="text" id="txtOfficeAddress1" name="txtOfficeAddress1" value="{{ strtoupper($app[0]->g_office_address1) }}" class="form-control" disabled>
								<input type="text" id="txtOfficeAddress2" name="txtOfficeAddress2" value="{{ strtoupper($app[0]->g_office_address2) }}" class="form-control" disabled>
								<input type="text" id="txtOfficeAddress3" name="txtOfficeAddress3" value="{{ strtoupper($app[0]->g_office_address3) }}" class="form-control" disabled>
							</div><br/>
							<div class="form-group">
								<label class="col-form-label">Postcode : </label>
								<input type="number" id="txtOfficePostcode" name="txtOfficePostcode" value="{{ strtoupper($app[0]->g_office_postcode) }}" maxlength="5" minlength="5" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">City : </label>
								<input type="text" id="txtOfficeCity" name="txtOfficeCity" value="{{ strtoupper($app[0]->g_office_city) }}" class="form-control" disabled>
							</div>
							<div class="form-group">	
								<label class="col-form-label">State : </label>
								<input type="text" id="txtOfficeState" name="txtOfficeState" value="{{ (App::getLocale() == 'en') ? strtoupper(Helper::getCodeMasterNameEnById($app[0]->g_office_state_id)) : strtoupper(Helper::getCodeMasterNameMsById($app[0]->g_office_state_id)) }}" class="form-control" disabled>
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
		
		// DropdownList OnChange
		$(document).ready(function(){
		
		});

    </script>
@endpush

