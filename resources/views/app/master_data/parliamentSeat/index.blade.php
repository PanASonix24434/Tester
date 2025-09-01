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
                        <h3 class="mb-0">Senarai Dewan Undangan Negeri (DUN)</h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-5 text-right">
                        <a href="{{ route('master-data.aduns.create') }}" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i> <span class="hidden-xs"> Tambah</span></a>
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
                                <form method="GET" action="{{ route('master-data.aduns.index') }}">
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
                                    @if (!$parliamentSeats->isEmpty())
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width:1%;"></th>
                                                <th><b>Kod DUN</b></th>
                                                <th><b>Nama DUN</b></th>
                                                <th><b>Parlimen</b></th>
                                                <th><b>Negeri</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($parliamentSeats as $item)
                                                <tr>
                                                    <td class="text-nowrap">
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-danger btn-sm" 
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#delete-modal"
                                                            data-href="{{ route('master-data.aduns.delete', $item->id) }}" >
                                                            <i class="fas fa-trash"></i>
                                                        </button>

                                                    </td>
                                                    <td><a href="{{ route('master-data.aduns.edit', $item->id) }}">
                                                        {{ $item->parliament_seat_code }}
                                                        </a>
                                                    </td>
                                                    <td><a href="{{ route('master-data.aduns.edit', $item->id) }}">
                                                        {{ $item->parliament_seat_name }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $item->parliament_code }} - {{ $item->parliament_name }}</td>
                                                    <td>{{ strtoupper(Helper::getCodeMasterNameById($item->state_id)) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    @else
                                        <thead class="table-light">
                                            <tr>
                                                <th><b>Kod DUN</b></th>
                                                <th><b>Nama DUN</b></th>
                                                <th><b>Parlimen</b></th>
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
                                        {!! $parliamentSeats->appends(Request::except('page'))->render() !!}
                                    </div>
                                </div>
                                @if (!$parliamentSeats->isEmpty())
                                    <div class="col-md-4">
                                        <span class="float-md-right">
                                            {{ __('app.table_info', [ 'first' => $parliamentSeats->firstItem(), 'last' => $parliamentSeats->lastItem(), 'total' => $parliamentSeats->total() ]) }}
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
