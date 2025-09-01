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
                        <h3 class="mb-0">Senarai Kakitangan</h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-5 text-right">
                        <a href="{{ route('profile.staffcreate') }}" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i> <span class="hidden-xs"> Tambah</span></a>
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
                                <form method="GET" action="{{ route('profile.stafflist') }}">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 align-items-center">
                                        <div class="mb-6">
                                            <label for="txtName" class="form-label">Nama Kakitangan : </label>
                                            <input type="text" id="txtName" name="txtName" value="{{ $filterName }}" class="form-control" />
                                        </div>
                                        <div class="mb-6">
                                            <label for="selStatus" class="form-label">Status : </label>
                                            <select class="form-control" id="selStatus" name="selStatus" autocomplete="off" width="100%">
                                                <option value="">-- PAPAR SEMUA --</option>                                       											
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 align-items-center">
                                        <div class="mb-6">
                                            <label for="txtICNO" class="form-label" for="selectOne">No Kad Pengenalan : </label>
                                            <input type="text" id="txtICNO" name="txtICNO" value="{{ $filterICNO }}" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                        <br/>
                                        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Cari</button>
                                        <!--<a href="#!" class="btn btn-success btn-sm"><i class="fas fa-file-export"></i> Eksport</a>-->
                                    </div>
                                </div>
                                </form>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table class="table text-nowrap mb-0 table-centered table-hover">
                                    @if (!$staffs->isEmpty())
                                        <thead class="table-light">
                                            <tr>
                                                <th><b>Nama</b></th>
                                                <th><b>No Kad Pengenalan</b></th>
                                                <th><b>Email</b></th>
                                                <th><b>Status</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($staffs as $a)
                                            <tr>
                                                <td>{{ $a->name }}</td>
                                                <td>{{ $a->icno }}</td>
                                                <td>{{ $a->email }}</td>

                                                @if ($a->is_active == true)
                                                <td>AKTIF</td>
                                                @else
                                                <td>TIDAK AKTIF</td>
                                                @endif
                                                
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    @else
                                        <thead>
                                            <tr>
                                                <th><b>Nama</b></th>
                                                <th><b>No Kad Pengenalan</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="2">{{ __('app.no_record_found') }}</td>
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
                                        {!! $staffs->appends(Request::except('page'))->render() !!}
                                    </div>
                                </div>
                                @if (!$staffs->isEmpty())
                                    <div class="col-md-4">
                                        <span class="float-md-right">
                                            {{ __('app.table_info', [ 'first' => $staffs->firstItem(), 'last' => $staffs->lastItem(), 'total' => $staffs->total() ]) }}
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

        var msg = '{{Session::get('alert')}}';
        var exist = '{{Session::has('alert')}}';
        if(exist){
            alert(msg);
        }

</script>   
@endpush
