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
                        <h3 class="mb-0">{{ $applicationType->name }}</h3>
                        <small>{{ $moduleName->name }} - {{ $roleName }}</small>
                    </div>

                </div>
                <div class="col-md-3 align-content-center">
                    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
                        <ol class="breadcrumb text-center">
                            <li class="breadcrumb-item">
                                <a href="http://127.0.0.1:8000/kadPendaftaran/permohonan-08">{{
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
                                <a class="nav-link custom-nav-link " id="tab1-link" aria-disabled="true">Maklumat
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
                                <a class="nav-link custom-nav-link" id="tab7-link" aria-disabled="true">Perakuan</a>
                            </li>
                        </ul>

                    </div>

                    <div class="card-body">

                        <div class="tab-content" id="pills-tabContent">

                             <div class="tab-pane fade show " id="content-tab1" role="tabpanel"
                                aria-labelledby="tab1-link">

                                <div class="mb-4">
                                    <div class="mb-3">
                                        <h5 class="fw-bold mb-0">Maklumat Peribadi</h5>
                                        <small class="text-muted">Maklumat peribadi yang telah direkodkan dipaparkan
                                            untuk semakan sahaja.</small>
                                        <hr>
                                    </div>

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
                                            <input type="text" class="form-control" id="icno" name="icno"
                                                value="{{ old('icno', $userDetail->icno ?? '') }}"
                                                placeholder="Masukkan Nombor Kad Pengenalan" readonly>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-6 mb-3">
                                            <label for="phone_number" class="form-label">Nombor Telefon</label>
                                            <input type="text" class="form-control" id="phone_number"
                                                name="phone_number"
                                                value="{{ old('phone_number', $userDetail->no_phone ?? '') }}"
                                                placeholder="Masukkan Nombor Telefon" readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="secondary_phone_number_number" class="form-label">Nombor Telefon
                                                (Kedua)</label>
                                            <input type="text" class="form-control" id="secondary_phone_number_number"
                                                name="secondary_phone_number_number"
                                                value="{{ old('secondary_phone_number_number', $userDetail->secondary_phone_number_number ?? '') }}"
                                                placeholder="Masukkan Nombor Telefon Kedua" readonly>
                                        </div>
                                    </div>
                                </div>

                                <br>

                                <div class="mb-4">
                                    <div class="mb-3">
                                        <h5 class="fw-bold mb-0">Alamat Kediaman</h5>
                                        <small class="text-muted">Maklumat alamat kediaman yang telah direkodkan
                                            dipaparkan untuk semakan sahaja.</small>
                                        <hr>
                                    </div>

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
                                                value="{{ old('poskod', $userDetail->secondary_postcode ?? '') }}"
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

                                <div class="mb-4">
                                    <div class="mb-3">
                                        <h5 class="fw-bold mb-0">Alamat Surat-Menyurat</h5>
                                        <small class="text-muted">Maklumat alamat surat-menyurat yang telah direkodkan
                                            dipaparkan untuk semakan sahaja.</small>
                                        <hr>
                                    </div>

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

                            </div>

                            <div class="tab-pane fade" id="content-tab2" role="tabpanel" aria-labelledby="tab1-link">
                                <form id="store_tab2" method="POST"
                                    action="{{ route('kadPendaftaran.permohonan-08.store_tab2') }}">
                                    @csrf

                                    <input type="text" class="hidden" value="negative" name="status">

                                    <div class="mb-4">
                                        <h4 class="fw-bold mb-0">Maklumat Sebagai Nelayan</h4>
                                        <small class="text-muted">Sila isikan maklumat berkaitan pengalaman dan aktiviti
                                            sebagai nelayan</small>

                                        @php
                                        $currentYear = date('Y');
                                        $storedDate = old('year_become_fisherman',
                                        $fishermanData['year_become_fisherman'] ?? '');
                                        $selectedYear = $storedDate ? date('Y', strtotime($storedDate)) : '';
                                        $duration = $selectedYear ? ($currentYear - (int)$selectedYear) : '';
                                        @endphp

                                        <div class="row mt-3">
                                            <!-- Tahun Menjadi Nelayan (Year Only) -->
                                            <div class="col-md-6 mb-3">
                                                <label for="year_become_fisherman" class="form-label">
                                                    Tahun Menjadi Nelayan <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-select" id="year_become_fisherman"
                                                    name="year_become_fisherman" required>
                                                    <option value="">Sila Pilih </option>

                                                    @for ($year = $currentYear; $year >= 1950; $year--)
                                                    @php
                                                    $dateValue = $year . '-01-01';
                                                    @endphp
                                                    <option value="{{ $dateValue }}" {{ $storedDate==$dateValue
                                                        ? 'selected' : '' }}>
                                                        {{ $year }}
                                                    </option>
                                                    @endfor
                                                </select>
                                            </div>

                                            <!-- Tempoh Menjadi Nelayan -->
                                            <div class="col-md-6 mb-3">
                                                <label for="becoming_fisherman_duration" class="form-label">
                                                    Tempoh Menjadi Nelayan (Tahun)
                                                </label>
                                                <input type="number" class="form-control"
                                                    id="becoming_fisherman_duration" name="becoming_fisherman_duration"
                                                    value="{{ old('becoming_fisherman_duration', $duration) }}"
                                                    placeholder="Akan dikira secara automatik" readonly>
                                            </div>
                                        </div>
                                        @push('scripts')
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function () {
                                                const yearSelect = document.getElementById('year_become_fisherman');
                                                const durationInput = document.getElementById('becoming_fisherman_duration');

                                                function calculateDuration() {
                                                    const selectedDate = yearSelect.value; // e.g. "2015-01-01"
                                                    if (selectedDate) {
                                                        const year = parseInt(selectedDate.split('-')[0]);
                                                        const currentYear = new Date().getFullYear();
                                                        if (!isNaN(year) && year <= currentYear) {
                                                            durationInput.value = currentYear - year;
                                                        } else {
                                                            durationInput.value = '';
                                                        }
                                                    } else {
                                                        durationInput.value = '';
                                                    }
                                                }

                                                yearSelect.addEventListener('change', calculateDuration);
                                                calculateDuration(); // on page load
                                            });
                                        </script>
                                        @endpush

                                        <div class="row">

                                            <div class="row mt-3">
                                                <div class="col-md-6 mb-3">
                                                    <label for="working_days_fishing_per_month" class="form-label">
                                                        Hari Bekerja Menangkap Ikan Sebulan <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <input type="number" class="form-control"
                                                        id="working_days_fishing_per_month"
                                                        name="working_days_fishing_per_month"
                                                        value="{{ old('working_days_fishing_per_month', $fishermanData['working_days_fishing_per_month'] ?? '') }}"
                                                        placeholder="Masukkan hari bekerja menangkap ikan" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="estimated_income_yearly_fishing"
                                                        class="form-label">Purata Pendapatan Tahunan Dari Menangkap
                                                        Ikan (RM)</label>
                                                    <input type="number" class="form-control"
                                                        id="estimated_income_yearly_fishing"
                                                        name="estimated_income_yearly_fishing"
                                                        value="{{ old('estimated_income_yearly_fishing', $fishermanData['estimated_income_yearly_fishing'] ?? '') }}"
                                                        placeholder="Masukkan Pendapatan Tahunan Dari Menangkap Ikan"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <hr>

                                    <div class="mb-4">
                                        <h4 class="fw-bold mb-0">Maklumat Pekerjaan Lain</h4>
                                        <small class="text-muted">Sekiranya anda mempunyai pekerjaan lain, sila isi
                                            maklumat berikut</small>

                                        <div class="row mt-3">
                                            <div class="col-md-6 mb-3">
                                                <label for="estimated_income_other_job" class="form-label">Purata
                                                    Pendapatan
                                                    Dari Pekerjaan Lain (RM) </label>
                                                <input type="number" class="form-control"
                                                    id="estimated_income_other_job" name="estimated_income_other_job"
                                                    value="{{ old('estimated_income_other_job', $fishermanData['estimated_income_other_job'] ?? '') }}"
                                                    placeholder="Masukkan Pendapatan Dari Pekerjaan Lain" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="days_working_other_job_per_month" class="form-label">
                                                    Hari Bekerja Di Pekerjaan Lain Sebulan <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="number" class="form-control"
                                                    id="days_working_other_job_per_month"
                                                    name="days_working_other_job_per_month"
                                                    value="{{ old('days_working_other_job_per_month', $fishermanData['days_working_other_job_per_month'] ?? '') }}"
                                                    placeholder="Akan dikira automatik" readonly required>
                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function () {
                                                        const fishingInput = document.getElementById('working_days_fishing_per_month');
                                                        const otherJobInput = document.getElementById('days_working_other_job_per_month');

                                                        function calculateOtherJobDays() {
                                                            const fishingDays = parseInt(fishingInput.value) || 0;
                                                            const maxDays = 30;
                                                            const result = maxDays - fishingDays;

                                                            otherJobInput.value = result >= 0 ? result : 0;
                                                        }

                                                        fishingInput.addEventListener('input', calculateOtherJobDays);

                                                        // Trigger on load (in case old value is already filled)
                                                        calculateOtherJobDays();
                                                    });
                                                </script>

                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <hr>

                                    <div class="mb-4">
                                        <h4 class="fw-bold mb-0">Maklumat Kewangan</h4>
                                        <small class="text-muted">Pilih sama ada anda menerima bantuan atau
                                            pencen</small>

                                        <div class="row mt-3">
                                            <div class="col-md-6 mb-3">
                                                <label for="receive_pension" class="form-label">Menerima Pencen<span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select" id="receive_pension" name="receive_pension"
                                                    required>
                                                    <option value="">Sila Pilih </option>

                                                    <option value="1" {{ old('receive_pension',
                                                        $fishermanData['receive_pension'] ?? '' )==1 ? 'selected' : ''
                                                        }}>
                                                        YA</option>
                                                    <option value="0" {{ old('receive_pension',
                                                        $fishermanData['receive_pension'] ?? '' )==0 ? 'selected' : ''
                                                        }}>
                                                        TIDAK</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="epf_contributor" class="form-label">Pencarum KWSP <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select" id="epf_contributor" name="epf_contributor"
                                                    required>
                                                    <option value="">Sila Pilih </option>
                                                    <option value="1" {{ old('epf_contributor',
                                                        $fishermanData['epf_contributor'] ?? '' )==1 ? 'selected' : ''
                                                        }}>
                                                        YA</option>
                                                    <option value="0" {{ old('epf_contributor',
                                                        $fishermanData['epf_contributor'] ?? '' )==0 ? 'selected' : ''
                                                        }}>
                                                        TIDAK</option>
                                                </select>
                                            </div>

                                            @push('scripts')
                                            <script>
                                                document.addEventListener('DOMContentLoaded', function () {
                                                    const epfContributor = document.getElementById('epf_contributor');
                                                    const epfTypeContainer = document.getElementById('epf_type_container');

                                                    function toggleEpfTypeDropdown() {
                                                        if (epfContributor.value === '1') {
                                                            epfTypeContainer.style.display = 'block';
                                                        } else {
                                                            epfTypeContainer.style.display = 'none';
                                                            document.getElementById('epf_type').value = ''; // clear selection
                                                        }
                                                    }

                                                    epfContributor.addEventListener('change', toggleEpfTypeDropdown);
                                                    toggleEpfTypeDropdown(); // run on page load for old() values
                                            });
                                            </script>
                                            @endpush

                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="receive_financial_aid" class="form-label">Menerima
                                                    Bantuan Kewangan<span class="text-danger">*</span></label>
                                                <select class="form-select" id="receive_financial_aid"
                                                    name="receive_financial_aid" required>
                                                    <option value="">Sila Pilih </option>
                                                    <option value="1" {{ old('receive_financial_aid',
                                                        $fishermanData['receive_financial_aid'] ?? '' )==1 ? 'selected'
                                                        : '' }}>
                                                        YA</option>
                                                    <option value="0" {{ old('receive_financial_aid',
                                                        $fishermanData['receive_financial_aid'] ?? '' )==0 ? 'selected'
                                                        : '' }}>
                                                        TIDAK</option>
                                                </select>
                                            </div>
<div id="epf_type_container" class="col-md-6 mb-3" style="display: none;">
    <label for="epf_type" class="form-label">Jenis Caruman KWSP <span class="text-danger">*</span></label>
    <select class="form-select" id="epf_type" name="epf_type">
        @php
            $epfType = old('epf_type', $fishermanData['epf_type'] ?? '');
        @endphp

        <option value="" disabled {{ $epfType == '' ? 'selected' : '' }}>Sila Pilih</option>
        <option value="SYARIKAT" {{ $epfType == 'SYARIKAT' ? 'selected' : '' }}>SYARIKAT</option>
        <option value="PERSENDIRIAN" {{ $epfType == 'PERSENDIRIAN' ? 'selected' : '' }}>PERSENDIRIAN</option>
    </select>
</div>

                                        </div>

                                       <div class="row" id="financial_aid_agency_div">
    <div class="col-md mb-3">
        <label class="form-label">
            Agensi Memberi Bantuan Kewangan <span class="text-danger">*</span>
        </label>

        <div id="financial_aid_agency_container">
            @php
                $oldAgencies = old('financial_aid_agency');
                $agencies = (!is_array($oldAgencies) || count($oldAgencies) === 0)
                    ? $agencyData
                    : $oldAgencies;

                $agencies = is_array($agencies) ? $agencies : [$agencies];
            @endphp

            @forelse ($agencies as $agency)
                <div class="input-group agency-row mb-2">
                    <input type="text" name="financial_aid_agency[]" class="form-control"
                        value="{{ $agency }}"
                        placeholder="Masukkan Nama Agensi Penyedia Bantuan Kewangan">
                    <button type="button" class="btn btn-danger remove-agency" title="Buang">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            @empty
                <div class="input-group agency-row mb-2">
                    <input type="text" name="financial_aid_agency[]" class="form-control"
                        placeholder="Masukkan Nama Agensi Penyedia Bantuan Kewangan">
                    <button type="button" class="btn btn-danger remove-agency" title="Buang">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            @endforelse
        </div>

        <button type="button" class="btn btn-primary col-md" id="add-agency-btn">+ Tambah Agensi</button>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('financial_aid_agency_container');
        const addBtn = document.getElementById('add-agency-btn');

        addBtn.addEventListener('click', function () {
            const inputGroup = document.createElement('div');
            inputGroup.className = 'input-group agency-row mb-2';
            inputGroup.innerHTML = `
                <input type="text" name="financial_aid_agency[]" class="form-control"
                    placeholder="Masukkan Nama Agensi Penyedia Bantuan Kewangan">
                <button type="button" class="btn btn-danger remove-agency" title="Buang">
                    <i class="fa fa-trash"></i>
                </button>
            `;
            container.appendChild(inputGroup);
        });

        container.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-agency') || e.target.closest('.remove-agency')) {
                const row = e.target.closest('.agency-row');
                if (row) row.remove();
            }
        });
    });
</script>
@endpush



                                    </div>

                                </form>
                            </div>

                            {{-- <div class="tab-pane fade" id="content-tab3" role="tabpanel" aria-labelledby="tab3-link">
                                <form id="store_tab3" method="POST" enctype="multipart/form-data"
                                    action="{{ route('kadPendaftaran.permohonan-08.store_tab3') }}">
                                    @csrf

                                    <h4 class="fw-bold">Maklumat Jeti / Pangkalan</h4>
                                    <small class="text-muted m-0">Sila isikan lokasi atau kawasan jeti tempat
                                        beroperasi</small>

                                    <div class="mt-3">
                                        <!-- Negeri -->
                                    <div class="mb-3">
                                    <label for="state_id" class="form-label">
                                        Negeri <span class="text-danger">*</span>
                                    </label>
                                    <select id="state_id" name="state_id" class="form-control" required>
                                        <option value="">-- PILIH NEGERI --</option>
                                        @foreach ($states as $id => $name)
                                            <option value="{{ $id }}" {{ old('state_id', $jettyData['state_id'] ?? '') == $id ? 'selected' : '' }}>
                                                {{ strtoupper($name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                                        <!-- Daerah -->
                                        <div class="mb-3">
                                            <label for="district_id" class="form-label">Daerah <span
                                                    class="text-danger">*</span></label>
                                            <select id="district_id" name="district_id" class="form-control" required>
                                                <option value="">-- Pilih Daerah --</option>
                                            </select>
                                        </div>

                                        <!-- Jeti -->
                                        <div class="mb-3">
                                            <label for="jetty_id" class="form-label">Jeti <span
                                                    class="text-danger">*</span></label>
                                            <select id="jetty_id" name="jetty_id" class="form-control" required>
                                                <option value="">-- Pilih Jeti --</option>
                                            </select>
                                        </div>

                                        <!-- Sungai -->
                                        <div class="mb-3">
                                            <label for="river_id" class="form-label">Sungai <span
                                                    class="text-danger">*</span></label>
                                            <select id="river_id" name="river_id" class="form-control" required>
                                                <option value="">-- Pilih Sungai --</option>
                                            </select>
                                        </div>
                                    </div>

                                    @push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const stateSelect = document.getElementById('state_id');
    const districtSelect = document.getElementById('district_id');
    const jettySelect = document.getElementById('jetty_id');
    const riverSelect = document.getElementById('river_id');

    //
    const routeDistricts = "/kadPendaftaran/permohonan-08/getDistricts/:state_id";
    const routeJetties = "/kadPendaftaran/permohonan-08/getJetties/:district_id";
    const routeRivers = "/kadPendaftaran/permohonan-08/getRivers/:district_id";

    const selectedStateId = "{{ old('state_id', $jettyData['state_id'] ?? '') }}";
    const selectedDistrictId = "{{ old('district_id', $jettyData['district_id'] ?? '') }}";
    const selectedJettyId = "{{ old('jetty_id', $jettyData['jetty_id'] ?? '') }}";
    const selectedRiverId = "{{ old('river_id', $jettyData['river_id'] ?? '') }}";

    if (selectedStateId) {
        const finalDistrictUrl = routeDistricts.replace(':state_id', selectedStateId);
        fetch(finalDistrictUrl)
            .then(res => res.json())
            .then(data => {
                for (const [id, name] of Object.entries(data)) {
                    const selected = (id == selectedDistrictId) ? 'selected' : '';
                    districtSelect.innerHTML += `<option value="${id}" ${selected}>${name.toUpperCase()}</option>`;
                }

                if (selectedDistrictId) {
                    const finalJettyUrl = routeJetties.replace(':district_id', selectedDistrictId);
                    const finalRiverUrl = routeRivers.replace(':district_id', selectedDistrictId);

                    fetch(finalJettyUrl)
                        .then(res => res.json())
                        .then(data => {
                            for (const [id, name] of Object.entries(data)) {
                                const selected = (id == selectedJettyId) ? 'selected' : '';
                                jettySelect.innerHTML += `<option value="${id}" ${selected}>${name.toUpperCase()}</option>`;
                            }
                        });

                    fetch(finalRiverUrl)
                        .then(res => res.json())
                        .then(data => {
                            for (const [id, name] of Object.entries(data)) {
                                const selected = (id == selectedRiverId) ? 'selected' : '';
                                riverSelect.innerHTML += `<option value="${id}" ${selected}>${name.toUpperCase()}</option>`;
                            }
                        });
                }
            });
    }

    stateSelect.addEventListener('change', function () {
        const stateId = this.value;
        districtSelect.innerHTML = '<option value="">-- Pilih Daerah --</option>';
        jettySelect.innerHTML = '<option value="">-- Pilih Jeti --</option>';
        riverSelect.innerHTML = '<option value="">-- Pilih Sungai --</option>';

        if (stateId) {
            const finalDistrictUrl = routeDistricts.replace(':state_id', stateId);
            fetch(finalDistrictUrl)
                .then(res => res.json())
                .then(data => {
                    for (const [id, name] of Object.entries(data)) {
                        districtSelect.innerHTML += `<option value="${id}">${name.toUpperCase()}</option>`;
                    }
                });
        }
    });

    districtSelect.addEventListener('change', function () {
        const districtId = this.value;
        jettySelect.innerHTML = '<option value="">-- Pilih Jeti --</option>';
        riverSelect.innerHTML = '<option value="">-- Pilih Sungai --</option>';

        if (districtId) {
            const finalJettyUrl = routeJetties.replace(':district_id', districtId);
            const finalRiverUrl = routeRivers.replace(':district_id', districtId);

            fetch(finalJettyUrl)
                .then(res => res.json())
                .then(data => {
                    for (const [id, name] of Object.entries(data)) {
                        jettySelect.innerHTML += `<option value="${id}">${name.toUpperCase()}</option>`;
                    }
                });

            fetch(finalRiverUrl)
                .then(res => res.json())
                .then(data => {
                    for (const [id, name] of Object.entries(data)) {
                        riverSelect.innerHTML += `<option value="${id}">${name.toUpperCase()}</option>`;
                    }
                });
        }
    });
});
</script>
@endpush


                                </form>
                            </div> --}}


                            <div class="tab-pane fade" id="content-tab3" role="tabpanel" aria-labelledby="tab3-link">
    <form id="store_tab3" method="POST" enctype="multipart/form-data"
        action="{{ route('kadPendaftaran.permohonan-08.store_tab3') }}">
        @csrf

                                    <input type="text" class="hidden" value="negative" name="status">


        <h4 class="fw-bold">Maklumat Jeti / Pangkalan</h4>
        <small class="text-muted m-0">Sila isikan lokasi atau kawasan jeti tempat beroperasi</small>

        <div class="mt-3">
            <!-- Negeri -->
            <div class="mb-3">
                <label for="state_id" class="form-label">
                    Negeri <span class="text-danger">*</span>
                </label>
                <select id="state_id" name="state_id" class="form-control" required>
                    <option value="">-- PILIH NEGERI --</option>
                    @foreach ($states as $id => $name)
                        <option value="{{ $id }}" {{ old('state_id', $jettyData['state_id'] ?? '') == $id ? 'selected' : '' }}>
                            {{ strtoupper($name) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Daerah -->
            <div class="mb-3">
                <label for="district_id" class="form-label">Daerah <span class="text-danger">*</span></label>
                <select id="district_id" name="district_id" class="form-control" required>
                    <option value="">-- Pilih Daerah --</option>
                </select>
            </div>

            <!-- Jeti -->
            <div class="mb-3">
                <label for="jetty_id" class="form-label">Jeti <span class="text-danger">*</span></label>
                <select id="jetty_id" name="jetty_id" class="form-control" required>
                    <option value="">-- Pilih Jeti --</option>
                </select>
            </div>

            <!-- Sungai -->
            <div class="mb-3">
                <label for="river_id" class="form-label">Sungai <span class="text-danger">*</span></label>
                <select id="river_id" name="river_id" class="form-control" required>
                    <option value="">-- Pilih Sungai --</option>
                </select>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const stateSelect = document.getElementById('state_id');
    const districtSelect = document.getElementById('district_id');
    const jettySelect = document.getElementById('jetty_id');
    const riverSelect = document.getElementById('river_id');

    // Use full URL for production compatibility
    const routeDistricts = "{{ url('kadPendaftaran/permohonan-08/getDistricts') }}/:state_id";
    const routeJetties = "{{ url('kadPendaftaran/permohonan-08/getJetties') }}/:district_id";
    const routeRivers = "{{ url('kadPendaftaran/permohonan-08/getRivers') }}/:district_id";

    const selectedStateId = "{{ old('state_id', $jettyData['state_id'] ?? '') }}";
    const selectedDistrictId = "{{ old('district_id', $jettyData['district_id'] ?? '') }}";
    const selectedJettyId = "{{ old('jetty_id', $jettyData['jetty_id'] ?? '') }}";
    const selectedRiverId = "{{ old('river_id', $jettyData['river_id'] ?? '') }}";

    if (selectedStateId) {
        const finalDistrictUrl = routeDistricts.replace(':state_id', selectedStateId);
        fetch(finalDistrictUrl)
            .then(res => res.json())
            .then(data => {
                for (const [id, name] of Object.entries(data)) {
                    const selected = (id == selectedDistrictId) ? 'selected' : '';
                    districtSelect.innerHTML += `<option value="${id}" ${selected}>${name.toUpperCase()}</option>`;
                }

                if (selectedDistrictId) {
                    const finalJettyUrl = routeJetties.replace(':district_id', selectedDistrictId);
                    const finalRiverUrl = routeRivers.replace(':district_id', selectedDistrictId);

                    fetch(finalJettyUrl)
                        .then(res => res.json())
                        .then(data => {
                            for (const [id, name] of Object.entries(data)) {
                                const selected = (id == selectedJettyId) ? 'selected' : '';
                                jettySelect.innerHTML += `<option value="${id}" ${selected}>${name.toUpperCase()}</option>`;
                            }
                        });

                    fetch(finalRiverUrl)
                        .then(res => res.json())
                        .then(data => {
                            for (const [id, name] of Object.entries(data)) {
                                const selected = (id == selectedRiverId) ? 'selected' : '';
                                riverSelect.innerHTML += `<option value="${id}" ${selected}>${name.toUpperCase()}</option>`;
                            }
                        });
                }
            });
    }

    stateSelect.addEventListener('change', function () {
        const stateId = this.value;
        districtSelect.innerHTML = '<option value="">-- Pilih Daerah --</option>';
        jettySelect.innerHTML = '<option value="">-- Pilih Jeti --</option>';
        riverSelect.innerHTML = '<option value="">-- Pilih Sungai --</option>';

        if (stateId) {
            const finalDistrictUrl = routeDistricts.replace(':state_id', stateId);
            fetch(finalDistrictUrl)
                .then(res => res.json())
                .then(data => {
                    for (const [id, name] of Object.entries(data)) {
                        districtSelect.innerHTML += `<option value="${id}">${name.toUpperCase()}</option>`;
                    }
                });
        }
    });

    districtSelect.addEventListener('change', function () {
        const districtId = this.value;
        jettySelect.innerHTML = '<option value="">-- Pilih Jeti --</option>';
        riverSelect.innerHTML = '<option value="">-- Pilih Sungai --</option>';

        if (districtId) {
            const finalJettyUrl = routeJetties.replace(':district_id', districtId);
            const finalRiverUrl = routeRivers.replace(':district_id', districtId);

            fetch(finalJettyUrl)
                .then(res => res.json())
                .then(data => {
                    for (const [id, name] of Object.entries(data)) {
                        jettySelect.innerHTML += `<option value="${id}">${name.toUpperCase()}</option>`;
                    }
                });

            fetch(finalRiverUrl)
                .then(res => res.json())
                .then(data => {
                    for (const [id, name] of Object.entries(data)) {
                        riverSelect.innerHTML += `<option value="${id}">${name.toUpperCase()}</option>`;
                    }
                });
        }
    });
});
</script>
@endpush


                            <div class="tab-pane fade" id="content-tab4" role="tabpanel" aria-labelledby="tab4-link">
                                <form id="store_tab4" method="POST" enctype="multipart/form-data"
                                    action="{{ route('kadPendaftaran.permohonan-08.store_tab4') }}">
                                    @csrf

                                     <input type="text" class="hidden" value="negative" name="status">
                                     <input type="text" class="hidden" value="negative" name="needItem">



                                  <section>
                                        <div class="mb-3">
                                            <h5 class="fw-bold mb-0">Peralatan Utama</h5>
                                            <small class="text-muted">Maklumat peralatan utama yang digunakan</small>

                                        </div>

                                        <div class="form-group">
                                            @php
                                            $main = $mainEquipment[0] ?? ['name' => '', 'quantity' => '', 'file_path' =>
                                            null, 'original_name' => null];
                                            @endphp

                                            <div class="row mb-3 align-items-start">

                                                <!-- Equipment Dropdown -->
                                                <div class="col-md-4">
                                                    <label for="main_0_name" class="form-label">Peralatan <span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-select" id="main_0_name" name="main[0][name]"
                                                        required>
                                                        <option value="">Sila Pilih</option>
                                                        @foreach ($equipmentList as $id => $name)
                                                        <option value="{{ $name }}" {{ old('main.0.name',
                                                            $main['name'])==$name ? 'selected' : '' }}>
                                                            {{ $name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Quantity Input -->
                                                <div class="col-md-1">
                                                    <label for="main_0_quantity" class="form-label">Kuantiti <span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" name="main[0][quantity]" id="main_0_quantity"
                                                        class="form-control" min="1"
                                                        value="{{ old('main.0.quantity', $main['quantity']) }}"
                                                        required>
                                                </div>

                                                <!-- File Upload Input -->
                                                <div class="col-md">
                                                    <label for="main_0_file" class="form-label">Gambar Peralatan <span
                                                            class="text-danger"></span>
                                                        @if (empty($main['file_path']))
                                                        <span class="text-danger">*</span>
                                                        @endif
                                                    </label>

                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="main_0_file"
                                                            name="main[0][file]" accept=".jpg,.jpeg,.png,.pdf"
                                                            @if(empty($main['file_path'])) required @endif>

                                                     <label class="custom-file-label" for="main_0_file">
    {{ isset($main['file_path']) ? basename($main['file_path']) : 'Pilih Fail' }}
</label>



                                                    </div>

                                                    <small class="text-muted">
                                                        Format dibenarkan: JPG, JPEG, PNG, PDF. Saiz maksimum: 5MB.
                                                    </small>

                                                </div>

                                                @if (!empty($main['file_path']))
                                                <div class="col-md-auto text-center">
                                                    <label class="form-label d-none d-md-block">&nbsp;</label>
                                                    <a type="button" class="btn btn-primary"
                                                        onclick="window.open('{{ route('tukarPeralatan.permohonan-04.viewTempEquipment', ['type' => 'UTAMA', 'index' => 0]) }}', '_blank')">
                                                        <i class="fa fa-search p-1"></i>
                                                    </a>
                                                </div>
                                                @endif

                                            </div>
                                        </div>

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
                                    </section>

                                    <!-- Peralatan Tambahan -->
                                 <section>
                                        <div class="mb-3">
                                            <h5 class="fw-bold mb-0">Peralatan Tambahan</h5>
                                            <small class="text-muted">Maklumat peralatan tambahan yang digunakan
                                                (pilihan)</small>

                                        </div>

                                        <div class="form-group">
                                            @for ($i = 0; $i < 5; $i++) @php $item=$additionalEquipments[$i] ??
                                                ['name'=> '', 'quantity' => '', 'file_path' => null, 'original_name' =>
                                                null];
                                                @endphp

                                                <div class="row mb-3 align-items-start">

                                                    <!-- Equipment Dropdown -->
                                                    <div class="col-md-4">
                                                        <label for="additional_{{ $i }}_name"
                                                            class="form-label">Peralatan</label>
                                                        <select class="form-select" id="additional_{{ $i }}_name"
                                                            name="additional[{{ $i }}][name]">
                                                            <option value="">Sila Pilih (Optional)</option>
                                                            @foreach ($equipmentList as $id => $name)
                                                            <option value="{{ $name }}" {{ old("additional.$i.name",
                                                                $item['name'])==$name ? 'selected' : '' }}>
                                                                {{ $name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Quantity Input -->
                                                    <div class="col-md-1">
                                                        <label for="additional_{{ $i }}_quantity"
                                                            class="form-label">Kuantiti</label>
                                                        <input type="number" name="additional[{{ $i }}][quantity]"
                                                            id="additional_{{ $i }}_quantity" class="form-control"
                                                            min="1" value="{{ old(" additional.$i.quantity",
                                                            $item['quantity']) }}">
                                                    </div>

                                                    <!-- File Upload Input -->
                                                    <div class="col-md">
                                                        <label for="additional_{{ $i }}_file" class="form-label">Gambar
                                                            Peralatan</label>

                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input"
                                                                id="additional_{{ $i }}_file"
                                                                name="additional[{{ $i }}][file]"
                                                                accept=".jpg,.jpeg,.png,.pdf">
                                                           <label class="custom-file-label" for="additional_{{ $i }}_file">
    {{ isset($item['file_path']) ? basename($item['file_path']) : 'Pilih Fail' }}
</label>

                                                        </div>

                                                        <small class="text-muted">
                                                            Format dibenarkan: JPG, JPEG, PNG, PDF. Saiz maksimum: 5MB.
                                                        </small>
                                                    </div>

                                                    @if (!empty($item['file_path']))
                                                    <div class="col-md-auto text-center">

                                                        <label class="form-label d-none d-md-block">&nbsp;</label>
                                                        <button type="button" class="btn btn-primary"
                                                            onclick="window.open('{{ route('tukarPeralatan.permohonan-04.viewTempEquipment', ['type' => 'TAMBAHAN', 'index' => $i]) }}', '_blank')">
                                                            <i class="fa fa-search p-1"></i>
                                                        </button>
                                                    </div>

                                                    @endif
                                                </div>
                                                @endfor
                                        </div>

                                        @push('scripts')
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function () {
                                            // Attach file input change listener for each additional field
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
                                    </section>

                            </form>
                        </div>

                        <div class="tab-pane fade" id="content-tab5" role="tabpanel" aria-labelledby="tab5-link">
                            <form id="store_tab5" method="POST" enctype="multipart/form-data"
                                action="{{ route('kadPendaftaran.permohonan-08.store_tab5') }}">
                                @csrf

                                 <input type="text" class="hidden" value="negative" name="status">

                                <div class="mb-3">
                                    <h4 class="fw-bold mb-0">Maklumat Pemilikan Vesel</h4>
                                    <small class="text-muted">Sila pilih sama ada anda mempunyai vesel atau
                                        tidak</small>
                                    <hr>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Adakah anda mempunyai vesel? <span
                                            class="text-danger">*</span></label>
                                    <select name="has_vessel" id="has_vessel" class="form-select">
                                        <option value="">Pilih</option>
                                        <option value="yes" {{ old('has_vessel', $vesselData['has_vessel'] ?? ''
                                            )=='yes' ? 'selected' : '' }}>
                                            YA</option>
                                        <option value="no" {{ old('has_vessel', $vesselData['has_vessel'] ?? '' )=='no'
                                            ? 'selected' : '' }}>
                                            TIDAK</option>
                                    </select>
                                </div>

                                <div id="no_vessel_transport_section"
                                    class="{{ old('has_vessel', $vesselData['has_vessel'] ?? '') == 'no' ? '' : 'd-none' }}">
                                    <div class="mb-3">
                                        <label for="transport_type" class="form-label">Jenis Pengangkutan
                                            Digunakan <span class="text-danger">*</span></label>
                                        <input type="text" name="transport_type" id="transport_type"
                                            class="form-control"
                                            value="{{ old('transport_type', $vesselData['transport_type'] ?? '') }}"
                                            placeholder="Contoh: Jalan kaki, motosikal">
                                    </div>
                                </div>

                                <br>
                                <hr>

                                <div id="vessel_section"
                                    class="{{ old('has_vessel', $vesselData['has_vessel'] ?? '') == 'yes' ? '' : 'd-none' }}">
                                    <div class="mb-3">
                                        <h4 class="fw-bold mb-0">Maklumat Vesel</h4>
                                        <small class="text-muted">Sila isikan maklumat vesel anda</small>

                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-6 mb-3">
                                            <label for="vessel_registration_number" class="form-label">No.
                                                Pendaftaran
                                                Vesel </label>
                                            <input type="text" name="vessel_registration_number"
                                                id="vessel_registration_number" class="form-control"
                                                value="{{ old('vessel_registration_number', $vesselData['vessel_registration_number'] ?? '') }}"
                                                placeholder="Masukkan No. Pendaftaran Vesel">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="hull_type" class="form-label">Jenis Kulit Vesel <span
                                                    class="text-danger">*</span></label>
                                            <select name="hull_type" id="hull_type" class="form-select" required>
                                                <option value="">Pilih Jenis Kulit Vesel</option>
                                                @foreach ($hullTypes as $id => $name)
                                                <option value="{{ $name }}" {{ old('hull_type', $vesselData['hull_type']
                                                    ?? '' )==$name ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="length" class="form-label">Panjang (m) <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" step="0.01" name="length" id="length"
                                                class="form-control"
                                                value="{{ old('length', $vesselData['length'] ?? '') }}"
                                                placeholder="Masukkan Panjang Vesel">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="width" class="form-label">Lebar (m) <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" step="0.01" name="width" id="width"
                                                class="form-control"
                                                value="{{ old('width', $vesselData['width'] ?? '') }}"
                                                placeholder="Masukkan Lebar Vesel">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="depth" class="form-label">Kedalaman (m) <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" step="0.01" name="depth" id="depth"
                                                class="form-control"
                                                value="{{ old('depth', $vesselData['depth'] ?? '') }}"
                                                placeholder="Masukkan Kedalaman Vesel">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Adakah vesel mempunyai enjin?</label>
                                        <select name="has_engine" id="has_engine" class="form-select">
                                            <option value="">Pilih</option>
                                            <option value="yes" {{ old('has_engine', $vesselData['has_engine'] ?? ''
                                                )=='yes' ? 'selected' : '' }}>
                                                YA</option>
                                            <option value="no" {{ old('has_engine', $vesselData['has_engine'] ?? ''
                                                )=='no' ? 'selected' : '' }}>
                                                TIDAK</option>
                                        </select>
                                    </div>

                                    <br>
                                    <hr>

                                    <div id="engine_section"
                                        class="{{ old('has_engine', $vesselData['has_engine'] ?? '') == 'yes' ? '' : 'd-none' }}">
                                        <div class="mb-3">
                                            <h4 class="fw-bold mb-0">Maklumat Enjin</h4>
                                            <small class="text-muted">Isikan maklumat enjin vesel anda jika
                                                ada</small>

                                        </div>

                                        <div class="row">
                                            <!-- Jenama Enjin -->
                                        <div class="col-md-4">
                                            <label for="engine_brand" class="form-label">Jenama Enjin <span class="text-danger">*</span></label>
                                            <select class="form-select" id="engine_brand" name="engine_brand" required>
                                                <option value="">Sila Pilih</option>
                                                @foreach ($engineBrand as $id => $name)
                                                    <option value="{{ $name }}" {{ old('engine_brand', $vesselData['engine_brand'] ?? '') == $name ? 'selected' : '' }}>
                                                        {{ $name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                            <div class="col-md mb-3">
                                                <label for="engine_model" class="form-label">Model Enjin <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="engine_model" id="engine_model"
                                                    class="form-control"
                                                    value="{{ old('engine_model', $vesselData['engine_model'] ?? '') }}"
                                                    placeholder="Contoh: Yamaha 150HP">
                                            </div>

                                            <div class="col-md mb-3">
                                                <label for="engine_power" class="form-label">Kuasa Kuda (KK) <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="engine_power" id="engine_power"
                                                    class="form-control"
                                                    value="{{ old('engine_power', $vesselData['horsepower'] ?? '') }}"
                                                    placeholder="Contoh: 150HP">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <br>
                        </div>

                        {{-- <div class="tab-pane fade" id="content-tab6" role="tabpanel" aria-labelledby="tab6-link">
                            <form method="POST" id="store_tab6" action="{{ route('kadPendaftaran.permohonan-08.store_tab6') }}"
                                enctype="multipart/form-data">
                                @csrf

                                <section>
                                    <h4 class="fw-bold mb-0">Muat Naik Dokumen Permohonan</h4>
                                    <small class="text-muted">
                                        Sila cetak permohonan anda, dapatkan tandatangan daripada Penghulu/Ketua Kampung/JKKK/JKOA/MyKP,
                                        dan muat naik semula dokumen tersebut.
                                    </small>
                                        <div class="mt-3">
                                            <a href="{{ route('kadPendaftaran.permohonan-08.printApplication') }}" target="_blank"
                                                class="btn btn-primary m-0">
                                                <i class="fa fa-print"></i> Cetak Borang Permohonan
                                            </a>
                                        </div>

                                    <div class="alert alert-warning mt-3">
                                        <strong>Perhatian:</strong> Pastikan dokumen lengkap telah ditandatangani sebelum dimuat naik.

                                    </div>


<div class="row mt-3">
    <div class="col-md">
        <label for="signed_application" class="form-label">
            Dokumen Permohonan Bertandatangan <span class="text-danger">*</span>
        </label>

        @php
            $existingSignedFile = $signedAppDoc['file_path'] ?? null;
            $existingFileName = $existingSignedFile ? basename($existingSignedFile) : 'Pilih fail';
        @endphp

        <div class="custom-file">
            <input type="file" name="signed_application" id="signed_application" class="custom-file-input" accept=".pdf,.jpg,.jpeg,.png,.docx" required>
            <label class="custom-file-label">{{ $existingFileName }}</label>
        </div>

        <small class="text-muted">Format dibenarkan: PDF, JPG, PNG, DOCX. Saiz maksimum: 2MB.</small>

        @if ($existingSignedFile)
            <div class="mt-2">
                <a class="btn btn-primary" target="_blank"
                    href="{{ asset('storage/' . $existingSignedFile) }}">
                    <i class="fa fa-search p-1"></i>
                </a>
            </div>
        @endif
    </div>
</div>
                                </section>

                                <br>

                                <section class="mt-5">
                                    <h4 class="fw-bold mb-0">Muat Naik Borang Pengisytiharan Pendaratan</h4>
                                    <small class="text-muted">
                                        Sila muat turun borang dari menu <strong>Dokumen</strong>, lengkapkan dan dapatkan tandatangan,
                                        kemudian muat naik semula ke dalam sistem.
                                    </small>

                                    <div class="alert alert-warning mt-3">
                                        <strong>Perhatian:</strong> Muat turun borang dari menu <strong>Dokumen</strong> dahulu sebelum  muat naik di sini.
                                    </div>


    <div class="col-md">
        <label for="landing_declaration_form" class="form-label">
            Borang Pengisytiharan Pendaratan Bertandatangan <span class="text-danger">*</span>
        </label>

        @php
            $landingFilePath = $landingDoc['file_path'] ?? null;
            $landingFileName = $landingFilePath ? basename($landingFilePath) : 'Pilih fail';
        @endphp

        <div class="custom-file">
            <input type="file" name="landing_declaration_form" id="landing_declaration_form" class="custom-file-input" accept=".pdf,.jpg,.jpeg,.png,.docx" required>
            <label class="custom-file-label">{{ $landingFileName }}</label>
        </div>

        <small class="text-muted">Format dibenarkan: PDF, JPG, PNG, DOCX. Saiz maksimum: 2MB.</small>

        @if ($landingFilePath)
            <div class="mt-2">
                <a class="btn btn-primary" target="_blank"
                    href="{{ asset('storage/' . $landingFilePath) }}">
                    <i class="fa fa-search p-1"></i>
                </a>
            </div>
        @endif
    </div>
</div>

                                    @push('scripts')
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                    const input = document.getElementById('landing_declaration_form');
                                    const label = input.nextElementSibling;

                                    input.addEventListener('change', function () {
                                        const fileName = this.files.length > 0 ? this.files[0].name : 'Pilih fail';
                                        label.textContent = fileName;
                                    });
                                });
                                    </script>
                                    @endpush
                                </section>

                            </form>
                        </div> --}}

                       {{-- <div class="tab-pane fade" id="content-tab7" role="tabpanel" aria-labelledby="tab7-link">
                            <form id="submitPermohonan" method="POST" enctype="multipart/form-data"
                                action="{{ route('kadPendaftaran.permohonan-08.store') }}" onsubmit="sessionStorage.clear();">
                                @csrf
                            </form>

                        </div> --}}

                 <div class="tab-pane fade" id="content-tab6" role="tabpanel" aria-labelledby="tab6-link">
    <form method="POST" id="store_tab6" action="{{ route('kadPendaftaran.permohonan-08.store_tab6') }}"
        enctype="multipart/form-data">
        @csrf

         <input type="text" class="hidden" value="negative" name="status">

        <section>
            <h4 class="fw-bold mb-0">Muat Naik Dokumen Permohonan</h4>
            <small class="text-muted">
                Sila cetak permohonan anda, dapatkan tandatangan daripada Penghulu/Ketua Kampung/JKKK/JKOA/MyKP,
                dan muat naik semula dokumen tersebut.
            </small>
            <br>
       <a href="{{ route('kadPendaftaran.permohonan-08.printApplication', ['status' => 'negative']) }}"
   target="_blank" class="btn btn-primary m-0">
    <i class="fa fa-print"></i> Cetak Borang Permohonan
</a>


            <div class="alert alert-warning mt-3">
                <strong>Perhatian:</strong> Pastikan dokumen lengkap telah ditandatangani sebelum dimuat naik.
            </div>

            {{-- Signed Application --}}
            @php
                $signedAppDoc = collect($documentsData ?? [])->firstWhere('title', 'Borang Pengesahan Penghulu/Ketua Kampung/JKKK/JKOA/MyKP');
                $signedFile = $signedAppDoc['file_path'] ?? null;
                $signedFileName = $signedFile ? basename($signedFile) : 'Pilih Fail';
            @endphp

            <div class="mb-4">
                <label for="signed_application" class="form-label">Dokumen Permohonan Bertandatangan <span class="text-danger">*</span></label>

                <div class="d-flex align-items-center gap-2">
                    <div style="flex-grow: 1;">
                        <div class="custom-file">
                            <input type="file" name="signed_application" id="signed_application"
                                class="custom-file-input" accept=".pdf,.jpg,.jpeg,.png,.docx" required>
                            <label class="custom-file-label">{{ $signedFileName }}</label>
                        </div>
                    </div>

                    @if ($signedFile)
                    <a class="btn btn-primary" target="_blank"
                        href="{{ asset('storage/' . $signedFile) }}">
                        <i class="fa fa-search p-1"></i>
                    </a>
                    @endif
                </div>

                <small class="text-muted">Format dibenarkan: PDF, JPG, PNG, DOCX. Saiz maksimum: 2MB.</small>
            </div>
        </section>

        <section class="mt-5">
            <h4 class="fw-bold mb-0">Muat Naik Borang Pengisytiharan Pendaratan</h4>
            <small class="text-muted">
                Sila muat turun borang dari menu <strong>Dokumen</strong>, lengkapkan dan dapatkan tandatangan,
                kemudian muat naik semula ke dalam sistem.
            </small>

            <div class="alert alert-warning mt-3">
                <strong>Perhatian:</strong> Muat turun borang dari menu <strong>Dokumen</strong> dahulu sebelum muat naik di sini.
            </div>

            {{-- Landing Declaration --}}
            @php
                $landingDoc = collect($documentsData ?? [])->firstWhere('title', 'Borang Pengisytiharan Pendaratan');
                $landingFile = $landingDoc['file_path'] ?? null;
                $landingFileName = $landingFile ? basename($landingFile) : 'Pilih Fail';
            @endphp

            <div class="mb-4">
                <label for="landing_declaration_form" class="form-label">Borang Pengisytiharan Pendaratan Bertandatangan <span class="text-danger">*</span></label>

                <div class="d-flex align-items-center gap-2">
                    <div style="flex-grow: 1;">
                        <div class="custom-file">
                            <input type="file" name="landing_declaration_form" id="landing_declaration_form"
                                class="custom-file-input" accept=".pdf,.jpg,.jpeg,.png,.docx" required>
                            <label class="custom-file-label">{{ $landingFileName }}</label>
                        </div>
                    </div>

                    @if ($landingFile)
                    <a class="btn btn-primary" target="_blank"
                        href="{{ asset('storage/' . $landingFile) }}">
                        <i class="fa fa-search p-1"></i>
                    </a>
                    @endif
                </div>

                <small class="text-muted">Format dibenarkan: PDF, JPG, PNG, DOCX. Saiz maksimum: 2MB.</small>
            </div>
        </section>
    </form>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            ['signed_application', 'landing_declaration_form'].forEach(function (id) {
                const input = document.getElementById(id);
                const label = input?.nextElementSibling;

                if (input && label) {
                    input.addEventListener('change', function () {
                        label.textContent = this.files.length > 0 ? this.files[0].name : 'Pilih Fail';
                    });
                }
            });
        });
    </script>
    @endpush
</div>



                        <div class="tab-pane fade" id="content-tab7" role="tabpanel" aria-labelledby="tab7-link">
                        <form id="submitPermohonan" method="POST" enctype="multipart/form-data"
                            action="{{ route('kadPendaftaran.permohonan-08.store') }}" onsubmit="sessionStorage.clear();">
                            @csrf


                               <input type="text" class="hidden" value="negative" name="status">



                            <!-- Perakuan Checkbox -->
                            <div class="form-check mt-4 mb-4 text-center">
                                <input class="form-check-input" type="checkbox" id="declarationCheckbox" name="declaration">
                                <label class="form-check-label fw-semibold text-secondary" for="declarationCheckbox">
                                    Saya dengan ini mengakui dan mengesahkan bahawa semua maklumat yang diberikan oleh saya adalah benar.
                                    Sekiranya terdapat maklumat yang tidak benar, pihak Jabatan boleh menolak permohonan saya dan tindakan
                                    undang-undang boleh dikenakan ke atas saya.
                                </label>
                            </div>

                            <!-- Button Row -->
                            <div class="text-center">

                                <button type="submit" id="hantarBtn" class="btn btn-success" disabled>
                                    <i class="fa fa-paper-plane"></i> Hantar Permohonan
                                </button>
                            </div>
                        </form>

                        @push('scripts')
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const checkbox = document.getElementById('declarationCheckbox');
                                const hantarBtn = document.getElementById('hantarBtn');

                                checkbox.addEventListener('change', function () {
                                    hantarBtn.disabled = !this.checked;
                                });
                            });
                        </script>
                        @endpush
                    </div>

                        <div class="card-footer pl-0 pr-0">
                            <div class="d-flex justify-content-between align-items-start flex-wrap">
                                <!-- Left: Print Button -->
                                <div class="m-0 mb-2">

                                </div>

                                <!-- Right: Navigation Buttons -->
                                <div class="d-flex justify-content-end mb-2 flex-wrap gap-2">
                                    <button id="backTabBtn" type="button" class="btn btn-light"
                                        style="width: 120px;">Kembali</button>

                                    <button id="saveBtn2" type="submit" form="store_tab2" class="btn btn-warning"
                                        style="width: 120px;">Simpan</button>
                                    <button id="saveBtn3" type="submit" form="store_tab3" class="btn btn-warning"
                                        style="width: 120px;">Simpan</button>
                                    <button id="saveBtn4" type="submit" form="store_tab4" class="btn btn-warning"
                                        style="width: 120px;">Simpan</button>
                                    <button id="saveBtn5" type="submit" form="store_tab5" class="btn btn-warning"
                                        style="width: 120px;">Simpan</button>
                                    <button id="saveBtn6" type="submit" form="store_tab6" class="btn btn-warning"
                                        style="width: 120px;">Simpan</button>

                                    <button id="nextTabBtn" type="button" class="btn btn-light"
                                        style="width: 120px;">Seterusnya</button>

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
                                sessionStorage.setItem(`tab${i}_saved`, 'true');
                                sessionStorage.setItem("lastSavedTab", i);
                            };
                        }
                    }

                    const nextBtn = document.getElementById("nextTabBtn");
                    const backBtn = document.getElementById("backTabBtn");

                    if (nextBtn) {
                        nextBtn.onclick = () => {
                            if (currentTab === 1 || sessionStorage.getItem(`tab${currentTab}_saved`) === 'true') {
                                if (currentTab < totalTabs) {
                                    changeTab(currentTab + 1);
                                }
                            } else {
                                alert(`Sila klik butang Simpan sebelum meneruskan.`);
                            }
                        };
                    }

                    if (backBtn) {
                        backBtn.onclick = () => {
                            if (currentTab > 1) changeTab(currentTab - 1);
                        };
                    }

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

                    const printBtnContainer = document.getElementById('printButtonContainer');
                    if (printBtnContainer) {
                        printBtnContainer.style.display = currentTab === totalTabs ? 'block' : 'none';
                    }

                    const nextBtn = document.getElementById("nextTabBtn");
                    if (nextBtn) {
                        nextBtn.style.display = currentTab === totalTabs ? 'none' : 'inline-block';
                    }
                }

                function toggleTab(tab, show) {
                    const link = document.getElementById(`tab${tab}-link`);
                    const content = document.getElementById(`content-tab${tab}`);

                    if (link && content) {
                        link.classList.toggle("active", show);
                        content.classList.toggle("show", show);
                        content.classList.toggle("active", show);
                    }
                }

                function toggleSimpan(tab, show) {
                    const btn = document.getElementById(`saveBtn${tab}`);
                    if (btn) btn.style.display = show ? 'inline-block' : 'none';
                }

                function submitForm(tab) {
                    const form = document.getElementById(`store_tab${tab}`);
                    if (form) {
                        form.submit();
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

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                                                const hasVesselSelect = document.getElementById('has_vessel');
                                                const hasEngineSelect = document.getElementById('has_engine');

                                                const vesselSection = document.getElementById('vessel_section');
                                                const noVesselSection = document.getElementById('no_vessel_transport_section');
                                                const engineSection = document.getElementById('engine_section');

                                                function toggleVesselSections() {
                                                    const value = hasVesselSelect.value;
                                                    vesselSection.classList.toggle('d-none', value !== 'yes');
                                                    noVesselSection.classList.toggle('d-none', value !== 'no');
                                                    if (value !== 'yes') engineSection.classList.add('d-none');
                                                }

                                                function toggleEngineSection() {
                                                    const value = hasEngineSelect.value;
                                                    engineSection.classList.toggle('d-none', value !== 'yes');
                                                }

                                                hasVesselSelect.addEventListener('change', toggleVesselSections);
                                                hasEngineSelect.addEventListener('change', toggleEngineSection);

                                                toggleVesselSections();
                                                toggleEngineSection();
                                            });
                </script>


                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                @endpush
