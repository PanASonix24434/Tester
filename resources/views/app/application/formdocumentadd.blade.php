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
        <a class="nav-link" id="custom-content-guarantor-tab" href="" role="tab" aria-controls="custom-content-guarantor" aria-selected="false">PARTICULARS OF GUARANTOR</a>
    </li>
	<li class="nav-item">
        <a class="nav-link" id="custom-content-vehicle-tab" href="" role="tab" aria-controls="custom-content-vehicle" aria-selected="false">PARTICULARS OF VEHICLE</a>
    </li>
	<li class="nav-item">
        <a class="nav-link" id="custom-content-financing-tab" href="" role="tab" aria-controls="custom-content-financing" aria-selected="false">PARTICULARS OF FINANCING</a>
    </li>
	<li class="nav-item">
        <a class="nav-link active" id="custom-content-document-tab" data-toggle="pill" href="#custom-content-document" role="tab" aria-controls="custom-content-document" aria-selected="true">PARTICULARS OF DOCUMENTS</a>
    </li>
</ul>
<br />
<div class="tab-content" id="custom-content-document">
<form id="form-application-document" method="POST" enctype="multipart/form-data" action="{{ route('application.storedocument') }}" autocomplete="off">
	@csrf
    <input type="hidden" id="hide_aid" name="hide_aid" value="{{ Helper::uuid() }}">
	<input type="hidden" id="hide_appid" name="hide_appid" value="{{ $application->id }}">
	<div class="row">
        <div class="col-md-12">
           	<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title bold">D. PARTICULARS OF DOCUMENTS</h3>
				</div>
				<div class="card-body">
					<div class="row"> 
						<div class="col-sm-6"> 
							<div class="form-group">	
								<label class="col-form-label">Document Type : </label>
								<select class="form-control" id="selDocType" name="selDocType" required autocomplete="off">
									<option value="">{{ __('app.please_select')}}</option>
									@foreach($docType as $dt)
										<option value="{{$dt->id}}">{{ (App::getLocale() == 'en') ? $dt->name : $dt->name_ms }}</option>
									@endforeach	
								</select>
							</div>
							<div class="form-group">
								<label class="col-form-label">Description : </label>
								<input type="text" id="txtDesc" name="txtDesc" value="" class="form-control" required>
							</div>								
						</div>
						<div class="col-sm-6"> 							
							<div class="form-group">
								<div class="form-group">
									<div class="input-group">
										<div class="custom-file" style="margin-top:33px;">
											<input type="file" class="custom-file-input" id="fileDoc" name="fileDoc">
											<label class="custom-file-label" for="fileDoc">Choose file</label>
										</div>							  
									</div>
								</div>
							</div>															
						</div>						
					</div>

					<div class="row">
						<div class="col-12 text-center">
							<a href="{{ route('application.formdocument', $application->id) }}" class="btn btn-default btn-sm"><i class="fas fa-arrow-left"></i><span class="hidden-xs"> {{ __('app.back') }}</span></a>
							<a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="event.preventDefault(); document.getElementById('form-application-document').submit();"><i class="fas fa-save"></i><span class="hidden-xs"> {{ __('app.save') }}</span></a>
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

