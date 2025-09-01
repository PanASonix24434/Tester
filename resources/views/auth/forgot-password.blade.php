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

            <div class="row"style="margin-top: 6%;">
                {{-- <div class="col-12 col-md-8 col-lg-6 col-xxl-4 py-8 py-xl-0"> --}}
                <div class="col-5">
                <!-- Card -->
					<div class="card smooth-shadow-md" style="background-color: rgba(77, 255, 255, 0.5); margin-top:-45px;">
                        <!-- Close Button -->
                        <a href="{{ route('login') }}" class="btn-close position-absolute end-0 mt-2 me-2" aria-label="Close"></a>

						<!-- Card body -->
						<div class="card-body p-6">
                            
                        <div class="mb-6 text-center" style="margin-top:-10px; opacity: 1;">
                                <img src="{{ asset('images/dof_logo_t.png') }}" alt="Jata" height="50" width="110">&nbsp;&nbsp;
                                <img src="{{ asset('images/elesen_logo.png') }}" alt="eLesen Logo" height="50" width="130">
                            </div>

                            <!-- Form -->
							<form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="input-group">
                                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required placeholder="Sila Masukkan No. MyKad Berdaftar">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-id-card"></span>
                                        </div>
                                    </div>
                                </div>
                                @error('username')
                                    <span id="icno_error" class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <div class="d-grid mt-3">
                                    <button type="submit" class="btn btn-primary">Hantar Pautan Reset Kata Laluan</button>
                                </div>
                            </form>
                        </div>
                        @if (session('email_success'))
    <!-- Success Modal Trigger -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = new bootstrap.Modal(document.getElementById('successModal'));
            modal.show();
        });
    </script>

    <!-- Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content text-center">
            <div class="modal-body p-5">
                <div class="text-success mb-3">
                    <i class="fas fa-check-circle fa-4x"></i>
                </div>
                <h4 class="mb-3">BERJAYA</h4>
                <p class="mb-2">Permintaan set semula katalaluan telah dihantar ke:</p>
                <strong>Emel Berdaftar:</strong><br>
                <span class="text-primary">{{ session('email_success') }}</span>
                <p class="mt-3 text-muted">Sila lihat email anda setelah <strong>2 minit</strong>.</p>
                <div class="mt-4">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Tutup</button>
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


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