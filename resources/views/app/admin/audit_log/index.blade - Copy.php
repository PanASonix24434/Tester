@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('template/plugins/daterangepicker/daterangepicker.css') }}">
@endpush

@section('content')
    @include('layouts.alert')
    @include('layouts.callout')
    <!-- Page Content -->
    <div id="app-content">

        <!-- Container fluid -->
        <div class="app-content-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <!-- Page header -->
                    <div class="mb-5">
                        <h3 class="mb-0">Senarai Log Audit</h3>
                    </div>
                </div>
                <div class="col-md-6">
                </div>
            </div>
            <div>
                <!-- row -->
                <div class="row">
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <input id="filterStartDate" type="hidden" value="{{ $filterStartDate }}">
                                <input id="filterEndDate" type="hidden" value="{{ $filterEndDate }}">
                                <!-- Form -->
                                <form method="GET" action="{{ route('administration.audit-logs.index') }}">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 align-items-center">
                                        <div class="mb-6">
                                            <label for="txtStartDate" class="form-label">Tarikh Mula : </label>
                                            <input type="date" id="txtStartDate" name="txtStartDate" value="{{ $filterStartDate }}" class="form-control" />
                                        </div>
                                        <div class="mb-6">
                                            <label for="action" class="form-label">Tindakan : </label>
                                            <input type="text" id="action" name="action" value="{{ $action }}" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 align-items-center">
                                        <div class="mb-6">
                                            <label for="txtEndDate" class="form-label">Tarikh Hingga : </label>
                                            <input type="date" id="txtEndDate" name="txtEndDate" value="{{ $filterEndDate }}" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Cari</button>
                                    </div>
                                </div>
                                </form><br/>
                            </div>
                  <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table text-nowrap mb-0 table-centered table-hover">
                        @if (!$audits->isEmpty())
                            <thead class="table-light">
                                <tr>
                                    <!--<th><b>Nama Penuh</b></th>
                                    <th><b>No. Kad Pengenalan</b></th>
                                    <th><b>Emel</b></th>
                                    <th><b>Peranan</b></th>
                                    <th><b>Pejabat Bertugas</b></th>
                                    <th><b>Status</b></th>-->
                                    <th style="width:25px; min-width:25px;"></th>
                                    <th style="width:25px; min-width:25px;"></th>
                                    <th style="white-space:nowrap;">{{ __('app.source') }}</th>
                                    <th style="white-space:nowrap;">{{ __('app.action') }}</th>
                                    <th style="white-space:nowrap;">{{ __('app.audit_by') }}</th>
                                    <th style="white-space:nowrap;">@sortablelink('created_at', __('app.audit_date'))</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($audits as $audit)
                                <tr>
                                    <td>
                                        <a href="{{ route('administration.audit-logs.show', $audit->id) }}" class="btn btn-default btn-sm audit-view">
                                            <i class="fa fa-search"></i>
                                        </a>
                                    </td>
                                    <td><i class="{{ !empty($audit->exception) ? 'fa fa-exclamation-triangle text-danger' : 'fa fa-check-circle text-primary' }}"></i></td>
                                    <td>{{ Module::localize($audit->source) }}</td>
                                    <td>{{ Helper::localize($audit->action) }}</td>
                                    <td>{!! !empty($audit->created_by) && !empty(App\Models\User::withTrashed()->find($audit->created_by)) ? App\Models\User::withTrashed()->find($audit->created_by)->name : '' !!}</td>
                                    <td>{{ $audit->created_at->format('d/m/Y h:i:s A') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        @else
                            <thead class="table-light">
                                <tr>
                                    <th style="white-space:nowrap;">{{ __('app.source') }}</th>
                                    <th style="white-space:nowrap;">{{ __('app.action') }}</th>
                                    <th style="white-space:nowrap;">{{ __('app.audit_by') }}</th>
                                    <th style="white-space:nowrap;">@sortablelink('created_at', __('app.audit_date'))</th>
                                </tr>
                            </thead>
                            <tbody><tr><td>{{ __('app.no_record_found') }}</td></tr></tbody>
                        @endif
                        </table>
                    </div>
                  </div>
                            <div
                                class="card-footer d-md-flex justify-content-between align-items-center">
                                <div class="col-md-8">
                                    <div class="table-responsive">
                                        {!! $audits->appends(Request::except('page'))->render() !!}
                                    </div>
                                </div>
                                @if (!$audits->isEmpty())
                                    <div class="col-md-4">
                                        <span class="float-md-right">
                                            {{ __('app.table_info', [ 'first' => $audits->firstItem(), 'last' => $audits->lastItem(), 'total' => $audits->total() ]) }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        </div>
    </div>

    <!-- modal -->
    <div id="audit-view" class="modal fade">
        <div class="modal-dialog">
            <div id="audit-content-view" class="modal-content">
                {{-- Content here refer to view_modal.blade.php --}}
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="{{ asset('template/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('template/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var start = moment().subtract(29, 'days');
            var end = moment();
            $('.daterange-picker').daterangepicker({
                startDate: $('#filterStartDate').val() !== '' ? $('#filterStartDate').val() : start,
                endDate: $('#filterEndDate').val() !== '' ? $('#filterEndDate').val() : end,
                ranges: {
                    '{{ __('app.today') }}': [moment(), moment()],
                    '{{ __('app.yesterday') }}': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '{{ __('app.last_7_days') }}': [moment().subtract(6, 'days'), moment()],
                    '{{ __('app.last_30_days') }}': [moment().subtract(29, 'days'), moment()],
                    '{{ __('app.this_month') }}': [moment().startOf('month'), moment().endOf('month')],
                    '{{ __('app.last_month') }}': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                // 'applyClass': 'btn-sm btn-success',
                // 'cancelClass': 'btn-sm btn-default',
                locale: {
                    applyLabel: '{{ __('app.apply') }}',
                    cancelLabel: '{{ __('app.cancel') }}',
                    format: 'DD/MM/YYYY',
                    fromLabel: 'From',
                    toLabel: 'To',
                    customRangeLabel: '{{ __('app.custom') }}',
                    daysOfWeek: [
                        '{{ __('app.su') }}',
                        '{{ __('app.mo') }}',
                        '{{ __('app.tu') }}',
                        '{{ __('app.we') }}',
                        '{{ __('app.th') }}',
                        '{{ __('app.fr') }}',
                        '{{ __('app.sa') }}'
                    ],
                    monthNames: [
                        '{{ __('app.january') }}',
                        '{{ __('app.february') }}',
                        '{{ __('app.march') }}',
                        '{{ __('app.april') }}',
                        '{{ __('app.may') }}',
                        '{{ __('app.june') }}',
                        '{{ __('app.july') }}',
                        '{{ __('app.august') }}',
                        '{{ __('app.september') }}',
                        '{{ __('app.october') }}',
                        '{{ __('app.november') }}',
                        '{{ __('app.december') }}'
                    ],
                }
            });
            $('.audit-view').off('click').on('click', function (e) {
                $('#audit-content-view').load($(this).attr('href'));
                $("#audit-view").modal('show');
                e.preventDefault();
            });
        });
    </script>  
@endpush
