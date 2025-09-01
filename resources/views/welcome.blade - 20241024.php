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

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  
  <style>
    .blink {
      animation: blink-animation 1s steps(5, start) infinite;
      -webkit-animation: blink-animation 1s steps(5, start) infinite;
    }
    @keyframes blink-animation {
      to {
        visibility: hidden;
      }
    }
    @-webkit-keyframes blink-animation {
      to {
        visibility: hidden;
      }
    }
  </style>

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

      </div>

      <!-- Right navbar links -->
      <div class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
		<ul class="navbar-nav">
          <li class="nav-item">
            <a href="{{ route('complaint.create') }}" class="nav-link"><b>Aduan</b></a>
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
    <br/>
    <!-- Main content -->
    <div class="content">
      <!--<div class="container">-->
      <!--<div>-->
      <div class="col-lg-12">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img class="d-block w-100" height="450" src="{{ asset('images/pic1.png') }}" alt="First slide">
            </div>
            <div class="carousel-item">
              <img class="d-block w-100" height="450" src="{{ asset('images/background.jpg') }}" alt="Second slide">
            </div>
            <div class="carousel-item">
              <img class="d-block w-100" height="450" src="{{ asset('images/pic3.jpg') }}" alt="Third slide">
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      <!--</div>-->
      </div>
    <!--</div>-->
    </div><br/><br/>

    <!-- Main content -->
    <div class="content">
      <div class="row">
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
        <div class="col-lg-6">
          
          <div class="card card-info">
            <div class="card-header">
              <h5 class="card-title m-0">PENGUMUMAN</h5>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <!--<p class="card-text" style="text-align: justify;">
                    1. <a data-target="#modal-lg" data-toggle="modal" class="MainNavText" id="MainNavHelp" 
                    href="#modal-lg">Test ...</a>
                  </p>
                  <br/><br/>-->

                  @php
                    $modaltext1 = "";
                    $modaltext2 = "";
                    $modaltext3 = "";
                    $modaltext4 = "";
                    $modaltext5 = "";
                  @endphp

                  <div class="col-xxl-8 col-md-12 col-12">
                    <table class="table">
                        <tbody>
                            @if ($annTextsCount > 0)
                              
                              @php
                              $num = 0;
                              @endphp

                              @foreach ($annTexts as $a)

                                @php
                                $num = $num + 1;
                                @endphp

                              <tr>
                                <td style="width: 100%;">
                                  @if ($num == 1)
                                    @php
                                      $modaltext1 = $a->description;
                                    @endphp
                                    <a data-target="#modal-lg1" href="#modal-lg1" data-toggle="modal" class="MainNavText blink" id="MainNav1">
                                      {{ $num }}. {{ $a->title }}
                                    </a>
                                  @elseif($num == 2)
                                    @php
                                      $modaltext2 = $a->description;
                                    @endphp
                                    <a data-target="#modal-lg2" href="#modal-lg2" data-toggle="modal" class="MainNavText blink" id="MainNav2">
                                      {{ $num }}. {{ $a->title }}
                                    </a>
                                  @elseif($num == 3)
                                    @php
                                      $modaltext3 = $a->description;
                                    @endphp
                                    <a data-target="#modal-lg3" href="#modal-lg3" data-toggle="modal" class="MainNavText blink" id="MainNav3">
                                      {{ $num }}. {{ $a->title }}
                                    </a>
                                  @elseif($num == 4)
                                    @php
                                      $modaltext4 = $a->description;
                                    @endphp
                                    <a data-target="#modal-lg4" href="#modal-lg4" data-toggle="modal" class="MainNavText blink" id="MainNav4">
                                      {{ $num }}. {{ $a->title }}
                                    </a>
                                  @elseif($num == 5)
                                    @php
                                      $modaltext5 = $a->description;
                                    @endphp
                                    <a data-target="#modal-lg5" href="#modal-lg5" data-toggle="modal" class="MainNavText blink" id="MainNav5">
                                      {{ $num }}. {{ $a->title }}
                                    </a>
                                  @endif
                                  
                                </td>
                              </tr>
                              @endforeach
                            @else
                              <tr>
                                <td style="width: 100%;">Tiada Pengumuman.</td>
                              </tr>
                            @endif
                        </tbody>
                    </table>
                  </div>
                  
                </div>
              </div>  
            </div>
          </div>

        </div>
        <!-- /.col-md-6 -->
      </div>
      <!-- /.row -->

      <!-- Modal 1 -->
      <div class="modal fade" id="modal-lg1">
        <div class="modal-dialog modal-lg1">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Pengumuman</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>{{ $modaltext1 }}</p>
            </div>
            <div class="modal-footer justify-content-between">
              <!--<button type="button" class="btn btn-dark" data-dismiss="modal">Tutup</button>-->
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <!-- Modal 2 -->
      <div class="modal fade" id="modal-lg2">
        <div class="modal-dialog modal-lg2">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Pengumuman</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>{{ $modaltext2 }}</p>
            </div>
            <div class="modal-footer justify-content-between">
              <!--<button type="button" class="btn btn-dark" data-dismiss="modal">Tutup</button>-->
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <!-- Modal 3 -->
      <div class="modal fade" id="modal-lg3">
        <div class="modal-dialog modal-lg3">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Pengumuman</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>{{ $modaltext3 }}</p>
            </div>
            <div class="modal-footer justify-content-between">
              <!--<button type="button" class="btn btn-dark" data-dismiss="modal">Tutup</button>-->
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <!-- Modal 4 -->
      <div class="modal fade" id="modal-lg4">
        <div class="modal-dialog modal-lg4">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Pengumuman</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>{{ $modaltext4 }}</p>
            </div>
            <div class="modal-footer justify-content-between">
              <!--<button type="button" class="btn btn-dark" data-dismiss="modal">Tutup</button>-->
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <!-- Modal 5 -->
      <div class="modal fade" id="modal-lg5">
        <div class="modal-dialog modal-lg5">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Pengumuman</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>{{ $modaltext5 }}</p>
            </div>
            <div class="modal-footer justify-content-between">
              <!--<button type="button" class="btn btn-dark" data-dismiss="modal">Tutup</button>-->
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

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

<!-- Slider -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</body>
</html>
