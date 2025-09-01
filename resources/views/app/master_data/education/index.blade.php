@extends('layouts.app')
@include('layouts.page_title')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline">
                <div class="card-header">
                    <h3 class="card-title">Education Level</h3>
                    <div class="card-tools">
                        <a href="{{route('master-data.education.create')}}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i><span class="hidden-xs"> Add</span></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped table-sm">
                                    @if (!$education->isEmpty())
                                        <thead>
                                            <tr>
                                                <th style="width: 2%"></th>
                                                <th>@sortablelink('name', __('app.name'))</th>
                                                <th style="width:3%;">@sortablelink('status', __('app.status'))</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($education as $item)
                                                <tr> 
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-xs"
                                                        data-toggle="modal" 
                                                        data-target="#delete-modal" 
                                                        data-href="{{ route('master-data.education.delete', $item->id) }}" >
                                                        <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>  
                                                    <td>{{ $item->name }}</td>
                                                    <td>
                                                        @if ($item->is_active)
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
                                {!! $education->appends(\Request::except('page'))->render() !!}
                            </div>
                        </div>
                        @if (!$education->isEmpty())
                            <div class="col-md-4">
                                <span class="float-md-right">
                                    {{ __('app.table_info', [ 'first' => $education->firstItem(), 'last' => $education->lastItem(), 'total' => $education->total() ]) }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection