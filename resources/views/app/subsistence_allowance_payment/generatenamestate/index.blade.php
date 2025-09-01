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
                        <!-- Page header -->
                        <div class="mb-8">
                            <h3 class="mb-0">Pembayaran Elaun Sara Hidup Nelayan Darat</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h6><i class="fas fa-list"></i> Janaan Senarai Nama Negeri:</h6>
                                <form method="get" action="{{ route('subsistenceallowancepayment.generatenamestate.create',$entity_id) }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label" for="selYear">Tahun : <span style="color:red;">*</span></label>
                                                <select class="form-select select2" id="selYear" name="selYear" autocomplete="off" width="100%" required>
                                                    <option value="">{{ __('app.please_select')}}</option>
                                                    <option value="2025">2025</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label" for="selMonth">Bulan : <span style="color:red;">*</span></label>
                                                <select class="form-select select2" id="selMonth" name="selMonth" autocomplete="off" width="100%" required>
                                                    <option value="">{{ __('app.please_select')}}</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                </select>
                                            </div>
                                        </div>
                                        <input type="hidden" name="entity_id" value="{{$entity_id}}">
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <button type="submit" class="btn btn-primary">Jana Senarai Nama</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header bg-primary">
                                <h4 class="mb-0" style="color:white;">Elaun Sara Sara Hidup Nelayan Darat</h4>
                            </div>
                            <div class="card-body">
                                <p class="fw-bold text-primary">Senarai Janaan Nama Elaun Sara Hidup Nelayan Darat</p>

                                <table id="dataTable" class="table table-striped">
                                    @if (!$lists->isEmpty())
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
                                            @foreach($lists as $data)
                                                @php
                                                    $districtIds = App\Models\SubsistencePayment\SubPayment::where('subsistence_payment_states_id',$data->id)->pluck('id')->toArray();
                                                    $count = App\Models\SubsistencePayment\SubPaymentPayee::whereIn('subsistence_payment_id', $districtIds)->count();
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
                                                        @if ($data->status == 'Dijana')
                                                            <!-- <a class="btn btn-sm btn-info" href="{{ route('subsistence-allowance.generate.pdf',  $data->id) }}"  target="_blank"><i class="fas fa-print"></i></a> -->
                                                            <a class="btn btn-sm btn-warning" href="{{ route('subsistenceallowancepayment.generatenamestate.edit', $data->id) }}">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('subsistenceallowancepayment.generatenamestate.destroy', $data->id) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        @else
                                        <thead>
                                            <tr>                                             
                                                <th>Tarikh Senarai Dijana</th>
                                                <th>Tahun</th>
                                                <th>Bulan</th>
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
