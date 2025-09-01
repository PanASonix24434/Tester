@extends('layouts.app')
@include('layouts.page_title')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline">
                <div class="card-header">
                    <h3 class="card-title">@yield('page_title')</h3>
                    <div class="card-tools">
                        <a href="{{ route('master-data.rates.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i><span class="hidden-xs"> {{ __('app.add') }}</span></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form method="GET" action="{{ route('master-data.rates.index') }}">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="q" value="{{ $q }}" placeholder="{{ __('app.search') }}..." autocomplete="off">
                                    <span class="input-group-append">
                                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                    </span>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped table-sm">
                                    @if (!$rates->isEmpty())
                                        <thead>
                                            <tr>
                                                <th style="width:1%;"></th>
                                                <th>Bayaran Perkhidmatan (%)</th>
                                                <th>Tarikh Mula</th>
                                                <th>Tarikh Hingga</th>
                                                <th>Status</th>
                                                <th>Dimasukkan Oleh</th>
                                                <th>Tarikh Dimasukkan</th>
                                                <th>Dikemaskini Oleh</th>
                                                <th>Tarikh Dikemaskini</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rates as $item)
                                                <tr>
                                                    <td class="text-nowrap">
                                                        <a href="{{ route('master-data.rates.edit', $item->id) }}" class="btn btn-default btn-xs">
                                                            <i class="fas fa-search"></i>
                                                        </a>
                                                        <!--<button type="button" class="btn btn-danger btn-xs"
                                                                data-toggle="modal" 
                                                                data-target="#delete-modal" 
                                                                data-href="{{ route('master-data.rates.delete', $item->id) }}" 
                                                                data-text="{{ __('app.data_will_be_deleted', ['type' => 'Bayaran Perkhidmatan', 'data' => (app()->getLocale() == 'ms' ? $item->interest_rate_value : $item->interest_rate_value)]) }}">
                                                                <i class="fas fa-trash"></i>
                                                        </button>-->
                                                    </td>
                                                    <td>{{ $item->interest_rate_value }}</td>
                                                    <td>{{ Helper::convertDateToFormat($item->start_date) }}</td>
                                                    @if ($item->end_date == null || $item->end_date == "")
                                                        <td>{{ $item->end_date }}</td>
                                                    @else
                                                        <td>{{ Helper::convertDateToFormat($item->end_date) }}</td>
                                                    @endif
                                                    @if ($item->is_active == true || $item->is_active == '1')
                                                        <td><b>AKTIF</b></td>
                                                    @else
                                                        <td>TIDAK AKTIF</td> 
                                                    @endif
                                                    <td>{{ strtoupper(Helper::getUsersNameById($item->created_by)) }}</td>
                                                    <td>{{ $item->created_at->format('d/m/Y H:i:s') }}</td>
                                                    <td>{{ strtoupper(Helper::getUsersNameById($item->updated_by)) }}</td>
                                                    <td>{{ $item->updated_at->format('d/m/Y H:i:s') }}</td>
                                                    
                                                    
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    @else
                                        <thead>
                                            <tr>
                                                <th>Bayaran Perkhidmatan (%)</th>
                                                <th>Tarikh Mula</th>
                                                <th>Tarikh Hingga</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="text-center">
                                                <td colspan="4">{{ __('app.no_record_found') }}</td>
                                            </tr>
                                        </tbody>
                                    @endif
                                </table>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="table-responsive">
                                {!! $rates->appends(\Request::except('page'))->render() !!}
                            </div>
                        </div>
                        @if (!$rates->isEmpty())
                            <div class="col-md-4">
                                <span class="float-md-right">
                                    {{ __('app.table_info', [ 'first' => $rates->firstItem(), 'last' => $rates->lastItem(), 'total' => $rates->total() ]) }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection