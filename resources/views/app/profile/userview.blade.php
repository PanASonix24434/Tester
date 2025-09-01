@extends('layouts.app')

@push('styles')
    <style type="text/css">
        .card {
        @apply bg-white shadow-md rounded-lg p-4 mb-4;
        }

        .form-check-input:disabled {
            opacity: 1; 
            pointer-events: none; 
        }

        .form-check-label {
            color: black !important; 
        }
    </style>
@endpush

@section('content')
<form id="form-profile-create" method="GET" enctype="multipart/form-data" action="{{ route('profile.editprofileuser', ['id' => $profile->id]) }}">
@csrf
    <!-- Page Content -->
    <div id="app-content">

        <!-- Container fluid -->
        <div class="app-content-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">

                        <!-- Page header -->
                         <div class="mb-5">
                            <h3 class="">Profil Pengguna</h3>
                        </div>
                    </div>
                </div>
                <div>
                    <!-- row -->
                    <div class="row">
                        <div class="col-10">
                            <!-- card -->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-primary" style="outline: 2px solid lightgray;">
                                                <div class="card-body box-profile d-flex flex-column flex-md-row align-items-center">
                                            
                                                <!-- Profile Image -->
                                                <div class="d-flex flex-column align-items-center">
                                                        <div class="profile-image" style="margin-top: 1px; margin-bottom: 10px; margin-right: 30px; margin-left: 30px; max-width: 120px; position: relative;">

                                                            @if (empty(Auth::user()->profile_picture))
                                                            <img class="profile-user-img img-fluid img-rectangle"
                                                            src="{{ asset('/images/avatar.png') }}"
                                                            alt="User profile picture"
                                                            style="width: 100%; max-width: 120px; height: auto;">

                                                            @else
                                                            <a href="{{ asset('/storage/profile-picture/.original/' . Auth::user()->profile_picture) }}" class="profile-picture">
                                                                <img class="profile-user-img img-fluid img-rectangle" 
                                                                src="{{ asset('/storage/profile-picture/.original/' . Auth::user()->profile_picture) }}" 
                                                                alt="User profile picture" 
                                                                style="width: 100%; max-width: 120px; height: auto;">
                                                            </a>
                                                            
                                                            @endif

                                                            <!-- Processing Indicator -->
                                                            <div id="process-img" class="processing hidden" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                                                <h3>
                                                                    <span class="badge badge-light badge-outline">
                                                                        <i class="fas fa-spinner fa-spin bigger-120"></i>
                                                                        {{ __('app.processing') }}...
                                                                    </span>
                                                                </h3>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Profile Info -->
                                                    <div class="profile-info flex-grow-1 mt-2" style="padding: 0%;">
                                                        <table class="table">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="width: 35%;"><b>Nama</b></td>
                                                                    <td style="width: 5%;">:</td>
                                                                    <td style="width: 70%;"><a class="ml-2">{{ strtoupper(Auth::user()->name) }}</a></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 35%;"><b>No. Kad Pengenalan (Lama)</b></td>
                                                                    <td style="width: 5%;">:</td>
                                                                    <td style="width: 70%;"><a class="ml-2">{{ strtoupper(Auth::user()->username) }}</a></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 35%;"><b>No. Kad Pendaftaran Nelayan</b></td>
                                                                    <td style="width: 5%;">:</td>
                                                                    <td style="width: 70%;"><a class="ml-2">-</a></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
            
                                        <!-- Single Column: Card with Form Inside -->
                                        <div class="col-lg-12">
                                            <div class="card card-primary" style="outline: 2px solid lightgray;">
                                                <div class="card-header" style="padding-bottom: 2px;">
                                                    <h6 style="color: white; font-size: 0.9rem;">PROFIL PENGGUNA</h6>
                                                </div>
                                        
                                                <div class="card-body">
                                                    <ul class="nav nav-tabs" id="tabMenu" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" id="individu-tab" data-bs-toggle="tab" onclick="redirectToPage('{{ route('profile.handleProfile') }}')" role="tab" aria-controls="individu" aria-selected="true">
                                                                Maklumat Individu
                                                            </a>
                                                        </li>

                                                        @if($user_roles_darat==true)
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="kewangan-tab" data-bs-toggle="tab" onclick="redirectToPage('{{ route('profile.kewanganDarat') }}')" role="tab" aria-controls="" aria-selected="false">
                                                                Maklumat Kewangan
                                                            </a>
                                                        </li>
                                                        @endif

                                                        @if($user_roles_darat==true)
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="pangkalan-tab" data-bs-toggle="tab" onclick="redirectToPage('{{ route('profile.pangkalanDarat') }}')" role="tab" aria-controls="" aria-selected="false">
                                                                Pangkalan Pendaratan
                                                            </a>
                                                        </li>
                                                        @endif

                                                        @if($user_roles_darat==true)
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="vesel-tab" data-bs-toggle="tab" onclick="redirectToPage('{{ route('profile.veselDarat') }}')" role="tab" aria-controls="" aria-selected="false">
                                                                Vesel/Jeti
                                                            </a>
                                                        </li>
                                                        @endif

                                                        @if($user_roles_darat==true)
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="aktiviti-tab" data-bs-toggle="tab" onclick="redirectToPage('{{ route('profile.aktivitiDarat') }}')" role="tab" aria-controls="" aria-selected="false">
                                                                Aktiviti Penangkapan Ikan
                                                            </a>
                                                        </li>
                                                        @endif

                                                        @if($user_roles_darat==true)
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="kesalahan-tab" data-bs-toggle="tab" onclick="redirectToPage('{{ route('profile.kesalahanDarat') }}')" role="tab" aria-controls="" aria-selected="false">
                                                                Kesalahan
                                                            </a>
                                                        </li>
                                                        @endif
                                                        
                                                        <!--  
                                                        @if($user_roles_laut ==true || $user_roles_skl ==true)
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="syarikat-tab" data-bs-toggle="tab" onclick="redirectToPage('{{ route('profile.maklumatSyarikat') }}')" role="tab" aria-controls="syarikat" aria-selected="false">
                                                                Maklumat Syarikat
                                                            </a>
                                                        </li>
                                                        @endif
                                                        -->

                                                        @if($user_roles_skl==true)
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="skl-tab" data-bs-toggle="tab" onclick="redirectToPage('{{ route('profile.projekskl') }}')" role="tab" aria-controls="skl" aria-selected="false">
                                                                Lesen SKL
                                                            </a>
                                                        </li>
                                                        @endif
                                                    </ul>
                                                    <br>

                                                    <div class="tab-content" id="tabContent">
                                                        <!-- Maklumat Individu -->
                                                        <div class="tab-pane fade show active" id="individu" role="tabpanel" aria-labelledby="individu-tab">
                                                            <h6 class="section-title" style="font-weight: bold; font-size: 0.9rem; color: #1070d5; border-bottom: 2px solid #1070d5; padding-bottom: 5px; margin-bottom: 2%;">Butiran Am Pengguna</h6>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label>Nama Pengguna <span style="color: red;">*</span></label>
                                                                        <input type="text" name="name" class="form-control" id="name" value="{{ strtoupper(Auth::user()->name) }}" style="background-color: #F1F2F4" disabled>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label>No. Kad Pengenalan  <span style="color: red;">*</span></label>
                                                                        <input type="text" name="icno" class="form-control" id="icno" value="{{ strtoupper(Auth::user()->username) }}" style="background-color: #F1F2F4" disabled>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                            <label>Alamat Semasa <span style="color: red;">*</span></label>
                                                        
                                                                        <!-- No Lot/Unit/Rumah -->
                                                                            <input type="text" name="no_lot" class="form-control" placeholder="No Lot/Unit/Rumah" value="{{ $profile->address1 ?? '' }}" style="margin-top: 5px; background-color: #F1F2F4" reaadonly >
                                                                            
                                                                        <!-- Nama Jalan -->
                                                                            <input type="text" name="nama_jalan" class="form-control" placeholder="Nama/No. Jalan" value="{{ $profile->address2 ?? '' }}" style="margin-top: 5px; background-color: #F1F2F4" reaadonly >
                                                                            
                                                                        <!-- Taman/Kampung/Bandar -->
                                                                            <input type="text" name="nama_bandar" class="form-control" placeholder="Taman/Kampung/Bandar" value="{{ $profile->address3 ?? '' }}" style="margin-top: 5px; background-color: #F1F2F4" reaadonly >
                                                                        
                                                                    </div>
                                                        
                                                        
                                                                    <div class="form-group">
                                                                        <label>Poskod <span style="color: red;">*</span></label>
                                                                        <input type="number" name="poskod" class="form-control" id="poskod" value="{{ $profile->poskod ?? '' }}" style="background-color: #F1F2F4" disabled>
                                                                    </div>
                                                        
                                                                    <div class="form-group">
                                                                        <label for="negeri">Negeri <span style="color: red;">*</span></label>
                                                                        <select id="negeri" name="negeri" class="form-control" style="background-color: #F1F2F4" disabled>
                                                                            @foreach($states as $state)
                                                                                <option value="{{ $state->id }}" 
                                                                                    {{ $profile->state == $state->id ? 'selected' : '' }}>
                                                                                    {{ strtoupper($state->name) }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="daerah">Daerah <span style="color: red;">*</span></label>
                                                                        <select id="daerah" name="daerah" class="form-control" style="background-color: #F1F2F4" disabled>
                                                                            @if($selectedDistrict)
                                                                                <option value="{{ $selectedDistrict->id }}" selected>{{ strtoupper($selectedDistrict->name) }}</option>
                                                                            @else
                                                                                <option value="">Tiada daerah dipilih</option>
                                                                            @endif
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group">
                                                                            <label>Alamat Surat-Menyurat <span style="color: red;">*</span></label>
                                                        
                                                                        <!-- No Lot/Unit/Rumah -->
                                                                            <input type="text" name="secondary_address_1" class="form-control" placeholder="No Lot/Unit/Rumah" value="{{ $profile->secondary_address_1 ?? '' }}" style="margin-top: 5px; background-color: #F1F2F4" reaadonly >
                                                                            
                                                                        <!-- Nama Jalan -->
                                                                            <input type="text" name="secondary_address_2" class="form-control" placeholder="Nama/No. Jalan" value="{{ $profile->secondary_address_2 ?? '' }}" style="margin-top: 5px; background-color: #F1F2F4" reaadonly >
                                                                            
                                                                        <!-- Taman/Kampung/Bandar -->
                                                                            <input type="text" name="secondary_address_3" class="form-control" placeholder="Taman/Kampung/Bandar" value="{{ $profile->secondary_address_3 ?? '' }}" style="margin-top: 5px; background-color: #F1F2F4" reaadonly >
                                                                        
                                                                    </div>
                                                        
                                                        
                                                                    <div class="form-group">
                                                                        <label>Poskod (Alamat Surat-Menyurat) <span style="color: red;">*</span></label>
                                                                        <input type="number" name="secondary_postcode" class="form-control" id="secondary_postcode" value="{{ $profile->secondary_postcode ?? '' }}" style="background-color: #F1F2F4" disabled>
                                                                    </div>
                                                        
                                                                    <div class="form-group">
                                                                        <label for="secondary_state">Negeri (Alamat Surat-Menyurat) <span style="color: red;">*</span></label>
                                                                        <select id="secondary_state" name="secondary_state" class="form-control" style="background-color: #F1F2F4" disabled>
                                                                        @foreach($states as $state)
                                                                            <option value="{{ $state->id }}" 
                                                                                {{ $profile->secondary_state == $state->id ? 'selected' : '' }}>
                                                                                {{ strtoupper($state->name) }}
                                                                            </option>
                                                                        @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="secondary_district">Daerah (Alamat Surat-Menyurat) <span style="color: red;">*</span></label>
                                                                        <select id="secondary_district" name="secondary_district" class="form-control" style="background-color: #F1F2F4" disabled>
                                                                        @if($selectedSecondaryDistrict)
                                                                            <option value="{{ $selectedSecondaryDistrict->id }}" selected>
                                                                                {{ strtoupper($selectedSecondaryDistrict->name) }}
                                                                            </option>
                                                                        @else
                                                                            <option value="">Tiada daerah dipilih</option>
                                                                        @endif
                                                                    </select>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="parliament">Parlimen (Kawasan Mengundi) <span style="color: red;">*</span></label>
                                                                        <select id="parliament" name="parliament" class="form-control" style="background-color: #F1F2F4" disabled>
                                                                            @foreach($parliaments as $p)
                                                                                <option value="{{ $p->id }}" 
                                                                                    {{ $profile->parliament == $p->id ? 'selected' : '' }}>
                                                                                    {{ $p->parliament_name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    
                                                                    <div class="form-group">
                                                                        <label for="parliament_seat">DUN (Kawasan Mengundi) <span style="color: red;">*</span></label>
                                                                        <select id="parliament_seat" name="parliament_seat" class="form-control" style="background-color: #F1F2F4" disabled>
                                                                            @if($selectedDun)
                                                                                <option value="{{ $selectedDun->id }}" selected>{{ $selectedDun->parliament_seat_name }}</option>
                                                                            @else
                                                                                <option value="">Tiada DUN dipilih</option>
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label for="ic">Umur <span style="color: red;">*</span></label>
                                                                        <input type="text" name="age" class="form-control" id="age" value="{{ $profile->age ?? '' }}" style="margin-top: 5px; background-color: #F1F2F4" reaadonly >
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="gender">Jantina <span style="color: red;">*</span></label>
                                                                        <select id="gender" name="gender" class="form-control" style="background-color: #F1F2F4" disabled>
                                                                            @foreach($gender as $g)
                                                                                <option value="{{ $g->id }}" {{ $profile->gender_id == $g->id ? 'selected' : '' }}>
                                                                                    {{ strtoupper($g->name_ms) }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    

                                                                    <div class="form-group">
                                                                        <label for="user_type">Kumpulan Pengguna <span style="color: red;">*</span></label>
                                                                        <select id="user_type" name="user_type" class="form-control" style="background-color: #F1F2F4" disabled>>
                                                                            @foreach($userTypes as $k)
                                                                                <option value="{{ $k->code }}" 
                                                                                    {{ $profile->user_type == $k->code ? 'selected' : '' }}>
                                                                                    {{ strtoupper($k->name_ms) }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                      
                                                                    <div class="form-group">
                                                                            <label for="religion">Agama</label>
                                                                            <select id="religion" name="religion" class="form-control" style="background-color: #F1F2F4" disabled>
                                                                                @foreach($religion as $s)
                                                                                    <option value="{{ $s->code }}" 
                                                                                        {{ $profile->religion == $s->code ? 'selected' : '' }}>
                                                                                        {{ $s->name_ms }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="marital_status">Status Perkahwinan <span style="color: red;">*</span></label>
                                                                        <select id="marital_status" name="marital_status" class="form-control" style="background-color: #F1F2F4" disabled>
                                                                            @foreach($marital_status as $z)
                                                                                <option value="{{ $z->code }}" 
                                                                                    {{ $profile->wedding_status == $z->code ? 'selected' : '' }}>
                                                                                    {{ strtoupper($z->name_ms) }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="txtPhoneNo" class="form-label">No. Telefon Bimbit : <span style="color: red;">*</span></label>
                                                                        <div class="input-group has-validation" style="margin-top: 5px;">
                                                                            <span class="input-group-text" id="inputGroupPrepend" style="background-color: #E0E0E0; color: #000; border: 1px solid #ced4da; padding: 10px 15px; height: auto;">+60</span>
                                                                            <input type="number" class="form-control" id="txtPhoneNo" name="txtPhoneNo" 
                                                                            value="{{ isset($profile->no_phone) ? substr($profile->no_phone, 2) : '' }}" 
                                                                            style="background-color: #F1F2F4; border: 1px solid #ced4da; height: auto;" disabled 
                                                                            aria-describedby="inputGroupPrepend">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="txtPhoneNoSecond" class="form-label">No. Telefon Bimbit Kedua :</label>
                                                                        <div class="input-group has-validation" style="margin-top: 5px;">
                                                                            <span class="input-group-text" id="inputGroupPrepend" style="background-color: #E0E0E0; color: #000; border: 1px solid #ced4da; padding: 10px 15px; height: auto;">+60</span>
                                                                            <input type="number" class="form-control" id="txtPhoneNoSecond" name="txtPhoneNoSecond" 
                                                                            value="{{ isset($profile->secondary_phone_number) ? substr($profile->secondary_phone_number, 2) : '' }}" 
                                                                            style="background-color: #F1F2F4; border: 1px solid #ced4da; height: auto;" disabled 
                                                                            aria-describedby="inputGroupPrepend">
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="txtOfficePhoneNo" class="form-label">No. Telefon Pejabat:</label>
                                                                        <div class="input-group has-validation" style="margin-top: 5px;">
                                                                            <span class="input-group-text" id="inputGroupPrepend" style="background-color: #E0E0E0; color: #000; border: 1px solid #ced4da; padding: 10px 15px; height: auto;">+60</span>
                                                                            <input type="number" class="form-control" id="txtOfficePhoneNo" name="txtOfficePhoneNo" 
                                                                            value="{{ isset($profile->no_phone_office) ? substr($profile->no_phone_office, 2) : '' }}" 
                                                                            style="background-color: #F1F2F4; border: 1px solid #ced4da; height: auto;" 
                                                                            aria-describedby="inputGroupPrepend">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="status" style="margin-right: 10%;">Status Bumiputera <span style="color: red;">*</span></label>
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="radio" name="status_bumiputera" id="bumiputera" value="bumiputera" checked disabled>
                                                                            <label class="form-check-label" for="bumiputera">Ya</label>
                                                                        </div>

                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="radio" name="status_bumiputera" id="tidak_bumiputera" value="tidak_bumiputera" disabled>
                                                                            <label class="form-check-label" for="tidak_bumiputera">Tidak</label>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="oku" style="margin-right: 17%;">Status OKU <span style="color: red;">*</span></label>
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="radio" name="status_oku" id="oku" value="oku" disabled>
                                                                            <label class="form-check-label" for="oku">Ya</label>
                                                                        </div>
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="radio" name="status_oku" id="bukan_oku" value="bukan_oku" checked disabled>
                                                                            <label class="form-check-label" for="bukan_oku">Tidak</label>
                                                                        </div>
                                                                    </div>


                                                                    <div class="form-group">
                                                                        <label for="race">Bangsa <span style="color: red;">*</span></label>
                                                                        <select id="race" name="race" class="form-control" style="background-color: #F1F2F4" disabled>
                                                                            <option value="" selected>Pilih Bangsa</option>
                                                                            @foreach($race as $a)
                                                                                <option value="{{ $a->code }}" 
                                                                                    {{ $profile->race == $a->code ? 'selected' : '' }}>
                                                                                    {{ $a->name_ms }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="email">Alamat Emel <span style="color: red;">*</span></label>
                                                                            <input type="email" name="email" class="form-control" id="email" value="{{ Auth::user()->email }}">
                                                                            <div class="form-group"style="margin-top: 1%;">
                                                                                <label style="margin-left: 1.5%;"for="notice"><span style="color: red; text-align: justify; font-weight:bolder; font-size: small;">Emel ini akan digunakan untuk semua urusan pelesenan. Sila pastikan emel ini sentiasa aktif. Sebarang perubahan emel perlu dikemaskini di bahagian profil.</span></label>
                                                                            </div>
                                                                    </div> 
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <br>
                                                        <h6 class="section-title" style="font-weight: bold; font-size: 0.9rem; color: #1070d5; border-bottom: 2px solid #1070d5; padding-bottom: 5px; margin-bottom: 2%;">Dokumen yang Perlu Dimuatnaik</h6>
                                                        <table class="table table-bordered" style="border: 1px solid #D3D3D3; border-collapse: collapse; width: 100%;">
                                                            <thead class="table-light" style="border: 1px solid #ddd;">
                                                                <tr>
                                                                    <th style="border: 1px solid #D3D3D3; width: 5%; text-align: center;">Bil</th>
                                                                    <th style="border: 1px solid #D3D3D3; width: 35%; font-weight: bold;">Nama Dokumen</th>
                                                                    <th style="border: 1px solid #D3D3D3; width: 60%;">Dokumen Dimuatnaik</th>
                                                                    <th style="border: 1px solid #D3D3D3; width: 5%;">Tindakan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td style="border: 1px solid #D3D3D3; text-align: center;">1</td>
                                                                    <td style="border-right: none; border-top: 1px solid #D3D3D3; border-left: 1px solid #D3D3D3; border-bottom: 1px solid #D3D3D3; font-weight: bold;">Salinan Kad Pengenalan</td>
                                                                    <td style="border: 1px solid #D3D3D3;">
                                                                        <div class="input-group">
                                                                        <input type="text" class="form-control" 
                                                                            value="{{ basename($profile->salinan_ic) }}" 
                                                                            style="border-top: 1px solid #ced4da; border-bottom: 1px solid #ced4da; border-left: 1px solid #ced4da; border-right: none;" 
                                                                            readonly>
                                                                            <div class="input-group-append">
                                                                                <button type="button" class="btn btn-light" style="background-color: #e9ecef; border-top: 1px solid #ced4da; border-bottom: 1px solid #ced4da; border-right: 1px solid #ced4da; border-left: none; color: rgb(4, 148, 4);">
                                                                                    <i class="fas fa-check"></i>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="border: 1px solid #D3D3D3;">
                                                                        <div class="input-group" style="justify-content: center;">
                                                                            <button type="button" class="btn btn-light view-doc-btn" data-toggle="modal" data-target="#documentModal" 
                                                                                data-file="{{ $profile->salinan_ic }}">
                                                                                <i class="fas fa-search"></i>
                                                                            </button>

                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                        <div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="documentModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="documentModalLabel">Paparan Dokumen</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <iframe id="documentViewer" src="" style="width: 100%; height: 500px;" frameborder="0"></iframe>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <a id="enlargeBtn" target="_blank" class="btn btn-info">Paparan Skrin Penuh</a>
                                                                        <a id="downloadBtn" class="btn btn-primary" download>Muat Turun</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                        
                                                        <!-- End of row -->
                                                        <div class="form-group">
                                                            <div class="profile-info w-100" style="margin-bottom: -30px;">
                                                                <ul class="list-group list-group-unbordered mb-3 w-100" style="margin-top: 20px;">
                                                                    <li class="list-group-item w-100 d-flex justify-content-center align-items-center" style="border-bottom: none;">
                                                                        <div style="display: flex; gap: 10px;">
                                                                            <button type="button" class="btn btn-light scalable back" onclick="history.back();">
                                                                                <span>Kembali</span>
                                                                            </button>
                                                                            <button type="submit" class="btn btn-success scalable save" name="submit" id="submit">
                                                                                <span>Kemaskini</span>
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                </ul>
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
               </div>
           </div>
       </div>
    </div>
</form>

@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).on('input', "input[type=text]", function () {
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
        });

        //Display success message
        var msg = '{{Session::get('alert')}}';
        var exist = '{{Session::has('alert')}}';
        if(exist){
            alert(msg);
        }
    </script> 

    <script>
        function redirectToPage(url) {
            window.location.href = url; // Redirect to the specified URL
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('salinan_ic');
            const label = input.nextElementSibling;

            input.addEventListener('change', function (e) {
                const fileName = input.files[0] ? input.files[0].name : "No File Chosen";
                label.textContent = fileName;
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const icnoField = document.getElementById("icno");
            const genderField = document.getElementById("gender");
            const genderDisplayField = document.getElementById("gender_display");

            if (icnoField && genderField && genderDisplayField) {
                // Extract the last digit from Kad Pengenalan
                const icno = icnoField.value.trim();
                if (icno) {
                    const lastDigit = parseInt(icno.charAt(icno.length - 1), 10);

                    // Determine gender based on the last digit
                    if (!isNaN(lastDigit)) {
                        const gender = lastDigit % 2 === 0 ? "PEREMPUAN" : "LELAKI";
                        genderField.value = gender; // Update the hidden input value
                        genderDisplayField.value = gender; // Update the disabled select field
                    }
                }
            }
        });
    </script>

    <script>
        document.querySelector('.custom-file-input').addEventListener('change', function (e) {
            let fileName = e.target.files[0].name; // Get the selected file name
            e.target.nextElementSibling.innerText = fileName; // Update the label text
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const documentViewer = document.getElementById('documentViewer');
            const enlargeBtn = document.getElementById('enlargeBtn');
            const downloadBtn = document.getElementById('downloadBtn');
            const documentModalLabel = document.getElementById('documentModalLabel');

        document.querySelectorAll('.view-doc-btn').forEach(button => {
            button.addEventListener('click', function () {
            const fileName = this.getAttribute('data-file');

            // Check for a nearby <label> element
            let documentTitle = "Dokumen Tidak Dikenali";
            const labelElement = this.closest('tr').querySelector('label');

            if (labelElement) {
                documentTitle = labelElement.innerText.trim();
            } 
            
            else {
                // Fallback: Use the second <td> text as the document title
                const titleElement = this.closest('tr').querySelector('td:nth-child(2)');
                
                if (titleElement) {
                documentTitle = titleElement.textContent.trim();
                }
            }

            const fileUrl = `{{ asset('storage') }}/${fileName}`;

            // Update modal title, iframe, enlarge, and download button links
            documentModalLabel.innerText = documentTitle;
            documentViewer.src = fileUrl;
            enlargeBtn.href = fileUrl;
            downloadBtn.href = fileUrl;
            downloadBtn.download = fileName;
            });
        });
        });
  </script>
<script>
    // Handle state change to fetch districts
    $('#negeri').on('change', function () {
        const negeriCode = $(this).val();

        $.ajax({
            url: '{{ route("profile.get.daerah") }}',
            method: 'GET',
            data: { negeri: negeriCode },
            success: function (data) {
                const $daerahSelect = $('#daerah');
                $daerahSelect.empty().append('<option value="">Pilih Daerah</option>');

                data.forEach(function (daerah) {
                    $daerahSelect.append('<option value="' + daerah.code + '">' + daerah.name_ms.toUpperCase() + '</option>');
                });
            },
            error: function (xhr) {
                console.error('Gagal dapatkan daerah:', xhr.responseText);
            }
        });
    });
</script>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

@endpush


