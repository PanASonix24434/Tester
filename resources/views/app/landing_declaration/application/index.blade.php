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
                            <h3 class="mb-0">Pengisytiharan Pendaratan Perikanan Darat</h3>
                        </div>
                    </div>
                    <div class="col-md-6">
                        @if($hasApprovedKadPendaftaranNelayan)
                            <div class="mb-5 text-right">  
                                <a href="{{ route('landingdeclaration.application.create') }}" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i><span class="hidden-xs"> {{ __('app.create') }}</span></a>
                            </div>
                        @endif
                    </div>
                </div>
                <div>
                    <!-- row -->
                    <div class="row ustify-content-center">
                        <div class="col-12">
                            <!-- card -->
                            <div class="card mb-4">
                                <div class="card-header bg-primary">
                                    <h4 class="mb-0" style="color:white;">Senarai Permohonan</h4>
                                </div>
                                <div class="card-body" style="display:flex;  flex-direction: column; align-items:center;">
                                    
                                    <br/>
                        
                                    <div class="table-responsive table-card">
                                        <table class="table table-striped">
                                            <thead class="table-light">
                                                <tr> 
                                                    <th>Tarikh Permohonan</th>
                                                    <th>Tahun</th>
                                                    <th>Bulan</th>
                                                    <th>Pejabat Perikanan Daerah</th>
                                                    <th>Status</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!$app->isEmpty())
                                                    @foreach ($app as $a)
                                                        <tr>
                                                            <td>{{ optional($a->created_at)->format('d/m/Y') }}</td>
                                                            <td>{{ $a->year }}</td>
                                                            <td>{{ $a->month }}</td>
                                                            <td>{{ $a->entity_id != null ? strtoupper(Helper::getEntityNameById($a->entity_id)) : '' }}</td>
                                                            <td>{{ $a->landing_status_id != null ? Helper::getCodeMasterNameById($a->landing_status_id) : '' }}</td>
                                                            <td>
                                                                @if ($a->landing_status_id == $disimpanId || $a->landing_status_id == $tidakLengkapId)
                                                                    <a href="{{ route('landingdeclaration.application.edit', $a->id) }}" class="btn btn-sm btn-warning" title="Kemaskini">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                @else
                                                                    <a href="{{ route('landingdeclaration.application.show', $a->id) }}" class="btn btn-sm btn-primary" title="Lihat">
                                                                        <i class="fas fa-search"></i>
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr class="text-center">
                                                        <td colspan="6">{{ __('app.no_record_found') }}</td>
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
                                {!! $app->appends(Request::except('page'))->render() !!}
                            </div>
                        </div>
                        @if (!$app->isEmpty())
                            <div class="col-md-4">
                                <span class="float-md-right">
                                    {{ __('app.table_info', [ 'first' => $app->firstItem(), 'last' => $app->lastItem(), 'total' => $app->total() ]) }}
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
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
        alert(msg);
    }
</script>   
@endpush
