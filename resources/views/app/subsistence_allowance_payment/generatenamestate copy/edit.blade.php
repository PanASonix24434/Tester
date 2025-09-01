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
                        <h3 class="mb-0">Pembayaran Elaun Sara Hidup Nelayan Darat</h3>
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
								<h4 class="mb-0" style="color:white;">Senarai Elaun Sara Hidup Nelayan Darat</h4>
                            </div>

                                <div class="card-body">
                                    <div class="container mt-4">
                                        <!-- Butang Cetak -->
                                        <div class="d-flex justify-content-end mb-3">
                                            <!-- <a class="btn btn-info" href="{{ route('subsistence-allowance.generate.listname.pdf', $id) }}"  target="_blank">
                                                <i class="fas fa-print" ></i> Cetak Senarai Nama
                                            </a> -->
                                        </div>

                                        <!-- Jadual Data -->
                                        <div class="table-responsive">
                                        <table id="dataTable" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Tindakan</th>
                                                    <!-- <th>Status</th> -->
                                                    <th>Nama Pemohon</th>
                                                    <th>No KP</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($payees as $data)
                                                    @php
                                                        $user = App\Models\User::find($data->user_id);
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('subsistence-allowance.showformdetails', $data->user_id) }}" class="btn btn-sm btn-primary" target="_blank"><i class="fas fa-eye"></i></a>

                                                            {{--
                                                                @if($data->decision_district == null)
                                                                    <form action="{{ route('subsistenceallowancepayment.generatenamehq.verifyListName') }}" method="POST" class="d-inline">
                                                                        @csrf
                                                                        <input type="hidden" name="application_id" value="{{ $data->id }}">
                                                                        <input type="hidden" name="status" value="sokong">
                                                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Disokong?')">
                                                                            <i class="fas fa-check"></i>
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                                @if($data->decision_district == null)
                                                                    <form action="{{ route('subsistenceallowancepayment.generatenamehq.verifyListName') }}" method="POST" class="d-inline">
                                                                        @csrf
                                                                        <input type="hidden" name="application_id" value="{{ $data->id }}">
                                                                        <input type="hidden" name="status" value="tidak sokong">
                                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tidak Disokong?')">
                                                                            <i class="fas fa-times"></i>
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                                --}}

                                                            </div>
                                                        </td>
                                                        {{--
                                                        <td>
                                                            
                                                            @if ($data->decision_district == 'Sokong')
                                                                <span class="badge bg-success">Disokong</span>
                                                            @elseif ($data->decision_district == 'Tidak Disokong')
                                                                <span class="badge bg-warning">Tidak Disokong</span>
                                                            @else
                                                                <span class="badge bg-secondary">Belum Membuat Sokongan</span>
                                                            @endif
                                                        </td>
                                                        --}}
                                                        <td>{{ $user != null ? $user->name : '' }}</td>
                                                        <td>{{ $user != null ? $user->username : '' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="table-responsive">
                                                    {!! $payees->appends(\Request::except('page'))->render() !!}
                                                </div>
                                            </div>

                                            @if (!$payees->isEmpty())
                                                <div class="col-md-4 d-flex justify-content-end align-items-center">
                                                    <span>
                                                        {{ __('app.table_info', [ 'first' => $payees->firstItem(), 'last' => $payees->lastItem(), 'total' => $payees->total() ]) }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-lg-center">
                                            </div>
                                        </div>
                                    </div>
                                   
                                    
                                    <form method="POST" enctype="multipart/form-data" action="{{ route('subsistenceallowancepayment.generatenamehq.storeListName') }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$application->id}}">
                                      <!-- button action -->
                                    <div class="card-body">
                                        <div class="row">
                                            <br />
                                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                                <a href="{{ route('subsistenceallowancepayment.generatenamehq.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                <!-- <a href="#" class="btn btn-success btn-sm"> <i class="fas fa-arrow-right"></i> {{ __('app.submit') }}</a> -->
                                                <button type="submit" class="btn btn-success btn-sm"  onclick="return confirm($('<span>Sokong Senarai?</span>').text())">
                                                    <i class="fas fa-paper-plane"></i>  {{ __('app.submit') }}
                                                </button>
                                               
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
