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
                <div class="col-md-6">
                    <!-- Page header -->
                    <div class="mb-5">
                        <h3 class="mb-0">{{ $applicationType->name_ms }}</h3>
                        <small>{{ $moduleName->name }} - {{ $roleName }}</small>
                    </div>
                </div>
                <div class="col-md-6 align-content-center">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
                        <ol class="breadcrumb text-center">
                            <li class="breadcrumb-item"><a href="http://127.0.0.1:8000/gantiKulit/semakanDokumen-06">{{
                                    \Illuminate\Support\Str::ucfirst(strtolower($applicationType->name)) }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $moduleName->name }}</a></li>
                            {{-- <li class="breadcrumb-item active" aria-current="page">resitBayaran</a></li> --}}

                        </ol>
                    </nav>
                </div>

            </div>
            <div>
                <div class="row">
                    <div class="col-12">

                        <div class="card card-primary card-tabs">
                            <div class="card-header"></div>
                            <div class="card-body">

                                <div class="border p-5" style="border-radius: 20px">
                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-md-6">
                                            <table class="table-borderless table">
                                                <tbody>
                                                    <tr>
                                                        <td class="col-md-3">Nama Pemohon</td>
                                                        <td class="col-md-1">:</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $userDetail->name ?? 'Tidak Diketahui' }}"
                                                                readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>No. Kad Pengenalan</td>
                                                        <td>:</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $userDetail->identity_card_number ?? 'Tidak Diketahui' }}"
                                                                readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pangkalan</td>
                                                        <td>:</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $jetty->jetty_name ?? 'Tidak Diketahui' }}"
                                                                readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>No. Pendaftaran Vesel</td>
                                                        <td>:</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $vessel->vessel_registration_number ?? 'Tiada Vesel' }}"
                                                                readonly>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <table class="table-borderless table">
                                                <tbody>
                                                    <tr>
                                                        <td class="col-md-3">Jenis resitBayaran</td>
                                                        <td class="col-md-1">:</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $application->applicationType->name_ms ?? 'Tidak Diketahui' }}"
                                                                readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>No. Rujukan</td>
                                                        <td>:</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $application->no_rujukan ?? 'Tidak Diketahui' }}"
                                                                readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tarikh resitBayaran</td>
                                                        <td>:</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $application->created_at?->format('d-m-Y') ?? 'Tidak Diketahui' }}"
                                                                readonly>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <br>

                                <div class="card card-primary">
                                    <div class="card-header pb-0">
                                        <ul class="nav nav-tabs" id="pills-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link custom-nav-link active" id="tab1-link"
                                                    aria-disabled="true"> Pemohon</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link custom-nav-link" id="tab2-link" aria-disabled="true">
                                                    Pangkalan</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link custom-nav-link" id="tab3-link" aria-disabled="true">
                                                    Peralatan</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link custom-nav-link" id="tab4-link" aria-disabled="true">
                                                    Vesel</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link custom-nav-link" id="tab5-link"
                                                    aria-disabled="true">Dokumen </a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link custom-nav-link" id="tab6-link"
                                                    aria-disabled="true">Rekod Kesalahan </a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link custom-nav-link" id="tab7-link"
                                                    aria-disabled="true">Pendaratan </a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link custom-nav-link" id="tab8-link"
                                                    aria-disabled="true">Status </a>
                                            </li>


                                            <li class="nav-item">
                                                <a class="nav-link custom-nav-link" id="tab9-link"
                                                    aria-disabled="true">Pelupusan </a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link custom-nav-link" id="tab10-link"
                                                    aria-disabled="true">Tindakan </a>
                                            </li>
                                        </ul>

                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content" id="pills-tabContent">
                                            <!-- -->
                                            <div class="tab-pane fade show active p-4 pt-0" id="content-tab1"
                                                role="tabpanel" aria-labelledby="tab1-link">

                                                <h5 class="  mb-0">Maklumat Peribadi</h5>
                                                <small class="text-muted">Maklumat peribadi pemohon</small>
                                                <hr>

                                                <table class="table-borderless table">
                                                    <tbody>
                                                        <tr>
                                                            <td class="col-md-4">Nama</td>
                                                            <td class="col-md-1 text-center">:</td>
                                                            <td>{{ $userDetail->name ?? 'Tidak Diketahui' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>No. I/C</td>
                                                            <td class="text-center">:</td>
                                                            <td>{{ $userDetail->identity_card_number ?? 'Tidak
                                                                Diketahui' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>No. Telefon</td>
                                                            <td class="text-center">:</td>
                                                            <td>{{ $userDetail->phone_number ?? 'Tidak Diketahui' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>No. Telefon (Kedua)</td>
                                                            <td class="text-center">:</td>
                                                            <td>{{ $userDetail->secondary_phone_number ?? '-' }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <br>

                                                <h5 class="  mb-0">Alamat Kediaman</h5>
                                                <small class="text-muted">Alamat lengkap tempat tinggal</small>
                                                <hr>

                                                <table class="table-borderless table">
                                                    <tbody>
                                                        <tr>
                                                            <td class="col-md-4">Alamat</td>
                                                            <td class="col-md-1 text-center">:</td>
                                                            <td>{{ $userDetail->address ?? 'Tidak Diketahui' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Poskod</td>
                                                            <td class="text-center">:</td>
                                                            <td>{{ $userDetail->postcode ?? 'Tidak Diketahui' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Daerah</td>
                                                            <td class="text-center">:</td>
                                                            <td>{{ $userDetail->district ?? 'Tidak Diketahui' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Negeri</td>
                                                            <td class="text-center">:</td>
                                                            <td>{{ $userDetail->state ?? 'Tidak Diketahui' }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <br>

                                                <h5 class="  mb-0">Alamat Surat-Menyurat</h5>
                                                <small class="text-muted">Alamat untuk tujuan surat-menyurat</small>
                                                <hr>

                                                <table class="table-borderless table">
                                                    <tbody>
                                                        <tr>
                                                            <td class="col-md-4">Alamat</td>
                                                            <td class="col-md-1 text-center">:</td>
                                                            <td>{{ $userDetail->mailing_address ?? 'Tidak Diketahui' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Poskod</td>
                                                            <td class="text-center">:</td>
                                                            <td>{{ $userDetail->mailing_postcode ?? 'Tidak Diketahui' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Daerah</td>
                                                            <td class="text-center">:</td>
                                                            <td>{{ $userDetail->mailing_district ?? 'Tidak Diketahui' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Negeri</td>
                                                            <td class="text-center">:</td>
                                                            <td>{{ $userDetail->mailing_state ?? 'Tidak Diketahui' }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <br>

                                                <h5 class="  mb-0">Maklumat Sebagai Nelayan</h5>
                                                <small class="text-muted">Maklumat berkaitan pengalaman dan aktiviti
                                                    sebagai nelayan</small>
                                                <hr>

                                                @php
                                                $useOff = empty($fishermanInfo) || !is_array($fishermanInfo);
                                                @endphp

                                                <table class="table-borderless table">
                                                    <tbody>
                                                        <tr>
                                                            <td class="col-md-4">Tahun Menjadi Nelayan</td>
                                                            <td class="col-md-1 text-center">:</td>
                                                            <td>{{ $useOff ? ($fishermanInfoOff->year_become_fisherman
                                                                ?? 'Tidak Diketahui') :
                                                                ($fishermanInfo['year_become_fisherman'] ?? 'Tidak
                                                                Diketahui') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-md-4">Tempoh Menjadi Nelayan</td>
                                                            <td class="col-md-1 text-center">:</td>
                                                            <td>{{ $useOff ?
                                                                ($fishermanInfoOff->becoming_fisherman_duration ??
                                                                'Tidak Diketahui') :
                                                                ($fishermanInfo['becoming_fisherman_duration'] ?? 'Tidak
                                                                Diketahui') }} Tahun</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-md-4">Hari Bekerja Menangkap Ikan Sebulan
                                                            </td>
                                                            <td class="col-md-1 text-center">:</td>
                                                            <td>{{ $useOff ?
                                                                ($fishermanInfoOff->working_days_fishing_per_month ??
                                                                'Tidak Diketahui') :
                                                                ($fishermanInfo['working_days_fishing_per_month'] ??
                                                                'Tidak Diketahui') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-md-4">Pendapatan Tahunan Dari Menangkap Ikan
                                                            </td>
                                                            <td class="col-md-1 text-center">:</td>
                                                            <td>RM {{ number_format($useOff ?
                                                                ($fishermanInfoOff->estimated_income_yearly_fishing ??
                                                                0) : ($fishermanInfo['estimated_income_yearly_fishing']
                                                                ?? 0), 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-md-4">Pendapatan Dari Pekerjaan Lain</td>
                                                            <td class="col-md-1 text-center">:</td>
                                                            <td>RM {{ number_format($useOff ?
                                                                ($fishermanInfoOff->estimated_income_other_job ?? 0) :
                                                                ($fishermanInfo['estimated_income_other_job'] ?? 0), 2)
                                                                }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-md-4">Hari Bekerja Di Pekerjaan Lain</td>
                                                            <td class="col-md-1 text-center">:</td>
                                                            <td>{{ $useOff ?
                                                                ($fishermanInfoOff->days_working_other_job_per_month ??
                                                                '-') :
                                                                ($fishermanInfo['days_working_other_job_per_month'] ??
                                                                '-') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-md-4">Menerima Pencen</td>
                                                            <td class="col-md-1 text-center">:</td>
                                                            <td>{{ ($useOff ? ($fishermanInfoOff->receive_pension ?? 0)
                                                                : ($fishermanInfo['receive_pension'] ?? 0)) == 1 ? 'Ya'
                                                                : 'Tidak' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-md-4">Menerima Bantuan Kewangan</td>
                                                            <td class="col-md-1 text-center">:</td>
                                                            <td>{{ ($useOff ? ($fishermanInfoOff->receive_financial_aid
                                                                ?? 0) : ($fishermanInfo['receive_financial_aid'] ?? 0))
                                                                == 1 ? 'Ya' : 'Tidak' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-md-4">Pencarum KWSP</td>
                                                            <td class="col-md-1 text-center">:</td>
                                                            <td>{{ ($useOff ? ($fishermanInfoOff->epf_contributor ?? 0)
                                                                : ($fishermanInfo['epf_contributor'] ?? 0)) == 1 ? 'Ya'
                                                                : 'Tidak' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-md-4">Agensi Memberi Bantuan</td>
                                                            <td class="col-md-1 text-center">:</td>
                                                            <td>
                                                                @php
                                                                $agencies = $useOff
                                                                ?
                                                                optional($aidAgencyOff)->pluck('agency_name')->toArray()
                                                                : ($fishermanInfo['financial_aid_agency'] ?? []);
                                                                $agencies = is_array($agencies) ? $agencies :
                                                                json_decode($agencies, true);
                                                                @endphp

                                                                @if (!empty($agencies))
                                                                <ul class="mb-0 ps-3">
                                                                    @foreach ($agencies as $agency)
                                                                    <li>{{ $agency }}</li>
                                                                    @endforeach
                                                                </ul>
                                                                @else
                                                                -
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>

                                          <div class="tab-pane fade p-4" id="content-tab2" role="tabpanel" aria-labelledby="tab2-link">

                                            <section>
                                                @php
                                                $useJettyOff = empty($jettyInfo) || !is_array($jettyInfo);
                                                @endphp

                                                <div class="mb-3">
                                                    <h4 class=" ">Maklumat Jeti / Pangkalan Semasa</h4>
                                                    <small class="text-muted m-0">
                                                        Maklumat berikut menunjukkan jeti atau pangkalan semasa di mana pemohon menjalankan aktiviti penangkapan
                                                        ikan.
                                                    </small>
                                                    <hr>
                                                </div>

                                                <table class="table table-borderless">
                                                    <tbody>
                                                        <tr>
                                                            <td class="col-md-4">Negeri</td>
                                                            <td class="col-md-1 text-center">:</td>
                                                            <td>{{ $jettyOff->state_name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-md-4">Daerah</td>
                                                            <td class="col-md-1 text-center">:</td>
                                                            <td>{{ $jettyOff->district_name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-md-4">Sungai/Tasik</td>
                                                            <td class="col-md-1 text-center">:</td>
                                                            <td>{{$jettyOff->river_name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-md-4">Jeti / Pangkalan</td>
                                                            <td class="col-md-1 text-center">:</td>
                                                            <td>{{ $jettyOff->jetty_name }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </section>

                                            <section>
                                                <br>
                                                <div class="mb-3">
                                                    <h4 class=" ">Rekod Jeti / Pangkalan</h4>
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
                                                                <th>Jeti / Pangkalan</th>
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

                                        </div>

                                            @php
                                            $latestEquipmentGroup = $latestEquipmentGroup ?? collect();
                                            $equipmentGrouped = $equipmentGrouped ?? collect();
                                            @endphp

                                            <div class="tab-pane fade p-4" id="content-tab3" role="tabpanel"
                                                aria-labelledby="tab3-link">

                                                <!-- Section 1: Current Equipment -->
                                                <h4 class="  mb-0">Peralatan Menangkap Ikan Semasa</h4>
                                                <small class="text-muted">Senarai peralatan dari permohonan semasa</small>
                                                <hr>

                                                @if ($latestEquipmentGroup->isEmpty())
                                                <p class="text-muted">Tiada peralatan digunakan buat masa ini.</p>
                                                @else
                                                <div class="mb-4 border rounded p-3">
                                                    <div class="table-responsive mb-4">
                                                        <table class="table table-borderless align-middle mb-0">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th style="width: 5%;">Bil.</th>
                                                                    <th>Nama Peralatan</th>
                                                                    <th>Jenis</th>
                                                                    <th style="width: 15%;">Kuantiti</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($latestEquipmentGroup as $index => $equipment)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $equipment->name ?? '-' }}</td>
                                                                    <td>
                                                                        {{ $equipment->type === 'main' ? 'UTAMA' :
                                                                        ($equipment->type === 'additional' ? 'TAMBAHAN'
                                                                        : '-') }}
                                                                    </td>

                                                                    <td>{{ $equipment->quantity ?? 1 }}</td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    @endif
                                                </div>

                                                <br>

                                                <!-- Section 2: Equipment History -->
                                                <h4 class="  mb-0">Rekod Peralatan Menangkap Ikan</h4>
                                                <small class="text-muted">Senarai peralatan dari permohonan
                                                    terdahulu</small>
                                                <hr>

                                                @if ($equipmentGrouped->isEmpty())
                                                <p class="text-muted">Tiada rekod peralatan sebelumnya.</p>
                                                @else
                                                @foreach ($equipmentGrouped as $applicationId => $equipmentList)
                                                <div class="mb-4 border rounded p-3">
                                                    @php
                                                    $createdAt = optional($equipmentList->first())->created_at;
                                                    @endphp

                                                    <h6 class="text-secondary">
                                                        {{
                                                        \Carbon\Carbon::parse($createdAt)->format('d/m/Y') }}
                                                    </h6>

                                                    <div class="table-responsive">
                                                        <table class="table  table-borderless align-middle mb-0">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th style="width: 5%;">Bil.</th>
                                                                    <th>Nama Peralatan</th>
                                                                    <th>Jenis</th>
                                                                    <th style="width: 15%;">Kuantiti</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($equipmentList as $index => $equipment)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $equipment->name ?? '-' }}</td>
                                                                    <td>
                                                                        {{ $equipment->type === 'main' ? 'UTAMA' :
                                                                        ($equipment->type === 'additional' ? 'TAMBAHAN'
                                                                        : '-') }}
                                                                    </td>
                                                                    <td>{{ $equipment->quantity ?? 1 }}</td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                @endforeach
                                                @endif

                                            </div>

                                            @php
                                            $useVesselOff = empty($vesselInfo) || !is_array($vesselInfo);
                                            @endphp

                                            <div class="tab-pane fade p-4" id="content-tab4" role="tabpanel"
                                                aria-labelledby="tab4-link">
                                                <div class="mb-4">

                                                    <!-- Section: Maklumat Pemilikan Vesel -->

                                                    <h5 class="  mb-0">Maklumat Enjin Dan Vesel Semasa</h5>
                                                    <small class="text-muted">Maklumat ini memaparkan butiran pemilikan
                                                        vesel.</small>
                                                    <hr>

                                                    <table class="table table-borderless">
                                                        <tbody>
                                                            @if (($useVesselOff ? ($vesselInfoOff?->own_vessel ?? 'no')
                                                            : ($vesselInfo['has_vessel'] ?? '')) == 'no')
                                                            <tr>
                                                                <td class="col-md-4">Jenis Pengangkutan Digunakan</td>
                                                                <td class="col-md-1 text-center">:</td>
                                                                <td>
                                                                    {{ $useVesselOff
                                                                    ? ($vesselInfoOff?->transportation ?? '-')
                                                                    : ($vesselInfo['transport_type'] ?? '-') }}
                                                                </td>
                                                            </tr>
                                                            @else
                                                            <!-- Subsection: Maklumat Vesel -->
                                                            <tr class="   ">
                                                                <td colspan="3">Maklumat Vesel</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="col-md-4">No. Pendaftaran Vesel</td>
                                                                <td class=" col-md-1 text-center">:</td>
                                                                <td>{{ $vesselInfoOff?->vessel_registration_number ??
                                                                    'Tidak Diketahui' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Jenis Kulit Vesel</td>
                                                                <td class="text-center">:</td>
                                                                <td>{{ $vesselInfoOff?->hull?->hull_type ?? 'Tidak
                                                                    Diketahui' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Panjang (m)</td>
                                                                <td class="text-center">:</td>
                                                                <td>{{ $vesselInfoOff?->hull?->length ?? 'Tidak
                                                                    Diketahui' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Lebar (m)</td>
                                                                <td class="text-center">:</td>
                                                                <td>{{ $vesselInfoOff?->hull?->width ?? 'Tidak
                                                                    Diketahui' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Kedalaman (m)</td>
                                                                <td class="text-center">:</td>
                                                                <td>{{ $vesselInfoOff?->hull?->depth ?? 'Tidak
                                                                    Diketahui' }}</td>
                                                            </tr>

                                                            <!-- Subsection: Maklumat Enjin Tambahan -->
                                                            @if (!empty($vesselInfoOff?->engine))
                                                            <tr class="   ">
                                                                <td colspan="3">Maklumat Enjin Tambahan</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Model Enjin</td>
                                                                <td class="text-center">:</td>
                                                                <td>{{ $vesselInfoOff->engine->model ?? 'Tidak
                                                                    Diketahui' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Kuasa Kuda (KK)</td>
                                                                <td class="text-center">:</td>
                                                                <td>{{ $vesselInfoOff->engine->horsepower ?? 'Tidak
                                                                    Diketahui' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>No. Enjin</td>
                                                                <td class="text-center">:</td>
                                                                <td>{{ $vesselInfoOff->engine->engine_number ?? 'Tidak
                                                                    Diketahui' }}</td>
                                                            </tr>
                                                            @endif
                                                            @endif
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>

                                            <div class="tab-pane fade p-4" id="content-tab5" role="tabpanel"
                                                aria-labelledby="tab5-link">
                                                <h4 class="  mb-0">Dokumen Permohonan</h4>
                                                <small class="text-muted">Senarai dokumen berkaitan permohonan
                                                    ini</small>
                                                <hr>

                                                @if (!empty($documents) && is_array($documents))
                                                <table class="table-borderless table">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th style="width: 5%">Bil</th>
                                                            <th>Nama Dokumen</th>
                                                            <th>Tindakan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($documents as $index => $doc)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $doc['title'] ?? 'Tidak Diketahui' }}</td>
                                                            <td>
                                                                @if (!empty($doc['file_path']))
                                                                <!-- Button to trigger modal -->
                                                                <button type="button" class="btn btn-primary"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#documentModal{{ $index }}">
                                                                    <i class="fa fa-search p-1"></i>
                                                                </button>

                                                                <!-- Modal -->
                                                                <div class="modal fade" id="documentModal{{ $index }}"
                                                                    tabindex="-1"
                                                                    aria-labelledby="documentModalLabel{{ $index }}"
                                                                    aria-hidden="true">
                                                                    <div
                                                                        class="modal-dialog modal-xl modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="documentModalLabel{{ $index }}">
                                                                                    Paparan Dokumen
                                                                                </h5>
                                                                                <button type="button" class="btn-close"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Tutup"></button>
                                                                            </div>
                                                                            <div class="modal-body"
                                                                                style="height: 80vh;">
                                                                                <iframe src="{{ route('gantiKulit.semakanDokumen-06.viewDocument', [
                                                                                                    'index' => $index,
                                                                                                    'application_id' => $application->id,
                                                                                                ]) }}"
                                                                                    style="width: 100%; height: 100%;"
                                                                                    frameborder="0">
                                                                                </iframe>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @else
                                                                <span class="text-muted">Tiada Fail</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                @else
                                                <p class="text-muted">Tiada dokumen dimuat naik.</p>
                                                @endif

                                                <br>

                                                <h4 class="  mb-0">Rekod Laporan LPI</h4>
                                                <small class="text-muted">Laporan LPI yang telah direkodkan</small>
                                                <hr>

                                                <table class="table table-borderless">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Bil</th>
                                                            <th>Tarikh Pemeriksaan</th>
                                                            <th>Tarikh Sah Laku</th>
                                                            <th>Tarikh Cipta</th>
                                                            <th>Tindakan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($inspection as $index => $item)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{
                                                                \Carbon\Carbon::parse($item->inspection_date)->format('d-m-Y')
                                                                ?? '-' }}</td>
                                                            <td>{{
                                                                \Carbon\Carbon::parse($item->valid_date)->format('d-m-Y')
                                                                ?? '-' }}</td>
                                                            <td>{{
                                                                \Carbon\Carbon::parse($item->created_at)->format('d-m-Y
                                                                H:i') ?? '-' }}</td>
                                                            <td>
                                                                <button type="button" class="btn btn-primary"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#modalInspectionDetail{{ $index }}">
                                                                    <i class="fa fa-search"></i>
                                                                </button>

                                                                @foreach ($inspection as $index => $ins)
                                                                <div class="modal fade"
                                                                    id="modalInspectionDetail{{ $index }}" tabindex="-1"
                                                                    aria-labelledby="inspectionModalLabel{{ $index }}"
                                                                    aria-hidden="true">
                                                                    <div
                                                                        class="modal-dialog modal-xl modal-dialog-scrollable">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Butiran
                                                                                    Pemeriksaan #{{ $loop->iteration }}
                                                                                </h5>
                                                                                <button type="button" class="btn-close"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Tutup"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <h5 class=" ">Maklumat Umum</h5>
                                                                                <table class="table table-borderless">
                                                                                    <tr>
                                                                                        <td class="col-md-4 ">Tarikh
                                                                                            Pemeriksaan</td>
                                                                                        <td class="col-md-2">:</td>
                                                                                        <td>{{
                                                                                            \Carbon\Carbon::parse($ins->inspection_date)->format('d-m-Y')
                                                                                            }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="col-md-4 ">Tarikh Sah
                                                                                        </td>
                                                                                        <td class="col-md-2">:</td>
                                                                                        <td>{{
                                                                                            \Carbon\Carbon::parse($ins->valid_date)->format('d-m-Y')
                                                                                            }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="col-md-4 ">Oleh</td>
                                                                                        <td class="col-md-2">:</td>
                                                                                        <td>{{ $ins->inspector?->name ??
                                                                                            '-' }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="col-md-4 ">Ringkasan
                                                                                        </td>
                                                                                        <td class="col-md-2">:</td>
                                                                                        <td>{{ $ins->inspection_summary
                                                                                            ?? '-' }}</td>
                                                                                    </tr>
                                                                                </table>

                                                                                <hr>
                                                                                <h5 class=" ">Maklumat Vesel</h5>
                                                                                <table class="table table-borderless">
                                                                                    <tr>
                                                                                        <td class="col-md-4 ">Keadaan
                                                                                        </td>
                                                                                        <td class="col-md-2">:</td>
                                                                                        <td>{{ $ins->vessel_condition ??
                                                                                            '-' }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="col-md-4 ">Asal</td>
                                                                                        <td class="col-md-2">:</td>
                                                                                        <td>{{ $ins->vessel_origin ??
                                                                                            '-' }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="col-md-4 ">Jenis
                                                                                            Kulit</td>
                                                                                        <td class="col-md-2">:</td>
                                                                                        <td>{{ $ins->hull_type ?? '-' }}
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="col-md-4 ">Digerudi?
                                                                                        </td>
                                                                                        <td class="col-md-2">:</td>
                                                                                        <td>{{ $ins->drilled ? 'Ya' :
                                                                                            'Tidak' }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="col-md-4 ">Dicat
                                                                                            Cerah?</td>
                                                                                        <td class="col-md-2">:</td>
                                                                                        <td>{{ $ins->brightly_painted ?
                                                                                            'Ya' : 'Tidak' }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="col-md-4 ">Ulasan
                                                                                            Pendaftaran</td>
                                                                                        <td class="col-md-2">:</td>
                                                                                        <td>{{
                                                                                            $ins->vessel_registration_remarks
                                                                                            ?? '-' }}</td>
                                                                                    </tr>
                                                                                </table>

                                                                                <hr>
                                                                                <h5 class=" ">Dimensi Vesel</h5>
                                                                                <table class="table table-borderless">
                                                                                    <tr>
                                                                                        <td class="col-md-4">Panjang
                                                                                        </td>
                                                                                        <td class="col-md-2">:</td>
                                                                                        <td>{{ $ins->length }} m</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="col-md-4">Lebar</td>
                                                                                        <td class="col-md-2">:</td>
                                                                                        <td>{{ $ins->width }} m</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="col-md-4">Kedalaman
                                                                                        </td>
                                                                                        <td class="col-md-2">:</td>
                                                                                        <td>{{ $ins->depth }} m</td>
                                                                                    </tr>
                                                                                </table>

                                                                                <hr>
                                                                                <h5 class=" ">Maklumat Enjin</h5>
                                                                                <table class="table table-borderless">
                                                                                    <tr>
                                                                                        <td class="col-md-4">Model</td>
                                                                                        <td class="col-md-2">:</td>
                                                                                        <td>{{ $ins->engine_model ?? '-'
                                                                                            }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="col-md-4">Jenama</td>
                                                                                        <td class="col-md-2">:</td>
                                                                                        <td>{{ $ins->engine_brand ?? '-'
                                                                                            }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="col-md-4">Kuasa Kuda
                                                                                        </td>
                                                                                        <td class="col-md-2">:</td>
                                                                                        <td>{{ $ins->horsepower ?? '-'
                                                                                            }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="col-md-4">No. Enjin
                                                                                        </td>
                                                                                        <td class="col-md-2">:</td>
                                                                                        <td>{{ $ins->engine_number ??
                                                                                            '-' }}</td>
                                                                                    </tr>
                                                                                </table>

                                                                                <hr>
                                                                                <h5 class=" ">Maklumat Jaket
                                                                                    Keselamatan</h5>
                                                                                <table class="table table-borderless">
                                                                                    <tr>
                                                                                        <td class="col-md-4">Status</td>
                                                                                        <td class="col-md-2">:</td>
                                                                                        <td>{{
                                                                                            $ins->safety_jacket_status
                                                                                            ?? '-' }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="col-md-4">Kuantiti
                                                                                        </td>
                                                                                        <td class="col-md-2">:</td>
                                                                                        <td>{{
                                                                                            $ins->safety_jacket_quantity
                                                                                            ?? '-' }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="col-md-4">Keadaan
                                                                                        </td>
                                                                                        <td class="col-md-2">:</td>
                                                                                        <td>{{
                                                                                            $ins->safety_jacket_condition
                                                                                            ?? '-' }}</td>
                                                                                    </tr>
                                                                                </table>

                                                                                <hr>
                                                                                <h5 class=" ">Lampiran Gambar</h5>
                                                                                <div class="row g-3">
                                                                                    @foreach ([
                                                                                    'attendance_form_path' => 'Borang
                                                                                    Kehadiran',
                                                                                    'vessel_image_path' => 'Vesel',
                                                                                    'inspector_owner_image_path' =>
                                                                                    'Pemeriksa & Pemilik',
                                                                                    'overall_image_path' => 'Gambar
                                                                                    Menyeluruh',
                                                                                    'safety_jacket_image_path' => 'Jaket
                                                                                    Keselamatan',
                                                                                    'engine_image_path' => 'Enjin',
                                                                                    'engine_number_image_path' => 'No
                                                                                    Enjin',
                                                                                    ] as $field => $label)
                                                                                    @if (! empty($ins->$field))
                                                                                    <div class="col-12">

                                                                                        <label
                                                                                            class="form-label d-block  ">{{
                                                                                            $label }}</label>

                                                                                        <div class="border p-2 bg-light"
                                                                                            style="height: 400px; overflow: hidden;">

                                                                                            <iframe
                                                                                                src="{{ route('gantiKulit.semakanDokumen-06.viewInspectionDocument',['id' => $ins->id, 'field' => $field]) }}"
                                                                                                style="width: 100%; height: 100%; object-fit: contain; border: none;"></iframe>

                                                                                        </div>
                                                                                    </div>
                                                                                    @endif
                                                                                    @endforeach
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endforeach

                                                            </td>
                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center text-muted">Tiada rekod
                                                                pemeriksaan tersedia.</td>
                                                        </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="tab-pane fade p-4" id="content-tab6" role="tabpanel"
                                                aria-labelledby="tab6-link">
                                                <div class="w-100 d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h4 class="  mb-0">Rekod Kesalahan</h4>
                                                        <small class="text-muted">Berikut merupakan senarai kesalahan
                                                            yang pernah direkodkan oleh pengguna</small>
                                                    </div>
                                                    <div>

                                                          <!-- Trigger modal button -->
                                                        {{-- <button type="button" class="btn btn-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#rekodKesalahanModal">
                                                            Kemaskini
                                                        </button> --}}

                                                    </div>
                                                </div>
                                                <hr>

                                                <!-- Rekod Kesalahan Modal (Extra Large & Centered) -->
                                                {{-- <div class="modal fade" id="rekodKesalahanModal" tabindex="-1"
                                                    aria-labelledby="rekodKesalahanModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                                        <form method="POST"
                                                            action="{{ route('gantiKulit.semakanDokumen-06.updateFault', ['application_id' => $application->id]) }}"
                                                            enctype="multipart/form-data" class="modal-content">
                                                            @csrf

                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="rekodKesalahanModalLabel">
                                                                    Kemaskini Rekod Kesalahan</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="case_number" class="form-label">Nombor
                                                                        Kes</label>
                                                                    <input type="text" name="case_number"
                                                                        id="case_number" class="form-control">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="fault_type" class="form-label">Jenis
                                                                        Kesalahan</label>
                                                                    <select name="fault_type" id="fault_type"
                                                                        class="form-select" required>
                                                                        <option value="">Pilih Jenis Kesalahan
                                                                        </option>
                                                                        <option value="Menangkap ikan tanpa lesen">
                                                                            Menangkap ikan tanpa lesen</option>
                                                                        <option
                                                                            value="Menggunakan peralatan tangkapan yang dilarang">
                                                                            Menggunakan peralatan tangkapan yang
                                                                            dilarang</option>
                                                                        <option value="Menjala di kawasan larangan">
                                                                            Menjala di kawasan larangan</option>
                                                                        <option
                                                                            value="Menangkap spesies ikan yang dilindungi">
                                                                            Menangkap spesies ikan yang dilindungi
                                                                        </option>
                                                                        <option
                                                                            value="Menggunakan racun atau bahan letupan">
                                                                            Menggunakan racun atau bahan letupan
                                                                        </option>
                                                                        <option value="Menangkap ikan melebihi kuota">
                                                                            Menangkap ikan melebihi kuota</option>
                                                                        <option
                                                                            value="Mengganggu habitat semula jadi ikan">
                                                                            Mengganggu habitat semula jadi ikan</option>
                                                                        <option
                                                                            value="Tidak melaporkan hasil tangkapan">
                                                                            Tidak melaporkan hasil tangkapan</option>
                                                                        <option value="Menjual ikan tanpa kebenaran">
                                                                            Menjual ikan tanpa kebenaran</option>
                                                                        <option
                                                                            value="Menggunakan bot atau enjin yang tidak didaftarkan">
                                                                            Menggunakan bot atau enjin yang tidak
                                                                            didaftarkan</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="fault_date" class="form-label">Tarikh
                                                                        Kesalahan</label>
                                                                    <input type="date" name="fault_date" id="fault_date"
                                                                        class="form-control" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="method"
                                                                        class="form-label">Kaedah</label>
                                                                    <input type="text" name="method" id="method"
                                                                        class="form-control">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="method_section"
                                                                        class="form-label">Seksyen Kaedah</label>
                                                                    <input type="text" name="method_section"
                                                                        id="method_section" class="form-control">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="decision" class="form-label">Perintah
                                                                        Mahkamah</label>
                                                                    <textarea class="form-control" name="decision"
                                                                        id="decision" rows="5"></textarea>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="case_document" class="form-label">Muat
                                                                        Naik Dokumen Kes</label>
                                                                    <input type="file" name="case_document"
                                                                        id="case_document" class="form-control"
                                                                        accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                                                    <small class="text-muted">Format dibenarkan: PDF,
                                                                        JPG, JPEG, PNG, DOC, DOCX. Saiz maksimum:
                                                                        2MB.</small>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-success">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div> --}}

                                                <div class="table-responsive mt-3">
                                                    <table class="table-borderless table">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th style="width: 5%">Bil</th>
                                                                <th>No. Kes</th>
                                                                <th>Jenis Kesalahan</th>
                                                                <th>Tarikh Kesalahan</th>
                                                                <th>Kaedah</th>
                                                                <th>Seksyen Kaedah</th>
                                                                <th>Perintah Mahkamah</th>
                                                                <th>Dokumen</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($faultRecord as $index => $rekod)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $rekod->case_number ?? '-' }}</td>
                                                                <td>{{ $rekod->fault_type ?? '-' }}</td>
                                                                <td>{{ $rekod->fault_date ?
                                                                    \Carbon\Carbon::parse($rekod->fault_date)->format('d/m/Y')
                                                                    : '-' }}
                                                                </td>
                                                                <td>{{ $rekod->method ?? '-' }}</td>
                                                                <td>{{ $rekod->method_section ?? '-' }}</td>
                                                                <td>{{ $rekod->decision ?? '-' }}</td>
                                                                <td>
                                                                    @if (!empty($rekod->document_path))
                                                                    <button class="btn btn-primary"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#viewDocumentModal{{ $rekod->id }}">
                                                                        <i class="fa fa-search p-1"></i>
                                                                    </button>

                                                                    <!-- Modal -->
                                                                    <div class="modal fade"
                                                                        id="viewDocumentModal{{ $rekod->id }}"
                                                                        tabindex="-1"
                                                                        aria-labelledby="viewDocumentLabel{{ $rekod->id }}"
                                                                        aria-hidden="true">
                                                                        <div
                                                                            class="modal-dialog modal-xl modal-dialog-centered">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title"
                                                                                        id="viewDocumentLabel{{ $rekod->id }}">
                                                                                        Paparan Dokumen Kes</h5>
                                                                                    <button type="button"
                                                                                        class="btn-close"
                                                                                        data-bs-dismiss="modal"
                                                                                        aria-label="Tutup"></button>
                                                                                </div>
                                                                                <div class="modal-body"
                                                                                    style="height: 80vh;">
                                                                                    <iframe
                                                                                        src="{{ route('gantiKulit.semakanDokumen-06.viewFaultDocument', ['application_id' => $application->id, 'record_id' => $rekod->id]) }}"
                                                                                        style="width: 100%; height: 100%;"
                                                                                        frameborder="0"></iframe>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @else
                                                                    <span class="text-muted">Tiada Fail</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @empty
                                                            <tr>
                                                                <td class="text-center" colspan="8">Tiada rekod
                                                                    kesalahan direkodkan.</td>
                                                            </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>

                                            <div class="tab-pane fade" id="content-tab7" role="tabpanel"
                                                aria-labelledby="tab7-link">
                                                <div class="card-header mb-3 pl-0">

                                                    <h4 class="  mb-0">Maklumat Pendaratan</h4>
                                                    <small class="text-muted">Maklumat berkaitan hasil tangkapan dan
                                                        pendaratan ikan</small>
                                                </div>
 @forelse ($declarations as $declaration)

                                        <div class="card-header">
                                         <!-- <strong>Pendaratan oleh:</strong> {{ $declaration->user->name ?? 'Tidak
                                            diketahui' }} <br> -->
                                            <strong>Bulan:</strong> {{ $declaration->month }} / {{ $declaration->year
                                            }}<br>
                                            <strong>Minggu:</strong> {{ $declaration->week }} <br>
                                            <strong>Bilangan Hari Operasi:</strong>
                                            {{ ($declaration->endDay - $declaration->startDay) + 1 }} hari
                                        </div>
                                        <div class="card-body">
                                            @if ($declaration->landingInfo)
                                            <p><strong>Tarikh Pendaratan:</strong> {{
                                                $declaration->landingInfo->landing_date->format('d/m/Y') }}</p>

                                            @foreach ($declaration->landingInfo->landingInfoActivities as $activity)
                                            <div class="mb-3 border p-3 bg-light">
                                                <h5>Aktiviti: {{ $activity->activityType->name ?? 'N/A' }}</h5>
                                                <p>
                                                    <strong>Lokasi:</strong> {{ $activity->location_name }} <br>
                                                    <strong>Peralatan:</strong> {{ $activity->equipment }} <br>
                                                    <strong>Masa:</strong> {{ $activity->time }}
                                                </p>

                                                @if ($activity->landingActivitySpecies->isNotEmpty())
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Spesies</th>
                                                            <th>Berat (kg)</th>
                                                            <th>Harga Seunit (RM)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($activity->landingActivitySpecies as $species)
                                                        <tr>
                                                            <td>{{ $species->species->common_name ?? 'Tidak diketahui'
                                                                }}</td>
                                                            <td>{{ $species->weight }}</td>
                                                            <td>{{ $species->price_per_weight }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                @else
                                                <p>Tiada spesies direkodkan.</p>
                                                @endif
                                            </div>
                                            @endforeach

                                            <p class="mt-3"><strong>Disahkan oleh:</strong>
                                                {{ $declaration->decisionBy->name ?? 'Tidak diketahui' }}
                                                pada {{ optional($declaration->decision_at)->format('d/m/Y') }}
                                            </p>
                                            @else
                                            <p><em>Tiada maklumat pendaratan.</em></p>
                                            @endif
                                        </div>
                          		<hr>
                                    @empty
                                    <p>Tiada data pendaratan.</p>
                                    @endforelse

                                            </div>

                                            <div class="tab-pane fade" id="content-tab8" role="tabpanel"
                                                aria-labelledby="tab8-link">
                                                <h4>Status resitBayaran</h4>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="timeline">
                                                            @if ($applicationLogs->isEmpty())
                                                            <div class="text-muted text-center">
                                                                <p class="mt-4">Tiada Rekod</p>
                                                            </div>
                                                            @else
                                                            @php
                                                            $prevDate = null;
                                                            $count = 0;
                                                            @endphp
                                                            @foreach ($applicationLogs as $log)
                                                            @php $count++; @endphp

                                                            {{-- Group by date --}}
                                                            @if ($log->created_at->format('d/m/Y') !== $prevDate)
                                                            @php
                                                            $prevDate = $log->created_at->format('d/m/Y');
                                                            @endphp
                                                            <div class="time-label">
                                                                <span class="bg-white">{{ $prevDate }}</span>
                                                            </div>
                                                            @endif

                                                            <div>
                                                                <div class="timeline-item">
                                                                    <span class="time"><i class="fas fa-clock"></i>
                                                                        {{ $log->created_at->format('h:i:s A') }}</span>

                                                                    <!-- Status -->
                                                                    <h3 class="timeline-header"
                                                                        style="color: black; font-weight: bold; border-bottom: 1px solid #D3D3D3; font-size: 100%; padding-top: 1%; padding-bottom: 1%;">
                                                                        Status&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        {{ $log->applicationStatus->name_ms ?? 'Tidak
                                                                        Diketahui' }}
                                                                    </h3>

                                                                    @php
                                                                    $flagBadges = [];

                                                                    if (!is_null($log->review_flag)) {
                                                                    $flagBadges[] =
                                                                    '<span class="badge ' .
                                                                                            ($log->review_flag ? 'bg-success' : 'bg-danger') .
                                                                                            '">' .
                                                                        ($log->review_flag
                                                                        ? 'LENGKAP'
                                                                        : 'TIDAK
                                                                        LENGKAP') .
                                                                        '</span>';
                                                                    }

                                                                    if (!is_null($log->support_flag)) {
                                                                    $flagBadges[] =
                                                                    '<span class="badge ' .
                                                                                            ($log->support_flag ? 'bg-success' : 'bg-danger') .
                                                                                            '">' .
                                                                        ($log->support_flag
                                                                        ? 'DISOKONG'
                                                                        : 'TIDAK
                                                                        DISOKONG') .
                                                                        '</span>';
                                                                    }

                                                                    if (!is_null($log->decision_flag)) {
                                                                    $flagBadges[] =
                                                                    '<span class="badge ' .
                                                                                            ($log->decision_flag ? 'bg-success' : 'bg-danger') .
                                                                                            '">' .
                                                                        ($log->decision_flag
                                                                        ? 'LULUS'
                                                                        : 'TIDAK
                                                                        LULUS') .
                                                                        '</span>';
                                                                    }

                                                                    if (!is_null($log->confirmation_flag)) {
                                                                    $flagBadges[] =
                                                                    '<span class="badge ' .
                                                                                            ($log->confirmation_flag ? 'bg-success' : 'bg-danger') .
                                                                                            '">' .
                                                                        ($log->confirmation_flag
                                                                        ? 'DISAHKAN'
                                                                        : 'TIDAK DISAHKAN') .
                                                                        '</span>';
                                                                    }
                                                                    @endphp

                                                                    @if (count($flagBadges))
                                                                    <h3 class="timeline-header d-flex align-items-center flex-wrap gap-2"
                                                                        style="color: black; font-weight: bold; border-bottom: 1px solid #D3D3D3;
                                                                               font-size: 100%; padding-top: 1%; padding-bottom: 1%;">
                                                                        Label&nbsp;&nbsp;&nbsp;:
                                                                        <div class="d-flex flex-wrap gap-2">
                                                                            {!! implode(' <span>/</span> ', $flagBadges)
                                                                            !!}
                                                                        </div>
                                                                    </h3>
                                                                    @endif

                                                                    <!-- Ulasan -->
                                                                    @if (!empty($log->remarks))
                                                                    <h3 class="timeline-header"
                                                                        style="color: black; font-weight: bold; border-bottom: 1px solid #D3D3D3; font-size: 100%; padding-top: 1%; padding-bottom: 1%;">
                                                                        Ulasan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        :
                                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <br><br>
                                                                        <span
                                                                            style="color: black; font-weight: normal; text-align: justify; line-height: 1.6; font-size: 105%;">
                                                                            {{ $log->remarks }}
                                                                        </span>
                                                                    </h3>
                                                                    @endif

                                                                    <!-- Hidden Detail Section -->
                                                                    <div id="details{{ $count }}"
                                                                        style="display: none;">
                                                                        <!-- Pelaku -->
                                                                        <h3 class="timeline-header"
                                                                            style="color: black; font-weight: bold; border-bottom: 1px solid #D3D3D3; font-size: 100%; padding-top: 1%; padding-bottom: 1%;">
                                                                            &nbsp;&nbsp;&nbsp;Pelaku&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                            :
                                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                            <a href="#"
                                                                                style="color: black; font-weight: normal;"
                                                                                onmouseover="this.style.color='blue';"
                                                                                onmouseout="this.style.color='black';">
                                                                                {{ strtoupper($log->creator->name ??
                                                                                'Tidak Diketahui') }}
                                                                            </a>
                                                                        </h3>

                                                                        <!-- Jawatan -->
                                                                        <h3 class="timeline-header"
                                                                            style="color: black; font-weight: bold; border-bottom: 1px solid #D3D3D3; font-size: 100%; padding-top: 1%; padding-bottom: 1%;">
                                                                            &nbsp;&nbsp;&nbsp;Jawatan&nbsp;&nbsp;&nbsp;
                                                                            : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                            <a href="#"
                                                                                style="color: black; font-weight: normal;">
                                                                                @if ($log->creator &&
                                                                                $log->creator->userRoles->isNotEmpty())
                                                                                {{
                                                                                $log->creator->userRoles->pluck('name')->join(',
                                                                                ') }}
                                                                                @else
                                                                                Tidak Diketahui
                                                                                @endif
                                                                            </a>
                                                                        </h3>
                                                                    </div>

                                                                    <!-- Toggle Button -->
                                                                    <div style="text-align: right;">
                                                                        <button type="button"
                                                                            onclick="toggleDetails('details{{ $count }}', this)"
                                                                            class="btn btn-link"
                                                                            style="text-decoration: none;">
                                                                            <i class="fas fa-angle-down"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                            @endif

                                                            <!-- Timeline End Icon -->
                                                            <div>

                                                                <i class="fas fa-clock bg-gray"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <script>
                                                function toggleDetails(detailsId, button) {
                                                        const details = document.getElementById(detailsId);
                                                        if (details.style.display === "none") {
                                                            details.style.display = "block";
                                                            button.innerHTML = '<i class="fas fa-angle-up"></i>';
                                                        } else {
                                                            details.style.display = "none";
                                                            button.innerHTML = '<i class="fas fa-angle-down"></i>';
                                                        }
                                                    }
                                            </script>

                                        <div class="tab-pane fade" id="content-tab9" role="tabpanel" aria-labelledby="tab9-link">
                                            <h4 class="  mb-3">Maklumat Pelupusan Vesel</h4>
                                            <small class="text-muted d-block mb-3">
                                                Maklumat berikut menunjukkan cara pelupusan vesel oleh pemohon sama ada melalui jualan atau penamatan lesen.
                                            </small>
                                            <hr>
                                            <section>
                                            @if(isset($dispose))
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <td class="col-md-4">Jenis Permohonan </td>
                                                        <td class="col-md-1 text-center">:</td>
                                                        <td>
                                                            {{ $dispose['jenisPermohonan'] === 'lupus' ? 'Lupus' : 'Ganti Kulit' }}

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-4">Tindakan Pelupusan</td>
                                                        <td class="col-md-1 text-center">:</td>
                                                        <td>
                                                            {{-- {{ $dispose['jenisPermohonan'] === 'lupus' ? 'Lupus' : 'Ganti Kulit' }} --}}
                                                            {{ $dispose['main_disposal_action'] === 'jual' ? 'Jual Vesel' : 'Lupus & Tamat Lesen' }}
                                                        </td>
                                                    </tr>

                                                    @if($dispose['main_disposal_action'] === 'jual')
                                                    <tr>
                                                        <td>Jenis Jualan</td>
                                                        <td class="text-center">:</td>
                                                        <td>
                                                            {{ $dispose['disposal_type'] === 'dalam_industri' ? 'Dalam Industri' : 'Luar Industri' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nama Pemilik Baharu</td>
                                                        <td class="text-center">:</td>
                                                        <td>{{ $dispose['new_owner_name'] ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>No. Telefon Pemilik Baharu</td>
                                                        <td class="text-center">:</td>
                                                        <td>{{ $dispose['new_owner_phone'] ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>No. Kad Pengenalan Pemilik Baharu</td>
                                                        <td class="text-center">:</td>
                                                        <td>{{ $dispose['new_owner_ic'] ?? '-' }}</td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                            @else
                                         <div class="alert alert-warning">Tiada maklumat pelupusan vesel direkodkan.</div>
                                            @endif
                                            </section>


                                            <section>
                                                <h4 class="  mb-3">Laporan Pelupusan Vesel</h4>
                                                <small class="text-muted d-block mb-3">
                                                    Berikut adalah maklumat pelupusan vesel yang telah direkodkan.
                                                </small>
                                                <hr>

                                                <table class="table table-borderless">
    <tbody>
        <tr>
            <td class="col-md-4">Tarikh Pelupusan</td>
            <td class="col-md-1 text-center">:</td>
            <td>{{ $disposeOff->disposal_time ? \Carbon\Carbon::parse($disposeOff->disposal_time)->format('d/m/Y') : '-' }}</td>
        </tr>
        <tr>
            <td>Lokasi Pelupusan</td>
            <td class="text-center">:</td>
            <td>{{ $disposeOff->disposal_location ?? '-' }}</td>
        </tr>
        <tr>
            <td>Kaedah Pelupusan</td>
            <td class="text-center">:</td>
            <td>{{ ucfirst(strtolower($disposeOff->disposal_method ?? '-')) }}</td>
        </tr>

        <!-- Borang Kehadiran with Modal Preview -->
        <tr>
            <td>Borang Kehadiran</td>
            <td class="text-center">:</td>
            <td>
                @if ($disposeOff->attendance_form_image)
                    <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#modalAttendanceForm">
                        <i class="fa fa-search"></i>
                    </button>
                @else
                    -
                @endif
            </td>
        </tr>

        <!-- Gambar Sebelum Pelupusan with Modal Preview -->
        <tr>
            <td>Gambar Sebelum Pelupusan</td>
            <td class="text-center">:</td>
            <td>
                @if ($disposeOff->before_disposal_image)
                    <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#modalBeforeImage">
                        <i class="fa fa-search"></i>
                    </button>
                @else
                    Tiada gambar
                @endif
            </td>
        </tr>

        <!-- Gambar Selepas Pelupusan with Modal Preview -->
        <tr>
            <td>Gambar Selepas Pelupusan</td>
            <td class="text-center">:</td>
            <td>
                @if ($disposeOff->after_disposal_image)
                    <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#modalAfterImage">
                        <i class="fa fa-search"></i>
                    </button>
                @else
                    Tiada gambar
                @endif
            </td>
        </tr>
    </tbody>
</table>

<!-- Modal for Borang Kehadiran -->
@if ($disposeOff->attendance_form_image)
<div class="modal fade" id="modalAttendanceForm" tabindex="-1" aria-labelledby="modalAttendanceFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAttendanceFormLabel">Pratonton Borang Kehadiran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body" style="height: 80vh;">
                <iframe src="{{ route('gantiKulit.laporanLpiLupus-06.viewInspectionDocument', ['id' => $disposeOff->id, 'field' => 'attendance_form_image']) }}"
                        style="width: 100%; height: 100%; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Modal for Gambar Sebelum Pelupusan -->
@if ($disposeOff->before_disposal_image)
<div class="modal fade" id="modalBeforeImage" tabindex="-1" aria-labelledby="modalBeforeImageLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalBeforeImageLabel">Pratonton Gambar Sebelum Pelupusan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body" style="height: 80vh;">
                <iframe src="{{ route('gantiKulit.laporanLpiLupus-06.viewInspectionDocument', ['id' => $disposeOff->id, 'field' => 'before_disposal_image']) }}"
                        style="width: 100%; height: 100%; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Modal for Gambar Selepas Pelupusan -->
@if ($disposeOff->after_disposal_image)
<div class="modal fade" id="modalAfterImage" tabindex="-1" aria-labelledby="modalAfterImageLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAfterImageLabel">Pratonton Gambar Selepas Pelupusan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body" style="height: 80vh;">
                <iframe src="{{ route('gantiKulit.laporanLpiLupus-06.viewInspectionDocument', ['id' => $disposeOff->id, 'field' => 'after_disposal_image']) }}"
                        style="width: 100%; height: 100%; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>
@endif

                                            </section>



                                        </div>

                                            <!---->

                                            {{-- @php
                                            // Ensure this is passed from the controller
                                            $isStillValid = $isStillValid ?? false;
                                            @endphp --}}

                                          <div class="tab-pane fade" id="content-tab10" role="tabpanel" aria-labelledby="tab10-link">
                                            <form method="POST" id="submitsemakanDokumen"
                                                action="{{ route('gantiKulit.semakanLupus-06.store', $application->id) }}">
                                                @csrf

                                                  <!-- Semakan -->
                                                <div class="card-header mb-3 pl-0 mt-4">
                                                    <h4 class="fw-bold mb-0">Semakan</h4>
                                                    <small class="text-muted">Sila pilih status semakan borang
                                                        ini</small>
                                                </div>
                                                <div class="d-flex gap-4 mb-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="review_flag"
                                                            id="lengkap" value="1">
                                                        <label class="form-check-label" for="lengkap">Lengkap</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="review_flag"
                                                            id="tidak_lengkap" value="0">
                                                        <label class="form-check-label" for="tidak_lengkap">Tidak
                                                            Lengkap</label>
                                                    </div>
                                                </div>

                                                <!-- Pengesahan (Conditional) -->
                                                <div id="pengesahanSection" style="display: none;">
                                                    <div class="card-header mb-3 pl-0">
                                                        <h4 class="fw-bold mb-0">Pengesahan</h4>
                                                        <small class="text-muted">Sila buat pengesahan terhadap
                                                            maklumat resit ini</small>
                                                    </div>
                                                    <div class="d-flex gap-4 mb-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="confirmation_flag" id="sah" value="1">
                                                            <label class="form-check-label" for="sah">Sah</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="confirmation_flag" id="tidak_sah" value="0">
                                                            <label class="form-check-label" for="tidak_sah">Tidak
                                                                Sah</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Ulasan -->
                                                <div class="card-header mb-3 pl-0">
                                                    <h4 class="fw-bold mb-0">Ulasan</h4>
                                                    <small class="text-muted">Berikan ulasan terhadap semakan dan
                                                        pengesahan ini</small>
                                                </div>
                                                <textarea name="remarks" class="form-control mb-4" rows="4"
                                                    placeholder="Masukkan ulasan..."></textarea>
                                            </form>
                                        </div>


                                      @push('scripts')
                                            <script>
                                                $(document).ready(function () {
                                                $('input[name="review_flag"]').on('change', function () {
                                                    if ($(this).val() === '1') {
                                                        $('#pengesahanSection').slideDown();
                                                    } else {
                                                        $('#pengesahanSection').slideUp();
                                                        $('input[name="confirmation_flag"]').prop('checked', false);
                                                    }
                                                });
                                            });
                                            </script>
                                            @endpush


                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <div class="d-flex justify-content-end gap-3">
                                            <!-- Back and Next Buttons -->
                                            <div class="d-flex gap-3">
                                                <button id="backTabBtn" type="button" class="btn btn-light"
                                                    style="width:120px">Kembali</button>
                                                <button id="nextTabBtn" type="button" class="btn btn-light"
                                                    style="width:120px">Seterusnya</button>
                                            </div>

                                            <!-- Submit Buttons -->
                                            <div class="d-flex gap-3">

                                                <!-- Hantar Button -->
                                                <button id="submitBtn" type="submit" form="submitsemakanDokumen"
                                                    class="btn btn-success" style="width:120px; display:none;">
                                                    Hantar
                                                </button>
                                            </div>
                                        </div>
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

    {{-- Convert Data --}}
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

    <script>
    let currentTab = 1;
    const totalTabs = 10; // updated from 9 to 10

    const switchTab = (direction) => {
        const newTab = currentTab + direction;
        if (newTab < 1 || newTab > totalTabs) {
            alert(`Ini adalah tab ${newTab < 1 ? 'pertama' : 'terakhir'}.`);
            return;
        }

        document.getElementById(`tab${currentTab}-link`).classList.remove("active");
        document.getElementById(`content-tab${currentTab}`).classList.remove("show", "active");

        currentTab = newTab;

        document.getElementById(`tab${currentTab}-link`).classList.add("active");
        document.getElementById(`content-tab${currentTab}`).classList.add("show", "active");

        document.getElementById('submitBtn').style.display = (currentTab === totalTabs) ? 'inline-block' : 'none';
    };

    document.addEventListener("DOMContentLoaded", () => {
        document.getElementById("nextTabBtn").onclick = () => switchTab(1);
        document.getElementById("backTabBtn").onclick = () => switchTab(-1);

        // Hide submit button on load
        document.getElementById('submitBtn').style.display = 'none';
    });
</script>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @endpush
