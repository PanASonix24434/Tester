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
      <a class="nav-link active" id="custom-content-form-tab" data-toggle="pill" href="#custom-content-form" role="tab" aria-controls="custom-content-form" aria-selected="true">PARTICULARS OF APPLICANT</a>
    </li>

	@if (strtoupper(Helper::getCodeMasterNameEnById($app->applicant_type_id)) == "WITH GUARANTOR")
		<li class="nav-item">
			<a class="nav-link" id="custom-content-guarantor-tab" href="{{ route('application.formguarantorview', $app->id) }}" role="tab" aria-controls="custom-content-guarantor" aria-selected="false">PARTICULARS OF GUARANTOR</a>
		</li>
	@endif
	
	<li class="nav-item">
        <a class="nav-link" id="custom-content-vehicle-tab" href="{{ route('application.formvehicleview', $app->id) }}" role="tab" aria-controls="custom-content-vehicle" aria-selected="false">PARTICULARS OF VEHICLE</a>
    </li>
	<li class="nav-item">
        <a class="nav-link" id="custom-content-financing-tab" href="{{ route('application.formfinancingview', $app->id) }}" role="tab" aria-controls="custom-content-financing" aria-selected="false">PARTICULARS OF FINANCING</a>
    </li>
	<li class="nav-item">
        <a class="nav-link" id="custom-content-document-tab" href="{{ route('application.formdocumentview', $app->id) }}" role="tab" aria-controls="custom-content-document" aria-selected="false">PARTICULARS OF DOCUMENTS</a>
    </li>
</ul>
<br />
<div class="tab-content" id="custom-content-form">
<form id="form-application-create" method="POST" enctype="multipart/form-data" action="{{ route('application.store') }}" autocomplete="off">
	@csrf
    <input type="hidden" id="hide_aid" name="hide_aid" value="{{ Helper::uuid() }}">
	<div class="row">
        <div class="col-md-12">
           	<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title bold">A. PARTICULARS OF APPLICANT</h3>
				</div>
				<div class="card-body">
					<div class="row"> 
						<div class="col-sm-6"> 
							<div class="form-group">	
								<label class="col-form-label">Individual Type : </label>
								<input type="text" id="txtIndividualType" name="txtIndividualType" value="{{ (App::getLocale() == 'en') ? strtoupper(Helper::getCodeMasterNameEnById($app->individual_type_id)) : strtoupper(Helper::getCodeMasterNameMsById($app->individual_type_id)) }}" class="form-control" disabled>
							</div>								
						</div>
						<div class="col-sm-6"> 
							<div class="form-group">	
								<label class="col-form-label">Applicant Type : </label>
								<input type="text" id="txtApplicantType" name="txtApplicantType" value="{{ (App::getLocale() == 'en') ? strtoupper(Helper::getCodeMasterNameEnById($app->applicant_type_id)) : strtoupper(Helper::getCodeMasterNameMsById($app->applicant_type_id)) }}" class="form-control" disabled>
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
					<h3 class="card-title bold">A1. APPLICANT INFO</h3>
				</div>
				<div class="card-body">
					<div class="row"> 
						<div class="col-sm-6"> 
							<div class="form-group">
								<label class="col-form-label">Full Name : </label>
								<input type="text" id="txtFullName" name="txtFullName" value="{{ strtoupper($app->fullname) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">NRIC : </label>
								<input type="text" id="txtICNo" name="txtICNo" value="{{ strtoupper($app->icno) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Date Of Birth : </label>
								<input type="date" class="form-control" id="txtDOB" name="txtDOB" value="{{ strtoupper($app->date_of_birth) }}" disabled>
							</div>	
							<div class="form-group">
								<label class="col-form-label">Telephone No. - Home : </label>
								<input type="text" id="txtPhoneNo" name="txtPhoneNo" value="{{ strtoupper($app->phone_no) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Telephone No. - Mobile : </label>
								<input type="text" id="txtMobilePhoneNo" name="txtMobilePhoneNo" value="{{ strtoupper($app->mobile_phone_no) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Email Address : </label>
								<input type="text" id="txtEmail" name="txtEmail" value="{{ $app->email }}" class="form-control" disabled>
							</div>
							<div class="form-group">	
								<label class="col-form-label">Marital Status : </label>
								<input type="text" id="txtMaritalStatus" name="txtMaritalStatus" value="{{ (App::getLocale() == 'en') ? strtoupper(Helper::getCodeMasterNameEnById($app->marital_status_id)) : strtoupper(Helper::getCodeMasterNameMsById($app->marital_status_id)) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Number Of Children : </label>
								<input type="number" id="txtNoOfChildren" name="txtNoOfChildren" value="{{ $app->no_of_children }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Citizenship : </label>
								<input type="text" id="txtCitizenship" name="txtCitizenship" value="{{ strtoupper($app->citizenship) }}" class="form-control" disabled>
							</div>
							<div class="form-group">	
								<label class="col-form-label">Bumiputera Status : </label>
								@if ($app->bumiputera_status == 1)
									<input type="text" id="txtBumiputeraStatus" name="txtBumiputeraStatus" value="YES" class="form-control" disabled>									
								@else
									<input type="text" id="txtBumiputeraStatus" name="txtBumiputeraStatus" value="NO" class="form-control" disabled>
								@endif
							</div>							
						</div>
						<div class="col-sm-6"> 
							<div class="form-group">
								<label class="col-form-label">Home Address : </label>
								<input type="text" id="txtHomeAddress1" name="txtHomeAddress1" value="{{ strtoupper($app->home_address1) }}" class="form-control" disabled>
								<input type="text" id="txtHomeAddress2" name="txtHomeAddress2" value="{{ strtoupper($app->home_address2) }}" class="form-control" disabled>
								<input type="text" id="txtHomeAddress3" name="txtHomeAddress3" value="{{ strtoupper($app->home_address3) }}" class="form-control" disabled>
							</div>
							<br/>
							<div class="form-group">
								<label class="col-form-label">Postcode : </label>
								<input type="number" id="txtHomePostcode" name="txtHomePostcode" value="{{ strtoupper($app->home_postcode) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">City : </label>
								<input type="text" id="txtHomeCity" name="txtHomeCity" value="{{ strtoupper($app->home_city) }}" class="form-control" disabled>
							</div>
							<div class="form-group">	
								<label class="col-form-label">State : </label>
								<input type="text" id="txtState" name="txtState" value="{{ (App::getLocale() == 'en') ? strtoupper(Helper::getCodeMasterNameEnById($app->home_state_id)) : strtoupper(Helper::getCodeMasterNameMsById($app->home_state_id)) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">No. Of Years Stayed : </label>
								<input type="number" id="txtNoOfYearsStayed" name="txtNoOfYearsStayed" value="{{ strtoupper($app->no_years_stayed) }}" class="form-control" disabled>
							</div>
							<div class="form-group">	
								<label class="col-form-label">Types Of Residence : </label>
								<input type="text" id="txtTypesOfResidence" name="txtTypesOfResidence" value="{{ (App::getLocale() == 'en') ? strtoupper(Helper::getCodeMasterNameEnById($app->type_of_residence_id)) : strtoupper(Helper::getCodeMasterNameMsById($app->type_of_residence_id)) }}" class="form-control" disabled>
							</div>	
							<div class="form-group">	
								<label class="col-form-label">Education Level : </label>
								<input type="text" id="txtEducationLevel" name="txtEducationLevel" value="{{ (App::getLocale() == 'en') ? strtoupper(Helper::getCodeMasterNameEnById($app->education_level_id)) : strtoupper(Helper::getCodeMasterNameMsById($app->education_level_id)) }}" class="form-control" disabled>
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
					<h3 class="card-title bold">A2. APPLICANT EMPLOYMENT INFO</h3>
				</div>
				<div class="card-body">
					<div class="row"> 
						<div class="col-sm-6">
							<div class="form-group">	
								<label class="col-form-label">Employment Category : </label>
								<input type="text" id="txtEmploymentCategory" name="txtEmploymentCategory" value="{{ (App::getLocale() == 'en') ? strtoupper(Helper::getCodeMasterNameEnById($app->employment_category_id)) : strtoupper(Helper::getCodeMasterNameMsById($app->employment_category_id)) }}" class="form-control" disabled>
							</div>	 														
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label class="col-form-label">Length Of Service (Year) : </label>
								<input type="number" id="txtServiceYear" name="txtServiceYear" value="{{ strtoupper($app->length_of_service_years) }}" class="form-control" disabled>
							</div> 																						
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label class="col-form-label">(Month) : </label>
								<input type="number" id="txtServiceMonth" name="txtServiceMonth" value="{{ strtoupper($app->length_of_service_months) }}" class="form-control" disabled>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Designation : </label>
								<input type="text" id="txtDesignation" name="txtDesignation" value="{{ strtoupper($app->designation) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Monthly Income (RM) : </label>
								<input type="number" id="txtIncome" name="txtIncome" value="{{ strtoupper($app->monthly_income) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Source Of Fund : </label>
								<input type="text" id="txtSourceFund" name="txtSourceFund" value="{{ strtoupper($app->source_of_fund) }}" class="form-control" disabled>
							</div>			
							<div class="form-group">
								<label class="col-form-label">Name Of Business : </label>
								<input type="text" id="txtNatureBusiness" name="txtNatureBusiness" value="{{ strtoupper($app->nature_of_business) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Nature Of Employer / Business : </label>
								<input type="text" id="txtEmployerName" name="txtEmployerName" value="{{ strtoupper($app->name_of_employer) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Office Telephone Number : </label>
								<input type="text" id="txtOfficePhoneNo" name="txtOfficePhoneNo" value="{{ strtoupper($app->office_phone_no) }}" class="form-control" disabled>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Occupation : </label>
								<input type="text" id="txtOccupation" name="txtOccupation" value="{{ strtoupper($app->occupation) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Annual Sales Turnover : </label>
								<input type="number" id="txtAnnualSales" name="txtAnnualSales" value="{{ strtoupper($app->annual_sales_turnover) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Source Of Wealth : </label>
								<input type="text" id="txtSourceWealth" name="txtSourceWealth" value="{{ strtoupper($app->source_of_wealth) }}" class="form-control" disabled>
							</div>
							<div class="form-group">	
								<label class="col-form-label">Type Of Entity : </label>
								<input type="text" id="txtTypeOfEntity" name="txtTypeOfEntity" value="{{ (App::getLocale() == 'en') ? strtoupper(Helper::getCodeMasterNameEnById($app->type_of_entity_id)) : strtoupper(Helper::getCodeMasterNameMsById($app->type_of_entity_id)) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Number Of Fulltime Employees : </label>
								<input type="number" id="txtFulltimeEmployeeNo" name="txtFulltimeEmployeeNo" value="{{ strtoupper($app->no_fulltime_employee) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Office Address : </label>
								<input type="text" id="txtOfficeAddress1" name="txtOfficeAddress1" value="{{ strtoupper($app->office_address1) }}" class="form-control" disabled>
								<input type="text" id="txtOfficeAddress2" name="txtOfficeAddress2" value="{{ strtoupper($app->office_address2) }}" class="form-control" disabled>
								<input type="text" id="txtOfficeAddress3" name="txtOfficeAddress3" value="{{ strtoupper($app->office_address3) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Postcode : </label>
								<input type="number" id="txtOfficePostcode" name="txtOfficePostcode" value="{{ strtoupper($app->office_postcode) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">City : </label>
								<input type="text" id="txtOfficeCity" name="txtOfficeCity" value="{{ strtoupper($app->office_city) }}" class="form-control" disabled>
							</div>
							<div class="form-group">	
								<label class="col-form-label">State : </label>
								<input type="text" id="txtOfficeState" name="txtOfficeState" value="{{ (App::getLocale() == 'en') ? strtoupper(Helper::getCodeMasterNameEnById($app->office_state_id)) : strtoupper(Helper::getCodeMasterNameMsById($app->office_state_id)) }}" class="form-control" disabled>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
        <div class="col-md-12">
           	<div class="card card-danger">
				<div class="card-header">
					<h3 class="card-title bold">A3. EMERGENCY CONTACT INFO</h3>
				</div>
				<div class="card-body">
					<div class="row"> 
						<div class="col-sm-6"> 
							<div class="form-group">
								<label class="col-form-label">Emergency Contact Name : </label>
								<input type="text" id="txtEmergencyName" name="txtEmergencyName" value="{{ strtoupper($app->emergency_contact_name) }}" class="form-control" disabled>
							</div>
							<div class="form-group">
								<label class="col-form-label">Emergency Contact Number : </label>
								<input type="text" id="txtEmergencyPhoneNo" name="txtEmergencyPhoneNo" value="{{ strtoupper($app->emergency_contact_no) }}" class="form-control" disabled>
							</div>							
						</div>
						<div class="col-sm-6"> 
							<div class="form-group">
								<label class="col-form-label">Relationship With Emergency Contact : </label>
								<input type="text" id="txtEmergencyRelation" name="txtEmergencyRelation" value="{{ strtoupper($app->emergency_contact_relationship) }}" class="form-control" disabled>
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

