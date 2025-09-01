@extends('layouts.app')
@include('layouts.page_title')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline">
                <div class="card-header">
                    <h3 class="card-title">List of Dealer</h3>
                    <div class="card-tools">
                        <a href="{{route('master-data.dealer.create')}}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i><span class="hidden-xs"> Add</span></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped table-sm">
                                    @if (!$dealer_list->isEmpty())
                                        <thead>
                                            <tr>
                                                <th>Dealer Code</th>
                                                <th>Dealer Name</th>
                                                <th>Contact Person</th>
                                                <th>Email</th>
                                                <th>Phone No.</th>
                                                <th>Fax No.</th>
                                                <th>State</th>
                                                <th style="width:3%;">@sortablelink('status', __('app.status'))</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dealer_list as $item)
                                                <tr>
                                                    <td>{{ $item->dealer_code }}</td>   
                                                    <td>{{ $item->dealer_name }}</td>
                                                    <td>{{ $item->dealer_contact_person }}</td>
                                                    <td>{{ $item->dealer_email }}</td>
                                                    <td>{{ $item->dealer_phone_no }}</td>
                                                    <td>{{ $item->dealer_fax_no }}</td>
                                                    <td>{{ (App::getLocale() == 'en') ? strtoupper(Helper::getCodeMasterNameEnById($item->dealer_state_id)) : strtoupper(Helper::getCodeMasterNameMsById($item->dealer_state_id)) }}</td>
                                                    <td>
                                                        @if ($item->dealer_status == 1)
                                                            <span class="badge badge-pill badge-info">{{ __('app.active') }}</span>
                                                        @else
                                                            <span class="badge badge-pill badge-secondary">{{ __('app.inactive') }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    @else
                                        <tbody><tr><td>{{ __('app.no_record_found') }}</td></tr></tbody>
                                    @endif
                                </table>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="table-responsive">
                                {!! $dealer_list->appends(\Request::except('page'))->render() !!}
                            </div>
                        </div>
                        @if (!$dealer_list->isEmpty())
                            <div class="col-md-4">
                                <span class="float-md-right">
                                    {{ __('app.table_info', [ 'first' => $dealer_list->firstItem(), 'last' => $dealer_list->lastItem(), 'total' => $dealer_list->total() ]) }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection