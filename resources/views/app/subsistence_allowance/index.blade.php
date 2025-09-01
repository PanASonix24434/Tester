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
                        <h3 class="mb-0">Permohonan Elaun Sara Hidup Nelayan Darat</h3>
                    </div>
                </div>
                @if(Auth::user()->name != 'Super Admin')
                    @if(!$subApplication->isEmpty())
                        @if($subApplicationList->sub_application_status == 'Permohonan Tidak Diluluskan Peringkat Negeri' || $subApplicationList->sub_application_status == 'Permohonan Ditolak Peringkat Negeri' ||  $subApplicationList->sub_application_status == 'Permohonan Tidak Diluluskan Peringkat HQ')
                            <div class="col-md-6">
                                <div class="mb-5 text-right">
                                    <a href="{{ route('subsistence-allowance.formdetails_appeal') }}" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i><span class="hidden-xs"> {{ __('app.create') }}</span></a>
                                </div>
                            </div>
                        @else
                            <div class="col-md-6">

                            </div>
                        @endif
                    @else
                        <div class="col-md-6">
                            <div class="mb-5 text-right">
                                <a href="{{ route('subsistence-allowance.application.create') }}" class="btn btn-secondary btn-sm @if(!$canApply) disabled @endif"><i class="fas fa-plus"></i><span class="hidden-xs"> {{ __('app.create') }}</span></a>
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
								<h4 class="mb-0" style="color:white;">Senarai Permohonan</h4>
                            </div>
                            <div class="card-body" style="padding: 0%;">
								<div class="table-responsive">
                                    <table class="table table-centered table-hover">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <div>Tarikh</div>
                                                    <div>Permohonan</div>
                                                </th>
                                                <th>No Rujukan</th>
                                                <th>Nama Pemohon</th>
                                                <th>No. Kad Pengenalan</th>
												<th>Status</th>
                                                <th>Pejabat Perikanan Daerah</th>
                                                <th style="width:1%;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!$subApplication->isEmpty())
                                                @foreach ($subApplication as $a)
                                                    <tr>
                                                        <td>{{ optional($a->submitted_at)->format('d/m/Y') }}</td>
                                                        <td>{{ $a->registration_no }}</td>
                                                        <td>{{ strtoupper($a->fullname) }}</td>
                                                        <td>{{ $a->icno }}</td>
                                                        <td>{{ strtoupper($a->sub_application_status) }}</td>
                                                        <td>{{ $a->entity_id != null ? strtoupper(Helper::getEntityNameById($a->entity_id)) : '' }}</td>
                                                        <td class="text-nowrap">
                                                            @if($a->sub_application_status == 'Permohonan Disimpan' || $a->sub_application_status == 'Permohonan Disemak (TIDAK LENGKAP)')
                                                                <a href= "{{ route('subsistence-allowance.application.editformdetails', $a->id) }}"class="btn btn-warning btn-sm">
                                                                    <i class="nav-icon fas fa-edit"></i>
                                                                </a>
                                                            @else
                                                                <a href= "{{ route('subsistence-allowance.application.show', $a->id) }}"class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-search"></i>
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="text-center">
                                                    <td colspan="10">{{ __('app.no_record_found') }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
									</table>
                                </div>
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
