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

            <div class="row"style="margin-top: 5%;">
                {{-- <div class="col-12 col-md-8 col-lg-6 col-xxl-4 py-8 py-xl-0"> --}}
                <div class="col-5">
                <!-- Card -->
					<div class="card smooth-shadow-md" style="background-color: rgba(77, 255, 255, 0.5); margin-top:-45px;">
						<!-- Card body -->
						<div class="card-body p-6" style="margin-bottom:-30px;">

                            <div class="mb-6 text-center" style="margin-top:-10px; opacity: 1;">
                                <img src="{{ asset('images/dof_logo_t.png') }}" alt="Jata" height="50" width="110">&nbsp;&nbsp;
                                <img src="{{ asset('images/elesen_logo.png') }}" alt="eLesen Logo" height="50" width="130">
							</div>

                            <div class="mb-6 text-center" style="margin-top:-13px;">
                                <label class="form-label" style="font-size:20px; color:black; font-weight: normal;">Selamat Datang Ke<br> <b>eLesen Perikanan</b></label>
							</div>

                            <div class="mb-6 text-center" style="margin-top:-20px;">
                                <label class="form-label" style="font-size:12px; color:black;">SILA LOG MASUK MENGGUNAKAN MYDIGITAL ID <br/>ATAU ID SISTEM ELESEN</label>
							</div>

                            <div class="mb-6 text-center" style="margin-top:-20px;">
                                <img src="{{ asset('images/icon_mydid.png') }}" alt="MyDID" height="10%" width="40%">
							</div><br/>

                            <div style="display: flex; align-items: center; text-align: center; margin-top: -8%; margin-bottom: 2%;">
                                <hr style="flex: 1; border: none; border-top: 1px solid #ddd;">
                                <span style="padding: 0 10px; color:black;">atau</span>
                                <hr style="flex: 1; border: none; border-top: 1px solid #ddd;">
                            </div>

                            @if (session('status'))
                                <div class="alert alert-danger d-flex align-items-center alert-dismissible" role="alert">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill me-2" viewBox="0 0 16 16">
                                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                    </svg>
                                    <div>
                                        {{ session('status') }}
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>                               
                            @endif
                            @error('username')
                                <div class="alert alert-danger d-flex align-items-center alert-dismissible" role="alert">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill me-2" viewBox="0 0 16 16">
                                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                    </svg>
                                    <div>
                                        {{ $message }}
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @enderror
                            @error('password')
                                <div class="alert alert-danger d-flex align-items-center alert-dismissible" role="alert">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill me-2" viewBox="0 0 16 16">
                                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                    </svg>
                                    <div>
                                        {{ $message }}
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @enderror

                            @if (session('success'))
                                <!-- Success alert -->
                                <div class="alert alert-success d-flex align-items-center alert-dismissible" role="alert">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle-fill me-2" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                    </svg>
                                    <div>
                                        {{ session('success') }}
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

							<!-- Form -->
							<form method="POST" action="{{ route('login') }}">
                                @csrf

								<!-- Username -->
								<div class="mb-3" style="margin-top:-7px;">
									<label for="username" class="form-label" style="color:black;">No. Kad Pengenalan ( Tanpa '-' ) : </label>
									<input type="text" id="username" class="form-control" name="username" required="" maxlength="12" />
                                    <label id="errUsername" class="form-label" style="color:red; display:none;">Sila masukkan 12 digit No. Kad Pengenalan.</label>
								</div>

                                <!-- Password -->
                                <div class="mb-3" style="margin-top:-7px;">
                                    <label for="password" class="form-label" style="color:black;">Kata Laluan : 
                                        <i class="fa fa-info-circle" style="font-size:18px;color:green" data-bs-toggle="tooltip" data-placement="top" 
                                        title="Panjang minimum 12 Aksara, Minimum 1 Huruf Kecil, 1 Huruf Besar, 1 Nombor, 1 Simbol">
                                        </i>
                                    </label>
                                </div>
                                <div class="input-group mt-3" >
                                    <input style="margin-top:-10px;" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="">
                                    <div class="input-group-append" style="margin-top:-10px;">                           
                                        <div class="input-group-text">
                                            <i  class="bi bi-eye-slash" id="togglePassword" style="cursor: pointer;"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Checkbox -->
								<div class="d-lg-flex justify-content-between align-items-center mb-4">
								</div>

                                <div>
									<!-- Button -->
									<div class="d-grid">
										<button type="submit" class="btn" style="background-color: #2e3192; color: white;">Log Masuk</button>
									</div>

									<div class="d-md-flex justify-content-between mt-4">
										<div class="mb-2 mb-md-0">
											<a href="{{ route('register') }}" class="btn btn-danger">Daftar Pengguna Baru</a><br/>
										</div>
										<div>
											<a href="{{ route('password.request') }}" class="btn btn-danger">Lupa Kata Laluan ?</a>
										</div>
									</div>
								</div><br/><br/>

                                <div class="mb-6 text-center">
                                    <label class="form-label" style="font-size:12px; color:white;">Hak Cipta Terpelihara 2025 &copy; <br/> Jabatan Perikanan Malaysia</label>
                                </div>

							</form>
						</div>
@if(session('showResetSuccessModal'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var myModal = new bootstrap.Modal(document.getElementById('resetSuccessModal'));
            myModal.show();
        });
    </script>

    <!-- Success Reset Modal -->
    <div class="modal fade" id="resetSuccessModal" tabindex="-1" role="dialog" aria-labelledby="resetSuccessModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content text-center">
                <div class="modal-body p-5">
                    <div class="text-success mb-3">
                        <i class="fas fa-check-circle fa-4x"></i>
                    </div>
                    <h4 class="mb-3">BERJAYA</h4>
                    <p class="mb-2">Kata Laluan Telah Direset Semula</p>
                    <p class="text-muted">Sila log masuk dengan kata laluan baru anda.</p>
                    <div class="mt-4">
                        <a href="{{ route('login') }}" class="btn btn-success">Log Masuk</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

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
<!-- Bootstrap Bundle JS (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


  <script type="text/javascript">

    var errUsername = document.getElementById("errUsername");

    $("#username").keyup('input', function(event){

        this.value = this.value.replace(/[^0-9]/g, '');

        if ( $("#username").val().length != 12) {
            
            // If username is too short
            errUsername.style.display = "block";
        
        } else {
            
            // If there is no errors, clear the HTML
            errUsername.style.display = "none";
            event.preventDefault();    
            
        }
    })
        
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    // togglePassword.addEventListener('click', function (e) {
    //     // toggle the type attribute
    //     const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    //     password.setAttribute('type', type);
    //     // toggle the eye slash icon
    //     this.classList.toggle('fa-eye-slash');
    // });

    togglePassword.addEventListener("click", function () {
        // toggle the type attribute
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);
            
        // toggle the icon
        this.classList.toggle("bi-eye");
    });

    //Display success message
    var msgSuccess = '{{Session::get('status_reset')}}';
    var existSuccess = '{{Session::has('status_reset')}}';
    if(existSuccess){
        alert(msgSuccess);
    }

  </script>

</body>
</html>