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
                        <a class="nav-link active disabled" id="content-a-tab" data-bs-toggle="tab" href="#content-a" role="tab"
                        aria-controls="content-a" aria-selected="false">Ringkasan Maklumat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" id="content-b-tab" data-bs-toggle="tab" href="#content-b" role="tab"
                        aria-controls="content-b" aria-selected="false">Maklumat Aktiviti</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" id="content-c-tab" data-bs-toggle="tab" href="#content-c" role="tab"
                        aria-controls="content-c" aria-selected="false">Maklumat Pendaratan</a>
                    </li>
                </ul>
                <div class="tab-content p-4" id="tabContent">
                    <div class="tab-pane fade show active" id="content-a" role="tabpanel" aria-labelledby="content-a-tab">
                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-header bg-primary">
                                        <h4 class="mb-0" style="color:white;">Ringkasan Maklumat </h4>
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
                                                <a href="{{ route('landingdeclaration.confirmation.show', $app->landing_declare_monthly_id) }}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                <a class="btn btn-dark btn-sm next-tab-btn" data-next-tab="content-b-tab"><i class="fas fa-arrow-right"></i> Seterusnya</a>
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
                                        <h4 class="mb-0" style="color:white;">Maklumat Aktiviti</h4>
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
                                                <a class="btn btn-dark btn-sm next-tab-btn" data-next-tab="content-a-tab"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                <a class="btn btn-dark btn-sm next-tab-btn" data-next-tab="content-c-tab"><i class="fas fa-arrow-right"></i> Seterusnya</a>
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
                                        <h4 class="mb-0" style="color:white;">Maklumat Pendaratan </h4>
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
                                                                $landingInfoActivites = App\Models\LandingDeclaration\LandingInfoActivity::where('landing_info_id',$li->id)->whereIn('landing_activity_type_id',$landingActivityIds)->orderBy('time')->get();
                                                                $landingInfoActivityIds = App\Models\LandingDeclaration\LandingInfoActivity::where('landing_info_id',$li->id)->whereIn('landing_activity_type_id',$landingActivityIds)->select('id')->get()->pluck('id')->toArray();
                                                                
                                                                $row = $landingInfoActivites->count(); //number of activities per day

                                                                //loop through each activity
                                                                $extraRow = 0;
                                                                if($row > 0){
                                                                    foreach( $landingInfoActivites as $lIA ){
                                                                        $hasLandingSpecies = App\Models\LandingDeclaration\LandingActivitySpecies::where('landing_info_activity_id',$lIA->id)->exists();
                                                                        if($hasLandingSpecies){
                                                                            $extraRow++;
                                                                        }
                                                                    }
                                                                }
                                                                $rowWithOnlyOneLine = $row - $extraRow;

                                                                $landingSpecies = App\Models\LandingDeclaration\LandingActivitySpecies::whereIn('landing_info_activity_id',$landingInfoActivityIds)->get();
                                                                $row2 = $landingSpecies->count();
                                                            @endphp
                                                            <tr>
                                                                @if ( $row > 0 )
                                                                    <td rowspan="{{ $rowWithOnlyOneLine + $row2 }}">
                                                                @else
                                                                    <td rowspan="1">
                                                                @endif
                                                                    <div>
                                                                        <b>{{ Carbon\Carbon::parse($li->landing_date)->locale('ms')->isoFormat('dddd') }}</b>
                                                                    </div>
                                                                    <div>
                                                                        {{ optional($li->landing_date)->format('d-m-Y') }}
                                                                    </div>
                                                                </td>
                                                                @if ($row > 0)
                                                                    @php
                                                                        $activitySpecies = App\Models\LandingDeclaration\LandingActivitySpecies::where('landing_info_activity_id',$landingInfoActivites[0]->id)->get();
                                                                        $row3 = $activitySpecies->count();
                                                                    @endphp
                                                                    <td rowspan="{{ $row3 > 0 ? $row3 : 1 }}">
                                                                        {{$landingInfoActivites[0]->landing_activity_type_id != null ? App\Models\LandingDeclaration\LandingActivityType::find($landingInfoActivites[0]->landing_activity_type_id)->name  : '' }}
                                                                    </td>
                                                                    @if ($row3 > 0)
                                                                        <td>
                                                                            {{ App\Models\Species::find($activitySpecies[0]->species_id)->common_name}}
                                                                        </td>
                                                                        <td>{{$activitySpecies[0]->weight}}</td>
                                                                        <td>{{$activitySpecies[0]->price_per_weight}}</td>
                                                                        @for ( $j=1;$j<$row3;$j++)
                                                                            <tr>
                                                                                <td>
                                                                                    {{ App\Models\Species::find($activitySpecies[$j]->species_id)->common_name}}
                                                                                </td>
                                                                                <td>{{$activitySpecies[$j]->weight}}</td>
                                                                                <td>{{$activitySpecies[$j]->price_per_weight}}</td>
                                                                            </tr>
                                                                        @endfor
                                                                    @else
                                                                        <td colspan="3">
                                                                            <span style="color: red;">- Tiada Pendaratan -</span>
                                                                        </td>
                                                                    @endif
                                                                @else
                                                                    <td colspan="4">-Tiada Aktiviti-</td>
                                                                @endif
                                                            </tr>
                                                            @if ($row>0)
                                                                @for ( $i=1;$i<$row;$i++ )
                                                                    @php
                                                                        $activitySpecies = App\Models\LandingDeclaration\LandingActivitySpecies::where('landing_info_activity_id',$landingInfoActivites[$i]->id)->get();
                                                                        $row3 = $activitySpecies->count();
                                                                    @endphp
                                                                    <tr >
                                                                        <td rowspan="{{ $row3 > 0 ? $row3 : 1 }}">
                                                                            {{$landingInfoActivites[$i]->landing_activity_type_id != null ? App\Models\LandingDeclaration\LandingActivityType::find($landingInfoActivites[$i]->landing_activity_type_id)->name  : '' }}
                                                                        </td>
                                                                        @if ($row3 > 0)
                                                                            <td>
                                                                                {{ App\Models\Species::find($activitySpecies[0]->species_id)->common_name}}
                                                                            </td>
                                                                            <td>{{$activitySpecies[0]->weight}}</td>
                                                                            <td>{{$activitySpecies[0]->price_per_weight}}</td>
                                                                            @for ( $j=1;$j<$row3;$j++ )
                                                                                <tr>
                                                                                    <td>
                                                                                        {{ App\Models\Species::find($activitySpecies[$j]->species_id)->common_name}}
                                                                                    </td>
                                                                                    <td>{{$activitySpecies[$j]->weight}}</td>
                                                                                    <td>{{$activitySpecies[$j]->price_per_weight}}</td>
                                                                                </tr>
                                                                            @endfor
                                                                        @else
                                                                            <td colspan="3"><span style="color: red;">-Tiada Pendaratan-</span></td>
                                                                        @endif
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
                                                <a class="btn btn-dark btn-sm next-tab-btn" data-next-tab="content-b-tab"><i class="fas fa-arrow-left"></i> Kembali</a>
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
    const nextTabButtons = document.querySelectorAll('.next-tab-btn');
    const tabList = document.getElementById('myTab');

    nextTabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const nextTabId = this.dataset.nextTab;
            const nextTabTrigger = tabList.querySelector(`#${nextTabId}`);

            if (nextTabTrigger) {
            const nextTabBootstrap = bootstrap.Tab.getOrCreateInstance(nextTabTrigger);
            nextTabBootstrap.show();
            }
        });
    });
</script>   
@endpush
