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
                            <li class="breadcrumb-item"><a href="http://127.0.0.1:8000/tukarEnjin/laporanLpi-05">{{
                                    \Illuminate\Support\Str::ucfirst(strtolower($applicationType->name)) }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $moduleName->name }}</a></li>
                            {{-- <li class="breadcrumb-item active" aria-current="page">laporanLpii</a></li> --}}

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
                                     <div class="row">
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
                                                                value="{{ $userDetail->icno ?? 'Tidak Diketahui' }}"
                                                                readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pangkalan</td>
                                                        <td>:</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $jetty->jetty_name ?? 'Tidak Diketahui' }}"
                                                                readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>No. Pendaftaran Vesel</td>
                                                        <td>:</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $vessel->registration_number ?? 'Tiada Vesel' }}"
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
                                                        <td class="col-md-3">Jenis Permohonan</td>
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
                                                        <td>Tarikh Permohonan</td>
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
                                                    action="{{ route('tukarEnjin.laporanLpi-05.storeMaklumatVesel', $application->id) }}"
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

                                                        <div class="d-flex align-items-center gap-3">
                                                            <div class="custom-file w-100">
                                                                <input type="file" class="custom-file-input"
                                                                    id="overall_image_path" name="overall_image_path"
                                                                    accept=".jpg,.jpeg,.png">
                                                                <label class="custom-file-label"
                                                                    for="overall_image_path">
                                                                    {{ !empty($inspection?->overall_image_path) ?
                                                                    basename($inspection->overall_image_path) : 'Pilih
                                                                    Fail' }}
                                                                </label>
                                                            </div>

                                                            @if (!empty($inspection?->overall_image_path))
                                                            <a class="btn btn-primary"
                                                                href="{{ route('tukarEnjin.laporanLpi-05.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'overall_image_path']) }}"
                                                                target="_blank">
                                                                <i class="fa fa-search"></i>
                                                            </a>
                                                            @endif
                                                        </div>

                                                        <small class="form-text text-muted">
                                                            Muat naik fail dalam format JPG atau PNG (maksimum 2MB).
                                                        </small>
                                                    </div>

                                                    @push('scripts')
                                                    <script>
                                                        document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('overall_image_path');
        const label = input?.nextElementSibling;

        input?.addEventListener('change', function () {
            const fileName = this.files.length > 0 ? this.files[0].name : 'Pilih Fail';
            if (label) label.textContent = fileName;
        });
    });
                                                    </script>
                                                    @endpush

                                                </form>
                                            </div>

                                            <div class="tab-pane fade" id="content-tab2" role="tabpanel"
                                                aria-labelledby="tab2-link">
                                                <form id="form-tab2"
                                                    action="{{ route('tukarEnjin.laporanLpi-05.storeMaklumatEnjin', $application->id) }}"
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
                                                            <select class="form-select" name="engine_brand">
                                                                <option value="">Pilih Jenama</option>
                                                                @foreach ($engineBrandList as $value => $label)
                                                                <option value="{{ $value }}" {{ old('engine_brand',
                                                                    $inspection->engine_brand ?? '') == $value ?
                                                                    'selected' : '' }}>
                                                                    {{ $label }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Model</label>
                                                            <input class="form-control" name="engine_model" type="text"
                                                                value="{{ old('engine_model', $inspection->engine_model ?? '') }}"
                                                                placeholder="Masukkan Model">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Kuasa Kuda (kk)</label>
                                                            <input class="form-control" name="horsepower" type="text"
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
                                                    <div class="mb-4">
                                                        <div class="mb-4">
                                                            <label class="form-label">Gambar Enjin</label>

                                                            <div class="d-flex align-items-center gap-3">
                                                                <div class="custom-file w-100">
                                                                    <input type="file" class="custom-file-input"
                                                                        id="engine_image_path" name="engine_image_path"
                                                                        accept=".jpg,.jpeg,.png">

                                                                    <label class="custom-file-label"
                                                                        for="engine_image_path">
                                                                        {{ !empty($inspection?->engine_image_path) ?
                                                                        basename($inspection->engine_image_path) :
                                                                        'Pilih Fail' }}
                                                                    </label>
                                                                </div>

                                                                @if (!empty($inspection?->engine_image_path))
                                                                <a class="btn btn-primary"
                                                                    href="{{ route('tukarEnjin.laporanLpi-05.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'engine_image_path']) }}"
                                                                    target="_blank">
                                                                    <i class="fa fa-search"></i>
                                                                </a>
                                                                @endif
                                                            </div>

                                                            <small class="form-text text-muted">
                                                                Muat naik fail dalam format JPG atau PNG (maksimum 2MB).
                                                            </small>
                                                        </div>

                                                        @push('scripts')
                                                        <script>
                                                            document.addEventListener('DOMContentLoaded', function () {
                                                            const input = document.getElementById('engine_image_path');
                                                            const label = input?.nextElementSibling;

                                                            input?.addEventListener('change', function () {
                                                                const fileName = this.files.length > 0 ? this.files[0].name : 'Pilih Fail';
                                                                if (label) label.textContent = fileName;
                                                            });
                                                        });
                                                        </script>
                                                        @endpush

                                                        <!-- Gambar No. Enjin -->
                                                        <div class="mb-4">
                                                            <label class="form-label">Gambar No. Enjin</label>

                                                            <div class="d-flex align-items-center gap-3">
                                                                <div class="custom-file w-100">
                                                                    <input type="file" class="custom-file-input"
                                                                        id="engine_number_image_path"
                                                                        name="engine_number_image_path"
                                                                        accept=".jpg,.jpeg,.png">
                                                                    <label class="custom-file-label"
                                                                        for="engine_number_image_path">
                                                                        {{
                                                                        !empty($inspection?->engine_number_image_path) ?
                                                                        basename($inspection->engine_number_image_path)
                                                                        : 'Pilih Fail' }}
                                                                    </label>
                                                                </div>

                                                                @if (!empty($inspection?->engine_number_image_path))
                                                                <a class="btn btn-primary"
                                                                    href="{{ route('tukarEnjin.laporanLpi-05.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'engine_number_image_path']) }}"
                                                                    target="_blank">
                                                                    <i class="fa fa-search"></i>
                                                                </a>
                                                                @endif
                                                            </div>

                                                            <small class="form-text text-muted">
                                                                Muat naik fail dalam format JPG atau PNG (maksimum 2MB).
                                                            </small>
                                                        </div>

                                                        @push('scripts')
                                                        <script>
                                                            document.addEventListener('DOMContentLoaded', function () {
                                                                const fileInput = document.getElementById('engine_number_image_path');
                                                                const fileLabel = fileInput?.nextElementSibling;

                                                                fileInput?.addEventListener('change', function () {
                                                                    const fileName = this.files.length > 0 ? this.files[0].name : 'Pilih Fail';
                                                                    if (fileLabel) fileLabel.textContent = fileName;
                                                                });
                                                            });
                                                        </script>
                                                        @endpush
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="tab-pane fade" id="content-tab3" role="tabpanel"
                                                aria-labelledby="tab3-link">
                                                <form id="form-tab3"
                                                    action="{{ route('tukarEnjin.laporanLpi-05.storePeralatanKeselamatan', $application->id) }}"
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
                                                                @foreach ($jenisKeadaan as $name)
                                                                <option value="{{ $name }}" {{
                                                                    old('safety_jacket_condition', $inspection->
                                                                    safety_jacket_condition ?? '') == $name ? 'selected'
                                                                    : '' }}>
                                                                    {{ $name }}
                                                                </option>
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

                                                        <div class="d-flex align-items-center gap-3">
                                                            <div class="custom-file w-100">
                                                                <input type="file" class="custom-file-input"
                                                                    id="safety_jacket_image_path"
                                                                    name="safety_jacket_image_path"
                                                                    accept=".jpg,.jpeg,.png">
                                                                <label class="custom-file-label"
                                                                    for="safety_jacket_image_path">
                                                                    {{ !empty($inspection?->safety_jacket_image_path) ?
                                                                    basename($inspection->safety_jacket_image_path) :
                                                                    'Pilih Fail' }}
                                                                </label>
                                                            </div>

                                                            @if (!empty($inspection?->safety_jacket_image_path))
                                                            <a class="btn btn-primary"
                                                                href="{{ route('tukarEnjin.laporanLpi-05.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'safety_jacket_image_path']) }}"
                                                                target="_blank">
                                                                <i class="fa fa-search"></i>
                                                            </a>
                                                            @endif
                                                        </div>

                                                        <small class="form-text text-muted">Muat naik fail dalam format
                                                            JPG atau PNG (maksimum 2MB).</small>

                                                    </div>

                                                    @push('scripts')
                                                    <script>
                                                        document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('safety_jacket_image_path');
        const label = input?.nextElementSibling;

        input?.addEventListener('change', function () {
            const fileName = this.files.length > 0 ? this.files[0].name : 'Pilih Fail';
            if (label) label.textContent = fileName;
        });
    });
                                                    </script>
                                                    @endpush

                                                </form>
                                            </div>

                                            <div class="tab-pane fade" id="content-tab4" role="tabpanel"
                                                aria-labelledby="tab4-link">
                                                <form id="form-tab4"
                                                    action="{{ route('tukarEnjin.laporanLpi-05.storePeralatanMenangkapIkan', $application->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf

                                                   <!-- Peralatan Utama -->
<section>
    <div class="mb-3">
        <h4 class="fw-bold mb-0">Peralatan Utama</h4>
        <small class="text-muted">Maklumat peralatan utama yang digunakan</small>
        <hr>
    </div>

    <div class="form-group">
        <div class="row mb-3 align-items-start">
            <!-- Equipment Dropdown -->
            <div class="col-md-4">
                <label for="main_0_name" class="form-label">Peralatan <span class="text-danger">*</span></label>
                <select class="form-select" id="main_0_name" name="main[0][name]" required>
                    <option value="">Sila Pilih</option>
                    @foreach ($equipmentList as $id => $name)
                        <option value="{{ $name }}"
                            {{ old('main.0.name', $mainInspectionEquipment[0]->name ?? '') == $name ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Quantity Input -->
            <div class="col-md-1">
                <label for="main_0_quantity" class="form-label">Kuantiti <span class="text-danger">*</span></label>
                <input type="number" name="main[0][quantity]" id="main_0_quantity" class="form-control"
                    min="1"
                    value="{{ old('main.0.quantity', $mainInspectionEquipment[0]->quantity ?? '') }}"
                    required>
            </div>

            <!-- File Upload Input -->
            <div class="col-md">
                <label for="main_0_file" class="form-label">
                    Gambar Peralatan
                    @if (empty($mainInspectionEquipment[0]->file_path ?? null)) <span class="text-danger">*</span> @endif
                </label>

                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="main_0_file" name="main[0][file]"
                        accept=".jpg,.jpeg,.png,.pdf"
                        @if(empty($mainInspectionEquipment[0]->file_path ?? null)) required @endif>

                    <label class="custom-file-label" for="main_0_file">
                        {{ basename($mainInspectionEquipment[0]->file_path ?? '') ?: 'Pilih Fail' }}
                    </label>
                </div>

                <small class="text-muted">
                    Format dibenarkan: JPG, JPEG, PNG, PDF. Saiz maksimum: 5MB.
                </small>
            </div>

            <!-- View File Button (if file exists) -->
           @if (!empty($mainInspectionEquipment[0]->file_path ?? null))
    <div class="col-md-auto text-center">
        <label class="form-label d-none d-md-block">&nbsp;</label>
        <button type="button" class="btn btn-primary"
            onclick="window.open('{{ route('tukarEnjin.laporanLpi-05.viewEquipmentFile', ['id' => $mainInspectionEquipment[0]->id, 'type' => 'UTAMA']) }}', '_blank')">
            <i class="fa fa-search p-1"></i>
        </button>
    </div>
@endif

        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('main_0_file');
        const fileLabel = fileInput.nextElementSibling;

        fileInput.addEventListener('change', function () {
            fileLabel.textContent = this.files.length > 0 ? this.files[0].name : 'Pilih Fail';
        });
    });
</script>
@endpush

                                                  <!-- Peralatan Tambahan -->
<section>
    <div class="mb-3">
        <h4 class="fw-bold mb-0">Peralatan Tambahan</h4>
        <small class="text-muted">Maklumat peralatan tambahan yang digunakan (pilihan)</small>
        <hr>
    </div>

    <div class="form-group">
        @for ($i = 0; $i < 5; $i++)
            <div class="row mb-3 align-items-start">
                @php
                    $item = $additionalInspectionEquipment[$i] ?? null;
                @endphp

                <!-- Equipment Dropdown -->
                <div class="col-md-4">
                    <label for="additional_{{ $i }}_name" class="form-label">Peralatan</label>
                    <select class="form-select" id="additional_{{ $i }}_name" name="additional[{{ $i }}][name]">
                        <option value="">Sila Pilih</option>
                        @foreach ($equipmentList as $id => $name)
                            <option value="{{ $name }}"
                                {{ old("additional.$i.name", $item->name ?? '') == $name ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Quantity Input -->
                <div class="col-md-1">
                    <label for="additional_{{ $i }}_quantity" class="form-label">Kuantiti</label>
                    <input type="number" name="additional[{{ $i }}][quantity]"
                        id="additional_{{ $i }}_quantity"
                        class="form-control" min="1"
                        value="{{ old("additional.$i.quantity", $item->quantity ?? '') }}">
                </div>

                <!-- File Upload Input -->
                <div class="col-md">
                    <label for="additional_{{ $i }}_file" class="form-label">Gambar Peralatan</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input"
                            id="additional_{{ $i }}_file"
                            name="additional[{{ $i }}][file]"
                            accept=".jpg,.jpeg,.png,.pdf">
                        <label class="custom-file-label" for="additional_{{ $i }}_file">
                            {{ basename($item->file_path ?? '') ?: 'Pilih Fail' }}
                        </label>
                    </div>
                    <small class="text-muted">
                        Format dibenarkan: JPG, JPEG, PNG, PDF. Saiz maksimum: 5MB.
                    </small>
                </div>

                <!-- View File Button (if file exists) -->
                <!-- View File Button (if file exists) -->
@if (!empty($item->file_path ?? null))
    <div class="col-md-auto text-center">
        <label class="form-label d-none d-md-block">&nbsp;</label>
        <button type="button" class="btn btn-primary"
            onclick="window.open('{{ route('tukarEnjin.laporanLpi-05.viewEquipmentFile', ['id' => $item->id, 'type' => 'TAMBAHAN']) }}', '_blank')">
            <i class="fa fa-search p-1"></i>
        </button>
    </div>
@endif

            </div>
        @endfor
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        for (let i = 0; i < 5; i++) {
            const fileInput = document.getElementById(`additional_${i}_file`);
            const fileLabel = fileInput?.nextElementSibling;

            if (fileInput && fileLabel) {
                fileInput.addEventListener('change', function () {
                    fileLabel.textContent = this.files.length > 0 ? this.files[0].name : 'Pilih Fail';
                });
            }
        }
    });
</script>
@endpush

                                                    <section>
                                                        <div class="mb-5">
                                                            <div class="card-header mb-3 pl-0 mt-5">
                                                                <h4 class="fw-bold mb-0">Peralatan Ditemui Semasa
                                                                    Pemeriksaan</h4>
                                                                <small class="text-muted">Masukkan peralatan tambahan
                                                                    yang ditemui semasa pemeriksaan.</small>
                                                            </div>

                                                            <div id="foundItemsContainer">
                                                                @forelse($foundEquipments as $index => $found)
                                                                <div class="row mb-3" id="foundItemRow{{ $index }}">
                                                                    <div class="col-md-10 mb-2">
                                                                        <select name="found_item_name[]"
                                                                            class="form-select" required>
                                                                            <option disabled {{
                                                                                empty(old("found_item_name.$index",
                                                                                $found->item)) ? 'selected' : '' }}>
                                                                                Pilih Peralatan
                                                                            </option>
                                                                            @foreach ($equipmentList as $id => $name)
                                                                            <option value="{{ $name }}" {{
                                                                                old("found_item_name.$index", $found->
                                                                                item) == $name ? 'selected' : '' }}>
                                                                                {{ $name }}
                                                                            </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-1 mb-2">
                                                                        <input type="number"
                                                                            name="found_item_quantity[]"
                                                                            class="form-control" min="1" value="{{ old("
                                                                            found_item_quantity.$index",
                                                                            $found->quantity ?? 1) }}" required>
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
                                                                        <select name="found_item_name[]"
                                                                            class="form-select" required>
                                                                            <option disabled selected>Pilih Peralatan
                                                                            </option>
                                                                            @foreach ($equipmentList as $id => $name)
                                                                            <option value="{{ $name }}">{{ $name }}
                                                                            </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-1 mb-2">
                                                                        <input type="number"
                                                                            name="found_item_quantity[]"
                                                                            class="form-control" min="1"
                                                                            placeholder="0">
                                                                    </div>
                                                                    <div class="col-md-1 text-center">
                                                                        <button type="button"
                                                                            class="btn btn-danger remove-item-btn d-none">
                                                                            <i class="fa fa-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                @endforelse
                                                            </div>

                                                            <div class="mb-4">
                                                                <button type="button" class="btn btn-primary"
                                                                    id="addItemRowBtn">
                                                                    <i class="fa fa-plus"></i> Tambah Peralatan
                                                                </button>
                                                            </div>

                                                            @push('scripts')
                                                            <script>
                                                                const equipmentOptions = @json(array_values($equipmentList->toArray()));

            document.getElementById('addItemRowBtn').addEventListener('click', function () {
                const container = document.getElementById('foundItemsContainer');
                const rowCount = container.querySelectorAll('.row').length;

                const row = document.createElement('div');
                row.className = 'row mb-3';
                row.id = `foundItemRow${rowCount}`;

                let options = '<option disabled selected>Pilih Peralatan</option>';
                equipmentOptions.forEach(name => {
                    options += `<option value="${name}">${name}</option>`;
                });

                row.innerHTML = `
                    <div class="col-md-10 mb-2">
                        <select name="found_item_name[]" class="form-select" required>${options}</select>
                    </div>
                    <div class="col-md-1 mb-2">
                        <input type="number" name="found_item_quantity[]" class="form-control" min="1" placeholder="0" required>
                    </div>
                    <div class="col-md-1 text-center">
                        <button type="button" class="btn btn-danger remove-item-btn">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                `;
                container.appendChild(row);
            });

            document.getElementById('foundItemsContainer').addEventListener('click', function (e) {
                if (e.target.closest('.remove-item-btn')) {
                    e.target.closest('.row').remove();
                }
            });
                                                            </script>
                                                            @endpush
                                                        </div>
                                                    </section>

                                                </form>
                                            </div>

                                            {{-- <div class="tab-pane fade" id="content-tab4" role="tabpanel"
                                                aria-labelledby="tab4-link">
                                                <form id="form-tab4"
                                                    action="{{ route('tukarEnjin.laporanLpi-05.storePeralatanMenangkapIkan', $application->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf

                                            </div>

                                            <hr>

                                            <div class="mb-5">
                                                <div class="card-header mb-3 pl-0 mt-5">
                                                    <h4 class="fw-bold mb-0">Peralatan Ditemui Semasa
                                                        Pemeriksaan</h4>
                                                    <small class="text-muted">Masukkan peralatan tambahan yang
                                                        ditemui
                                                        semasa pemeriksaan.</small>
                                                </div>

                                                <div id="foundItemsContainer">
                                                    @forelse($foundEquipments as $found)
                                                    <div class="row mb-3" id="foundItemRow{{ $loop->index }}">
                                                        <div class="col-md-10 mb-2">
                                                            <select name="found_item_name[]" class="form-select"
                                                                required>
                                                                <option disabled {{ empty(old("found_item_name.$loop->
                                                                    index", $found->item ?? '')) ? 'selected' :
                                                                    '' }}>
                                                                    Pilih Peralatan
                                                                </option>
                                                                @foreach ($jenisPeralatan as $name)
                                                                <option value="{{ $name }}" {{
                                                                    old("found_item_name.$loop->
                                                                    index", $found->item ?? '') == $name ?
                                                                    'selected' : ''
                                                                    }}>
                                                                    {{ $name }}
                                                                </option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                        <div class="col-md-1 mb-2">
                                                            <input type="number" name="found_item_quantity[]"
                                                                class="form-control" min="1" value="{{ old("
                                                                found_item_quantity.$loop->index",
                                                            $found->quantity ?? 1)
                                                            }}" required>
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
                                                                <option disabled selected>Pilih Peralatan
                                                                </option>
                                                                @foreach ($jenisPeralatan as $name => $id)
                                                                <option value="{{ $id }}">{{ $name }}</option>
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
                                                            @foreach ($jenisPeralatan as $name => $id)
                                                                <option value="{{ $id }}">{{ $name }}</option>
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
                                        </div> --}}

                                        <div class="tab-pane fade" id="content-tab5" role="tabpanel"
                                            aria-labelledby="tab5-link">
                                            <form id="form-tab5"
                                                action="{{ route('tukarEnjin.laporanLpi-05.storePengesahanPemeriksaan', $application->id) }}"
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
                                                        <label class="form-label">Keadaan Vesel <span
                                                                class="text-danger">*</span> </label>
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
                                                        <label class="form-label">Tarikh Pemeriksaan <span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control" name="inspection_date" type="date"
                                                            value="{{ old('inspection_date', $inspection->inspection_date ?? '') }}"
                                                            max="{{ \Carbon\Carbon::today()->toDateString() }}"
                                                            required>

                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Lokasi Pemeriksaan</label>
                                                        <input class="form-control" name="inspection_location"
                                                            type="text"
                                                            value="{{ old('inspection_location', $inspection->inspection_location ?? '') }}"
                                                            placeholder="Masukkan Lokasi Pemeriksaan">

                                                    </div>
                                                </div>

                                                <!-- Borang Kehadiran -->
                                                <div class="mb-4">
                                                    <div class="card-header mb-3 pl-0">
                                                        <h4 class="fw-bold mb-0">Borang Kehadiran <span
                                                                class="text-danger">*</span></h4>
                                                        <small class="text-muted">Muat naik borang kehadiran semasa
                                                            pemeriksaan dijalankan</small>
                                                    </div>

                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="custom-file w-100">
                                                            <input type="file" class="custom-file-input"
                                                                id="attendance_form_path" name="attendance_form_path"
                                                                accept=".jpg,.jpeg,.png,.pdf"  >
                                                            <label class="custom-file-label" for="attendance_form_path">
                                                                {{ !empty($inspection?->attendance_form_path) ?
                                                                basename($inspection->attendance_form_path) : 'Pilih
                                                                Fail' }}
                                                            </label>
                                                        </div>

                                                        @if (!empty($inspection?->attendance_form_path))
                                                        <a class="btn btn-primary"
                                                            href="{{ route('tukarEnjin.laporanLpi-05.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'attendance_form_path']) }}"
                                                            target="_blank">
                                                            <i class="fa fa-search"></i>
                                                        </a>
                                                        @endif
                                                    </div>

                                                    <small class="form-text text-muted">Muat naik fail dalam format JPG,
                                                        PNG, atau PDF (maksimum 2MB).</small>

                                                </div>

                                                @push('scripts')
                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('attendance_form_path');
        const label = input?.nextElementSibling;

        input?.addEventListener('change', function () {
            const fileName = this.files.length > 0 ? this.files[0].name : 'Pilih Fail';
            if (label) label.textContent = fileName;
        });
    });
                                                </script>
                                                @endpush

                                                <!-- Gambar Vesel / Peralatan -->
                                                <div class="mb-4">
                                                    <div class="card-header mb-3 pl-0">
                                                        <h4 class="fw-bold mb-0">Gambar Vesel / Peralatan <span
                                                                class="text-danger">*</span></h4>
                                                        <small class="text-muted">Muat naik gambar vesel atau peralatan
                                                            berkaitan</small>
                                                    </div>

                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="custom-file w-100">
                                                            <input type="file" class="custom-file-input"
                                                                id="vessel_image_path" name="vessel_image_path"
                                                                accept=".jpg,.jpeg,.png,.pdf"  >
                                                            <label class="custom-file-label" for="vessel_image_path">
                                                                {{ !empty($inspection?->vessel_image_path) ?
                                                                basename($inspection->vessel_image_path) : 'Pilih Fail'
                                                                }}
                                                            </label>
                                                        </div>

                                                        @if (!empty($inspection?->vessel_image_path))
                                                        <a class="btn btn-primary"
                                                            href="{{ route('tukarEnjin.laporanLpi-05.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'vessel_image_path']) }}"
                                                            target="_blank">
                                                            <i class="fa fa-search"></i>
                                                        </a>

                                                        @endif
                                                    </div>

                                                    <small class="form-text text-muted">
                                                        Muat naik fail dalam format JPG, PNG, atau PDF (maksimum 2MB).
                                                    </small>

                                                </div>

                                                @push('scripts')
                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('vessel_image_path');
        const label = input?.nextElementSibling;

        input?.addEventListener('change', function () {
            const fileName = this.files.length > 0 ? this.files[0].name : 'Pilih Fail';
            if (label) label.textContent = fileName;
        });
    });
                                                </script>
                                                @endpush

                                                <div class="mb-4">
                                                    <div class="card-header mb-3 pl-0">
                                                        <h4 class="fw-bold mb-0">Gambar Pemeriksa Bersama Pemilik <span
                                                                class="text-danger">*</span></h4>
                                                        <small class="text-muted">Muat naik gambar pemeriksa bersama
                                                            pemilik vesel</small>
                                                    </div>

                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="custom-file w-100">
                                                            <input type="file" class="custom-file-input"
                                                                id="inspector_owner_image_path"
                                                                name="inspector_owner_image_path"
                                                                accept=".jpg,.jpeg,.png,.pdf"  >
                                                            <label class="custom-file-label"
                                                                for="inspector_owner_image_path">
                                                                {{ !empty($inspection?->inspector_owner_image_path) ?
                                                                basename($inspection->inspector_owner_image_path) :
                                                                'Pilih Fail' }}
                                                            </label>
                                                        </div>

                                                        @if (!empty($inspection?->inspector_owner_image_path))
                                                        <a class="btn btn-primary"
                                                            href="{{ route('tukarEnjin.laporanLpi-05.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'inspector_owner_image_path']) }}"
                                                            target="_blank">
                                                            <i class="fa fa-search"></i>
                                                        </a>
                                                        @endif
                                                    </div>

                                                    <small class="form-text text-muted">
                                                        Muat naik fail dalam format JPG, PNG, atau PDF (maksimum 2MB).
                                                    </small>

                                                </div>

                                                @push('scripts')
                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('inspector_owner_image_path');
        const label = input?.nextElementSibling;

        input?.addEventListener('change', function () {
            const fileName = this.files.length > 0 ? this.files[0].name : 'Pilih Fail';
            if (label) label.textContent = fileName;
        });
    });
                                                </script>
                                                @endpush

                                                <!-- Sokongan -->
                                                <div class="card-header mb-3 pl-0">
                                                    <h4 class="fw-bold mb-0">Sokongan</h4>
                                                    <small class="text-muted">Sila pilih sama ada anda menyokong
                                                        laporan lpi ini</small>
                                                </div>

                                                <div class="d-flex mb-4 gap-4">
    <div class="form-check">
        <input class="form-check-input" type="radio" name="is_support"
            id="supportYes" value="1"
            {{ (old('is_support', $inspection ->is_support ?? null) == '1') ? 'checked' : '' }}>
        <label class="form-check-label" for="supportYes">Sokong</label>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="radio" name="is_support"
            id="supportNo" value="0"
            {{ (old('is_support', $inspection ->is_support ?? null) == '0') ? 'checked' : '' }}>
        <label class="form-check-label" for="supportNo">Tidak Sokong</label>
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
                                    <form id="form-submit-final" onsubmit="sessionStorage.removeItem('lastSavedTab')"
                                        action="{{ route('tukarEnjin.laporanLpi-05.store', $application->id) }}"
                                        method="POST">
                                        @csrf
                                    </form>

                                    <!-- Hantar Button -->
                                    <button id="hantarBtn" type="submit" class="btn btn-success"
                                        form="form-submit-final" style="width:120px; display:none">Hantar</button>
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

<script>
    let currentTab = 1;
    const totalTabs = 5;

    // Restore last saved tab from sessionStorage
    document.addEventListener("DOMContentLoaded", () => {
        const lastTab = sessionStorage.getItem("lastSavedTab");
        if (lastTab) {
            currentTab = parseInt(lastTab);
        }

        showTab(currentTab);
        toggleButtons();
    });

    function showTab(tabIndex) {
        for (let i = 1; i <= totalTabs; i++) {
            document.getElementById(`tab${i}-link`)?.classList.remove("active");
            document.getElementById(`content-tab${i}`)?.classList.remove("show", "active");
        }

        document.getElementById(`tab${tabIndex}-link`)?.classList.add("active");
        document.getElementById(`content-tab${tabIndex}`)?.classList.add("show", "active");

        sessionStorage.setItem("lastSavedTab", tabIndex);
    }

    function toggleButtons() {
        for (let i = 1; i <= totalTabs; i++) {
            const btn = document.getElementById(`simpanBtn${i}`);
            if (btn) btn.style.display = (currentTab === i) ? "inline-block" : "none";
        }

        const hantarBtn = document.getElementById("hantarBtn");
        if (hantarBtn) hantarBtn.style.display = (currentTab === totalTabs) ? "inline-block" : "none";

        const backBtn = document.getElementById("backTabBtn");
        if (backBtn) backBtn.style.display = (currentTab === 1) ? "none" : "inline-block";

        const nextBtn = document.getElementById("nextTabBtn");
        if (nextBtn) nextBtn.style.display = (currentTab === totalTabs) ? "none" : "inline-block";
    }

    document.getElementById("nextTabBtn")?.addEventListener("click", () => {
        if (currentTab === totalTabs) return alert("Ini adalah tab terakhir.");

        currentTab++;
        showTab(currentTab);
        toggleButtons();
    });

    document.getElementById("backTabBtn")?.addEventListener("click", () => {
        if (currentTab === 1) return alert("Ini adalah tab pertama.");

        currentTab--;
        showTab(currentTab);
        toggleButtons();
    });
</script>

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
