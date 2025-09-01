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
        <a class="nav-link" id="custom-content-financing-tab" href="{{ route('application.formfinancingedit', $app[0]->id) }}" role="tab" aria-controls="custom-content-financing" aria-selected="false">PARTICULARS OF FINANCING</a>
    </li>
	<li class="nav-item">
        <a class="nav-link active" id="custom-content-document-tab" data-toggle="pill" href="#custom-content-document" role="tab" aria-controls="custom-content-document" aria-selected="true">PARTICULARS OF DOCUMENTS</a>
    </li>
</ul>
<br />
<div class="tab-content" id="custom-content-financing">
<form id="form-application-document" method="POST" enctype="multipart/form-data" action="#" autocomplete="off">
	@csrf
	<input type="hidden" id="hide_appid" name="hide_appid" value="{{ $app[0]->id }}">
	<div class="row">
        <div class="col-md-12">
           	<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title bold">D. PARTICULARS OF DOCUMENTS</h3>					
				</div>
				<div class="card-body">
					<div class="row">
                        <div class="col-12">
							<div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped table-sm">
                                    @if (!$docs->isEmpty())
                                        <thead>
                                            <tr> 
                                                <th style="width:1%;"></th>
                                                <th>Document Type</th>
                                                <th>Description</th>
                                                <th>Title</th>
												<th>Created By</th>
												<th>Created Date</th>                                              
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($docs as $a)
                                                <tr>
                                                    <td class="text-nowrap">
                                                        <a href="" class="btn btn-default btn-xs">
                                                            <i class="fas fa-search"></i>
                                                        </a>
                                                    </td>
                                                    <td>{{ (App::getLocale() == 'en') ? strtoupper(Helper::getCodeMasterNameEnById($a->document_type_id)) : strtoupper(Helper::getCodeMasterNameMsById($a->document_type_id)) }}</td>
                                                    <td>{{ $a->desc }}</td>
                                                    <td>{{ $a->title }}</td>
                                                    <td>{{ strtoupper(Helper::getUsersNameById($a->created_by)) }}</td>
                                                    <td>{{ $a->created_at }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    @else
                                        <thead>
                                            <tr>                                             
                                                <th>Document Type</th>
                                                <th>Description</th>
                                                <th>Title</th>
												<th>Created By</th>
												<th>Created Date</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="text-center">
                                                <td colspan="5">{{ __('app.no_record_found') }}</td>
                                            </tr>
                                        </tbody>
                                    @endif
                                </table>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="table-responsive">
                                {!! $docs->appends(\Request::except('page'))->render() !!}
                            </div>
                        </div>
                        @if (!$docs->isEmpty())
                            <div class="col-md-4">
                                <span class="float-md-right">
                                    {{ __('app.table_info', [ 'first' => $docs->firstItem(), 'last' => $docs->lastItem(), 'total' => $docs->total() ]) }}
                                </span>
                            </div>
                        @endif
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

