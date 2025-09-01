@extends('layouts.app')

@push('styles')
    <style type="text/css">
       

        #search-form {
            width: 100%; 
            margin-bottom: 40px;
        }

       
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
            </div>
            <div>
                <!-- row -->
                <div class="row ustify-content-center">
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary">
								<h4 class="mb-0" style="color:white;">Pengesahan Pendaratan </h4>
                            </div>
                            <div class="card-body" style="display:flex;  flex-direction: column; align-items:center;">
                                
                                <br/>
                                <div class="table-responsive table-card">
                                    <table class="table table-striped">
                                        <thead class="table-light">
                                            <tr> 
                                                <th>Nama Pemohon</th>
                                                <th>No. Kad Pengenalan</th>
                                                <th>Tahun</th>
                                                <th>Bulan</th>
                                                <th>Status</th>
                                                <th>Cetak</th>
                                                <th>Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!$app->isEmpty())
                                                @foreach ($app as $a)
                                                    <tr>
                                                        <td>{{ $a->name }}</td>
                                                        <td>{{ $a->username }}</td>
                                                        <td>{{ $a->year }}</td>
                                                        <td>{{ $a->month }}</td>
                                                        <td>{{ $a->landing_status_id != null ? Helper::getCodeMasterNameById($a->landing_status_id) : '' }}</td>
                                                        <td>
                                                            <a href="{{ route('landinghelper.exportExcel',['userId'=>$a->user_id, 'year'=>$a->year, 'month'=>$a->month]) }}" class="btn btn-sm btn-info">
                                                                <i class="fas fa-print"></i>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('landingdeclaration.confirmation.show', $a->id) }}" class="btn btn-sm btn-primary">
                                                                <i class="fas fa-search"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <td colspan="7">{{ __('app.no_record_found') }}</td>
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
