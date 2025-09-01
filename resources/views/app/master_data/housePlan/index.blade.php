@extends('layouts.app')
@include('layouts.page_title')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline">
                <div class="card-header">
                    <h3 class="card-title">@yield('page_title')</h3>
                    <div class="card-tools">
                        @if ($can_create)
                            <a href="{{ route('master-data.plans.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i><span class="hidden-xs"> {{ __('app.add') }}</span></a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form method="GET" action="{{ route('master-data.plans.index') }}">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="q" value="{{ $q }}" placeholder="{{ __('app.search') }}..." autocomplete="off">
                                    <span class="input-group-append">
                                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                    </span>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped table-sm">
                                    @if (!$plan->isEmpty())
                                        <thead>
                                            <tr>
                                                <th style="width:1%;"></th>
                                                <th>Nama Pelan Perumahan</th>
                                                <th>File</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($plan as $item)
                                                <tr>
                                                    <td class="text-nowrap">
                                                        <a href="{{ route('master-data.plans.edit', $item->id) }}" class="btn btn-default btn-xs">
                                                            <i class="fas fa-search"></i>
                                                        </a>
                                                        @if ($can_delete)
                                                            <button type="button" class="btn btn-danger btn-xs"
                                                                data-toggle="modal" 
                                                                data-target="#delete-modal" 
                                                                data-href="{{ route('master-data.plans.delete', $item->id) }}" 
                                                                data-text="{{ __('app.data_will_be_deleted', ['type' => __('app.plans'), 'data' => (app()->getLocale() == 'ms' ? $item->parliament_seat_name : $item->parliament_seat_name)]) }}">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->title }}</td>
                                                    <td>
                                                        <a href="{{ route('master-data.plans.downloadPlan', $item->id) }}">{{ $item->filename }}</a>
                                                    </td>
                                                    {{-- <td>{{ $item->file_path }}</td> --}}
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
                                {!! $plan->appends(\Request::except('page'))->render() !!}
                            </div>
                        </div>
                        @if (!$plan->isEmpty())
                            <div class="col-md-4">
                                <span class="float-md-right">
                                    {{ __('app.table_info', [ 'first' => $plan->firstItem(), 'last' => $plan->lastItem(), 'total' => $plan->total() ]) }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection