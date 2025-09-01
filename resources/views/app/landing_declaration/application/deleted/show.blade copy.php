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
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="content-a-tab" data-bs-toggle="tab" href="#content-a" role="tab"
                        aria-controls="content-a" aria-selected="true">Maklumat Nelayan Darat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="content-b-tab" data-bs-toggle="tab" href="#content-b" role="tab"
                        aria-controls="content-b" aria-selected="false">Waktu Pendaratan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="content-c-tab" data-bs-toggle="tab" href="#content-c" role="tab"
                        aria-controls="content-c" aria-selected="false">Maklumat Kawasan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="content-d-tab" data-bs-toggle="tab" href="#content-d" role="tab"
                        aria-controls="content-d" aria-selected="false">Maklumat Pendaratan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="content-e-tab" data-bs-toggle="tab" href="#content-e" role="tab"
                        aria-controls="content-e" aria-selected="false">Maklumat Dokumen</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="content-f-tab" data-bs-toggle="tab" href="#content-f" role="tab"
                        aria-controls="content-f" aria-selected="false">Perakuan</a>
                    </li>
                </ul>
                <div class="tab-content p-4" id="tabContent">
                    <div class="tab-pane fade show active" id="content-a" role="tabpanel" aria-labelledby="content-a-tab">
                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-header bg-primary">
                                        <h4 class="mb-0" style="color:white;">A. Butiran Pemohon </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">Minggu :</label>
                                                    <input type="text" class="form-control" value="{{ Carbon\Carbon::create($app->year, $app->month, 1)->isoFormat('MMMM') }} {{ $app->year }} ({{$app->startDay}} - {{$app->endDay}})" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">Nama Pemohon :</label>
                                                    <input type="text" class="form-control" id="AppName"  name="fullname" value="{{ $app->name }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">No Kad Pengenalan :</label>
                                                    <input type="text" class="form-control" id="AppIC" name="icno" value="{{ $app->username }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="col-form-label">Alamat :</label>
                                                    <input type="text" class="form-control" id="AppAddress1" value="Auto" readonly>
                                                    <input type="text" class="form-control" id="AppAddress2" value="Auto" readonly>
                                                    <input type="text" class="form-control" id="AppAddress3" value="Auto" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row">
                                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                                <a href="{{ route('landingdeclaration.application.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="content-b" role="tabpanel" aria-labelledby="content-b-tab">
                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-header bg-primary">
                                        <h4 class="mb-0" style="color:white;">B. Waktu Pendaratan </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm">
                                                <table class="table table-bordered" style="text-align: center">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 20%">Hari</th>
                                                            <th>Aktiviti</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ( $landingInfos as $li )
                                                            <tr>
                                                                <td>
                                                                    <div>
                                                                        <b>{{ Carbon\Carbon::parse($li->landing_date)->locale('ms')->isoFormat('dddd') }}</b>
                                                                    </div>
                                                                    <div>
                                                                        {{ optional($li->landing_date)->format('d-m-Y') }}
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    @php
                                                                        $landingActivities =  App\Models\LandingDeclaration\LandingInfoActivity::where('landing_info_id',$li->id)->get();
                                                                    @endphp
                                                                    @if (!$landingActivities->isEmpty())
                                                                        @foreach ( $landingActivities as $la )
                                                                            <div>
                                                                                {{ $la->landing_activity_type_id != null ? App\Models\LandingDeclaration\LandingActivityType::find($la->landing_activity_type_id)->name  : '' }}
                                                                            </div>
                                                                        @endforeach
                                                                        <!-- <div>
                                                                            <a href="{{-- route('kruhelper.deleteReceipt', $receipt->id) --}}" class="btn btn-danger btn-sm" onclick="return confirm($('<span>Hapus Maklumat Aktiviti?</span>').text())">
                                                                                <i class="fas fa-trash"></i>
                                                                            </button>
                                                                        </div> -->
                                                                    @else
                                                                        - Tiada Aktiviti -
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row">
                                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                                <a href="{{ route('landingdeclaration.application.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="content-c" role="tabpanel" aria-labelledby="content-c-tab">
                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-header bg-primary">
                                        <h4 class="mb-0" style="color:white;">C. Maklumat Kawasan Penangkapan Ikan </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm table-responsive">
                                                <table class="table table-bordered" style="text-align: center">
                                                    <thead>
                                                        <tr>
                                                            <th>Hari</th>
                                                            <th>Aktiviti</th>
                                                            <th>Masa</th>
                                                            <th>Negeri</th>
                                                            <th>Daerah</th>
                                                            <th>Jenis Perairan</th>
                                                            <th>Nama Tempat (Kg./Kawasan)</th>
                                                            <th>Peralatan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ( $landingInfos as $li )
                                                            @php
                                                                $landingActivities = App\Models\LandingDeclaration\LandingInfoActivity::where('landing_info_id',$li->id)->orderBy('time')->get();
                                                                $row = $landingActivities->count();
                                                            @endphp
                                                            <tr>
                                                                <td rowspan="{{ $row > 0 ? $row : 1 }}">
                                                                    <div>
                                                                        <b>{{ Carbon\Carbon::parse($li->landing_date)->locale('ms')->isoFormat('dddd') }}</b>
                                                                    </div>
                                                                    <div>
                                                                        {{ optional($li->landing_date)->format('d-m-Y') }}
                                                                    </div>
                                                                </td>
                                                                @if ($row > 0)
                                                                    <td>{{$landingActivities[0]->landing_activity_type_id != null ? App\Models\LandingDeclaration\LandingActivityType::find($landingActivities[0]->landing_activity_type_id)->name  : '' }}</td>
                                                                    <td>{{$landingActivities[0]->time}}</td>
                                                                    <td>{{$landingActivities[0]->state_id != null ? Helper::getCodeMasterNameById($landingActivities[0]->state_id)  : ''}}</td>
                                                                    <td>{{$landingActivities[0]->district_id != null ? Helper::getCodeMasterNameById($landingActivities[0]->district_id)  : ''}}</td>
                                                                    <td>{{$landingActivities[0]->landing_water_type_id ? App\Models\LandingDeclaration\LandingWaterType::find($landingActivities[0]->landing_water_type_id)->name  : '' }} </td>
                                                                    <td>{{$landingActivities[0]->location_name}}</td>
                                                                    <td>{{$landingActivities[0]->equipment}}</td>
                                                                @else
                                                                    <td colspan="7">-Tiada Aktiviti-</td>
                                                                @endif
                                                            </tr>
                                                            @if ($row>0)
                                                                @for ( $i=1;$i<$row;$i++)
                                                                    <tr>
                                                                        <td>{{$landingActivities[$i]->landing_activity_type_id != null ? App\Models\LandingDeclaration\LandingActivityType::find($landingActivities[$i]->landing_activity_type_id)->name  : '' }}</td>
                                                                        <td>{{$landingActivities[$i]->time}}</td>
                                                                        <td>{{$landingActivities[$i]->state_id != null ? Helper::getCodeMasterNameById($landingActivities[$i]->state_id)  : ''}}</td>
                                                                        <td>{{$landingActivities[$i]->district_id != null ? Helper::getCodeMasterNameById($landingActivities[$i]->district_id)  : ''}}</td>
                                                                        <td>{{$landingActivities[$i]->landing_water_type_id ? App\Models\LandingDeclaration\LandingWaterType::find($landingActivities[$i]->landing_water_type_id)->name  : '' }} </td>
                                                                        <td>{{$landingActivities[$i]->location_name}}</td>
                                                                        <td>{{$landingActivities[$i]->equipment}}</td>
                                                                    </tr>
                                                                @endfor
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row">
                                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                                <a href="{{ route('landingdeclaration.application.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="content-d" role="tabpanel" aria-labelledby="content-d-tab">
                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-header bg-primary">
                                        <h4 class="mb-0" style="color:white;">D. Maklumat Pendaratan </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm table-responsive">
                                                <table class="table table-bordered" style="text-align: center">
                                                    <thead>
                                                        <tr>
                                                            <th>Hari</th>
                                                            <th>Aktiviti</th>
                                                            <th>Nama Spesies Ikan</th>
                                                            <th>Berat (KG)</th>
                                                            <th>Harga (RM/KG)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ( $landingInfos as $li )
                                                            @php
                                                                $landingActivities = App\Models\LandingDeclaration\LandingInfoActivity::where('landing_info_id',$li->id)->orderBy('time')->get();
                                                                $row = $landingActivities->count();
                                                            @endphp
                                                            <tr>
                                                                <td rowspan="{{ $row + 1 }}">
                                                                    <div>
                                                                        <b>{{ Carbon\Carbon::parse($li->landing_date)->locale('ms')->isoFormat('dddd') }}</b>
                                                                    </div>
                                                                    <div>
                                                                        {{ optional($li->landing_date)->format('d-m-Y') }}
                                                                    </div>
                                                                </td>
                                                                @if ($row > 0)
                                                                    <td>{{$landingActivities[0]->landing_activity_type_id != null ? App\Models\LandingDeclaration\LandingActivityType::find($landingActivities[0]->landing_activity_type_id)->name  : '' }}</td>
                                                                    <td>{{$landingActivities[0]->species_name}}</td>
                                                                    <td>{{$landingActivities[0]->weight}}</td>
                                                                    <td>{{$landingActivities[0]->price_per_weight}}</td>
                                                                @else
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                @endif
                                                            </tr>
                                                            @if ($row>0)
                                                                @for ( $i=1;$i<$row;$i++)
                                                                    <tr>
                                                                        <td>{{$landingActivities[$i]->landing_activity_type_id != null ? App\Models\LandingDeclaration\LandingActivityType::find($landingActivities[$i]->landing_activity_type_id)->name  : '' }}</td>
                                                                        <td>{{$landingActivities[$i]->species_name}}</td>
                                                                        <td>{{$landingActivities[$i]->weight}}</td>
                                                                        <td>{{$landingActivities[$i]->price_per_weight}}</td>
                                                                    </tr>
                                                                @endfor
                                                                <tr>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row">
                                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                                <a href="{{ route('landingdeclaration.application.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="content-e" role="tabpanel" aria-labelledby="content-e-tab">
                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-header bg-primary">
                                        <h4 class="mb-0" style="color:white;">E. Maklumat Dokumen </h4>
                                    </div>
                                    <div class="card-body">
                                        <br />
                                        <div class="row">
                                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                                <a href="{{ route('landingdeclaration.application.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="content-f" role="tabpanel" aria-labelledby="content-f-tab">
                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-header bg-primary">
                                        <h4 class="mb-0" style="color:white;">F. Perakuan </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="col-form-label">Perakuan Pemohon</label>

                                                    <p class="mb-3">
                                                        Saya dengan ini mengakui dan mengesahkan bahawa semua maklumat yang diberikan oleh saya adalah benar. 
                                                        Sekiranya terdapat maklumat yang tidak benar, pihak Jabatan boleh menolak permohonan saya dan tindakan undang-undang boleh dikenakan ke atas saya.
                                                    </p>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" checked disabled>
                                                        <label class="form-check-label">Setuju</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" disabled>
                                                        <label class="form-check-label">Tidak Setuju</label>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row">
                                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                                <a href="{{ route('landingdeclaration.application.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
<script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script src="{{ asset('template/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript">

       bsCustomFileInput.init();

        $(document).on('input', "input[type=text]", function () {
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
        });

        

        

        
        

</script>   
@endpush
