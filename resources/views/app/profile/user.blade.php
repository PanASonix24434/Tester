@extends('layouts.app')

@push('styles')
    <style type="text/css">
    </style>
@endpush

@section('content')
<form id="form-profile-update" method="POST" enctype="multipart/form-data" action="{{ route('profile.storeprofileuser') }}">
    @csrf
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
                
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card card-primary" style="outline: 2px solid lightgray;">
        <div class="card-body box-profile d-flex flex-column flex-md-row align-items-center">
            <!-- Profile Image -->
            <div class="d-flex flex-column align-items-center">
                <div class="profile-image" style="margin-top: 1px; margin-bottom: 10px; max-width: 120px; position: relative;">
                    
                    <a href="{{ asset('/storage/profile-picture/.original/' . (Auth::user()->profile_picture ?? '7ad44131-2027-4963-a2ff-16d1631c3ace.jpg')) }}" class="profile-picture">
                        <img id="preview-profile-picture"
                             class="profile-user-img img-fluid img-rectangle"
                             src="{{ asset('/storage/profile-picture/.original/' . (Auth::user()->profile_picture ?? '7ad44131-2027-4963-a2ff-16d1631c3ace.jpg')) }}"
                             alt="User profile picture"
                             style="width: 100%; max-width: 120px; height: auto;">
                    </a>

                    @if (!empty(Auth::user()->profile_picture))
                        <!-- Rotate Button-->
                        <div id="profile-picture-btn-rotate" style="position: absolute; top: 10px; left: 10px;">
                            <a href="javascript:void(0);" onclick="event.preventDefault(); processAvatar(); document.getElementById('form-profile-picture-rotate').submit();">
                                <span class="fa-stack">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fas fa-redo fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </div>

                        <!-- Delete Button -->
                        <div id="profile-picture-btn-delete" style="position: absolute; top: 10px; right: 10px;">
                            <a href="javascript:void(0);" class="text-danger" onclick="if (confirm($('<span>{{ __('auth.are_you_sure_to_delete_profile_picture') }}</span>').text())) document.getElementById('form-profile-picture-delete').submit();">
                                <span class="fa-stack">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fas fa-times fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </div>
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

                <!-- File Upload Input -->
                <div id="profile-picture-input" class="form-group mt-3">
                    <div class="col-12" style="max-width: 210px; width: 100%;">
                        <div class="custom-file">
                            <input id="profile-picture" type="file" class="custom-file-input" name="profile-picture">
                            <label for="profile-picture" class="custom-file-label">{{ __('app.upload_photo') }}</label>
                        </div>
                        @error('profile-picture')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
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

                            <!-- @if($user_roles_laut ==true || $user_roles_skl ==true)
                            <li class="nav-item">
                                <a class="nav-link" id="syarikat-tab" data-bs-toggle="tab" onclick="redirectToPage('{{ route('profile.maklumatSyarikat') }}')" role="tab" aria-controls="syarikat" aria-selected="false">
                                    Maklumat Syarikat
                                </a>
                            </li>
                            @endif -->


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
                            <!-- Maklumat Individu Content -->
                             <div class="tab-pane fade show active" id="individu" role="tabpanel" aria-labelledby="individu-tab">
                                    <h6 class="section-title" style="font-weight: bold; font-size: 0.9rem; color: #1070d5; border-bottom: 2px solid #1070d5; padding-bottom: 5px; margin-bottom: 2%;">Butiran Am Pengguna</h6>
                                    <div class="row">
                                    <div class="col-sm-6">
                              <div class="form-group">
                                <label>Nama Pengguna</label>
                                <input type="text" name="name" class="form-control" id="name" value="{{ strtoupper(Auth::user()->name) }}" readonly>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>No. Kad Pengenalan</label>
                                <input type="text" name="icno" class="form-control" id="icno" value="{{ strtoupper(Auth::user()->username) }}" readonly>
                              </div>
                            </div>
                          </div>

                            <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <!-- Alamat label only -->
                                <label>Alamat Semasa <span style="color: red;">*</span></label>
                                
                                <!-- Input for No Lot/Unit/Rumah -->
                                <input type="text" name="no_lot" class="form-control" placeholder="No Lot/Unit/Rumah" value="" style="color: black; background-color: white; margin-top: 5px;" required >
                              
                                <!-- Input for Nama/No. Jalan -->
                                <input type="text" name="nama_jalan" class="form-control" placeholder="Nama/No. Jalan" value="" style="color: black; background-color: white; margin-top: 5px;">

                                <!-- Input for Taman/Kampung/Bandar -->
                                <input type="text" name="nama_bandar" class="form-control" placeholder="Taman/Kampung/Bandar" value="" style="color: black; background-color: white; margin-top: 5px;">
                              </div>
                              
                              
                              <div class="form-group">
                                <label>Poskod <span style="color: red;">*</span></label>
                                <input type="number" name="poskod" class="form-control" id="poskod" value="" required>
                              </div>
                              
                              <div class="form-group">
                                <label>Negeri <span style="color: red;">*</span></label>
                                <select id="negeri" name="negeri" class="form-control" required>
                                    <option value="" selected>Pilih Negeri</option>
                                    @foreach($state as $s)
                                        <option value="{{ $s->code }}" {{ $selectedState == $s->code ? 'selected' : '' }}>
                                            {{ strtoupper($s->name_ms) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" style="margin-bottom: 2px;">
                                <label for="daerah">Daerah <span style="color: red;">*</span></label>
                                <select id="daerah" name="daerah" class="form-control" required>
                                    <option value="" selected>Pilih Daerah</option>
                                    @foreach($districts as $d)
                                        <option value="{{ $d->code }}">{{ strtoupper($d->name_ms) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            
                            <br>

                            <div class="form-group">
                                <!-- Alamat label only -->
                                <label>Alamat Surat-Menyurat <span style="color: red;">*</span></label>
                                
                                <!-- Input for No Lot/Unit/Rumah -->
                                <input type="text" name="secondary_address_1" class="form-control" placeholder="No Lot/Unit/Rumah" value="" style="color: black; background-color: white; margin-top: 5px;" required >
                              
                                <!-- Input for Nama/No. Jalan -->
                                <input type="text" name="secondary_address_2" class="form-control" placeholder="Nama/No. Jalan" value="" style="color: black; background-color: white; margin-top: 5px;">

                                <!-- Input for Taman/Kampung/Bandar -->
                                <input type="text" name="secondary_address_3" class="form-control" placeholder="Taman/Kampung/Bandar" value="" style="color: black; background-color: white; margin-top: 5px;">
                              </div>
                              
                              
                              <div class="form-group">
                                <label>Poskod (Alamat Surat-Menyurat) <span style="color: red;">*</span></label>
                                <input type="number" name="secondary_postcode" class="form-control" id="secondary_postcode" value="" required>
                              </div>
                              
                              <div class="form-group">
                                <label>Negeri (Alamat Surat-Menyurat) <span style="color: red;">*</span></label>
                                <select id="secondary_state" name="secondary_state" class="form-control" required>
                                    <option value="" selected>Pilih Negeri</option>
                                    @foreach($state as $s)
                                        <option value="{{ $s->code }}" {{ $selectedState == $s->code ? 'selected' : '' }}>
                                            {{ strtoupper($s->name_ms) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="secondary_district">Daerah (Alamat Surat-Menyurat) <span style="color: red;">*</span></label>
                                <select id="secondary_district" name="secondary_district" class="form-control" required>
                                    <option value="" selected>Pilih Daerah</option>
                                    @foreach($districts as $d)
                                        <option value="{{ $d->code }}">{{ strtoupper($d->name_ms) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                    <label for="parliament">Parlimen (Kawasan Mengundi) <span style="color: red;">*</span></label>
                                    <select id="parliament" name="parliament" class="form-control" required>
                                        <option value="" selected>Pilih Parlimen</option>
                                        @foreach($parliaments as $p)
                                            <option value="{{ $p->id }}">{{ $p->parliament_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="parliament_seat">DUN (Kawasan Mengundi) <span style="color: red;">*</span></label>
                                    <select id="parliament_seat" name="parliament_seat" class="form-control" required>
                                        <option value="">Pilih DUN</option>
                                        @foreach($duns as $dun)
                                            <option value="{{ $dun->id }}">{{ $dun->parliament_seat_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                            <div class="form-group">
                                <label for="age">Umur </label>
                                <input 
                                    type="text" 
                                    name="age" 
                                    class="form-control" 
                                    id="age" 
                                    value="" 
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="gender">Jantina</label>
                                <!-- Disabled select field for display -->
                                <select id="gender_display" class="form-control" disabled>
                                    <option value="">Pilih Jantina</option>
                                    <option value="LELAKI">LELAKI</option>
                                    <option value="PEREMPUAN">PEREMPUAN</option>
                                </select>
                                <!-- Hidden input to hold the actual value -->
                                <input type="hidden" id="gender" name="gender" value="">
                            </div>

                            <div class="form-group">
                            <label for="user_type">Kumpulan Pengguna </label>
                            <!-- Disabled select field for display -->
                            <select id="user_type_display" class="form-control" disabled>
                                <option value="">Pilih Kumpulan Pengguna</option>
                                @foreach($userTypes as $s)
                                    <option 
                                        value="{{ $s->code }}" 
                                        {{ strtoupper(Auth::user()->user_type) == $s->code ? 'selected' : '' }}>
                                        {{ $s->name_ms }}
                                    </option>
                                @endforeach
                            </select>
                            <!-- Hidden input to hold the actual value -->
                            <input type="hidden" id="user_type" name="user_type" value="{{ Auth::user()->user_type }}">
                        </div>

                                <div class="form-group">
                                <label for="religion">Agama <span style="color: red;">*</span></label>
                                <select id="religion" name="religion" class="form-control" required>
                                  <option value="" selected>Pilih Agama</option>
                                  @foreach($religion as $s)
                                            <option value="{{$s->code}}">{{ $s->name_ms }}</option>                                           
                                        @endforeach	
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="marital_status">Status Perkahwinan <span style="color: red;">*</span></label>
                                <select id="marital_status" name="marital_status" class="form-control" required>
                                  <option value="" selected>Pilih Status Perkahwinan</option>
                                  @foreach($marital_status as $s)
                                            <option value="{{$s->code}}">{{ $s->name_ms }}</option>                                           
                                        @endforeach	
                                </select>
                              </div>
                            

                              <div class="form-group">
                                            <label for="txtPhoneNo" class="form-label">No. Telefon Bimbit : <span style="color: red;">*</span></label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">+60</span>
                                                <input type="number" class="form-control" id="txtPhoneNo" name="txtPhoneNo" required
                                                aria-describedby="inputGroupPrepend">
                                            </div>
                                            <div id="phoneErrorLabel" class="text-danger" style="margin-top: 0.5%; font-weight:bolder; display: none;"></div>
                                        </div>

                             <div class="form-group">
                                            <label for="txtPhoneNoSecond" class="form-label">No. Telefon Bimbit Kedua :</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">+60</span>
                                                <input type="number" class="form-control" id="txtPhoneNoSecond" name="txtPhoneNoSecond"
                                                aria-describedby="inputGroupPrepend">
                                            </div>
                                            <div id="phoneErrorLabel" class="text-danger" style="margin-top: 0.5%; font-weight:bolder; display: none;"></div>
                                        </div>
                              <div class="mb-3">
                                            <label for="txtOfficePhoneNo" class="form-label">No. Telefon Pejabat : </label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">+60</span>
                                                <input type="number" class="form-control" id="txtOfficePhoneNo" name="txtOfficePhoneNo"
                                                aria-describedby="inputGroupPrepend">
                                            </div>
                                            <div id="phoneErrorLabel" class="text-danger" style="margin-top: 0.5%; font-weight:bolder; display: none;"></div>
                                        </div>
                              <div class="form-group">
                                <label for="status" style="margin-right: 10%;">Status Bumiputera <span style="color: red;">*</span></label>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="status_bumiputera" id="bumiputera" value="bumiputera" checked required>
                                  <label class="form-check-label" for="bumiputera">Ya</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="status_bumiputera" id="tidak_bumiputera" value="tidak_bumiputera" required>
                                  <label class="form-check-label" for="tidak_bumiputera">Tidak</label>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="oku" style="margin-right: 16%;">Status OKU <span style="color: red;">*&nbsp;</span></label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status_oku" id="oku" value="oku" required>
                                    <label class="form-check-label" for="oku">Ya</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status_oku" id="bukan_oku" value="bukan_oku" checked required>
                                    <label class="form-check-label" for="bukan_oku">Tidak</label>
                                </div>
                            </div>
                              <div class="form-group">
                                <label for="race">Bangsa <span style="color: red;">*</span></label>
                                <select id="race" name="race" class="form-control" required>
                                  <option value="" selected>Pilih Bangsa</option>
                                  @foreach($race as $w)
                                            <option value="{{$w->code}}">{{ $w->name_ms }}</option>                                           
                                        @endforeach	
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="email">Alamat Emel <span style="color: red;">*</span></label>
                                
                                <input type="email"
                                    name="email"
                                    id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', Auth::user()->email) }}">

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror 
                                 <div class="form-group" style="margin-top: 1%;">
                                    <label style="margin-left: 1.5%;" for="notice">
                                        <span style="color: red; text-align: justify; font-weight: bolder; font-size: small;">
                                            Emel ini akan digunakan untuk semua urusan pelesenan. Sila pastikan emel ini sentiasa aktif. Sebarang perubahan emel perlu dikemaskini di bahagian profil.
                                        </span>
                                    </label>
                                </div>
                            </div>
                            </div>
                          </div>
            </div>

            <h6 class="section-title" style="font-weight: bold; font-size: 0.9rem; color: #1070d5; border-bottom: 2px solid #1070d5; padding-bottom: 5px; margin-bottom: 2%; margin-top: 2%;">Dokumen yang Perlu Dimuatnaik</h6>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="salinan_ic" style="font-weight: bolder;">
                            Salinan Kad Pengenalan 
                            <span style="color: red;">*</span>
                        </label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="salinan_ic" name="salinan_ic" required>
                                <label class="custom-file-label" for="salinan_ic">No File Chosen</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h6 class="section-title" style="font-weight: bold; font-size: 0.9rem; color: #1070d5; border-bottom: 2px solid #1070d5; padding-bottom: 5px; margin-bottom: 2%; margin-top: 2%;">Perakuan </h6>
            <div class="row">
            <div class="col-12">
                <div class="form-group mb-0">
                <div class="d-flex align-items-start">
                    <div class="custom-control custom-checkbox mr-2 mt-1">
                    <input type="checkbox" name="terms" class="custom-control-input" id="agree" required />
                    <label class="custom-control-label" for="agree"></label>
                    </div>
                    <p style="font-weight: bold; line-height: 1.2; margin-bottom: 0;">
                    Saya dengan ini mengakui dan mengesahkan bahawa semua maklumat yang diberikan oleh saya adalah benar. Sekiranya terdapat maklumat yang tidak benar, pihak Jabatan Perikanan
                    <span style="display: block; margin-top: 1px; margin-left: -1px padding-left: 40px;">
                        Malaysia (DOF) boleh menolak permohonan saya dan tindakan undang-undang boleh dikenakan ke atas saya.
                    </span>
                    </p>
                </div>
                </div>
            </div>
            </div>
                <br>

  
                          <!-- End of row -->
                          <div class="form-group">
                              <div class="profile-info w-100" style="margin-bottom: -30px;">
                                  <ul class="list-group list-group-unbordered mb-3 w-100" style="margin-top: 20px;">
                                      <li class="list-group-item w-100 d-flex justify-content-center align-items-center" style="border-bottom: none;">
                                          <div style="display: flex; gap: 10px;">
                                              <button type="button" class="btn btn-light scalable back" onclick="history.back();">
                                                  <span>Kembali</span>
                                              </button>
                                              <button type="submit" class="btn btn-success scalable save" name="submit" id="submit" onclick="alert('Hantar Butiran Profil ?');">
                                                  <span>Hantar</span>
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

        $(document).ready(function () {  


            //No Telefon Bimbit - Validation
            $('#txtPhoneNo').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g)|| $(this).val().length >= 10)    
                    return false;                        
            }); 

            //No Telefon Bimbit Tambahan - Validation
            $('#txtPhoneNoSecond').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g)|| $(this).val().length >= 10)    
                    return false;                        
            }); 

            //No Telefon Pejabat - Validation
            $('#txtOfficePhoneNo').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g)|| $(this).val().length >= 10)    
                    return false;                        
            }); 

           $('form').submit(function (e) {
                const phone = $('#txtPhoneNo').val();
                const phoneSecond = $('#txtPhoneNoSecond').val();
                const officePhone = $('#txtOfficePhoneNo').val();
                const errorLabel = document.getElementById("phoneErrorLabel");

                if ((phone && phone.length < 9) || (officePhone && officePhone.length < 9) || (phoneSecond && phoneSecond.length < 9)) {
                    errorLabel.textContent = "Nombor telefon mesti sekurang-kurangnya 10 digit.";
                    errorLabel.style.display = "block";
                    e.preventDefault(); // Prevent form submission
                } else {
                    errorLabel.style.display = "none";
                }
            });

            $('#poskod').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g)|| $(this).val().length >= 5)    
                    return false;                        
            }); 

            $('#secondary_postcode').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g)|| $(this).val().length >= 5)    
                    return false;                        
            }); 

        });

</script>   
<script>
    function redirectToPage(url) {
        window.location.href = url; // Redirect to the specified URL
    }
</script>
<script>
    // Wait for the DOM to load
    document.addEventListener("DOMContentLoaded", function () {
        const icInput = document.getElementById("icno");
        const ageInput = document.getElementById("age");

        // Function to calculate age from IC number
        function calculateAgeFromIC(icNumber) {
            if (!icNumber || icNumber.length < 6) return "";

            const yearPrefix = icNumber.slice(0, 2); // First 2 digits
            const currentYear = new Date().getFullYear();
            let birthYear = parseInt(yearPrefix, 10);

            // Determine if the birth year is in the 1900s or 2000s
            birthYear += birthYear < 30 ? 2000 : 1900;

            // Calculate age
            return currentYear - birthYear;
        }

        // Extract IC value and calculate age
        const icNumber = icInput.value;
        if (icNumber) {
            const age = calculateAgeFromIC(icNumber);
            ageInput.value = age; // Set age in the input field
        }
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
    // Update file label text for any custom input
    document.addEventListener('DOMContentLoaded', function () {
        const fileInputs = document.querySelectorAll('.custom-file-input');
        fileInputs.forEach(input => {
            input.addEventListener('change', function (e) {
                const fileName = input.files[0] ? input.files[0].name : "No File Chosen";
                input.nextElementSibling.textContent = fileName;
            });
        });

        // Preview image update
        const profileInput = document.getElementById('profile-picture');
        const previewImg = document.getElementById('preview-profile-picture');

        if (profileInput && previewImg) {
            profileInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        previewImg.src = event.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });

    function showProcessingIndicator() {
        const processingDiv = document.getElementById('process-img');
        processingDiv.classList.remove('hidden');
    }

    function hideProcessingIndicator() {
        const processingDiv = document.getElementById('process-img');
        processingDiv.classList.add('hidden');
    }
</script>

<script>
    $(document).ready(function () {
        

        // Listen for changes in Parlimen dropdown
        $('#parliament').on('change', function () {
            var parliamentId = $(this).val();

            // Make an AJAX request to fetch the related DUNs
            $.ajax({
                url: '{{ route("profile.get.duns.by.parliament") }}',
                method: 'GET',
                data: { parliament_id: parliamentId },
                success: function (data) {
                    // Clear current DUN options
                    $('#parliament_seat').empty();

                    // Append new DUN options
                    $('#parliament_seat').append('<option value="">Pilih DUN</option>');
                    data.forEach(function (dun) {
                        $('#parliament_seat').append(
                            '<option value="' + dun.id + '">' + dun.parliament_seat_name + '</option>'
                        );
                    });

                }
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

<script>
    // Handle secondary state change to fetch secondary districts
    $('#secondary_state').on('change', function () {
        const negeriCode = $(this).val();

        $.ajax({
            url: '{{ route("profile.get.daerah") }}',
            method: 'GET',
            data: { negeri: negeriCode },
            success: function (data) {
                const $secondaryDistrictSelect = $('#secondary_district');
                $secondaryDistrictSelect.empty().append('<option value="">Pilih Daerah</option>');

                data.forEach(function (daerah) {
                    $secondaryDistrictSelect.append('<option value="' + daerah.code + '">' + daerah.name_ms.toUpperCase() + '</option>');
                });
            },
            error: function (xhr) {
                console.error('Gagal dapatkan daerah (surat-menyurat):', xhr.responseText);
            }
        });
    });
</script>




@endpush
