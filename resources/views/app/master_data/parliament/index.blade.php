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
                        <h3 class="mb-0">Senarai Parlimen</h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-5 text-right">
                        <a href="{{ route('master-data.parliaments.create2') }}" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i> <span class="hidden-xs"> Tambah</span></a>
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
                                <form method="GET" action="{{ route('master-data.parliaments.index') }}">
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
                                    @if (!$parliaments->isEmpty())
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width:1%;"></th>
                                                <th><b>Kod Parlimen</b></th>
                                                <th><b>Nama Parlimen</b></th>
                                                <th><b>Negeri</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($parliaments as $item)
                                                <tr>
                                                    <td class="text-nowrap">
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-danger btn-sm" 
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#delete-modal"
                                                            data-href="{{ route('master-data.parliaments.delete', $item->id) }}" >
                                                            <i class="fas fa-trash"></i>
                                                        </button>

                                                    </td>
                                                    <td><a href="{{ route('master-data.parliaments.edit', $item->id) }}">
                                                        {{ $item->parliament_code }}
                                                        </a>
                                                    </td>
                                                    <td><a href="{{ route('master-data.parliaments.edit', $item->id) }}">
                                                        {{ $item->parliament_name }}
                                                        </a>
                                                    </td>
                                                    <td>{{ strtoupper(Helper::getCodeMasterNameById($item->state_id)) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    @else
                                        <thead class="table-light">
                                            <tr>
                                                <th><b>Kod Parlimen</b></th>
                                                <th><b>Nama Parlimen</b></th>
                                                <th><b>Negeri</b></th>
                                            </tr>
                                        </thead>
                                        <tbody><tr><td>{{ __('app.no_record_found') }}</td></tr></tbody>
                                    @endif
                                    </table>
                                </div>
                            </div>
                            <div
                                class="card-footer d-md-flex justify-content-between align-items-center">
                                <div class="col-md-8">
                                    <div class="table-responsive">
                                        {!! $parliaments->appends(Request::except('page'))->render() !!}
                                    </div>
                                </div>
                                @if (!$parliaments->isEmpty())
                                    <div class="col-md-4">
                                        <span class="float-md-right">
                                            {{ __('app.table_info', [ 'first' => $parliaments->firstItem(), 'last' => $parliaments->lastItem(), 'total' => $parliaments->total() ]) }}
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

</script>   
@endpush
