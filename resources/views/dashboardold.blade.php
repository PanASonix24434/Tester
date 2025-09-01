@extends('layouts.app')

@push('styles')
    <style type="text/css">
        .div-1 {
            background-color: #40E0D0;
        }

        .div-red {
            background-color: red;
        }
    </style>
@endpush

@section('content')

<!-- Page content -->
<div id="app-content">
  <!-- Container fluid -->

  <!-- MODUL ADUAN -->
  @if ($user_roles_admin == true || $user_roles_aduan == true)
  <div class="app-content-area">
    <div class="bg-primary pt-10 pb-21 mt-n6 mx-n4"></div>
    <div class="container-fluid mt-n22">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
          <!-- Page header -->
          <div class="d-flex justify-content-between align-items-center mb-5">
            <div class="mb-2 mb-lg-0">
              <h3 class="mb-0 text-white">Dashboard - Modul Aduan</h3>
            </div>
            <div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-5">
          <!-- card -->
          <div class="card h-70 card-lift">
            <!-- card body -->
            <div class="card-body div-1">
              <!-- heading -->
              <div class="justify-content-between align-items-center mb-3">
                <div>
                  <h4 class="mb-0" style="text-align:center;">Aduan Selesai</h4>
                </div>
              </div>
              <!-- project number -->
              <div class="lh-1">
                <h1 class="mb-1 fw-bold text-center">{{ $complaintCompleted }}</h1><br/>
                <p class="mb-0 text-center">
                  <a href="{{ route('complaint2.complaintlist') }}" class="small-box-footer"><u>Lihat Butiran</u> <i class="fas fa-arrow-circle-right"></i></a>
                </p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-5">
          <!-- card -->
          <div class="card h-70 card-lift">
            <!-- card body -->
            <div class="card-body div-red">
              <!-- heading -->
              <div class="justify-content-between align-items-center mb-3">
                <div>
                  <h4 class="mb-0" style="text-align:center;">Aduan Dalam Tindakan</h4>
                </div>
              </div>
              <!-- project number -->
              <div class="lh-1">
                <h1 class="mb-1 fw-bold text-center">{{ $complaintAssigns }}</h1><br/>
                <p class="mb-0 text-center">
                  <a href="{{ route('complaint2.complaintlist') }}" class="small-box-footer"><u>Lihat Butiran</u> <i class="fas fa-arrow-circle-right"></i></a>
                </p>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-5">

        </div>

        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-5">

        </div>
      </div>

    </div>
  </div>
  @endif

  @if ($user_roles_admin == true)
  <div class="app-content-area">
    <div class="bg-primary pt-10 pb-21 mt-n6 mx-n4"></div>
    <div class="container-fluid mt-n22">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
          <!-- Page header -->
          <div class="d-flex justify-content-between align-items-center mb-5">
            <div class="mb-2 mb-lg-0">
              <h3 class="mb-0 text-white">Dashboard</h3>
            </div>
            <div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-5">
          <!-- card -->
          <div class="card h-70 card-lift">
            <!-- card body -->
            <div class="card-body div-1">
              <!-- heading -->
              <div class="justify-content-between align-items-center mb-3">
                <div>
                  <h4 class="mb-0" style="text-align:center;">Jumlah Vesel Aktif</h4>
                </div>
              </div>
              <!-- project number -->
              <div class="lh-1">
                <h1 class="mb-1 fw-bold text-center">0</h1><br/>
                <p class="mb-0 text-center">
                  <a href="#" class="small-box-footer"><u>Lihat Butiran</u> <i class="fas fa-arrow-circle-right"></i></a>
                </p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-5">
          <!-- card -->
          <div class="card h-70 card-lift">
            <!-- card body -->
            <div class="card-body div-red">
              <!-- heading -->
              <div class="justify-content-between align-items-center mb-3">
                <div>
                  <h4 class="mb-0" style="text-align:center;">Jumlah Vesel Tamat Tempoh</h4>
                </div>
              </div>
              <!-- project number -->
              <div class="lh-1">
                <h1 class="mb-1 fw-bold text-center">0</h1><br/>
                <p class="mb-0 text-center">
                  <a href="#" class="small-box-footer"><u>Lihat Butiran</u> <i class="fas fa-arrow-circle-right"></i></a>
                </p>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-5">
          <!-- card -->
          <div class="card h-70 card-lift">
            <!-- card body -->
            <div class="card-body div-1">
              <!-- heading -->
              <div class="justify-content-between align-items-center mb-3">
                <div>
                  <h4 class="mb-0" style="text-align:center;">Jumlah Vesel Aktif</h4>
                </div>
              </div>
              <!-- project number -->
              <div class="lh-1">
                <h1 class="mb-1 fw-bold text-center">0</h1><br/>
                <p class="mb-0 text-center">
                  <a href="#" class="small-box-footer"><u>Lihat Butiran</u> <i class="fas fa-arrow-circle-right"></i></a>
                </p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-5">
          <!-- card -->
          <div class="card h-70 card-lift">
            <!-- card body -->
            <div class="card-body div-red">
              <!-- heading -->
              <div class="justify-content-between align-items-center mb-3">
                <div>
                  <h4 class="mb-0" style="text-align:center;">Jumlah Vesel Tamat Tempoh</h4>
                </div>
              </div>
              <!-- project number -->
              <div class="lh-1">
                <h1 class="mb-1 fw-bold text-center">0</h1><br/>
                <p class="mb-0 text-center">
                  <a href="#" class="small-box-footer"><u>Lihat Butiran</u> <i class="fas fa-arrow-circle-right"></i></a>
                </p>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- Chart -->
      <div class="row  mb-5">
        <div class="col-6">
          <div class="card h-70">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h4 class="mb-0">Demographics</h4>

              <div class="dropdown dropstart">
                <a href="#!" class="btn btn-ghost btn-icon btn-sm rounded-circle" data-bs-toggle="dropdown" aria-expanded="false">
                  <i data-feather="more-vertical" class="icon-xs"></i>
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item d-flex align-items-center" href="#!">Action</a></li>
                  <li><a class="dropdown-item d-flex align-items-center" href="#!">Another action</a></li>
                  <li><a class="dropdown-item d-flex align-items-center" href="#!">Something else here</a></li>
                </ul>
              </div>
              </div>
            <div class="card-body">


              <div id="chartGraphics"></div>
            </div>
          </div>
        </div>
        <div class="col-6">
          <div class="card h-70">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h4 class="mb-0">Social Traffic</h4>
              <div class="dropdown dropstart">
                <a href="#!" class="btn btn-ghost btn-icon btn-sm rounded-circle" data-bs-toggle="dropdown" aria-expanded="false">
                  <i data-feather="more-vertical" class="icon-xs"></i>
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item d-flex align-items-center" href="#!">Action</a></li>
                  <li><a class="dropdown-item d-flex align-items-center" href="#!">Another action</a></li>
                  <li><a class="dropdown-item d-flex align-items-center" href="#!">Something else here</a></li>
                </ul>
              </div>
            </div>
            <div class="card-body">

              <div class="row align-items-center g-0">
                <div class="col-md-5">
                  <div id="socialTraffic" class="d-flex justify-content-center"></div>
                </div>
                <div class="col-md-7">
                  <ul class="list-group list-group-flush px-6 py-4">
                    <li class="list-group-item  d-flex justify-content-between">
                      <span class="text-muted">Quora</span>
                      <span>460 / 83%</span>
                    </li>
                    <li class="list-group-item  d-flex justify-content-between">
                      <span class="text-muted">Twitter</span>
                      <span>320 / 24%</span>
                    </li>
                    <li class="list-group-item  d-flex justify-content-between">
                      <span class="text-muted">Facebook</span>
                      <span>123 / 12%</span>
                    </li>
                    <li class="list-group-item  d-flex justify-content-between">
                      <span class="text-muted">Youtube</span>
                      <span>109 / 10%</span>
                    </li>
                    <li class="list-group-item  d-flex justify-content-between">
                      <span class="text-muted">LinkedIn</span>
                      <span>88 / 8%</span>
                    </li>
                    <li class="list-group-item  d-flex justify-content-between">
                      <span class="text-muted">Reddit</span>
                      <span>40 / 4%</span>
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
  @endif

</div>

@endsection
