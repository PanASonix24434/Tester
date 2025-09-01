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
                                                    <th>Nama Pemohon</th>
                                                    <th>No Kad Pengenalan</th>
                                                    <th>Pendaratan ({{$application->month}}/{{$application->year}})</th>
                                                    <th>Pejabat Perikanan Daerah</th>
                                                    <th>Tindakan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($payees as $data)
                                                    @php
                                                        $user = App\Models\User::find($data->user_id);
                                                        $subApplication = App\Models\SubsistenceAllowance\SubApplication::where('icno',$user->username)->select('id','entity_id')->latest('application_expired_date')->first();
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $user != null ? $user->name : '' }}</td>
                                                        <td>{{ $user != null ? $user->username : '' }}</td>
                                                        <td>
                                                            @if ($data->has_landing)
                                                                <span class="badge bg-success">Ada Pendaratan</span>
                                                            @else
                                                                <span class="badge bg-danger">Tiada Pendaratan</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $subApplication->entity_id != null ? strtoupper(Helper::getEntityNameById($subApplication->entity_id)) : '' }}</td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('subsistence-allowance.showformdetails', $subApplication->id) }}" class="btn btn-sm btn-primary" target="_blank"><i class="fas fa-search"></i></a>
                                                            </div>
                                                        </td>
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
                                    </div>
                                   
                                       
                                   
                                    <form method="POST" enctype="multipart/form-data" action="{{ route('subsistenceallowancepayment.generatenamedistrict.storeListName') }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$application->id}}">
                                      <!-- button action -->
                                    <div class="card-body">
                                        <div class="row">
                                            <br />
                                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                                <a href="{{ route('subsistenceallowancepayment.generatenamedistrict.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                <!-- <a href="#" class="btn btn-success btn-sm"> <i class="fas fa-arrow-right"></i> {{ __('app.submit') }}</a> -->
                                                <button type="submit" class="btn btn-primary btn-sm"  onclick="return confirm($('<span>Hantar Senarai ?</span>').text())">
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
