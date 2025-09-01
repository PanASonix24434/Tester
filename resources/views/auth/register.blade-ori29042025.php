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

    <!-- ===================================================================== -->
    <!-- Color modes -->
    <script src="{{ asset('assets/js/vendors/color-modes.js') }}"></script>

    <!-- Libs CSS -->
    <link href="{{ asset('assets/libs/bootstrap-icons/font/bootstrap-icons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/libs/@mdi/font/css/materialdesignicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/libs/simplebar/dist/simplebar.min.css') }}" rel="stylesheet" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/theme.min.css') }}">

    <!-- ===================================================================== -->

  <title>Sistem eLesen 2.0</title>
</head>

<body>
  <main id="main-wrapper" class="main-wrapper">

    <div class="header">
        <!-- navbar -->
        <div class="navbar-custom navbar navbar-expand-lg">
            <div class="container-fluid px-0">
                <a class="navbar-brand d-block d-md-none" href="{{ route('welcome') }}">
                    <img src="{{ asset('images/jata_login.jpg') }}" alt="Image" width="350px" />
                </a>

                <!--Navbar nav -->
                <ul class="navbar-nav navbar-right-wrap ms-lg-auto d-flex nav-top-wrap align-items-center ms-4 ms-lg-0">
                    <li>
                        <a class="navbar-brand d-block d-md-none" href="#">
                            <img src="{{ asset('images/icon_soalanlazim.png') }}" alt="Image" width="60px" height="50px" />
                        </a>
                    </li>
                    <li>
                        <a class="navbar-brand d-block d-md-none" href="#">
                            <img src="{{ asset('images/icon_maklumbalas.png') }}" alt="Image" width="60px" height="50px" />
                        </a>
                    </li>
                    <li>
                        <a class="navbar-brand d-block d-md-none" href="#">
                            <img src="{{ asset('images/icon_hubungikami.png') }}" alt="Image" width="60px" height="50px" />
                        </a>
                    </li>
                    <li>
                        <a class="navbar-brand d-block d-md-none" href="#">
                            <img src="{{ asset('images/icon_petalaman.png') }}" alt="Image" width="60px" height="50px" />
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div id="app-content" style="background-image:url({{ asset('images/bg_login.jpg') }}); 
                background-position: center center;
                background-repeat: no-repeat;
                background-size: cover;
                height: 100%;
                width: 100%;">
      <div class="app-content-area pt-0 ">
        <div class="pt-12 pb-21 "></div>
        <div class="container-fluid mt-n22 ">

            <div class="row">
                {{-- <div class="col-12 col-md-8 col-lg-6 col-xxl-4 py-8 py-xl-0"> --}}
                <div class="col-5">
                <!-- Card -->
					<div class="card smooth-shadow-md">
						<!-- Card body -->
						<div class="card-body p-6">

                            <div class="mb-6 text-center" style="margin-top:-10px;">
                                <img src="{{ asset('images/jata.png') }}" alt="Jata" height="50" width="90">&nbsp;&nbsp;
                                <img src="{{ asset('images/dof_logo.jpg') }}" alt="DOF Logo" height="50" width="90">
							</div>

							<!-- Form -->
							<form id="form-register" method="POST" action="{{ route('register') }}">
                                @csrf

                                <!-- User Type -->
								<div class="mb-3">
                                    <label class="form-label" for="selectOne">Sila Pilih Jenis Pengguna : <span style="color:red;">*</span></label>
									<select class="form-select select2" id="selUserType" name="selUserType" required autocomplete="off" height="100%">
                                        <option value="">{{ __('app.please_select_user_type')}}</option>
                                        @foreach($userTypes as $ut)
                                            <option value="{{$ut->code}}">{{ (App::getLocale() == 'en') ? $ut->name : $ut->name_ms }}</option>                                           
                                        @endforeach	
                                    </select>
								</div>

								<!-- Username -->
								<div class="mb-3">
									<label for="username" class="form-label">No. Kad Pengenalan ( Tanpa '-' ) : <span style="color:red;">*</span></label>
									<input type="username" id="username" class="form-control" name="username" required="" maxlength="12" />
                                    <label id="errUsername" class="form-label" style="color:red; display:none;">Sila masukkan 12 digit No. Kad Pengenalan.</label>
								</div>
                                @error('username')
                                    <span id="username_error" class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <!-- Username -->
								<div class="mb-3">
									<label for="name" class="form-label">Nama Penuh ( Mengikut Kad Pengenalan ) : <span style="color:red;">*</span></label>
									<input type="text" id="name" class="form-control" name="name" required="" />
                                    <label id="errName" class="form-label" style="color:red; display:none;">Sila masukkan Nama Penuh.</label>
								</div>

                                <!-- Email -->
								<div class="mb-3">
									<label for="email" class="form-label">Emel : <span style="color:red;">*</span></label>
									<input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" required="" />
                                    <label class="form-label" style="color:red">Emel ini akan digunakan untuk semua urusan pelesenan. Sila pastikan emel ini sentiasa aktif.</label>
                                    <label id="errEmail" class="form-label" style="color:red; display:none;">Emel yang dimasukkan tidak mengikut format yang sah.</label>
                                    @error('email')
                                    <span id="email_error" class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
								</div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Kata Laluan : 
                                        <i class="fa fa-info-circle" style="font-size:18px;color:green" data-bs-toggle="tooltip" data-placement="top" 
                                        title="Panjang minimum 12 Aksara, Minimum 1 Huruf Kecil, 1 Huruf Besar, 1 Nombor, 1 Simbol">
                                        </i> <span style="color:red;">*</span>
                                    </label>
                                </div>
                                <div class="input-group mt-3" >
                                    <input style="margin-top:-10px;" type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="">
                                    <div class="input-group-append" style="margin-top:-10px;">                           
                                        <div class="input-group-text">
                                            <i  class="far fa-eye" id="togglePassword" style="cursor: pointer;"></i>
                                        </div>
                                    </div>
                                </div>
                                @error('password')
                                <span id="password_error" class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <!-- Password Confirmation -->
                                <div class="mb-3" style="margin-top:10px;">
                                    <label for="password_confirmation" class="form-label">Pengesahan Kata Laluan : 
                                        <i class="fa fa-info-circle" style="font-size:18px;color:green" data-bs-toggle="tooltip" data-placement="top" 
                                        title="Panjang minimum 12 Aksara, Minimum 1 Huruf Kecil, 1 Huruf Besar, 1 Nombor, 1 Simbol">
                                        </i> <span style="color:red;">*</span>
                                    </label>
                                </div>
                                <div class="input-group mt-3" >
                                    <input style="margin-top:-10px;" id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required placeholder="">
                                    <div class="input-group-append" style="margin-top:-10px;">                           
                                        <div class="input-group-text">
                                            <i  class="far fa-eye" id="togglePassword1" style="cursor: pointer;"></i>
                                        </div>
                                    </div>
                                </div>
                                @error('password_confirmation')
                                <span id="password_confirmation_error" class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <br/>
                                <div>
									<!-- Button -->
									<div class="d-grid">
										<button type="submit" class="btn btn-primary">Daftar Pengguna</button>
									</div>

									<div class="d-md-flex justify-content-between mt-4">
										<div class="mb-2 mb-md-0">
											<a href="{{ route('login') }}" class="fs-5">Log Masuk</a>
										</div>
										<div>

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
  </main>

    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('template/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>$.widget.bridge('uibutton', $.ui.button)</script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <!--<script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>-->

    <!-- jQuery -->
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('assets/libs/select2/js/select2.full.min.js') }}"></script>

  <!-- ================================================================================== -->
  <!-- Scripts -->
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

  <script src="{{ asset('template/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
  <script type="text/javascript">

    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
          
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        //No Kad Pengenalan
        $('#username').keypress(function (e) { 
            var charCode = (e.which) ? e.which : event.keyCode    
            if (String.fromCharCode(charCode).match(/[^0-9]/g)|| $(this).val().length >= 12)    
                return false;                        
        }); 
            
        //Nama Penuh
        $('#name').keypress(function (e) { 
            var charCode = (e.which) ? e.which : event.keyCode    
            if ( String.fromCharCode(charCode).match(/[a-zA-Z@' ]/g) ){

            }
            else{
                return false; 
            }    
                                           
        }); 
          
    });

    const inputName = document.getElementById("name");

    inputName.addEventListener("keyup", function(event) {
        event.preventDefault();
        inputName.value = inputName.value.toUpperCase();
    });

    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
    });

    const togglePassword1 = document.querySelector('#togglePassword1');
    const password_confirmation = document.querySelector('#password_confirmation');

    togglePassword1.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = password_confirmation.getAttribute('type') === 'password' ? 'text' : 'password';
        password_confirmation.setAttribute('type', type);
        // toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
    });

  </script>

</body>
</html>