@extends('layouts.app')

@push('styles')
    <style type="text/css">
    </style>
@endpush

@section('content')
<form id="form-profile-update" method="POST" enctype="multipart/form-data" action="{{ route('profile.maklumatSyarikat') }}">
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
                                    <a class="nav-link active" id="pemegang-saham-tab" data-bs-toggle="tab" onclick="redirectToPage('{{ route('profile.pemilikanPentadbiran', ['company_id' => $company->id]) }}')" role="tab" aria-controls="pemegang-saham" aria-selected="false">
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

                                    <h6 class="section-title" style="font-weight: bold; font-size: 0.9rem; color: #1070d5; border-bottom: 2px solid #1070d5; padding-bottom: 5px; margin-bottom: 2%;">Pemilikan & Pentadbiran</h6>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                            <label>Senarai Pemegang Saham </label>
                                            <div id="shareholder-list" class="table-responsive">
                                                <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                    <th style="width: 5%;">No.</th>
                                                    <th style="width: 55%;">Nama Pemegang Saham</th>
                                                    <th style="width: 25%;">No. Kad Pengenalan</th>
                                                    <th style="width: 15%;">Peratus Saham</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="shareholder mb-3">
                                                    <td class="shareholder-number">1.</td>
                                                    <td>
                                                        <input type="text" name="shareholder_name[]" class="form-control" placeholder="" value="{{ $company ? 'JANIL A/L SHANMUGAM' : '' }}" disabled  {{ !$company ? 'disabled' : '' }}>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="shareholder_ic[]" class="form-control" placeholder="" value="{{ $company ? '870414558279' : '' }}" disabled  {{ !$company ? 'disabled' : '' }}>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="shareholder_percentage[]" class="form-control" placeholder="0%" value="{{ $company ? '50%' : '' }}" disabled  {{ !$company ? 'disabled' : '' }}>
                                                    </td>
                                                    </tr>
                                                    <tr class="shareholder mb-3">
                                                    <td class="shareholder-number">2.</td>
                                                    <td>
                                                        <input type="text" name="shareholder_name[]" class="form-control" placeholder="" value="{{ $company ? 'CHE AZHARI ZIHNI BIN NIK JEMADIN' : '' }}" disabled  {{ !$company ? 'disabled' : '' }}>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="shareholder_ic[]" class="form-control" placeholder="" value="{{ $company ? '950915302561' : '' }}" disabled  {{ !$company ? 'disabled' : '' }}>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="shareholder_percentage[]" class="form-control" placeholder="0%" value="{{ $company ? '50%' : '' }}" disabled  {{ !$company ? 'disabled' : '' }}>
                                                    </td>
                                                    </tr>
                                                    <!-- Repeat additional rows as needed -->
                                                </tbody>
                                                </table>
                                            </div>
                                            <hr>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                            <label>Senarai Pengarah Syarikat </label>
                                            <div id="director-list" class="table-responsive">
                                                <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                    <th style="width: 5%;">No.</th>
                                                    <th style="width: 45%;">Nama Pengarah Syarikat</th>
                                                    <th style="width: 35%;">No. Kad Pengenalan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="director mb-3">
                                                    <td class="director-number">1.</td>
                                                    <td>
                                                        <input type="text" name="director_name[]" class="form-control" placeholder="" value="{{ $company ? 'JANIL A/L SHANMUGAM' : '' }}" disabled  {{ !$company ? 'disabled' : '' }}>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="director_ic[]" class="form-control" placeholder="" value="{{ $company ? '870414558279' : '' }}" disabled  {{ !$company ? 'disabled' : '' }}>
                                                    </td>
                                                    </tr>
                                                </tbody>
                                                </table>
                                            </div>
                                            <hr>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                            <label>Senarai Pemunya Benefisial </label>
                                            <div id="director-list" class="table-responsive">
                                                <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                    <th style="width: 5%;">No.</th>
                                                    <th style="width: 45%;">Nama Pemunya Benefisial</th>
                                                    <th style="width: 35%;">No. Kad Pengenalan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="director mb-3">
                                                    <td class="director-number">1.</td>
                                                    <td>
                                                        <input type="text" name="director_name[]" class="form-control" placeholder="" value="{{ $company ? 'JANIL A/L SHANMUGAM' : '' }}" disabled  {{ !$company ? 'disabled' : '' }}>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="director_ic[]" class="form-control" placeholder="" value="{{ $company ? '870414558279' : '' }}" disabled  {{ !$company ? 'disabled' : '' }}>
                                                    </td>
                                                    </tr>
                                                </tbody>
                                                </table>
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

@endpush
