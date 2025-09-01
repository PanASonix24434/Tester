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
                            <h3 class="mb-0">Pembayaran Elaun Sara Hidup Nelayan Darat</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header bg-primary">
                                <h4 class="mb-0" style="color:white;">Elaun Sara Sara Hidup Nelayan Darat</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <p class="fw-bold text-primary">Senarai Janaan Nama Elaun Sara Hidup Nelayan Darat</p>
                                    <table id="dataTable" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Tarikh Senarai Dijana</th>
                                                <th>Tahun</th>
                                                <th>Bulan</th>
                                                <th>Jumlah Dalam Senarai</th>
                                                <th>Status</th>
                                                <th>Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!$lists->isEmpty())
                                                @foreach($lists as $data)
                                                    @php
                                                        $stateIds = App\Models\SubsistencePayment\SubPaymentState::where('subsistence_payment_hq_id',$data->id)->pluck('id')->toArray();
                                                        $districtIds = App\Models\SubsistencePayment\SubPayment::whereIn('subsistence_payment_states_id',$stateIds)->pluck('id')->toArray();
                                                        $count = App\Models\SubsistencePayment\SubPaymentPayee::whereIn('subsistence_payment_id', $districtIds)->where('has_landing',true)->count();
                                                    @endphp

                                                    <tr>
                                                        <td>{{ $data->created_at }}</td>
                                                        <td>{{ $data->year }}</td>
                                                        <td>{{ $data->month }}</td>
                                                        <td>{{ $count }}</td>
                                                        <td>
                                                            <span class="badge bg-{{ $data->status == 'Dicetak' ? 'warning' : ($data->status == 'Dihantar' ? 'success' : 'primary') }}">
                                                                {{ $data->status }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            @if ($data->status == 'Dihantar')
                                                                <a class="btn btn-sm btn-warning" href="{{ route('subsistenceallowancepayment.generateallocation.edit', $data->id) }}">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="text-center">
                                                    <td colspan="4">{{ __('app.no_record_found') }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
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
