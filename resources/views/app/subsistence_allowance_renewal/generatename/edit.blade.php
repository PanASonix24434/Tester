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
                <div class="col-md-8">
                    <!-- Page header -->
                    <div class="mb-8">
                        <h3 class="mb-0">Kemaskini Janaan Nama</h3>
                    </div>
                </div>
                <div class="col-md-4">
                </div>
            </div>
            
            <div>
               
                <!-- row -->
                <div class="row">
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary">
								<h4 class="mb-0" style="color:white;">Senarai Pembaharuan ESH Nelayan Darat</h4>
                            </div>

                                <div class="card-body">
                                    <div class="container mt-4">
                                        <!-- Butang Cetak -->
                                        <div class="d-flex justify-content-end mb-3">
                                            <a class="btn btn-info" href="{{ route('subsistence-allowance-renewal.generate.listname.pdf', $id) }}"  target="_blank">
                                                <i class="fas fa-print" ></i> Cetak Senarai Nama
                                            </a>
                                        </div>

                                        <!-- Jadual Data -->
                                        <div class="table-responsive">
                                        <table id="dataTable" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Tindakan</th>
                                                    <th>Status</th>
                                                    <th>Tarikh Permohonan</th>
                                                    <th>No Fail</th>
                                                    <th>Nama Pemohon</th>
                                                    <th>No KP</th>
                                                    <th>Jenis Permohonan</th>
                                                    <th>Negeri</th>
                                                    <th>Daerah</th>
                                                    <th>Tangkapan Bulanan (KG)</th>
                                                    <th>Pendapatan Sebulan (RM)</th>
                                                    <th>Hasil Tangkapan (RM)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($applications as $data)
                                                <tr>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('subsistence-allowance-renewal.showformdetails', $data->id) }}" class="btn btn-sm btn-primary" target="_blank"><i class="fas fa-search"></i></a>

                                                      
                                                        @if($data->status_quota == 'senarai_menunggu')
                                                        <form action="{{ route('subsistence-allowance-renewal.verifyListName') }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" name="application_id" value="{{ $data->id }}">
                                                            <input type="hidden" name="status" value="layak diluluskan">
                                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Disokong?')">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                        @endif

                                                        @if($data->status_quota == 'senarai_menunggu' )
                                                        <form action="{{ route('subsistence-allowance-renewal.verifyListName') }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" name="application_id" value="{{ $data->id }}">
                                                            <input type="hidden" name="status" value="ditolak">
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tidak Layak?')">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </form>
                                                        @endif

                                                    </div>
                                                </td>

                                                    <td class="text-center">
                                                            @if ($data->status_quota == 'layak diluluskan')
                                                                <span class="badge bg-success">Layak Diluluskan</span>
                                                            @elseif ($data->status_quota == 'layak tidak diluluskan')
                                                                <span class="badge bg-warning">Layak Tidak Diluluskan</span>
                                                            @elseif ($data->status_quota == 'ditolak')
                                                                <span class="badge bg-danger">Ditolak</span>
                                                            @else
                                                                <span class="badge bg-secondary">Senarai Menunggu</span>
                                                            @endif
                                                    </td>
                                                    <td>{{ $data->created_at }}</td>
                                                    <td>{{ $data->registration_no }}</td>
                                                    <td>{{ $data->fullname }}</td>
                                                    <td>{{ $data->icno }}</td>
                                                    <td>
                                                        @if($data->type_registration == 'Renew')
                                                            <span class="badge bg-success">Pembaharuan</span>
                                                        @elseif($data->type_registration == 'Rayuan Pembaharuan')
                                                            <span class="badge bg-warning text-dark">Rayuan</span>
                                                        @endif
                                                    </td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>{{ $data->tot_incomefish }}</td>
                                                </tr>
                                                @endforeach
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
                                   
                                       
                                   
                                    <form method="POST" enctype="multipart/form-data" action="{{ route('subsistence-allowance-renewal.storeListName', $id) }}">
                                    @csrf
                                      <!-- button action -->
                                    <div class="card-body">
                                        <div class="row">
                                            <br />
                                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                                <a href="{{ route('subsistence-allowance-renewal.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                <!-- <a href="#" class="btn btn-success btn-sm"> <i class="fas fa-arrow-right"></i> {{ __('app.submit') }}</a> -->
                                                <!-- <button type="submit" class="btn btn-success btn-sm"  onclick="return confirm($('<span>Hantar Senarai ?</span>').text())">
                                                    <i class="fas fa-arrow-right"></i>  {{ __('app.submit') }}
                                                </button> -->
                                                @if ($canUpdate)
                                                <button type="submit" class="btn btn-primary btn-sm" @if(!$allApplicationHaveUpdated) disabled @endif onclick="return confirm($('<span>Hantar Senarai ?</span>').text())">
                                                    <i class="fas fa-paper-plane"></i>  {{ __('app.submit') }}
                                                </button>
                                                @endif
                                               
                                            </div>
                                        </div>
                                    </div>
                                   
                                </div>
                        </div>
                    </div>
                </div>
                

            </form>
            </div>

        </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">

        $(document).on('input', "input[type=text]", function () {
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
        });

        

       

</script>   
@endpush
