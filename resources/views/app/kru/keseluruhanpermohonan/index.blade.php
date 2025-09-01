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
                            <h3 class="mb-0">Keseluruhan Permohonan Kru</h3>
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
                                    <form method="GET" action="{{ route('keseluruhanpermohonankru.index') }}">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 align-items-center">
                                                <div class="mb-6">
                                                    <label for="txtRefNo" class="form-label">No. Rujukan :</label>
                                                    <input type="text" id="txtRefNo" name="txtRefNo" value="{{$filterRefNo}}" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 align-items-center">
                                            </div>
                                            <div class="col-lg-6 col-md-6 align-items-center">
                                                <div class="mb-6">
                                                    <label for="selAppType" class="form-label">Jenis Permohonan :</label>
                                                    <select class="form-control select2" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" id="selAppType" name="selAppType" autocomplete="off">
                                                        <option value="">{{ __('app.show_all')}}</option>
                                                        @if (!is_null($filterAppType))
                                                            @foreach($applicationTypes as $at)
                                                                <option value="{{$at->id}}" {{ $at->id == $filterAppType ? 'selected' : '' }}>{{ $at->code }}  - {{ $at->name }}</option>
                                                            @endforeach
                                                        @else
                                                            @foreach($applicationTypes as $at)
                                                                <option value="{{$at->id}}">{{ $at->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 align-items-center">
                                                <div class="mb-6">
                                                    <label for="selAppStatus" class="form-label">Status Permohonan :</label>
                                                    <select class="form-control select2" style="width: 100%;" data-select2-id="2" tabindex="-1" aria-hidden="true" id="selAppStatus" name="selAppStatus" autocomplete="off">
                                                        <option value="">{{ __('app.show_all')}}</option>
                                                        @if (!is_null($filterAppStatus))
                                                            @foreach($applicationStatus as $as)
                                                                <option value="{{$as->id}}" {{ $as->id == $filterAppStatus ? 'selected' : '' }}>{{ strtoupper($as->name_ms) }}</option>
                                                            @endforeach
                                                        @else
                                                            @foreach($applicationStatus as $as)
                                                                <option value="{{$as->id}}">{{ strtoupper($as->name_ms) }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="col-lg-6 col-md-6 align-items-center">
                                                <div class="mb-6">
                                                    <label for="txtRefNo" class="form-label">Pejabat Permohonan (Negeri) :</label>
                                                    <select class="form-control select2" style="width: 100%;" data-select2-id="3" tabindex="-1" aria-hidden="true" id="selAppStateEntity" name="selAppStateEntity" autocomplete="off" {{ $entityLevel != '1' ? 'disabled' : '' }}>
                                                        <option value="">{{ __('app.show_all')}}</option>
                                                        @if (!is_null($filterAppStateEntity))
                                                            @foreach($applicationStateEntities as $ase)
                                                                <option value="{{$ase->id}}" {{ $ase->id == $filterAppStateEntity ? 'selected' : '' }}>{{ strtoupper($ase->entity_name) }}</option>
                                                            @endforeach
                                                        @else
                                                            @foreach($applicationStateEntities as $ase)
                                                                <option value="{{$ase->id}}">{{ strtoupper($ase->entity_name) }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 align-items-center">
                                                <div class="mb-6">
                                                    <label for="txtRefNo" class="form-label">Pejabat Permohonan (Daerah) :</label>
                                                    <select class="form-control select2" style="width: 100%;" data-select2-id="4" tabindex="-1" aria-hidden="true" id="selAppDistrictEntity" name="selAppDistrictEntity" autocomplete="off" {{ ($entityLevel != '1' && $entityLevel != '2' && $entityLevel != '3') ? 'disabled' : '' }}>
                                                        <option value="">{{ __('app.show_all')}}</option>
                                                        @if (!is_null($filterAppDistrictEntity))
                                                            @foreach($applicationDistrictEntities as $ade)
                                                                <option value="{{$ade->id}}" {{ $ade->id == $filterAppDistrictEntity ? 'selected' : '' }}>{{ strtoupper($ade->entity_name) }}</option>
                                                            @endforeach
                                                        @else
                                                            @foreach($applicationDistrictEntities as $ade)
                                                                <option value="{{$ade->id}}">{{ strtoupper($ade->entity_name) }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                                <br/>
                                                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Cari</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-body" style="padding: 0%;">
                                    <div class="table-responsive">
                                        <table class="table text-nowrap mb-0 table-centered table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th><b>Tarikh Permohonan</b></th>
                                                    <th><b>No. Rujukan</b></th>
                                                    <th><b>Pemohon</b></th>
                                                    <th><b>Jenis Permohonan</b></th>
                                                    <th><b>Vesel</b></th>
                                                    <!-- <th><b>Nama Kru</b></th> -->
                                                    <th><b>Pejabat Perikanan Daerah</b></th>
                                                    <th><b>Status</b></th>
                                                </tr>
                                            </thead>
                                            @if (!empty($applications) && !$applications->isEmpty())
                                                <tbody>
                                                    @foreach ($applications as $a)
                                                    <tr>
                                                        @if ($a->submitted_at != null)
                                                            @php
                                                                $days = Carbon\Carbon::now()->diff(Carbon\Carbon::parse($a->submitted_at))->days;
                                                            @endphp
                                                            @if ( $processStatusIds->contains('id',$a->kru_application_status_id) )
                                                                @if ($days >= 15)
                                                                    <td style="color: orangered;">
                                                                        {{  $a->submitted_at->format('d/m/Y') }} ({{ $days }} hari)
                                                                    </td>
                                                                @elseif ($days >= 8)
                                                                    <td style="color: orange;">
                                                                        {{  $a->submitted_at->format('d/m/Y') }} ({{ $days }} hari)
                                                                    </td>
                                                                @else
                                                                    <td style="color: green;">
                                                                        {{  $a->submitted_at->format('d/m/Y') }} ({{ $days }} hari)
                                                                    </td>
                                                                @endif
                                                            @elseif ( $finishedStatusIds->contains('id',$a->kru_application_status_id) )
                                                                <td>
                                                                    {{  $a->submitted_at->format('d/m/Y') }}
                                                                </td>
                                                            @else
                                                                <td>
                                                                    {{  $a->submitted_at->format('d/m/Y') }} ({{ $days }} hari)
                                                                </td>
                                                            @endif
                                                        @else
                                                            <td></td>
                                                        @endif
                                                        <td>
                                                            @if ( $a->kru_application_type_id == $kru01Id )
                                                                <a href="{{ route('keseluruhanpermohonankru.showKru01', $a->id) }}">
                                                                    {{ $a->reference_number != null ? $a->reference_number : '-Tiada-' }}
                                                                </a>
                                                            @elseif ( $a->kru_application_type_id == $kru02Id )
                                                                <a href="{{ route('keseluruhanpermohonankru.showKru02', $a->id) }}">
                                                                    {{ $a->reference_number != null ? $a->reference_number : '-Tiada-' }}
                                                                </a>
                                                            @elseif ( $a->kru_application_type_id == $kru03Id )
                                                                <a href="{{ route('keseluruhanpermohonankru.showKru03', $a->id) }}">
                                                                    {{ $a->reference_number != null ? $a->reference_number : '-Tiada-' }}
                                                                </a>
                                                            @elseif ( $a->kru_application_type_id == $kru04Id )
                                                                <a href="{{ route('keseluruhanpermohonankru.showKru04', $a->id) }}">
                                                                    {{ $a->reference_number != null ? $a->reference_number : '-Tiada-' }}
                                                                </a>
                                                            @elseif ( $a->kru_application_type_id == $kru05Id )
                                                                <a href="{{ route('keseluruhanpermohonankru.showKru05', $a->id) }}">
                                                                    {{ $a->reference_number != null ? $a->reference_number : '-Tiada-' }}
                                                                </a>
                                                            @elseif ( $a->kru_application_type_id == $kru06Id )
                                                                <a href="{{ route('keseluruhanpermohonankru.showKru06', $a->id) }}">
                                                                    {{ $a->reference_number != null ? $a->reference_number : '-Tiada-' }}
                                                                </a>
                                                            @elseif ( $a->kru_application_type_id == $kru07Id )
                                                                <a href="{{ route('keseluruhanpermohonankru.showKru07', $a->id) }}">
                                                                    {{ $a->reference_number != null ? $a->reference_number : '-Tiada-' }}
                                                                </a>
                                                            @elseif ( $a->kru_application_type_id == $kru08Id )
                                                                <a href="{{ route('keseluruhanpermohonankru.showKru08', $a->id) }}">
                                                                    {{ $a->reference_number != null ? $a->reference_number : '-Tiada-' }}
                                                                </a>
                                                            @endif
                                                        </td>
                                                        <td>{{ $a->name }}</td>
                                                        <td>{{ App\Models\Kru\KruApplicationType::withTrashed()->find($a->kru_application_type_id)->code }}</td>
                                                        <td>{{ $a->vessel_id != null ? App\Models\Vessel::withTrashed()->find($a->vessel_id)->no_pendaftaran : '' }}</td>
                                                        <!-- <td>{{ App\Models\Kru\KruApplicationKru::where('kru_application_id',$a->id)->pluck('name')->implode(', ') }}</td> -->
                                                        <td>{{ $a->entity_id != null ? strtoupper(Helper::getEntityNameById($a->entity_id)) : '' }}</td>
                                                        <td>{{ Helper::getCodeMasterNameById($a->kru_application_status_id) }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            @else
                                                <tbody>
                                                    <tr>
                                                        <td colspan="7">{{ __('app.no_record_found') }}</td>
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
