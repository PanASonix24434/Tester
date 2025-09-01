<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>e-Lesen 2.0 | Utama</title>
  <link rel="icon" href="{{ asset('images/doflogoonly.png') }}" type="image/png">
  

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
<link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white" >
    <div class="container">
      <a href="#" class="navbar-brand">
        <!--<img src="../../dist/img/doflogoonly.png" alt="DOF Logo" class="brand-image img-circle elevation-3" style="opacity: .8">-->
		<img src="{{ asset('images/jata.png') }}" alt="Jata" height="50">
		<img src="{{ asset('images/dof_logo.jpg') }}" alt="DOF Logo" height="50">
        <span class="brand-text font-weight-light"><b>&nbsp;&nbsp;e-Lesen 2.0</b></span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <!--<ul class="navbar-nav">
          <li class="nav-item">
            <a href="#" class="nav-link"><b>Aduan</b></a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link"><b>PDPA</b></a>
          </li>
		  <li class="nav-item">
            <a href="#" class="nav-link"><b>Log Masuk</b></a>
          </li>
        </ul>

      </div>

      <!-- Right navbar links -->
      <div class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
		<ul class="navbar-nav">
          <li class="nav-item">
            <a href="#" class="nav-link"><b>Aduan</b></a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link"><b>PDPA</b></a>
          </li>
		  <li class="nav-item">
            <a href="{{ route('login') }}" class="nav-link"><b>Log Masuk</b></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">

    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <!--<div class="container">-->
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <img src="{{ asset('images/pic1.png') }}" class="card-img-top" height="508" alt="Aktiviti Penangkapan Ikan">
              </div>
            </div>

          </div>
          <!-- /.col-md-6 -->
          <div class="col-lg-6">
            <div class="card card-primary">
              <div class="card-header">
                <h5 class="card-title m-0">INFORMASI</h5>
              </div>
              <div class="card-body">
                <p class="card-text" style="text-align: justify;">Sistem e-Lesen 2.0 adalah versi terkini yang memudahkan pengurusan lesen vesel dan peralatan menangkap ikan. Sistem ini menawarkan maklumat lengkap pelesenan dan membolehkan pemohon menguruskan keseluruhan proses pelesenan secara atas talian.</p>
                <p style="text-align: justify;">Dengan kecekapan yang lebih baik dan kemudahan penggunaan yang dipertingkatkan, e-Lesen 2.0 membantu memperkukuh pengurusan sumber perikanan negara serta menyokong usaha pemeliharaan laut yang mampan.</p>
              </div>
            </div>

			<div class="card card-primary">
              <div class="card-header">
                <h5 class="card-title m-0">WAKTU PERKHIDMATAN</h5>
              </div>
              <div class="card-body">
			    <div class="row">
					<div class="col-md-6">
						<p class="card-text" style="text-align: justify;"><b>Isnin hingga Khamis :</b></p>
						<p style="text-align: justify;">9:00 AM - 1:00 PM<br/>1:00 AM - 2:00 PM (Rehat)<br/>2:00 PM - 4:30 PM</p>
					</div>
					<div class="col-md-6">
						<p class="card-text" style="text-align: justify;"><b>Jumaat :</b></p>
						<p style="text-align: justify;">9:00 AM - 12:00 PM<br/>12:00 PM - 2:45 PM (Rehat)<br/>2:45 PM - 4:30 PM</p>
                        <br/><br/>
					</div>
				</div>
                
              </div>
            </div>

          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      <!--</div>--><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Versi 1.0.0
    </div>
    <!-- Default to the left -->
    <strong>Hakcipta Terpelihara &copy; 2025 <a href="https://www.dof.gov.my/">Jabatan Perikanan Malaysia</a>.</strong>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>

</body>
</html>
