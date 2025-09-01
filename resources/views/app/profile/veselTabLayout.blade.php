@extends('layouts.app')

@section('content')
<!-- Page Content -->
<div id="app-content">
    <div class="app-content-area">
        <div class="container-fluid">
        
           <!-- <div class="mb-5 text-right">  
                <a href="{{ route('profile.formubahsuai', $vessel->id) }}" class="btn btn-primary btn-sm"><span class="hidden-xs"> Permohonan Ubahsuai Vesel</span></a>

            </div> -->
    
            <div class="row align-items-center">
                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                    <!-- Card -->
                    <div class="card rounded-bottom rounded-0 smooth-shadow-sm mb-5">
                        <div class="d-flex pt-4 pb-6 px-4">
                            <!-- Avatar -->
                            <div class="me-4">
                                <img src="{{ asset('assets/images/avatar/kapalmancing.jpg') }}" class="border border-2" style="width: 250px; height: 250px; object-fit: cover;" alt="Image">
                            </div>
                            <!-- Table -->
                            <div class="flex-grow-1">
                                <div class="table-responsive">
                                    <table class="table table-centered text-nowrap">
                                        <tbody>
                                            <tr>
                                                <td><h5 class="mb-0">No. Pendaftaran Vesel</h5></td>
                                                <td>:</td>
                                                <td>{{ $vessel->no_pendaftaran }}</td>
                                            </tr>
                                            <tr>
                                                <td><h5 class="mb-0">Kategori Vesel</h5></td>
                                                <td>:</td>
                                                <td>{{ $vessel->kategori_vessel }}</td>
                                            </tr>
                                            <tr>
                                                <td><h5 class="mb-0">Negeri</h5></td>
                                                <td>:</td>
                                                <td>{{ $vessel->negeri }}</td>
                                            </tr>
                                            <tr>
                                                <td><h5 class="mb-0">Daerah</h5></td>
                                                <td>:</td>
                                                <td>{{ $vessel->daerah }}</td>
                                            </tr>
                                            <tr>
                                                <td><h5 class="mb-0">Pangkalan</h5></td>
                                                <td>:</td>
                                                <td>{{ $vessel->pangkalan }}</td>
                                            </tr>
                                            <tr>
                                                <td><h5 class="mb-0">Zon</h5></td>
                                                <td>:</td>
                                                <td>{{ $vessel->zon }}</td>
                                            </tr>
                                            <tr>
                                                <td><h5 class="mb-0">Tarikh Tamat Lesen</h5></td>
                                                <td>:</td>
                                                <td>{{ $vessel->tarikh_tamat_lesen ? $vessel->tarikh_tamat_lesen->format('d-m-Y') : '-' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs & Content -->
        <div class="card">
            <ul class="nav nav-lt-tab px-4 overflow-auto border-bottom" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active py-2 px-4 text-dark" data-bs-toggle="tab" data-bs-target="#am_vessel" type="button" role="tab">{{ $tab['am_vessel']['name'] }}</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link py-2 px-4 text-purple" data-bs-toggle="tab" data-bs-target="#lesen" type="button" role="tab">{{ $tab['lesen']['name'] }}</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link py-2 px-4 text-purple" data-bs-toggle="tab" data-bs-target="#kulit" type="button" role="tab">{{ $tab['kulit']['name'] }}</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link py-2 px-4 text-purple" data-bs-toggle="tab" data-bs-target="#enjin" type="button" role="tab">{{ $tab['enjin']['name'] }}</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link py-2 px-4 text-purple" data-bs-toggle="tab" data-bs-target="#peralatan" type="button" role="tab">{{ $tab['peralatan']['name'] }}</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link py-2 px-4 text-purple" data-bs-toggle="tab" data-bs-target="#kru" type="button" role="tab">{{ $tab['kru']['name'] }}</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link py-2 px-4 text-purple" data-bs-toggle="tab" data-bs-target="#pangkalan" type="button" role="tab">{{ $tab['pangkalan']['name'] }}</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link py-2 px-4 text-purple" data-bs-toggle="tab" data-bs-target="#pemilikan" type="button" role="tab">{{ $tab['pemilikan']['name'] }}</button>
                </li>
               
                <li class="nav-item">
                    <button class="nav-link py-2 px-4 text-purple" data-bs-toggle="tab" data-bs-target="#pematuhan" type="button" role="tab">{{ $tab['pematuhan']['name'] }}</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link py-2 px-4 text-purple" data-bs-toggle="tab" data-bs-target="#kesalahan" type="button" role="tab">{{ $tab['kesalahan']['name'] }}</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link py-2 px-4 text-purple" data-bs-toggle="tab" data-bs-target="#pendaftaran_antarabangsa" type="button" role="tab">{{ $tab['pendaftaran_antarabangsa']['name'] }}</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link py-2 px-4 text-purple" data-bs-toggle="tab" data-bs-target="#pendaratan" type="button" role="tab">{{ $tab['pendaratan']['name'] }}</button>
                </li>
            </ul>
            
            <div class="tab-content p-4">
                @include('app.profile.tab.am_vessel', ["am_vessel" => $am_vessel])
                @include('app.profile.tab.lesen', ["lesen" => $lesen])
                @include('app.profile.tab.kulit', ["kulitList" => $kulitList])
                @include('app.profile.tab.enjin', ["enjin" => $enjin])
                @include('app.profile.tab.peralatan', ["peralatan" => $peralatan])
                @include('app.profile.tab.kru')
                @include('app.profile.tab.pangkalan', ["pangkalan" => $pangkalan])
                @include('app.profile.tab.pemilikan', ["pemilikan" => $pemilikan])
                @include('app.profile.tab.pematuhan', ["pematuhan" => $pematuhan])
                @include('app.profile.tab.kesalahan', ["kesalahan" => $kesalahan])
                @include('app.profile.tab.pendaftaran_antarabangsa', ["pendaftaran_antarabangsa" => $pendaftaran_antarabangsa])
                @include('app.profile.tab.pendaratan', ["pendaratan" => $pendaratan])
            </div>
        </div>
    </div>
</div>

<style>
.nav-lt-tab {
    background-color: white !important;
    padding: 10px 4px 0px 4px !important;
    display: flex !important;
    overflow-x: auto !important;
    position: relative !important;
    border-bottom: 2px solid #D1D5DB !important;
}

.nav-lt-tab .nav-item {
    margin-right: 10px !important;
}

.nav-lt-tab .nav-link {
    border: 1px solid transparent !important;
    background-color: transparent !important;
    padding: 8px 16px !important;
    border-radius: 6px 6px 0 0 !important;
    font-weight: 500 !important;
    color: #8B5CF6 !important;
    transition: all 0.2s ease !important;
}

.nav-lt-tab .nav-link.active {
    background-color: #F3F4F6 !important;
    border-color: #D1D5DB #D1D5DB transparent !important;
    color: #1F2937 !important;
    font-weight: 600 !important;
    border-radius: 6px 6px 0 0 !important;
    position: relative;
    z-index: 2;
}

.nav-lt-tab .nav-link:hover:not(.active) {
    color: #8B5CF6 !important;
}

.card {
    border-radius: 8px !important;
    overflow: hidden !important;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1) !important;
}

.tab-content {
    background-color: #ffffff !important;
    border-radius: 0 0 8px 8px !important;
}
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get('tab');

        if (tab) {
            const targetBtn = document.querySelector(`button[data-bs-target="#${tab}"]`);
            if (targetBtn) {
                let tabInstance = bootstrap.Tab.getOrCreateInstance(targetBtn);
                tabInstance.show();
            }
        }
    });
</script>

@endsection
