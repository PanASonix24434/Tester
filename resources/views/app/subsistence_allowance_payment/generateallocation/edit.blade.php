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
                                <h4 class="mb-0" style="color:white;">Kelulusan PBKP</h4>
                            </div>
                            <div class="card-body">
                                <div class="container mt-4">
                                    <div class="d-flex justify-content-end mb-3">
                                    </div>
                                    <div class="table-responsive">
                                        <table id="dataTable" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nama Pemohon</th>
                                                    <th>No KP</th>
                                                    <th>Pendaratan ({{$application->month}}/{{$application->year}})</th>
                                                    <th>Pejabat Perikanan Daerah</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!$payees->isEmpty())
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
                                                @else
                                                    <tr>
                                                        <td colspan="5">{{ __('app.no_record_found') }}</td>
                                                    </tr>
                                                @endif
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
                                            Senarai Diluluskan untuk Pembayaran
                                        </div>
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('subsistenceallowancepayment.generateallocation.storeListName') }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$application->id}}">
                                    <div class="card-body">
                                        <div class="row">
                                            <br />
                                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                                <a href="{{ route('subsistenceallowancepayment.generateallocation.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                <button type="submit" class="btn btn-success btn-sm"  onclick="return confirm($('<span>Lulus Senarai?</span>').text())">
                                                    <i class="fas fa-paper-plane"></i>  {{ __('app.submit') }}
                                                </button>
                                            </div>
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
