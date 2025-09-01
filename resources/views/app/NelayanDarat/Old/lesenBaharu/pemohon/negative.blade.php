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
                                <a href="http://127.0.0.1:8000/lesenBaharu/permohonan-01">{{
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
                                <a class="nav-link custom-nav-link  " id="tab1-link" aria-disabled="true">Maklumat
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

                            <div class="tab-pane fade  " id="content-tab1" role="tabpanel"
                                aria-labelledby="tab1-link">
                                {{--
                                <form id="store_tab1" method="POST"
                                    action="{{ route('lesenBaharu.permohonan-01.store_tab1') }}">
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
                                                <label for="phone_number" class="form-label">Nombor Telefon</label>
                                                <input type="text" class="form-control" id="phone_number"
                                                    name="phone_number"
                                                    value="{{ old('phone_number', $userDetail->no_phone ?? '') }}"
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
                                                    value="{{ old('district', $userDetail->secondary_district_name ?? '') }}"
                                                    placeholder="Masukkan Daerah" readonly>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="state" class="form-label">Negeri</label>
                                                <input type="text" class="form-control" id="state" name="state"
                                                    value="{{ old('state', $userDetail->secondary_state_name ?? '') }}"
                                                    placeholder="Masukkan Negeri" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <br>

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
                                                    value="{{ old('secondary_district', $userDetail->district_name ?? '') }}"
                                                    placeholder="Masukkan Daerah" readonly>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="secondary_state  " class="form-label">Negeri</label>
                                                <input type="text" class="form-control" id="secondary_state  "
                                                    name="secondary_state  "
                                                    value="{{ old('secondary_state  ', $userDetail->state_name?? '') }}"
                                                    placeholder="Masukkan Negeri" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    {{--
                                </form> --}}

                            </div>
                            <div class="tab-pane fade" id="content-tab2" role="tabpanel" aria-labelledby="tab2-link">
                                <div class="mb-4">
                                    <h4 class="fw-bold mb-0">Maklumat Sebagai Nelayan</h4>
                                    <small class="text-muted">Maklumat berkaitan pengalaman dan aktiviti sebagai nelayan
                                        dipaparkan untuk semakan
                                        sahaja</small>

                                    <div class="row mt-3">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Tahun Menjadi Nelayan</label>
                                            <input type="text" class="form-control"
                                                value="{{ \Carbon\Carbon::parse($fishermanDetail->year_become_fisherman)->format('Y') ?? '-' }}"
                                                readonly>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Tempoh Menjadi Nelayan (Tahun)</label>
                                            <input type="text" class="form-control"
                                                value="{{ $fishermanDetail->becoming_fisherman_duration ?? '-' }}"
                                                readonly>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Hari Bekerja Menangkap Ikan Sebulan</label>
                                            <input type="text" class="form-control"
                                                value="{{ $fishermanDetail->working_days_fishing_per_month ?? '-' }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Pendapatan Tahunan Dari Menangkap Ikan
                                                (RM)</label>
                                            <input type="text" class="form-control"
                                                value="{{ $fishermanDetail->estimated_income_yearly_fishing ?? '-' }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <div class="mb-4">
                                    <h4 class="fw-bold mb-0">Maklumat Pekerjaan Lain</h4>
                                    <small class="text-muted">Maklumat berkaitan pekerjaan lain (jika ada)</small>

                                    <div class="row mt-3">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Pendapatan Dari Pekerjaan Lain (RM)</label>
                                            <input type="text" class="form-control"
                                                value="{{ $fishermanDetail->estimated_income_other_job ?? '-' }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Hari Bekerja Di Pekerjaan Lain Sebulan</label>
                                            <input type="text" class="form-control"
                                                value="{{ $fishermanDetail->days_working_other_job_per_month ?? '-' }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <br>

                                <div class="mb-4">
                                    <h4 class="fw-bold mb-0">Maklumat Kewangan</h4>
                                    <small class="text-muted">Maklumat bantuan dan pencen</small>

                                    <div class="row mt-3">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Menerima Pencen</label>
                                            <input type="text" class="form-control"
                                                value="{{ $fishermanDetail->receive_pension == 1 ? 'Ya' : 'Tidak' }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Pencarum KWSP</label>
                                            <input type="text" class="form-control"
                                                value="{{ $fishermanDetail->epf_contributor == 1 ? 'Ya' : 'Tidak' }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Jenis Caruman KWSP</label>
                                            <input type="text" class="form-control"
                                                value="{{ $fishermanDetail->epf_type ?? '-' }}" readonly>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Menerima Bantuan Kewangan</label>
                                            <input type="text" class="form-control"
                                                value="{{ $fishermanDetail->receive_financial_aid == 1 ? 'Ya' : 'Tidak' }}"
                                                readonly>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md mb-3">
                                            <label class="form-label">Agensi Memberi Bantuan Kewangan</label>
                                            @forelse ($aidAgencies as $agency)
                                            <input type="text" class="form-control mb-2"
                                                value="{{ $agency->agency_name }}" readonly>
                                            @empty
                                            <input type="text" class="form-control" value="Tiada agensi direkodkan"
                                                readonly>
                                            @endforelse

                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="tab-pane fade" id="content-tab3" role="tabpanel" aria-labelledby="tab3-link">
                                <h4 class="fw-bold m-0">Maklumat Jeti / Pangkalan</h4>
                                <small class="text-muted m-0">Maklumat lokasi atau kawasan jeti tempat beroperasi
                                    dipaparkan untuk semakan sahaja</small>

                                <div class="mt-3">
                                    <!-- Negeri -->
                                    <div class="mb-3">
                                        <label class="form-label">Negeri</label>
                                        <input type="text" class="form-control"
                                            value="{{ $baseDetail?->state?->name ?? 'Tiada Maklumat' }}" readonly>
                                    </div>

                                    <!-- Daerah -->
                                    <div class="mb-3">
                                        <label class="form-label">Daerah</label>
                                        <input type="text" class="form-control"
                                            value="{{ $baseDetail?->district?->name ?? 'Tiada Maklumat' }}" readonly>
                                    </div>

                                    <!-- Jeti -->
                                    <div class="mb-3">
                                        <label class="form-label">Jeti / Pangkalan</label>
                                        <input type="text" class="form-control"
                                            value="{{ $baseDetail?->jetty?->name ?? 'Tiada Maklumat' }}" readonly>
                                    </div>

                                    <!-- Sungai -->
                                    <div class="mb-3">
                                        <label class="form-label">Sungai</label>
                                        <input type="text" class="form-control"
                                            value="{{ $baseDetail?->river?->name ?? 'Tiada Maklumat' }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="content-tab4" role="tabpanel" aria-labelledby="tab4-link">
                                <form id="store_tab4" method="POST" enctype="multipart/form-data"
                                    action="{{ route('lesenBaharu.permohonan-01.store_tab4') }}">
                                    @csrf

                                    <input type="text" class="hidden" name="status" value="negative">

                                    <!-- Peralatan Utama -->
                               <section>
    <div class="mb-3">
        <h4 class="fw-bold mb-0">Peralatan Utama</h4>
        <small class="text-muted">Maklumat peralatan utama yang digunakan</small>
        <hr>
    </div>

    <div class="form-group">
        @php
            $main = $mainEquipment[0] ?? ['name' => '', 'quantity' => '', 'file_path' => null, 'original_name' => null];
        @endphp

        <div class="row mb-3 align-items-start">

            {{-- Equipment Dropdown --}}
            <div class="col-md-4">
                <label for="main_0_name" class="form-label">Peralatan <span class="text-danger">*</span></label>
                <select class="form-select" id="main_0_name" name="main[0][name]" required>
                    <option value="">Sila Pilih</option>
                    @foreach ($equipmentList as $id => $name)
                        <option value="{{ $name }}" {{ old('main.0.name', $main['name']) == $name ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Quantity Input --}}
            <div class="col-md-1">
                <label for="main_0_quantity" class="form-label">Kuantiti <span class="text-danger">*</span></label>
                <input type="number" name="main[0][quantity]" id="main_0_quantity"
                       class="form-control" min="1"
                       value="{{ old('main.0.quantity', $main['quantity']) }}" required>
            </div>

            {{-- File Upload Input --}}
            <div class="col-md">
                <label for="main_0_file" class="form-label">
                    Gambar Peralatan
                    @if (empty($main['file_path']))
                        <span class="text-danger">*</span>
                    @endif
                </label>

                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="main_0_file"
                           name="main[0][file]" accept=".jpg,.jpeg,.png,.pdf"
                           @if (empty($main['file_path'])) required @endif
                           aria-label="Muat naik gambar peralatan utama">

                    <label class="custom-file-label" for="main_0_file">
                        {{ $main['original_name'] ?? 'Pilih Fail' }}
                    </label>
                </div>

                <small class="text-muted">
                    Format dibenarkan: JPG, JPEG, PNG, PDF. Saiz maksimum: 5MB.
                </small>
            </div>

            {{-- File Preview Button --}}
            @if (!empty($main['file_path']))
                <div class="col-md-auto text-center">
                    <label class="form-label d-none d-md-block">&nbsp;</label>
                 <a type="button" class="btn btn-primary"
   onclick="window.open('{{ route('lesenBaharu.permohonan-01.viewEquipment', ['type' => 'UTAMA', 'index' => 0]) }}', 'equipmentWindow', 'width=1200,height=800,scrollbars=yes,resizable=yes'); return false;"
   aria-label="Lihat gambar peralatan utama">
    <i class="fa fa-search p-1"></i>
</a>

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
            fileLabel.innerHTML = this.files.length > 0 ? this.files[0].name : 'Pilih Fail';
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
            @php
                $item = $additionalEquipments[$i] ?? ['name' => '', 'quantity' => '', 'file_path' => null, 'original_name' => null];
            @endphp

            <div class="row mb-3 align-items-start">
                <!-- Equipment Dropdown -->
                <div class="col-md-4">
                    <label for="additional_{{ $i }}_name" class="form-label">Peralatan</label>
                    <select class="form-select" id="additional_{{ $i }}_name" name="additional[{{ $i }}][name]">
                        <option value="">Sila Pilih</option>
                        @foreach ($equipmentList as $id => $name)
                            <option value="{{ $name }}" {{ old("additional.$i.name", $item['name']) == $name ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Quantity Input -->
                <div class="col-md-1">
                    <label for="additional_{{ $i }}_quantity" class="form-label">Kuantiti</label>
                    <input type="number" name="additional[{{ $i }}][quantity]" id="additional_{{ $i }}_quantity"
                        class="form-control" min="1" value="{{ old("additional.$i.quantity", $item['quantity']) }}">
                </div>

                <!-- File Upload Input -->
                <div class="col-md">
                    <label for="additional_{{ $i }}_file" class="form-label">Gambar Peralatan</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="additional_{{ $i }}_file"
                            name="additional[{{ $i }}][file]" accept=".jpg,.jpeg,.png,.pdf">
                        <label class="custom-file-label" for="additional_{{ $i }}_file">
                            {{ $item['original_name'] ?? 'Pilih Fail' }}
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
        onclick="window.open('{{ route('lesenBaharu.permohonan-01.viewEquipment', ['type' => 'TAMBAHAN', 'index' => $i]) }}', 'tambahEquipmentWindow', 'width=1200,height=800,scrollbars=yes,resizable=yes'); return false;">
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
                                action="{{ route('lesenBaharu.permohonan-01.store_tab5') }}">
                                @csrf

                                <div class="mb-3">
                                    <h4 class="fw-bold mb-0">Maklumat Pemilikan Vesel</h4>
                                    <small class="text-muted">Sila pilih sama ada anda mempunyai vesel atau tidak</small>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Adakah anda mempunyai vesel? <span class="text-danger">*</span></label>
                                    <select name="has_vessel" id="has_vessel" class="form-select">
                                        <option value="">Pilih</option>
                                        <option value="yes" {{ old('has_vessel', $vesselData['has_vessel'] ?? '' )=='yes' ? 'selected' : '' }}>
                                            YA</option>
                                        <option value="no" {{ old('has_vessel', $vesselData['has_vessel'] ?? '' )=='no' ? 'selected' : '' }}>
                                            TIDAK</option>
                                    </select>
                                </div>

                                <div id="no_vessel_transport_section"
                                    class="{{ old('has_vessel', $vesselData['has_vessel'] ?? '') == 'no' ? '' : 'd-none' }}">
                                    <div class="mb-3">
                                        <label for="transport_type" class="form-label">Jenis Pengangkutan Digunakan <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="transport_type" id="transport_type" class="form-control"
                                            value="{{ old('transport_type', $vesselData['transport_type'] ?? '') }}"
                                            placeholder="Contoh: Jalan kaki, motosikal">
                                    </div>
                                </div>

                                <div id="vessel_section"
                                    class="{{ old('has_vessel', $vesselData['has_vessel'] ?? '') == 'yes' ? '' : 'd-none' }}">
                                    <div class="mb-3">
                                        <h4 class="fw-bold mb-0">Maklumat Vesel</h4>
                                        <small class="text-muted">Sila isikan maklumat vesel anda</small>
                                    </div>

                                    <div class="row">

                                        <div class="mb-3">
                                            <label for="has_registration_number" class="form-label">
                                                Adakah anda telah mempunyai nombor pendaftaran vesel? <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select" id="has_registration_number" name="has_registration_number" required>
                                                <option value="">Pilih</option>
                                                <option value="yes" {{ old('has_registration_number', $vesselData['has_registration_number']
                                                    ?? '' )=='yes' ? 'selected' : '' }}>YA</option>
                                                <option value="no" {{ old('has_registration_number', $vesselData['has_registration_number']
                                                    ?? '' )=='no' ? 'selected' : '' }}>TIDAK</option>
                                            </select>
                                        </div>

                                        <div class="mb-3" id="vessel_number_wrapper" style="display: none;">
                                            <label for="vessel_registration_number" class="form-label">No. Pendaftaran Vesel <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="vessel_registration_number" id="vessel_registration_number"
                                                class="form-control"
                                                value="{{ old('vessel_registration_number', $vesselData['vessel_registration_number'] ?? '') }}"
                                                placeholder="Masukkan No. Pendaftaran Vesel">
                                        </div>

                                        @push('scripts')
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function () {
                                const $dropdown = $('#has_registration_number');
                                const $wrapper = $('#vessel_number_wrapper');
                                const $input = $('#vessel_registration_number');

                                function handleToggle() {
                                    if ($dropdown.val() === 'yes') {
                                        $wrapper.slideDown();
                                        $input.prop('required', true);
                                    } else {
                                        $wrapper.slideUp();
                                        $input.prop('required', false).val('');
                                    }
                                }

                                $dropdown.on('change', handleToggle);
                                handleToggle();
                            });
                                        </script>
                                        @endpush

                                        <div class="mb-3">
                                            <label for="hull_type" class="form-label">Jenis Kulit Vesel <span
                                                    class="text-danger">*</span></label>
                                            <select name="hull_type" id="hull_type" class="form-select" required>
                                                <option value="">Pilih Jenis Kulit Vesel</option>
                                                @foreach ($hullTypes as $id => $name)
                                                <option value="{{ $name }}" {{ old('hull_type', $vesselData['hull_type'] ?? '' )==$name
                                                    ? 'selected' : '' }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="length" class="form-label">Panjang (m) <span class="text-danger">*</span></label>
                                                <input type="number" step="0.01" name="length" id="length" class="form-control"
                                                    value="{{ old('length', $vesselData['length'] ?? '') }}"
                                                    placeholder="Masukkan Panjang Vesel">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="width" class="form-label">Lebar (m) <span class="text-danger">*</span></label>
                                                <input type="number" step="0.01" name="width" id="width" class="form-control"
                                                    value="{{ old('width', $vesselData['width'] ?? '') }}" placeholder="Masukkan Lebar Vesel">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="depth" class="form-label">Kedalaman (m) <span class="text-danger">*</span></label>
                                                <input type="number" step="0.01" name="depth" id="depth" class="form-control"
                                                    value="{{ old('depth', $vesselData['depth'] ?? '') }}"
                                                    placeholder="Masukkan Kedalaman Vesel">
                                            </div>
                                        </div>

                                        <br>

                                        <div class="mb-3">
                                            <label class="form-label">Adakah vesel mempunyai enjin? <span class="text-danger">*</span> </label>
                                            <select name="has_engine" id="has_engine" class="form-select" required>
                                                <option value="">Pilih</option>
                                                <option value="yes" {{ old('has_engine', $vesselData['has_engine'] ?? '' )=='yes' ? 'selected'
                                                    : '' }}>YA</option>
                                                <option value="no" {{ old('has_engine', $vesselData['has_engine'] ?? '' )=='no' ? 'selected'
                                                    : '' }}>TIDAK</option>
                                            </select>
                                        </div>

                                        <div id="engine_section"
                                            class="{{ old('has_engine', $vesselData['has_engine'] ?? '') == 'yes' ? '' : 'd-none' }}">
                                            <div class="mb-3">
                                                <h4 class="fw-bold mb-0">Maklumat Enjin</h4>
                                                <small class="text-muted">Isikan maklumat enjin vesel anda jika ada</small>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="engine_brand" class="form-label">Jenama Enjin <span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-select" id="engine_brand" name="engine_brand" required>
                                                        <option value="">Sila Pilih</option>
                                                        @foreach ($engineBrandList as $id => $name)
                                                        <option value="{{ $name }}" {{ old('engine_brand', $vesselData['engine_brand'] ?? ''
                                                            )==$name ? 'selected' : '' }}>{{ $name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md mb-3">
                                                    <label for="engine_model" class="form-label">Model Enjin <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="engine_model" id="engine_model" class="form-control"
                                                        value="{{ old('engine_model', $vesselData['engine_model'] ?? '') }}"
                                                        placeholder="Contoh: Yamaha 150HP">
                                                </div>
                                                <div class="col-md">
                                                    <label for="engine_power" class="form-label">Kuasa Kuda (KK) <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="engine_power" id="engine_power" class="form-control"
                                                        value="{{ old('engine_power', $vesselData['horsepower'] ?? '') }}"
                                                        placeholder="Contoh: 150HP">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                      {{-- <div class="tab-pane fade" id="content-tab6" role="tabpanel" aria-labelledby="tab6-link">
                        <form method="POST" id="store_tab6" action="{{ route('lesenBaharu.permohonan-01.store_tab6') }}"
                            enctype="multipart/form-data">
                            @csrf

                            <section>
                                <h4 class="fw-bold m-0">Muat Naik Dokumen Permohonan</h4>
                                <small class="text-muted d-block mb-3">Sila muat naik gambar vesel dan enjin.</small>

                                <!-- Gambar Vesel -->
                                @php
                                $vesselDoc = collect($documentsData ?? [])->firstWhere('title', 'Gambar Vesel');
                                @endphp

                                <div class="mb-4">
                                    <label for="vessel_picture" class="form-label">Gambar Vesel</label>

                                    <div class="d-flex align-items-center gap-2">
                                        <div style="flex-grow: 1;">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="vessel_picture" name="vessel_picture"
                                                    accept=".jpg,.jpeg,.png">
                                                <label class="custom-file-label" for="vessel_picture">
                                                    {{ $vesselDoc['original_name'] ?? 'Pilih Fail' }}
                                                </label>
                                            </div>
                                        </div>

                                        @if (!empty($vesselDoc['file_path']))
                                        <a class="btn btn-primary  "
                                            href="{{ route('lesenBaharu.permohonan-01.viewDocument', ['type' => 'required', 'index' => array_search($vesselDoc, $documentsData)]) }}"
                                            target="_blank">
                                            <i class="fa fa-search p-1"></i>
                                        </a>
                                        @endif
                                    </div>

                                    <small class="text-muted">Format dibenarkan: JPG, JPEG, PNG. Saiz maksimum: 2MB.</small>
                                </div>

                                <!-- Gambar Enjin -->
                                @php
                                $engineDoc = collect($documentsData ?? [])->firstWhere('title', 'Gambar Enjin');
                                @endphp
                                <!-- Gambar Enjin -->
                                <div class="mb-4">
                                    <label for="engine_picture" class="form-label">Gambar Enjin</label>

                                    <div class="d-flex align-items-center gap-2">
                                        <div style="flex-grow: 1;">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="engine_picture" name="engine_picture"
                                                    accept=".jpg,.jpeg,.png">
                                                <label class="custom-file-label" for="engine_picture">
                                                    {{ $engineDoc['original_name'] ?? 'Pilih Fail' }}
                                                </label>
                                            </div>
                                        </div>

                                        @if (!empty($engineDoc['file_path']))
                                        <a class="btn btn-primary "
                                            href="{{ route('lesenBaharu.permohonan-01.viewDocument', ['type' => 'required', 'index' => array_search($engineDoc, $documentsData)]) }}"
                                            target="_blank">
                                            <i class="fa fa-search p-1"></i>
                                        </a>
                                        @endif
                                    </div>

                                    <small class="text-muted">Format dibenarkan: JPG, JPEG, PNG. Saiz maksimum: 2MB.</small>
                                </div>

                            </section>
                        </form>

                        @push('scripts')
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                                                        const updateLabel = (inputId) => {
                                                                            const input = document.getElementById(inputId);
                                                                            const label = input?.nextElementSibling;
                                                                            if (input && label) {
                                                                                input.addEventListener('change', function () {
                                                                                    label.textContent = this.files.length > 0 ? this.files[0].name : 'Pilih Fail';
                                                                                });
                                                                            }
                                                                        };

                                                                        updateLabel('vessel_picture');
                                                                        updateLabel('engine_picture');
                                                                    });
                        </script>
                        @endpush
                    </div> --}}

                    <div class="tab-pane fade" id="content-tab6" role="tabpanel" aria-labelledby="tab6-link">
    <form method="POST" id="store_tab6" action="{{ route('kadPendaftaran.permohonan-08.store_tab6') }}" enctype="multipart/form-data">
    @csrf

    <section>
        <h4 class="fw-bold m-0">Muat Naik Gambar Berkaitan</h4>
        <small class="text-muted d-block mb-3">
            Gambar di bawah adalah pilihan dan hanya perlu dimuat naik jika berkaitan.
        </small>

      {{-- Gambar Vesel --}}
@php
    $vesselDoc = collect($documentsData ?? [])->firstWhere('title', 'Gambar Vesel');
@endphp

<div class="mb-4">
    <label for="vessel_picture" class="form-label">Gambar Vesel</label>

    <div class="d-flex align-items-center gap-2">
        <div style="flex-grow: 1;">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="vessel_picture" name="vessel_picture"
                    accept=".jpg,.jpeg,.png,.pdf">
                <label class="custom-file-label" for="vessel_picture">
                    {{ $vesselDoc['original_name'] ?? 'Pilih Fail' }}
                </label>
            </div>
        </div>

        @if (!empty($vesselDoc['file_path']))
        <a href="#" class="btn btn-primary"
   onclick="window.open('{{ route('lesenBaharu.permohonan-01.viewTempDocument', ['title' => 'Gambar Vesel']) }}', 'vesselImageWindow', 'width=1200,height=800,scrollbars=yes,resizable=yes'); return false;">
   <i class="fa fa-search p-1"></i>
</a>

        @endif
    </div>

    <small class="text-muted">Format dibenarkan: JPG, JPEG, PNG, PDF. Saiz maksimum: 2MB.</small>
</div>

        {{-- Gambar Enjin --}}
        @php
            $engineDoc = collect($documentsData ?? [])->firstWhere('title', 'Gambar Enjin');
        @endphp

        <div class="mb-4">
            <label for="engine_picture" class="form-label">Gambar Enjin</label>

            <div class="d-flex align-items-center gap-2">
                <div style="flex-grow: 1;">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="engine_picture" name="engine_picture"
                            accept=".jpg,.jpeg,.png,.pdf">
                        <label class="custom-file-label" for="engine_picture">
                            {{ $engineDoc['original_name'] ?? 'Pilih Fail' }}
                        </label>
                    </div>
                </div>

                @if (!empty($engineDoc['file_path']))

                       <a href="#" class="btn btn-primary"
   onclick="window.open('{{ route('lesenBaharu.permohonan-01.viewTempDocument', ['title' => 'Gambar Enjin']) }}', 'engineImageWindow', 'width=1200,height=800,scrollbars=yes,resizable=yes'); return false;">
   <i class="fa fa-search p-1"></i>
</a>

                @endif
            </div>

            <small class="text-muted">Format dibenarkan: JPG, JPEG, PNG, PDF. Saiz maksimum: 2MB.</small>
        </div>
    </section>
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const updateLabel = (inputId) => {
            const input = document.getElementById(inputId);
            const label = input?.nextElementSibling;
            if (input && label) {
                input.addEventListener('change', function () {
                    label.textContent = this.files.length > 0 ? this.files[0].name : 'Pilih Fail';
                });
            }
        };

        updateLabel('vessel_picture');
        updateLabel('engine_picture');
    });
</script>
@endpush

</div>

                            <div class="tab-pane fade" id="content-tab7" role="tabpanel" aria-labelledby="tab7-link">
                              <form id="submitPermohonan" method="POST" enctype="multipart/form-data"
    action="{{ route('lesenBaharu.permohonan-01.submitNegativeFeedback', ['id' => $application->id]) }}"
    onsubmit="sessionStorage.clear();">
    @csrf


                                    <!-- Perakuan Checkbox -->
                                    <div class="form-check mt-4 mb-4 text-center">
                                        <input class="form-check-input" type="checkbox" id="declarationCheckbox"
                                            name="declaration">
                                        <label class="form-check-label fw-semibold text-secondary"
                                            for="declarationCheckbox">
                                            Saya dengan ini mengakui dan mengesahkan bahawa semua maklumat yang
                                            diberikan oleh saya adalah benar.
                                            Sekiranya terdapat maklumat yang tidak benar, pihak Jabatan boleh menolak
                                            permohonan saya dan tindakan
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

                    {{-- <script>
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
                if (i >= 4) {
                    // Tabs 4 and above require save button
                    btn.style.display = i === currentTab ? 'inline-block' : 'none';
                    btn.onclick = () => {
                        submitForm(i);
                        sessionStorage.setItem(`tab${i}_saved`, 'true');
                        sessionStorage.setItem("lastSavedTab", i);
                    };
                } else {
                    // Tabs 1-3: hide save button (not required)
                    btn.style.display = 'none';
                }
            }
        }

        const nextBtn = document.getElementById("nextTabBtn");
        const backBtn = document.getElementById("backTabBtn");

        if (nextBtn) {
            nextBtn.onclick = () => {
                // Allow next if tab < 4, or tab has been saved
                if (currentTab < 4 || sessionStorage.getItem(`tab${currentTab}_saved`) === 'true') {
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
        if (btn && tab >= 4) {
            btn.style.display = show ? 'inline-block' : 'none';
        }
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
                    </script> --}}

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
                if (i >= 4) {
                    // Tabs 4 and above require save button
                    btn.style.display = i === currentTab ? 'inline-block' : 'none';
                    btn.onclick = () => {
                        submitForm(i);
                        sessionStorage.setItem(`tab${i}_saved`, 'true');
                        sessionStorage.setItem("lastSavedTab", i);
                    };
                } else {
                    btn.style.display = 'none';
                }
            }
        }

        const nextBtn = document.getElementById("nextTabBtn");
        const backBtn = document.getElementById("backTabBtn");

        if (nextBtn) {
            nextBtn.onclick = () => {
                if (currentTab < 4 || sessionStorage.getItem(`tab${currentTab}_saved`) === 'true') {
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

        // Show/hide print button on last tab
        const printBtnContainer = document.getElementById('printButtonContainer');
        if (printBtnContainer) {
            printBtnContainer.style.display = currentTab === totalTabs ? 'block' : 'none';
        }

        // Show/hide "Seterusnya" button
        const nextBtn = document.getElementById("nextTabBtn");
        if (nextBtn) {
            nextBtn.style.display = currentTab === totalTabs ? 'none' : 'inline-block';
        }

        // Show/hide "Kembali" button
        const backBtn = document.getElementById("backTabBtn");
        if (backBtn) {
            backBtn.style.display = currentTab === 1 ? 'none' : 'inline-block';
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
        if (btn && tab >= 4) {
            btn.style.display = show ? 'inline-block' : 'none';
        }
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
            changeTab(1); // Default to tab 1 if none saved
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
