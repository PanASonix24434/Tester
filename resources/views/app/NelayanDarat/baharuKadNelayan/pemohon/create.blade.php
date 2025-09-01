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
                                <a href="http://127.0.0.1:8000/baharuKadNelayan/permohonan-09">{{
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
                            {{-- <li class="nav-item">
                                <a class="nav-link custom-nav-link" id="tab6-link" aria-disabled="true">Dokumen
                                    Sokongan</a>
                            </li> --}}

                            <li class="nav-item">
                                {{-- <a class="nav-link custom-nav-link" id="tab7-link"
                                    aria-disabled="true">Perakuan</a> --}}
                                <a class="nav-link custom-nav-link" id="tab6-link" aria-disabled="true">Perakuan</a>
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
                                                value="{{ old('address', trim(($userDetail->address1 ?? '') . ' ,' . ($userDetail->address2 ?? '') . ' ,' . ($userDetail->address3 ?? ''))) }}"
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

                                     <div class="mb-3">
                                        <h5 class="fw-bold mb-0">Peralatan Menangkap Ikan</h5>
                                        <small class="text-muted">Berikut adalah senarai peralatan yang telah direkodkan
                                            di bawah permohonan terkini anda.</small>
                                        <hr>
                                    </div>
                                    @if($equipmentGroupLatest)



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

                                        Tiada data peralatan untuk dipaparkan.


                                    @endif

                                </section>
<br>
                            </div>

                            {{-- <div class="tab-pane fade" id="content-tab5" role="tabpanel"
                                aria-labelledby="tab5-link">

                                <div class="mb-3">
                                    <h5 class="fw-bold mb-0">Maklumat Pemilikan Vesel</h5>
                                    <small class="text-muted">Maklumat pemilikan vesel yang telah direkodkan dipaparkan
                                        untuk semakan sahaja.</small>
                                    <hr>
                                </div>

                                <section>
                                    <div class="mb-4">
                                        <label class="form-label">Adakah anda mempunyai vesel?</label>
                                        <select class="form-select" disabled>
                                            <option value="1" {{ ($vessel->own_vessel ?? null) == 1 ? 'selected' : ''
                                                }}>YA
                                            </option>
                                            <option value="0" {{ ($vessel->own_vessel ?? null) == 0 ? 'selected' : ''
                                                }}>TIDAK</option>
                                        </select>
                                    </div>

                                    <div id="no_vessel_transport_section"
                                        class="{{ ($vessel->own_vessel ?? null) == 0 ? '' : 'd-none' }}">
                                        <div class="mb-3">
                                            <label class="form-label">Jenis Pengangkutan Digunakan</label>
                                            <input type="text" class="form-control"
                                                value="{{ $vessel->transport_type ?? '-' }}" readonly>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Nombor Pendaftaran Vesel</label>
                                        <input type="text" class="form-control"
                                            value="{{ $vessel->registration_number ?? '-' }}" readonly>
                                    </div>
                                </section>

                                <section class="mb-4">
                                    <div class="mb-3">
                                        <h5 class="fw-bold mb-0">Maklumat Hull Vesel</h5>
                                        <small class="text-muted">Maklumat berkaitan jenis dan dimensi hull vesel yang
                                            telah direkodkan dipaparkan untuk semakan sahaja.</small>
                                        <hr>
                                    </div>

                                    @if ($hull = $user->hull ?? null)
                                    <div class="mb-3">
                                        <label class="form-label">Jenis Hull</label>
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
                                    <div class="alert text-center">Maklumat tidak direkodkan.</div>
                                    @endif
                                </section>

                                <section class="mb-4">
                                    <div class="mb-3">
                                        <h5 class="fw-bold mb-0">Maklumat Enjin Vesel</h5>
                                        <small class="text-muted">Maklumat berkaitan enjin vesel yang telah direkodkan
                                            dipaparkan untuk semakan sahaja.</small>
                                        <hr>
                                    </div>

                                    @if ($engine = $user->engine ?? null)
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Jenama Enjin</label>
                                            <input type="text" class="form-control" value="{{ $engine->brand ?? '-' }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Model Enjin</label>
                                            <input type="text" class="form-control" value="{{ $engine->model ?? '-' }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Kuasa Kuda (KK)</label>
                                            <input type="text" class="form-control"
                                                value="{{ $engine->horsepower ?? '-' }}" readonly>
                                        </div>
                                    </div>
                                    @else
                                    <div class="alert text-center">Maklumat tidak direkodkan.</div>
                                    @endif
                                </section>

                            </div> --}}

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
                                        <small class="text-muted">Maklumat berkaitan enjin vesel yang telah direkodkan
                                            dipaparkan untuk semakan sahaja.</small>
                                        <hr>
                                    </div>

                                    @if ($engine = $user->engine ?? null)
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Jenama Enjin</label>
                                            <input type="text" class="form-control" value="{{ $engine->brand ?? '-' }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Model Enjin</label>
                                            <input type="text" class="form-control" value="{{ $engine->model ?? '-' }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Kuasa Kuda (KK)</label>
                                            <input type="text" class="form-control"
                                                value="{{ $engine->horsepower ?? '-' }}" readonly>
                                        </div>
                                    </div>
                                    @else
                                    <div class="alert text-center">Maklumat tidak diketahui.</div>
                                    @endif
                                </section>
                                @endif
                            </div>


                            {{-- <div class="tab-pane fade" id="content-tab6" role="tabpanel"
                                aria-labelledby="tab6-link">
                                <form method="POST" id="store_tab6"
                                    action="{{ route('baharuKadNelayan.permohonan-09.store_tab6') }}"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <section>
                                        <h5 class="fw-bold m-0">Muat Naik Dokumen Permohonan</h5>
                                        <small class="text-muted d-block mb-3">Sila muat naik gambar vesel dan
                                            enjin.</small>

                                        <!-- Gambar Vesel -->
                                        @php
                                        $vesselDoc = collect($documentsData ?? [])->firstWhere('title', 'Gambar Vesel');
                                        @endphp

                                        <div class="mb-4">
                                            <label for="vessel_picture" class="form-label">Gambar Vesel</label>

                                            <div class="d-flex align-items-center gap-2">
                                                <div style="flex-grow: 1;">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="vessel_picture"
                                                            name="vessel_picture" accept=".jpg,.jpeg,.png">
                                                        <label class="custom-file-label" for="vessel_picture">
                                                            {{ $vesselDoc['original_name'] ?? 'Pilih Fail' }}
                                                        </label>
                                                    </div>
                                                </div>

                                                @if (!empty($vesselDoc['file_path']))
                                                <a class="btn btn-primary  "
                                                    href="{{ route('baharuKadNelayan.permohonan-09.viewDocument', ['type' => 'required', 'index' => array_search($vesselDoc, $documentsData)]) }}"
                                                    target="_blank">
                                                    <i class="fa fa-search p-1"></i>
                                                </a>
                                                @endif
                                            </div>

                                            <small class="text-muted">Format dibenarkan: JPG, JPEG, PNG. Saiz maksimum:
                                                2MB.</small>
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
                                                        <input type="file" class="custom-file-input" id="engine_picture"
                                                            name="engine_picture" accept=".jpg,.jpeg,.png">
                                                        <label class="custom-file-label" for="engine_picture">
                                                            {{ $engineDoc['original_name'] ?? 'Pilih Fail' }}
                                                        </label>
                                                    </div>
                                                </div>

                                                @if (!empty($engineDoc['file_path']))
                                                <a class="btn btn-primary "
                                                    href="{{ route('baharuKadNelayan.permohonan-09.viewDocument', ['type' => 'required', 'index' => array_search($engineDoc, $documentsData)]) }}"
                                                    target="_blank">
                                                    <i class="fa fa-search p-1"></i>
                                                </a>
                                                @endif
                                            </div>

                                            <small class="text-muted">Format dibenarkan: JPG, JPEG, PNG. Saiz maksimum:
                                                2MB.</small>
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
                                {{-- <div class="tab-pane fade" id="content-tab7" role="tabpanel"
                                    aria-labelledby="tab7-link"> --}}
                                    <form id="submitPermohonan" method="POST" enctype="multipart/form-data"
                                        action="{{ route('baharuKadNelayan.permohonan-09.store') }}"
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
                                        <!-- Left: Print Button -->
                                        <div class="m-0 mb-2">

                                        </div>

                                        <!-- Right: Navigation Buttons -->
                                        <div class="d-flex justify-content-end mb-2 flex-wrap gap-2">
                                            <button id="backTabBtn" type="button" class="btn btn-light"
                                                style="width: 120px;">Kembali</button>

                                            {{-- <button id="saveBtn2" type="submit" form="store_tab2"
                                                class="btn btn-warning" style="width: 120px;">Simpan</button>
                                            <button id="saveBtn3" type="submit" form="store_tab3"
                                                class="btn btn-warning" style="width: 120px;">Simpan</button>
                                            <button id="saveBtn4" type="submit" form="store_tab4"
                                                class="btn btn-warning" style="width: 120px;">Simpan</button>
                                            <button id="saveBtn5" type="submit" form="store_tab5"
                                                class="btn btn-warning" style="width: 120px;">Simpan</button>
                                            <button id="saveBtn6" type="submit" form="store_tab6"
                                                class="btn btn-warning" style="width: 120px;">Simpan</button> --}}

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
                if (i === 6) {
                    // Only tab 6 requires save button
                    btn.style.display = i === currentTab ? 'inline-block' : 'none';
                    btn.onclick = () => {
                        submitForm(i);
                        sessionStorage.setItem(`tab${i}_saved`, 'true');
                        sessionStorage.setItem("lastSavedTab", i);
                    };
                } else {
                    // Hide save button for all other tabs
                    btn.style.display = 'none';
                }
            }
        }

        const nextBtn = document.getElementById("nextTabBtn");
        const backBtn = document.getElementById("backTabBtn");

        if (nextBtn) {
            nextBtn.onclick = () => {
                // Skip save check unless on tab 6
                if (currentTab !== 6 || sessionStorage.getItem(`tab${currentTab}_saved`) === 'true') {
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
        if (btn) {
            btn.style.display = (tab === 6 && show) ? 'inline-block' : 'none';
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
    const totalTabs = 6;

    document.addEventListener("DOMContentLoaded", () => {
        const lastSavedTab = sessionStorage.getItem("lastSavedTab");
        if (lastSavedTab) {
            currentTab = parseInt(lastSavedTab);
        }

        changeTab(currentTab);

        // Hide all Simpan buttons regardless of tab
        for (let i = 1; i <= totalTabs; i++) {
            const btn = document.getElementById(`saveBtn${i}`);
            if (btn) {
                btn.style.display = 'none';
            }
        }

        const nextBtn = document.getElementById("nextTabBtn");
        const backBtn = document.getElementById("backTabBtn");

        if (nextBtn) {
            nextBtn.onclick = () => {
                if (currentTab < totalTabs) {
                    changeTab(currentTab + 1);
                }
            };
        }

        if (backBtn) {
            backBtn.onclick = () => {
                if (currentTab > 1) {
                    changeTab(currentTab - 1);
                }
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
        }

        // Hide "Seterusnya" on last tab
        const nextBtn = document.getElementById("nextTabBtn");
        if (nextBtn) {
            nextBtn.style.display = currentTab === totalTabs ? 'none' : 'inline-block';
        }

        // Hide "Kembali" on first tab
        const backBtn = document.getElementById("backTabBtn");
        if (backBtn) {
            backBtn.style.display = currentTab === 1 ? 'none' : 'inline-block';
        }

        // Optionally show print button only on last tab
        const printBtnContainer = document.getElementById('printButtonContainer');
        if (printBtnContainer) {
            printBtnContainer.style.display = currentTab === totalTabs ? 'block' : 'none';
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



                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                        @endpush
