<!DOCTYPE html>
<html lang="en"  data-layout=horizontal>

<head>
  <!-- Required meta tags -->
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<meta name="author" content="Codescandy" />

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-M8S4MT3EYG"></script>
<script>
	window.dataLayer = window.dataLayer || [];
	function gtag() {
		dataLayer.push(arguments);
	}
	gtag('js', new Date());

	gtag('config', 'G-M8S4MT3EYG');
</script>

<!-- Favicon icon-->
<link rel="shortcut icon" type="image/x-icon" href="../assets/images/favicon/favicon.ico" />

<!-- Color modes -->
<script src="{{ asset('assets/js/vendors/color-modes.js') }}"></script>

<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free/css/all.min.css') }}">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{ asset('template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">
<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<!-- Custom css -->
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/grid.css') }}">
<link rel="stylesheet" href="{{ asset('css/badge.css') }}">

<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/libs/select2/css/select2.min.css') }}">

<!-- =============================================================================================== -->

<!-- Libs CSS -->
<link href="{{ asset('assets/libs/bootstrap-icons/font/bootstrap-icons.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/libs/@mdi/font/css/materialdesignicons.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/libs/simplebar/dist/simplebar.min.css') }}" rel="stylesheet" />

<!-- Theme CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/theme.min.css') }}">

  <!-- Custom CSS -->
  <style>
    textarea { text-transform: uppercase; }
  </style>

  <title>Sistem e-Lesen 2.0</title>
</head>

<body>
  <main id="main-wrapper" class="main-wrapper">


      <div class="header">
	<!-- navbar -->
	<div class="navbar-custom navbar navbar-expand-lg">
		<div class="container-fluid px-0">
			<a class="navbar-brand d-block d-md-none" href="#">
				<img src="{{ asset('images/dof_logo.jpg') }}" height="70" width="140" alt="Image" />
			</a>

			<a class="navbar-brand d-block d-md-none" href="#">
				<img src="{{ asset('assets/images/brand/logo/logo1.png') }}" height="70" width="140" alt="Image" />
			</a>

			<!--Navbar nav -->
			<ul class="navbar-nav navbar-right-wrap ms-lg-auto d-flex nav-top-wrap align-items-center ms-4 ms-lg-0">
				<li>
					<div class="dropdown">
						<button class="btn btn-ghost btn-icon rounded-circle" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
							<i class="bi theme-icon-active"></i>
							<span class="visually-hidden bs-theme-text">Toggle theme</span>
						</button>
						<ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bs-theme-text">
							<li>
								<button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
									<i class="bi theme-icon bi-sun-fill"></i>
									<span class="ms-2">Light</span>
								</button>
							</li>
							<li>
								<button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
									<i class="bi theme-icon bi-moon-stars-fill"></i>
									<span class="ms-2">Dark</span>
								</button>
							</li>
							<li>
								<button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
									<i class="bi theme-icon bi-circle-half"></i>
									<span class="ms-2">Auto</span>
								</button>
							</li>
						</ul>
					</div>
				</li>

			</ul>
		</div>
	</div>
</div>

 <!-- navbar horizontal -->



    <div id="app-content">
      <div class="app-content-area pt-0 ">
        <div class="bg-primary pt-12 pb-21 "></div>
        <div class="container-fluid mt-n22 ">
          <!-- Form -->
          <form method="POST" enctype="multipart/form-data" action="{{ route('complaint.store') }}">
            @csrf
            <input type="hidden" id="hide_aid" name="hide_aid" value="{{ Helper::uuid() }}">
            <div class="row">
              <div class="col-lg-12 col-md-12 col-12">
                  <!-- Page header -->
                  <div class="d-flex justify-content-between align-items-center mb-5">
                      <div class="mb-2 mb-lg-0">
                          <h3 class="mb-0  text-white">Aduan Awam</h3>
                      </div>
                      <div>
                      </div>
                  </div>
              </div>
            </div>
            <div class="row" style="margin-top:25px;">
                <!-- card  -->
                <div class="col-xl-6 col-lg-12 col-md-12 col-12 mb-5 mb-xl-0">
                  <div class="card h-100">
                    <!-- card header  -->
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">BUTIRAN ADUAN </h4>
                    </div>
                    <!-- table  -->
                    <div class="card-body">
                        
                      <div class="form-group">
                        <label for="selComplaintType">Jenis Aduan : <span style="color:red;">*</span></label>
                        <select class="form-select select2" id="selComplaintType" name="selComplaintType" required autocomplete="off">
                          <option value="">-- Sila Pilih --</option>
                          <option value="ID Pengguna">ID Pengguna</option>
                          <option value="Lesen Vesel Penangkapan Ikan">Lesen Vesel Penangkapan Ikan</option>
                          <option value="Elaun Sara Hidup">Elaun Sara Hidup</option>
                          <option value="Aduan Awam">Aduan Awam</option>											
                        </select>
                      </div>
        
                      <div class="form-group">
                        <label for="txtTitle">Tajuk : <span style="color:red;">*</span></label>
                        <input type="text" class="form-control" name="txtTitle" id="txtTitle" value="" required>
                      </div>
        
                      <div class="form-group">
                        <label for="txtDesc">Butiran Aduan : <span style="color:red;">*</span></label>
                        <textarea name="txtDesc" id="txtDesc" class="form-control" rows="7" placeholder="" required></textarea>
                      </div>
        
                      <div class="form-group" style="margin-top:28px;">
                        <label for="">Lampiran : <small>Maksimum Saiz : 5MB</small></label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="fileDoc" name="fileDoc">
                            <label class="custom-file-label" for="fileDoc">Choose file</label>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
                <!-- card  -->
                <div class="col-xl-6 col-lg-12 col-md-12 col-12 mb-5 mb-xl-0">
                    <div class="card h-100">
                        <!-- card header  -->
                        <div class="card-header">
                            <h4 class="mb-0">MAKLUMAT PENGADU </h4>
                        </div>
                        <!-- table  -->
                        <div class="card-body" >
                            
                          <div class="form-group">
                            <label for="txtName">Nama Penuh : <span style="color:red;">*</span></label>
                            <input type="text" class="form-control" name="txtName" id="txtName" value="" required>
                          </div>
                          @error('txtName')
                            <span id="txtName_error" class="text-danger" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
            
                          <!--<div class="form-group">
                            <label for="txtPhoneNo">No. Telefon : <span style="color:red;">*</span></label>
                            <input type="text" class="form-control" name="txtPhoneNo" id="txtPhoneNo" value="" required>
                          </div>-->

                          <div class="mb-3">
                            <label for="txtPhoneNo" class="form-label">No. Telefon Bimbit <small>[ Tanpa(-) ]</small> : <span style="color:red;">*</span></label>
                            <div class="input-group has-validation">
                                <span class="input-group-text" id="inputGroupPrepend">+60</span>
                                <input type="number" class="form-control" id="txtPhoneNo" name="txtPhoneNo"
                                aria-describedby="inputGroupPrepend" required>
                            </div>
                          </div>
            
                          <div class="form-group">
                            <label for="txtEmel">Emel : <span style="color:red;">*</span></label>
                            <input type="email" class="form-control" name="txtEmel" id="txtEmel" value="" required>
                          </div>
                          @error('txtEmel')
                            <span id="txtEmel_error" class="text-danger" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                          <br/><br/>

                          <!-- Success alert -->
                          @if (!empty($return_value))
                            <div class="alert alert-success d-flex align-items-center" role="alert">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle-fill me-2" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                              </svg>
                              <div>
                                Maklumat Aduan Berjaya Dihantar !! No Aduan : <b>#{{ sprintf('%06d', $return_value) }}</b><br/>
                                Maklum balas aduan anda akan dihantar melalui emel yang dimasukkan. Pastikan emel sentiasa aktif.
                              </div>
                            </div>
                          @endif

                          <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                            <a href="{{ route('welcome') }}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-paper-plane"></i> Hantar</button>
                          </div><br/><br/>

                        </div>
                    </div>
                </div>
            </div>
          </form>
          <!-- Close Form -->
        </div>
    </div>
    </div>
  </main>
  <!-- Scripts -->

  <!-- jQuery UI 1.11.4 -->
<script src="{{ asset('template/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>$.widget.bridge('uibutton', $.ui.button)</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>

<!-- jQuery -->
<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('assets/libs/select2/js/select2.full.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/ms-my.min.js"></script>

<script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

<!-- =============================================================================================== -->


  <!-- Libs JS -->

  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/libs/feather-icons/dist/feather.min.js') }}"></script>
  <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
  
  <!-- Theme JS -->
  <script src="{{ asset('assets/js/theme.min.js') }}"></script>

  <script src="{{ asset('assets/libs/jsvectormap/dist/js/jsvectormap.min.js') }}"></script>
  <script src="{{ asset('assets/libs/jsvectormap/dist/maps/world.js') }}"></script>
  <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/js/vendors/chart.js') }}"></script>

  <script type="text/javascript">
  
    bsCustomFileInput.init(); 

    $(document).on('input', "input[type=text]", function () {
        $(this).val(function (_, val) {
            return val.toUpperCase();
        });
    });

</script>

</body>

</html>