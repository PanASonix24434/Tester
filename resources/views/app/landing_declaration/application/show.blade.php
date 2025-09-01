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
                    <div class="col-md-8">
                        <!-- Page header -->
                        <div class="mb-8">
                            <h3 class="mb-0">Pengisytiharan Pendaratan Perikanan Darat</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h4 class="mb-0" style="color:white;">Permohonan</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Pemohon</label>
                                            <input type="text" class="form-control" value="{{ $app->name }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>No. Kad Pengenalan</label>
                                            <input type="text" class="form-control" value="{{ $app->username }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Pejabat Permohonan</label>
                                            <input type="text" class="form-control" value="{{ $app->entity_id != null ? strtoupper(Helper::getEntityNameById($app->entity_id)) : '' }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <input type="text" class="form-control" value="{{ $app->landing_status_id != null ? Helper::getCodeMasterNameById($app->landing_status_id) : '' }}" disabled>
                                        </div>
                                    </div>
                                    @if ($app->landing_status_id == $statusTidakLengkapId)
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label style="color: red;">Sebab Tidak Lengkap</label>
                                                <textarea class="form-control" rows="4" style="background-color: whitesmoke; color: red;" disabled>{{ $incompleteLog->remark }}</textarea>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <br/>
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="content-a-tab" data-bs-toggle="tab" href="#content-a" role="tab"
                                        aria-controls="content-a" aria-selected="true">Maklumat Permohonan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="content-d-tab" data-bs-toggle="tab" href="#content-d" role="tab"
                                        aria-controls="content-d" aria-selected="false">Maklumat Dokumen</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="content-f-tab" data-bs-toggle="tab" href="#content-f" role="tab"
                                        aria-controls="content-f" aria-selected="false">Perakuan</a>
                                    </li>
                                </ul>
                                <div class="tab-content p-4" id="tabContent">
                                    <div class="tab-pane fade show active" id="content-a" role="tabpanel" aria-labelledby="content-a-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">Bulan :</label>
                                                    <input type="text" class="form-control" value="{{ Carbon\Carbon::create($app->year, $app->month, 1)->isoFormat('MMMM') }} {{ $app->year }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 table-responsive">
                                                <div class="form-group">
                                                    <label class="col-form-label">Senarai Minggu:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12 table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Minggu</th>
                                                            <th style="width:1%;"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="listDoc">
                                                        @if (!$weeks->isEmpty())
                                                            @php
                                                                $count = 0;
                                                            @endphp
                                                            @foreach ($weeks as $week)
                                                                <tr>
                                                                    <td>{{$week->week}} ({{$week->startDay}} - {{$week->endDay}}hb)</td>
                                                                    {{--
                                                                    <td>
                                                                        @if ($week->landing_status_id != null)
                                                                            {{ Helper::getCodeMasterNameById($week->landing_status_id) }}
                                                                        @else
                                                                            <span style="color: red;">--Belum lengkap diisi--</span>
                                                                        @endif
                                                                    </td>
                                                                    --}}
                                                                    <td>
                                                                        <a href="{{ route('landingdeclaration.application.showWeek', $week->id) }}" class="btn btn-sm btn-primary" title="Lihat">
                                                                            <i class="fas fa-search"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="3" style="text-align: center;">-Tiada Dokumen Tambahan-</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row">
                                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                                <a href="{{ route('landingdeclaration.application.index') }}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                @if ($app->landing_status_id == $statusTidakLengkapId)
                                                    <a href="{{ route('landingdeclaration.application.edit',$app->id) }}" class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i> Kemaskini</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="content-d" role="tabpanel" aria-labelledby="content-d-tab">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-form-label">Senarai Dokumen:</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:1%;">Bil</th>
                                                            <th>Tarikh Dicipta</th>
                                                            <th>Dokumen</th>
                                                            <th>Tindakan Oleh</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="listDoc">
                                                        @if (!$docs->isEmpty())
                                                            @php
                                                                $count = 0;
                                                            @endphp
                                                            @foreach ($docs as $doc)
                                                                <tr>
                                                                    <td>{{++$count}}</td>
                                                                    <td>{{$doc->created_at->format('d/m/Y h:i:s A')}}</td>
                                                                    <td><a href="{{ route('landinghelper.previewDoc', $doc->id) }}" target="_blank">{{$doc->description}}</a></td>
                                                                    <td>{{strtoupper(Helper::getUsersNameById($doc->created_by))}}</td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="4" style="text-align: center;">-Tiada Dokumen-</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row">
                                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                                <a href="{{ route('landingdeclaration.application.index') }}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                @if ($app->landing_status_id == $statusTidakLengkapId)
                                                    <a href="{{ route('landingdeclaration.application.edit',$app->id) }}" class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i> Kemaskini</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="content-f" role="tabpanel" aria-labelledby="content-f-tab">
                                        <div class="row">
                                            <div class="col-12 text-center">
                                                <div class="form-group mb-0">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="terms" class="custom-control-input" id="terms" checked disabled>
                                                        <label class="custom-control-label" for="terms">Saya dengan ini mengakui dan mengesahkan bahawa semua maklumat yang diberikan oleh saya adalah benar. Sekiranya terdapat maklumat yang tidak benar, pihak Jabatan boleh menolak permohonan saya dan tindakan undang-undang boleh dikenakan ke atas saya.</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row">
                                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                                <a href="{{ route('landingdeclaration.application.index') }}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                @if ($app->landing_status_id == $statusTidakLengkapId)
                                                    <a href="{{ route('landingdeclaration.application.edit',$app->id) }}" class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i> Kemaskini</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
