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
                            <h3 class="mb-0">Kru</h3>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-5 text-right">
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
                                    <form method="GET" action="{{ route('crewvessel.index') }}">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 align-items-center">
                                                <div class="mb-6">
                                                    <label for="selVessel" class="form-label">Vesel :</label>
                                                    <select class="form-control select2" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" id="selVessel" name="selVessel" autocomplete="off">
                                                        <option value="">{{ __('app.show_all')}}</option>
                                                        @if (!$vessels->isEmpty())
                                                            @foreach($vessels as $v)
                                                                <option value="{{$v->id}}" {{ $v->id == $filterVessel ? 'selected' : '' }}>{{ $v->no_pendaftaran }} | Tempatan/Pemastautin:{{$v->totalLocalKru()}}, Asing:{{$v->totalForeignKru()}}, Jumlah:{{$v->totalKru()}}, Maksimum:{{$v->maximumKru()}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                                <br/>
                                                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Cari</button>
                                                <a href="{{ route('crewvessel.exportApprovalLetter',$userId) }}" target="_blank" class="btn btn-warning btn-sm"><i class="fas fa-print"></i> Surat Kelulusan Penggunaan Kru Bukan Warganegara</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-body" style="padding: 0%;">
                                    <div class="table-responsive">
                                        <table class="table text-nowrap mb-0 table-centered table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th><b>No Kad Pengenalan / Pasport</b></th>
                                                    <th><b>Nama</b></th>
                                                    <th><b>Vesel</b></th>
                                                    <th><b>Jenis Kru</b></th>
                                                </tr>
                                            </thead>
                                            @if (!empty($crews) && !$crews->isEmpty())
                                                <tbody>
                                                    @foreach ($crews as $c)
                                                    <tr>
                                                        <!-- <td>{{ $c->identity_no }}</td> -->
                                                        <td>
                                                            {{-- @if ( $a->kru_application_type_id == $kru01Id ) --}}
                                                                <a href="{{ route('crewvessel.show', ['type' => $c->crew_type, 'id' => $c->id]) }}">
                                                                    {{ $c->identity_no }}
                                                                </a>
                                                            {{-- @elseif ( $a->kru_application_type_id == $kru02Id )
                                                                <a href="{{ route('keseluruhanpermohonankru.showKru02', $a->id) }}">
                                                                    {{ $a->reference_number != null ? $a->reference_number : '-Tiada-' }}
                                                                </a>
                                                            @endif --}}
                                                        </td>
                                                        <td>{{ $c->name }}</td>
                                                        <td>{{ $c->vessel_id != null ? App\Models\Vessel::withTrashed()->find($c->vessel_id)->no_pendaftaran : '' }}</td>
                                                        <td>{{ $c->crew_type }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            @else
                                                <tbody>
                                                    <tr>
                                                        <td colspan="4">{{ __('app.no_record_found') }}</td>
                                                    </tr>
                                                </tbody>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                                @if (!empty($crews) && !$crews->isEmpty())
                                    <div
                                        class="card-footer d-md-flex justify-content-between align-items-center">
                                        <div class="col-md-8">
                                            <div class="table-responsive">
                                                {!! $crews->appends(Request::except('page'))->render() !!}
                                            </div>
                                        </div>
                                        @if (!$crews->isEmpty())
                                            <div class="col-md-4">
                                                <span class="float-md-right">
                                                    {{ __('app.table_info', [ 'first' => $crews->firstItem(), 'last' => $crews->lastItem(), 'total' => $crews->total() ]) }}
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
