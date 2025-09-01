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

@php
    use App\Models\ProfileUsers;
    use App\Models\ProfilePentadbirHarta;

    $profile = ProfileUsers::where('user_id', auth()->id())->first();
    $pentadbir_harta = ProfilePentadbirHarta::where('user_id', auth()->id())->first();
@endphp

@if (session('custom_alert') && $profile->verify_status != 1 && $pentadbir_harta && $pentadbir_harta->status === 'submitted')
<!-- Modal -->
<div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="alertModalLabel">Makluman</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <p><strong>Profil berjaya dikemaskini!</strong></p>
        <ul class="mb-0 ps-3">
          <li>Pengesahan profil anda akan diproses pada peringkat atasan.</li>
          <li>Anda akan menerima emel makluman selepas proses pengesahan selesai.</li>
          <li>Hanya profil yang telah disahkan sahaja boleh menggunakan keseluruhan fungsi sistem.</li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<script>
    window.onload = function () {
        var alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
        alertModal.show();
    };
</script>
@endif




<!-- PENGGUNA KALI PERTAMA -->
@php

$user = auth()->user();

$profile = ProfileUsers::where('user_id', $user->id)->first();
$isAdmin = $user->is_admin ?? 0;
$hasEntity = !is_null($user->entity_id);

// Get ProfilePentadbirHarta for the user
$pentadbir_harta = ProfilePentadbirHarta::where('user_id', $user->id)->first();

// Allowed roles
$allowedRoles = [
    'PEMOHON LESEN VESEL (NELAYAN LAUT)',
    'PEMOHON LESEN VESEL (NELAYAN DARAT)',
    'PENGURUS VESEL',
    'PENGUSAHA SKL',
    'PEWARIS',
    'PENTADBIR HARTA'
];

// Get user role names
$userRoles = $user->roles->pluck('name')->toArray();
$hasAllowedRole = collect($userRoles)->intersect($allowedRoles)->isNotEmpty();
@endphp


@if (!$isAdmin && !$hasEntity && $hasAllowedRole)
    {{-- First time login (no profile) --}}
    @if (!$profile && !$pentadbir_harta)
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                new bootstrap.Modal(document.getElementById("firstTimeModal")).show();
            });
        </script>

        <div class="modal fade" id="firstTimeModal" tabindex="-1" aria-labelledby="firstTimeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="firstTimeModalLabel">Makluman</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Bagi pengguna kali pertama, anda dikehendaki mengemaskini profil dahulu sebelum menggunakan sistem E-Lesen Perikanan.</p>
                    </div>

                      @php
                        // Default profile URL
                        $profileUrl = url('profile/handleProfile');

                        // Override for specific roles
                        if (in_array('PENTADBIR HARTA', $userRoles)) {
                            $profileUrl = url('profile/inheritance-administrator/create');
                        } elseif (in_array('PEWARIS', $userRoles)) {
                            $profileUrl = url('profile/inheritance-administrator/create_pewaris');
                        }
                      @endphp

                       <div class="modal-footer">
                          <a href="{{ $profileUrl }}" class="btn btn-primary">OK</a>
                      </div>
                </div>
            </div>
        </div>

    {{-- Show Success Modal --}}
    @elseif (
        ($profile && $profile->verify_status === 1 && session('show_success_modal')) || ($pentadbir_harta && $pentadbir_harta->status === 'verified'))

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const modal = new bootstrap.Modal(document.getElementById("successModal"));
                modal.show();

                fetch("{{ route('profile.modal-seen') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ seen: true })
                }).then(response => {
                    if (!response.ok) {
                        console.error("Gagal kemas kini verification_modal_shown.");
                    }
                });
            });
        </script>

        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel">Makluman</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Profil anda telah <strong>BERJAYA</strong> disahkan! Anda boleh mula menggunakan sistem E-Lesen Perikanan.</p>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-primary" data-bs-dismiss="modal">Tutup</a>
                    </div>
                </div>
            </div>
        </div>

    {{-- Show Failed Modal --}}
    @elseif (
        ($profile && $profile->verify_status === 0 && session('show_failed_modal')) || ($pentadbir_harta && $pentadbir_harta->status === 'unverified'))

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const modal = new bootstrap.Modal(document.getElementById("failedModal"));
                modal.show();

                fetch("{{ route('profile.modal-seen') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ seen: true })
                }).then(response => {
                    if (!response.ok) {
                        console.error("Gagal kemas kini verification_modal_shown.");
                    }
                });
            });
        </script>

        <div class="modal fade" id="failedModal" tabindex="-1" aria-labelledby="failedModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="failedModalLabel">Makluman</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Profil anda <strong>GAGAL</strong> disahkan. Sila kemaskini semula profil anda.</p>
                        <p><strong>ULASAN PEGAWAI</strong>:<br>{{ $profile->ulasan ?? 'Tiada ulasan diberikan.' }}</p>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ url('profile/handleProfile') }}" class="btn btn-primary">OK</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif



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

  @if ($user_roles_admin != true)
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

</div>

@endsection
