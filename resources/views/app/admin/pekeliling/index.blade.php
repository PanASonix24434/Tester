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
                        <h3 class="mb-0">Senarai Pekeliling</h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-5 text-right">
                        <a href="{{ route('administration.pekeliling.create') }}" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i> <span class="hidden-xs"> Tambah</span></a>
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
                                <form method="GET" action="{{ route('administration.pekeliling.index') }}">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 align-items-center">
                                        <div class="mb-6">
                                            <label for="txtStartDate" class="form-label">Tarikh Mula : </label>
                                            <input type="date" id="txtStartDate" name="txtStartDate" value="{{ $filterStartDate }}" class="form-control" />
                                        </div>
                                        <div class="mb-6">
                                            <label for="txtName" class="form-label" for="selectOne">Bilangan Pekeliling : </label>
                                            <input type="text" id="txtName" name="txtName" value="{{ $filterName }}" class="form-control" />
                                        </div>
                                        <div class="mb-6">
                                            <label for="txtRefNo" class="form-label" for="selectOne">No. Rujukan : </label>
                                            <input type="text" id="txtRefNo" name="txtRefNo" value="{{ $filterRefNo }}" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 align-items-center">
                                        <div class="mb-6">
                                            <label for="txtEndDate" class="form-label">Tarikh Hingga : </label>
                                            <input type="date" id="txtEndDate" name="txtEndDate" value="{{ $filterEndDate }}" class="form-control" />
                                        </div>
                                        <div class="mb-6">
                                            <label for="txtTitle" class="form-label" for="selectOne">Tajuk Pekeliling : </label>
                                            <input type="text" id="txtTitle" name="txtTitle" value="{{ $filterTitle }}" class="form-control" />
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
                                    @if (!$pekeliling->isEmpty())
                                        <thead class="table-light">
                                            <tr>
                                                <th><b>Tarikh Pekeliling</b></th>
                                                <th><b>Bilangan Pekeliling</b></th>
                                                <th><b>Tajuk</b></th>
                                                <th><b>No. Rujukan</b></th>
                                                <th><b>Dokumen</b></th>
                                                <th><b>Dikemaskini Oleh</b></th>
                                                <th><b>Tarikh Kemaskini</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pekeliling as $a)
                                            <tr>
                                                <td>{{ Carbon\Carbon::createFromFormat('Y-m-d', $a->tarikh)->format('d/m/Y') }}</td>

                                                <td><a href="{{ route('administration.pekeliling.edit', $a->id) }}">
                                                    {{ $a->nama }}
                                                    </a>
                                                </td>
                                                <td>{{ $a->tajuk }}</td>
                                                <td>{{ $a->no_rujukan }}</td>
                                                <td><a href="{{ route('administration.pekeliling.downloadDoc', $a->id) }}">
                                                    {{ $a->file_name }}
                                                    </a>
                                                </td>

                                                <td>{{ strtoupper(App\Models\User::withTrashed()->find($a->updated_by)->name) }}</td>
                                                <td>{{ $a->updated_at->format('d/m/Y h:i:s A') }}</td>
                                                
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    @else
                                        <thead>
                                            <tr>
                                                <th><b>Tarikh Pekeliling</b></th>
                                                <th><b>Bilangan Pekeliling</b></th>
                                                <th><b>Tajuk</b></th>
                                                <th><b>No. Rujukan</b></th>
                                                <th><b>Dokumen</b></th>
                                                <th><b>Dikemaskini Oleh</b></th>
                                                <th><b>Tarikh Kemaskini</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="8">{{ __('app.no_record_found') }}</td>
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
                                        {!! $pekeliling->appends(Request::except('page'))->render() !!}
                                    </div>
                                </div>
                                @if (!$pekeliling->isEmpty())
                                    <div class="col-md-4">
                                        <span class="float-md-right">
                                            {{ __('app.table_info', [ 'first' => $pekeliling->firstItem(), 'last' => $pekeliling->lastItem(), 'total' => $pekeliling->total() ]) }}
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
        var msgSuccess = '{{Session::get('pekeliling_success')}}';
        var existSuccess = '{{Session::has('pekeliling_success')}}';
        if(existSuccess){
            alert(msgSuccess);
        }

        //Display failed message
        var msgFailed = '{{Session::get('pekeliling_failed')}}';
        var existFailed = '{{Session::has('pekeliling_failed')}}';
        if(existFailed){
            alert(msgFailed);
        }

</script>   
@endpush
