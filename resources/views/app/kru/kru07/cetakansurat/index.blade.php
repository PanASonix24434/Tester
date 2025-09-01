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
                <div class="col-md-6">
                    <!-- Page header -->
                    <div class="mb-5">
                        <h3 class="mb-0">Permohonan Pembaharuan Penggunaan Kru Bukan Warganegara Untuk Bekerja Di Atas Vesel Penangkapan Ikan Tempatan</h3>
                    </div>
                </div>
            </div>
            <div>
                <!-- row -->
                <div class="row">
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <div class="card-header">
                            </div>
                            <div class="card-body" style="padding: 0%;">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-centered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th><b>Tarikh Permohonan</b></th>
                                                <th><b>No. Rujukan</b></th>
                                                <th><b>Nama Syarikat</b></th>
                                                <th><b>Vesel</b></th>
                                                <th><b>Pejabat Perikanan Daerah</b></th>
                                                <th><b>Status</b></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        @if (!empty($applications) && !$applications->isEmpty())
                                            <tbody>
                                                @foreach ($applications as $a)
                                                <tr>
                                                    <td>{{ $a->submitted_at->format('d/m/Y h:i:s A') }}</td>
                                                    <td>{{ $a->reference_number != null ? $a->reference_number : '-Tiada-' }}</td>
                                                    <td>{{ $a->name }}</td>
                                                    <td>{{ $a->vessel_id != null ? App\Models\Vessel::withTrashed()->find($a->vessel_id)->no_pendaftaran : '' }}</td>
                                                    <td>{{ $a->entity_id != null ? strtoupper(Helper::getEntityNameById($a->entity_id)) : '' }}</td>
                                                    <td>{{ Helper::getCodeMasterNameById($a->kru_application_status_id) }}</td>
                                                    <td>
                                                        <a class="btn btn-sm btn-primary" href="{{ route('pembaharuanpenggunaankrubukanwarganegara.cetakansurat.show', $a->id) }}">
                                                            <i class="fas fa-search"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        @else
                                            <tbody>
                                                <tr>
                                                    <td colspan="8">{{ __('app.no_record_found') }}</td>
                                                </tr>
                                            </tbody>
                                        @endif
                                    </table>
                                </div>
                            </div>
                            @if (!empty($applications) && !$applications->isEmpty())
                            <div
                                class="card-footer d-md-flex justify-content-between align-items-center">
                                <div class="col-md-8">
                                    <div class="table-responsive">
                                        {!! $applications->appends(Request::except('page'))->render() !!}
                                    </div>
                                </div>
                                @if (!$applications->isEmpty())
                                    <div class="col-md-4">
                                        <span class="float-md-right">
                                            {{ __('app.table_info', [ 'first' => $applications->firstItem(), 'last' => $applications->lastItem(), 'total' => $applications->total() ]) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            @endif

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

        $(document).on('input', "input[type=text]", function () {
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
        });
        
        var msg = '{{Session::get('alert')}}';
        var exist = '{{Session::has('alert')}}';
        if(exist){
            alert(msg);
        }

</script>
@endpush
