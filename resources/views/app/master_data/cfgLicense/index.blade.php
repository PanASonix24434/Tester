@extends('layouts.app')

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
                        <h3 class="mb-0">Senarai Konfigurasi Lesen</h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-5 text-right">
                        <a href="{{ route('master-data.licenses.create') }}" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i> <span class="hidden-xs"> Tambah</span></a>
                    </div>
                </div>
            </div>
            <div>
                <!-- row -->
                <div class="row">
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <div class="card-header">

                                <!-- Form -->
                                <form method="GET" action="{{ route('master-data.licenses.index') }}">
                                <div class="row">
                                    <div class="col-lg-12 align-items-center">
                                        <div class="mb-6">
                                            <label for="txtName" class="form-label">Maklumat Carian : </label>
                                            <input type="text" id="txtName" name="txtName" value="{{ $txtName }}" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Cari</button>
                                    </div>
                                </div>
                                </form><br/>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table class="table text-nowrap mb-0 table-centered table-hover">
                                    @if (!$licenses->isEmpty())
                                        <thead class="table-light">
                                            <tr>
                                                <th><b>Parameter Lesen</b></th>
                                                <th><b>Penerangan</b></th>
                                                <th><b>Tempoh Lesen (Tahun)</b></th>
                                                <th><b>Amaun Lesen (RM)</b></th>
                                                <th><b>Tarikh Kuat Kuasa</b></th>
                                                <th><b>Tarikh Hingga</b></th>
                                                <th><b>Status</b></th>
                                                <th><b>Dikemaskini Oleh</b></th>
                                                <th><b>Tarikh Dikemaskini</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($licenses as $item)
                                                <tr>
                                                    <td><a href="{{ route('master-data.licenses.edit', $item->id) }}">
                                                        {{ $item->license_parameter }}
                                                        </a>
                                                    </td>
                                                    
                                                    <td>{{ $item->desc }}</td>
                                                    <td>{{ $item->license_duration }}</td>
                                                    <td>{{ $item->license_amount }}</td>
                                                    <td>{{ Helper::convertDateToFormat($item->start_date) }}</td>
                                                    @if ($item->end_date == null || $item->end_date == "")
                                                        <td>{{ $item->end_date }}</td>
                                                    @else
                                                        <td>{{ Helper::convertDateToFormat($item->end_date) }}</td>
                                                    @endif
                                                    
                                                    @if ($item->is_active == true || $item->is_active == '1')
                                                        <td><b>AKTIF</b></td>
                                                    @else
                                                        <td>TIDAK AKTIF</td> 
                                                    @endif

                                                    <td>{{ strtoupper(Helper::getUsersNameById($item->updated_by)) }}</td>
                                                    <td>{{ $item->updated_at->format('d/m/Y H:i:s') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    @else
                                        <thead>
                                            <tr>
                                                <th>Parameter Lesen</th>
                                                <th>Penerangan</th>
                                                <th>Tempoh Lesen</th>
                                                <th>Amaun Lesen</th>
                                                <th>Tarikh Kuat Kuasa</th>
                                                <th>Tarikh Hingga</th>
                                                <th>Status</th>
                                                <th>Dikemaskini Oleh</th>
                                                <th>Tarikh Dikemaskini</th>
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
                            </div>
                            <div
                                class="card-footer d-md-flex justify-content-between align-items-center">
                                <div class="col-md-8">
                                    <div class="table-responsive">
                                        {!! $licenses->appends(Request::except('page'))->render() !!}
                                    </div>
                                </div>
                                @if (!$licenses->isEmpty())
                                    <div class="col-md-4">
                                        <span class="float-md-right">
                                            {{ __('app.table_info', [ 'first' => $licenses->firstItem(), 'last' => $licenses->lastItem(), 'total' => $licenses->total() ]) }}
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
    </div>

@endsection

@push('scripts')
<script type="text/javascript">

        $(document).on('input', "input[type=text]", function () {
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
        });

        //Display success message
        var msgSuccess = '{{Session::get('lcn_success')}}';
        var existSuccess = '{{Session::has('lcn_success')}}';
        if(existSuccess){
            alert(msgSuccess);
        }

        //Display failed message
        var msgFailed = '{{Session::get('lcn_failed')}}';
        var existFailed = '{{Session::has('lcn_failed')}}';
        if(existFailed){
            alert(msgFailed);
        }

</script>   
@endpush
