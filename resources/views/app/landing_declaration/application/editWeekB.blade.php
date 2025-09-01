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
                        <a class="nav-link disabled" href="#" role="tab" aria-selected="false">Maklumat Aktiviti</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#" role="tab" aria-selected="true">Maklumat Pendaratan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" role="tab" aria-selected="false">Ringkasan Maklumat</a>
                    </li>
                </ul>
                <br />
                <div>
                    <div class="row">
                        <div class="col-12">
                            <!-- card -->
                            <div class="card mb-4">
                                <div class="card-header bg-primary">
                                    <h4 class="mb-0" style="color:white;">Maklumat Pendaratan</h4>
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
                                                                <td rowspan="{{ $rowWithOnlyOneLine + $extraRow + $row2 }}">
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
                                                                <td rowspan="{{ $row3 > 0 ? $row3+1 : 1 }}">
                                                                    {{$landingInfoActivites[0]->landing_activity_type_id != null ? App\Models\LandingDeclaration\LandingActivityType::find($landingInfoActivites[0]->landing_activity_type_id)->name  : '' }}
                                                                </td>
                                                                @if ($row3 > 0)
                                                                    <td>
                                                                        {{ App\Models\Species::find($activitySpecies[0]->species_id)->common_name}}
                                                                        <form method="post" action="{{ route('landingdeclaration.application.deleteSpecies',$activitySpecies[0]->id) }}"> 
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <a href="{{ route('landingdeclaration.application.editWeekBEditSpecies', $activitySpecies[0]->id) }}" class="btn btn-warning btn-sm" title="Kemaskini"><i class="fas fa-edit"></i></a>
                                                                            <button type="submit" onclick="return confirm($('<span>Padam Species?</span>').text())" class="btn btn-danger btn-sm" title="Padam"><i class="fas fa-trash"></i>
                                                                        </form>
                                                                    </td>
                                                                    <td>{{$activitySpecies[0]->weight}}</td>
                                                                    <td>{{$activitySpecies[0]->price_per_weight}}</td>
                                                                    @for ( $j=1;$j<$row3;$j++)
                                                                        <tr>
                                                                            <td>
                                                                                {{ App\Models\Species::find($activitySpecies[$j]->species_id)->common_name}}
                                                                                <form method="post" action="{{ route('landingdeclaration.application.deleteSpecies',$activitySpecies[$j]->id) }}"> 
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <a href="{{ route('landingdeclaration.application.editWeekBEditSpecies', $activitySpecies[$j]->id) }}" class="btn btn-warning btn-sm" title="Kemaskini"><i class="fas fa-edit"></i></a>
                                                                                    <button type="submit" onclick="return confirm($('<span>Padam Species?</span>').text())" class="btn btn-danger btn-sm" title="Padam"><i class="fas fa-trash"></i>
                                                                                </form>
                                                                            </td>
                                                                            <td>{{$activitySpecies[$j]->weight}}</td>
                                                                            <td>{{$activitySpecies[$j]->price_per_weight}}</td>
                                                                        </tr>
                                                                    @endfor
                                                                    <tr>
                                                                        <td colspan="3">
                                                                            <a href="{{ route('landingdeclaration.application.editWeekBAddSpecies', $landingInfoActivites[0]->id) }}" class="btn btn-secondary btn-sm" title="Tambah"><i class="fas fa-plus"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                @else
                                                                    <td colspan="3">
                                                                        <a href="{{ route('landingdeclaration.application.editWeekBAddSpecies', $landingInfoActivites[0]->id) }}" class="btn btn-secondary btn-sm" title="Tambah"><i class="fas fa-plus"></i></a>
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
                                                                    <td rowspan="{{ $row3 > 0 ? $row3+1 : 1 }}">
                                                                        {{$landingInfoActivites[$i]->landing_activity_type_id != null ? App\Models\LandingDeclaration\LandingActivityType::find($landingInfoActivites[$i]->landing_activity_type_id)->name  : '' }}
                                                                    </td>
                                                                    @if ($row3 > 0)
                                                                        <td>
                                                                            {{ App\Models\Species::find($activitySpecies[0]->species_id)->common_name}}
                                                                            <form method="post" action="{{ route('landingdeclaration.application.deleteSpecies',$activitySpecies[0]->id) }}"> 
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <a href="{{ route('landingdeclaration.application.editWeekBEditSpecies', $activitySpecies[0]->id) }}" class="btn btn-warning btn-sm" title="Kemaskini"><i class="fas fa-edit"></i></a>
                                                                                <button type="submit" onclick="return confirm($('<span>Padam Species?</span>').text())" class="btn btn-danger btn-sm" title="Padam"><i class="fas fa-trash"></i>
                                                                            </form>
                                                                        </td>
                                                                        <td>{{$activitySpecies[0]->weight}}</td>
                                                                        <td>{{$activitySpecies[0]->price_per_weight}}</td>
                                                                        @for ( $j=1;$j<$row3;$j++ )
                                                                            <tr>
                                                                                <td>
                                                                                    {{ App\Models\Species::find($activitySpecies[$j]->species_id)->common_name}}
                                                                                    <form method="post" action="{{ route('landingdeclaration.application.deleteSpecies',$activitySpecies[$j]->id) }}"> 
                                                                                        @csrf
                                                                                        @method('DELETE')
                                                                                        <a href="{{ route('landingdeclaration.application.editWeekBEditSpecies', $activitySpecies[$j]->id) }}" class="btn btn-warning btn-sm" title="Kemaskini"><i class="fas fa-edit"></i></a>
                                                                                        <button type="submit" onclick="return confirm($('<span>Padam Species?</span>').text())" class="btn btn-danger btn-sm" title="Padam"><i class="fas fa-trash"></i>
                                                                                    </form>
                                                                                </td>
                                                                                <td>{{$activitySpecies[$j]->weight}}</td>
                                                                                <td>{{$activitySpecies[$j]->price_per_weight}}</td>
                                                                            </tr>
                                                                        @endfor
                                                                        <tr>
                                                                            <td colspan="3">
                                                                                <a href="{{ route('landingdeclaration.application.editWeekBAddSpecies', $landingInfoActivites[$i]->id) }}" class="btn btn-secondary btn-sm" title="Tambah"><i class="fas fa-plus"></i></a>
                                                                            </td>
                                                                        </tr>
                                                                    @else
                                                                        <td colspan="3">
                                                                            <a href="{{ route('landingdeclaration.application.editWeekBAddSpecies', $landingInfoActivites[$i]->id) }}" class="btn btn-secondary btn-sm" title="Tambah"><i class="fas fa-plus"></i></a>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            @endfor
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
                                                <a href="{{ route('landingdeclaration.application.editWeek',$app->id) }}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                <a href="{{ route('landingdeclaration.application.editWeekC',$app->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-arrow-right"></i> Seterusnya</a>
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
