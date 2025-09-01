@extends('layouts.app')

@push('styles')
    <style type="text/css">
        .form-check-input:disabled {
            opacity: 1; /* Removes the faded effect */
            pointer-events: none; /* Prevents interaction */
        }

        .form-check-label {
            color: black !important; /* Ensures label remains black */
        }
    </style>
@endpush

@section('content')

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
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4" style="width: 100%;max-width: 1100px;">

                            <div class="card-body" style="width: 100%;max-width: 1100px;">
                            <div class="row">
          <div class="col-md-12">
            <div class="card card-primary" style="outline: 2px solid lightgray; height: auto;width: 100%;max-width: 1100px;">
                <div class="card-body box-profile d-flex flex-column flex-md-row align-items-center">
                    <!-- Profile Image -->
                    <div class="d-flex flex-column align-items-center">
                    <div class="profile-image" style="margin-top: 1px; margin-bottom: 10px; max-width: 120px; position: relative;">
                        @if (empty(Auth::user()->profile_picture))
                        <img class="profile-user-img img-fluid img-rectangle"
                            src="{{ asset('/images/avatar.png') }}"
                            alt="User profile picture"
                            style="width: 100%; max-width: 120px; height: auto;">
                        @else
                        <a href="{{ asset('/storage/profile-picture/.original/' . Auth::user()->profile_picture) }}" class="profile-picture">
                            <img class="profile-user-img img-fluid img-rectangle"
                                src="{{ asset('/storage/profile-picture/' . Auth::user()->profile_picture) }}"
                                alt="User profile picture"
                                style="width: 100%; max-width: 120px; height: auto;">
                        </a>

                        <!-- Rotate Button -->
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
                                <label for="profile-picture" class="custom-file-label">{{ empty(Auth::user()->profile_picture) ? __('app.upload_photo') : __('app.upload_new_photo') }}</label>
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
                                <a class="nav-link" id="individu-tab" data-bs-toggle="tab" onclick="redirectToPage('{{ route('profile.handleProfile') }}')" role="tab" aria-controls="individu" aria-selected="true">
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
                                <a class="nav-link active" id="vesel-tab" data-bs-toggle="tab" onclick="redirectToPage('{{ route('profile.veselDarat') }}')" role="tab" aria-controls="" aria-selected="false">
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

                            @if($user_roles_laut ==true || $user_roles_skl ==true)
                            <li class="nav-item">
                                <a class="nav-link" id="syarikat-tab" data-bs-toggle="tab" onclick="redirectToPage('{{ route('profile.maklumatSyarikat') }}')" role="tab" aria-controls="syarikat" aria-selected="false">
                                    Maklumat Syarikat
                                </a>
                            </li>
                            @endif


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
                             <div class="tab-pane fade show active" id="vesel" role="tabpanel" aria-labelledby="vesel-tab">
                             <h6 class="section-title" style="font-weight: bold; font-size: 0.9rem; color: #1070d5; border-bottom: 2px solid #1070d5; padding-bottom: 5px; margin-bottom: 2%;">Butiran Vesel & Jeti Penyimpanan</h6>
                             @if(!$profile || is_null($profile->verified_at))
                                <!-- If verified_at is NULL, hide all input fields and show a message -->
                                <p class="text-black">Tiada maklumat direkodkan.</p>
                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        document.querySelectorAll("input[type='radio'], input[type='text']").forEach(input => {
                                            input.checked = false;
                                            input.value = "";
                                        });
                                    });
                                </script>
                            @else
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label for="ada_vesel" style="margin-right: 10%;">Mempunyai Vesel?</label>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="ada_vesel" id="ada" value="ada" checked disabled>
                                  <label class="form-check-label" for="ada">Ya</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="ada_vesel" id="tiada" value="tiada" disabled>
                                  <label class="form-check-label" for="tiada" >Tidak</label>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>Kenderaan/Pengangkutan</label>
                                <select id="pemilikan1" name="pemilikan[]" class="form-control" disabled>
                                  <option value="" selected>Pilih Kenderaan/Pengangkutan</option>
                                  <option value="nelayan_laut"selected>MOTORSIKAL</option>
                                  <option value="nelayan_darat">Pemohon Lesen Vesel (Nelayan Darat)</option>
                                  <option value="pengusaha_skl">Pengusaha SKL</option>
                                  <option value="pemilik_vesel">Pemilik Vesel</option>
                                  <option value="waris_pentadbir">Waris/Pentadbir Harta</option>
                              </select>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>No. Pendaftaran Vesel</label>
                                <input type="text" name="nama_syarikat" class="form-control" id="ic" value="PAF 2011" disabled>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>Jenis Kulit</label>
                                <select id="kulit" name="kulit" class="form-control" disabled>
                                  <option value="" >Pilih Jenis Kulit</option>
                                  <option value="nelayan_laut" selected>TERPAKAI TEMPATAN</option>
                                  <option value="nelayan_darat">Pemohon Lesen Vesel (Nelayan Darat)</option>
                                  <option value="pengusaha_skl">Pengusaha SKL</option>
                                  <option value="pemilik_vesel">Pemilik Vesel</option>
                                  <option value="waris_pentadbir">Waris/Pentadbir Harta</option>
                              </select>
                              </div>
                            </div>
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label>Butir-butir Vesel</label>
                                <table class="table" style="border: 1px solid 	#D3D3D3; border-collapse: collapse;">
                                    <tbody>
                                      <tr>
                                        <td style="border: 1px solid #D3D3D3;">Panjang (m) :</td>
                                        <td style="border: 1px solid #D3D3D3;">
                                            <input type="number" name="ukuran1" class="form-control" placeholder="" value="12" disabled style="color: black; background-color: white;">
                                        </td>
                                    </tr>                      
                                        <tr>
                                            <td style="border: 1px solid 	#D3D3D3;">Jenama Enjin :</td>
                                            <td style="border: 1px solid 	#D3D3D3;">
                                              <input type="" name="ukuran1" class="form-control" placeholder="" value="YAMAHA" disabled style="color: black; background-color: white;">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid 	#D3D3D3;">Kuasa Kuda (KK) :</td>
                                            <td style="border: 1px solid 	#D3D3D3;">
                                              <input type="number" name="ukuran1" class="form-control" placeholder="" value="25" disabled style="color: black; background-color: white;">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label>Jeti Penyimpanan Vesel (Kg./Kawasan)</label>
                                <input type="text" name="nama_syarikat" class="form-control" id="ic" value="PENGKALAN NELAYAN BAGAN PASIR B" disabled>
                              </div>
                            </div>
                          </div>
                          @endif
                            
                          
                          
                          <!-- End of row -->
                          <div class="form-group">
                              <div class="profile-info w-100" style="margin-bottom: -30px;">
                                  <ul class="list-group list-group-unbordered mb-3 w-100" style="margin-top: 20px;">
                                      <li class="list-group-item w-100 d-flex justify-content-center align-items-center" style="border-bottom: none;">
                                          <div style="display: flex; gap: 10px;">
                                              <button type="button" class="btn btn-light scalable back" onclick="history.back();">
                                                  <span>Kembali</span>
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

            //No Telefon Pejabat - Validation
            $('#txtOfficePhoneNo').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g)|| $(this).val().length >= 10)    
                    return false;                        
            }); 

            $('#poskod').keypress(function (e) { 
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
@endpush
