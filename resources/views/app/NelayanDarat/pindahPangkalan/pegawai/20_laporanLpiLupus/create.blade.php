@extends('layouts.app')

@push('styles')
<style type="text/css">
</style>

<style>
    .nav-link {
        border-bottom: none !important;
    }

    .nav.nav-tabs {
        border-bottom: none !important;
    }

    .nav-link.active {
        background-color: white !important;
    }

    /* Disable hover effect and interaction for custom nav links */
    .custom-nav-link:hover {
        background-color: white !important;
        /* Keep the background color as is during hover */
    }

    /* Disable all interactions with custom nav links */
    .custom-nav-link {
        pointer-events: none;
        /* Disable all interactions with the nav link */
    }

    /* Override the default btn-primary color */
    .btn-primary {
        background-color: #007bff !important;
        /* Set background color to #007bff */
        border-color: #007bff !important;
        /* Set border color to #007bff */
        color: white !important;
        /* Ensure text is white */
    }

    /* Optional: Change hover effect */
    .btn-primary:hover {
        background-color: #0056b3 !important;
        /* Darker blue on hover */
        border-color: #0056b3 !important;
        /* Darker border on hover */
    }
</style>
@endpush

@section('content')
<!-- Page Content -->
<div id="app-content">

    <!-- Container fluid -->
    <div class="app-content-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md">
                    <!-- Page header -->
                    <div class="mb-5">
                        <h3 class="mb-0">{{ $applicationType->name_ms }}</h3>
                        <small>{{ $moduleName->name }} - {{ $roleName }}</small>
                    </div>
                </div>
                <div class="col-md-3 align-content-center">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
                        <ol class="breadcrumb text-center">
                            <li class="breadcrumb-item"><a
                                    href="http://127.0.0.1:8000/pindahPangkalan/laporanLpi-03">{{
                                    \Illuminate\Support\Str::ucfirst(strtolower($applicationType->name)) }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $moduleName->name }}</a></li>
                            {{-- <li class="breadcrumb-item active" aria-current="page">Permohonan</a></li> --}}

                        </ol>
                    </nav>
                </div>
            </div>
            <div>
                <!-- row -->
                <div class="row">
                    <div class="col-12">

                        {{-- card 1 --}}

                        <div class="card card-primary">
                            <div class="card-header "></div>
                            <div class="card-body">

                                <div class="border p-5" style="border-radius: 20px">
                                    <div class="row table-responsive">
                                        <!-- Left Column -->
                                        <div class="col-md-6">
                                            <table class="table-borderless table">
                                                <tbody>
                                                    <tr>
                                                        <td class="col-md-3">Nama Pemohon</td>
                                                        <td class="col-md-1">:</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $userDetail->name ?? 'Tidak Diketahui' }}"
                                                                readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>No. Kad Pengenalan</td>
                                                        <td>:</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $userDetail->identity_card_number ?? 'Tidak Diketahui' }}"
                                                                readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pangkalan</td>
                                                        <td>:</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $jettyOff->jetty_name ?? 'Tidak Diketahui' }}"
                                                                readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>No. Pendaftaran Vesel</td>
                                                        <td>:</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $vesselOff->vessel_registration_number ?? 'Tiada Vesel' }}"
                                                                readonly>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <table class="table-borderless table">
                                                <tbody>
                                                    <tr>
                                                        <td class="col-md-3">Jenis semakanDokumen</td>
                                                        <td class="col-md-1">:</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $application->applicationType->name_ms ?? 'Tidak Diketahui' }}"
                                                                readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>No. Rujukan</td>
                                                        <td>:</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $application->no_rujukan ?? 'Tidak Diketahui' }}"
                                                                readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tarikh semakanDokumen</td>
                                                        <td>:</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $application->created_at?->format('d-m-Y') ?? 'Tidak Diketahui' }}"
                                                                readonly>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <br>

                                <div class="card card-primary card-tabs">

                                    <div class="card-header pb-0">

                                        <ul class="nav nav-tabs" id="pills-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link custom-nav-link active" id="tab1-link"
                                                    aria-disabled="true"> Vesel</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link custom-nav-link" id="tab2-link" aria-disabled="true">
                                                    Enjin</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link custom-nav-link" id="tab3-link" aria-disabled="true">
                                                    Peralatan Keselamatan</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link custom-nav-link" id="tab4-link" aria-disabled="true">
                                                    Peralatan Menangkap Ikan</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link custom-nav-link" id="tab5-link" aria-disabled="true">
                                                    Pemeriksaan </a>
                                            </li>

                                        </ul>
                                    </div>
                                    <div class="card-body">

                                        <div class="tab-content" id="pills-tabContent">

                                            <div class="tab-pane fade show active" id="content-tab1" role="tabpanel"
                                                aria-labelledby="tab1-link">
                                                <form id="form-tab1"
                                                    action="{{ route('pindahPangkalan.laporanLpi-03.storeMaklumatVesel', $application->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf

                                                    <!-- Asal Vesel -->
                                                    <div class="card-header mb-3 pl-0">
                                                        <h4 class="fw-bold mb-0">Asal Vesel</h4>
                                                        <small class="text-muted">Maklumat asal vesel sama ada baru atau
                                                            terpakai</small>
                                                    </div>
                                                    <select required class="form-select mb-4" name="vessel_origin">
                                                        <option selected disabled>Pilih Jenis Asal Vesel</option>
                                                        <option value="1" {{ old('vessel_origin', $inspection->
                                                            vessel_origin ?? null) == 1 ? 'selected' : '' }}>
                                                            BARU
                                                        </option>
                                                        <option value="2" {{ old('vessel_origin', $inspection->
                                                            vessel_origin ?? null) == 2 ? 'selected' : '' }}>
                                                            TERPAKAI
                                                        </option>
                                                    </select>

                                                    <!-- Jenis Kulit -->
                                                    <div class="card-header mb-3 pl-0">
                                                        <h4 class="fw-bold mb-0">Jenis Kulit</h4>
                                                        <small class="text-muted">Pilih jenis kulit vesel yang
                                                            digunakan</small>
                                                    </div>
                                                    <select required class="form-select mb-4" name="jenis_kulit">
                                                        <option selected disabled>Pilih Jenis Kulit</option>
                                                        @foreach ($jenisKulit as $id => $name)
                                                        <option value="{{ $name }}" {{ old('hull_type', $inspection->
                                                            hull_type ?? null) == $name ? 'selected' : '' }}>
                                                            {{ $name }}</option>
                                                        @endforeach
                                                    </select>

                                                    <!-- No. Pendaftaran Vesel -->
                                                    <div class="card-header mb-3 pl-0">
                                                        <h4 class="fw-bold mb-0">No. Pendaftaran Vesel</h4>
                                                        <small class="text-muted">Semakan ke atas nombor pendaftaran
                                                            vesel</small>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Ditebuk</label>
                                                        <select required class="form-select" name="ditebuk">
                                                            <option selected disabled>Pilih Status</option>
                                                            <option value="1" {{ old('ditebuk', $inspection->drilled ??
                                                                '') == 1 ? 'selected' : '' }}>YA
                                                            </option>
                                                            <option value="0" {{ old('ditebuk', $inspection->drilled ??
                                                                '') == 0 ? 'selected' : '' }}>
                                                                TIDAK</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Dicat dengan terang</label>
                                                        <select required class="form-select" name="dicat_dengan_terang">
                                                            <option selected disabled>Pilih Status</option>
                                                            <option value="1" {{ old('dicat_dengan_terang',
                                                                $inspection->brightly_painted ?? '') == 1 ? 'selected' :
                                                                '' }}>
                                                                YA</option>
                                                            <option value="0" {{ old('dicat_dengan_terang',
                                                                $inspection->brightly_painted ?? '') == 0 ? 'selected' :
                                                                '' }}>
                                                                TIDAK</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-4">
                                                        <label class="form-label" for="ulasan">Ulasan</label>
                                                        <textarea class="form-control"
                                                            name="no_pendaftaran_vesel_ulasan"
                                                            rows="3">{{ old('no_pendaftaran_vesel_ulasan', $inspection->vessel_registration_remarks ?? '') }}</textarea>
                                                    </div>

                                                    <!-- Ukuran Dimensi Vesel -->
                                                    <div class="card-header mb-3 pl-0">
                                                        <h4 class="fw-bold mb-0">Ukuran Dimensi Vesel (UDV)</h4>
                                                        <small class="text-muted">Maklumat dimensi vesel semasa
                                                            pemeriksaan dijalankan</small>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Panjang (m)</label>
                                                        <input class="form-control" name="panjang" type="text"
                                                            value="{{ old('panjang', $inspection->length ?? '') }}"
                                                            placeholder="Panjang">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Lebar (m)</label>
                                                        <input class="form-control" name="lebar" type="text"
                                                            value="{{ old('lebar', $inspection->width ?? '') }}"
                                                            placeholder="Lebar">
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label">Dalam (m)</label>
                                                        <input class="form-control" name="dalam" type="text"
                                                            value="{{ old('dalam', $inspection->depth ?? '') }}"
                                                            placeholder="Dalam">
                                                    </div>

                                                    <div class="card-header mb-3 pl-0">
                                                        <h4 class="fw-bold mb-0">Gambar Vesel</h4>
                                                        <small class="text-muted">Gambar vesel semasa pemeriksaan
                                                            dijalankan</small>
                                                    </div>

                                                    <div class="mb-4">
                                                        <label class="form-label">Gambar Keseluruhan</label>
                                                        <div
                                                            class="d-flex justify-content-between align-items-center gap-3">
                                                            <input class="form-control" name="overall_image_path"
                                                                type="file">

                                                            @if (!empty($inspection->overall_image_path))

                                                            <button type="button" class="btn btn-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#overallImageModal_{{ $inspection->id }}">
                                                                <i class="fa fa-search"></i>
                                                            </button>
                                                            @endif
                                                        </div>
                                                        <small class="form-text text-muted">Muat naik fail dalam format
                                                            JPG atau PNG (maksimum
                                                            2MB).</small>

       @if (!empty($inspection->overall_image_path))
            <div class="text-success small">
                Fail telah dimuat naik
            </div>
        @endif
                                                    </div>

                                                    @if (!empty($inspection->overall_image_path))
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="overallImageModal_{{ $inspection->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="overallImageModalLabel_{{ $inspection->id }}"
                                                        aria-hidden="true">
                                                        <div
                                                            class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-md-down">
                                                            <div class="modal-content p-3">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="overallImageModalLabel_{{ $inspection->id }}">
                                                                        Gambar
                                                                        Keseluruhan Vesel</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Tutup"></button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    @php
                                                                    $extension = pathinfo(
                                                                    $inspection->overall_image_path,
                                                                    PATHINFO_EXTENSION,
                                                                    );
                                                                    @endphp

                                                                    @if (in_array(strtolower($extension), ['jpg',
                                                                    'jpeg', 'png']))
                                                                    <img src="{{ route('pindahPangkalan.laporanLpi-03.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'overall_image_path']) }}"
                                                                        class="img-fluid rounded"
                                                                        style="max-height: 85vh;">
                                                                    @elseif(strtolower($extension) === 'pdf')
                                                                    <iframe
                                                                        src="{{ route('pindahPangkalan.laporanLpi-03.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'overall_image_path']) }}"
                                                                        width="100%" height="700px"
                                                                        frameborder="0"></iframe>
                                                                    @else
                                                                    <a href="{{ route('pindahPangkalan.laporanLpi-03.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'overall_image_path']) }}"
                                                                        target="_blank"
                                                                        class="btn btn-outline-primary">Buka Dokumen</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif

                                                </form>
                                            </div>

                                            <div class="tab-pane fade" id="content-tab2" role="tabpanel"
                                                aria-labelledby="tab2-link">
                                                <form id="form-tab2"
                                                    action="{{ route('pindahPangkalan.laporanLpi-03.storeMaklumatEnjin', $application->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf

                                                    <!-- Header -->
                                                    <div class="card-header mb-3 pl-0">
                                                        <h4 class="fw-bold mb-0">Maklumat Enjin</h4>
                                                        <small class="text-muted">Sila isi maklumat berkenaan enjin
                                                            vesel yang diperiksa</small>
                                                    </div>

                                                    <!-- Fields -->
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Jenama</label>
                                                            <input class="form-control" name="engine_brand" type="text"
                                                                value="{{ old('engine_brand', $inspection->engine_brand ?? '') }}"
                                                                placeholder="Masukkan Jenama">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Model</label>
                                                            <input class="form-control" name="engine_model" type="text"
                                                                value="{{ old('engine_model', $inspection->engine_model ?? '') }}"
                                                                placeholder="Masukkan Model">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Kuasa Kuda (kk)</label>
                                                            <input class="form-control" name="horsepower" type="number"
                                                                value="{{ old('horsepower', $inspection->horsepower ?? '') }}"
                                                                placeholder="Masukkan Kuasa Kuda">
                                                        </div>
                                                        <div class="col-md-6 mb-4">
                                                            <label class="form-label">No. Enjin</label>
                                                            <input class="form-control" name="engine_number" type="text"
                                                                value="{{ old('engine_number', $inspection->engine_number ?? '') }}"
                                                                placeholder="Masukkan No. Enjin">
                                                        </div>
                                                    </div>

                                                    <!-- Gambar Enjin Header -->
                                                    <div class="card-header mb-3 pl-0">
                                                        <h4 class="fw-bold mb-0">Gambar Enjin</h4>
                                                        <small class="text-muted">Sila muat naik gambar enjin dan nombor
                                                            enjin</small>
                                                    </div>

                                                    <!-- Gambar Enjin -->
                                                    <!-- Gambar Enjin -->
                                                    <div class="mb-4">
                                                        <label class="form-label">Gambar</label>
                                                        <div
                                                            class="d-flex justify-content-between align-items-center gap-3">
                                                            <input class="form-control" name="engine_image_path"
                                                                type="file">
                                                            @if (!empty($inspection->engine_image_path))
                                                            <button type="button" class="btn btn-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#engineImageModal_{{ $inspection->id }}">
                                                                <i class="fa fa-search"></i>
                                                            </button>
                                                            @endif
                                                        </div>
                                                        <small class="form-text text-muted">Muat naik fail dalam format
                                                            JPG atau PNG (maksimum
                                                            2MB).</small>

                                                              @if (!empty($inspection->engine_image_path))
            <div class="text-success small">
                Fail telah dimuat naik
            </div>
        @endif
                                                    </div>

                                                    @if (!empty($inspection->engine_image_path))
                                                    <!-- Modal Preview Gambar Enjin -->
                                                    <div class="modal fade" id="engineImageModal_{{ $inspection->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="engineImageModalLabel_{{ $inspection->id }}"
                                                        aria-hidden="true">
                                                        <div
                                                            class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-md-down">
                                                            <div class="modal-content p-3">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Gambar Enjin</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Tutup"></button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    @php $ext = pathinfo($inspection->engine_image_path,
                                                                    PATHINFO_EXTENSION); @endphp

                                                                    @if (in_array(strtolower($ext), ['jpg', 'jpeg',
                                                                    'png']))
                                                                    <img src="{{ route('pindahPangkalan.laporanLpi-03.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'engine_image_path']) }}"
                                                                        class="img-fluid rounded"
                                                                        style="max-height: 85vh;">
                                                                    @elseif(strtolower($ext) === 'pdf')
                                                                    <iframe
                                                                        src="{{ route('pindahPangkalan.laporanLpi-03.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'engine_image_path']) }}"
                                                                        width="100%" height="700px"
                                                                        frameborder="0"></iframe>
                                                                    @else
                                                                    <a href="{{ route('pindahPangkalan.laporanLpi-03.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'engine_image_path']) }}"
                                                                        target="_blank"
                                                                        class="btn btn-outline-primary">Buka Fail</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif

                                                    <!-- Gambar No. Enjin -->
                                                    <div class="mb-4">
                                                        <label class="form-label">Gambar No. Enjin</label>
                                                        <div
                                                            class="d-flex justify-content-between align-items-center gap-3">
                                                            <input class="form-control" name="engine_number_image_path"
                                                                type="file">
                                                            @if (!empty($inspection->engine_number_image_path))
                                                            <button type="button" class="btn btn-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#engineNumberImageModal_{{ $inspection->id }}">
                                                                <i class="fa fa-search"></i>
                                                            </button>
                                                            @endif
                                                        </div>
                                                        <small class="form-text text-muted">Muat naik fail dalam format
                                                            JPG atau PNG (maksimum
                                                            2MB).</small>

                                                              @if (!empty($inspection->engine_number_image_path))
            <div class="text-success small">
                Fail telah dimuat naik
            </div>
        @endif
                                                    </div>

                                                    @if (!empty($inspection->engine_number_image_path))
                                                    <!-- Modal Preview Gambar No. Enjin -->
                                                    <div class="modal fade"
                                                        id="engineNumberImageModal_{{ $inspection->id }}" tabindex="-1"
                                                        aria-labelledby="engineNumberImageModalLabel_{{ $inspection->id }}"
                                                        aria-hidden="true">
                                                        <div
                                                            class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-md-down">
                                                            <div class="modal-content p-3">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Gambar No. Enjin</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Tutup"></button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    @php $ext =
                                                                    pathinfo($inspection->engine_number_image_path,
                                                                    PATHINFO_EXTENSION); @endphp

                                                                    @if (in_array(strtolower($ext), ['jpg', 'jpeg',
                                                                    'png']))
                                                                    <img src="{{ route('pindahPangkalan.laporanLpi-03.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'engine_number_image_path']) }}"
                                                                        class="img-fluid rounded"
                                                                        style="max-height: 85vh;">
                                                                    @elseif(strtolower($ext) === 'pdf')
                                                                    <iframe
                                                                        src="{{ route('pindahPangkalan.laporanLpi-03.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'engine_number_image_path']) }}"
                                                                        width="100%" height="700px"
                                                                        frameborder="0"></iframe>
                                                                    @else
                                                                    <a href="{{ route('pindahPangkalan.laporanLpi-03.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'engine_number_image_path']) }}"
                                                                        target="_blank"
                                                                        class="btn btn-outline-primary">Buka Fail</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif

                                                </form>
                                            </div>

                                            <div class="tab-pane fade" id="content-tab3" role="tabpanel"
                                                aria-labelledby="tab3-link">
                                                <form id="form-tab3"
                                                    action="{{ route('pindahPangkalan.laporanLpi-03.storePeralatanKeselamatan', $application->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="card-header mb-3 pl-0">
                                                        <h4 class="fw-bold mb-0">Peralatan Keselamatan</h4>
                                                        <small class="text-muted">Maklumat berkaitan jaket keselamatan
                                                            vesel</small>
                                                    </div>

                                                    <div class="row mb-4">
                                                        <div class="col-md-4">
                                                            <label class="form-label">Jaket Keselamatan</label>
                                                            <select class="form-select" name="safety_jacket_status"
                                                                id="safety_jacket_status" required>
                                                                <option selected disabled>Pilih Status</option>
                                                                <option value="1" {{ old('safety_jacket_status',
                                                                    $inspection->safety_jacket_status ?? '') == 1 ?
                                                                    'selected' : '' }}>
                                                                    ADA</option>
                                                                <option value="0" {{ old('safety_jacket_status',
                                                                    $inspection->safety_jacket_status ?? '') == 0 ?
                                                                    'selected' : '' }}>
                                                                    TIADA</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label">Kuantiti</label>
                                                            <input type="number" class="form-control"
                                                                id="safety_jacket_quantity"
                                                                name="safety_jacket_quantity"
                                                                value="{{ old('safety_jacket_quantity', $inspection->safety_jacket_quantity ?? '') }}"
                                                                placeholder="Masukkan Kuantiti">
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label">Keadaan Jaket</label>
                                                            <select class="form-select" id="safety_jacket_condition"
                                                                name="safety_jacket_condition">
                                                                <option selected disabled>Pilih Keadaan</option>
                                                                @foreach ($jenisKeadaan as $id => $name)
                                                                <option value="{{ $name }}" {{
                                                                    old('safety_jacket_condition', $inspection->
                                                                    safety_jacket_condition ?? '') == $name ? 'selected' :
                                                                    '' }}>
                                                                    {{ $name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="mb-4">
                                                        <div class="card-header mb-3 pl-0">
                                                            <h4 class="fw-bold mb-0">Gambar Jaket Keselamatan</h4>
                                                            <small class="text-muted">Gambar peralatan keselamatan yang
                                                                dijumpai</small>
                                                        </div>

                                                        <div
                                                            class="d-flex justify-content-between align-items-center gap-3">
                                                            <input class="form-control" name="safety_jacket_image_path"
                                                                type="file">
                                                            @if (!empty($inspection->safety_jacket_image_path))
                                                            <button type="button" class="btn btn-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modalJaketPreview">
                                                                <i class="fa fa-search"></i>
                                                            </button>
                                                            @if (!empty($inspection->safety_jacket_image_path))
                                                            <div class="modal fade" id="modalJaketPreview" tabindex="-1"
                                                                aria-labelledby="modalJaketPreviewLabel"
                                                                aria-hidden="true">
                                                                <div
                                                                    class="modal-dialog modal-xl modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Gambar Jaket
                                                                                Keselamatan</h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Tutup"></button>
                                                                        </div>
                                                                        <div class="modal-body text-center">
                                                                            @php $ext =
                                                                            pathinfo($inspection->safety_jacket_image_path,
                                                                            PATHINFO_EXTENSION); @endphp

                                                                            @if (in_array(strtolower($ext), ['jpg',
                                                                            'jpeg', 'png']))
                                                                            <img src="{{ route('pindahPangkalan.laporanLpi-03.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'safety_jacket_image_path']) }}"
                                                                                class="img-fluid rounded"
                                                                                style="max-height: 600px;">
                                                                            @elseif(strtolower($ext) === 'pdf')
                                                                            <iframe
                                                                                src="{{ route('pindahPangkalan.laporanLpi-03.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'safety_jacket_image_path']) }}"
                                                                                width="100%" height="600px"
                                                                                frameborder="0"></iframe>
                                                                            @else
                                                                            <a href="{{ route('pindahPangkalan.laporanLpi-03.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'safety_jacket_image_path']) }}"
                                                                                target="_blank"
                                                                                class="btn btn-outline-primary">Buka
                                                                                Fail</a>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif

                                                            @endif
                                                        </div>
                                                        <small class="form-text text-muted">Muat naik fail dalam format
                                                            JPG atau PNG (maksimum
                                                            2MB).</small>

                                                              @if (!empty($inspection->safety_jacket_image_path ))
            <div class="text-success small">
                Fail telah dimuat naik
            </div>
        @endif
                                                    </div>
                                                </form>
                                            </div>

                                            {{-- <div class="tab-pane fade" id="content-tab4" role="tabpanel"
                                                aria-labelledby="tab4-link">
                                                <form id="form-tab4"
                                                    action="{{ route('pindahPangkalan.laporanLpi-03.storePeralatanMenangkapIkan', $application->id) }}"
                                                    method="POST">
                                                    @csrf

                                                    <div class="mb-3">
                                                        <h4 class="fw-bold mb-0">Peralatan Utama</h4>
                                                        <small class="text-muted">Maklumat peralatan utama yang
                                                            digunakan</small>
                                                    </div>

                                                    @foreach ($mainEquipment as $index => $equipment)
                                                    <div class="row mb-2">
                                                        <div class="col-md-4 mb-2">
                                                            <label for="main_name_{{ $index }}" class="form-label">
                                                                Nama Peralatan <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" name="main[{{ $index }}][name]"
                                                                id="main_name_{{ $index }}" class="form-control"
                                                                placeholder="Masukkan Peralatan"
                                                                value="{{ old('main.' . $index . '.name', $equipment['name'] ?? '') }}"
                                                                required>
                                                        </div>

                                                        <div class="col-md-1 mb-2">
                                                            <label for="main_quantity_{{ $index }}" class="form-label">
                                                                Kuantiti <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="number" name="main[{{ $index }}][quantity]"
                                                                id="main_quantity_{{ $index }}" class="form-control"
                                                                placeholder="Kuantiti" min="1"
                                                                value="{{ old('main.' . $index . '.quantity', $equipment['quantity'] ?? '') }}"
                                                                required>
                                                        </div>

                                                        <div class="col-md-2 mb-2">
                                                            <label for="main_condition_{{ $index }}" class="form-label">
                                                                Keadaan <span class="text-danger">*</span>
                                                            </label>
                                                            <select name="main[{{ $index }}][condition]"
                                                                class="form-select mb-2" required>
                                                                <option value="" disabled selected>Pilih Keadaan
                                                                    Peralatan</option>
                                                                @foreach ($jenisKeadaan as $id => $name)
                                                                <option value="{{ $name }}" {{ old('main.' . $index
                                                                    . '.condition' , $equipment['condition'] ?? ''
                                                                    )==$name ? 'selected' : '' }}>
                                                                    {{ $name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-md-4 mb-2">
                                                            <label for="main_file_{{ $index }}" class="form-label">
                                                                Fail <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="file" name="main[{{ $index }}][file]"
                                                                id="main_file_{{ $index }}" class="form-control mb-2"
                                                                accept=".jpg,.jpeg,.png,.pdf,.docx">
                                                            <small class="text-muted d-block mb-2">
                                                                Format dibenarkan: JPG, JPEG, PNG, PDF, DOCX. Saiz
                                                                maksimum: 2MB.
                                                            </small>
                                                        </div>

                                                        <div class="col-md mb-2 mt-7 text-center">
                                                            @if (!empty($equipment['file_path']))
                                                            <button type="button" class="btn btn-primary "
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#fileModalMain{{ $index }}">
                                                                <i class="fa fa-search p-1"></i>
                                                            </button>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    @if (!empty($equipment['file_path']))
                                                    <div class="modal fade" id="fileModalMain{{ $index }}" tabindex="-1"
                                                        aria-labelledby="fileModalMainLabel{{ $index }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-xl modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="fileModalMainLabel{{ $index }}">
                                                                        Paparan Fail Peralatan Utama
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Tutup"></button>
                                                                </div>
                                                                <div class="modal-body" style="height: 80vh;">
                                                                    <iframe
                                                                        src="{{ route('pindahPangkalan.laporanLpi-03.viewEquipmentPhoto', ['application_id' => $application->id, 'type' => 'main', 'index' => $index]) }}"
                                                                        style="width: 100%; height: 100%;"
                                                                        frameborder="0">
                                                                    </iframe>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @endforeach

                                                    <hr>

                                                    <div class="mb-5">
                                                        <div class="mb-3">
                                                            <h4 class="fw-bold mb-0">Peralatan Tambahan</h4>
                                                            <small class="text-muted">Senaraikan peralatan tambahan
                                                                (maksimum 5)</small>
                                                        </div>

                                                        @for ($i = 0; $i < 5; $i++) @php
                                                            $additional=$additionalEquipments[$i] ?? []; @endphp <div
                                                            class="row mb-3">
                                                            <div class="col-md-4 mb-2">
                                                                <label class="form-label">Peralatan {{ $i + 1 }}</label>
                                                                <input type="text" name="additional[{{ $i }}][name]"
                                                                    class="form-control"
                                                                    placeholder="Masukkan Peralatan"
                                                                    value="{{ old('additional.' . $i . '.name', $additional['name'] ?? '') }}">
                                                            </div>

                                                            <div class="col-md-1 mb-2">
                                                                <label class="form-label">Kuantiti</label>
                                                                <input type="number"
                                                                    name="additional[{{ $i }}][quantity]"
                                                                    class="form-control" placeholder="Kuantiti" min="1"
                                                                    value="{{ old('additional.' . $i . '.quantity', $additional['quantity'] ?? '') }}">
                                                            </div>

                                                            <div class="col-md-2 mb-2">
                                                                <label class="form-label">Keadaan Peralatan</label>
                                                                <select name="additional[{{ $i }}][condition]"
                                                                    class="form-select mb-2" required>
                                                                    <option value="" disabled selected>Pilih Keadaan
                                                                        Peralatan</option>
                                                                    @foreach ($jenisKeadaan as $id => $name)
                                                                    <option value="{{ $name }}" {{ old('additional.' .
                                                                        $i . '.condition' , $additional['condition']
                                                                        ?? '' )==$name ? 'selected' : '' }}>
                                                                        {{ $name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="col-md-4 mb-2">
                                                                <label class="form-label">Fail</label>
                                                                <input type="file" name="additional[{{ $i }}][file]"
                                                                    class="form-control mb-2"
                                                                    accept=".jpg,.jpeg,.png,.pdf,.docx">
                                                                <small class="text-muted d-block">Format dibenarkan:
                                                                    JPG, JPEG, PNG, PDF, DOCX. Saiz maksimum:
                                                                    2MB.</small>
                                                            </div>

                                                            <div class="col-md-1 mb-2 mt-7 text-center">
                                                                @if (!empty($additional['file_path']))
                                                                <button type="button" class="btn btn-primary"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#fileModalAdditional{{ $i }}">
                                                                    <i class="fa fa-search p-1"></i>
                                                                </button>
                                                                @endif
                                                            </div>
                                                    </div>

                                                    @if (!empty($additional['file_path']))
                                                    <div class="modal fade" id="fileModalAdditional{{ $i }}"
                                                        tabindex="-1" aria-labelledby="fileModalAdditionalLabel{{ $i }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-xl modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="fileModalAdditionalLabel{{ $i }}">Paparan
                                                                        Fail Peralatan Tambahan {{ $i + 1 }}</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Tutup"></button>
                                                                </div>
                                                                <div class="modal-body" style="height: 80vh;">
                                                                    <iframe
                                                                        src="{{ route('pindahPangkalan.laporanLpi-03.viewEquipmentPhoto', ['application_id' => $application->id, 'type' => 'additional', 'index' => $i]) }}"
                                                                        style="width: 100%; height: 100%;"
                                                                        frameborder="0"></iframe>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @endfor
                                            </div>

                                            <hr>

                                            @php
                                            $equipmentList = $equipmentList ?? collect();
                                            $jenisKeadaan = $jenisKeadaan ?? [];
                                            $itemFoundList = $itemFoundList ?? collect();
                                            $options = ['JARING UDANG', 'PUKAT', 'BUBU', 'RAWAI', 'JALA', 'BESEN IKAN',
                                            'BAKUL PLASTIK', 'TONG SIMPANAN IKAN'];
                                            @endphp

                                            <div class="mb-5">
                                                <div class="card-header mb-3 pl-0 mt-5">
                                                    <h4 class="fw-bold mb-0">Peralatan Ditemui Semasa Pemeriksaan</h4>
                                                    <small class="text-muted">Masukkan peralatan tambahan yang ditemui
                                                        semasa pemeriksaan.</small>
                                                </div>

                                                <div id="foundItemsContainer">
                                                    @forelse($foundEquipments as $found)
                                                    <div class="row mb-3" id="foundItemRow{{ $loop->index }}">
                                                        <div class="col-md-10 mb-2">
                                                            <select name="found_item_name[]" class="form-select"
                                                                required>
                                                                <option disabled>Pilih Peralatan</option>
                                                                @foreach($options as $option)
                                                                <option value="{{ $option }}" {{ $found->name == $option
                                                                    ? 'selected' : '' }}>{{ $option }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1 mb-2">
                                                            <input type="number" name="found_item_quantity[]"
                                                                class="form-control" min="1"
                                                                value="{{ $found->quantity ?? 1 }}" required>
                                                        </div>
                                                        <div class="col-md-1 text-center">
                                                            <button type="button"
                                                                class="btn btn-danger remove-item-btn">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    @empty
                                                    <div class="row mb-3" id="foundItemRow0">
                                                        <div class="col-md-10 mb-2">
                                                            <select name="found_item_name[]" class="form-select"
                                                                required>
                                                                <option disabled selected>Pilih Peralatan</option>
                                                                @foreach($options as $option)
                                                                <option value="{{ $option }}">{{ $option }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1 mb-2">
                                                            <input type="number" name="found_item_quantity[]"
                                                                class="form-control" min="1" placeholder="0" required>
                                                        </div>
                                                        <div class="col-md-1 text-center">
                                                            <button type="button"
                                                                class="btn btn-danger remove-item-btn d-none">
                                                                <i class="fa fa-trash"></i> Buang
                                                            </button>
                                                        </div>
                                                    </div>
                                                    @endforelse
                                                </div>

                                                <div class="mb-4">
                                                    <button type="button" class="btn btn-primary" id="addItemRowBtn">
                                                        <i class="fa fa-plus"></i> Tambah Peralatan
                                                    </button>
                                                </div>

                                                @push('scripts')
                                                <script>
                                                    const options = ['JARING UDANG', 'PUKAT', 'BUBU', 'RAWAI', 'JALA', 'BESEN IKAN', 'BAKUL PLASTIK', 'TONG SIMPANAN IKAN'];

                                                 document.getElementById('addItemRowBtn').addEventListener('click', function() {
                                                    const container = document.querySelector('#foundItemsContainer');
                                                    const row = document.createElement('div');
                                                    row.classList.add('row', 'mb-3');
                                                    row.innerHTML = `
                                                        <div class="col-md-10 mb-2">
                                                            <select name="found_item_name[]" class="form-select" required>
                                                                <option disabled selected>Pilih Peralatan</option>
                                                                ${options.map(option => `<option value="${option}">${option}</option>`).join('')}
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1 mb-2">
                                                            <input type="number" name="found_item_quantity[]" class="form-control" min="1" placeholder="0" required>
                                                        </div>
                                                        <div class="col-md-1 text-center">
                                                            <button type="button" class="btn btn-danger remove-item-btn">
                                                                <i class="fa fa-trash p-1"></i>
                                                            </button>
                                                        </div>
                                                    `;
                                                    container.appendChild(row);
                                                });

                                                 document.querySelector('#foundItemsContainer').addEventListener('click', function(e) {
                                                    if (e.target.closest('.remove-item-btn')) {
                                                        e.target.closest('.row').remove();
                                                    }
                                                });
                                                </script>
                                                @endpush
                                            </div>

                                            </form>
                                        </div> --}}

                                        <div class="tab-pane fade" id="content-tab4" role="tabpanel"
                                            aria-labelledby="tab4-link">
                                            <form id="form-tab4"
                                                action="{{ route('pindahPangkalan.laporanLpi-03.storePeralatanMenangkapIkan', $application->id) }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf

                                                {{-- Peralatan Utama --}}
                                                <div class="mb-3">
                                                    <h4 class="fw-bold mb-0">Peralatan Utama</h4>
                                                    <small class="text-muted">Maklumat peralatan utama yang
                                                        digunakan</small>
                                                </div>

                                                @php
                                                $mainEquipment = !empty($mainEquipment) ? $mainEquipment : [['name' =>
                                                '', 'quantity' => '', 'condition' => '', 'file_path' => '']];
                                                @endphp

                                                @foreach ($mainEquipment as $index => $equipment)
                                                <div class="row mb-2">
                                                    {{-- Nama Peralatan --}}
                                                    <div class="col-md-4 mb-2">
                                                        <label for="main_name_{{ $index }}" class="form-label">Nama
                                                            Peralatan <span class="text-danger">*</span></label>
     <select name="main[{{ $index }}][name]" id="main_name_{{ $index }}" class="form-select" required>
    <option disabled {{ empty($equipment['name']) ? 'selected' : '' }}>Pilih Peralatan</option>
    @foreach ($jenisPeralatan as $name)
        <option value="{{ $name }}"
            {{ old("main.$index.name", $equipment['name'] ?? '') == $name ? 'selected' : '' }}>
            {{ $name }}
        </option>
    @endforeach
</select>

          @if (!empty($equipment['file_path']))
                <div class="text-success small mt-1">
                    Fail telah dimuat naik
                </div>
            @endif

                                                    </div>

                                                    {{-- Kuantiti --}}
                                                    <div class="col-md-1 mb-2">
                                                        <label for="main_quantity_{{ $index }}"
                                                            class="form-label">Kuantiti <span
                                                                class="text-danger">*</span></label>
                                                        <input type="number" name="main[{{ $index }}][quantity]"
                                                            id="main_quantity_{{ $index }}" class="form-control"
                                                            placeholder="Kuantiti" min="1"
                                                            value="{{ old('main.' . $index . '.quantity', $equipment['quantity'] ?? '') }}"
                                                            required>
                                                    </div>

                                                    {{-- Condition --}}
                                                    <div class="col-md-2 mb-2">
                                                        <label for="main_condition_{{ $index }}"
                                                            class="form-label">Keadaan <span
                                                                class="text-danger">*</span></label>
                                                        <select name="main[{{ $index }}][condition]"
                                                            class="form-select mb-2" required>
                                                            <option value="" disabled {{ empty($equipment['condition'])
                                                                ? 'selected' : '' }}>Pilih Keadaan Peralatan</option>
                                                            @foreach ($jenisKeadaan as $id => $name)
                                                            <option value="{{ $name }}" {{ old('main.' . $index
                                                                . '.condition' , $equipment['condition'] ?? '' )==$name
                                                                ? 'selected' : '' }}>
                                                                {{ $name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    {{-- Fail --}}
                                                    <div class="col-md-4 mb-2">
                                                        <label for="main_file_{{ $index }}" class="form-label">Fail
                                                            <span class="text-danger">*</span></label>
                                                        <input type="file" name="main[{{ $index }}][file]"
                                                            id="main_file_{{ $index }}" class="form-control mb-2"
                                                            accept=".jpg,.jpeg,.png,.pdf,.docx">
                                                        <small class="text-muted d-block mb-2">
                                                            Format dibenarkan: JPG, JPEG, PNG, PDF, DOCX. Saiz maksimum:
                                                            2MB.aaa
                                                        </small>

                                                    </div>

                                                    {{-- Preview --}}
                                                    <div class="col-md mb-2 mt-7 text-center">
                                                        @if (!empty($equipment['file_path']))
                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#fileModalMain{{ $index }}">
                                                            <i class="fa fa-search p-1"></i>
                                                        </button>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- Modal --}}
                                                @if (!empty($equipment['file_path']))
                                                <div class="modal fade" id="fileModalMain{{ $index }}" tabindex="-1"
                                                    aria-labelledby="fileModalMainLabel{{ $index }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="fileModalMainLabel{{ $index }}">Paparan Faildd
                                                                    Peralatan Utama</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                            </div>
                                                            <div class="modal-body" style="height: 80vh;">
                                                                <iframe
                                                                    src="{{ route('pindahPangkalan.laporanLpi-03.viewEquipmentFile', ['application_id' => $application->id, 'type' => 'main', 'index' => $index]) }}"
                                                                    style="width: 100%; height: 100%;"
                                                                    frameborder="0"></iframe>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                @endforeach

                                                <hr>

                                                {{-- Peralatan Tambahan --}}
                                                <div class="mb-5">
                                                    <div class="mb-3">
                                                        <h4 class="fw-bold mb-0">Peralatan Tambahan</h4>
                                                        <small class="text-muted">Senaraikan peralatan tambahan
                                                            (maksimum 5)</small>
                                                    </div>

                                                    @for ($i = 0; $i < 5; $i++) @php
                                                        $additional=$additionalEquipments[$i] ?? []; @endphp <div
                                                        class="row mb-3">
                                                        {{-- Nama Peralatan --}}
                                                        <div class="col-md-4 mb-2">
                                                            <label class="form-label">Peralatan {{ $i + 1 }}</label>
                                                          <select name="additional[{{ $i }}][name]" class="form-select" required>
    <option disabled {{ empty(old('additional.' . $i . '.name', $additional['name'] ?? '')) ? 'selected' : '' }}>
        Pilih Peralatan
    </option>
    @foreach ($jenisPeralatan as $name)
        <option value="{{ $name }}"
            {{ old("additional.$i.name", $additional['name'] ?? '') == $name ? 'selected' : '' }}>
            {{ $name }}
        </option>
    @endforeach
</select>

  {{-- File uploaded notice --}}
            @if (!empty($additional['file_path']))
                <div class="text-success small mt-1">
                    Fail telah dimuat naik
                </div>
            @endif

                                                        </div>

                                                        {{-- Kuantiti --}}
                                                        <div class="col-md-1 mb-2">
                                                            <label class="form-label">Kuantiti</label>
                                                            <input type="number" name="additional[{{ $i }}][quantity]"
                                                                class="form-control" placeholder="Kuantiti" min="1"
                                                                value="{{ old('additional.' . $i . '.quantity', $additional['quantity'] ?? '') }}">
                                                        </div>

                                                        {{-- Condition --}}
                                                        <div class="col-md-2 mb-2">
                                                            <label class="form-label">Keadaan Peralatan</label>
                                                            <select name="additional[{{ $i }}][condition]"
                                                                class="form-select mb-2">
                                                                <option value="" disabled selected>Pilih Keadaan
                                                                    Peralatan</option>
                                                                @foreach ($jenisKeadaan as $id => $name)
                                                                <option value="{{ $name }}" {{ old('additional.' . $i
                                                                    . '.condition' , $additional['condition'] ?? ''
                                                                    )==$name ? 'selected' : '' }}>
                                                                    {{ $name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        {{-- Fail --}}
                                                        <div class="col-md-4 mb-2">
                                                            <label class="form-label">Fail</label>
                                                            <input type="file" name="additional[{{ $i }}][file]"
                                                                class="form-control mb-2"
                                                                accept=".jpg,.jpeg,.png,.pdf,.docx">
                                                            <small class="text-muted d-block">Format dibenarkan: JPG,
                                                                JPEG, PNG, PDF, DOCX. Saiz maksimum: 2MB.</small>
                                                        </div>

                                                        {{-- Preview Button --}}
                                                        <div class="col-md-1 mb-2 mt-7 text-center">
                                                            @if (!empty($additional['file_path']))
                                                            <button type="button" class="btn btn-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#fileModalAdditional{{ $i }}">
                                                                <i class="fa fa-search p-1"></i>
                                                            </button>
                                                            @endif
                                                        </div>
                                                </div>

                                                {{-- Modal for Additional Equipment --}}
                                                @if (!empty($additional['file_path']))
                                                <div class="modal fade" id="fileModalAdditional{{ $i }}" tabindex="-1"
                                                    aria-labelledby="fileModalAdditionalLabel{{ $i }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="fileModalAdditionalLabel{{ $i }}">Paparan Fail
                                                                    Peralatan Tambahan {{ $i + 1 }}</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                            </div>
                                                            <div class="modal-body" style="height: 80vh;">
                                                                <iframe
                                                                    src="{{ route('pindahPangkalan.laporanLpi-03.viewEquipmentFile', ['application_id' => $application->id, 'type' => 'additional', 'index' => $i]) }}"
                                                                    style="width: 100%; height: 100%;"
                                                                    frameborder="0"></iframe>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                @endfor
                                        </div>

                                        <hr>

                                        {{-- Peralatan Ditemui Semasa Pemeriksaan --}}
                                        <div class="mb-5">
                                            <div class="card-header mb-3 pl-0 mt-5">
                                                <h4 class="fw-bold mb-0">Peralatan Ditemui Semasa Pemeriksaan</h4>
                                                <small class="text-muted">Masukkan peralatan tambahan yang ditemui
                                                    semasa pemeriksaan.</small>
                                            </div>

                                            <div id="foundItemsContainer">
                                                @forelse($foundEquipments as $found)
                                                <div class="row mb-3" id="foundItemRow{{ $loop->index }}">
                                                    <div class="col-md-10 mb-2">
                                                   <select name="found_item_name[]" class="form-select" required>
    <option disabled {{ empty(old("found_item_name.$loop->index", $found->item ?? '')) ? 'selected' : '' }}>
        Pilih Peralatan
    </option>
    @foreach ($jenisPeralatan as $name)
        <option value="{{ $name }}"
            {{ old("found_item_name.$loop->index", $found->item ?? '') == $name ? 'selected' : '' }}>
            {{ $name }}
        </option>
    @endforeach
</select>

 {{-- Show file notice if uploaded --}}

                                                    </div>
                                                    <div class="col-md-1 mb-2">
                                                        <input type="number" name="found_item_quantity[]"
                                                            class="form-control" min="1" value="{{ old("
                                                            found_item_quantity.$loop->index", $found->quantity ?? 1)
                                                        }}" required>
                                                    </div>
                                                    <div class="col-md-1 text-center">
                                                        <button type="button" class="btn btn-danger remove-item-btn">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                @empty
                                                <div class="row mb-3" id="foundItemRow0">
                                                    <div class="col-md-10 mb-2">
                                                        <select name="found_item_name[]" class="form-select" required>
    <option disabled selected>Pilih Peralatan</option>
    @foreach ($jenisPeralatan as $name)
        <option value="{{ $name }}">{{ $name }}</option>
    @endforeach
</select>

                                                    </div>
                                                    <div class="col-md-1 mb-2">
                                                        <input type="number" name="found_item_quantity[]"
                                                            class="form-control" min="1" placeholder="0">
                                                    </div>
                                                    <div class="col-md-1 text-center">
                                                        <button type="button"
                                                            class="btn btn-danger remove-item-btn d-none">
                                                            <i class="fa fa-trash"></i> Buang
                                                        </button>
                                                    </div>
                                                </div>
                                                @endforelse
                                            </div>

                                            <div class="mb-4">
                                                <button type="button" class="btn btn-primary" id="addItemRowBtn">
                                                    <i class="fa fa-plus"></i> Tambah Peralatan
                                                </button>
                                            </div>

                                            @push('scripts')
                                            <script>
                                                document.getElementById('addItemRowBtn').addEventListener('click', function () {
                                                    const container = document.querySelector('#foundItemsContainer');
                                                    const rowCount = container.querySelectorAll('.row').length;
                                                    const row = document.createElement('div');
                                                    row.classList.add('row', 'mb-3');
                                                    row.setAttribute('id', `foundItemRow${rowCount}`);
                                                    row.innerHTML = `
                                                        <div class="col-md-10 mb-2">
                                                           <select name="found_item_name[]" class="form-select" required>
    <option disabled selected>Pilih Peralatan</option>
    @foreach ($jenisPeralatan as $name)
        <option value="{{ $name }}">{{ $name }}</option>
    @endforeach
</select>

                                                        </div>
                                                        <div class="col-md-1 mb-2">
                                                            <input type="number" name="found_item_quantity[]" class="form-control" min="1" placeholder="0" required>
                                                        </div>
                                                        <div class="col-md-1 text-center">
                                                            <button type="button" class="btn btn-danger remove-item-btn">
                                                                <i class="fa fa-trash p-1"></i>
                                                            </button>
                                                        </div>
                                                    `;
                                                    container.appendChild(row);
                                                });

                                                document.querySelector('#foundItemsContainer').addEventListener('click', function (e) {
                                                    if (e.target.closest('.remove-item-btn')) {
                                                        e.target.closest('.row').remove();
                                                    }
                                                });
                                            </script>
                                            @endpush
                                        </div>

                                        </form>
                                    </div>

                                    <div class="tab-pane fade" id="content-tab5" role="tabpanel"
                                        aria-labelledby="tab5-link">
                                        <form id="form-tab5"
                                            action="{{ route('pindahPangkalan.laporanLpi-03.storePengesahanPemeriksaan', $application->id) }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf

                                            <!-- Keadaan Vesel, Tarikh, Lokasi -->
                                            <div class="card-header mb-3 pl-0">
                                                <h4 class="fw-bold mb-0">Maklumat Pemeriksaan</h4>
                                                <small class="text-muted">Isikan maklumat keadaan vesel, tarikh
                                                    dan lokasi
                                                    pemeriksaan</small>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-md-4">
                                                    <label class="form-label">Keadaan Vesel</label>
                                                    <select required class="form-select" name="keadaan_vesel">
                                                        <option selected disabled>Pilih Keadaan Vesel</option>
                                                        @foreach ($jenisKeadaan as $id => $name)
                                                        <option value="{{ $name }}" {{ old('keadaan_vesel',
                                                            $inspection->vessel_condition ?? null) == $name ?
                                                            'selected' : '' }}>
                                                            {{ $name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Tarikh Pemeriksaan</label>
                                                    <input class="form-control" name="inspection_date" type="date"
                                                        value="{{ old('inspection_date', $inspection->inspection_date ?? '') }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Lokasi Pemeriksaan</label>
                                                    <input class="form-control" name="inspection_location" type="text"
                                                        value="{{ old('inspection_location', $inspection->inspection_location ?? '') }}"
                                                        placeholder="Masukkan Lokasi Pemeriksaan">

                                                </div>
                                            </div>

                                            <!-- Borang Kehadiran -->
                                            <div class="mb-4">
                                                <div class="card-header mb-3 pl-0">
                                                    <h4 class="fw-bold mb-0">Borang Kehadiran</h4>
                                                    <small class="text-muted">Muat naik borang kehadiran semasa
                                                        pemeriksaan
                                                        dijalankan</small>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center gap-3">
                                                    <input class="form-control" name="attendance_form_path" type="file">

                                                    @if (!empty($inspection->attendance_form_path))
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#modalAttendancePreview">
                                                        <i class="fa fa-search"></i>
                                                    </button>

                                                    <div class="modal fade" id="modalAttendancePreview" tabindex="-1"
                                                        aria-labelledby="modalAttendancePreviewLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-xl modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Pratonton Borang Kehadiran
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Tutup"></button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    <iframe
                                                                        src="{{ route('pindahPangkalan.laporanLpi-03.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'attendance_form_path']) }}"
                                                                        width="100%" height="600px"
                                                                        frameborder="0"></iframe>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>

                                                <small class="form-text text-muted">Muat naik fail dalam format
                                                    JPG, PNG, atau PDF (maksimum
                                                    2MB).</small>
                                                      <!-- File Uploaded Notice -->
@if (!empty($inspection?->attendance_form_path))
    <div class="text-success small mt-2">
        Fail telah dimuat naik
    </div>
@endif

                                            </div>

                                            <div class="mb-4">
                                                <div class="card-header mb-3 pl-0">
                                                    <h4 class="fw-bold mb-0">Gambar Vesel / Peralatan</h4>
                                                    <small class="text-muted">Muat naik gambar vesel atau
                                                        peralatan berkaitan</small>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center gap-3">
                                                    <input class="form-control" name="vessel_image_path" type="file">

                                                    @if (!empty($inspection->vessel_image_path))
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#modalVesselImage">
                                                        <i class="fa fa-search"></i>
                                                    </button>

                                                    <div class="modal fade" id="modalVesselImage" tabindex="-1"
                                                        aria-labelledby="modalVesselImageLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-xl modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Gambar Vesel / Peralatan
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Tutup"></button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    <iframe
                                                                        src="{{ route('pindahPangkalan.laporanLpi-03.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'vessel_image_path']) }}"
                                                                        width="100%" height="600px"
                                                                        frameborder="0"></iframe>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>

                                                <small class="form-text text-muted">Muat naik fail dalam format
                                                    JPG, PNG, atau PDF (maksimum
                                                    2MB).</small>
                                                      <!-- File Uploaded Notice -->

        @if (!empty($inspection?->vessel_image_path))
    <div class="text-success small mt-2">
        Fail telah dimuat naik
    </div>
@endif
                                            </div>

                                            <div class="mb-4">
                                                <div class="card-header mb-3 pl-0">
                                                    <h4 class="fw-bold mb-0">Gambar Pemeriksa Bersama Pemilik
                                                    </h4>
                                                    <small class="text-muted">Muat naik gambar pemeriksa bersama
                                                        pemilik vesel</small>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center gap-3">
                                                    <input class="form-control" name="inspector_owner_image_path"
                                                        type="file">

                                                    @if (!empty($inspection->inspector_owner_image_path))
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#modalInspectorOwner">
                                                        <i class="fa fa-search"></i>
                                                    </button>

                                                    <div class="modal fade" id="modalInspectorOwner" tabindex="-1"
                                                        aria-labelledby="modalInspectorOwnerLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-xl modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Gambar Pemeriksa Bersama
                                                                        Pemilik</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Tutup"></button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    <iframe
                                                                        src="{{ route('pindahPangkalan.laporanLpi-03.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'inspector_owner_image_path']) }}"
                                                                        width="100%" height="600px"
                                                                        frameborder="0"></iframe>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>

                                                <small class="form-text text-muted">Muat naik fail dalam format
                                                    JPG, PNG, atau PDF (maksimum
                                                    2MB).</small>

                                                      @if (!empty($inspection->inspector_owner_image_path))
            <div class="text-success small">
                Fail telah dimuat naik
            </div>
        @endif



                                            </div>

                                            <!-- Sokongan -->
                                            <div class="card-header mb-3 pl-0">
                                                <h4 class="fw-bold mb-0">Sokongan</h4>
                                                <small class="text-muted">Sila pilih sama ada anda menyokong
                                                    permohonan ini</small>
                                            </div>
                                            <div class="d-flex mb-4 gap-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="is_support"
                                                        id="supportYes" value="1" {{ old('is_support',
                                                        $inspection->is_support ?? '') == '1'
                                                    ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="supportYes">Sokong</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="is_support"
                                                        id="supportNo" value="0" {{ old('is_support',
                                                        $inspection->is_support ?? '') == '0'
                                                    ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="supportNo">Tidak
                                                        Sokong</label>
                                                </div>
                                            </div>

                                            <!-- Ulasan -->
                                            <div class="card-header mb-3 pl-0">
                                                <h4 class="fw-bold mb-0">Ulasan</h4>
                                                <small class="text-muted">Sila berikan ulasan berkaitan
                                                    pemeriksaan</small>
                                            </div>
                                            <div class="mb-4">
                                                <textarea class="form-control" name="inspection_summary" rows="4"
                                                    placeholder="Masukkan ulasan...">{{ old('inspection_summary', $inspection->inspection_summary ?? '') }}</textarea>
                                            </div>

                                        </form>
                                    </div>

                                </div>

                                {{-- card --}}

                            </div>

                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-end gap-3">
                            <!-- Back and Next Buttons -->
                            <div class="d-flex gap-3">
                                <button id="backTabBtn" type="button" class="btn btn-light"
                                    style="width:120px">Kembali</button>

                                <!-- Simpan Buttons for Each Tab -->
                                <button id="simpanBtn1" type="submit" class="btn btn-warning" form="form-tab1"
                                    style="width:120px; display:none">Simpan</button>
                                <button id="simpanBtn2" type="submit" class="btn btn-warning" form="form-tab2"
                                    style="width:120px; display:none">Simpan</button>
                                <button id="simpanBtn3" type="submit" class="btn btn-warning" form="form-tab3"
                                    style="width:120px; display:none">Simpan</button>
                                <button id="simpanBtn4" type="submit" class="btn btn-warning" form="form-tab4"
                                    style="width:120px; display:none">Simpan</button>
                                <button id="simpanBtn5" type="submit" class="btn btn-warning" form="form-tab5"
                                    style="width:120px; display:none">Simpan</button>

                                <button id="nextTabBtn" type="button" class="btn btn-light"
                                    style="width:120px">Seterusnya</button>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-3">
                                <!-- Final Submission Form -->
                                <form id="form-submit-final"
                                    action="{{ route('pindahPangkalan.laporanLpi-03.store', $application->id) }}"
                                    method="POST">
                                    @csrf
                                </form>

                                <!-- Hantar Button -->
                                <button id="hantarBtn" type="submit" class="btn btn-success" form="form-submit-final"
                                    style="width:120px; display:none">Hantar</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

@endsection

@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
            // Convert all prefilled input and textarea values to uppercase
            $("input[type=text], textarea").each(function() {
                const currentVal = $(this).val();
                if (currentVal && typeof currentVal === "string") {
                    $(this).val(currentVal.toUpperCase());
                }
            });

            // Dynamic input conversion as the user types
            $(document).on('input', "input[type=text], textarea", function() {
                $(this).val(function(_, val) {
                    return val.toUpperCase();
                });
            });
        });
</script>

<script>
    // Display success message from Laravel session
        var msgSuccess = @json(Session::get('success'));
        var existSuccess = @json(Session::has('success'));

        if (existSuccess) {
            alert(msgSuccess);
        }

        // Display error message from Laravel session
        var msgError = @json(Session::get('error'));
        var existError = @json(Session::has('error'));

        if (existError) {
            alert(msgError);
        }
</script>

{{-- Tab --}}
<script>
    let currentTab = 1;
        const totalTabs = 5;

        function toggleButtons() {
            // Toggle Simpan buttons
            for (let i = 1; i <= totalTabs; i++) {
                document.getElementById(`simpanBtn${i}`).style.display = (currentTab === i) ? "inline-block" : "none";
            }

            // Toggle Hantar button
            document.getElementById("hantarBtn").style.display = (currentTab === totalTabs) ? "inline-block" : "none";
        }

        document.getElementById("nextTabBtn").addEventListener("click", () => {
            if (currentTab === totalTabs) return alert("Ini adalah tab terakhir.");

            document.getElementById(`tab${currentTab}-link`).classList.remove("active");
            document.getElementById(`content-tab${currentTab}`).classList.remove("show", "active");

            currentTab++;

            document.getElementById(`tab${currentTab}-link`).classList.add("active");
            document.getElementById(`content-tab${currentTab}`).classList.add("show", "active");

            toggleButtons();
        });

        document.getElementById("backTabBtn").addEventListener("click", () => {
            if (currentTab === 1) return alert("Ini adalah tab pertama.");

            document.getElementById(`tab${currentTab}-link`).classList.remove("active");
            document.getElementById(`content-tab${currentTab}`).classList.remove("show", "active");

            currentTab--;

            document.getElementById(`tab${currentTab}-link`).classList.add("active");
            document.getElementById(`content-tab${currentTab}`).classList.add("show", "active");

            toggleButtons();
        });

        toggleButtons(); // Init
</script>
{{--
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dynamicTable = document.getElementById('dynamicTable');
        const addRowButton = document.getElementById('addRowButton');
        // Add Row Functionality
        addRowButton.addEventListener('click', function() {
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
<td></td>
<td>
    <select required class="form-select" name="new_peralatan[]">
        <option selected disabled>Pilih Peralatan</option>
        @foreach ($equipmentFound2 as $equip)
        <option value="{{ $equip->id }}">{{ $equip->name }}</option>
@endforeach
</select>
</td>
<td><input class="form-control" name="new_kuantiti[]" type="number" placeholder="Kuantiti"></td>
<td><button class="btn btn-danger btn-remove col-md" type="button">Padam</button></td>
`;

dynamicTable.tBodies[0].appendChild(newRow);
updateRowNumbers(); // Update row numbers after adding a new row
});

// Remove Row Functionality
dynamicTable.addEventListener('click', function(e) {
if (e.target.classList.contains('btn-remove')) {
e.target.closest('tr').remove();
updateRowNumbers(); // Update row numbers after removing a row
}
});
// Function to Update Row Numbers
function updateRowNumbers() {
const rows = dynamicTable.tBodies[0].rows;
Array.from(rows).forEach((row, index) => {
row.cells[0].textContent = `${index + 1}.`;
});
}
// Initialize row numbers on page load
updateRowNumbers();
});

</script> --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
            function toggleSafetyFields() {
                const status = document.getElementById('safety_jacket_status').value;
                const quantity = document.getElementById('safety_jacket_quantity');
                const condition = document.getElementById('safety_jacket_condition');
                const fileInput = document.querySelector('input[name="safety_jacket_image_path"]');

                const isDisabled = status === '0';
                quantity.disabled = isDisabled;
                condition.disabled = isDisabled;
                fileInput.disabled = isDisabled;
            }

            const select = document.getElementById('safety_jacket_status');
            select.addEventListener('change', toggleSafetyFields);
            toggleSafetyFields(); // initial state
        });
</script>
@endpush
