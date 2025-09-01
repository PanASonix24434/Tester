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
            <div class="col-5">
                <!-- Card -->
                <div class="card smooth-shadow-md" style="background-color: rgba(77, 255, 255, 0.5);">
                    <!-- Card body -->
                    <div class="card-body p-6">

                        <div class="mb-6 text-center" style="margin-top:-10px;">
                            <img src="{{ asset('images/dof_logo_t.png') }}" alt="Jata" height="50" width="110">&nbsp;&nbsp;
                            <img src="{{ asset('images/elesen_logo.png') }}" alt="eLesen Logo" height="50" width="130">
                        </div>

                        <!-- Success alert -->
                        <div class="alert alert-success d-flex align-items-center alert-dismissible" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle-fill me-2" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                            </svg>
                            <div>
                                Pendaftaran Pengguna Berjaya ! Sila semak emel untuk membuat verifikasi pengguna.<br/>
                                Sekiranya tidak menerima emel verifikasi pengguna, sila klik butang Hantar Semula Verifikasi Emel.
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        <div>
                            <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Hantar Semula Verifikasi Emel</button>
                                </div>
                            </form>
                        </div><br/>

                        <div>
                            <!-- Form -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <!-- Button -->
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Kembali</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-7"></div>
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

  <script type="text/javascript">

  </script>

</body>
</html>