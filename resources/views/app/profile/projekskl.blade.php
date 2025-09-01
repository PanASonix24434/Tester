@extends('layouts.app')

@push('styles')
    <style type="text/css">
    </style>
@endpush

@section('content')

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
          <div class="col-md-12">
            <div class="card card-primary" style="outline: 2px solid lightgray;">
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
                                <a class="nav-link active" id="skl-tab" data-bs-toggle="tab" onclick="redirectToPage('{{ route('profile.projekskl') }}')" role="tab" aria-controls="skl" aria-selected="false">
                                    Lesen SKL
                                </a>
                            </li>
                            @endif
                        </ul>
                        <br>

                        <div class="tab-content" id="tabContent">
                            <!-- Maklumat Individu Content -->
                             <div class="tab-pane fade show active" id="skl" role="tabpanel" aria-labelledby="skl-tab">
                             <h6 class="section-title" style="font-weight: bold; font-size: 0.9rem; color: #1070d5; border-bottom: 2px solid #1070d5; padding-bottom: 5px; margin-bottom: 2%;">Butiran Projek Sistem Kultur Laut (SKL)</h6>                          
                             @if(!$profile || is_null($profile->verify_status) || $profile->verify_status == 0)
   			     <!-- If verify_status is NULL or 0, hide all input fields and show a message -->
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
                                <div class="col-sm-12 table-responsive">
                                    <table class="table table-bordered table-striped mt-3 w-100">
                                        <thead style="background-color: #F0F8FF;">
                                            <tr>
                                                <th>Bil</th>
                                                <th>No. Lesen SKL</th>
                                                <th>Jenis Sistem <br>Kultur Laut</th>
                                                <th>Jenis Ternakan</th>
                                                <th>Tarikh Tamat <br>Lesen</th>
                                                <th>Keluasan <br>(hectar/m²)</th>
                                                <th>Lokasi</th>
                                                <th>Salinan Lesen SKL</th>
                                            </tr>
                                        </thead>
                                        <tbody id="sklTableBody">
                                            <tr>
                                                <td>1</td>
                                                <td>
                                                    <input type="text" name="noLesen[]" class="form-control" style="width: 150px;" value="AQL 32721" disabled>
                                                </td>
                                                <td>
                                                    <input type="text" name="jenisSistem[]" class="form-control" style="width: 200px;" value="Sistem Rakit" disabled>
                                                </td>
                                                <td>
                                                    <input type="text" name="jenisTernakan[]" class="form-control" style="width: 200px;" value="Ikan Kerapu" disabled>
                                                </td>
                                                <td>
                                                    <input type="date" name="tarikhTamat[]" class="form-control" style="width: 150px;" value="2025-12-31" disabled>
                                                </td>
                                                <td>
                                                    <input type="text" name="keluasan[]" class="form-control" style="width: 100px;" value="2.5" disabled>
                                                </td>
                                                <td>
                                                    <div class="mb-2">
                                                        <label>Longitud</label>
                                                        <input type="text" name="longitud[]" class="form-control" style="width: 120px;" placeholder="Longitud" value="38.895" disabled>
                                                    </div>
                                                    <div>
                                                        <label>Latitud</label>
                                                        <input type="text" name="latitud[]" class="form-control" style="width: 120px;" placeholder="Latitud" value="-77.0364" disabled>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#" 
                                                    class="btn btn-link view-doc-btn" 
                                                    data-toggle="modal" 
                                                    data-target="#documentModal" 
                                                    data-file="salinan_lesen_skl.pdf"
                                                    style="text-decoration: none; color: #007bff; padding: 0; border: none;">
                                                    LESEN_SKL.pdf
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br>
                                </div>
                                @endif
                            </div>
                            
                
            </div>
                            
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
                                            <canvas id="imageCanvas" style="max-width: 100%; display: none;"></canvas>
                                            </div>
                                            <div class="modal-footer">
                                            <a id="enlargeBtn" target="_blank" class="btn btn-info">Paparan Skrin Penuh</a>
                                            <a id="downloadBtn" class="btn btn-primary" download>Muat Turun</a>
                                             <!-- <button id="printBtn" class="btn btn-primary">Cetak</button> -->

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
                                              <!---<button type="submit" class="btn btn-success scalable save" name="submit" id="submit" onclick="alert('Kemaskini Profil ?');">
                                                  <span>Kemaskini</span>
                                              </button>
                                              <button type="button" id="addRowBtn" class="btn btn-primary"><span>Tambah</span></button>  -->
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
    document.getElementById("addRowBtn").addEventListener("click", function () {
        const tableBody = document.getElementById("sklTableBody");

        // Create a new row
        const rowCount = tableBody.rows.length + 1;
        const newRow = document.createElement("tr");

        newRow.innerHTML = `
            <td>${rowCount}</td>
            <td><input type="text" name="noLesen[]" class="form-control" placeholder="No. Lesen SKL" required></td>
            <td><input type="text" name="jenisSistem[]" class="form-control" placeholder="Jenis Sistem Kultur Laut" required></td>
            <td><input type="text" name="jenisTernakan[]" class="form-control" placeholder="Jenis Ternakan" required></td>
            <td><input type="date" name="tarikhTamat[]" class="form-control" required></td>
            <td><input type="text" name="keluasan[]" class="form-control" placeholder="Keluasan" required></td>
            <td>
                <div class="form-group mb-2">
                    <label>Longitud</label>
                    <input type="text" name="longitud[]" class="form-control" placeholder="Longitud" required>
                </div>
                <div class="form-group">
                    <label>Latitud</label>
                    <input type="text" name="latitud[]" class="form-control" placeholder="Latitud" required>
                </div>
            </td>
        `;

        // Append the new row to the table body
        tableBody.appendChild(newRow);
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.view-doc-btn').forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault(); // Prevent the link from navigating

            const fileName = this.getAttribute('data-file');
            const fileUrl = `/storage/lesen_skl/${fileName}`;
            const fileExtension = fileName.split('.').pop().toLowerCase();

            // Get the correct document title from the 8th column (Salinan Lesen SKL)
            let documentTitle = "Dokumen Tidak Dikenali";
            const titleElement = document.querySelector('thead th:nth-child(8)');
            if (titleElement) {
                documentTitle = titleElement.textContent.trim();
            }

            // Update modal title, iframe, enlarge, and download button links
            document.getElementById('documentModalLabel').innerText = documentTitle;
            document.getElementById('documentViewer').src = fileUrl;
            document.getElementById('enlargeBtn').href = fileUrl;
            document.getElementById('downloadBtn').href = fileUrl;
            document.getElementById('downloadBtn').download = fileName;

            const pdfViewer = document.getElementById('documentViewer');
            const imageCanvas = document.getElementById('imageCanvas');
            const ctx = imageCanvas.getContext("2d");

            if (fileExtension === "pdf") {
                // Handle PDFs
                pdfViewer.src = fileUrl;
                pdfViewer.style.display = "block";
                imageCanvas.style.display = "none";
            } else if (["jpg", "jpeg", "png"].includes(fileExtension)) {
                // Handle Images
                const img = new Image();
                img.src = fileUrl;
                img.onload = function () {
                    imageCanvas.width = img.naturalWidth;
                    imageCanvas.height = img.naturalHeight;
                    ctx.drawImage(img, 0, 0, img.naturalWidth, img.naturalHeight);

                    // Apply watermark
                    ctx.font = "bold 50px Arial";
                    ctx.fillStyle = "rgba(255, 0, 0, 0.3)";
                    ctx.textAlign = "center";
                    ctx.fillText("CONFIDENTIAL", img.naturalWidth / 2, img.naturalHeight / 2);
                };
                pdfViewer.style.display = "none";
                imageCanvas.style.display = "block";
            }

            // Show the modal manually
            const modal = new bootstrap.Modal(document.getElementById('documentModal'));
            modal.show();
        });
    });
});
</script>
<script>
document.getElementById("printBtn").addEventListener("click", function () {
    const fileName = "salinan_lesen_skl.pdf"; // Change this if needed
    const fileUrl = `/storage/lesen_skl/${fileName}`; // Adjust path accordingly
    const logoUrl = "/storage/dof_logo.png"; // Update with actual DOF logo path

    const newWindow = window.open("", "_blank");
    newWindow.document.write(`
        <html>
        <head>
            <title>Print</title>
            <style>
                @media print {
                    body {
                        margin: 0;
                        padding: 0;
                    }
                    .watermark {
                        position: fixed;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                        text-align: center;
                        font-size: 30px;
                        font-weight: bold;
                        color: rgba(0, 0, 0, 0.5); /* 50% transparency */
                        z-index: 9999;
                        pointer-events: none;
                        white-space: nowrap;
                    }
                    .watermark img {
                        width: 150px; /* Adjust as needed */
                        height: auto;
                        opacity: 0.5; /* 50% transparency */
                        display: block;
                        margin: 0 auto;
                    }
                    iframe {
                        width: 100vw;
                        height: 100vh;
                        border: none;
                    }
                }
                body {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                    background-color: white;
                }
                .watermark {
                    position: fixed;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    text-align: center;
                    font-size: 30px;
                    font-weight: bold;
                    color: rgba(0, 0, 0, 0.5); /* 50% transparency */
                    z-index: 9999;
                    pointer-events: none;
                    white-space: nowrap;
                }
                .watermark img {
                    width: 150px; /* Adjust as needed */
                    height: auto;
                    opacity: 0.5; /* 50% transparency */
                    display: block;
                    margin: 0 auto;
                }
                iframe {
                    width: 100%;
                    height: 100%;
                    border: none;
                }
            </style>
        </head>
        <body>
            <div class="watermark">
                <img src="${logoUrl}" alt="DOF Logo">
                <p>Hak Milik Jabatan Perikanan Malaysia</p>
            </div>
            <iframe src="${fileUrl}" onload="this.contentWindow.focus(); this.contentWindow.print();"></iframe>
        </body>
        </html>
    `);
    newWindow.document.close();
});

</script>
<script>
require_once('vendor/tecnickcom/tcpdf/tcpdf.php');

$filePath = 'storage/lesen_skl/salinan_lesen_skl.pdf'; // Path to your PDF
$watermarkText = "Hak Milik Jabatan Perikanan Malaysia";
$watermarkImage = 'storage/dof_logo.png'; // Path to DOF logo

$pdf = new TCPDF();
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage();

// Import existing PDF
$pageCount = $pdf->setSourceFile($filePath);
for ($i = 1; $i <= $pageCount; $i++) {
    $tplId = $pdf->importPage($i);
    $pdf->useTemplate($tplId, 0, 0);

    // Add watermark text
    $pdf->SetFont('Helvetica', 'B', 30);
    $pdf->SetTextColor(255, 0, 0, 50); // 50% transparent red
    $pdf->SetXY(30, 140);
    $pdf->Cell(0, 0, $watermarkText, 0, 1, 'C', false);

    // Add watermark image
    $pdf->Image($watermarkImage, 70, 100, 100, 100, '', '', '', true, 150);
}

// Save the new PDF
$watermarkedFilePath = 'storage/lesen_skl/watermarked_salinan_lesen_skl.pdf';
$pdf->Output($watermarkedFilePath, 'F'); // Save to file

// Serve the file
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="watermarked.pdf"');
readfile($watermarkedFilePath);
</script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
@endpush
