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
      <a href="{{ route('welcome') }}" class="navbar-brand">
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
      <form method="POST" enctype="multipart/form-data" action="{{ route('complaint.store') }}">
        @csrf
        <input type="hidden" id="hide_aid" name="hide_aid" value="{{ Helper::uuid() }}">
      <div class="row">
        
        <div class="col-lg-7">
          <div class="card card-info">
            <div class="card-header">
              <h5 class="card-title m-0">BUTIRAN ADUAN</h5>
            </div>
            <div class="card-body">
              
              <div class="form-group">
                <label for="txtComplaintNo">No Aduan : </label>
                <input type="text" class="form-control" name="txtComplaintNo" id="txtComplaintNo" value="#{{ sprintf('%06d', $complaints->complaint_no) }}" disabled>
              </div>

              <div class="form-group">
                <label for="txtComplaintType">Jenis Aduan : </label>
                <input type="text" class="form-control" name="txtComplaintType" id="txtComplaintType" value="{{ strtoupper($complaints->complaint_type) }}" disabled>
              </div>

              <div class="form-group">
                <label for="txtTitle">Tajuk : </label>
                <input type="text" class="form-control" name="txtTitle" id="txtTitle" value="{{ strtoupper($complaints->title) }}" disabled>
              </div>

              <div class="form-group">
                <label for="txtDesc">Butiran Aduan : </label>
                <textarea name="txtDesc" id="txtDesc" class="form-control" rows="7" placeholder="" disabled>{{ strtoupper($complaints->description) }}</textarea>
              </div>

              <div class="form-group" style="margin-top:28px;">
                <label for="">Lampiran : </label>
              </div>

            </div>
          </div>
        </div>

        <div class="col-lg-5">

          <div class="card card-info">
            <div class="card-header">
              <h5 class="card-title m-0">MAKLUMAT PENGADU</h5>
            </div>
            <div class="card-body">
              
              <div class="form-group">
                <label for="txtName">Nama Penuh : </label>
                <input type="text" class="form-control" name="txtName" id="txtName" value="{{ strtoupper($complaints->name) }}" disabled>
              </div>

              <div class="form-group">
                <label for="txtPhoneNo">No Telefon : </label>
                <input type="text" class="form-control" name="txtPhoneNo" id="txtPhoneNo" value="{{ strtoupper($complaints->phone_no) }}" disabled>
              </div>

              <div class="form-group">
                <label for="txtEmel">Emel : </label>
                <input type="text" class="form-control" name="txtEmel" id="txtEmel" value="{{ strtoupper($complaints->email) }}" disabled>
              </div>
              <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>

            </div>
          </div>
        </div>

        <div class="col-lg-12">
            <div class="profile-info w-100" style="margin-bottom: 30px; margin-top: -30px;">
                <ul class="list-group list-group-unbordered mb-3 w-100" style="margin-top: 20px;">
                    <li class="list-group-item w-100 d-flex justify-content-center align-items-center" style="border-bottom: none;">
                        <div style="display: flex; gap: 10px;">
                            <a href="{{ route('welcome') }}" class="btn btn-dark"><i class="fas fa-arrow-left"></i><span class="hidden-xs"> {{ __('app.back') }}</span></a>
                            <button type="submit" class="btn btn-primary" onclick="return confirm($('<span>Simpan Butiran Aduan ?</span>').text())">
                                <i class="fas fa-save"></i> {{ __('app.save') }}
                            </button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

      </div>
      <!-- /.row -->
      </form>

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

<script>
  @if(session()->has('modal'))
   $("#emailSentModal").modal("toggle");

  @endif
</script>

</body>
</html>
