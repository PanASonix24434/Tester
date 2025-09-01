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
                                <a href="http://127.0.0.1:8000/lesenTahunan/permohonan-02">{{
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
                                    action="{{ route('lesenTahunan.permohonan-02.store_tab1') }}">
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
                                                <label for="icno" class="form-label">Nombor Kad
                                                    Pengenalan</label>
                                                <input type="text" class="form-control" id="icno"
                                                    name="icno"
                                                    value="{{ old('icno', $userDetail->icno ?? '') }}"
                                                    placeholder="Masukkan Nombor Kad Pengenalan" readonly>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-6 mb-3">
                                                <label for="no_phone" class="form-label">Nombor Telefon</label>
                                                <input type="text" class="form-control" id="no_phone"
                                                    name="no_phone"
                                                    value="{{ old('no_phone', $userDetail->no_phone ?? '') }}"
                                                    placeholder="Masukkan Nombor Telefon" readonly>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="secondary_no_phone" class="form-label">Nombor Telefon
                                                    (Kedua)</label>
                                                <input type="text" class="form-control" id="secondary_no_phone"
                                                    name="secondary_no_phone"
                                                    value="{{ old('secondary_no_phone', $userDetail->secondary_no_phone ?? '') }}"
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
                                                    value="{{ old('address', trim(($userDetail->secondary_address_1 ?? '') . ' ' . ($userDetail->secondary_address_2 ?? '') . ' ' . ($userDetail->secondary_address_3 ?? ''))) }}"
                                                    placeholder="Masukkan Alamat Anda" readonly>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="poskod" class="form-label">Poskod</label>
                                                <input type="text" class="form-control" id="poskod" name="poskod"
                                                    value="{{ old('poskod', $userDetail->secondary_poskod ?? '') }}"
                                                    placeholder="Masukkan Poskod" readonly>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="district" class="form-label">Daerah</label>
                                                <input type="text" class="form-control" id="district" name="district"
                                                    value="{{ old('district', $userDetail->secondary_district ?? '') }}"
                                                    placeholder="Masukkan Daerah" readonly>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="state" class="form-label">Negeri</label>
                                                <input type="text" class="form-control" id="state" name="state"
                                                    value="{{ old('state', $userDetail->secondary_state ?? '') }}"
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
                                                <input type="text" class="form-control" id="address" name="address"
                                                    value="{{ old('address', trim(($userDetail->address1 ?? '') . ' ' . ($userDetail->address2 ?? '') . ' ' . ($userDetail->address3 ?? ''))) }}"
                                                    placeholder="Masukkan Alamat Anda" readonly>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="secondary_postcode " class="form-label">Poskod</label>
                                                <input type="text" class="form-control" id="secondary_postcode "
                                                    name="secondary_postcode "
                                                    value="{{ old('secondary_postcode ', $userDetail->poskod ?? '') }}"
                                                    placeholder="Masukkan Poskod" readonly>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="secondary_district" class="form-label">Daerah</label>
                                                <input type="text" class="form-control" id="secondary_district"
                                                    name="secondary_district"
                                                    value="{{ old('secondary_district', $userDetail->district ?? '') }}"
                                                    placeholder="Masukkan Daerah" readonly>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="secondary_state  " class="form-label">Negeri</label>
                                                <input type="text" class="form-control" id="secondary_state  "
                                                    name="secondary_state  "
                                                    value="{{ old('secondary_state  ', $userDetail->state ?? '') }}"
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
                                    action="{{ route('lesenTahunan.permohonan-02.store_tab2') }}">
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
                                    action="{{ route('lesenTahunan.permohonan-02.store_tab3') }}">
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
                                            value="{{ $jettyOff->state ?? 'Tiada Maklumat' }}" readonly>
                                    </div>

                                    <!-- Daerah -->
                                    <div class="mb-3">
                                        <label class="form-label">Daerah</label>
                                        <input type="text" class="form-control"
                                            value="{{ $jettyOff->district ?? 'Tiada Maklumat' }}" readonly>
                                    </div>

                                    <!-- Jeti / Pangkalan -->
                                    <div class="mb-3">
                                        <label class="form-label">Nama Jeti / Pangkalan</label>
                                        <input type="text" class="form-control"
                                            value="{{ $jettyOff->jetty_name ?? 'Tiada Maklumat' }}" readonly>
                                    </div>

                                    <!-- Sungai -->
                                    <div class="mb-3">
                                        <label class="form-label">Sungai</label>
                                        <input type="text" class="form-control"
                                            value="{{ $jettyOff->river ?? 'Tiada Maklumat' }}" readonly>
                                    </div>

                                    {{--
                                </form> --}}
                            </div>

                            <div class="tab-pane fade" id="content-tab4" role="tabpanel" aria-labelledby="tab4-link">
                                {{-- <form id="store_tab4" method="POST" enctype="multipart/form-data"
                                    action="{{ route('lesenTahunan.permohonan-02.store_tab4') }}">
                                    @csrf --}}

                                    <div class="mb-3">
                                        <h4 class="fw-bold mb-0">Peralatan Menangkap Ikan </h4>
                                        <small class="text-muted">Senarai peralatan yang telah di lesenkan</small>
                                    </div>

                                    @if ($latestEquipmentGroup->isNotEmpty())

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
                                                    <button type="button" class="btn  btn-primary"
                                                        data-bs-toggle="modal"
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
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Tutup"></button>
                                                                </div>
                                                                <div class="modal-body" style="height: 80vh;">
                                                                    <iframe
                                                                        src="{{ route('lesenTahunan.permohonan-02.viewEquipmentFile', ['equipment_id' => $equipment->id]) }}"
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
                                                        <button type="button" class="btn  btn-primary"
                                                            data-bs-toggle="modal"
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
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Tutup"></button>
                                                                    </div>
                                                                    <div class="modal-body" style="height: 80vh;">
                                                                        <iframe
                                                                            src="{{ route('lesenTahunan.permohonan-02.viewEquipmentFile', ['equipment_id' => $equipment->id]) }}"
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
                                        @endforeach

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
                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#equipmentFileModal{{ $equipment->id }}">
                                                            <i class="fa fa-search"></i>
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class="modal fade"
                                                            id="equipmentFileModal{{ $equipment->id }}" tabindex="-1"
                                                            aria-labelledby="equipmentFileModalLabel{{ $equipment->id }}"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="equipmentFileModalLabel{{ $equipment->id }}">
                                                                            Paparan Fail Peralatan</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Tutup"></button>
                                                                    </div>
                                                                    <div class="modal-body" style="height: 80vh;">
                                                                        <iframe
                                                                            src="{{ route('lesenTahunan.permohonan-02.viewEquipmentFile', ['equipment_id' => $equipment->id]) }}"
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
                                    action="{{ route('lesenTahunan.permohonan-02.store_tab5') }}">
                                    @csrf --}}

                                    <div class="mb-3">
                                        <h4 class="fw-bold mb-0">Maklumat Pemilikan Vesel</h4>
                                        <small class="text-muted">Maklumat ini dipaparkan untuk semakan sahaja</small>
                                        <hr>
                                    </div>

                                    <div class="mb-4">
                                        <div class="row mt-3">
                                            <div class="col-md-6 mb-3">
                                                <label for="vessel_registration_number" class="form-label">No.
                                                    Pendaftaran Vesel</label>
                                                <input type="text" name="vessel_registration_number"
                                                    id="vessel_registration_number" class="form-control"
                                                    value="{{ old('vessel_registration_number', $vesselInfoOff->vessel_registration_number ?? '-') }}"
                                                    readonly>
                                            </div>

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
                                                    value="{{ old('width', $vesselInfoOff->hull->width ?? '-') }}"
                                                    readonly>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="depth" class="form-label">Kedalaman (m) <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" step="0.01" name="depth" id="depth"
                                                    class="form-control"
                                                    value="{{ old('depth', $vesselInfoOff->hull->depth ?? '-') }}"
                                                    readonly>
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
                                    action="{{ route('lesenTahunan.permohonan-02.store_tab6') }}"
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
                                                <button type="button" class="btn btn-primary col-md"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#signedDocumentModal{{ $index }}">
                                                    <i class="fa fa-search p-1"></i>
                                                </button>
                                            </div>

                                            <div class="modal fade" id="signedDocumentModal{{ $index }}" tabindex="-1"
                                                aria-labelledby="signedDocumentModalLabel{{ $index }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-xl modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="signedDocumentModalLabel{{ $index }}">
                                                                Dokumen : {{ $doc['title'] ??
                                                                'Dokumen' }}
                                                            </h5>

                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                        </div>
                                                        <div class="modal-body" style="height: 80vh;">
                                                            <iframe
                                                                src="{{ route('lesenTahunan.permohonan-02.viewDocument', ['index' => $index]) }}"
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
                                                    <input type="file" name="additional_documents[]"
                                                        class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @elseif ($hasExisting)
                                        {{-- Case 2: Show uploaded documents as readonly --}}
                                        @foreach ($additionalDocuments as $index => $document)
                                        <div class="row mt-3 additional-document-item">
                                            <!-- Nama Dokumen (Editable) -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Nama Dokumen</label>
                                                <input type="text" name="additional_titles[]" class="form-control"
                                                    value="{{ $document['title'] ?? '' }}"
                                                    placeholder="Contoh: Surat Sokongan Tambahan">
                                            </div>

                                            <!-- Fail Dokumen (Editable Upload + Preview Button) -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Fail Dokumen</label>
                                                <div class="d-flex gap-2 align-items-end">
                                                    <!-- File input -->
                                                    <input type="file" name="additional_documents[]"
                                                        class="form-control" accept=".pdf,.jpg,.jpeg,.png">

                                                    <!-- Preview Button -->
                                                    @if (!empty($document['file_path']))
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#documentModal{{ $index }}" title="Lihat Fail">
                                                        <i class="fa fa-search p-1"></i>
                                                    </button>
                                                    @endif
                                                </div>

                                                <!-- Modal -->
                                                @if (!empty($document['file_path']))
                                                <div class="modal fade" id="documentModal{{ $index }}" tabindex="-1"
                                                    aria-labelledby="documentModalLabel{{ $index }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="documentModalLabel{{ $index }}">
                                                                    Paparan Dokumen: {{ $document['title'] ?? 'Dokumen
                                                                    Tambahan' }}
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                            </div>
                                                            <div class="modal-body" style="height: 80vh;">
                                                                <iframe
                                                                    src="{{ route('lesenTahunan.permohonan-02.viewDocument', ['type' => 'additional', 'index' => $index]) }}"
                                                                    style="width: 100%; height: 100%;"
                                                                    frameborder="0"></iframe>
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
                                                    <input type="file" name="additional_documents[]"
                                                        class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>

                                    <!-- Button to Add More Documents -->
                                    <div class="text-end">
                                        <button type="button" class="btn btn-primary col-md"
                                            id="add-document-btn">Tambah
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
                            <div class="d-flex justify-content-end align-items-start flex-wrap">
                                <!-- Left: (Removed Print Button) -->

                                <!-- Right: Navigation Buttons -->
                                <div class="d-flex justify-content-end mb-2 flex-wrap gap-2">
                                    <button id="backTabBtn" type="button" class="btn btn-light"
                                        style="width: 120px;">Kembali</button>

                                    <button id="saveBtn6" type="submit" form="store_tab6" class="btn btn-warning"
                                        style="width: 120px;">Simpan</button>

                                    <button id="nextTabBtn" type="button" class="btn btn-light"
                                        style="width: 120px;">Seterusnya</button>

                                    <form id="submitPermohonan" method="POST" enctype="multipart/form-data"
                                        action="{{ route('lesenTahunan.permohonan-02.store') }}">
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
