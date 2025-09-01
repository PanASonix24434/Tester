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
                        <small>{{$moduleName->name}} - {{$roleName}}</small>
                    </div>

                </div>
                <div class="col-md-3 align-content-center">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="d-flex   justify-content-end">
                        <ol class="breadcrumb text-center">
                            <li class="breadcrumb-item">
                                <a href="http://127.0.0.1:8000/lesenTahunan/permohonan-02">{{
                                    \Illuminate\Support\Str::ucfirst(strtolower($applicationType->name)) }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{$moduleName->name}}</a></li>
                            {{-- <li class="breadcrumb-item active" aria-current="page">Permohonan</a></li> --}}

                        </ol>
                    </nav>

            </div>
            <div>
                <div class="card">
                    <div class="card-header bg-danger text-white">

                    </div>
                    <form id="submitPermohonan" method="POST" enctype="multipart/form-data" action="{{ route('lesenTahunan.permohonan-02.storeAppeal') }}">
                        @csrf

                        <div class="card-body ">
                            {{-- 🧾 Application Info --}}
                            <div class="row mb-4">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                            <tr>
                                                <td class="col-md-4">Nama Pemohon</td>
                                                <td class="col-md-1">:</td>
                                                <td>
                                                    <input type="text" class="form-control" value="{{ $application->user->name ?? 'Tidak Diketahui' }}" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>No. Kad Pengenalan</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" class="form-control" value="{{ $application->user->username ?? 'Tidak Diketahui' }}" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Pangkalan</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" class="form-control" value="{{ $jettyInfo->jetty_name ?? 'Tidak Diketahui' }}" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>No. Pendaftaran Vesel</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" class="form-control" value="{{ $vessel->vessel_registration_number ?? 'Tiada Vesel' }}" readonly>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                            <tr>
                                                <td class="col-md-4">Jenis Permohonan</td>
                                                <td class="col-md-1">:</td>
                                                <td>
                                                    <input type="text" class="form-control" value="{{ $application->applicationType->name_ms ?? 'Tidak Diketahui' }}" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>No. Rujukan</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" class="form-control" value="{{ $application->no_rujukan ?? 'Tidak Diketahui' }}" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tarikh Permohonan</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" class="form-control" value="{{ $application->created_at?->format('d-m-Y') ?? 'Tidak Diketahui' }}" readonly>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- 🔴 Maklum Balas Negatif --}}
                            <hr>

                            @forelse ($applicationLogs as $log)
                            <div class="mb-4 ">
                                <div class="alert alert-danger">
                                    <strong>Ulasan</strong>

                                    <br>
                                    {{ $log->remarks ?? '-' }}
                                </div>
                            </div>
                            @if (!$loop->last)
                            <hr>
                            @endif
                            @empty
                            <p class="text-muted mb-0">Tiada maklum balas direkodkan untuk permohonan ini.</p>
                            @endforelse
                            <strong>Beri Kenyataan</strong>
                            <textarea name="user_statement" id="user_statement" class="form-control" rows="5" required placeholder="Contoh: Saya telah mengemaskini maklumat vesel seperti yang diminta."></textarea>
                        </div>

                </div>
                </form>
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

                    <div class="card-body ">

                        <div class="tab-content " id="pills-tabContent">

                            <div class="tab-pane fade show active" id="content-tab1" role="tabpanel" aria-labelledby="tab1-link">
                                <form id="store_tab1" method="POST" action="{{ route('lesenTahunan.permohonan-02.store_tab1') }}">
                                    @csrf

                                    <div class="mb-4">
                                        <h4 class="fw-bold mb-0">Maklumat Peribadi</h4>
                                        <small class="text-muted">Maklumat ini telah disimpan dan tidak boleh diubah</small>
                                        <div class="row mt-3">
                                            <div class="col-md-6 mb-3">
                                                <label for="name" class="form-label">Nama</label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $userDetail->name ?? '') }}" readonly>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="no_phone" class="form-label">Nombor Telefon</label>
                                                <input type="text" class="form-control" id="no_phone" name="no_phone" value="{{ old('no_phone', $userDetail->no_phone ?? '') }}" readonly>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="icno" class="form-label">Nombor Kad Pengenalan</label>
                                                <input type="text" class="form-control" id="icno" name="icno" value="{{ old('icno', $userDetail->icno ?? '') }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <hr>

                                    <div class="mb-4">
                                        <h4 class="fw-bold mb-0">Alamat Surat-Menyurat</h4>
                                        <small class="text-muted">Maklumat ini telah disimpan dan tidak boleh diubah</small>
                                        <div class="row mt-3">
                                            <div class="col-md mb-3">
                                                <label for="address" class="form-label">Alamat</label>
                                                <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $userDetail->address ?? '') }}" readonly>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="poskod" class="form-label">Poskod</label>
                                                <input type="text" class="form-control" id="poskod" name="poskod" value="{{ old('poskod', $userDetail->poskod ?? '') }}" readonly>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="district" class="form-label">Daerah</label>
                                                <input type="text" class="form-control" id="district" name="district" value="{{ old('district', $userDetail->district ?? '') }}" readonly>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="state" class="form-label">Negeri</label>
                                                <input type="text" class="form-control" id="state" name="state" value="{{ old('state', $userDetail->state ?? '') }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="content-tab2" role="tabpanel" aria-labelledby="tab1-link">
                                <form id="store_tab2" method="POST" action="{{ route('lesenTahunan.permohonan-02.store_tab2') }}">
                                    @csrf

                                    <div class="mb-4">
                                        <h4 class="fw-bold mb-0">Maklumat Sebagai Nelayan</h4>
                                        <small class="text-muted">Maklumat ini telah disimpan dan tidak boleh diubah</small>

                                        <div class="row mt-3">
                                            <div class="col-md-6 mb-3">
                                                <label for="year_become_fisherman" class="form-label">Tahun Menjadi Nelayan</label>
                                                <input type="number" class="form-control" id="year_become_fisherman" name="year_become_fisherman" value="{{ old('year_become_fisherman', $fishermanInfo->year_become_fisherman ?? '') }}" readonly>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="becoming_fisherman_duration" class="form-label">Tempoh Menjadi Nelayan (Tahun)</label>
                                                <input type="number" class="form-control" id="becoming_fisherman_duration" name="becoming_fisherman_duration" value="{{ old('becoming_fisherman_duration', $fishermanInfo->becoming_fisherman_duration ?? '') }}" readonly>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="working_days_fishing_per_month" class="form-label">Hari Bekerja Menangkap Ikan Sebulan</label>
                                                <input type="number" class="form-control" id="working_days_fishing_per_month" name="working_days_fishing_per_month" value="{{ old('working_days_fishing_per_month', $fishermanInfo->working_days_fishing_per_month ?? '') }}" readonly>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="estimated_income_yearly_fishing" class="form-label">Pendapatan Tahunan Dari Menangkap Ikan</label>
                                                <input type="number" class="form-control" id="estimated_income_yearly_fishing" name="estimated_income_yearly_fishing" value="{{ old('estimated_income_yearly_fishing', $fishermanInfo->estimated_income_yearly_fishing ?? '') }}" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <hr>

                                    <div class="mb-4">
                                        <h4 class="fw-bold mb-0">Maklumat Pekerjaan Lain</h4>
                                        <small class="text-muted">Maklumat ini telah disimpan dan tidak boleh diubah</small>

                                        <div class="row mt-3">
                                            <div class="col-md-6 mb-3">
                                                <label for="estimated_income_other_job" class="form-label">Pendapatan Dari Pekerjaan Lain</label>
                                                <input type="number" class="form-control" id="estimated_income_other_job" name="estimated_income_other_job" value="{{ old('estimated_income_other_job', $fishermanInfo->estimated_income_other_job ?? '') }}" readonly>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="days_working_other_job_per_month" class="form-label">Hari Bekerja Di Pekerjaan Lain Sebulan</label>
                                                <input type="number" class="form-control" id="days_working_other_job_per_month" name="days_working_other_job_per_month" value="{{ old('days_working_other_job_per_month', $fishermanInfo->days_working_other_job_per_month ?? '') }}" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <hr>

                                    <div class="mb-4">
                                        <h4 class="fw-bold mb-0">Maklumat Kewangan</h4>
                                        <small class="text-muted">Maklumat ini telah disimpan dan tidak boleh diubah</small>

                                        <div class="row mt-3">
                                            <div class="col-md-6 mb-3">
                                                <label for="receive_pension" class="form-label">Menerima Pencen</label>
                                                <select class="form-select" id="receive_pension" name="receive_pension" disabled>
                                                    <option value="1" {{ old('receive_pension', $fishermanInfo->receive_pension ?? '') == 1 ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('receive_pension', $fishermanInfo->receive_pension ?? '') == 0 ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="receive_financial_aid" class="form-label">Menerima Bantuan Kewangan</label>
                                                <select class="form-select" id="receive_financial_aid" name="receive_financial_aid" disabled>
                                                    <option value="1" {{ old('receive_financial_aid', $fishermanInfo->receive_financial_aid ?? '') == 1 ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('receive_financial_aid', $fishermanInfo->receive_financial_aid ?? '') == 0 ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="financial_aid_agency" class="form-label">Agensi Memberi Bantuan Kewangan</label>
                                                <input type="text" class="form-control" id="financial_aid_agency" name="financial_aid_agency" value="{{ old('financial_aid_agency', $fishermanInfo->financial_aid_agency ?? '') }}" readonly>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="epf_contributor" class="form-label">Pencarum KWSP</label>
                                                <select class="form-select" id="epf_contributor" name="epf_contributor" disabled>
                                                    <option value="1" {{ old('epf_contributor', $fishermanInfo->epf_contributor ?? '') == 1 ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('epf_contributor', $fishermanInfo->epf_contributor ?? '') == 0 ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const receiveFinancialAid = document.getElementById('receive_financial_aid');
                                    const financialAidAgencyDiv = document.getElementById('financial_aid_agency_div');

                                    function toggleAgencyInput() {
                                        if (receiveFinancialAid.value === '0') {
                                            financialAidAgencyDiv.style.display = 'none';
                                        } else {
                                            financialAidAgencyDiv.style.display = 'block';
                                        }
                                    }

                                    toggleAgencyInput();
                                    receiveFinancialAid.addEventListener('change', toggleAgencyInput);
                                });

                            </script>

                            <div class="tab-pane fade" id="content-tab3" role="tabpanel" aria-labelledby="tab3-link">
                                <form id="store_tab3" method="POST" enctype="multipart/form-data" action="{{ route('lesenTahunan.permohonan-02.store_tab3') }}">
                                    @csrf

                                    <div class="mb-4">
                                        <h4 class="fw-bold mb-0">Maklumat Jeti / Pangkalan</h4>
                                        <small class="text-muted">Maklumat ini telah disimpan dan tidak boleh diubah</small>

                                        <div class="row mt-3">
                                            <div class="col-md-6 mb-3">
                                                <label for="state" class="form-label">Negeri</label>
                                                <input type="text" class="form-control" id="state" name="state" value="{{ old('state', $jettyInfo->state ?? '') }}" readonly>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="district" class="form-label">Daerah</label>
                                                <input type="text" class="form-control" id="district" name="district" value="{{ old('district', $jettyInfo->district ?? '') }}" readonly>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="jetty_name" class="form-label">Nama Jeti / Pangkalan</label>
                                                <input type="text" class="form-control" id="jetty_name" name="jetty_name" value="{{ old('jetty_name', $jettyInfo->jetty_name ?? '') }}" readonly>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="river" class="form-label">Sungai</label>
                                                <input type="text" class="form-control" id="river" name="river" value="{{ old('river', $jettyInfo->river ?? '') }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="content-tab4" role="tabpanel" aria-labelledby="tab4-link">
                                <form id="store_tab4" method="POST" enctype="multipart/form-data" action="{{ route('lesenTahunan.permohonan-02.store_tab4') }}">
                                    @csrf

                                    <div class="mb-5">
                                        <div class="mb-3">
                                            <h4 class="fw-bold mb-0">Peralatan Utama</h4>
                                            <small class="text-muted">Maklumat peralatan utama yang digunakan</small>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-8 mb-3">
                                                <input type="text" name="main[name]" id="main_name" class="form-control" placeholder="Masukkan Peralatan" value="{{ old('main.name', $mainEquipment->name ?? '') }}" readonly>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <input type="number" name="main[quantity]" id="main_quantity" class="form-control" placeholder="Masukkan Kuantiti" min="1" value="{{ old('main.quantity', $mainEquipment->quantity ?? '') }}" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <hr>

                                    <div class="mb-5">
                                        <div class="mb-3">
                                            <h4 class="fw-bold mb-0">Peralatan Tambahan</h4>
                                            <small class="text-muted">Senaraikan peralatan tambahan (maksimum 5)</small>
                                        </div>

                                        @for($i = 0; $i < 5; $i++)
                                            @php $additional = $additionalEquipments[$i] ?? null; @endphp
                                            <div class="mb-3">
                                                <label class="form-label">Peralatan {{ $i + 1 }}</label>
                                                <div class="row">
                                                    <div class="col-md-8 mb-3">
                                                        <input type="text" name="additional[{{ $i }}][name]" class="form-control" placeholder="Masukkan Peralatan"
                                                            value="{{ old("additional.$i.name", $additional->name ?? '') }}" readonly>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <input type="number" name="additional[{{ $i }}][quantity]" class="form-control" placeholder="Masukkan Kuantiti"
                                                            min="1" value="{{ old("additional.$i.quantity", $additional->quantity ?? '') }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                    </div>

                                    <br>
                                    <hr>

                                    <div class="mb-4">
                                        <div class="mb-3">
                                            <h4 class="fw-bold mb-0">Gambar Peralatan</h4>
                                            <small class="text-muted">Muat naik satu gambar mewakili semua peralatan</small>
                                        </div>

                                        <div class="mb-3">
                                            <label for="photo" class="form-label">Kemaskini / Muat Naik Gambar Baru</label>
                                            <div class="d-flex align-items-center gap-2">
                                                <!-- Disabled file input (prevent reupload) -->
                                                <input type="file" name="photo" id="photo" accept="image/*" class="form-control" disabled>

                                                <!-- Preview button with icon -->
                                                @if(!empty($equipmentSet->photo))
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#photoPreviewModal">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    @if(!empty($equipmentSet->photo))
                                    <div class="modal fade" id="photoPreviewModal" tabindex="-1" aria-labelledby="photoPreviewModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-xl">
                                            <div class="modal-content p-3">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="photoPreviewModalLabel">Gambar Peralatan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img src="{{ route('lesenTahunan.permohonan-02.viewEquipmentPhoto', $equipmentSet->id) }}" alt="Gambar Peralatan" class="img-fluid rounded" style="max-height: 80vh;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                </form>
                            </div>

                        <div class="tab-pane fade" id="content-tab5" role="tabpanel" aria-labelledby="tab5-link">
                            <form id="store_tab5" method="POST" enctype="multipart/form-data" action="{{ route('lesenTahunan.permohonan-02.store_tab5') }}">
                                @csrf

                                <div class="mb-4">
                                    <h4 class="fw-bold mb-0">Pemilikan Vesel</h4>
                                    <small class="text-muted">Sila nyatakan sama ada anda memiliki vesel atau tidak</small>
                                    <div class="row mt-3">
                                        <div class="col-md">
                                            <select name="own_vessel" id="own_vessel" class="form-select" disabled>
                                                <option value="">Sila Pilih</option>
                                                <option value="1" {{ old('own_vessel', (string) ($vessel->own_vessel ?? '')) === '1' ? 'selected' : '' }}>ADA</option>
                                                <option value="0" {{ old('own_vessel', (string) ($vessel->own_vessel ?? '')) === '0' ? 'selected' : '' }}>TIADA</option>
                                            </select>
                                            <input type="hidden" name="own_vessel" value="{{ old('own_vessel', $vessel->own_vessel ?? '') }}">
                                        </div>
                                    </div>
                                </div>

                                <br>

                                <div id="vessel-info-section">
                                    <hr>
                                    <h4 class="fw-bold mb-0">Maklumat Vesel</h4>
                                    <small class="text-muted">Maklumat asas vesel yang dimiliki</small>

                                    <div class="row mt-3">
                                        <div class="col-md-6 mb-3">
                                            <label for="vessel_registration_number" class="form-label">No. Pendaftaran Vesel</label>
                                            <input type="text" readonly name="vessel_registration_number" id="vessel_registration_number" class="form-control"
                                                value="{{ old('vessel_registration_number', $vessel->vessel_registration_number ?? '') }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="hull_type" class="form-label">Jenis Kulit Vesel</label>
                                            <input type="text" readonly name="hull_type" id="hull_type" class="form-control"
                                                value="{{ old('hull_type', $hull->hull_type ?? '') }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="length" class="form-label">Panjang (m)</label>
                                            <input type="number" readonly step="0.01" name="length" id="length" class="form-control"
                                                value="{{ old('length', $hull->length ?? '') }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="width" class="form-label">Lebar (m)</label>
                                            <input type="number" readonly step="0.01" name="width" id="width" class="form-control"
                                                value="{{ old('width', $hull->width ?? '') }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="depth" class="form-label">Kedalaman (m)</label>
                                            <input type="number" readonly step="0.01" name="depth" id="depth" class="form-control"
                                                value="{{ old('depth', $hull->depth ?? '') }}">
                                        </div>
                                    </div>

                                    <br>
                                    <hr>

                                    <h4 class="fw-bold mb-0">Maklumat Enjin</h4>
                                    <small class="text-muted">Spesifikasi enjin utama vesel</small>
                                    <div class="row mt-3">
                                        <div class="col-md-6 mb-3">
                                            <label for="engine_model" class="form-label">Model Enjin</label>
                                            <input type="text" readonly name="engine_model" id="engine_model" class="form-control"
                                                value="{{ old('engine_model', $engine->engine_model ?? '') }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="engine_brand" class="form-label">Jenama Enjin</label>
                                            <input type="text" readonly name="engine_brand" id="engine_brand" class="form-control"
                                                value="{{ old('engine_brand', $engine->engine_brand ?? '') }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="horsepower" class="form-label">Kuasa Kuda (KK)</label>
                                            <input type="number" readonly name="horsepower" id="horsepower" class="form-control"
                                                value="{{ old('horsepower', $engine->horsepower ?? '') }}">
                                        </div>
                                    </div>
                                </div>

                                <div id="transportation-section">
                                    <hr>
                                    <h4 class="fw-bold mb-0">Maklumat Pengangkutan</h4>
                                    <small class="text-muted">Jenis pengangkutan yang digunakan jika tiada vesel</small>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label for="transportation_only" class="form-label">Jenis Pengangkutan</label>
                                            <input type="text" readonly name="transportation_only" id="transportation_only" class="form-control"
                                                value="{{ old('transportation_only', $vessel->transportation ?? '') }}">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        @push('scripts')
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const ownVessel = document.getElementById('own_vessel');
                                const vesselSection = document.getElementById('vessel-info-section');
                                const transportSection = document.getElementById('transportation-section');

                                function setDisabled(section, disabled) {
                                    const inputs = section.querySelectorAll('input, select, textarea');
                                    inputs.forEach(input => input.disabled = disabled);
                                }

                                function toggleSections(value) {
                                    if (value === '1') {
                                        vesselSection.style.display = 'block';
                                        transportSection.style.display = 'none';
                                        setDisabled(vesselSection, false);
                                        setDisabled(transportSection, true);
                                    } else if (value === '0') {
                                        vesselSection.style.display = 'none';
                                        transportSection.style.display = 'block';
                                        setDisabled(vesselSection, true);
                                        setDisabled(transportSection, false);
                                    } else {
                                        vesselSection.style.display = 'none';
                                        transportSection.style.display = 'none';
                                        setDisabled(vesselSection, true);
                                        setDisabled(transportSection, true);
                                    }
                                }

                                ownVessel.addEventListener('change', function () {
                                    toggleSections(this.value);
                                });

                                toggleSections(ownVessel.value); // initial toggle
                            });
                        </script>
                        @endpush

                        <div class="tab-pane fade" id="content-tab5" role="tabpanel" aria-labelledby="tab5-link">
                            <form id="store_tab5" method="POST" enctype="multipart/form-data" action="{{ route('lesenTahunan.permohonan-02.store_tab5') }}">
                                @csrf

                                <div class="mb-4">
                                    <h4 class="fw-bold mb-0">Pemilikan Vesel</h4>
                                    <small class="text-muted">Sila nyatakan sama ada anda memiliki vesel atau tidak</small>
                                    <div class="row mt-3">
                                        <div class="col-md">
                                            <select name="own_vessel" id="own_vessel" class="form-select" required>
                                                <option value="">Sila Pilih</option>
                                                <option value="1" {{ old('own_vessel', (string) ($vessel->own_vessel ?? '')) === '1' ? 'selected' : '' }}>ADA</option>
                                                <option value="0" {{ old('own_vessel', (string) ($vessel->own_vessel ?? '')) === '0' ? 'selected' : '' }}>TIADA</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <br>

                                <div id="vessel-info-section" style="display: none;">
                                    <hr>
                                    <h4 class="fw-bold mb-0">Maklumat Vesel</h4>
                                    <small class="text-muted">Maklumat asas vesel yang dimiliki</small>

                                    <div class="row mt-3">
                                        <div class="col-md-6 mb-3">
                                            <label for="vessel_registration_number" class="form-label">No. Pendaftaran Vesel</label>
                                            <input type="text" name="vessel_registration_number" id="vessel_registration_number" class="form-control"
                                                value="{{ old('vessel_registration_number', $vessel->vessel_registration_number ?? '') }}" placeholder="Masukkan No. Pendaftaran Vesel">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="hull_type" class="form-label">Jenis Kulit Vesel</label>
                                            <input type="text" name="hull_type" id="hull_type" class="form-control"
                                                value="{{ old('hull_type', $hull->hull_type ?? '') }}" placeholder="Masukkan Jenis Kulit Vesel">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="length" class="form-label">Panjang (m)</label>
                                            <input type="number" step="0.01" name="length" id="length" class="form-control"
                                                value="{{ old('length', $hull->length ?? '') }}" placeholder="Masukkan Panjang Vesel">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="width" class="form-label">Lebar (m)</label>
                                            <input type="number" step="0.01" name="width" id="width" class="form-control"
                                                value="{{ old('width', $hull->width ?? '') }}" placeholder="Masukkan Lebar Vesel">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="depth" class="form-label">Kedalaman (m)</label>
                                            <input type="number" step="0.01" name="depth" id="depth" class="form-control"
                                                value="{{ old('depth', $hull->depth ?? '') }}" placeholder="Masukkan Kedalaman Vesel">
                                        </div>
                                    </div>

                                    <br>
                                    <hr>

                                    <h4 class="fw-bold mb-0">Maklumat Enjin</h4>
                                    <small class="text-muted">Spesifikasi enjin utama vesel</small>
                                    <div class="row mt-3">
                                        <div class="col-md-6 mb-3">
                                            <label for="engine_model" class="form-label">Model Enjin</label>
                                            <input type="text" name="engine_model" id="engine_model" class="form-control"
                                                value="{{ old('engine_model', $engine->engine_model ?? '') }}" placeholder="Masukkan Model Enjin">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="engine_brand" class="form-label">Jenama Enjin</label>
                                            <input type="text" name="engine_brand" id="engine_brand" class="form-control"
                                                value="{{ old('engine_brand', $engine->engine_brand ?? '') }}" placeholder="Masukkan Jenama Enjin">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="horsepower" class="form-label">Kuasa Kuda (KK)</label>
                                            <input type="number" name="horsepower" id="horsepower" class="form-control"
                                                value="{{ old('horsepower', $engine->horsepower ?? '') }}" placeholder="Masukkan Kuasa Kuda">
                                        </div>
                                    </div>
                                </div>

                                <div id="transportation-section" style="display: none;">
                                    <hr>
                                    <h4 class="fw-bold mb-0">Maklumat Pengangkutan</h4>
                                    <small class="text-muted">Jenis pengangkutan yang digunakan jika tiada vesel</small>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label for="transportation_only" class="form-label">Jenis Pengangkutan</label>
                                            <input type="text" name="transportation_only" id="transportation_only" class="form-control"
                                                value="{{ old('transportation_only', $vessel->transportation ?? '') }}" placeholder="Masukkan Jenis Pengangkutan">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        @push('scripts')
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const ownVessel = document.getElementById('own_vessel');
                                const vesselSection = document.getElementById('vessel-info-section');
                                const transportSection = document.getElementById('transportation-section');

                                function setDisabled(section, disabled) {
                                    const inputs = section.querySelectorAll('input, select, textarea');
                                    inputs.forEach(input => input.disabled = disabled);
                                }

                                function toggleSections(value) {
                                    if (value === '1') {
                                        vesselSection.style.display = 'block';
                                        transportSection.style.display = 'none';
                                        setDisabled(vesselSection, false);
                                        setDisabled(transportSection, true);
                                    } else if (value === '0') {
                                        vesselSection.style.display = 'none';
                                        transportSection.style.display = 'block';
                                        setDisabled(vesselSection, true);
                                        setDisabled(transportSection, false);
                                    } else {
                                        vesselSection.style.display = 'none';
                                        transportSection.style.display = 'none';
                                        setDisabled(vesselSection, true);
                                        setDisabled(transportSection, true);
                                    }
                                }

                                ownVessel.addEventListener('change', function () {
                                    toggleSections(this.value);
                                });

                                toggleSections(ownVessel.value); // initial toggle
                            });
                        </script>
                        @endpush

                    <div class="card-footer pr-0">
                        <input type="hidden" name="current_tab" id="currentTabInput" value="1">
                        <div class="d-flex justify-content-end gap-2">
                            <button id="backTabBtn" type="button" class="btn btn-light" style="width: 120px">Kembali</button>
                            <button id="nextTabBtn" type="button" class="btn btn-light" style="width: 120px">Seterusnya</button>

                            <!-- Simpan Button -->
                            {{-- <button id="saveBtn1" type="submit" form="store_tab1" class="btn btn-warning" style="width: 120px;">Simpan</button>
                            <button id="saveBtn2" type="submit" form="store_tab2" class="btn btn-warning" style="width: 120px;">Simpan</button>
                            <button id="saveBtn3" type="submit" form="store_tab3" class="btn btn-warning" style="width: 120px;">Simpan</button>
                            <button id="saveBtn4" type="submit" form="store_tab4" class="btn btn-warning" style="width: 120px;">Simpan</button>
                            <button id="saveBtn5" type="submit" form="store_tab5" class="btn btn-warning" style="width: 120px;">Simpan</button> --}}
                            <button id="saveBtn6" type="submit" form="store_tab6" class="btn btn-warning" style="width: 120px;">Simpan</button>

                            <form id="submitPermohonan" method="POST" enctype="multipart/form-data" action="{{ route('lesenTahunan.permohonan-02.store') }}">
                                @csrf
                            </form>

                            <!-- Hantar Button (Only on last tab) -->
                            <button id="submitBtn" type="button" class="btn btn-success" style="display: none; width: 120px;">Hantar</button>
                        </div>
                    </div>

                </div>

            </div>

            @endsection

            @push('scripts')

            <script type="text/javascript">
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
                document.addEventListener("DOMContentLoaded", function() {
                    // Display success message from Laravel session
                    var msgSuccess = @json(Session::get('success'));
                    if (msgSuccess) {
                        alert(msgSuccess);
                    }

                    // Display error message from Laravel session
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
                    // Init Simpan buttons
                    for (let i = 1; i <= totalTabs; i++) {
                        const btn = document.getElementById(`saveBtn${i}`);
                        if (btn) {
                            btn.style.display = i === currentTab ? 'inline-block' : 'none';
                            btn.onclick = () => {
                                console.log(`Simpan button for tab ${i} pressed.`);
                                submitForm(i);
                            };
                        }
                    }

                    document.getElementById("submitBtn").onclick = confirmSubmission;
                    document.getElementById("nextTabBtn").onclick = () => currentTab < totalTabs && changeTab(currentTab + 1);
                    document.getElementById("backTabBtn").onclick = () => currentTab > 1 && changeTab(currentTab - 1);

                    toggleSubmitButton();
                });

                function changeTab(newTab) {
                    toggleTab(currentTab, false);
                    toggleSimpan(currentTab, false);
                    currentTab = newTab;
                    toggleTab(currentTab, true);
                    toggleSimpan(currentTab, true);
                    toggleSubmitButton();
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
                    document.getElementById('submitBtn').style.display = currentTab === totalTabs ? 'inline-block' : 'none';
                }

                function confirmSubmission() {
                    const msg = "Saya dengan ini mengakui dan mengesahkan bahawa segala maklumat yang diberikan adalah benar dan tepat. " +
                        "Sebarang ketidaktepatan adalah tanggungjawab saya.\n\nAdakah anda pasti untuk menghantar permohonan ini?";
                    if (confirm(msg)) {
                        document.getElementById('submitPermohonan').submit();
                    }
                }

            </script>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            @endpush
