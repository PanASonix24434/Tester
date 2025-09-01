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
                        <h3 class="mb-0">{{ $applicationType->name }}</h3>
                        <small>{{$moduleName->name}} - {{$roleName}}</small>
                    </div>
                </div>
                <div class="col-md-3 align-content-center">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="d-flex   justify-content-end">
                        <ol class="breadcrumb text-center">
                            <li class="breadcrumb-item"><a href="http://127.0.0.1:8000/baharuKadNelayan/laporanLpi-09">{{ \Illuminate\Support\Str::ucfirst(strtolower($applicationType->name)) }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$moduleName->name}}</a></li>
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

                        <div class="card card-primary card-tabs">
                            <div class="card-header pb-0">

                                <ul class="nav nav-tabs" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="tab1-link" aria-disabled="true"> Vesel</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link custom-nav-link" id="tab2-link" aria-disabled="true"> Enjin</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link custom-nav-link" id="tab3-link" aria-disabled="true"> Peralatan Keselamatan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link custom-nav-link" id="tab4-link" aria-disabled="true"> Peralatan Menangkap Ikan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link custom-nav-link" id="tab5-link" aria-disabled="true"> Pemeriksaan </a>
                                    </li>

                                </ul>
                            </div>
                            <div class="card-body">

                                <div class="tab-content" id="pills-tabContent">

                                    <div class="tab-pane fade show active" id="content-tab1" role="tabpanel" aria-labelledby="tab1-link">
                                        <form id="form-tab1" action="{{ route('baharuKadNelayan.laporanLpi-09.storeMaklumatVesel', $application->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf

                                            <!-- Asal Vesel -->
                                            <div class="card-header mb-3 pl-0">
                                                <h4 class="fw-bold mb-0">Asal Vesel</h4>
                                                <small class="text-muted">Maklumat asal vesel sama ada baru atau terpakai</small>
                                            </div>
                                            <select required class="form-select mb-4" name="vessel_origin">
                                                <option selected disabled>Pilih Jenis Asal Vesel</option>
                                                <option value="1" {{ old('vessel_origin', $inspection->vessel_origin ?? null) == 1 ? 'selected' : '' }}>BARU</option>
                                                <option value="2" {{ old('vessel_origin', $inspection->vessel_origin ?? null) == 2 ? 'selected' : '' }}>TERPAKAI</option>
                                            </select>

                                            <!-- Jenis Kulit -->
                                            <div class="card-header mb-3 pl-0">
                                                <h4 class="fw-bold mb-0">Jenis Kulit</h4>
                                                <small class="text-muted">Pilih jenis kulit vesel yang digunakan</small>
                                            </div>
                                            <select required class="form-select mb-4" name="jenis_kulit">
                                                <option selected disabled>Pilih Jenis Kulit</option>
                                                @foreach ($jenisKulit as $id => $name)
                                                <option value="{{ $name }}" {{ old('hull_type', $inspection->hull_type ?? null) == $name ? 'selected' : '' }}>{{ $name }}</option>
                                                @endforeach
                                            </select>

                                            <!-- No. Pendaftaran Vesel -->
                                            <div class="card-header mb-3 pl-0">
                                                <h4 class="fw-bold mb-0">No. Pendaftaran Vesel</h4>
                                                <small class="text-muted">Semakan ke atas nombor pendaftaran vesel</small>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Ditebuk</label>
                                                <select required class="form-select" name="ditebuk">
                                                    <option selected disabled>Pilih Status</option>
                                                    <option value="1" {{ old('ditebuk', $inspection->drilled ?? '') == 1 ? 'selected' : '' }}>YA</option>
                                                    <option value="0" {{ old('ditebuk', $inspection->drilled ?? '') == 0 ? 'selected' : '' }}>TIDAK</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Dicat dengan terang</label>
                                                <select required class="form-select" name="dicat_dengan_terang">
                                                    <option selected disabled>Pilih Status</option>
                                                    <option value="1" {{ old('dicat_dengan_terang', $inspection->brightly_painted ?? '') == 1 ? 'selected' : '' }}>YA</option>
                                                    <option value="0" {{ old('dicat_dengan_terang', $inspection->brightly_painted ?? '') == 0 ? 'selected' : '' }}>TIDAK</option>
                                                </select>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label" for="ulasan">Ulasan</label>
                                                <textarea class="form-control" name="no_pendaftaran_vesel_ulasan" rows="3">{{ old('no_pendaftaran_vesel_ulasan', $inspection->vessel_registration_remarks ?? '') }}</textarea>
                                            </div>

                                            <!-- Ukuran Dimensi Vesel -->
                                            <div class="card-header mb-3 pl-0">
                                                <h4 class="fw-bold mb-0">Ukuran Dimensi Vesel (UDV)</h4>
                                                <small class="text-muted">Maklumat dimensi vesel semasa pemeriksaan dijalankan</small>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Panjang (m)</label>
                                                <input class="form-control" name="panjang" type="text" value="{{ old('panjang', $inspection->length ?? '') }}" placeholder="Panjang">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Lebar (m)</label>
                                                <input class="form-control" name="lebar" type="text" value="{{ old('lebar', $inspection->width ?? '') }}" placeholder="Lebar">
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label">Dalam (m)</label>
                                                <input class="form-control" name="dalam" type="text" value="{{ old('dalam', $inspection->depth ?? '') }}" placeholder="Dalam">
                                            </div>

                                            <!-- Gambar Vesel -->
                                            <div class="card-header mb-3 pl-0">
                                                <h4 class="fw-bold mb-0">Gambar Vesel</h4>
                                                <small class="text-muted">Gambar vesel semasa pemeriksaan dijalankan</small>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label">Gambar Keseluruhan</label>
                                                <div class="d-flex justify-content-between align-items-center gap-3">
                                                    <input class="form-control" name="overall_image_path" type="file">

                                                    @if (!empty($inspection->overall_image_path))
                                                    <!-- Trigger Button -->
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#overallImageModal_{{ $inspection->id }}">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                    @endif
                                                </div>
                                                <small class="form-text text-muted">Muat naik fail dalam format JPG atau PNG (maksimum 2MB).</small>
                                            </div>

                                            @if (!empty($inspection->overall_image_path))
                                            <!-- Modal -->
                                            <div class="modal fade" id="overallImageModal_{{ $inspection->id }}" tabindex="-1" aria-labelledby="overallImageModalLabel_{{ $inspection->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-md-down">
                                                    <div class="modal-content p-3">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="overallImageModalLabel_{{ $inspection->id }}">Gambar Keseluruhan Vesel</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            @php
                                                            $extension = pathinfo($inspection->overall_image_path, PATHINFO_EXTENSION);
                                                            @endphp

                                                            @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                                                            <img src="{{ route('baharuKadNelayan.laporanLpi-09.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'overall_image_path']) }}" class="img-fluid rounded" style="max-height: 85vh;">
                                                            @elseif(strtolower($extension) === 'pdf')
                                                            <iframe src="{{ route('baharuKadNelayan.laporanLpi-09.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'overall_image_path']) }}" width="100%" height="700px" frameborder="0"></iframe>
                                                            @else
                                                            <a href="{{ route('baharuKadNelayan.laporanLpi-09.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'overall_image_path']) }}" target="_blank" class="btn btn-outline-primary">Buka Dokumen</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                        </form>
                                    </div>

                                    <div class="tab-pane fade" id="content-tab2" role="tabpanel" aria-labelledby="tab2-link">
                                        <form id="form-tab2" action="{{ route('baharuKadNelayan.laporanLpi-09.storeMaklumatEnjin', $application->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf

                                            <!-- Header -->
                                            <div class="card-header mb-3 pl-0">
                                                <h4 class="fw-bold mb-0">Maklumat Enjin</h4>
                                                <small class="text-muted">Sila isi maklumat berkenaan enjin vesel yang diperiksa</small>
                                            </div>

                                            <!-- Fields -->
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Jenama</label>
                                                    <input class="form-control" name="engine_brand" type="text" value="{{ old('engine_brand', $inspection->engine_brand ?? '') }}" placeholder="Masukkan Jenama">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Model</label>
                                                    <input class="form-control" name="engine_model" type="text" value="{{ old('engine_model', $inspection->engine_model ?? '') }}" placeholder="Masukkan Model">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Kuasa Kuda (kk)</label>
                                                    <input class="form-control" name="horsepower" type="text" value="{{ old('horsepower', $inspection->horsepower ?? '') }}" placeholder="Masukkan Kuasa Kuda">
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <label class="form-label">No. Enjin</label>
                                                    <input class="form-control" name="engine_number" type="text" value="{{ old('engine_number', $inspection->engine_number ?? '') }}" placeholder="Masukkan No. Enjin">
                                                </div>
                                            </div>

                                            <!-- Gambar Enjin Header -->
                                            <div class="card-header mb-3 pl-0">
                                                <h4 class="fw-bold mb-0">Gambar Enjin</h4>
                                                <small class="text-muted">Sila muat naik gambar enjin dan nombor enjin</small>
                                            </div>

                                            <!-- Gambar Enjin -->
                                            <!-- Gambar Enjin -->
                                            <div class="mb-4">
                                                <label class="form-label">Gambar</label>
                                                <div class="d-flex justify-content-between align-items-center gap-3">
                                                    <input class="form-control" name="engine_image_path" type="file">
                                                    @if (!empty($inspection->engine_image_path))
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#engineImageModal_{{ $inspection->id }}">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                    @endif
                                                </div>
                                                <small class="form-text text-muted">Muat naik fail dalam format JPG atau PNG (maksimum 2MB).</small>
                                            </div>

                                            @if (!empty($inspection->engine_image_path))
                                            <!-- Modal Preview Gambar Enjin -->
                                            <div class="modal fade" id="engineImageModal_{{ $inspection->id }}" tabindex="-1" aria-labelledby="engineImageModalLabel_{{ $inspection->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-md-down">
                                                    <div class="modal-content p-3">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Gambar Enjin</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            @php $ext = pathinfo($inspection->engine_image_path, PATHINFO_EXTENSION); @endphp

                                                            @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                                                            <img src="{{ route('baharuKadNelayan.laporanLpi-09.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'engine_image_path']) }}" class="img-fluid rounded" style="max-height: 85vh;">
                                                            @elseif(strtolower($ext) === 'pdf')
                                                            <iframe src="{{ route('baharuKadNelayan.laporanLpi-09.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'engine_image_path']) }}" width="100%" height="700px" frameborder="0"></iframe>
                                                            @else
                                                            <a href="{{ route('baharuKadNelayan.laporanLpi-09.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'engine_image_path']) }}" target="_blank" class="btn btn-outline-primary">Buka Fail</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            <!-- Gambar No. Enjin -->
                                            <div class="mb-4">
                                                <label class="form-label">Gambar No. Enjin</label>
                                                <div class="d-flex justify-content-between align-items-center gap-3">
                                                    <input class="form-control" name="engine_number_image_path" type="file">
                                                    @if (!empty($inspection->engine_number_image_path))
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#engineNumberImageModal_{{ $inspection->id }}">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                    @endif
                                                </div>
                                                <small class="form-text text-muted">Muat naik fail dalam format JPG atau PNG (maksimum 2MB).</small>
                                            </div>

                                            @if (!empty($inspection->engine_number_image_path))
                                            <!-- Modal Preview Gambar No. Enjin -->
                                            <div class="modal fade" id="engineNumberImageModal_{{ $inspection->id }}" tabindex="-1" aria-labelledby="engineNumberImageModalLabel_{{ $inspection->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-md-down">
                                                    <div class="modal-content p-3">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Gambar No. Enjin</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            @php $ext = pathinfo($inspection->engine_number_image_path, PATHINFO_EXTENSION); @endphp

                                                            @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                                                            <img src="{{ route('baharuKadNelayan.laporanLpi-09.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'engine_number_image_path']) }}" class="img-fluid rounded" style="max-height: 85vh;">
                                                            @elseif(strtolower($ext) === 'pdf')
                                                            <iframe src="{{ route('baharuKadNelayan.laporanLpi-09.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'engine_number_image_path']) }}" width="100%" height="700px" frameborder="0"></iframe>
                                                            @else
                                                            <a href="{{ route('baharuKadNelayan.laporanLpi-09.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'engine_number_image_path']) }}" target="_blank" class="btn btn-outline-primary">Buka Fail</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif




                                </form>
                            </div>

                            <div class="tab-pane fade" id="content-tab3" role="tabpanel" aria-labelledby="tab3-link">
                                <form id="form-tab3" action="{{ route('baharuKadNelayan.laporanLpi-09.storePeralatanKeselamatan', $application->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <!-- Header -->
                                    <div class="card-header mb-3 pl-0">
                                        <h4 class="fw-bold mb-0">Peralatan Keselamatan</h4>
                                        <small class="text-muted">Maklumat berkaitan jaket keselamatan vesel</small>
                                    </div>

                                    <!-- Jaket Keselamatan Section -->
                                    <div class="row mb-4">
                                        <div class="col-md-4">
                                            <label class="form-label">Jaket Keselamatan</label>
                                            <select class="form-select" name="safety_jacket_status" id="safety_jacket_status" required>
                                                <option selected disabled>Pilih Status</option>
                                                <option value="1" {{ old('safety_jacket_status', $inspection->safety_jacket_status ?? '') == 1 ? 'selected' : '' }}>ADA</option>
                                                <option value="0" {{ old('safety_jacket_status', $inspection->safety_jacket_status ?? '') == 0 ? 'selected' : '' }}>TIADA</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Kuantiti</label>
                                            <input type="number" class="form-control" id="safety_jacket_quantity" name="safety_jacket_quantity" value="{{ old('safety_jacket_quantity', $inspection->safety_jacket_quantity ?? '') }}" placeholder="Masukkan Kuantiti">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Keadaan Jaket</label>
                                            <select class="form-select" id="safety_jacket_condition" name="safety_jacket_condition">
                                                <option selected disabled>Pilih Keadaan</option>
                                                @foreach ($jenisKeadaan as $id => $name)
                                                <option value="{{ $id }}" {{ old('safety_jacket_condition', $inspection->safety_jacket_condition ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- File Upload -->
                                    <div class="mb-4">
                                        <div class="card-header mb-3 pl-0">
                                            <h4 class="fw-bold mb-0">Gambar Jaket Keselamatan</h4>
                                            <small class="text-muted">Gambar peralatan keselamatan yang dijumpai</small>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center gap-3">
                                            <input class="form-control" name="safety_jacket_image_path" type="file">
                                            @if (!empty($inspection->safety_jacket_image_path))
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalJaketPreview">
                                                <i class="fa fa-search"></i>
                                            </button>
                                            @if (!empty($inspection->safety_jacket_image_path))
                                            <div class="modal fade" id="modalJaketPreview" tabindex="-1" aria-labelledby="modalJaketPreviewLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Gambar Jaket Keselamatan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            @php $ext = pathinfo($inspection->safety_jacket_image_path, PATHINFO_EXTENSION); @endphp

                                                            @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                                                            <img src="{{ route('baharuKadNelayan.laporanLpi-09.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'safety_jacket_image_path']) }}" class="img-fluid rounded" style="max-height: 600px;">
                                                            @elseif(strtolower($ext) === 'pdf')
                                                            <iframe src="{{ route('baharuKadNelayan.laporanLpi-09.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'safety_jacket_image_path']) }}" width="100%" height="600px" frameborder="0"></iframe>
                                                            @else
                                                            <a href="{{ route('baharuKadNelayan.laporanLpi-09.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'safety_jacket_image_path']) }}" target="_blank" class="btn btn-outline-primary">Buka Fail</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @endif
                                        </div>
                                        <small class="form-text text-muted">Muat naik fail dalam format JPG atau PNG (maksimum 2MB).</small>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="content-tab4" role="tabpanel" aria-labelledby="tab4-link">
                                <form id="form-tab4" action="{{ route('baharuKadNelayan.laporanLpi-09.storePeralatanMenangkapIkan', $application->id) }}" method="POST">
                                    @csrf

                                    @php
                                        $equipmentList = $equipmentList ?? collect();
                                        $jenisKeadaan = $jenisKeadaan ?? [];
                                        $itemFoundList = $itemFoundList ?? collect();
                                        $options = ['JARING UDANG','PUKAT','BUBU','RAWAI','JALA','BESEN IKAN','BAKUL PLASTIK','TONG SIMPANAN IKAN'];
                                    @endphp

                                    <div class="card-header mb-3 pl-0">
                                        <h4 class="fw-bold mb-0">Senarai Peralatan Pengguna</h4>
                                        <small class="text-muted">Berikut adalah senarai peralatan dan keadaannya yang telah direkodkan.</small>
                                    </div>

                                    <table class="table">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center">Bil</th>
                                                <th>Nama Peralatan</th>
                                                <th>Kuantiti</th>
                                                <th>Jenis</th>
                                                <th>Keadaan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($equipmentList as $index => $equipment)
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td>
                                                        {{ $equipment->name ?? '-' }}
                                                        <input type="hidden" name="equipment_id[]" value="{{ $equipment->id ?? '' }}">
                                                    </td>
                                                    <td>{{ $equipment->quantity ?? 0 }}</td>
                                                    <td>{{ ucfirst($equipment->type ?? '-') }}</td>
                                                    <td>
                                                        <select class="form-select" name="condition[]">
                                                            <option selected disabled>Pilih Keadaan</option>
                                                            @foreach ($jenisKeadaan as $id => $name)
                                                                <option value="{{ $id }}" {{ ($equipment->condition ?? '') == $id ? 'selected' : '' }}>
                                                                    {{ $name }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted">Tiada peralatan direkodkan.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>

                                    <div class="card-header mb-3 pl-0 mt-5">
                                        <h4 class="fw-bold mb-0">Peralatan Ditemui Semasa Pemeriksaan</h4>
                                        <small class="text-muted">Masukkan peralatan tambahan yang ditemui semasa pemeriksaan.</small>
                                    </div>

                                    <table class="table" id="itemFoundTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Nama Peralatan</th>
                                                <th>Kuantiti</th>
                                                <th style="width: 5%">Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($itemFoundList as $found)
                                                <tr>
                                                    <td>
                                                        <select name="found_item_name[]" class="form-select" required>
                                                            <option disabled>Pilih Peralatan</option>
                                                            @foreach($options as $option)
                                                                <option value="{{ $option }}" {{ ($found->item ?? '') == $option ? 'selected' : '' }}>
                                                                    {{ $option }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="found_item_quantity[]" class="form-control" min="1" value="{{ $found->quantity ?? 1 }}">
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-danger remove-item-btn">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td>
                                                        <select name="found_item_name[]" class="form-select" required>
                                                            <option disabled selected>Pilih Peralatan</option>
                                                            @foreach($options as $option)
                                                                <option value="{{ $option }}">{{ $option }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="found_item_quantity[]" class="form-control" min="1" placeholder="0">
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-danger btn-sm remove-item-btn d-none">
                                                            <i class="fa fa-trash"></i> Buang
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>

                                    <div class="mb-4">
                                        <button type="button" class="btn btn-primary" id="addItemRowBtn">
                                            <i class="fa fa-plus"></i> Tambah Peralatan
                                        </button>
                                    </div>

                                    @push('scripts')
                                    <script>
                                        const options = ['JARING UDANG','PUKAT','BUBU','RAWAI','JALA','BESEN IKAN','BAKUL PLASTIK','TONG SIMPANAN IKAN'];

                                        document.getElementById('addItemRowBtn').addEventListener('click', function() {
                                            const table = document.querySelector('#itemFoundTable tbody');
                                            const row = document.createElement('tr');

                                            let selectOptions = `<option disabled selected>Pilih Peralatan</option>`;
                                            options.forEach(item => {
                                                selectOptions += `<option value="${item}">${item}</option>`;
                                            });

                                            row.innerHTML = `
                                                <td><select name="found_item_name[]" class="form-select" required>${selectOptions}</select></td>
                                                <td><input type="number" name="found_item_quantity[]" class="form-control" min="1" placeholder="0"></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger remove-item-btn"><i class="fa fa-trash"></i></button>
                                                </td>
                                            `;

                                            table.appendChild(row);
                                        });

                                        document.querySelector('#itemFoundTable tbody').addEventListener('click', function(e) {
                                            if (e.target.closest('.remove-item-btn')) {
                                                e.target.closest('tr').remove();
                                            }
                                        });
                                    </script>
                                    @endpush

                                </form>
                            </div>


                            <div class="tab-pane fade" id="content-tab5" role="tabpanel" aria-labelledby="tab5-link">
                                <form id="form-tab5" action="{{ route('baharuKadNelayan.laporanLpi-09.storePengesahanPemeriksaan', $application->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <!-- Keadaan Vesel, Tarikh, Lokasi -->
                                    <div class="card-header mb-3 pl-0">
                                        <h4 class="fw-bold mb-0">Maklumat Pemeriksaan</h4>
                                        <small class="text-muted">Isikan maklumat keadaan vesel, tarikh dan lokasi pemeriksaan</small>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-4">
                                            <label class="form-label">Keadaan Vesel</label>
                                            <select required class="form-select" name="keadaan_vesel">
                                                <option selected disabled>Pilih Keadaan Vesel</option>
                                                @foreach ($jenisKeadaan as $id => $name)
                                                <option value="{{ $name }}" {{ old('keadaan_vesel', $inspection->vessel_condition ?? null) == $name ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Tarikh Pemeriksaan</label>
                                            <input class="form-control" name="inspection_date" type="date" value="{{ old('inspection_date', $inspection->inspection_date ?? '') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Lokasi Pemeriksaan</label>
                                            <input class="form-control" name="inspection_location" type="text" value="{{ old('inspection_location', $inspection->inspection_location ?? '') }}" placeholder="Masukkan Lokasi Pemeriksaan">
                                        </div>
                                    </div>

                                    <!-- Borang Kehadiran -->
                                    <div class="mb-4">
                                        <div class="card-header mb-3 pl-0">
                                            <h4 class="fw-bold mb-0">Borang Kehadiran</h4>
                                            <small class="text-muted">Muat naik borang kehadiran semasa pemeriksaan dijalankan</small>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center gap-3">
                                            <input class="form-control" name="attendance_form_path" type="file">

                                            @if (!empty($inspection->attendance_form_path))
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAttendancePreview">
                                                <i class="fa fa-search"></i>
                                            </button>

                                            <div class="modal fade" id="modalAttendancePreview" tabindex="-1" aria-labelledby="modalAttendancePreviewLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Pratonton Borang Kehadiran</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            @php
                                                            $ext = pathinfo($inspection->attendance_form_path, PATHINFO_EXTENSION);
                                                            @endphp

                                                            @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                                                            <img src="{{ route('baharuKadNelayan.laporanLpi-09.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'attendance_form_path']) }}" class="img-fluid rounded" style="max-height: 600px;">
                                                            @elseif(strtolower($ext) === 'pdf')
                                                            <iframe src="{{ route('baharuKadNelayan.laporanLpi-09.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'attendance_form_path']) }}" width="100%" height="600px" frameborder="0"></iframe>
                                                            @else
                                                            <a href="{{ route('baharuKadNelayan.laporanLpi-09.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'attendance_form_path']) }}" target="_blank" class="btn btn-outline-primary">Buka Fail</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>

                                        <small class="form-text text-muted">Muat naik fail dalam format JPG, PNG, atau PDF (maksimum 2MB).</small>
                                    </div>

                                    <div class="mb-4">
                                        <div class="card-header mb-3 pl-0">
                                            <h4 class="fw-bold mb-0">Gambar Vesel / Peralatan</h4>
                                            <small class="text-muted">Muat naik gambar vesel atau peralatan berkaitan</small>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center gap-3">
                                            <input class="form-control" name="vessel_image_path" type="file">

                                            @if (!empty($inspection->vessel_image_path))
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalVesselImage">
                                                <i class="fa fa-search"></i>
                                            </button>

                                            <div class="modal fade" id="modalVesselImage" tabindex="-1" aria-labelledby="modalVesselImageLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Gambar Vesel / Peralatan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            @php $ext = pathinfo($inspection->vessel_image_path, PATHINFO_EXTENSION); @endphp

                                                            @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                                                            <img src="{{ route('baharuKadNelayan.laporanLpi-09.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'vessel_image_path']) }}" class="img-fluid rounded" style="max-height: 600px;">
                                                            @elseif(strtolower($ext) === 'pdf')
                                                            <iframe src="{{ route('baharuKadNelayan.laporanLpi-09.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'vessel_image_path']) }}" width="100%" height="600px" frameborder="0"></iframe>
                                                            @else
                                                            <a href="{{ route('baharuKadNelayan.laporanLpi-09.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'vessel_image_path']) }}" target="_blank" class="btn btn-outline-primary">Buka Fail</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>

                                        <small class="form-text text-muted">Muat naik fail dalam format JPG, PNG, atau PDF (maksimum 2MB).</small>
                                    </div>

                                    <div class="mb-4">
                                        <div class="card-header mb-3 pl-0">
                                            <h4 class="fw-bold mb-0">Gambar Pemeriksa Bersama Pemilik</h4>
                                            <small class="text-muted">Muat naik gambar pemeriksa bersama pemilik vesel</small>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center gap-3">
                                            <input class="form-control" name="inspector_owner_image_path" type="file">

                                            @if (!empty($inspection->inspector_owner_image_path))
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalInspectorOwner">
                                                <i class="fa fa-search"></i>
                                            </button>

                                            <div class="modal fade" id="modalInspectorOwner" tabindex="-1" aria-labelledby="modalInspectorOwnerLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Gambar Pemeriksa Bersama Pemilik</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            @php $ext = pathinfo($inspection->inspector_owner_image_path, PATHINFO_EXTENSION); @endphp

                                                            @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                                                            <img src="{{ route('baharuKadNelayan.laporanLpi-09.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'inspector_owner_image_path']) }}" class="img-fluid rounded" style="max-height: 600px;">
                                                            @elseif(strtolower($ext) === 'pdf')
                                                            <iframe src="{{ route('baharuKadNelayan.laporanLpi-09.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'inspector_owner_image_path']) }}" width="100%" height="600px" frameborder="0"></iframe>
                                                            @else
                                                            <a href="{{ route('baharuKadNelayan.laporanLpi-09.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'inspector_owner_image_path']) }}" target="_blank" class="btn btn-outline-primary">Buka Fail</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>

                                        <small class="form-text text-muted">Muat naik fail dalam format JPG, PNG, atau PDF (maksimum 2MB).</small>
                                    </div>

                                    <!-- Sokongan -->
                                    <div class="card-header mb-3 pl-0">
                                        <h4 class="fw-bold mb-0">Sokongan</h4>
                                        <small class="text-muted">Sila pilih sama ada anda menyokong permohonan ini</small>
                                    </div>
                                    <div class="mb-4 d-flex gap-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="is_support" id="supportYes" value="1" {{ old('is_support', $inspection->is_support ?? '') == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="supportYes">Sokong</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="is_support" id="supportNo" value="0" {{ old('is_support', $inspection->is_support ?? '') == '0' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="supportNo">Tidak Sokong</label>
                                        </div>
                                    </div>

                                    <!-- Ulasan -->
                                    <div class="card-header mb-3 pl-0">
                                        <h4 class="fw-bold mb-0">Ulasan</h4>
                                        <small class="text-muted">Sila berikan ulasan berkaitan pemeriksaan</small>
                                    </div>
                                    <div class="mb-4">
                                        <textarea class="form-control" name="inspection_summary" rows="4" placeholder="Masukkan ulasan...">{{ old('inspection_summary', $inspection->inspection_summary ?? '') }}</textarea>
                                    </div>

                                </form>
                            </div>

                        </div>

                        {{-- card --}}

                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-end gap-3">
                            <!-- Back and Next Buttons -->
                            <div class="d-flex gap-3">
                                <button id="backTabBtn" type="button" class="btn btn-light" style="width:120px">Kembali</button>
                                <button id="nextTabBtn" type="button" class="btn btn-light" style="width:120px">Seterusnya</button>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-3">
                                <!-- Final Submission Form -->
                                <form id="form-submit-final" action="{{ route('baharuKadNelayan.laporanLpi-09.store', $application->id) }}" method="POST">
                                    @csrf
                                </form>

                                <!-- Simpan Buttons for Each Tab -->
                                <button id="simpanBtn1" type="submit" class="btn btn-warning" form="form-tab1" style="width:120px; display:none">Simpan</button>
                                <button id="simpanBtn2" type="submit" class="btn btn-warning" form="form-tab2" style="width:120px; display:none">Simpan</button>
                                <button id="simpanBtn3" type="submit" class="btn btn-warning" form="form-tab3" style="width:120px; display:none">Simpan</button>
                                <button id="simpanBtn4" type="submit" class="btn btn-warning" form="form-tab4" style="width:120px; display:none">Simpan</button>
                                <button id="simpanBtn5" type="submit" class="btn btn-warning" form="form-tab5" style="width:120px; display:none">Simpan</button>

                                <!-- Hantar Button -->
                                <button id="hantarBtn" type="submit" class="btn btn-success" form="form-submit-final" style="width:120px; display:none">Hantar</button>
                            </div>
                        </div>
                    </div>

                </div>
                <br>

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
