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
                        <h3 class="">{{ $applicationType->name_ms }}</h3>
                        <small>{{ $moduleName->name }} - {{ $roleName }}</small>
                    </div>

                </div>
                <div class="col-md-3 align-content-center">
                    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
                        <ol class="breadcrumb text-center">
                            <li class="breadcrumb-item">
                                <a href="http://127.0.0.1:8000/pindahPangkalan/permohonan-03">{{
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
                                    action="{{ route('pindahPangkalan.permohonan-03.store_tab1') }}">
                                    @csrf --}}

                                    <div class="mb-4">
                                        <h4 class="fw-bold ">Maklumat Peribadi</h4>
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
                                        <h4 class="fw-bold ">Alamat Kediaman</h4>
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
                                        <h4 class="fw-bold ">Alamat Surat-Menyurat</h4>
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
                                    action="{{ route('pindahPangkalan.permohonan-03.store_tab2') }}">
                                    @csrf --}}

                                    <div class="mb-4">
                                        <h4 class="fw-bold ">Maklumat Sebagai Nelayan</h4>
                                        <small class="text-muted">Maklumat berkaitan pengalaman dan aktiviti sebagai
                                            nelayan.</small>
                                        <hr>

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

                                    <div class="mb-4">
                                        <h4 class="fw-bold ">Maklumat Pekerjaan Lain</h4>
                                        <small class="text-muted">Maklumat berkaitan pekerjaan lain yang dilakukan oleh
                                            nelayan.</small>
                                        <hr>

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

                                    <div class="mb-4">
                                        <div class="mb-3">
                                            <h4 class="fw-bold ">Maklumat Kewangan</h4>
                                            <small class="text-muted">Maklumat berkaitan bantuan dan pencen yang
                                                diterima oleh nelayan.</small>
                                            <hr>
                                        </div>

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
                                    action="{{ route('pindahPangkalan.permohonan-03.store_tab3') }}">
                                    @csrf --}}

                                     <form method="POST" id="store_tab3"  enctype="multipart/form-data" action="{{ route('pindahPangkalan.permohonan-03.store_tab3') }}?jenisPindah=dalam">
                            @csrf

                                    <section>

                                        <div class="mb-3">
                                            <h4 class="fw-bold">Maklumat Jeti / Pangkalan Baharu</h4>
                                            <small class="text-muted m-0">Sila pilih daerah dan jeti baharu tempat
                                                nelayan akan beroperasi.</small>
                                            <hr>
                                        </div>

                                        <div class="mt-3">

                                            {{-- <div class="mb-3">
                                                <label for="state_id" class="form-label">Negeri <span
                                                        class="text-danger">*</span></label>
                                                <select id="state_id" name="state_id" class="form-control" readonly>
                                                    <option value="">-- Pilih Negeri --</option>
                                                    @foreach ($states as $id => $name)
                                                    <option value="{{ $id }}" {{ old('state_id', $selectedState ?? ''
                                                        )==$id ? 'selected' : '' }}>
                                                        {{ $name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div> --}}

                                            {{-- <div class="mb-3">
                                                <label for="district_id" class="form-label">Daerah <span
                                                        class="text-danger">*</span></label>
                                                <select id="district_id" name="district_id" class="form-control"
                                                    disabled>
                                                    <option value="">-- Pilih Daerah --</option>
                                                </select>
                                            </div> --}}

                                            <div class="mb-3">
                                                <label for="state_display" class="form-label">Negeri </label>

                                                <!-- Read-only input for display -->
                                                <input type="text" id="state_display" class="form-control"
                                                    value="{{ $jettyOff->state_name?? '-' }}" readonly>

                                                <input type="hidden" name="state_id"
                                                    value="{{ $jettyOff->state->id ?? '' }}">
                                            </div>


                                            <div class="mb-3">
                                                <label for="state_display" class="form-label">Daerah </label>

                                                <!-- Read-only input for display -->
                                                <input type="text" class="form-control"
                                                    value="{{ $jettyOff->district_name?? '-' }}" readonly>

                                                <input type="hidden" name="district_id"
                                                    value="{{ $jettyOff->district->id ?? '' }}">
                                            </div>


                                            {{-- <section hidden>
                                                <!-- Jeti -->
                                                <div class="mb-3">
                                                    <label for="jetty_id" class="form-label">Jeti / Pangkalan Pendaratan
                                                        <span class="text-danger">*</span></label>
                                                    <select id="jetty_id" name="jetty_id" class="form-select" required>
                                                        <option value="">-- Pilih Jeti --</option>
                                                    </select>
                                                </div>

                                                <!-- Sungai -->
                                                <div class="mb-3">
                                                    <label for="river_id" class="form-label">Sungai / Tasik<span
                                                            class="text-danger">*</span></label>
                                                    <select id="river_id" name="river_id" class="form-select" required>
                                                        <option value="">-- Pilih Sungai --</option>
                                                    </select>
                                                </div>
                                            </section> --}}
                                        </div>
                                    </section>

                                    {{-- @push('scripts')
                                    <script>
                                        document.addEventListener("DOMContentLoaded", () => {
                                const stateSelect = document.getElementById('state_id');
                                const districtSelect = document.getElementById('district_id');
                                const jettySelect = document.getElementById('jetty_id');
                                const riverSelect = document.getElementById('river_id');

                                const selectedDistrict = "{{ $selectedDistrict ?? '' }}";
                                const selectedJetty = "{{ $selectedJetty ?? '' }}";
                                const selectedRiver = "{{ $selectedRiver ?? '' }}";

                                function loadDistricts(stateId, selectedId = null) {
                                    fetch(`/pindahPangkalan/permohonan-03/get-districts/${stateId}`)
                                        .then(res => res.json())
                                        .then(data => {
                                            districtSelect.innerHTML = '<option value="">-- Pilih Daerah --</option>';
                                            for (const [id, name] of Object.entries(data)) {
                                                districtSelect.innerHTML += `<option value="${id}" ${selectedId == id ? 'selected' : ''}>${name}</option>`;
                                            }
                                            if (selectedId) {
                                                loadJettyAndRiver(selectedId, selectedJetty, selectedRiver);
                                            }
                                        });
                                }

                                function loadJettyAndRiver(districtId, jettyId = null, riverId = null) {
                                    fetch(`/pindahPangkalan/permohonan-03/get-jetty-river/${districtId}`)
                                        .then(res => res.json())
                                        .then(data => {
                                            jettySelect.innerHTML = '<option value="">-- Pilih Jeti --</option>';
                                            riverSelect.innerHTML = '<option value="">-- Pilih Sungai --</option>';

                                            for (const [id, name] of Object.entries(data.jetty)) {
                                                jettySelect.innerHTML += `<option value="${id}" ${jettyId == id ? 'selected' : ''}>${name}</option>`;
                                            }

                                            for (const [id, name] of Object.entries(data.river)) {
                                                riverSelect.innerHTML += `<option value="${id}" ${riverId == id ? 'selected' : ''}>${name}</option>`;
                                            }
                                        });
                                }

                                // Auto load on page load
                                const initStateId = stateSelect.value;
                                if (initStateId) {
                                    loadDistricts(initStateId, selectedDistrict);
                                }

                                // When user selects new state
                                stateSelect.addEventListener('change', function () {
                                    loadDistricts(this.value);
                                    jettySelect.innerHTML = '<option value="">-- Pilih Jeti --</option>';
                                    riverSelect.innerHTML = '<option value="">-- Pilih Sungai --</option>';
                                });

                                districtSelect.addEventListener('change', function () {
                                    loadJettyAndRiver(this.value);
                                });
                            });
                                    </script>
                                    @endpush --}}

                                    <section>

                                        <!-- Jeti -->
                                        <div class="mb-3">
                                            <label class="form-label">Jeti / Pangkalan Pendaratan <span
                                                    class="text-danger">*</span></label>
                                            <select id="jetty_id" name="jetty_id" class="form-select" required>
                                                <option value="">-- Pilih Jeti --</option>
                                                @foreach ($jettyPre as $id => $name)
                                                <option value="{{ $id }}" {{ ($jettyInfo['jetty_id'] ?? '' )==$id
                                                    ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Sungai -->
                                        <div class="mb-3">
                                            <label for="river_id" class="form-label">Sungai / Tasik <span
                                                    class="text-danger">*</span></label>
                                            <select id="river_id" name="river_id" class="form-select" required>
                                                <option value="">-- Pilih Sungai --</option>
                                                @foreach ($riverPre as $id => $name)
                                                <option value="{{ $id }}" {{ ($jettyInfo['river_id'] ?? '' )==$id
                                                    ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </section>


                                    </section>

                                    <section>
                                        <br>
                                        <div class="mb-3">
                                            <h4 class="fw-bold">Rekod Jeti / Pangkalan</h4>
                                            <small class="text-muted m-0">Maklumat berkaitan lokasi atau kawasan
                                                jeti di
                                                mana nelayan menjalankan
                                                aktiviti
                                                operasi semasa.</small>
                                            <hr>
                                        </div>

                                        <div class="p-2 border rounded">

                                            <table class="table table-borderless">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 5%">Bil</th>
                                                        <th style="width: 10%">Tarikh</th>
                                                        <th>Negeri</th>
                                                        <th>Daerah</th>
                                                        <th>Jeti</th>
                                                        <th>Sungai</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($jettyOffColl as $index => $jetty)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $jetty->created_at ? $jetty->created_at->format('d/m/Y')
                                                            : '-' }}</td>

                                                        <td>{{ $jetty->state_name }}</td>
                                                        <td>{{ $jetty->district_name }}</td>
                                                        <td>{{ $jetty->jetty_name }}</td>
                                                        <td>{{ $jetty->river_name }}</td>

                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center">Tiada rekod dijumpai</td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>

                                        </div>

                                    </section>

                                    {{-- <section>
                                        <div class="mb-3">
                                            <h4 class="fw-bold">Maklumat Jeti / Pangkalan</h4>
                                            <small class="text-muted m-0">Maklumat berkaitan lokasi atau kawasan jeti di
                                                mana nelayan menjalankan
                                                aktiviti
                                                operasi semasa.</small>
                                            <hr>
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
                                                value="{{ $jettyOff->jetty->name ?? 'Tiada Maklumat' }}" readonly>
                                        </div>

                                        <!-- Sungai -->
                                        <div class="mb-3">
                                            <label class="form-label">Sungai</label>
                                            <input type="text" class="form-control"
                                                value="{{ $jettyOff->river->name ?? 'Tiada Maklumat' }}" readonly>
                                        </div>

                                    </section> --}}

                                </form>
                            </div>

                            <div class="tab-pane fade" id="content-tab4" role="tabpanel" aria-labelledby="tab4-link">
                                {{-- <form id="store_tab4" method="POST" enctype="multipart/form-data"
                                    action="{{ route('pindahPangkalan.permohonan-03.store_tab4') }}">
                                    @csrf --}}

                                    <section>
                                        <div class="mb-3">
                                            <h4 class="fw-bold ">Peralatan Menangkap Ikan</h4>
                                            <small class="text-muted">Senarai peralatan yang telah di lesenkan</small>
                                            <hr>
                                        </div>

                                        <div class="p-2 border rounded">
                                            @if ($latestEquipmentGroup && $latestEquipmentGroup->count())
                                            <table class="table table-borderless ">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 5%">Bil.</th>
                                                        <th style="width: 35%">Nama Peralatan</th>
                                                        <th style="width: 10%" class="text-center">Kuantiti</th>
                                                        <th style="width: 15%" class="text-center">Jenis</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($latestEquipmentGroup as $equipment)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $equipment->name }}</td>
                                                        <td class="text-center">{{ $equipment->quantity }}</td>
                                                        <td class="text-center">
                                                            {{ $equipment->type === 'main' ? 'UTAMA' : ($equipment->type
                                                            === 'additional' ? 'TAMBAHAN' : '-') }}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            @else
                                            <p class="p-4 ">Tiada peralatan ditemui untuk permohonan terbaru.</p>
                                            @endif
                                        </div>

                                        <br>
                                    </section>

                                    <section>
                                        <div class="mb-3">
                                            <h4 class="fw-bold ">Rekod Peralatan Menangkap Ikan</h4>
                                            <small class="text-muted">Senarai rekod peralatan yang telah di
                                                lesenkan</small>
                                            <hr>
                                        </div>

                                        @foreach ($equipmentGrouped as $applicationId => $equipmentList)
                                        @php
                                        $createdDate = $equipmentList->sortByDesc('created_at')->first()?->created_at;
                                        @endphp

                                        <div class="p-2 border rounded mb-4">
                                            <small class="mt-2 mb-2 d-block">
                                                <strong>{{ optional($createdDate)->format('d-m-Y') ?? 'Tidak Diketahui'
                                                    }}</strong>
                                            </small>
                                            <table class="table table-borderless align-middle ">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 5%">Bil.</th>
                                                        <th style="width: 35%">Nama Peralatan</th>
                                                        <th style="width: 10%" class="text-center">Kuantiti</th>
                                                        <th style="width: 15%" class="text-center">Jenis</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($equipmentList as $index => $equipment)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $equipment->name }}</td>
                                                        <td class="text-center">{{ $equipment->quantity }}</td>
                                                        <td class="text-center">
                                                            {{ $equipment->type === 'main' ? 'Utama' : 'Tambahan' }}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        @endforeach
                                    </section>

                                    <br>

                                    {{--
                                </form> --}}
                            </div>

                            <div class="tab-pane fade" id="content-tab5" role="tabpanel" aria-labelledby="tab5-link">
                                {{-- <form id="store_tab5" method="POST" enctype="multipart/form-data"
                                    action="{{ route('pindahPangkalan.permohonan-03.store_tab5') }}">
                                    @csrf --}}

                                    <div class="mb-3">
                                        <h4 class="fw-bold ">Maklumat Pemilikan Vesel</h4>
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
                                                <h4 class="fw-bold ">Maklumat Enjin</h4>
                                                <small class="text-muted">Maklumat enjin dipaparkan untuk semakan
                                                    sahaja</small>
                                            </div>

                                            <div class="row">
                                                <div class="col-md mb-3">
                                                    <label for="engine_model" class="form-label">Model Enjin <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="engine_model" id="engine_model"
                                                        class="form-control"
                                                        value="{{ old('model', $vesselInfoOff->engine->model ?? '-') }}"
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
                                    action="{{ route('pindahPangkalan.permohonan-03.store_tab6') }}"
                                    enctype="multipart/form-data">
                                    @csrf

                                 @php
    $suratBaharuIndex = collect($documents)->search(fn($doc) => $doc['title'] === 'Surat Pengesahan Pangkalan Baharu');
    $suratAsalIndex = collect($documents)->search(fn($doc) => $doc['title'] === 'Surat Pengesahan Pangkalan Asal');
    $suratBaharu = $suratBaharuIndex !== false ? $documents[$suratBaharuIndex] : null;
    $suratAsal = $suratAsalIndex !== false ? $documents[$suratAsalIndex] : null;
@endphp

<section>
    <h4 class="fw-bold mb-2">Dokumen Diperlukan</h4>
    <small class="text-muted">
        Sila muat naik kedua-dua dokumen di bawah yang telah ditandatangani oleh pihak berkuasa yang berkenaan.
    </small>
    <hr>

    <div class="alert alert-warning mt-3">
        <strong>Perhatian:</strong> Pastikan kedua-dua dokumen <strong>Surat Pengesahan Pangkalan Baharu</strong> dan
        <strong>Surat Pengesahan Pangkalan Asal</strong> telah ditandatangani sebelum dimuat naik.
    </div>

    <!-- Surat Pengesahan Pangkalan Baharu -->
    <div class="mb-3 mt-3">
        <label for="surat_baharu" class="form-label fw-bold">
            Surat Pengesahan Pangkalan Baharu <span class="text-danger">*</span>
        </label>
        <div class="d-flex gap-2">
            <input class="form-control" type="file" name="surat_baharu" id="surat_baharu" required>
            @if ($suratBaharu)
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#suratBaharuModal">
                    <i class="fa fa-search"></i>
                </button>
            @endif
        </div>
        <small class="text-muted">Format dibenarkan: PDF, JPG, PNG. Saiz maksimum: 2MB.</small>
        @if ($suratBaharu)
            <br><small class="text-success"><strong>Fail berjaya dimuat naik.</strong></small>
        @endif
    </div>

    <!-- Modal for Surat Baharu -->
    @if ($suratBaharu)
        <div class="modal fade" id="suratBaharuModal" tabindex="-1" aria-labelledby="suratBaharuModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="suratBaharuModalLabel">Lampiran: Surat Pangkalan Baharu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body" style="height: 80vh;">
                        <iframe src="{{ route('pindahPangkalan.permohonan-03.viewDocument', ['index' => $suratBaharuIndex]) }}"
                                style="width:100%; height:100%; border:none;"></iframe>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Surat Pengesahan Pangkalan Asal -->
    <div class="mb-3">
        <label for="surat_asal" class="form-label fw-bold">
            Surat Pengesahan Pangkalan Asal <span class="text-danger">*</span>
        </label>
        <div class="d-flex gap-2">
            <input class="form-control" type="file" name="surat_asal" id="surat_asal" required>
            @if ($suratAsal)
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#suratAsalModal">
                    <i class="fa fa-search"></i>
                </button>
            @endif
        </div>
        <small class="text-muted">Format dibenarkan: PDF, JPG, PNG. Saiz maksimum: 2MB.</small>
        @if ($suratAsal)
            <br><small class="text-success"><strong>Fail berjaya dimuat naik.</strong></small>
        @endif
    </div>

    <!-- Modal for Surat Asal -->
    @if ($suratAsal)
        <div class="modal fade" id="suratAsalModal" tabindex="-1" aria-labelledby="suratAsalModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="suratAsalModalLabel">Lampiran: Surat Pangkalan Asal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body" style="height: 80vh;">
                        <iframe src="{{ route('pindahPangkalan.permohonan-03.viewDocument', ['index' => $suratAsalIndex]) }}"
                                style="width:100%; height:100%; border:none;"></iframe>
                    </div>
                </div>
            </div>
        </div>
    @endif
</section>



                                    {{-- <section hidden>

                                        <h4 class="fw-bold ">Dokumen Tambahan (Jika Ada)</h4>
                                        <small class="text-muted">Muat naik dokumen sokongan tambahan (jika ada)</small>

                                        <!-- Additional Documents Section -->
                                        <div id="additional-documents-wrapper">
                                            @php
                                            $oldTitles = old('additional_titles', []);
                                            $hasOld = count($oldTitles) > 0;
                                            $hasExisting = !empty($additionalDocuments);
                                            @endphp

                                            @if ($hasOld)

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
                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#documentModal{{ $index }}"
                                                            title="Lihat Fail">
                                                            <i class="fa fa-search p-1"></i>
                                                        </button>
                                                        @endif
                                                    </div>

                                                    <!-- Modal -->
                                                    @if (!empty($document['file_path']))
                                                    <div class="modal fade" id="documentModal{{ $index }}" tabindex="-1"
                                                        aria-labelledby="documentModalLabel{{ $index }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-xl modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="documentModalLabel{{ $index }}">
                                                                        Paparan Dokumen: {{ $document['title'] ??
                                                                        'Dokumen
                                                                        Tambahan' }}
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Tutup"></button>
                                                                </div>
                                                                <div class="modal-body" style="height: 80vh;">
                                                                    <iframe
                                                                        src="{{ route('pindahPangkalan.permohonan-03.viewDocument', ['type' => 'additional', 'index' => $index]) }}"
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

                                        <div class="text-end">
                                            <button type="button" class="btn btn-primary col-md"
                                                id="add-document-btn">Tambah
                                                Dokumen</button>
                                        </div>
                                    </section> --}}



                            </form>
                        </div>
                        {{-- <script>
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
                        </script> --}}

                        {{-- <div class="card-footer pl-0 pr-0">
                            <div class="d-flex justify-content-end align-items-start flex-wrap">
                                <!-- Left: (Removed Print Button) -->

                                <!-- Right: Navigation Buttons -->
                                <div class="d-flex justify-content-end mb-2 flex-wrap gap-2">
                                    <button id="backTabBtn" type="button" class="btn btn-light"
                                        style="width: 120px;">Kembali</button>

                                    <button id="saveBtn6" type="submit" form="store_tab6" class="btn btn-warning"
                                        style="width: 120px;">Simpan</button>

                                    <button id="saveBtn6" type="submit" form="store_tab3" class="btn btn-warning"
                                        style="width: 120px;">Simpan</button>

                                    <button id="nextTabBtn" type="button" class="btn btn-light"
                                        style="width: 120px;">Seterusnya</button>

                                    <form id="submitPermohonan" method="POST" enctype="multipart/form-data"
                                        action="{{ route('pindahPangkalan.permohonan-03.store') }}">
                                        @csrf
                                    </form>

                                    <button id="submitBtn" type="button" class="btn btn-success"
                                        style="display: none; width: 120px;">Hantar</button>
                                </div>
                            </div>
                        </div> --}}

                        <div class="card-footer pl-0 pr-0">
                            <div class="d-flex justify-content-end align-items-start flex-wrap">
                                <!-- Left: (Removed Print Button) -->

                                <!-- Right: Navigation Buttons -->
                                <div class="d-flex justify-content-end mb-2 flex-wrap gap-2">
                                    <button id="backTabBtn" type="button" class="btn btn-light"
                                        style="width: 120px;">Kembali</button>

                                         <button id="saveBtn3" type="submit" form="store_tab3" class="btn btn-warning"
                                        style="width: 120px;">Simpan</button>

                                    <button id="saveBtn6" type="submit" form="store_tab6" class="btn btn-warning"
                                        style="width: 120px;">Simpan</button>

                                    <button id="nextTabBtn" type="button" class="btn btn-light"
                                        style="width: 120px;">Seterusnya</button>

                                    <form id="submitPermohonan" method="POST" enctype="multipart/form-data"
                                        action="{{ route('pindahPangkalan.permohonan-03.store') }}">
                                        @csrf
                                    </form>

                                    <!-- Trigger Button -->
                                    <button id="submitBtn" type="button" class="btn btn-success"
                                        style="display: none; width: 120px;">Hantar</button>

                                    <!-- Modal Structure -->
                                    <div class="modal fade" id="confirmationModal" tabindex="-1"
                                        aria-labelledby="confirmationModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmationModalLabel">Pengesahan
                                                        Permohonan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Saya dengan ini mengakui dan mengesahkan bahawa semua maklumat
                                                        yang diberikan oleh saya adalah benar. Sekiranya terdapat
                                                        maklumat yang tidak benar, pihak Jabatan boleh menolak
                                                        permohonan saya dan tindakan undang-undang boleh dikenakan ke
                                                        atas saya.</p>
                                                    <div class="form-check mt-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="ackCheckbox">
                                                        <label class="form-check-label" for="ackCheckbox">
                                                            Saya bersetuju dan faham dengan pernyataan di atas
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button id="confirmSubmitBtn" type="button" class="btn btn-primary"
                                                        disabled>Hantar Permohonan</button>
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

    // function confirmSubmission() {
    //     const isTab6Saved = sessionStorage.getItem("tab6_saved") === "true";

    //     if (!isTab6Saved) {
    //         alert("Sila klik simpan sebelum menghantar permohonan.");
    //         changeTab(6); // Switch to tab 6 if not saved
    //         return;
    //     }

    //     const msg = "Saya dengan ini mengakui dan mengesahkan bahawa segala maklumat yang diberikan adalah benar dan tepat. " +
    //                 "Sebarang ketidaktepatan adalah tanggungjawab saya.\n\nAdakah anda pasti untuk menghantar permohonan ini?";
    //     if (confirm(msg)) {
    //         sessionStorage.removeItem("lastSavedTab");
    //         sessionStorage.removeItem("tab6_saved");

    //         document.getElementById('submitPermohonan').submit();
    //     }
    // }

    function confirmSubmission() {
    const isTab6Saved = sessionStorage.getItem("tab6_saved") === "true";

    if (!isTab6Saved) {
        alert("Sila klik simpan sebelum menghantar permohonan.");
        changeTab(6);
        return;
    }

    // Reset modal elements
    document.getElementById("ackCheckbox").checked = false;
    document.getElementById("confirmSubmitBtn").disabled = true;

    // Show the modal
    const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
    modal.show();
}

// Enable the submit button only when checkbox is checked
document.getElementById("ackCheckbox").addEventListener("change", function() {
    document.getElementById("confirmSubmitBtn").disabled = !this.checked;
});

// When confirmed inside modal
document.getElementById("confirmSubmitBtn").addEventListener("click", function() {
    sessionStorage.removeItem("lastSavedTab");
    sessionStorage.removeItem("tab6_saved");

    document.getElementById('submitPermohonan').submit();
});

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
