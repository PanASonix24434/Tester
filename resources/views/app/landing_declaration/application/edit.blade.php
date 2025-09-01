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
                <ul class="nav nav-tabs" id="custom-content-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-content-a-tab" data-toggle="pill" href="#custom-content-a" role="tab" aria-controls="custom-content-a" aria-selected="true">Maklumat Pendaratan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" id="custom-content-e-tab" href="#" role="tab" aria-controls="custom-content-e" aria-selected="false">Maklumat Dokumen</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link disabled" id="custom-content-b-tab" href="#" role="tab" aria-controls="custom-content-b" aria-selected="false">Ringkasan Maklumat</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link disabled" id="custom-content-f-tab" href="#" role="tab" aria-controls="custom-content-f" aria-selected="false">Perakuan</a>
                    </li>
                </ul>
                <br />
                <div>
                    <!-- row -->
                    <div class="row">
                        <div class="col-12">
                            <!-- card -->
                            <div class="card mb-4">
                                <div class="card-header bg-primary">
                                    <h4 class="mb-0" style="color:white;">Maklumat Pendaratan</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!-- Nama Pemohon -->
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Pemohon :</label>
                                                <input type="text" class="form-control" id="AppName"  name="fullname" value="{{ $app->name }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <!-- No Kad Pengenalan -->
                                            <div class="form-group">
                                                <label class="col-form-label">No Kad Pengenalan :</label>
                                                <input type="text" class="form-control" id="AppIC" name="icno" value="{{ $app->username }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Bulan :</label>
                                                <input type="text" class="form-control" value="{{ Carbon\Carbon::create($app->year, $app->month, 1)->isoFormat('MMMM') }} {{ $app->year }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 table-responsive">
                                            <div class="form-group">
                                                <label class="col-form-label">Senarai Minggu:</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Minggu</th>
                                                        <th>Status</th>
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
                                                                <td>
                                                                    @if ($week->landing_status_id != null)
                                                                        {{ Helper::getCodeMasterNameById($week->landing_status_id) }}
                                                                    @else
                                                                        <span style="color: red;">--Belum lengkap diisi--</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('landingdeclaration.application.editWeek', $week->id) }}" class="btn btn-sm btn-warning" title="Kemaskini">
                                                                        <i class="fas fa-edit"></i>
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
                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                            <a href="{{ route('landingdeclaration.application.index') }}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                            <a href="{{ route('landingdeclaration.application.editD',$app->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-arrow-right"></i> Seterusnya</a>
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
