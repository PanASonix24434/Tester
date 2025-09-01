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
                        <a class="nav-link" href="#" role="tab" aria-selected="false">Maklumat Nelayan Darat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" role="tab" aria-selected="false">Waktu Pendaratan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#" role="tab" aria-selected="true">Maklumat Kawasan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" role="tab" aria-selected="false">Maklumat Pendaratan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" role="tab" aria-selected="false">Maklumat Dokumen</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" role="tab" aria-selected="false">Perakuan</a>
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
                                    <h4 class="mb-0" style="color:white;">C. Maklumat Kawasan Penangkapan Ikan</h4>
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
                                                            <td rowspan="{{ $row + 1 }}">
                                                                <div>
                                                                    <b>{{ Carbon\Carbon::parse($li->landing_date)->locale('ms')->isoFormat('dddd') }}</b>
                                                                </div>
                                                                <div>
                                                                    {{ optional($li->landing_date)->format('d-m-Y') }}
                                                                </div>
                                                            </td>
                                                            @if ($row > 0)
                                                                <td>
                                                                    {{$landingActivities[0]->landing_activity_type_id != null ? App\Models\LandingDeclaration\LandingActivityType::find($landingActivities[0]->landing_activity_type_id)->name  : '' }}
                                                                    <form method="post" action="{{ route('landingdeclaration.application.deleteActivity',$landingActivities[0]->id) }}"> 
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <a href="{{ route('landingdeclaration.application.editCEditActivity', $landingActivities[0]->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                                                        <button type="submit" onclick="return confirm($('<span>Padam Aktiviti?</span>').text())" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>
                                                                    </form>
                                                                </td>
                                                                <td>{{$landingActivities[0]->time}}</td>
                                                                <td>{{$landingActivities[0]->state_id != null ? Helper::getCodeMasterNameById($landingActivities[0]->state_id)  : ''}}</td>
                                                                <td>{{$landingActivities[0]->district_id != null ? Helper::getCodeMasterNameById($landingActivities[0]->district_id)  : ''}}</td>
                                                                <td>{{$landingActivities[0]->landing_water_type_id ? App\Models\LandingDeclaration\LandingWaterType::find($landingActivities[0]->landing_water_type_id)->name  : '' }} </td>
                                                                <td>{{$landingActivities[0]->location_name}}</td>
                                                                <td>{{$landingActivities[0]->equipment}}</td>
                                                            @else
                                                                <td colspan="7">
                                                                    <a href="{{ route('landingdeclaration.application.editCAddActivity', $li->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></a>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                        @if ($row>0)
                                                            @for ( $i=1;$i<$row;$i++)
                                                                <tr>
                                                                    <td>
                                                                        {{$landingActivities[$i]->landing_activity_type_id != null ? App\Models\LandingDeclaration\LandingActivityType::find($landingActivities[$i]->landing_activity_type_id)->name  : '' }}
                                                                        <form method="post" action="{{ route('landingdeclaration.application.deleteActivity',$landingActivities[$i]->id) }}"> 
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <a href="{{ route('landingdeclaration.application.editCEditActivity', $landingActivities[$i]->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                                                            <button type="submit" onclick="return confirm($('<span>Padam Aktiviti?</span>').text())" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>
                                                                        </form>
                                                                    </td>
                                                                    <td>{{$landingActivities[$i]->time}}</td>
                                                                    <td>{{$landingActivities[$i]->state_id != null ? Helper::getCodeMasterNameById($landingActivities[$i]->state_id)  : ''}}</td>
                                                                    <td>{{$landingActivities[$i]->district_id != null ? Helper::getCodeMasterNameById($landingActivities[$i]->district_id)  : ''}}</td>
                                                                    <td>{{$landingActivities[$i]->landing_water_type_id ? App\Models\LandingDeclaration\LandingWaterType::find($landingActivities[$i]->landing_water_type_id)->name  : '' }} </td>
                                                                    <td>{{$landingActivities[$i]->location_name}}</td>
                                                                    <td>{{$landingActivities[$i]->equipment}}</td>
                                                                </tr>
                                                            @endfor
                                                            <tr>
                                                                <td colspan="7">
                                                                    <a href="{{ route('landingdeclaration.application.editCAddActivity', $li->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- button action -->
                                    <div class="card-body">
                                        <div class="row">
                                            <br />
                                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                                <a href="{{ route('landingdeclaration.application.editB',$app->id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
    </div>

@endsection

@push('scripts')
<script type="text/javascript">
</script>   
@endpush
