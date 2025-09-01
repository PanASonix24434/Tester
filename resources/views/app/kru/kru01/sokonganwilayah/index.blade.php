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
                        <h3 class="mb-0">Senarai Permohonan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)</h3>
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
                                {{--
                                <form method="GET" action="{{ route('kadpendaftarannelayan.semakandaerah.index') }}">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 align-items-center">
                                        <div class="mb-6">
                                            <label for="txtRefNo" class="form-label">No. Rujukan :</label>
                                            <input type="text" id="txtRefNo" name="txtRefNo" value="{{$filterRefNo}}" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                        <br/>
                                        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Cari</button>
                                    </div>
                                </div>
                                </form>
                                --}}
                            </div>
                            <div class="card-body" style="padding: 0%;">
                                <div class="table-responsive">
                                    <table class="table text-nowrap mb-0 table-centered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th><b>Tarikh Permohonan</b></th>
                                                <th><b>No. Rujukan</b></th>
                                                <th><b>Vesel</b></th>
                                                <th><b>Nama Kru</b></th>
                                                <th><b>Pejabat / Kawasan</b></th>
                                                <th><b>Status</b></th>
                                            </tr>
                                        </thead>
                                        @if (!empty($applications) && !$applications->isEmpty())
                                            <tbody>
                                                @foreach ($applications as $a)
                                                <tr>
                                                    <td>{{ $a->submitted_at->format('d/m/Y h:i:s A') }}</td>
                                                    <td>
                                                        <a href="{{ route('kadpendaftarannelayan.sokonganwilayah.show', $a->id) }}">
                                                            {{ $a->reference_number != null ? $a->reference_number : '-Tiada-' }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $a->vessel_id != null ? App\Models\Vessel::withTrashed()->find($a->vessel_id)->vessel_no : '' }}</td>
                                                    <td>{{ App\Models\Kru\KruApplicationKru::where('kru_application_id',$a->id)->pluck('name')->implode(', ') }}</td>
                                                    <td>{{ $a->entity_id != null ? strtoupper(Helper::getEntityNameById($a->entity_id)) : '' }}</td>
                                                    <td>{{ Helper::getCodeMasterNameById($a->kru_application_status_id) }}</td>
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
