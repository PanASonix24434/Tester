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
                        <h3 class="mb-0">Senarai Hebahan</h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-5 text-right">
                        <a href="{{ route('hebahan.hebahanlist.create') }}" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i> <span class="hidden-xs"> Tambah</span></a>
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
                                <form method="GET" action="{{ route('hebahan.hebahanlist.index') }}">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 align-items-center">
                                        <div class="mb-6">
                                            <label for="txtStartDate" class="form-label">Tarikh Mula : </label>
                                            <input type="date" id="txtStartDate" name="txtStartDate" value="{{ $filterStartDate }}" class="form-control" />
                                        </div>
                                        <div class="mb-6">
                                            <label for="txtTitle" class="form-label" for="selectOne">Tajuk : </label>
                                            <input type="text" id="txtTitle" name="txtTitle" value="{{ $filterTitle }}" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 align-items-center">
                                        <div class="mb-6">
                                            <label for="txtEndDate" class="form-label">Tarikh Hingga : </label>
                                            <input type="date" id="txtEndDate" name="txtEndDate" value="{{ $filterEndDate }}" class="form-control" />
                                        </div>
                                        <div class="mb-6">
                                            <label for="txtDesc" class="form-label" for="selectOne">Kandungan : </label>
                                            <input type="text" id="txtDesc" name="txtDesc" value="{{ $filterDesc }}" class="form-control" />
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
                                    @if (!$hebahan->isEmpty())
                                        <thead class="table-light">
                                            <tr>
                                                <th><b>Tarikh Hebahan</b></th>
                                                <th><b>Tajuk</b></th>
                                                <th><b>Kandungan</b></th>
                                                <th><b>Peranan</b></th>
                                                <th><b>Pejabat / Kawasan</b></th>
                                                <th><b>Status</b></th>
                                                <th><b>Dikemaskini Oleh</b></th>
                                                <th><b>Tarikh Kemaskini</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($hebahan as $a)
                                            <tr>
                                                <td>{{ Carbon\Carbon::createFromFormat('Y-m-d', $a->tarikh)->format('d/m/Y') }}</td>

                                                <td><a href="{{ route('hebahan.hebahanlist.edit', $a->id) }}">
                                                    {{ $a->tajuk }}
                                                    </a>
                                                </td>
                                                <td>{{ $a->kandungan }}</td>
                                                <td>{{ $a->name }}</td>
                                                <td>{{ strtoupper(Helper::getEntityNameById($a->entity_id)) }}</td>
                                                
                                                @if ($a->status == 1)
                                                    <td>DIHANTAR</td>
                                                @elseif ($a->status == 2)
                                                    <td>DILULUSKAN</td>
                                                @elseif ($a->status == 3)
                                                    <td>DITOLAK</td>
                                                @else
                                                    <td></td>
                                                @endif
                                                
                                                
                                                <td>{{ strtoupper(App\Models\User::withTrashed()->find($a->updated_by)->name) }}</td>
                                                <td>{{ $a->updated_at->format('d/m/Y h:i:s A') }}</td>                                               
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    @else
                                        <thead>
                                            <tr>
                                                <th><b>Tarikh Hebahan</b></th>
                                                <th><b>Tajuk</b></th>
                                                <th><b>Kandungan</b></th>
                                                <th><b>Peranan</b></th>
                                                <th><b>Pejabat / Kawasan</b></th>
                                                <th><b>Status</b></th>
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
                                        {!! $hebahan->appends(Request::except('page'))->render() !!}
                                    </div>
                                </div>
                                @if (!$hebahan->isEmpty())
                                    <div class="col-md-4">
                                        <span class="float-md-right">
                                            {{ __('app.table_info', [ 'first' => $hebahan->firstItem(), 'last' => $hebahan->lastItem(), 'total' => $hebahan->total() ]) }}
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
