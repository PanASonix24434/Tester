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
<form id="form-profile-update" method="POST" enctype="multipart/form-data" action="{{ route('profile.updatePenglibatanSyarikat', ['company_id' => $company->id]) }}">
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
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4" style="width: 100%;max-width: 1100px;">

                            <div class="card-body" style="width: 100%;max-width: 1100px;">
                            <div class="row">
        
                <!-- Single Column: Card with Form Inside -->
                <div class="col-lg-12">
                  <div class="card card-primary" style="outline: 2px solid lightgray;">
                    <div class="card-header" style="padding-bottom: 2px;">
                        <h6 style="color: white; font-size: 0.9rem;">
                                {{ $company->company_name ?? 'PROFIL SYARIKAT' }}
                        </h6>
                        </div>
                
                        <div class="card-body">
                        <ul class="nav nav-tabs" id="tabMenu" role="tablist">
                        <li class="nav-item">
                                    <a class="nav-link" id="maklumat-am-tab" data-bs-toggle="tab" onclick="redirectToPage('{{ route('profile.maklumatSyarikat', ['company_id' => $company->id]) }}')"  role="tab" aria-controls="maklumat-am" aria-selected="true">
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
                                    <a class="nav-link active" id="penglibatan-tab" data-bs-toggle="tab" onclick="redirectToPage('{{ route('profile.penglibatanSyarikat', ['company_id' => $company->id]) }}')" role="tab" aria-controls="penglibatan" aria-selected="false">
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


                                    <h6 class="section-title" style="font-weight: bold; font-size: 0.9rem; color: #1070d5; border-bottom: 2px solid #1070d5; padding-bottom: 5px; margin-bottom: 2%;">Penglibatan Dalam Industri Perikanan Sedia Ada</h6>
                                    <div class="form-group">
                                    <label>Pernah Terlibat dalam Industri Perikanan? <span style="color: red;">*</span></label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="penglibatan" id="pernah_terlibat" value="pernah_terlibat"
                                            {{ $penglibatan_exists && isset($bil_vesel) && $bil_vesel >= 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="pernah_terlibat" style="color: black;">Ya</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="penglibatan" id="tidak_terlibat" value="tidak_terlibat"
                                            {{ !$penglibatan_exists || empty($bil_vesel) || $bil_vesel == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak_terlibat" style="color: black;">Tidak</label>
                                    </div>
                                </div>

                                <!-- Content to be shown only if 'Ya' is selected -->
                                <div id="industry-involvement" style="display: {{ $penglibatan_exists && isset($bil_vesel) && $bil_vesel >= 1 ? 'block' : 'none' }};">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="bilangan_vesel">Bilangan Vesel Berdaftar <span style="color: red;">*</span></label>
                                                <input type="text" name="bilangan_vesel" class="form-control" id="bilangan_vesel" value="{{ $bil_vesel ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Industri Huluan/Hiliran Perikanan <span style="color: red;">*</span></label>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="pemprosesan" name="industri[]" value="1"
                                                            @if(in_array(1, $jenis_industri ?? [])) checked @endif>
                                                        <label class="form-check-label" for="pemprosesan" style="color: black;">Pemprosesan</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                        <input class="form-check-input" type="checkbox" id="limbungan" name="industri[]" value="2"
                                                            @if(in_array(2, $jenis_industri ?? [])) checked @endif>
                                                        <label class="form-check-label" for="limbungan" style="color: black;">Limbungan</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                        <input class="form-check-input" type="checkbox" id="kilang_ais" name="industri[]" value="3"
                                                            @if(in_array(3, $jenis_industri ?? [])) checked @endif>
                                                        <label class="form-check-label" for="kilang_ais" style="color: black;">Kilang Ais</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                        <input class="form-check-input" type="checkbox" id="bilik_sejuk" name="industri[]" value="4"
                                                            @if(in_array(4, $jenis_industri ?? [])) checked @endif>
                                                        <label class="form-check-label" for="bilik_sejuk" style="color: black;">Bilik Sejuk</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-check mt-2">
                                                        <input class="form-check-input" type="checkbox" id="pemborong_perikanan" name="industri[]" value="5"
                                                            @if(in_array(5, $jenis_industri ?? [])) checked @endif>
                                                        <label class="form-check-label" for="pemborong_perikanan" style="color: black;">Pemborong Perikanan</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                        <input class="form-check-input" type="checkbox" id="peruncitan_perikanan" name="industri[]" value="6"
                                                            @if(in_array(6, $jenis_industri ?? [])) checked @endif>
                                                        <label class="form-check-label" for="peruncitan_perikanan" style="color: black;">Peruncitan Perikanan</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                        <input class="form-check-input" type="checkbox" id="lain_lain" name="industri[]" value="7"
                                                            @if(in_array(7, $jenis_industri ?? [])) checked @endif>
                                                        <label class="form-check-label" for="lain_lain" style="color: black;">Lain-lain</label>
                                                        </div>
                                                        <!-- Additional input for "Lain-lain" -->
                                                        <input type="text" id="lain_lain_input" name="lain_lain_input" class="form-control mt-2" placeholder="Sila nyatakan"
                                                            value="{{ $industri_lain }}" style="display: @if(in_array(7, $jenis_industri)) block @else none @endif;" >
                                                    </div>
                                                </div>
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
                                             <button type="submit" class="btn btn-success scalable save" name="submit" id="submit" onclick="alert('Kemaskini Penglibatan Syarikat ?');">
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
<script>
  // Show input field if "Lain-lain" is checked
  document.getElementById('lain_lain').addEventListener('change', function() {
    var lainLainInput = document.getElementById('lain_lain_input');
    if (this.checked) {
      lainLainInput.style.display = 'block';
    } else {
      lainLainInput.style.display = 'none';
    }
  });
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    function toggleIndustryInvolvement() {
        let pernahTerlibat = document.getElementById("pernah_terlibat").checked;
        let industrySection = document.getElementById("industry-involvement");

        if (pernahTerlibat) {
            industrySection.style.display = "block";
        } else {
            industrySection.style.display = "none";
        }
    }

    // Run on page load to apply initial state
    toggleIndustryInvolvement();

    // Add event listeners to both radio buttons
    document.getElementById("pernah_terlibat").addEventListener("change", toggleIndustryInvolvement);
    document.getElementById("tidak_terlibat").addEventListener("change", toggleIndustryInvolvement);
});
</script>
@endpush
