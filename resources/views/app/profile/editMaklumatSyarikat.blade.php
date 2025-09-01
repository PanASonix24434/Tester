@extends('layouts.app')

@push('styles')
    <style type="text/css">
    </style>
@endpush

@section('content')
<form id="form-profile-update" method="POST" enctype="multipart/form-data" action="{{ route('profile.updateMaklumatSyarikat', ['id' => $company->id]) }}">
    @csrf
    <div id="app-content">

        <!-- Container fluid -->
        <div class="app-content-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <!-- Page header -->
                    <div class="mb-5">
                        <h3 class="">Profil Syarikat</h3>
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
        
                <!-- Single Column: Card with Form Inside -->
                <div class="col-lg-12">
                  <div class="card card-primary" style="outline: 2px solid lightgray;">
                    <div class="card-header" style="padding-bottom: 2px;">
                            <h6 style="color: white; font-size: 0.9rem;">PROFIL SYARIKAT</h6>
                        </div>
                
                        <div class="card-body">
                        <div class="tab-content" id="tabContent">
                            <!-- Maklumat Syarikat Content -->
                             <div class="tab-pane fade show active" id="syarikat" role="tabpanel" aria-labelledby="syarikat-tab">
                             <ul class="nav nav-tabs mt-1" id="nestedTabMenu" role="tablist">
                             <li class="nav-item">
                                    <a class="nav-link active" id="maklumat-am-tab" data-bs-toggle="tab" onclick="redirectToPage('{{ route('profile.maklumatSyarikat', ['company_id' => $company->id]) }}')" role="tab" aria-controls="maklumat-am" aria-selected="true">
                                        Butiran Am
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pendaftaran-tab" data-bs-toggle="tab" onclick="redirectToPage('{{ route('profile.pendaftaranPerniagaan', ['company_id' => $company->id]) }}')" role="tab" aria-controls="pendaftaran" aria-selected="false">
                                        Pendaftaran Perniagaan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pemegang-saham-tab" data-bs-toggle="tab" onclick="redirectToPage('{{ route('profile.pemilikanPentadbiran', ['company_id' => $company->id]) }}')" role="tab" aria-controls="pemegang-saham" aria-selected="false">
                                        Pemilikan & Pentadbiran
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="penglibatan-tab" data-bs-toggle="tab" onclick="redirectToPage('{{ route('profile.penglibatanSyarikat', ['company_id' => $company->id]) }}')" role="tab" aria-controls="penglibatan" aria-selected="false">
                                        Penglibatan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="butiran-kewangan-tab" data-bs-toggle="tab" onclick="redirectToPage('{{ route('profile.kewanganSyarikat', ['company_id' => $company->id]) }}')" role="tab" aria-controls="butiran-kewangan" aria-selected="false">
                                        Butiran Kewangan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="dokumen-tab" data-bs-toggle="tab" onclick="redirectToPage('{{ route('profile.dokumenSyarikat', ['company_id' => $company->id]) }}')" role="tab" aria-controls="dokumen" aria-selected="false">
                                        Dokumen
                                    </a>
                                </li>
                            </ul>
                            <br>

                                    <h6 class="section-title" style="font-weight: bold; font-size: 0.9rem; color: #1070d5; border-bottom: 2px solid #1070d5; padding-bottom: 5px; margin-bottom: 2%;">Butiran Am Syarikat</h6>
                                        <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                            <label>Nama Pemilik Vesel (Syarikat/Koperasi/Persatuan) </label>
                                            <input type="text" name="company_name" class="form-control" id="company_name" value="{{ $company_name ?? '' }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                    <!-- Alamat label only -->
                                                    <label>Alamat Semasa </label>
                                                    
                                                    <!-- Input for No Lot/Unit/Rumah -->
                                                    <input type="text" name="company_address1" class="form-control" id="company_address1" value="{{ $company_address1 ?? '' }}" readonly>
                                                
                                                    <!-- Input for Nama/No. Jalan -->
                                                    <input type="text" name="company_address2" class="form-control" id="company_address2" value="{{ $company_address2 ?? '' }}" readonly>

                                                    <!-- Input for Taman/Kampung/Bandar -->
                                                    <input type="text" name="company_address3" class="form-control" id="company_address3" value="{{ $company_address3 ?? '' }}" readonly>
                                                </div>
                                                    
                                                <div class="form-group">
                                                    <label>Poskod </label>
                                                    <input type="text" name="poskod" class="form-control" id="poskod" value="{{ $poskod ?? '' }}" readonly>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label>Daerah </label>
                                                    <input type="text" name="district" class="form-control" id="district" value="{{ $district ?? '' }}" readonly>
                                                </div>
                                            
                                                <div class="form-group">
                                                    <label for="negeri">Negeri </label>
                                                    <select id="negeri" name="negeri" class="form-control" style="background-color: #F1F2F4" disabled>
                                                        <option value="" {{ $state_code === null ? 'selected' : '' }}></option> <!-- Default option if state_code is null -->
                                                        @foreach($states as $state)
                                                            <option value="{{ $state->code }}" 
                                                                {{ $state_code == $state->code ? 'selected' : '' }}>
                                                                {{ strtoupper($state->name_ms) }} <!-- Display state name -->
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="ownership">Kategori Pemilikan </label>
                                                <select id="ownership" name="ownership" class="form-control" disabled>
                                                    <option value="" {{ $ownership_code === null ? 'selected' : '' }}></option> 
                                                    @foreach($ownerships as $ownership)
                                                        <option value="{{ $ownership->code }}" 
                                                            {{ $ownership_code == $ownership->code ? 'selected' : '' }}>
                                                            {{ strtoupper($ownership->name_ms) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="status" style="margin-right: 10%;">Status Bumiputera </label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="status_bumiputera" id="bumiputera" value="bumiputera" 
                                                        {{ $bumiputera_status === 1 ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="bumiputera">Ya</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="status_bumiputera" id="tidak_bumiputera" value="tidak_bumiputera" 
                                                        {{ $bumiputera_status === 0 ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="tidak_bumiputera">Tidak</label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtPhoneNo" class="form-label">No. Telefon Bimbit : </label>
                                                <div class="input-group has-validation" style="margin-top: 5px;">
                                                    <span class="input-group-text" id="inputGroupPrepend">+60</span>
                                                    <input type="number" class="form-control" id="txtPhoneNo" name="txtPhoneNo" 
                                                        value="{{ isset($company->no_phone) ? substr($company->no_phone, 2) : '' }}" 
                                                        aria-describedby="inputGroupPrepend">
                                                </div>
                                            </div> 
                                                 

                                            <div class="form-group">
                                                <label for="txtPhoneNoOffice" class="form-label">No. Telefon Pejabat : </label>
                                                <div class="input-group has-validation" style="margin-top: 5px;">
                                                    <span class="input-group-text" id="inputGroupPrepend">+60</span>
                                                    <input type="number" class="form-control" id="txtPhoneNoOffice" name="txtPhoneNoOffice" 
                                                        value="{{ isset($company->no_phone_office) ? substr($company->no_phone_office, 2) : '' }}"
                                                        aria-describedby="inputGroupPrepend">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                            <label for="fax">No. Faks</label>
                                            <input type="text" name="fax" class="form-control" id="fax" value="{{ $fax ?? '' }}" >
                                            </div>   
                                            <div class="form-group">
                                            <label for="email">Alamat Emel (Pejabat) </label>
                                            <input type="text" name="email" class="form-control" id="email" value="{{ $email ?? '' }}" >
                                            <div class="form-group"style="margin-top: 1%;">
                                                <label style="margin-left: 1.5%;"for="notice"><span style="color: red; text-align: justify; font-weight:bolder; font-size: small;">Emel ini akan digunakan untuk semua urusan pelesenan. Sila pastikan emel ini sentiasa aktif. Sebarang perubahan emel perlu dikemaskini di bahagian profil syarikat.</span></label>
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
                                              <button type="submit" class="btn btn-success scalable save" name="submit" id="submit" onclick="alert('Kemaskini Butiran Am Syarikat ?');">
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
<script>
    $(document).ready(function() {
        $("#form-profile-update").submit(function() {
            $(this).find(":disabled").prop("disabled", false);
        });
    });
</script>
<script type="text/javascript">

        $(document).on('input', "input[type=text]:not(#email)", function () {
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

@endpush
