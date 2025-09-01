@extends('layouts.app')

@push('styles')
    <style type="text/css">
    </style>
@endpush

@section('content')

    <div id="app-content">
        <div class="app-content-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-8">
                        <h3 class="mb-0">Permohonan Elaun Sara Hidup Nelayan Darat</h3>
                    </div>
                </div>
                <div class="col-md-4">
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header bg-primary">
                            <h4 class="mb-0" style="color:white;">Senarai Nama</h4>
                        </div>
                        <div class="card-body">
                            <div class="container mt-4">
                                <div class="d-flex justify-content-end mb-3">
                                    <a class="btn btn-info" href="{{ route('subsistence-allowance.generate-name-state.generateListNamePDF', $id) }}"  target="_blank">
                                        <i class="fas fa-print" ></i> Cetak Senarai Nama
                                    </a>
                                </div>
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Tarikh Permohonan</th>
                                                <th>No Rujukan</th>
                                                <th>Nama Pemohon</th>
                                                <th>No KP</th>
                                                <!-- <th>Jenis Permohonan</th> -->
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!$applications->isEmpty())
                                                @foreach($applications as $data)
                                                <tr>
                                                    <td>{{ $data->created_at }}</td>
                                                    <td>{{ $data->registration_no }}</td>
                                                    <td>{{ $data->fullname }}</td>
                                                    <td>{{ $data->icno }}</td>
                                                    {{--
                                                    <td>
                                                        @if($data->type_registration == 'Baru')
                                                            <span class="badge bg-success">Baru</span>
                                                        @elseif($data->type_registration == 'Rayuan')
                                                            <span class="badge bg-warning text-dark">Rayuan</span>
                                                        @endif
                                                    </td>
                                                    --}}
                                                    <td class="text-center">
                                                        @if ($data->status_quota == 'layak diluluskan')
                                                            <span class="badge bg-success">Disokong</span>
                                                        @elseif ($data->status_quota == 'layak tidak diluluskan')
                                                        <span class="badge bg-warning">Layak Tidak Diluluskan</span>
                                                        @elseif ($data->status_quota == 'ditolak')
                                                            <span class="badge bg-danger">Ditolak</span>
                                                        @else
                                                            <span class="badge bg-secondary">Senarai Menunggu</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('subsistence-allowance.application.show', $data->id) }}" class="btn btn-sm btn-primary" target="_blank"><i class="fas fa-search"></i></a>
                                                            @if($data->status_quota == 'senarai_menunggu')
                                                                <form action="{{ route('subsistence-allowance.generate-name-state.verifyListName') }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <input type="hidden" name="application_id" value="{{ $data->id }}">
                                                                    <input type="hidden" name="status" value="layak diluluskan">
                                                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Disokong?')">
                                                                        <i class="fas fa-check"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                            @if($data->status_quota == 'senarai_menunggu')
                                                                <form action="{{ route('subsistence-allowance.generate-name-state.verifyListName') }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <input type="hidden" name="application_id" value="{{ $data->id }}">
                                                                    <input type="hidden" name="status" value="layak tidak diluluskan">
                                                                    <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Layak tetapi Tidak Disokong?')">
                                                                        <i class="fas fa-minus"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                            @if($data->status_quota == 'senarai_menunggu' )
                                                                <form action="{{ route('subsistence-allowance.generate-name-state.verifyListName') }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <input type="hidden" name="application_id" value="{{ $data->id }}">
                                                                    <input type="hidden" name="status" value="ditolak">
                                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tidak Disokong?')">
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="7">-Tiada Rekod-</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="table-responsive">
                                            {!! $applications->appends(\Request::except('page'))->render() !!}
                                        </div>
                                    </div>
                                    @if (!$applications->isEmpty())
                                        <div class="col-md-4 d-flex justify-content-end align-items-center">
                                            <span>
                                                {{ __('app.table_info', [ 'first' => $applications->firstItem(), 'last' => $applications->lastItem(), 'total' => $applications->total() ]) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <br />
                            <form method="POST" action="{{ route('subsistence-allowance.generate-name-state.storeListName', $id) }}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                        <a href="{{ route('subsistence-allowance.generate-name-state.index') }}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        @if ($canUpdate)
                                            <button type="submit" class="btn btn-success btn-sm" @if(!$allApplicationHaveUpdated) disabled @endif onclick="return confirm($('<span>Hantar Senarai ?</span>').text())">
                                                <i class="fas fa-paper-plane"></i>  {{ __('app.submit') }}
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </form>
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
</script>   
@endpush
