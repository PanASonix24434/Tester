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
                                <a class="nav-link custom-nav-link" id="tab7-link" aria-disabled="true">Pelupusan</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link custom-nav-link" id="tab8-link" aria-disabled="true">Perakuan</a>

                            </li>
                        </ul>

                    </div>

                    <div class="card-body">

                        <div class="tab-content" id="pills-tabContent">

                            <div class="tab-pane fade show active" id="content-tab1" role="tabpanel"
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
                            <div class="tab-pane fade" id="content-tab2" role="tabpanel" aria-labelledby="tab2-link">
                                <div class="mb-4">
                                    <div class="mb-3">
                                        <h5 class="fw-bold mb-0">Maklumat Sebagai Nelayan</h5>
                                        <small class="text-muted">Maklumat berkaitan pengalaman dan aktiviti sebagai
                                            nelayan yang telah direkodkan dipaparkan untuk semakan sahaja.</small>
                                        <hr>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Tahun Menjadi Nelayan</label>
                                            <input type="text" class="form-control"
                                                value="{{ $fishermanDetail->year_become_fisherman ?? '-' }}" readonly>
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
                                    <div class="mb-3">
                                        <h5 class="fw-bold mb-0">Maklumat Pekerjaan Lain</h5>
                                        <small class="text-muted">Maklumat berkaitan pekerjaan lain (jika ada) yang
                                            telah direkodkan dipaparkan untuk semakan sahaja.</small>
                                        <hr>
                                    </div>

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
                                    <div class="mb-3">
                                        <h5 class="fw-bold mb-0">Maklumat Kewangan</h5>
                                        <small class="text-muted">Maklumat bantuan dan pencen yang telah direkodkan
                                            dipaparkan untuk semakan sahaja.</small>
                                        <hr>
                                    </div>

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
                                                value="{{ $agency->agency_name ?? '-' }}" readonly>
                                            @empty
                                            <input type="text" class="form-control" value="Tiada agensi direkodkan"
                                                readonly>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="content-tab3" role="tabpanel" aria-labelledby="tab3-link">
                                <div class="mb-3">
                                    <h5 class="fw-bold mb-0">Maklumat Jeti / Pangkalan</h5>
                                    <small class="text-muted">Maklumat lokasi atau kawasan jeti tempat beroperasi yang
                                        telah direkodkan dipaparkan untuk semakan sahaja.</small>
                                    <hr>
                                </div>

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

                                <section>
                                    @if($equipmentGroupLatest)

                                    <div class="mb-3">
                                        <h5 class="fw-bold mb-0">Peralatan Menangkap Ikan</h5>
                                        <small class="text-muted">Berikut adalah senarai peralatan yang telah direkodkan
                                            di bawah permohonan terkini anda.</small>
                                        <hr>
                                    </div>

                                    <table class="table ">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 5%">Bil</th>
                                                <th class="col-md-7">Nama Peralatan</th>
                                                <th class="col-md-2">Jenis</th>
                                                <th class="col-md-1">Kuantiti</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($equipmentGroupLatest as $index => $equipment)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <input type="text" class="form-control"
                                                        value="{{ $equipment->name ?? '-' }}" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control"
                                                        value="{{ $equipment->type ?? '-' }}" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control"
                                                        value="{{ $equipment->quantity ?? '-' }}" readonly>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                    <div class="alert alert-info">
                                        Tiada data peralatan untuk dipaparkan.
                                    </div>
                                    @endif

                                </section>

                            </div>

                            <div class="tab-pane fade" id="content-tab5" role="tabpanel" aria-labelledby="tab5-link">
                                <div class="mb-3">
                                    <h5 class="fw-bold mb-0">Maklumat Pemilikan Vesel</h5>
                                    <small class="text-muted">Maklumat pemilikan vesel yang telah direkodkan dipaparkan
                                        untuk semakan sahaja.</small>
                                    <hr>
                                </div>

                                <section class="mb-4">
                                    <div class="mb-4">
                                        <label class="form-label">Adakah anda mempunyai vesel?</label>
                                        <select class="form-select" disabled>
                                            <option value="1" {{ ($vessel->own_vessel ?? null) == 1 ? 'selected' : ''
                                                }}>YA</option>
                                            <option value="0" {{ ($vessel->own_vessel ?? null) == 0 ? 'selected' : ''
                                                }}>TIDAK</option>
                                        </select>
                                    </div>

                                    @if (($vessel->own_vessel ?? null) == 0 || !empty($vessel->transport_type))
                                    <div class="mb-3">
                                        <label class="form-label">Jenis Pengangkutan Digunakan</label>
                                        <input type="text" class="form-control"
                                            value="{{ $vessel->transport_type ?? '-' }}" readonly>
                                    </div>
                                    @endif

                                    <div class="mb-3">
                                        <label class="form-label">Nombor Pendaftaran Vesel</label>
                                        <input type="text" class="form-control"
                                            value="{{ $vessel->registration_number ?? '-' }}" readonly>
                                    </div>
                                </section>

                                @if (($vessel->own_vessel ?? null) == 1)

                                <section class="mb-4">
                                    <div class="mb-3">
                                        <h5 class="fw-bold mb-0">Maklumat Kulit Vesel</h5>
                                        <small class="text-muted">Maklumat berkaitan jenis dan dimensi kulit vesel yang
                                            telah direkodkan dipaparkan untuk semakan sahaja.</small>
                                        <hr>
                                    </div>

                                    @if ($hull = $user->hull ?? null)
                                    <div class="mb-3">
                                        <label class="form-label">Jenis Kulit</label>
                                        <input type="text" class="form-control" value="{{ $hull->hull_type ?? '-' }}"
                                            readonly>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Panjang (m)</label>
                                            <input type="text" class="form-control" value="{{ $hull->length ?? '-' }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Lebar (m)</label>
                                            <input type="text" class="form-control" value="{{ $hull->width ?? '-' }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Dalam (m)</label>
                                            <input type="text" class="form-control" value="{{ $hull->depth ?? '-' }}"
                                                readonly>
                                        </div>
                                    </div>
                                    @else
                                    <div class="alert text-center">Maklumat tidak diketahui.</div>
                                    @endif
                                </section>

                                <section class="mb-4">
                                    <div class="mb-3">
                                        <h5 class="fw-bold mb-0">Maklumat Enjin Vesel</h5>
                                        <small class="text-muted">Maklumat enjin sedia ada dipaparkan di bawah.
                                            Sekiranya anda ingin mengemaskini maklumat enjin, sila isikan maklumat baru
                                            dalam ruangan yang disediakan.</small>
                                        <hr>
                                    </div>

                                    @if ($engine = $user->engine ?? null)
                                    <!-- Display-only engine info -->

                                    <div class="mb-3">
                                        <h5>Maklumat Enjin Semasa</h5>
                                        <small>Bahagian ini memaparkan maklumat enjin yang sedang digunakan oleh
                                            pemohon.</small>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Jenama Enjin (Asal)</label>
                                            <input type="text" class="form-control bg-light"
                                                value="{{ $engine->brand ?? '-' }}" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Model Enjin (Asal)</label>
                                            <input type="text" class="form-control bg-light"
                                                value="{{ $engine->model ?? '-' }}" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Kuasa Kuda (KK) (Asal)</label>
                                            <input type="text" class="form-control bg-light"
                                                value="{{ $engine->horsepower ?? '-' }}" readonly>
                                        </div>
                                    </div>
                                    <br>

                                    @else
                                    <div class="alert alert-warning text-center">Maklumat tidak diketahui. </div>
                                    @endif
                                </section>

                                @endif
                            </div>

                           @php
    $vesselPictureDoc = collect($documentsTemp)->firstWhere('title', 'Gambar Vesel');
@endphp

<div class="tab-pane fade" id="content-tab6" role="tabpanel" aria-labelledby="tab6-link">
    <form method="POST" id="store_tab6"
        action="{{ route('gantiKulit.permohonan-06.store_tab6') }}"
        enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="jenisPermohonan" value="gantiKulit">

        <section>
            <div class="mb-3">
                <h5 class="fw-bold m-0">Muat Naik Gambar Vesel</h5>
                <small class="text-muted d-block mb-3">Sila muat naik satu gambar vesel.</small>
                <hr>
            </div>

            {{-- Gambar Vesel --}}
            <div class="mb-4">
                <label for="vesselPicture" class="form-label">Gambar Vesel <span class="text-danger">*</span></label>
                <div class="d-flex align-items-center gap-2">
                    <div style="flex-grow: 1;">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="vesselPicture"
                                name="vesselPicture" accept=".jpg,.jpeg,.png,.pdf" required>
                            <label class="custom-file-label" for="vesselPicture">
                                {{ isset($vesselPictureDoc['file_path']) ? basename($vesselPictureDoc['file_path']) : 'Pilih Fail' }}
                            </label>
                        </div>
                        @error('vesselPicture')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    @if (!empty($vesselPictureDoc['file_path']))
                    <a class="btn btn-primary"
                        href="{{ route('gantiKulit.permohonan-06.viewDocument', ['type' => 'required', 'index' => array_search($vesselPictureDoc, $documentsTemp)]) }}"
                        target="_blank">
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
            const input = document.getElementById('vesselPicture');
            const label = input?.nextElementSibling;
            if (input && label) {
                input.addEventListener('change', function () {
                    label.textContent = this.files.length > 0 ? this.files[0].name : 'Pilih Fail';
                });
            }
        });
    </script>
    @endpush
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
                            name="main_disposal_action" id="action_jual" value="jual"
                            {{ old('main_disposal_action', $disposeTemp['main_disposal_action'] ?? '') === 'jual' ? 'checked' : '' }}>
                        <label class="form-check-label" for="action_jual">Jual Vesel</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"
                            name="main_disposal_action" id="action_lupus" value="lupus"
                            {{ old('main_disposal_action', $disposeTemp['main_disposal_action'] ?? '') === 'lupus' ? 'checked' : '' }}>
                        <label class="form-check-label" for="action_lupus">Lupus & Tamat Lesen</label>
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
                                {{ old('disposal_type', $disposeTemp['disposal_type'] ?? '') === 'dalam_industri' ? 'checked' : '' }}>
                            <label class="form-check-label" for="jual_dalam">Jualan Dalam Industri</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio"
                                name="disposal_type" id="jual_luar" value="luar_industri"
                                {{ old('disposal_type', $disposeTemp['disposal_type'] ?? '') === 'luar_industri' ? 'checked' : '' }}>
                            <label class="form-check-label" for="jual_luar">Jualan Luar Industri</label>
                        </div>
                    </div>
                </div>

                <hr>

                <h5 class="fw-bold mb-2">Maklumat Pemilik Baharu</h5>
                <small class="text-muted d-block mb-3">Sila isikan maklumat pemilik baharu vesel ini.</small>

                <div class="mb-3">
                    <label class="form-label">Nama Pemilik Baharu</label>
                    <input type="text" name="new_owner_name" class="form-control"
                        value="{{ old('new_owner_name', $disposeTemp['new_owner_name'] ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">No. Telefon Pemilik Baharu</label>
                    <input type="text" name="new_owner_phone" class="form-control"
                        value="{{ old('new_owner_phone', $disposeTemp['new_owner_phone'] ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">No. Kad Pengenalan Pemilik Baharu</label>
                    <input type="text" name="new_owner_ic" class="form-control"
                        value="{{ old('new_owner_ic', $disposeTemp['new_owner_ic'] ?? '') }}">
                </div>
            </div>
        </section>

        <br>
    </form>

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
</div>




                            <div class="tab-pane fade" id="content-tab8" role="tabpanel" aria-labelledby="tab8-link">
                                <form id="submitPermohonan" method="POST" enctype="multipart/form-data"
                                    action="{{ route('gantiKulit.permohonan-06.store') }}"
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
                                            Sekiranya terdapat maklumat yang tidak benar, pihak Jabatan boleh
                                            menolak
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
                                    <!-- Left: Print Button (if any) -->
                                    <div class="m-0 mb-2"></div>

                                    <!-- Right: Navigation Buttons -->
                                    <div class="d-flex justify-content-end mb-2 flex-wrap gap-2">
                                        <button id="backTabBtn" type="button" class="btn btn-light"
                                            style="width: 120px;">Kembali</button>
                                        {{-- <button id="saveBtn5" type="submit" form="store_tab5"
                                            class="btn btn-warning" style="width: 120px; display: none;">Simpan</button>
                                        --}}
                                        <button id="saveBtn6" type="submit" form="store_tab6" class="btn btn-warning"
                                            style="width: 120px; display: none;">Simpan</button>
                                        <button id="saveBtn7" type="submit" form="store_tab7" class="btn btn-warning"
                                            style="width: 120px; display: none;">Simpan</button>

                                        <button id="nextTabBtn" type="button" class="btn btn-light"
                                            style="width: 120px;">Seterusnya</button>

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
  document.addEventListener("DOMContentLoaded", () => {
    let currentTab = 1;
    const totalTabs = 8;
    const tabsWithSaveRequirement = [6, 7]; // Tabs that require "Simpan" before proceeding

    // Restore last tab from sessionStorage
    const lastTab = parseInt(sessionStorage.getItem("lastTab"), 10);
    if (lastTab >= 1 && lastTab <= totalTabs) {
      currentTab = lastTab;
    }

    activateTab(currentTab);
    updateButtons();

    // Navigation button handlers
    document.getElementById("nextTabBtn").addEventListener("click", handleNext);
    document.getElementById("backTabBtn").addEventListener("click", handleBack);

    // Setup "Simpan" button handlers for tabs 6 & 7
    tabsWithSaveRequirement.forEach(tabNum => {
      const btn = document.getElementById(`saveBtn${tabNum}`);
      if (btn) {
        btn.addEventListener("click", () => {
          submitForm(tabNum);
          sessionStorage.setItem(`tab${tabNum}_saved`, "true");
          sessionStorage.setItem("lastTab", tabNum);
          updateButtons();
        });
      }
    });

    // On full page load (in case DOMContentLoaded already fired)
    window.addEventListener("load", () => {
      const savedLast = parseInt(sessionStorage.getItem("lastTab"), 10);
      if (savedLast >= 1 && savedLast <= totalTabs) {
        currentTab = savedLast;
      } else {
        currentTab = 1;
      }
      activateTab(currentTab);
      updateButtons();
    });

    function handleNext() {
      // If current tab requires saving, enforce it
      if (tabsWithSaveRequirement.includes(currentTab)) {
        const saved = sessionStorage.getItem(`tab${currentTab}_saved`);
        if (saved !== "true") {
          return alert("Sila klik butang Simpan sebelum meneruskan.");
        }
      }

      if (currentTab < totalTabs) {
        currentTab++;
        sessionStorage.setItem("lastTab", currentTab);
        activateTab(currentTab);
        updateButtons();
      }
    }

    function handleBack() {
      if (currentTab > 1) {
        currentTab--;
        sessionStorage.setItem("lastTab", currentTab);
        activateTab(currentTab);
        updateButtons();
      }
    }

    function activateTab(tabNumber) {
      for (let i = 1; i <= totalTabs; i++) {
        const link = document.getElementById(`tab${i}-link`);
        const content = document.getElementById(`content-tab${i}`);
        const isActive = (i === tabNumber);

        if (link) link.classList.toggle("active", isActive);
        if (content) {
          content.classList.toggle("show", isActive);
          content.classList.toggle("active", isActive);
        }
      }
    }

    function updateButtons() {
      const nextBtn = document.getElementById("nextTabBtn");
      const backBtn = document.getElementById("backTabBtn");

      // Show/hide Next & Back
      nextBtn.style.display = (currentTab === totalTabs ? "none" : "inline-block");
      backBtn.style.display = (currentTab === 1 ? "none" : "inline-block");

      // Show “Simpan” only on tabs 6 & 7 when active
      for (let i = 1; i <= totalTabs; i++) {
        const simpanBtn = document.getElementById(`saveBtn${i}`);
        if (simpanBtn) {
          simpanBtn.style.display =
            (tabsWithSaveRequirement.includes(i) && currentTab === i)
              ? "inline-block"
              : "none";
        }
      }


    function submitForm(tabNum) {
      const form = document.getElementById(`store_tab${tabNum}`);
      if (form) form.submit();
    }
  });
</script>


                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                    @endpush
