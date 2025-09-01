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
                <!-- <form method="POST" enctype="multipart/form-data" action="#">
                    @csrf -->
                <!-- row -->
                <div class="row">
                    <!-- Jana Senarai Nama Permohonan Baharu -->
                    
                    <div class="card p-3">
                        <h6><i class="fas fa-list"></i> Janaan Senarai Nama Hq:</h6>
                        <a href="{{route('subsistenceallowancepayment.generatenamehq.create',$entity_id)}}" class="btn btn-primary mt-2">Jana Senarai Nama Hq</a> 
                        {{--<form action="{{ route('subsistenceallowancepayment.generatenamehq.create',$entity_id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="entity_id" value="{{$entity_id}}">
                            <button type="submit" class="btn btn-primary mt-2">Jana Senarai Nama</button> 
                        </form>--}}
                    </div>
                    
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary">
								<h4 class="mb-0" style="color:white;">Elaun Sara Sara Hidup</h4>
                            </div>

                                <div class="card-body">
                                
                                    <!-- Elaun Sara Hidup -->
                                        <p class="fw-bold text-primary">Senarai Janaan Nama Elaun Sara Hidup Nelayan Darat</p>

                                        <!-- Jadual Data -->
                                        <table id="dataTable" class="table table-striped">
                                        @if (!$lists->isEmpty())
                                            <thead>
                                                <tr>
                                                    <th>Tarikh Senarai Dijana</th>
                                                    <th>Jumlah Dalam Senarai</th>
                                                    <!-- <th>Kuota</th> -->
                                                    <th>Status</th>
                                                    <th>Tindakan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($lists as $data)
                                                    @php
                                                        $statesIds = App\Models\SubsistencePayment\SubPaymentState::where('subsistence_payment_hq_id',$data->id)->pluck('id')->toArray();
                                                        $districtIds = App\Models\SubsistencePayment\SubPayment::whereIn('subsistence_payment_states_id',$statesIds)->pluck('id')->toArray();
                                                        $count = App\Models\SubsistencePayment\SubPaymentPayee::whereIn('subsistence_payment_id', $districtIds)->count();
                                                    @endphp

                                                    <tr>
                                                        <td>{{ $data->created_at }}</td>
                                                        <td>{{ $count }}</td>
                                                        <!-- <td>{{ $data->quota }}</td> -->
                                                        <td>
                                                            <span class="badge bg-{{ $data->status == 'Dicetak' ? 'warning' : ($data->status == 'Dihantar' ? 'success' : 'primary') }}">
                                                                {{ $data->status }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            @if ($data->status == 'Dijana')
                                                                <!-- <a class="btn btn-sm btn-info" href="{{ route('subsistence-allowance.generate.pdf',  $data->id) }}"  target="_blank"><i class="fas fa-print"></i></a> -->
                                                                <a class="btn btn-sm btn-warning" href="{{ route('subsistenceallowancepayment.generatenamehq.edit', $data->id) }}">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <form action="{{ route('subsistenceallowancepayment.generatenamehq.destroy', $data->id) }}" method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                                                </form>
                                                            @endif
                                                        </td>
                                                        
                                                        <!-- <td>
                                                            <button class="btn btn-sm btn-info"><i class="fas fa-print"></i></button>
                                                            <a class="btn btn-sm btn-warning" href="{{ route('subsistence-allowance.edit', $data->id) }}">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                                        </td> -->
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            @else
                                            <thead>
                                                <tr>                                             
                                                    <th>Tarikh Senarai Dijana</th>
                                                    <th>Jumlah Senarai</th>
                                                    <th>Status</th>
                                                    <th>Tindakan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center">
                                                    <td colspan="6">{{ __('app.no_record_found') }}</td>
                                                </tr>
                                            </tbody>
                                        @endif
                                        </table>
    
                                </div>
      
                        </div>
                        
                    </div>
                        <div class="col-md-8">
                                    <div class="table-responsive">
                                        {!! $lists->appends(\Request::except('page'))->render() !!}
                                    </div>
                                </div>
                                @if (!$lists->isEmpty())
                                    <div class="col-md-4">
                                        <span class="float-md-right">
                                            {{ __('app.table_info', [ 'first' => $lists->firstItem(), 'last' => $lists->lastItem(), 'total' => $lists->total() ]) }}
                                        </span>
                                    </div>
                                @endif
                        </div>

            <!-- </form> -->
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
