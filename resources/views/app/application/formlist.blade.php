@extends('layouts.app')
@include('layouts.page_title')

@section('content')
<div id="app-content">
    <div class="app-content-area">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline">
                <div class="card-header">
                    <h3 class="card-title">@yield('page_title')</h3>
                    <div class="card-tools">  
					</div>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('application.formlist') }}">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">
                                    Applicant Name :
                                </label>
                                <input type="text" class="form-control" id="txtApplicantName" name="txtApplicantName" value="">                               																		
                            </div>                           
                        </div>  
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">
                                    Applicant ICNo :
                                </label>
                                <input type="text" class="form-control" id="txtApplicantICNo" name="txtApplicantICNo" value="">																		
                            </div>                           
                        </div>  
                    </div>
                    <div class="row">
                        <div class="col-12 text-left">                            
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> SEARCH</button>
                        </div>							
                    </div>
                    </form>
                    <br /><br />
                    <div class="row">
                        <div class="col-12">
							<div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped table-sm">
                                    @if (!$applications->isEmpty())
                                        <thead>
                                            <tr> 
                                                <th style="width:1%;"></th>                                              
                                                <th>@sortablelink('applicant_name', __('app.applicant_name'))</th>
                                                <th>@sortablelink('icno', __('app.icno'))</th>
												<th>Mobile Phone No</th>
												<th>Vehicle Description</th>
												<th>Amount Financed</th>
												<th>Tenure</th>
												<th>@sortablelink('status', __('app.status'))</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($applications as $a)
                                                <tr>
                                                    <td class="text-nowrap">
                                                        <a href="{{ route('application.formview', $a->id) }}" title="View" class="btn btn-default btn-xs">
                                                            <i class="fas fa-search"></i>
                                                        </a>
                                                        @if (strtoupper(Helper::getCodeMasterNameEnById($a->application_status_id)) == 'SAVED')
                                                            <a href="{{ route('application.formedit', $a->id) }}" title="Edit" class="btn btn-default btn-xs">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        @endif 
                                                    </td>
                                                    <td>{{ strtoupper($a->fullname) }}</td>
                                                    <td>{{ $a->icno }}</td>
													<td>{{ $a->mobile_phone_no }}</td>
													<td>{{ $a->vehicle_desc }}</td>
													<td>RM {{ number_format($a->amount_financed) }}</td>
													<td>{{ $a->tenure }} MONTHS</td>
													<td>{{ (App::getLocale() == 'en') ? strtoupper(Helper::getCodeMasterNameEnById($a->application_status_id)) : strtoupper(Helper::getCodeMasterNameMsById($a->application_status_id)) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    @else
                                        <thead>
                                            <tr>                                             
                                                <th>@sortablelink('applicant_name', __('app.applicant_name'))</th>
                                                <th>@sortablelink('icno', __('app.icno'))</th>
												<th>Mobile Phone No</th>
												<th>Amount Financed</th>
												<th>Tenure</th>
												<th>@sortablelink('status', __('app.status'))</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="text-center">
                                                <td colspan="6">{{ __('app.no_record_found') }}</td>
                                            </tr>
                                        </tbody>
                                    @endif
                                </table>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="table-responsive">
                                {!! $applications->appends(\Request::except('page'))->render() !!}
                            </div>
                        </div>
                        @if (!$applications->isEmpty())
                            <div class="col-md-4">
                                <span class="float-md-right">
                                    {{ __('app.table_info', [ 'first' => $applications->firstItem(), 'last' => $applications->lastItem(), 'total' => $applications->total() ]) }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>  
@endsection

@push('scripts')
	<script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
	<script src="{{ asset('template/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script type="text/javascript">	    

		$(document).on('input', "input[type=text]", function () {
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
        });

    </script>
@endpush