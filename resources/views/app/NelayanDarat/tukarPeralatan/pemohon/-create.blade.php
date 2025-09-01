`@extends('layouts.app')

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

                    <div class="mb-5">
                        <h3 class="mb-0">{{ $applicationType->name_ms }}</h3>
                        <small>{{ $moduleName->name }} - {{ $roleName }}</small>
                    </div>

                </div>
                <div class="col-md-3 align-content-center">
                    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
                        <ol class="breadcrumb text-center">
                            <li class="breadcrumb-item">
                                <a href="http://127.0.0.1:8000/tukarPeralatan/permohonan-04">{{
                                    \Illuminate\Support\Str::ucfirst(strtolower($applicationType->name)) }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $moduleName->name }}</a></li>
                            {{-- <li class="breadcrumb-item active" aria-current="page">Permohonan</a></li> --}}

                        </ol>
                    </nav>
                </div>
            </div>
            <div>

                <div class="card card-primary card-tabs">

                    <div class="card-header pb-0">
                        <ul class="nav nav-tabs" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link custom-nav-link active" id="tab1-link" aria-disabled="true">Maklumat
                                    Pemohon</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link custom-nav-link" id="tab2-link" aria-disabled="true">Maklumat
                                    Tambahan</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link custom-nav-link" id="tab3-link" aria-disabled="true">Maklumat
                                    Pangkalan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link custom-nav-link" id="tab4-link" aria-disabled="true">Maklumat
                                    Peralatan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link custom-nav-link" id="tab5-link" aria-disabled="true">Maklumat
                                    Vesel</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link custom-nav-link" id="tab6-link" aria-disabled="true">Dokumen
                                    Sokongan</a>
                            </li>
                        </ul>

                    </div>

                    <div class="card-body">

                        <div class="tab-content" id="pills-tabContent">

                            <div class="tab-pane fade show active" id="content-tab1" role="tabpanel"
                                aria-labelledby="tab1-link">
                                {{--
                                <form id="store_tab1" method="POST"
                                    action="{{ route('tukarPeralatan.permohonan-04.store_tab1') }}">
                                    @csrf --}}

                                    <div class="mb-4">
                                        <h4 class="fw-bold mb-0">Maklumat Peribadi</h4>
                                        <small class="text-muted">Sila isikan maklumat peribadi anda dengan
                                            lengkap</small>

                                        <div class="row mt-3">
                                            <div class="col-md-6 mb-3">
                                                <label for="name" class="form-label">Nama</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ old('name', $userDetail->name ?? '') }}"
                                                    placeholder="Masukkan Nama Penuh" readonly>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="identity_card_number" class="form-label">Nombor Kad
                                                    Pengenalan</label>
                                                <input type="text" class="form-control" id="identity_card_number"
                                                    name="identity_card_number"
                                                    value="{{ old('identity_card_number', $userDetail->identity_card_number ?? '') }}"
                                                    placeholder="Masukkan Nombor Kad Pengenalan" readonly>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-6 mb-3">
                                                <label for="phone_number" class="form-label">Nombor Telefon</label>
                                                <input type="text" class="form-control" id="phone_number"
                                                    name="phone_number"
                                                    value="{{ old('phone_number', $userDetail->phone_number ?? '') }}"
                                                    placeholder="Masukkan Nombor Telefon" readonly>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="secondary_phone_number" class="form-label">Nombor Telefon
                                                    (Kedua)</label>
                                                <input type="text" class="form-control" id="secondary_phone_number"
                                                    name="secondary_phone_number"
                                                    value="{{ old('secondary_phone_number', $userDetail->secondary_phone_number ?? '') }}"
                                                    placeholder="Masukkan Nombor Telefon Kedua" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <hr>

                                    <div class="mb-4">
                                        <h4 class="fw-bold mb-0">Alamat Kediaman</h4>
                                        <small class="text-muted">Masukkan alamat tempat tinggal anda</small>

                                        <div class="row mt-3">
                                            <div class="col-md mb-3">
                                                <label for="address" class="form-label">Alamat</label>
                                                <input type="text" class="form-control" id="address" name="address"
                                                    value="{{ old('address', $userDetail->address ?? '') }}"
                                                    placeholder="Masukkan Alamat Anda" readonly>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="postcode" class="form-label">Poskod</label>
                                                <input type="text" class="form-control" id="postcode" name="postcode"
                                                    value="{{ old('postcode', $userDetail->postcode ?? '') }}"
                                                    placeholder="Masukkan Poskod" readonly>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="district" class="form-label">Daerah</label>
                                                <input type="text" class="form-control" id="district" name="district"
                                                    value="{{ old('district', $userDetail->district ?? '') }}"
                                                    placeholder="Masukkan Daerah" readonly>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="state" class="form-label">Negeri</label>
                                                <input type="text" class="form-control" id="state" name="state"
                                                    value="{{ old('state', $userDetail->state ?? '') }}"
                                                    placeholder="Masukkan Negeri" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <hr>

                                    <div class="mb-4">
                                        <h4 class="fw-bold mb-0">Alamat Surat-Menyurat</h4>
                                        <small class="text-muted">Masukkan alamat untuk tujuan surat-menyurat</small>

                                        <div class="row mt-3">
                                            <div class="col-md mb-3">
                                                <label for="mailing_address" class="form-label">Alamat</label>
                                                <input type="text" class="form-control" id="mailing_address"
                                                    name="mailing_address"
                                                    value="{{ old('mailing_address', $userDetail->mailing_address ?? '') }}"
                                                    placeholder="Masukkan Alamat Surat-Menyurat" readonly>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="mailing_postcode" class="form-label">Poskod</label>
                                                <input type="text" class="form-control" id="mailing_postcode"
                                                    name="mailing_postcode"
                                                    value="{{ old('mailing_postcode', $userDetail->mailing_postcode ?? '') }}"
                                                    placeholder="Masukkan Poskod" readonly>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="mailing_district" class="form-label">Daerah</label>
                                                <input type="text" class="form-control" id="mailing_district"
                                                    name="mailing_district"
                                                    value="{{ old('mailing_district', $userDetail->mailing_district ?? '') }}"
                                                    placeholder="Masukkan Daerah" readonly>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="mailing_state" class="form-label">Negeri</label>
                                                <input type="text" class="form-control" id="mailing_state"
                                                    name="mailing_state"
                                                    value="{{ old('mailing_state', $userDetail->mailing_state ?? '') }}"
                                                    placeholder="Masukkan Negeri" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    {{--
                                </form> --}}

                            </div>

                            <div class="tab-pane fade" id="content-tab2" role="tabpanel" aria-labelledby="tab1-link">
                                {{-- <form id="store_tab2" method="POST"
                                    action="{{ route('tukarPeralatan.permohonan-04.store_tab2') }}">
                                    @csrf --}}

                                    <div class="mb-4">
                                        <h4 class="fw-bold mb-0">Maklumat Sebagai Nelayan</h4>
                                        <small class="text-muted">Maklumat berkaitan pengalaman dan aktiviti sebagai
                                            nelayan dipaparkan untuk semakan sahaja</small>

                                        <div class="row mt-3">
                                            <div class="col-md-6 mb-3">
                                                <label for="year_become_fisherman" class="form-label">
                                                    Tahun Menjadi Nelayan
                                                </label>
                                                <input type="number" class="form-control" id="year_become_fisherman"
                                                    name="year_become_fisherman"
                                                    value="{{ old('year_become_fisherman', $fishermanInfoOff->year_become_fisherman ?? '') }}"
                                                    placeholder="Masukkan Tahun Menjadi Nelayan" readonly>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="becoming_fisherman_duration" class="form-label">
                                                    Tempoh Menjadi Nelayan (Tahun)
                                                </label>
                                                <input type="number" class="form-control"
                                                    id="becoming_fisherman_duration" name="becoming_fisherman_duration"
                                                    value="{{ old('becoming_fisherman_duration', $fishermanInfoOff->becoming_fisherman_duration ?? '') }}"
                                                    placeholder="Masukkan Tempoh Menjadi Nelayan" readonly>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="working_days_fishing_per_month" class="form-label">
                                                    Hari Bekerja Menangkap Ikan Sebulan
                                                </label>
                                                <input type="number" class="form-control"
                                                    id="working_days_fishing_per_month"
                                                    name="working_days_fishing_per_month"
                                                    value="{{ old('working_days_fishing_per_month', $fishermanInfoOff->working_days_fishing_per_month ?? '') }}"
                                                    placeholder="Masukkan Hari Bekerja Menangkap Ikan Sebulan" readonly>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="estimated_income_yearly_fishing" class="form-label">
                                                    Pendapatan Tahunan Dari Menangkap Ikan
                                                </label>
                                                <input type="number" class="form-control"
                                                    id="estimated_income_yearly_fishing"
                                                    name="estimated_income_yearly_fishing"
                                                    value="{{ old('estimated_income_yearly_fishing', $fishermanInfoOff->estimated_income_yearly_fishing ?? '') }}"
                                                    placeholder="Masukkan Pendapatan Tahunan Dari Menangkap Ikan"
                                                    readonly>
                                            </div>
                                        </div>

                                    </div>

                                    <br>
                                    <hr>

                                    <div class="mb-4">
                                        <h4 class="fw-bold mb-0">Maklumat Pekerjaan Lain</h4>
                                        <small class="text-muted">Maklumat berkaitan pekerjaan lain (sekiranya ada),
                                            dipaparkan untuk semakan sahaja</small>

                                        <div class="row mt-3">
                                            <div class="col-md-6 mb-3">
                                                <label for="estimated_income_other_job" class="form-label">
                                                    Pendapatan Dari Pekerjaan Lain<span class="text-danger">*</span>
                                                </label>
                                                <input type="number" class="form-control"
                                                    id="estimated_income_other_job" name="estimated_income_other_job"
                                                    value="{{ old('estimated_income_other_job', $fishermanInfoOff->estimated_income_other_job ?? '') }}"
                                                    placeholder="Masukkan Pendapatan Dari Pekerjaan Lain" readonly>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="days_working_other_job_per_month" class="form-label">
                                                    Hari Bekerja Di Pekerjaan Lain Sebulan<span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="number" class="form-control"
                                                    id="days_working_other_job_per_month"
                                                    name="days_working_other_job_per_month"
                                                    value="{{ old('days_working_other_job_per_month', $fishermanInfoOff->days_working_other_job_per_month ?? '') }}"
                                                    placeholder="Masukkan Hari Bekerja Di Pekerjaan Lain Sebulan"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <hr>

                                    <div class="mb-4">
                                        <h4 class="fw-bold mb-0">Maklumat Kewangan</h4>
                                        <small class="text-muted">Maklumat bantuan dan pencen ini dipaparkan untuk
                                            semakan sahaja</small>

                                        <div class="row mt-3">
                                            <div class="col-md-6 mb-3">
                                                <label for="receive_pension" class="form-label">Menerima Pencen<span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select" id="receive_pension" name="receive_pension"
                                                    disabled>
                                                    <option value="1" {{ old('receive_pension', $fishermanInfoOff->
                                                        receive_pension ?? '') == 1 ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('receive_pension', $fishermanInfoOff->
                                                        receive_pension ?? '') == 0 ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="epf_contributor" class="form-label">Pencarum KWSP<span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select" id="epf_contributor" name="epf_contributor"
                                                    disabled>
                                                    <option value="1" {{ old('epf_contributor', $fishermanInfoOff->
                                                        epf_contributor ?? '') == 1 ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('epf_contributor', $fishermanInfoOff->
                                                        epf_contributor ?? '') == 0 ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="receive_financial_aid" class="form-label">Menerima Bantuan
                                                    Kewangan<span class="text-danger">*</span></label>
                                                <select class="form-select" id="receive_financial_aid"
                                                    name="receive_financial_aid" disabled>
                                                    <option value="1" {{ old('receive_financial_aid',
                                                        $fishermanInfoOff->receive_financial_aid ?? '') == 1 ?
                                                        'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('receive_financial_aid',
                                                        $fishermanInfoOff->receive_financial_aid ?? '') == 0 ?
                                                        'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>
                                        </div>

                                        @php
                                        $agencies = old('financial_aid_agency',
                                        $aidAgencyOff->pluck('agency_name')->toArray());
                                        $agencies = is_array($agencies) ? $agencies : [$agencies];
                                        @endphp

                                        <div class="row" id="financial_aid_agency_div">
                                            <div class="col-md mb-3">
                                                <label class="form-label">
                                                    Agensi Memberi Bantuan Kewangan <span class="text-danger">*</span>
                                                </label>

                                                <div id="financial_aid_agency_container">
                                                    @foreach ($agencies as $index => $agency)
                                                    <div class="input-group agency-row mb-2">
                                                        <input type="text" name="financial_aid_agency[]"
                                                            class="form-control" value="{{ $agency }}" readonly
                                                            placeholder="Nama Agensi Penyedia Bantuan Kewangan">
                                                    </div>
                                                    @endforeach

                                                    @if (empty($agencies))
                                                    <div class="input-group agency-row mb-2">
                                                        <input type="text" name="financial_aid_agency[]"
                                                            class="form-control" placeholder="Tiada agensi direkodkan"
                                                            readonly>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{--
                                </form> --}}
                            </div>

                            <div class="tab-pane fade" id="content-tab3" role="tabpanel" aria-labelledby="tab3-link">
                                {{-- <form id="store_tab3" method="POST" enctype="multipart/form-data"
                                    action="{{ route('baharuKadNelayan.permohonan-09.store_tab3') }}">
                                    @csrf --}}

                                    <div class="mb-3">
                                        <h4 class="fw-bold">Maklumat Jeti / Pangkalan</h4>
                                        <small class="text-muted m-0">Sila isikan lokasi atau kawasan jeti tempat
                                            beroperasi</small>
                                    </div>

                                    <!-- Negeri -->
                                    <div class="mb-3">
                                        <label class="form-label">Negeri</label>
                                        <input type="text" class="form-control"
                                            value="{{ $jettyOff->state->name ?? 'Tiada Maklumat' }}" readonly>
                                    </div>

                                    <!-- Daerah -->
                                    <div class="mb-3">
                                        <label class="form-label">Daerah</label>
                                        <input type="text" class="form-control"
                                            value="{{ $jettyOff->district->name ?? 'Tiada Maklumat' }}" readonly>
                                    </div>

                                    <!-- Jeti / Pangkalan -->
                                    <div class="mb-3">
                                        <label class="form-label">Nama Jeti / Pangkalan</label>
                                        <input type="text" class="form-control"
                                            value="{{ $jettyOff->jetty->name?? 'Tiada Maklumat' }}" readonly>
                                    </div>

                                    <!-- Sungai -->
                                    <div class="mb-3">
                                        <label class="form-label">Sungai</label>
                                        <input type="text" class="form-control"
                                            value="{{ $jettyOff->river->name ?? 'Tiada Maklumat' }}" readonly>
                                    </div>

                                    {{--
                                </form> --}}
                            </div>

                            <div class="tab-pane fade" id="content-tab4" role="tabpanel" aria-labelledby="tab4-link">
                                <form id="store_tab4" method="POST" enctype="multipart/form-data"
                                    action="{{ route('tukarPeralatan.permohonan-04.store_tab4') }}">
                                    @csrf

                                    <div class="mb-3">
                                        <h4 class="fw-bold mb-0">Senarai Peralatan Semasa</h4>
                                        <small class="text-muted">Maklumat peralatan semasa yang digunakan</small>
                                    </div>

                                    @foreach ($latestEquipmentGroup as $index => $equipment)
                                    <div class="card mb-3 shadow-sm border">
                                        <div class="card-body">
                                            <div class="row g-3 align-items-end">
                                                {{-- Peralatan --}}
                                                <div class="col-md ">
                                                    <label class="form-label fw-semibold">Peralatan</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $equipment['name'] ?? '-' }}" disabled>
                                                </div>

                                                {{-- Kuantiti --}}
                                                <div class="col-md-2">
                                                    <label class="form-label fw-semibold">Kuantiti</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $equipment['quantity'] ?? '-' }}" disabled>
                                                </div>

                                                {{-- Jenis --}}
                                                <div class="col-md-2">
                                                    <label class="form-label fw-semibold">Jenis</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $equipment['type'] === 'main' ? 'Utama' : ($equipment['type'] === 'additional' ? 'Tambahan' : '-') }}"
                                                        disabled>
                                                </div>

                                                {{-- View File Button --}}
                                                <div class="col-md-1 text-end">
                                                    @if (!empty($equipment['file_path']))
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#fileModal_{{ $index }}">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                    @endif
                                                </div>

                                                {{-- File Info --}}
                                                <div class="col-md-12 mt-2">
                                                    @if (!empty($equipment['file_path']))
                                                    <div class="text-success small">
                                                        ✅ Fail dimuat naik: <strong>{{
                                                            basename($equipment['original_name'] ??
                                                            $equipment['file_path']) }}</strong>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Modal --}}
                                    @if (!empty($equipment['file_path']) && !empty($equipment['id']))
                                    <div class="modal fade" id="fileModal_{{ $index }}" tabindex="-1"
                                        aria-labelledby="fileModalLabel_{{ $index }}" aria-hidden="true">
                                        <div class="modal-dialog modal-xl modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="fileModalLabel_{{ $index }}">
                                                        Paparan Fail - {{ $equipment['name'] }}
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body" style="height: 80vh;">
                                                    <iframe src="{{ route('tukarPeralatan.permohonan-04.viewOffEquipment', [
                        'equipment_id' => $equipment['id']
                    ]) }}" style="width: 100%; height: 100%;" frameborder="0">
                                                    </iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @endforeach

                                    <br>
                                    <hr>

                                    <div class="mb-3">
                                        <h4 class="fw-bold mb-0">Peralatan Baharu</h4>
                                        <small class="text-muted">Sila masukkan maklumat peralatan baharu</small>
                                    </div>

                                    <div class="mb-3">
                                        <h5 class="fw-bold mb-0">Peralatan Utama</h5>

                                    </div>

                                    @if (!empty($mainEquipment))
                                    @foreach ($mainEquipment as $i => $main)
                                    <div class="row mb-3">

                                        <div class="col-md-5 mb-2">
                                            <label class="form-label">Peralatan {{ $i + 1 }}</label>
                                            <select name="main[{{ $i }}][name]" class="form-select">
                                                <option value="">Pilih Peralatan</option>
                                                @foreach ($equipmentList as $id => $name)
                                                <option value="{{ $name }}" {{ old("main.$i.name", $main['name'] ?? ''
                                                    )==$name ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @if (!empty($main['file_path']))
                                            <div class="mt-1 text-success small fw-semibold">
                                                Fail telah dimuat naik:
                                                <span>{{ basename($main['original_name'] ?? $main['file_path'])
                                                    }}</span>
                                            </div>
                                            @endif
                                        </div>

                                        <div class="col-md-1 mb-2">
                                            <label class="form-label">Kuantiti</label>
                                            <input type="number" name="main[{{ $i }}][quantity]" class="form-control"
                                                placeholder="Kuantiti" min="1" value="{{ old(" main.$i.quantity",
                                                $main['quantity'] ?? '' ) }}">
                                        </div>

                                        <div class="col-md-5 mb-2">
                                            <label class="form-label">Fail</label>

                                            <input type="file" name="main[{{ $i }}][file]" class="form-control mb-2"
                                                accept=".jpg,.jpeg,.png,.pdf,.docx">

                                            <small class="text-muted d-block">
                                                Format dibenarkan: JPG, JPEG, PNG, PDF, DOCX. Saiz maksimum: 2MB.
                                            </small>

                                        </div>

                                        <div class="col-md mb-2 mt-7">
                                            @if (!empty($main['file_path']))
                                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal"
                                                data-bs-target="#fileModalMain{{ $i }}">
                                                <i class="fa fa-search p-1"></i>
                                            </button>
                                            @endif
                                        </div>

                                        @if (!empty($main['file_path']))
                                        <div class="modal fade" id="fileModalMain{{ $i }}" tabindex="-1"
                                            aria-labelledby="fileModalMainLabel{{ $i }}" aria-hidden="true">
                                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="fileModalMainLabel{{ $i }}">Paparan
                                                            Fail Peralatan Utama</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Tutup"></button>
                                                    </div>
                                                    <div class="modal-body" style="height: 80vh;">
                                                        <iframe
                                                            src="{{ route('tukarPeralatan.permohonan-04.viewTempEquipment', ['type' => 'main', 'index' => $i]) }}"
                                                            style="width: 100%; height: 100%;" frameborder="0"></iframe>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    @endforeach
                                    @else

                                    @php $i = 0; @endphp
                                    <div class="row mb-3">

                                        <div class="col-md-5 mb-2">
                                            <label class="form-label">Peralatan</label>
                                            <select name="main[0][name]" class="form-select">
                                                <option value="">Pilih Peralatan</option>
                                                @foreach ($equipmentList as $id => $name)
                                                <option value="{{ $name }}" {{ old("main.0.name")==$name ? 'selected'
                                                    : '' }}>
                                                    {{ $name }}
                                                </option>
                                                @endforeach
                                            </select>

                                        </div>

                                        <div class="col-md-1 mb-2">
                                            <label class="form-label">Kuantiti</label>
                                            <input type="number" name="main[0][quantity]" class="form-control"
                                                placeholder="Kuantiti" min="1" value="{{ old('main.0.quantity') }}">
                                        </div>

                                        <div class="col-md-5 mb-2">
                                            <label class="form-label">Fail</label>
                                            <input type="file" name="main[0][file]" class="form-control mb-2"
                                                accept=".jpg,.jpeg,.png,.pdf,.docx">
                                            <small class="text-muted d-block">
                                                Format dibenarkan: JPG, JPEG, PNG, PDF, DOCX. Saiz maksimum: 2MB.
                                            </small>

                                        </div>
                                    </div>
                                    @endif

                                    <hr>

                                    {{-- Peralatan Tambahan --}}
                                    <div class="mb-5">
                                        <div class="mb-3">
                                            <h5 class="fw-bold mb-0">Peralatan Tambahan</h5>
                                            <small class="text-muted">Senaraikan peralatan tambahan (maksimum
                                                5)</small>
                                        </div>

                                        @for ($i = 0; $i < 5; $i++) @php $additional=$additionalEquipments[$i] ?? [];
                                            @endphp <div class="row mb-3">
                                            <div class="col-md-5 mb-2">
                                                <label class="form-label">Peralatan {{ $i + 1 }}</label>
                                                <select name="additional[{{ $i }}][name]" class="form-select">
                                                    <option value="">Pilih Peralatan</option>
                                                    @foreach($equipmentList as $id => $name)
                                                    <option value="{{ $name }}" {{ old("additional.$i.name",
                                                        $additional['name'] ?? '' )==$name ? 'selected' : '' }}>
                                                        {{ $name }}
                                                    </option>
                                                    @endforeach
                                                </select>

                                                @if (!empty($additional['file_path']))
                                                <div class="mt-1 text-success small fw-semibold">
                                                    Fail telah dimuat naik:
                                                    <span>{{ basename($additional['original_name'] ??
                                                        $additional['file_path']) }}</span>
                                                </div>
                                                @endif

                                            </div>

                                            <div class="col-md-1 mb-2">
                                                <label class="form-label">Kuantiti</label>
                                                <input type="number" name="additional[{{ $i }}][quantity]"
                                                    class="form-control" placeholder="Kuantiti" min="1" value="{{ old("
                                                    additional.$i.quantity", $additional['quantity'] ?? '' ) }}">
                                            </div>

                                            <div class="col-md-5 mb-2">
                                                <label class="form-label">Fail</label>
                                                <input type="file" name="additional[{{ $i }}][file]"
                                                    class="form-control mb-2" accept=".jpg,.jpeg,.png,.pdf,.docx">
                                                <small class="text-muted d-block">
                                                    Format dibenarkan: JPG, JPEG, PNG, PDF, DOCX. Saiz maksimum:
                                                    2MB.
                                                </small>
                                            </div>

                                            <div class="col-md mb-2 mt-7">
                                                @if (!empty($additional['file_path']))
                                                <button type="button" class="btn btn-primary w-100"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#fileModalAdditional{{ $i }}">
                                                    <i class="fa fa-search p-1"></i>
                                                </button>
                                                @endif
                                            </div>
                                    </div>

                                    @if (!empty($additional['file_path']))
                                    <div class="modal fade" id="fileModalAdditional{{ $i }}" tabindex="-1"
                                        aria-labelledby="fileModalAdditionalLabel{{ $i }}" aria-hidden="true">
                                        <div class="modal-dialog modal-xl modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="fileModalAdditionalLabel{{ $i }}">
                                                        Paparan Fail Peralatan Tambahan {{ $i + 1 }}
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body" style="height: 80vh;">
                                                    <iframe
                                                        src="{{ route('tukarPeralatan.permohonan-04.viewTempEquipment', ['type' => 'additional', 'index' => $i]) }}"
                                                        style="width: 100%; height: 100%;" frameborder="0"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endfor
                            </div>
                            </form>

                            {{-- @if ($latestEquipmentGroup->isNotEmpty())

                            <table class="table table-borderless">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 35%">Nama Peralatan</th>
                                        <th style="width: 10%" class="text-center">Kuantiti</th>
                                        <th style="width: 15%" class="text-center">Jenis</th>

                                        <th style="width: 20%" class="text-center">Lampiran</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latestEquipmentGroup as $equipment)
                                    <tr>
                                        <td>{{ $equipment->name }}</td>
                                        <td class="text-center">{{ $equipment->quantity }}</td>
                                        <td class="text-center">
                                            {{ $equipment->type === 'main' ? 'UTAMA' : ($equipment->type ===
                                            'additional' ? 'TAMBAHAN' : '-') }}
                                        </td>

                                        <td class="text-center">
                                            @if (!empty($equipment->file_path))
                                            <!-- Trigger Modal -->
                                            <button type="button" class="btn  btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#equipmentModal{{ $equipment->id }}">
                                                <i class="fa fa-search"></i>
                                            </button>

                                            <!-- Modal with iframe -->
                                            <div class="modal fade" id="equipmentModal{{ $equipment->id }}"
                                                tabindex="-1" aria-labelledby="equipmentModalLabel{{ $equipment->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-xl modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="equipmentModalLabel{{ $equipment->id }}">
                                                                Lampiran Peralatan</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                        </div>
                                                        <div class="modal-body" style="height: 80vh;">
                                                            <iframe
                                                                src="{{ route('tukarPeralatan.permohonan-04.viewEquipmentFile', ['equipment_id' => $equipment->id]) }}"
                                                                style="width: 100%; height: 100%; border: none;"></iframe>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                            <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            @else
                            <p>Tiada peralatan ditemui untuk permohonan terbaru.</p>
                            @endif

                            <br>
                            <hr>

                            <div class="mb-3">
                                <h4 class="fw-bold mb-0">Rekod Peralatan Menangkap Ikan </h4>
                                <small class="text-muted">Senarai rekod peralatan yang telah di lesenkan</small>
                            </div>

                            @foreach ($equipmentGrouped as $applicationId => $equipmentList)
                            @php
                            $createdDate = $equipmentList->sortByDesc('created_at')->first()?->created_at;
                            @endphp

                            <h4 class="mt-2 mb-2 text-center">
                                {{ optional($createdDate)->format('d-m-Y') ?? 'Tidak Diketahui' }}
                                </h6>

                                <table class="table table-borderless  align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 35%">Nama Peralatan</th>
                                            <th style="width: 10%" class="text-center">Kuantiti</th>
                                            <th style="width: 15%" class="text-center">Jenis</th>
                                            <th style="width: 20%" class="text-center">Lampiran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($equipmentList as $equipment)
                                        <tr>
                                            <td>{{ $equipment->name }}</td>
                                            <td class="text-center">{{ $equipment->quantity }}</td>
                                            <td class="text-center">{{ $equipment->type === 'main' ? 'Utama' :
                                                'Tambahan' }}</td>
                                            <td class="text-center">
                                                @if (!empty($equipment->file_path))
                                                <!-- Trigger Modal -->
                                                <button type="button" class="btn  btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#equipmentModal{{ $equipment->id }}">
                                                    <i class="fa fa-search"></i>
                                                </button>

                                                <!-- Modal with iframe -->
                                                <div class="modal fade" id="equipmentModal{{ $equipment->id }}"
                                                    tabindex="-1"
                                                    aria-labelledby="equipmentModalLabel{{ $equipment->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="equipmentModalLabel{{ $equipment->id }}">
                                                                    Lampiran Peralatan</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                            </div>
                                                            <div class="modal-body" style="height: 80vh;">
                                                                <iframe
                                                                    src="{{ route('tukarPeralatan.permohonan-04.viewEquipmentFile', ['equipment_id' => $equipment->id]) }}"
                                                                    style="width: 100%; height: 100%; border: none;"></iframe>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @else
                                                <span class="text-muted">-</span>
                                                @endif
                                            </td>

                                        </tr>

                                        @php
                                        $historyList =
                                        \App\Models\darat_user_equipment_history::where('equipment_id',
                                        $equipment->id)
                                        ->orderByDesc('updated_at')->get();
                                        @endphp

                                        @if ($historyList->isNotEmpty())
                                        <tr class="bg-light">
                                            <td colspan="4">
                                                <strong>Sejarah Perubahan:</strong>
                                                <ul class="mb-0 small ps-3">
                                                    @foreach ($historyList as $history)
                                                    <li>
                                                        {{ $history->updated_at->format('d-m-Y H:i') }} —
                                                        Nama: {{ $history->name }},
                                                        Kuantiti: {{ $history->quantity }},
                                                        Jenis: {{ $history->type === 'main' ? 'Utama' :
                                                        'Tambahan'
                                                        }},
                                                        Keadaan: {{ $history->condition }}
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                                @endforeach --}}

                                {{-- <div class="mb-3">
                                    <h4 class="fw-bold mb-0">Peralatan Utama</h4>
                                    <small class="text-muted">Maklumat peralatan utama yang digunakan</small>
                                </div>

                                @if ($equipmentOff->isNotEmpty())
                                <table class="table table-borderless">

                                    <thead class="table-light">
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Peralatan</th>
                                            <th>Kuantiti</th>
                                            <th>Jenis</th>
                                            <th>Keadaan</th>
                                            <th>Fail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($equipmentOff as $index => $equipment)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $equipment->name }}</td>
                                            <td>{{ $equipment->quantity }}</td>
                                            <td>
                                                @if ($equipment->type === 'main')
                                                UTAMA
                                                @elseif ($equipment->type === 'additional')
                                                TAMBAHAN
                                                @else
                                                -
                                                @endif
                                            </td>

                                            <td>{{ ucfirst($equipment->condition ?? '-') }}</td>
                                            <td>
                                                @if ($equipment->file_path)
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#equipmentFileModal{{ $equipment->id }}">
                                                    <i class="fa fa-search"></i>
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="equipmentFileModal{{ $equipment->id }}"
                                                    tabindex="-1"
                                                    aria-labelledby="equipmentFileModalLabel{{ $equipment->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="equipmentFileModalLabel{{ $equipment->id }}">
                                                                    Paparan Fail Peralatan</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                            </div>
                                                            <div class="modal-body" style="height: 80vh;">
                                                                <iframe
                                                                    src="{{ route('tukarPeralatan.permohonan-04.viewEquipmentFile', ['equipment_id' => $equipment->id]) }}"
                                                                    style="width: 100%; height: 100%;"
                                                                    frameborder="0"></iframe>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @else
                                                Tiada
                                                @endif
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @else
                                <div class="alert alert-info">
                                    Tiada peralatan direkodkan untuk pengguna ini.
                                </div>
                                @endif --}}

                                {{--
                                </form> --}}
                        </div>

                        <div class="tab-pane fade" id="content-tab5" role="tabpanel" aria-labelledby="tab5-link">
                            {{-- <form id="store_tab5" method="POST" enctype="multipart/form-data"
                                action="{{ route('tukarPeralatan.permohonan-04.store_tab5') }}">
                                @csrf --}}

                                <div class="mb-3">
                                    <h4 class="fw-bold mb-0">Maklumat Pemilikan Vesel</h4>
                                    <small class="text-muted">Maklumat ini dipaparkan untuk semakan sahaja</small>
                                    <hr>
                                </div>

                                <div class="mb-4">
                                    <div class="row mt-3">
                                        @if (!empty($vesselInfoOff?->vessel_registration_number))
                                        <div class="col-md-6 mb-3">
                                            <label for="vessel_registration_number" class="form-label">No. Pendaftaran
                                                Vesel</label>
                                            <input type="text" name="vessel_registration_number"
                                                id="vessel_registration_number" class="form-control"
                                                value="{{ old('vessel_registration_number', $vesselInfoOff->vessel_registration_number) }}"
                                                readonly>
                                        </div>
                                        @endif

                                        <div class="col-md-6 mb-3">
                                            <label for="hull_type" class="form-label">Jenis Kulit Vesel <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="hull_type" id="hull_type" class="form-control"
                                                value="{{ old('hull_type', $vesselInfoOff->hull->hull_type ?? '-') }}"
                                                readonly>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="length" class="form-label">Panjang (m) <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" step="0.01" name="length" id="length"
                                                class="form-control"
                                                value="{{ old('length', $vesselInfoOff->hull->length ?? '-') }}"
                                                readonly>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="width" class="form-label">Lebar (m) <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" step="0.01" name="width" id="width"
                                                class="form-control"
                                                value="{{ old('width', $vesselInfoOff->hull->width ?? '-') }}" readonly>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="depth" class="form-label">Kedalaman (m) <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" step="0.01" name="depth" id="depth"
                                                class="form-control"
                                                value="{{ old('depth', $vesselInfoOff->hull->depth ?? '-') }}" readonly>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Adakah vesel mempunyai enjin?</label>
                                        <select name="has_engine" id="has_engine" class="form-select" disabled>
                                            <option value="">Pilih</option>
                                            <option value="yes" {{ $vesselInfoOff->engine ? 'selected' : '' }}>YA
                                            </option>
                                            <option value="no" {{ !$vesselInfoOff->engine ? 'selected' : '' }}>TIDAK
                                            </option>
                                        </select>
                                    </div>

                                    @if ($vesselInfoOff->engine)
                                    <br>
                                    <hr>

                                    <div id="engine_section">
                                        <div class="mb-3">
                                            <h4 class="fw-bold mb-0">Maklumat Enjin</h4>
                                            <small class="text-muted">Maklumat enjin dipaparkan untuk semakan
                                                sahaja</small>
                                        </div>

                                        <div class="row">
                                            <div class="col-md mb-3">
                                                <label for="engine_model" class="form-label">Model Enjin <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="engine_model" id="engine_model"
                                                    class="form-control"
                                                    value="{{ old('engine_model', $vesselInfoOff->engine->engine_model ?? '-') }}"
                                                    readonly>
                                            </div>

                                            <div class="col-md mb-3">
                                                <label for="engine_power" class="form-label">Kuasa Kuda (KK) <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="engine_power" id="engine_power"
                                                    class="form-control"
                                                    value="{{ old('engine_power', $vesselInfoOff->engine->horsepower ?? '-') }}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                {{--
                            </form> --}}
                            <br>
                        </div>

                        <div class="tab-pane fade" id="content-tab6" role="tabpanel" aria-labelledby="tab6-link">
                            <form method="POST" id="store_tab6"
                                action="{{ route('tukarPeralatan.permohonan-04.store_tab6') }}"
                                enctype="multipart/form-data">
                                @csrf

                                {{-- <div class="mb-4">
                                    <h4 class="fw-bold mb-0">Muat Naik Dokumen Permohonan Bertandatangan</h4>
                                    <small class="text-muted">Sila cetak permohonan anda, dapatkan tandatangan
                                        daripada
                                        Penghulu/Ketua Kampung/JKKK/JKOA/MyKP Officer, dan muat naik semula dokumen
                                        tersebut.</small>
                                    <div class="alert alert-warning mt-3">
                                        <strong>Perhatian:</strong> Pastikan dokumen lengkap telah ditandatangani
                                        sebelum dimuat naik.
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md mb-3">
                                            <label for="signed_application" class="form-label">
                                                Dokumen Permohonan Bertandatangan <span class="text-danger">*</span>
                                            </label>
                                            <input type="file" name="signed_application" id="signed_application"
                                                class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                                        </div>

                                        @foreach ($signedDocuments as $index => $doc)
                                        @if (!empty($doc['file_path']) && $doc['type'] === 'required')
                                        <div class="col-md-1 mb-3">
                                            <label class="form-label d-none d-md-block">&nbsp;</label>
                                            <button type="button" class="btn btn-primary col-md" data-bs-toggle="modal"
                                                data-bs-target="#signedDocumentModal{{ $index }}">
                                                <i class="fa fa-search p-1"></i>
                                            </button>
                                        </div>

                                        <div class="modal fade" id="signedDocumentModal{{ $index }}" tabindex="-1"
                                            aria-labelledby="signedDocumentModalLabel{{ $index }}" aria-hidden="true">
                                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="signedDocumentModalLabel{{ $index }}">
                                                            Dokumen : {{ $doc['title'] ??
                                                            'Dokumen' }}
                                                        </h5>

                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Tutup"></button>
                                                    </div>
                                                    <div class="modal-body" style="height: 80vh;">
                                                        <iframe
                                                            src="{{ route('tukarPeralatan.permohonan-04.viewDocument', ['index' => $index]) }}"
                                                            style="width: 100%; height: 100%;" frameborder="0">
                                                        </iframe>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach

                                    </div>

                                </div>

                                <br> --}}

                                <h4 class="fw-bold mb-0">Dokumen Tambahan (Jika Ada)</h4>
                                <small class="text-muted">Muat naik dokumen sokongan tambahan (jika ada)</small>

                                <!-- Additional Documents Section -->
                                <div id="additional-documents-wrapper">
                                    @php
                                    $oldTitles = old('additional_titles', []);
                                    $hasOld = count($oldTitles) > 0;
                                    $hasExisting = !empty($additionalDocuments);
                                    @endphp

                                    @if ($hasOld)
                                    {{-- Case 1: Re-populate old() on validation error --}}
                                    @foreach ($oldTitles as $index => $title)
                                    <div class="row mt-3 additional-document-item">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nama Dokumen</label>
                                            <input type="text" name="additional_titles[]" class="form-control"
                                                value="{{ $title }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Fail Dokumen</label>
                                            <div class="input-group">
                                                <input type="file" name="additional_documents[]" class="form-control"
                                                    accept=".pdf,.jpg,.jpeg,.png">
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @elseif ($hasExisting)
                                    {{-- Case 2: Show uploaded documents as readonly --}}
                                    @foreach ($additionalDocuments as $index => $document)
    <div class="row mt-3 additional-document-item">
        <!-- Nama Dokumen -->
        <div class="col-md-6 mb-3">
            <label class="form-label">Nama Dokumen</label>
            <input type="text" name="additional_titles[]" class="form-control"
                   value="{{ $document['title'] ?? '' }}"
                   placeholder="Contoh: Surat Sokongan Tambahan">

            @if (!empty($document['file_path']))
                <div class="text-success small mt-1">
                    ✅ Fail telah dimuat naik: <strong>{{ basename($document['file_path']) }}</strong>
                </div>
            @endif
        </div>

        <!-- Fail Dokumen + Preview -->
        <div class="col-md-6 mb-3">
            <label class="form-label">Fail Dokumen</label>
            <div class="d-flex gap-2 align-items-start">
                <div class="flex-grow-1">
                    <input type="file" name="additional_documents[]" class="form-control"
                           accept=".pdf,.jpg,.jpeg,.png,.docx">
                    <small class="text-muted d-block mt-1">
                        Format dibenarkan: JPG, JPEG, PNG, PDF, DOCX. Saiz maksimum: 2MB.
                    </small>
                </div>

                @if (!empty($document['file_path']))
                    <button type="button" class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#documentModal{{ $index }}"
                            title="Lihat Fail">
                        <i class="fa fa-search p-1"></i>
                    </button>
                @endif
            </div>

            <!-- Modal Preview -->
            @if (!empty($document['file_path']))
                <div class="modal fade" id="documentModal{{ $index }}" tabindex="-1"
                     aria-labelledby="documentModalLabel{{ $index }}" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="documentModalLabel{{ $index }}">
                                    Paparan Dokumen: {{ $document['title'] ?? 'Dokumen Tambahan' }}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body" style="height: 80vh;">
                                <iframe src="{{ route('tukarPeralatan.permohonan-04.viewDocument', ['type' => 'additional', 'index' => $index]) }}"
                                        style="width: 100%; height: 100%;" frameborder="0"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endforeach

                                    @else
                                    {{-- Case 3: Show one blank input if no data --}}
                                    <div class="row mt-3 additional-document-item">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nama Dokumen</label>
                                            <input type="text" name="additional_titles[]" class="form-control"
                                                placeholder="Contoh: Surat Sokongan Tambahan">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Fail Dokumen</label>
                                            <div class="input-group">
                                                <input type="file" name="additional_documents[]" class="form-control"
                                                    accept=".pdf,.jpg,.jpeg,.png">
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <!-- Button to Add More Documents -->
                                <div class="text-end">
                                    <button type="button" class="btn btn-primary col-md" id="add-document-btn">Tambah
                                        Dokumen</button>
                                </div>
                        </div>

                        </form>
                    </div>
                    <script>
                        document.getElementById('add-document-btn').addEventListener('click', function() {
                                        var newDocumentItem = document.createElement('div');
                                        newDocumentItem.classList.add('row', 'mt-3', 'additional-document-item');

                                        newDocumentItem.innerHTML = `
        <div class="col-md-6 mb-3">
            <label class="form-label">Nama Dokumen</label>
            <input type="text" name="additional_titles[]" class="form-control" placeholder="Contoh: Surat Sokongan Tambahan">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Fail Dokumen</label>
            <div class="input-group">
                <!-- File Upload Input -->
                <input type="file" name="additional_documents[]" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                <!-- Lihat Fail Button is not needed for new documents -->
            </div>
        </div>
    `;

                                        // Append the new document item to the wrapper
                                        document.getElementById('additional-documents-wrapper').appendChild(newDocumentItem);
                                    });
                    </script>

                    <div class="card-footer pl-0 pr-0">
                        <div class="d-flex justify-content-between align-items-start flex-wrap">
                            <!-- Left: Print Button -->
                            <div class="m-0 mb-2">
                                {{-- <div id="printButtonContainer" style="display: none;">
                                    <a href="{{ route('tukarPeralatan.permohonan-04.printApplication') }}"
                                        target="_blank" class="btn btn-primary m-0">
                                        <i class="fa fa-print"></i> Cetak Borang Permohonan
                                    </a> --}}
                                </div>

                            </div>

                            <!-- Right: Navigation Buttons -->
                            <div class="d-flex justify-content-end mb-2 flex-wrap gap-2">
                                <button id="backTabBtn" type="button" class="btn btn-light"
                                    style="width: 120px;">Kembali</button>

                                {{-- <button id="saveBtn2" type="submit" form="store_tab2" class="btn btn-warning"
                                    style="width: 120px;">Simpan</button>
                                <button id="saveBtn3" type="submit" form="store_tab3" class="btn btn-warning"
                                    style="width: 120px;">Simpan</button> --}}
                                <button id="saveBtn4" type="submit" form="store_tab4" class="btn btn-warning"
                                    style="width: 120px;">Simpan</button>
                                {{-- <button id="saveBtn5" type="submit" form="store_tab5" class="btn btn-warning"
                                    style="width: 120px;">Simpan</button> --}}
                                <button id="saveBtn6" type="submit" form="store_tab6" class="btn btn-warning"
                                    style="width: 120px;">Simpan</button>

                                <button id="nextTabBtn" type="button" class="btn btn-light"
                                    style="width: 120px;">Seterusnya</button>

                                <form id="submitPermohonan" method="POST" enctype="multipart/form-data"
                                    action="{{ route('tukarPeralatan.permohonan-04.store') }}">
                                    @csrf
                                </form>

                                <button id="submitBtn" type="button" class="btn btn-success"
                                    style="display: none; width: 120px;">Hantar</button>

                            </div>

                        </div>
                    </div>

                </div>

            </div>
            @endsection

            @push('scripts')
            <script type="text/javascript">
                $(document).ready(function() {
                                $("input[type=text], textarea").each(function() {
                                    const currentVal = $(this).val();
                                    if (currentVal && typeof currentVal === "string") {
                                        $(this).val(currentVal.toUpperCase());
                                    }
                                });

                                $(document).on('input', "input[type=text], textarea", function() {
                                    $(this).val(function(_, val) {
                                        return val.toUpperCase();
                                    });
                                });
                            });
            </script>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                                var msgSuccess = @json(Session::get('success'));
                                if (msgSuccess) {
                                    alert(msgSuccess);
                                }

                                var msgError = @json(Session::get('error'));
                                if (msgError) {
                                    alert(msgError);
                                }
                            });
            </script>

            <script>
                let currentTab = 1;
    const totalTabs = 6;

    document.addEventListener("DOMContentLoaded", () => {
        const lastSavedTab = sessionStorage.getItem("lastSavedTab");
        if (lastSavedTab) {
            currentTab = parseInt(lastSavedTab);
        }

        changeTab(currentTab);

        for (let i = 1; i <= totalTabs; i++) {
            const btn = document.getElementById(`saveBtn${i}`);
            if (btn) {
                btn.style.display = i === currentTab ? 'inline-block' : 'none';
                btn.onclick = () => {
                    submitForm(i);
                    // Only set saved flag for tab 6
                    if (i === 6) {
                        sessionStorage.setItem(`tab6_saved`, 'true');
                    }
                    sessionStorage.setItem("lastSavedTab", i);
                };
            }
        }

        document.getElementById("submitBtn").onclick = confirmSubmission;

        document.getElementById("nextTabBtn").onclick = () => {
            // Only enforce "Simpan" requirement on tab 6
            if (currentTab < totalTabs) {
                changeTab(currentTab + 1);
            }
        };

        document.getElementById("backTabBtn").onclick = () => {
            if (currentTab > 1) changeTab(currentTab - 1);
        };

        toggleTabsAndButtons();
    });

    function changeTab(newTab) {
        currentTab = newTab;
        sessionStorage.setItem("lastSavedTab", currentTab);
        toggleTabsAndButtons();
    }

    function toggleTabsAndButtons() {
        for (let i = 1; i <= totalTabs; i++) {
            toggleTab(i, i === currentTab);
            toggleSimpan(i, i === currentTab);
        }

        toggleSubmitButton();

        const nextTabBtn = document.getElementById('nextTabBtn');
        if (nextTabBtn) {
            nextTabBtn.style.display = currentTab === totalTabs ? 'none' : 'inline-block';
        }

        const printBtnContainer = document.getElementById('printButtonContainer');
        if (printBtnContainer) {
            printBtnContainer.style.display = currentTab === totalTabs ? 'block' : 'none';
        }
    }

    function toggleTab(tab, show) {
        document.getElementById(`tab${tab}-link`).classList.toggle("active", show);
        document.getElementById(`content-tab${tab}`).classList.toggle("show", show);
        document.getElementById(`content-tab${tab}`).classList.toggle("active", show);
    }

    function toggleSimpan(tab, show) {
        const btn = document.getElementById(`saveBtn${tab}`);
        if (btn) btn.style.display = show ? 'inline-block' : 'none';
    }

    function toggleSubmitButton() {
        const submitBtn = document.getElementById('submitBtn');
        if (submitBtn) {
            submitBtn.style.display = currentTab === totalTabs ? 'inline-block' : 'none';
        }
    }

    function submitForm(tab) {
        const form = document.getElementById(`store_tab${tab}`);
        if (form) {
            form.submit();
        }
    }

    function confirmSubmission() {
        const isTab6Saved = sessionStorage.getItem("tab6_saved") === "true";

        if (!isTab6Saved) {
            alert("Sila klik simpan sebelum menghantar permohonan.");
            changeTab(6); // Switch to tab 6 if not saved
            return;
        }

        const msg = "Saya dengan ini mengakui dan mengesahkan bahawa segala maklumat yang diberikan adalah benar dan tepat. " +
                    "Sebarang ketidaktepatan adalah tanggungjawab saya.\n\nAdakah anda pasti untuk menghantar permohonan ini?";
        if (confirm(msg)) {
            sessionStorage.removeItem("lastSavedTab");
            sessionStorage.removeItem("tab6_saved");

            document.getElementById('submitPermohonan').submit();
        }
    }

    window.addEventListener("load", () => {
        const lastSavedTab = sessionStorage.getItem("lastSavedTab");
        if (lastSavedTab) {
            currentTab = parseInt(lastSavedTab);
            changeTab(currentTab);
        } else {
            changeTab(1);
        }
    });
            </script>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            @endpush
