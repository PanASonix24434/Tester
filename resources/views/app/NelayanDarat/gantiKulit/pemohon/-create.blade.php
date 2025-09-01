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
                                <a href="http://127.0.0.1:8000/gantiKulit/permohonan-06">{{
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
                            <li class="nav-item">
                                <a class="nav-link custom-nav-link" id="tab7-link" aria-disabled="true">Maklumat
                                    Pelupusan</a>
                            </li>
                        </ul>

                    </div>

                    <div class="card-body">

                        <div class="tab-content" id="pills-tabContent">

                            <div class="tab-pane fade show active" id="content-tab1" role="tabpanel"
                                aria-labelledby="tab1-link">
                                {{--
                                <form id="store_tab1" method="POST"
                                    action="{{ route('gantiKulit.permohonan-06.store_tab1') }}">
                                    @csrf --}}

                                    <div class="mb-4">
                                        <h4 class="fw-bold">Maklumat Peribadi</h4>
                                        <small class="text-muted">
                                            Berikut merupakan maklumat peribadi pemohon yang telah direkodkan dalam
                                            sistem.
                                        </small>

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
                                        <h4 class="fw-bold">Alamat Kediaman</h4>
                                        <small class="text-muted">
                                            Alamat kediaman pemohon seperti yang telah direkodkan dalam sistem.
                                        </small>

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
                                        <h4 class="fw-bold">Alamat Surat-Menyurat</h4>
                                        <small class="text-muted">
                                            Alamat untuk tujuan surat-menyurat seperti yang telah direkodkan dalam
                                            sistem.
                                        </small>

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
                                    action="{{ route('gantiKulit.permohonan-06.store_tab2') }}">
                                    @csrf --}}

                                    <div class="mb-4">
                                        <h4 class="fw-bold">Maklumat Sebagai Nelayan</h4>
                                        <small class="text-muted">
                                            Maklumat berikut adalah berkaitan pengalaman dan aktiviti pemohon sebagai
                                            nelayan yang telah direkodkan dalam sistem.
                                        </small>
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
                                        <h4 class="fw-bold">Maklumat Pekerjaan Lain</h4>
                                        <small class="text-muted">
                                            Maklumat berikut menunjukkan pekerjaan lain yang dilakukan oleh pemohon
                                            selain daripada aktiviti sebagai nelayan.
                                        </small>
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
                                            <h4 class="fw-bold">Maklumat Kewangan</h4>
                                            <small class="text-muted">
                                                Maklumat berikut menunjukkan jenis bantuan kewangan dan pencen yang
                                                telah diterima oleh pemohon seperti direkodkan dalam sistem.
                                            </small>
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
                                    action="{{ route('gantiKulit.permohonan-06.store_tab3') }}">
                                    @csrf --}}

                                    <section>
                                        <div class="mb-3">
                                            <h4 class="fw-bold">Maklumat Jeti / Pangkalan Semasa</h4>
                                            <small class="text-muted m-0">
                                                Maklumat berikut menunjukkan lokasi atau kawasan jeti atau pangkalan
                                                semasa tempat pemohon menjalankan aktiviti sebagai nelayan.
                                            </small>
                                            <hr>
                                        </div>

                                        <!-- Negeri -->
                                        <div class="mb-3">
                                            <label class="form-label">Negeri</label>
                                            <input type="text" class="form-control"
                                                value="{{ $jettyOff->state_name ?? 'Tiada Maklumat' }}" readonly>
                                        </div>

                                        <!-- Daerah -->
                                        <div class="mb-3">
                                            <label class="form-label">Daerah</label>
                                            <input type="text" class="form-control"
                                                value="{{ $jettyOff->district_name ?? 'Tiada Maklumat' }}" readonly>
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
                                                value="{{ $jettyOff->river_name ?? 'Tiada Maklumat' }}" readonly>
                                        </div>

                                    </section>

                                    <section>
                                        <br>
                                        <div class="mb-3">
                                            <h4 class="fw-bold">Rekod Jeti / Pangkalan</h4>
                                            <small class="text-muted m-0">
                                                Maklumat berikut merupakan rekod lokasi atau kawasan jeti atau pangkalan
                                                yang telah digunakan oleh pemohon untuk menjalankan aktiviti sebagai
                                                nelayan.
                                            </small>
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
                                                        <td>{{ $jetty->created_at ?
                                                            $jetty->created_at->format('d/m/Y')
                                                            : '-' }}</td>

                                                        <td>{{ $jetty->state_name }}</td>
                                                        <td>{{ $jetty->district_name }}</td>
                                                        <td>{{ $jetty->jetty_name }}</td>
                                                        <td>{{ $jetty->river_name }}</td>

                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center">Tiada rekod dijumpai
                                                        </td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>

                                        </div>

                                    </section>

                                    {{-- <section>
                                        <div class="mb-3">
                                            <h4 class="fw-bold">Maklumat Jeti / Pangkalan</h4>
                                            <small class="text-muted m-0">Maklumat berkaitan lokasi atau kawasan
                                                jeti di
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
                                    action="{{ route('gantiKulit.permohonan-06.store_tab4') }}">
                                    @csrf --}}

                                    <section>
                                        <div class="mb-3">
                                            <h4 class="fw-bold">Maklumat Peralatan Menangkap Ikan Semasa</h4>
                                            <small class="text-muted">
                                                Senarai peralatan menangkap ikan yang sedang digunakan oleh pemohon
                                                seperti yang telah direkodkan dalam sistem.
                                            </small>
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

                                    </section>
                                    <br>
                                    <section>
                                        <div class="mb-3">
                                            <h4 class="fw-bold">Rekod Peralatan Menangkap Ikan</h4>
                                            <small class="text-muted">
                                                Senarai peralatan menangkap ikan yang telah dilesenkan kepada pemohon
                                                seperti yang direkodkan dalam sistem.
                                            </small>
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
                                    action="{{ route('gantiKulit.permohonan-06.store_tab5') }}">
                                    @csrf --}}

                                    <div class="mb-3">
                                        <h4 class="fw-bold">Maklumat Pemilikan Vesel</h4>
                                        <small class="text-muted">
                                            Maklumat berikut merupakan rekod pemilikan vesel oleh pemohon dan dipaparkan
                                            untuk tujuan semakan sahaja.
                                        </small>
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
                                                <h4 class="fw-bold">Maklumat Enjin</h4>
                                                <small class="text-muted">
                                                    Maklumat enjin vesel yang dimiliki oleh pemohon seperti yang telah
                                                    direkodkan dalam sistem. Paparan ini adalah untuk tujuan semakan
                                                    sahaja.
                                                </small>
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

                            {{-- <div class="tab-pane fade" id="content-tab6" role="tabpanel"
                                aria-labelledby="tab6-link">
                                <form method="POST" id="store_tab6"
                                    action="{{ route('gantiKulit.permohonan-06.store_tab6', ['jenisPermohonan' => 'lupus']) }}"
                                    enctype="multipart/form-data">
                                    @csrf

                                    @php
                                    $vesselOldIndex = collect($documents)->search(fn($doc) => $doc['title'] === 'Gambar
                                    Vesel');
                                    $vesselOld = $vesselOldIndex !== false ? $documents[$vesselOldIndex] : null;
                                    @endphp

                                    <section>
                                        <h4 class="fw-bold mb-2">Dokumen Diperlukan</h4>
                                        <small class="text-muted">
                                            Sila muat naik gambar yang diperlukan berkenaan.
                                        </small>
                                        <hr>

                                        <!-- Gambar Vesel -->
                                        <div class="mb-3">
                                            <label for="vesselOld" class="form-label fw-bold">
                                                Gambar Vesel <span class="text-danger">*</span>
                                            </label>
                                            <div class="d-flex gap-2">
                                                <input class="form-control" type="file" name="vesselOld" id="vesselOld"
                                                    required>
                                                @if ($vesselOld)
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#gambarVesel">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                                @endif
                                            </div>
                                            <small class="text-muted">Format dibenarkan: PDF, JPG, PNG. Saiz maksimum:
                                                2MB.</small>
                                            @if ($vesselOld)
                                            <br><small class="text-success"> Fail berjaya dimuat naik. </small>
                                            @endif
                                        </div>

                                        <!-- Modal for Surat Asal -->
                                        @if ($vesselOld)
                                        <div class="modal fade" id="gambarVesel" tabindex="-1"
                                            aria-labelledby="gambarVeselLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="gambarVeselLabel">Lampiran: Surat
                                                            Pangkalan Asal</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Tutup"></button>
                                                    </div>
                                                    <div class="modal-body" style="height: 80vh;">
                                                        <iframe
                                                            src="{{ route('gantiKulit.permohonan-06.viewDocument', ['index' => $vesselOldIndex]) }}"
                                                            style="width:100%; height:100%; border:none;"></iframe>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </section>

                                </form>
                            </div> --}}

                            <div class="tab-pane fade" id="content-tab6" role="tabpanel" aria-labelledby="tab6-link">
                                <form method="POST" id="store_tab6"
                                    action="{{ route('gantiKulit.permohonan-06.store_tab6') }}"
                                    enctype="multipart/form-data">
                                    @csrf

                                    {{-- Hidden input to send jenisPermohonan --}}
                                    <input type="hidden" name="jenisPermohonan" value="lupus">

                                    @php
                                    $vesselOldIndex = collect($documents)->search(fn($doc) => $doc['title'] === 'Gambar
                                    Vesel Asal');
                                    $vesselOld = $vesselOldIndex !== false ? $documents[$vesselOldIndex] : null;
                                    @endphp

                                    <section>
                                        <h4 class="fw-bold mb-2">Muat Naik Dokumen</h4>
                                        <small class="text-muted">
                                            Sila muat naik dokumen sokongan yang berkaitan bagi tujuan semakan dan
                                            pengesahan permohonan.
                                        </small>
                                        <hr>

                                        <!-- Gambar Vesel Asal -->
                                        <div class="mb-3">
                                            <label for="vesselOld" class="form-label fw-bold">
                                                Gambar Vesel Asal <span class="text-danger">*</span>
                                            </label>
                                            <div class="d-flex gap-2">
                                                <input class="form-control" type="file" name="vesselOld" id="vesselOld"
                                                    required>
                                                @if ($vesselOld)
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#gambarVeselAsal">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                                @endif
                                            </div>
                                            <small class="text-muted">Format dibenarkan: PDF, JPG, PNG. Saiz maksimum:
                                                2MB.</small>
                                            @if ($vesselOld)
                                            <br><small class="text-success"> Fail berjaya dimuat naik. </small>
                                            @endif
                                        </div>

                                        <!-- Modal Preview for Gambar Vesel Asal -->
                                        @if ($vesselOld)
                                        <div class="modal fade" id="gambarVeselAsal" tabindex="-1"
                                            aria-labelledby="gambarVeselAsalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="gambarVeselAsalLabel">Lampiran:
                                                            Gambar Vesel Asal</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Tutup"></button>
                                                    </div>
                                                    <div class="modal-body" style="height: 80vh;">
                                                        <iframe
                                                            src="{{ route('gantiKulit.permohonan-06.viewDocument', ['index' => $vesselOldIndex]) }}"
                                                            style="width:100%; height:100%; border:none;"></iframe>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </section>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="content-tab7" role="tabpanel" aria-labelledby="tab7-link">
                                <form method="POST" id="store_tab7"
                                    action="{{ route('gantiKulit.permohonan-06.store_tab7') }}"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <section>
                                        <h4 class="fw-bold mb-2">Maklumat Pelupusan Vesel</h4>
                                        <small class="text-muted">
                                            Sila isi maklumat yang diperlukan bagi tujuan pelupusan vesel.
                                        </small>

                                        <hr>
                                        <label class="mb-3 d-block">
                                            Sila pilih sama ada anda ingin menjual vesel ini kepada pemilik baharu atau
                                            melupuskan (menamatkan lesen) vesel tersebut.
                                        </label>

                                        <!-- Main Disposal Choice -->
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="main_disposal_action" id="action_jual" value="jual" {{
                                                        old('main_disposal_action', $dispose['main_disposal_action']
                                                        ?? '' )==='jual' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="action_jual">Jual Vesel</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="main_disposal_action" id="action_lupus" value="lupus" {{
                                                        old('main_disposal_action', $dispose['main_disposal_action']
                                                        ?? '' )==='lupus' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="action_lupus">Lupus & Tamat
                                                        Lesen</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="jualFields" style="display: none;">
                                            <h5 class="fw-bold mb-2">Jenis Jualan</h5>
                                            <label class="d-block mb-3">
                                                Sila pilih sama ada jualan dibuat dalam industri atau luar industri.
                                            </label>

                                            <div class="row mb-4">
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="disposal_type" id="jual_dalam" value="dalam_industri"
                                                            {{ old('disposal_type', $dispose['disposal_type'] ?? ''
                                                            )==='dalam_industri' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="jual_dalam">Jualan Dalam
                                                            Industri</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="disposal_type" id="jual_luar" value="luar_industri" {{
                                                            old('disposal_type', $dispose['disposal_type'] ?? ''
                                                            )==='luar_industri' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="jual_luar">Jualan Luar
                                                            Industri</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <h5 class="fw-bold mb-2">Maklumat Pemilik Baharu</h5>
                                            <small class="text-muted d-block mb-3">Sila isikan maklumat pemilik baharu
                                                vesel ini.</small>

                                            <div class="mb-3">
                                                <label class="form-label">Nama Pemilik Baharu</label>
                                                <input type="text" name="new_owner_name" class="form-control"
                                                    value="{{ old('new_owner_name', $dispose['new_owner_name'] ?? '') }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">No. Telefon Pemilik Baharu</label>
                                                <input type="text" name="new_owner_phone" class="form-control"
                                                    value="{{ old('new_owner_phone', $dispose['new_owner_phone'] ?? '') }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">No. Kad Pengenalan Pemilik Baharu</label>
                                                <input type="text" name="new_owner_ic" class="form-control"
                                                    value="{{ old('new_owner_ic', $dispose['new_owner_ic'] ?? '') }}">
                                            </div>
                                        </div>
                                    </section>

                                    @push('scripts')
                                    <script>
                                        function toggleJualFields() {
        const action = document.querySelector('input[name="main_disposal_action"]:checked');
        if (action && action.value === 'jual') {
            $('#jualFields').slideDown();
        } else {
            $('#jualFields').slideUp();
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        toggleJualFields();
        document.querySelectorAll('input[name="main_disposal_action"]').forEach(input => {
            input.addEventListener('change', toggleJualFields);
        });
    });
                                    </script>

                                    @endpush

                                    <br>

                                </form>
                            </div>

                            <div class="card-footer pl-0 pr-0">
                                <div class="d-flex justify-content-end align-items-start flex-wrap">
                                    <!-- Left: (Removed Print Button) -->

                                    <!-- Right: Navigation Buttons -->
                                    <div class="d-flex justify-content-end mb-2 flex-wrap gap-2">
                                        <button id="backTabBtn" type="button" class="btn btn-light"
                                            style="width: 120px;">Kembali</button>

                                        <button id="saveBtn6" type="submit" form="store_tab6" class="btn btn-warning"
                                            style="width: 120px;">Simpan</button>

                                        <button id="saveBtn7" type="submit" form="store_tab7" class="btn btn-warning"
                                            style="width: 120px;">Simpan</button>

                                        <button id="nextTabBtn" type="button" class="btn btn-light"
                                            style="width: 120px;">Seterusnya</button>

                                        <form id="submitPermohonan" method="POST" enctype="multipart/form-data"
                                            action="{{ route('gantiKulit.permohonan-06.store') }}">
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
                                                        <p>Saya dengan ini mengakui dan mengesahkan bahawa semua
                                                            maklumat
                                                            yang diberikan oleh saya adalah benar. Sekiranya terdapat
                                                            maklumat yang tidak benar, pihak Jabatan boleh menolak
                                                            permohonan saya dan tindakan undang-undang boleh dikenakan
                                                            ke
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
                                                        <button id="confirmSubmitBtn" type="button"
                                                            class="btn btn-primary" disabled>Hantar Permohonan</button>
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
    const totalTabs = 7;

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
                    if (i === 7) {
                        sessionStorage.setItem(`tab7_saved`, 'true');
                    }
                    sessionStorage.setItem("lastSavedTab", i);
                };
            }
        }

        document.getElementById("submitBtn").onclick = confirmSubmission;

        document.getElementById("nextTabBtn").onclick = () => {
            if (currentTab < totalTabs) {
                changeTab(currentTab + 1);
            }
        };

        document.getElementById("backTabBtn").onclick = () => {
            if (currentTab > 1) {
                changeTab(currentTab - 1);
            }
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
        const isTab7Saved = sessionStorage.getItem("tab7_saved") === "true";

        if (!isTab7Saved) {
            alert("Sila klik simpan sebelum menghantar permohonan.");
            changeTab(7); // Go to tab 7
            return;
        }

        // Reset modal UI
        document.getElementById("ackCheckbox").checked = false;
        document.getElementById("confirmSubmitBtn").disabled = true;

        const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
        modal.show();
    }

    document.getElementById("ackCheckbox").addEventListener("change", function () {
        document.getElementById("confirmSubmitBtn").disabled = !this.checked;
    });

    document.getElementById("confirmSubmitBtn").addEventListener("click", function () {
        sessionStorage.removeItem("lastSavedTab");
        sessionStorage.removeItem("tab7_saved");

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
