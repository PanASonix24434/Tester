@extends('layouts.app')

@push('styles')
    <style type="text/css">
    </style>
@endpush

@section('content')

    <!-- Page Content -->
    <div id="app-content">

        <!-- Container fluid -->
        <div class="app-content-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <!-- Page header -->
                    <div class="mb-5">
                        <h3 class="mb-0">Permohonan Elaun Sara Hidup Nelayan</h3>
                    </div>
                </div>
                @if(Auth::user()->name != 'Super Admin')
                    @if(!$subApplication->isEmpty())
                        @if($subApplicationList->sub_application_status == 'Permohonan Tidak Diluluskan Peringkat Negeri' || $subApplicationList->sub_application_status == 'Permohonan Ditolak Peringkat Negeri' ||  $subApplicationList->sub_application_status == 'Permohonan Tidak Diluluskan Peringkat HQ')
                        <div class="col-md-6">
                            <div class="mb-5 text-right">  
                                    <a href="{{ route('subsistence-allowance.formdetails_appeal') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i><span class="hidden-xs"> {{ __('app.create') }}</span></a>

                                </div>
                        </div>
                        @else
                        <div class="col-md-6">
                            
                        </div>
                        @endif
                    @else
                    <div class="col-md-6">
                        <div class="mb-5 text-right">  
                            <a href="{{ route('subsistence-allowance.formdetails') }}" class="btn btn-primary btn-sm @if(!$canApply) disabled @endif"><i class="fas fa-plus"></i><span class="hidden-xs"> {{ __('app.create') }}</span></a>
                        </div>
                    </div>
                    @endif
                @endif
            </div>
            <div>
                <!-- row -->
                <div class="row">
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary">
								<h4 class="mb-0" style="color:white;">Program Elaun Sara Hidup Nelayan Darat </h4>
                            </div>
                            <div class="card-body" style="margin-left:30px;">
                                <br/>
								<div class="table-responsive table-card">
                                    <table class="table table-striped">
                                    @if (!$subApplication->isEmpty())
                                        <thead>
                                            <tr> 
                                                <th style="width:1%;"></th> 
                                                <th>Tarikh Permohonan </th>
                                                <th> No Fail </th>  
                                                <th> Jenis Permohonan </th>                                             
                                                <th>@sortablelink('applicant_name', __('app.applicant_name'))</th>
                                                <th>@sortablelink('icno', __('app.icno'))</th>
                                                <th>Tarikh Diluluskan</th>
                                                <th>Tarikh Luput</th>
												<th>@sortablelink('status', __('app.status'))</th>
                                                <th>Pejabat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($subApplication as $a)
                                                <tr>
                                                    <td class="text-nowrap">
                                                        @if($a->sub_application_status == 'Permohonan Disimpan' || $a->sub_application_status == 'Permohonan Disemak (TIDAK LENGKAP)')
                                                            <a href= "{{ route('subsistence-allowance.editformdetails', $a->id) }}"class="btn btn-primary btn-sm">
                                                                <i class="nav-icon fas fa-edit"></i>
                                                            </a>
                                                        @else
                                                            <a href= "{{ route('subsistence-allowance.showformdetails', $a->id) }}"class="btn btn-primary btn-sm">
                                                                <i class="fas fa-search"></i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td>{{ $a->created_at }}</td>
                                                    <td>{{ $a->registration_no }}</td>
                                                        @if($a->type_registration == 'Baru')
                                                            <td><span class="badge bg-success">Baru</span></td>
                                                        @elseif($a->type_registration == 'Rayuan')
                                                            <td><span class="badge bg-warning text-dark">Rayuan</span></td>
                                                        @else
                                                            <td>{{ $a->type_registration }}</td>
                                                        @endif
                                                    <td>{{ strtoupper($a->fullname) }}</td>
                                                    <td>{{ $a->icno }}</td>
                                                    <td>{{ $a->application_approved_date ? Carbon\Carbon::parse($a->application_approved_date)->format('d/m/Y') : '-' }}</td>
                                                    <td>{{ $a->application_expired_date ? Carbon\Carbon::parse($a->application_expired_date)->format('d/m/Y') : '-' }}</td>
													<td>{{ strtoupper($a->sub_application_status) }}</td>
                                                    <td>{{ $a->entity_id != null ? strtoupper(Helper::getEntityNameById($a->entity_id)) : '' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    @else
                                        <thead>
                                            <tr>                                             
                                                <th>Tarikh Permohonan </th>
                                                <th> No Fail </th> 
                                                <th> Jenis Permohonan </th>                                              
                                                <th>@sortablelink('applicant_name', __('app.applicant_name'))</th>
                                                <th>@sortablelink('icno', __('app.icno'))</th>
                                                <th>Tarikh Diluluskan</th>
                                                <th>Tarikh Luput</th>
												<th>@sortablelink('status', __('app.status'))</th>
                                                <th>Pejabat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="text-center">
                                                <td colspan="9">{{ __('app.no_record_found') }}</td>
                                            </tr>
                                        </tbody>
                                    @endif
									</table>
                                </div>
								<br/>
                            </div>
                            
                        </div>
                    </div>

                        <div class="col-md-8">
                            <div class="table-responsive">
                                {!! $subApplication->appends(\Request::except('page'))->render() !!}
                            </div>
                        </div>
                        @if (!$subApplication->isEmpty())
                            <div class="col-md-4">
                                <span class="float-md-right">
                                    {{ __('app.table_info', [ 'first' => $subApplication->firstItem(), 'last' => $subApplication->lastItem(), 'total' => $subApplication->total() ]) }}
                                </span>
                            </div>
                        @endif
                    
                </div>
            </div>
        </div>
        </div>
    </div>

@endsection

@push('scripts')
<script type="text/javascript">

        $(document).on('input', "input[type=text]", function () {
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
        });

</script>   
@endpush
