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

        body.modal-open {
            overflow: auto !important;
        }
    </style>
@endpush

@section('content')
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
                        <div class="card mb-4">

                            <div class="card-body">
                            <div class="row">
        
        
                <!-- Single Column: Card with Form Inside -->
                <div class="col-lg-12">
                  <div class="card card-primary" style="outline: 2px solid lightgray;">
                    <div class="card-header" style="padding-bottom: 2px;">
                            <h6 style="color: white; font-size: 0.9rem;">PROFIL PENGGUNA</h6>
                        </div>
                
                        <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="overview-tab" data-bs-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Maklumat Am</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link disabled" id="verification-tab" data-bs-toggle="tab" href="#verification" role="tab" aria-controls="verification" aria-selected="false">Pengesahan</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                             <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                                    <h6 class="section-title" style="font-weight: bold; font-size: 0.9rem; color: #1070d5; border-bottom: 2px solid #1070d5; padding-bottom: 5px; margin-bottom: 2%; margin-top: 2%;">Butiran Am Pengguna</h6>
                                    <div class="row">
                                    <div class="col-sm-6">
                              <div class="form-group">
                                <label>Nama Pengguna <span style="color: red;">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ $profile->name ?? '' }}" style="background-color: #F1F2F4" reaadonly >
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>No. Kad Pengenalan  <span style="color: red;">*</span></label>
                                <input type="text" name="icno" class="form-control" value="{{ $profile->icno ?? '' }}" style="background-color: #F1F2F4" reaadonly >
                              </div>
                            </div>
                          </div>

                            <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <!-- Alamat label only -->
                                <label>Alamat Semasa <span style="color: red;">*</span></label>
                                
                                <!-- Input for No Lot/Unit/Rumah -->
                                <input type="text" name="no_lot" class="form-control" placeholder="No Lot/Unit/Rumah" value="{{ $profile->address1 ?? '' }}" style="margin-top: 5px; background-color: #F1F2F4" reaadonly >
                              
                                <!-- Input for Nama/No. Jalan -->
                                <input type="text" name="nama_jalan" class="form-control" placeholder="Nama/No. Jalan" value="{{ $profile->address2 ?? '' }}" style="margin-top: 5px; background-color: #F1F2F4" reaadonly >

                                <!-- Input for Taman/Kampung/Bandar -->
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
                                    <label for="parliament">Parlimen <span style="color: red;">*</span></label>
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
                                    <label for="parliament_seat">DUN <span style="color: red;">*</span></label>
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
                                    @foreach($gender as $f)
                                        <option value="{{ $f->code }}" 
                                            {{ $profile->gender == $f->code ? 'selected' : '' }}>
                                            {{ strtoupper($f->name_ms) }}
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
                                    <span class="input-group-text" id="inputGroupPrepend" 
                                        style="background-color: #E0E0E0; color: #000; border: 1px solid #ced4da; padding: 10px 15px; height: auto;">+60</span>
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
                                        <span class="input-group-text" id="inputGroupPrepend" 
                                        style="background-color: #E0E0E0; color: #000; border: 1px solid #ced4da; padding: 10px 15px; height: auto;">+60</span>
                                        <input type="number" class="form-control" id="txtOfficePhoneNo" name="txtOfficePhoneNo" 
                                        value="{{ isset($profile->no_phone_office) ? substr($profile->no_phone_office, 1) : '' }}" 
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
                                <input type="email" name="email" class="form-control" id="email" value="{{ $profile->email ?? '' }}" readonly>
                              </div> 
                            </div>
                          </div>
                            <br>

                            <br>
                            <h6 class="section-title" style="font-weight: bold; font-size: 0.9rem; color: #1070d5; border-bottom: 2px solid #1070d5; padding-bottom: 5px; margin-bottom: 2%;">Dokumen Pengguna</h6>
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
                                                    data-file="{{ $profile->salinan_ic }}"
                                                    data-backdrop="false">
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
                                              <button class="btn btn-primary" id="go-to-verification" disabled>Seterusnya</button>
                                          </div>
                                      </li>
                                  </ul>
                              </div>
                           </div>
                        </div>

                        <div class="tab-pane fade" id="verification" role="tabpanel" aria-labelledby="verification-tab">
                        <h6 class="section-title" style="font-weight: bold; font-size: 0.9rem; color: #1070d5; border-bottom: 2px solid #1070d5; padding-bottom: 5px; margin-bottom: 2%;  margin-top: 2%;">Pengesahan Profil Pengguna</h6>
                            <form action="{{ route('profile.submitVerification', $profile->id) }}" method="POST">
                                @csrf
                                    <div>
                                        <h5>Segala maklumat tentang pengguna ini adalah :</h5>

                                        <div class="form-group">
                                            <label style="font-weight: 400;">
                                                <input type="radio" name="verify_status" value="1" required> Sah
                                            </label><br>
                                            <label style="font-weight: 400;">
                                                <input type="radio" name="verify_status" value="0" required> Tidak Sah
                                            </label>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label for="ulasan">Ulasan</label>
                                            <textarea name="ulasan" class="form-control" rows="3" required></textarea>
                                        </div>


                                        <div class="form-group">
                                            <div class="profile-info w-100" style="margin-bottom: -30px;">
                                                <ul class="list-group list-group-unbordered mb-3 w-100" style="margin-top: 20px;">
                                                    <li class="list-group-item w-100 d-flex justify-content-center align-items-center" style="border-bottom: none;">
                                                        <div style="display: flex; gap: 10px;">
                                                            <button type="button" class="btn btn-light" id="back-to-overview">
                                                                <span>Kembali</span>
                                                            </button>
                                                            <button type="submit" class="btn btn-success scalable save" name="submit" id="submit" onclick="alert('Hantar pengesahan profil ?');">
                                                                <span>Hantar</span>
                                                            </button>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                            </form>
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

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $("#documentModal").draggable({
        handle: ".modal-header"
    });
});
</script>
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
        const label = input?.nextElementSibling;

        if (input && label) {
            input.addEventListener('change', function (e) {
                const fileName = input.files[0] ? input.files[0].name : "No File Chosen";
                label.textContent = fileName;
            });
        }
    });
</script>



<script>
function showProcessingIndicator() {
    const processingDiv = document.getElementById('process-img');
    processingDiv.classList.remove('hidden'); // Show spinner
}

function hideProcessingIndicator() {
    const processingDiv = document.getElementById('process-img');
    processingDiv.classList.add('hidden'); // Hide spinner
}

</script>
<script>
document.querySelector('.custom-file-input').addEventListener('change', function (e) {
    let fileName = e.target.files[0].name; // Get the selected file name
    e.target.nextElementSibling.innerText = fileName; // Update the label text
});
</script>

<script>
    // Handle Seterusnya button to jump to verification tab
    document.getElementById('go-to-verification').addEventListener('click', function () {
        let tab = new bootstrap.Tab(document.getElementById('verification-tab'));
        tab.show();
    });

    // Handle Kembali button to go back to overview tab
    document.getElementById('back-to-overview').addEventListener('click', function () {
        let tab = new bootstrap.Tab(document.getElementById('overview-tab'));
        tab.show();
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
        } else {
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
        document.addEventListener('DOMContentLoaded', function () {
            const viewDocBtn = document.querySelector('.view-doc-btn');
            const nextBtn = document.getElementById('go-to-verification');
            const verificationTab = document.getElementById('verification-tab');

            viewDocBtn.addEventListener('click', function () {
                // Enable the next button
                nextBtn.disabled = false;

                // Remove 'disabled' class from the tab
                verificationTab.classList.remove('disabled');

                // Optionally scroll to the newly enabled button or tab
                // nextBtn.scrollIntoView({ behavior: 'smooth' });
            });

            // Prevent clicking tab if still disabled
            verificationTab.addEventListener('click', function (e) {
                if (verificationTab.classList.contains('disabled')) {
                    e.preventDefault();
                    alert('Sila rujuk salinan kad pengenalan pengguna terlebih dahulu sebelum membuat pengesahan profil');
                }
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

@endpush
