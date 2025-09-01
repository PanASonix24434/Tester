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
                        <h3 class="mb-0">Temp Vessel</h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-5 text-right">
                        <a href="{{ route('tempvessel.create') }}" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i> <span class="hidden-xs"> Tambah</span></a>
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
                                {{--
                                <form method="GET" action="{{ route('hebahan.hebahanapprovelist.index') }}">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 align-items-center">
                                            <div class="mb-6">
                                                <label class="form-label" for="selectOne">Select : </label>
                                                <select class="form-select" id="selectOne" >
                                                    <option selected>Open this select menu</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>
                                            <div class="mb-6">
                                                <label for="txtStartDate" class="form-label">Tarikh Mula : </label>
                                                <input type="date" id="txtStartDate" name="txtStartDate" value="" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 align-items-center">
                                            <div class="mb-6">
                                                <label for="txtEndDate" class="form-label">Tarikh Hingga : </label>
                                                <input type="date" id="txtEndDate" name="txtEndDate" value="" class="form-control" />
                                            </div>
                                            <div class="mb-6">
                                                <label for="txtDesc" class="form-label" for="selectOne">Kandungan : </label>
                                                <input type="text" id="txtDesc" name="txtDesc" value="" class="form-control" />
                                            </div>                             
                                        </div>

                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                            <br/>
                                            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Cari</button>
                                            <!--<a href="#!" class="btn btn-success btn-sm"><i class="fas fa-file-export"></i> Eksport</a>-->
                                        </div>
                                    </div>
                                </form>
                                --}}
                            </div>
                            <div class="card-body" style="padding: 0%;">
                                <div class="table-responsive">
                                    <table class="table text-nowrap mb-0 table-centered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width:1%;"></th>
                                                <th><b>NO. VESEL</b></th>
                                                <th><b>PEMILIK</b></th>
                                                <th><b>ZON</b></th>
                                                <th><b>GRT</b></th>
                                                <th><b>PERALATAN</b></th>
                                                <th><b>MAKSIMUM KRU</b></th>
                                                <th><b>MAKSIMUM KRU ASING</b></th>
                                                <th><b>PEJABAT PANGKALAN</b></th>
                                                <th><b>TARIKH TAMAT LESEN</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if (!empty($data) && !$data->isEmpty())
                                            @foreach ($data as $a)
                                                <tr>
                                                    <td class="text-nowrap">
                                                        <button type="button" class="btn btn-danger btn-sm" 
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#delete-modal"
                                                            data-href="{{ route('tempvessel.delete', $a->id) }}" >
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('tempvessel.edit', $a->id) }}">
                                                            {{ $a->no_pendaftaran }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $a->user_id!=null ? App\Models\User::find($a->user_id)->name : '' }}</td>
                                                    <td>{{ $a->zon }}</td>
                                                    <td>{{ $a->grt }}</td>
                                                    <td>{{ $a->peralatan_utama!=null ? Helper::getCodeMasterNameById($a->peralatan_utama) : '' }}</td>
                                                    <td>{{ $a->maximumKru() }}</td>
                                                    <td>{{ $a->maximumForeignKru() }}</td>
                                                    <td>{{ $a->entity_id!=null ? Helper::getEntityNameById($a->entity_id) : '' }}</td>
                                                    <td>{{ $a->license_end }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="8">{{ __('app.no_record_found') }}</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if (!empty($data) && !$data->isEmpty())
                            <div
                                class="card-footer d-md-flex justify-content-between align-items-center">
                                <div class="col-md-8">
                                    <div class="table-responsive">
                                        {!! $data->appends(Request::except('page'))->render() !!}
                                    </div>
                                </div>
                                @if (!$data->isEmpty())
                                    <div class="col-md-4">
                                        <span class="float-md-right">
                                            {{ __('app.table_info', [ 'first' => $data->firstItem(), 'last' => $data->lastItem(), 'total' => $data->total() ]) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            @endif
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
