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
                        <a class="nav-link disabled" href="#" role="tab" aria-selected="false">Maklumat Pendaratan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#" role="tab" aria-controls="custom-content-b" aria-selected="true">Ringkasan Maklumat</a>
                    </li>
                </ul>
                <br />
                <div>
                    <form method="POST" action="{{ route('landingdeclaration.application.updateWeekC',$app->id) }}">
                        @csrf
                        <!-- row -->
                        <div class="row">
                            <div class="col-12">
                                <!-- card -->
                                <div class="card mb-4">
                                    <div class="card-header bg-primary">
                                        <h4 class="mb-0" style="color:white;">Ringkasan Maklumat</h4>
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
                                                                        @php
                                                                            $lAs = $landingActivities->pluck('landing_activity_type_id')->unique();
                                                                        @endphp
                                                                        @foreach ( $lAs as $la )
                                                                            <div>
                                                                                {{ App\Models\LandingDeclaration\LandingActivityType::find($la)->name }}
                                                                            </div>
                                                                        @endforeach
                                                                    @else
                                                                        <span style="color: red;">- Tiada Aktiviti -</span>
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
                                                <a href="{{ route('landingdeclaration.application.editWeekB',$app->id) }}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                <button id="btnSubmit" type="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Simpan Pengisytiharan Pendaratan?</span>').text())">
                                                    <i class="fas fa-save"></i> Simpan
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script type="text/javascript">
</script>   
@endpush
