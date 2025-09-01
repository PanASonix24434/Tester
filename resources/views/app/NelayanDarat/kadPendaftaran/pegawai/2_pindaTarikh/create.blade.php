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
                        <h3 class="mb-0">{{ $applicationType->name }}</h3>
                        <small>{{ $moduleName->name }} - {{ $roleName }}</small>
                    </div>
                </div>
                <div class="col-md-6 align-content-center">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
                        <ol class="breadcrumb text-center">
                            <li class="breadcrumb-item"><a
                                    href="http://127.0.0.1:8000/kadPendaftaran/semakanDokumen-08">{{
                                    \Illuminate\Support\Str::ucfirst(strtolower($applicationType->name)) }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $moduleName->name }}</a></li>
                            {{-- <li class="breadcrumb-item active" aria-current="page">semakanDokumen</a></li> --}}

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
                                                                value="{{ $userDetail->name ?? 'TIDAK DIKETAHUI' }}"
                                                                readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>No. Kad Pengenalan</td>
                                                        <td>:</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $userDetail->icno ?? 'TIDAK DIKETAHUI' }}"
                                                                readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pangkalan</td>
                                                        <td>:</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $jetty->jetty_name ?? 'TIDAK DIKETAHUI' }}"
                                                                readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>No. Pendaftaran Vesel</td>
                                                        <td>:</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $vessel->registration_number ?? 'Tiada Vesel' }}"
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
                                                        <td class="col-md-3">Jenis Permohonan</td>
                                                        <td class="col-md-1">:</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $application->applicationType->name ?? 'TIDAK DIKETAHUI' }}"
                                                                readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>No. Rujukan</td>
                                                        <td>:</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $application->no_rujukan ?? 'TIDAK DIKETAHUI' }}"
                                                                readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tarikh Permohonan</td>
                                                        <td>:</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $application->created_at?->format('d-m-Y') ?? 'TIDAK DIKETAHUI' }}"
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
                                                <a class="nav-link custom-nav-link " id="tab1-link"
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
                                                    aria-disabled="true">Tindakan </a>
                                            </li>
                                        </ul>

                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content" id="pills-tabContent">
                                            <!-- -->
                                            <div class="tab-pane fade   p-4 pt-0" id="content-tab1"
                                                role="tabpanel" aria-labelledby="tab1-link">

                                                <h5 class="fw-bold mb-0">Maklumat Peribadi</h5>
                                                <small class="text-muted">Sila isikan maklumat peribadi anda dengan
                                                    lengkap</small>
                                                <hr>

                                                <table class="table-borderless table">
                                                    <tbody>
                                                        <tr>
                                                            <td class="col-md-4">Nama</td>
                                                            <td class="col-md-1 text-center">:</td>
                                                           <td>{{ strtoupper($userDetail->name ?? 'TIDAK DIKETAHUI') }}</td>

                                                        </tr>
                                                        <tr>
                                                            <td>No. I/C</td>
                                                            <td class="text-center">:</td>
                                                            <td>
                                                                {{ $userDetail->icno ??
                                                                'Tidak
                                                                Diketahui' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>No. Telefon</td>
                                                            <td class="text-center">:</td>
                                                            <td>{{ $userDetail->no_phone ?? 'TIDAK DIKETAHUI' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>No. Telefon (Kedua)</td>
                                                            <td class="text-center">:</td>
                                                            <td>{{ $userDetail->secondary_phone_number ?? '-' }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <br>

                                                <h5 class="fw-bold mb-0">Alamat Kediaman</h5>
                                                <small class="text-muted">Alamat lengkap tempat tinggal</small>
                                                <hr>

                                                <table class="table-borderless table">
                                                    <tbody>
                                                        <tr>
                                                            <td class="col-md-4">Alamat</td>
                                                            <td class="col-md-1 text-center">:</td>
                                                           <td>{{ strtoupper(($userDetail->address1 ?? '') . ' ' . ($userDetail->address2 ?? '') . ' ' . ($userDetail->address3 ?? '')) }}</td>

                                                        </tr>
                                                        <tr>
                                                            <td>Poskod</td>
                                                            <td class="text-center">:</td>
                                                            <td>{{ $userDetail->poskod ?? 'TIDAK DIKETAHUI' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Daerah</td>
                                                            <td class="text-center">:</td>
                                                            <td>{{ $userDetail->district ?? 'TIDAK DIKETAHUI' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Negeri</td>
                                                            <td class="text-center">:</td>
                                                            <td>{{ $userDetail->state ?? 'TIDAK DIKETAHUI' }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <br>

                                                <h5 class="fw-bold mb-0">Alamat Surat-Menyurat</h5>
                                                <small class="text-muted">Alamat untuk tujuan surat-menyurat</small>
                                                <hr>

                                                <table class="table-borderless table">
                                                    <tbody>
                                                        <tr>
                                                            <td class="col-md-4">Alamat</td>
                                                            <td class="col-md-1 text-center">:</td>
                                                           <td>
    {{
        strtoupper(
            collect([
                $userDetail->secondary_address_1 ?? null,
                $userDetail->secondary_address_2 ?? null,
                $userDetail->secondary_address_3 ?? null
            ])
            ->filter()
            ->implode(', ')
        ) ?: 'TIDAK DIKETAHUI'
    }}
</td>

                                                        </tr>
                                                        <tr>
                                                            <td>Poskod</td>
                                                            <td class="text-center">:</td>
                                                           <td>{{ $userDetail->secondary_postcode  ?? 'TIDAK DIKETAHUI' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Daerah</td>
                                                            <td class="text-center">:</td>
                                                            <td>{{ $userDetail->secondary_district ?? 'TIDAK DIKETAHUI' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Negeri</td>
                                                            <td class="text-center">:</td>
                                                            <td>{{ $userDetail->secondary_state   ?? 'TIDAK DIKETAHUI' }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <br>

                                                <h5 class="fw-bold mb-0">Maklumat Sebagai Nelayan</h5>
                                                <small class="text-muted">Maklumat berkaitan pengalaman dan aktiviti
                                                    sebagai nelayan</small>
                                                <hr>

                                                <table class="table-borderless table">
                                                    <tr>
                                                        <td class="col-md-4">Tahun Menjadi Nelayan</td>
                                                        <td class="col-md-1 text-center">:</td>
                                                        <td>
                                                            {{ $fishermanInfo['year_become_fisherman'] ??
                                                            'TIDAK DIKETAHUI' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tempoh Menjadi Nelayan</td>
                                                        <td class="text-center">:</td>
                                                        <td>{{ $fishermanInfo['becoming_fisherman_duration'] ?? 'TIDAK DIKETAHUI' }}
                                                            TAHUN</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Hari Bekerja Menangkap Ikan Sebulan</td>
                                                        <td class="text-center">:</td>
                                                        <td>{{ $fishermanInfo['working_days_fishing_per_month'] ??
                                                            'TIDAK DIKETAHUI' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pendapatan Tahunan Dari Menangkap Ikan</td>
                                                        <td class="text-center">:</td>
                                                        <td>RM
                                                            {{
                                                            number_format($fishermanInfo['estimated_income_yearly_fishing']
                                                            ?? 0, 2) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pendapatan Dari Pekerjaan Lain</td>
                                                        <td class="text-center">:</td>
                                                        <td>RM
                                                            {{
                                                            number_format($fishermanInfo['estimated_income_other_job']
                                                            ?? 0, 2) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Hari Bekerja Di Pekerjaan Lain</td>
                                                        <td class="text-center">:</td>
                                                        <td>{{ $fishermanInfo['days_working_other_job_per_month'] ?? '-'
                                                            }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Menerima Pencen</td>
                                                        <td class="text-center">:</td>
                                                        <td>{{ ($fishermanInfo['receive_pension'] ?? 0) == 1 ? 'YA' :
                                                            'TIDAK' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Menerima Bantuan Kewangan</td>
                                                        <td class="text-center">:</td>
                                                        <td>{{ ($fishermanInfo['receive_financial_aid'] ?? 0) == 1 ?
                                                            'YA' : 'TIDAK' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pencarum KWSP</td>
                                                        <td class="text-center">:</td>
                                                        <td>{{ ($fishermanInfo['epf_contributor'] ?? 0) == 1 ? 'YA' :
                                                            'TIDAK' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Agensi Memberi Bantuan</td>
                                                        <td class="text-center">:</td>
                                                        <td>
                                                            @php
                                                            $agencies = $fishermanInfo['financial_aid_agencyData'] ?? [];
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
                                                </table>

                                            </div>

                                            <div class="tab-pane fade p-4" id="content-tab2" role="tabpanel"
                                                aria-labelledby="tab2-link">
                                                <h5 class="fw-bold mb-0">Maklumat Pangkalan Pendaratan</h5>
                                                <small class="text-muted">Sila semak maklumat pangkalan yang telah
                                                    dipilih</small>
                                                <hr>
@php use Illuminate\Support\Str; @endphp

<table class="table-borderless table">
    <tbody>
        <tr>
            <td class="col-md-4">Negeri</td>
            <td class="col-md-1">:</td>
            <td>{{ isset($jettyInfo['state']) ? Str::upper($jettyInfo['state']) : 'TIDAK DIKETAHUI' }}</td>
        </tr>
        <tr>
            <td>Daerah</td>
            <td>:</td>
            <td>{{ isset($jettyInfo['district']) ? Str::upper($jettyInfo['district']) : 'TIDAK DIKETAHUI' }}</td>
        </tr>
        <tr>
            <td>Nama Sungai/Tasik</td>
            <td>:</td>
            <td>{{ isset($jettyInfo['river']) ? Str::upper($jettyInfo['river']) : 'TIDAK DIKETAHUI' }}</td>
        </tr>
        <tr>
            <td>Pangkalan</td>
            <td>:</td>
            <td>{{ isset($jettyInfo['jetty_name']) ? Str::upper($jettyInfo['jetty_name']) : 'TIDAK DIKETAHUI' }}</td>
        </tr>
    </tbody>
</table>

                                                <br>

                                            </div>

                                         <div class="tab-pane fade p-4" id="content-tab3" role="tabpanel" aria-labelledby="tab3-link">
                       <div class="mb-3">
    <h5 class="fw-bold">Maklumat Peralatan</h5>
    <small class="text-muted">Bahagian ini memaparkan maklumat peralatan menangkap ikan yang dimohon oleh pemohon.</small>
    <hr>
</div>
        <table class="table table-borderless">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%">Bil</th>
                    <th>Nama Peralatan</th>
                    <th>Jenis Peralatan</th>
                    <th>Kuantiti</th>
                    <th>Fail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($equipmentList as $index => $equipment)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ e($equipment['name'] ?? 'TIDAK DIKETAHUI') }}</td>
                        <td>
                            @if ($equipment['type'] === 'UTAMA')
                                UTAMA
                            @elseif ($equipment['type'] === 'TAMBAHAN')
                                TAMBAHAN
                            @else
                                Tidak Diketahui
                            @endif
                        </td>
                        <td>{{ $equipment['quantity'] ?? 'TIDAK DIKETAHUI' }}</td>
                        <td>
                            @if (!empty($equipment['file_path']))
                            <a href="#" class="btn btn-primary"
   onclick="window.open('{{ route('kadPendaftaran.semakanDokumen-08.viewTempEquipment', [
       'type' => $equipment['type'],
       'index' => $index,
       'application_id' => $application->id
   ]) }}', 'equipmentWindow', 'width=1200,height=800,scrollbars=yes,resizable=yes'); return false;">
    <i class="fa fa-search p-1"></i>
</a>

                            @else
                                <span class="text-muted">Tiada Fail</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-muted text-center">Tiada peralatan direkodkan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
</div>

                                            <div class="tab-pane fade p-4" id="content-tab4" role="tabpanel" aria-labelledby="tab4-link">
                                            <div class="mb-4">
                                                <h5 class="fw-bold mb-0">Maklumat Pemilikan Vesel</h5>
                                                <small class="text-muted">Maklumat ini memaparkan butiran pemilikan vesel.</small>
                                                <hr>
                                            </div>

                                            <table class="table-borderless table">
                                                <tbody>
                                                    @if (($vesselInfo['has_vessel'] ?? '') === 'no' && !empty($vesselInfo['transport_type']))
                                                        <tr>
                                                            <td class="col-md-4">Jenis Pengangkutan Digunakan</td>
                                                            <td class="col-md-1 text-center">:</td>
                                                            <td>{{ $vesselInfo['transport_type'] }}</td>
                                                        </tr>
                                                    @endif

                                                    @if (($vesselInfo['has_vessel'] ?? '') === 'yes')
                                                        <tr>
                                                            <td class="col-md-4 fw-bold " colspan="3">Maklumat Vesel</td>
                                                        </tr>

                                                        @if (!empty($vesselInfo['vessel_registration_number']))
                                                            <tr>
                                                                <td class="col-md-4">No. Pendaftaran Vesel</td>
                                                                <td class="col-md-1 text-center">:</td>
                                                                <td>{{ $vesselInfo['vessel_registration_number'] }}</td>
                                                            </tr>
                                                        @endif

                                                        @if (!empty($vesselInfo['hull_type']))
                                                            <tr>
                                                                <td>Jenis Kulit Vesel</td>
                                                                <td class="text-center">:</td>
                                                                <td>{{ $vesselInfo['hull_type'] }}</td>
                                                            </tr>
                                                        @endif

                                                        @if (!empty($vesselInfo['length']))
                                                            <tr>
                                                                <td>Panjang (m)</td>
                                                                <td class="text-center">:</td>
                                                                <td>{{ $vesselInfo['length'] }}</td>
                                                            </tr>
                                                        @endif

                                                        @if (!empty($vesselInfo['width']))
                                                            <tr>
                                                                <td>Lebar (m)</td>
                                                                <td class="text-center">:</td>
                                                                <td>{{ $vesselInfo['width'] }}</td>
                                                            </tr>
                                                        @endif

                                                        @if (!empty($vesselInfo['depth']))
                                                            <tr>
                                                                <td>Kedalaman (m)</td>
                                                                <td class="text-center">:</td>
                                                                <td>{{ $vesselInfo['depth'] }}</td>
                                                            </tr>
                                                        @endif

                                                        @if (($vesselInfo['has_engine'] ?? '') === 'yes')
                                                            <tr>
                                                                <td class="fw-bold" colspan="3">Maklumat Enjin</td>
                                                            </tr>

                                                            @if (!empty($vesselInfo['engine_model']))
                                                                <tr>
                                                                    <td>Model Enjin</td>
                                                                    <td class="text-center">:</td>
                                                                    <td>{{ $vesselInfo['engine_model'] }}</td>
                                                                </tr>
                                                            @endif

                                                            @if (!empty($vesselInfo['horsepower']))
                                                                <tr>
                                                                    <td>Kuasa Kuda (KK)</td>
                                                                    <td class="text-center">:</td>
                                                                    <td>{{ $vesselInfo['horsepower'] }}</td>
                                                                </tr>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>

                                            <div class="tab-pane fade p-4" id="content-tab5" role="tabpanel"
                                                aria-labelledby="tab5-link">
                                                <h5 class="fw-bold mb-0">Dokumen Berkaitan</h5>
                                                <small class="text-muted">Senarai dokumen berkaitan permohonan
                                                    ini</small>
                                                <hr>

                                                @if (!empty($documents))
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
                                                            <td>{{ $doc['title'] ?? 'TIDAK DIKETAHUI' }}</td>
                                                         <td>
    @if (!empty($doc['file_path']))
        <a href="#" class="btn btn-primary"
           onclick="window.open('{{ route('kadPendaftaran.semakanDokumen-08.viewTempDocument', [
               'index' => $index,
               'application_id' => $application->id
           ]) }}', 'docWindow{{ $index }}', 'width=1200,height=800,scrollbars=yes,resizable=yes'); return false;">
            <i class="fa fa-search p-1"></i>
        </a>
    @else
        <span class="text-muted">Tiada Fail</span>
    @endif
</td>

                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                @endif

                                            </div>

                                            <div class="tab-pane fade p-4" id="content-tab6" role="tabpanel"
                                                aria-labelledby="tab6-link">
                                                <div class="w-100 d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h5 class="fw-bold mb-0">Rekod Kesalahan</h5>
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
                                                            action="{{ route('kadPendaftaran.semakanDokumen-08.updateFault', ['application_id' => $application->id]) }}"
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
        <a href="#" class="btn btn-primary"
           onclick="window.open('{{ route('kadPendaftaran.semakanDokumen-08.viewFaultRecord', [
               'application_id' => $application->id,
               'record_id' => $rekod->id
           ]) }}', 'faultDocWindow{{ $rekod->id }}', 'width=1200,height=800,scrollbars=yes,resizable=yes'); return false;">
            <i class="fa fa-search p-1"></i>
        </a>
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

                                                    <h5 class="fw-bold mb-0">Maklumat Pendaratan</h5>
                                                    <small class="text-muted">Maklumat berkaitan hasil tangkapan dan
                                                        pendaratan ikan</small>
                                                </div>
@php
    $pendaratanDoc = collect($documents)->firstWhere('title', 'Borang Pengisytiharan Pendaratan');
@endphp

@if ($pendaratanDoc && !empty($pendaratanDoc['file_path']))
    <div class="mb-4 text-center">
        <h5 class="fw-bold mb-3">{{ strtoupper($pendaratanDoc['title']) }}</h5>

        <div class="d-flex justify-content-center">
            <iframe
                src="{{ route('kadPendaftaran.semakanDokumen-08.viewTempDocument', [
                    'index' => array_search($pendaratanDoc, $documents),
                    'application_id' => $application->id
                ]) }}"
                style="width: 80%; height: 800px;"
                frameborder="0"
                class="mx-auto">
            </iframe>
        </div>
    </div>
@else
    <div class="alert alert-warning text-center">
        Dokumen "Borang Pengisytiharan Pendaratan" tidak dijumpai atau tiada fail dimuat naik.
    </div>
@endif

                                            </div>

                                            <div class="tab-pane fade" id="content-tab8" role="tabpanel"
                                                aria-labelledby="tab8-link">
                                                <h5>Status Permohonan</h5>
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
                                                                        {{ $log->applicationStatus->name ?? 'Tidak
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
                                                                                'TIDAK DIKETAHUI') }}
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
                                            <!---->

                                                <div class="tab-pane fade" id="content-tab9" role="tabpanel"
                                                    aria-labelledby="tab10-link">
                                                    <div class="p-4">

                                                         <form method="POST" id="submitSemakan"
                                                    action="{{ route('kadPendaftaran.pindaLpi-08.store', $application->id) }}">
                                                    @csrf


                                                        <!-- Cadangan Tarikh Pemeriksaan Vesel (readonly) -->
                                                        <div class="card-header mb-3 pl-0">
                                                        <h5 class="fw-bold mb-0">Tindakan</h5>
                                                        <small class="text-muted">
                                                            Bahagian ini membolehkan pemohon mencadangkan tarikh baharu, memilih daripada tarikh yang telah dicadangkan, dan memberikan ulasan berkaitan tindakan lanjut.
                                                        </small>
                                                    </div>

                                                    <label for="">Cadangan Tarikh Pemeriksaan Vesel</label><br>
                                                    <small>Tarikh cadangan semasa</small>
                                                        <input type="date" class="form-control mb-4"
                                                            value="{{ $application->inspection_date ? \Carbon\Carbon::parse($application->inspection_date)->format('Y-m-d') : '' }}"
                                                            readonly>

                                                        <!-- Pengesahan -->
                                                        <div class="  mb-3 pl-0">
                                                            <label class="fw-bold mb-0">Pengesahan</label><br>
                                                            <small class="text-muted">Sila sahkan atau pinda tarikh
                                                                cadangan pemeriksaan</small>
                                                        </div>
                                                        <div class="d-flex gap-4 mb-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="confirmation_flag" id="sahkan" value="1">
                                                                <label class="form-check-label"
                                                                    for="sahkan">Sahkan</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="confirmation_flag" id="pinda" value="0">
                                                                <label class="form-check-label"
                                                                    for="pinda">Pinda</label>
                                                            </div>
                                                        </div>

                                                        <!-- Pinda Tarikh Baharu (slidable) -->
                                                        <div id="pindaField" style="display: none;">
                                                            <div class="  mb-3 pl-0">
                                                                <label class="fw-bold mb-0">Pinda Tarikh Baharu</label>
                                                                <small class="text-muted">Sila masukkan tarikh baharu
                                                                    jika ingin meminda tarikh cadangan</small>
                                                            </div>
                                                    <input type="date" name="new_inspection_date"
                                                        class="form-control mb-4"
                                                        min="{{ \Carbon\Carbon::today()->toDateString() }}">

                                                        </div>

                                                        <!-- Ulasan -->
                                                        <div class="mb-3 pl-0">
                                                            <label class="fw-bold mb-0">Ulasan</label><br>
                                                            <small class="text-muted">Sila nyatakan ulasan terhadap
                                                                pengesahan atau pindaan ini</small>
                                                        </div>
                                                        <textarea name="remarks" rows="4" class="form-control mb-4"
                                                            placeholder="Masukkan ulasan..."></textarea>

                                                    </div>
                                                </div>

                                                @push('scripts')
                                                <script>
                                                    $(document).ready(function() {
                                                                $('input[name="confirmation_flag"]').on('change', function() {
                                                                    if ($(this).val() === '0') {
                                                                        $('#pindaField').slideDown();
                                                                    } else {
                                                                        $('#pindaField').slideUp();
                                                                        $('input[name="new_inspection_date"]').val('');
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
                                                    <button id="submitBtn" type="submit" form="submitSemakan"
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
                </form>
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
    const totalTabs = 9;

    const switchTab = (direction) => {
        const newTab = currentTab + direction;
        if (newTab < 1 || newTab > totalTabs) return;

        document.getElementById(`tab${currentTab}-link`).classList.remove("active");
        document.getElementById(`content-tab${currentTab}`).classList.remove("show", "active");

        currentTab = newTab;

        document.getElementById(`tab${currentTab}-link`).classList.add("active");
        document.getElementById(`content-tab${currentTab}`).classList.add("show", "active");

        sessionStorage.setItem('lastTab', currentTab);
        toggleButtons();
    };

    const toggleButtons = () => {
        document.getElementById('backTabBtn').style.display = currentTab === 1 ? 'none' : 'inline-block';
        document.getElementById('nextTabBtn').style.display = currentTab === totalTabs ? 'none' : 'inline-block';
        document.getElementById('submitBtn').style.display = currentTab === totalTabs ? 'inline-block' : 'none';
    };

    const activateTab = (tabNumber) => {
        // Deactivate current tab
        document.querySelectorAll('.nav-link').forEach(el => el.classList.remove("active"));
        document.querySelectorAll('.tab-pane').forEach(el => el.classList.remove("show", "active"));

        currentTab = tabNumber;

        // Activate new tab
        document.getElementById(`tab${currentTab}-link`).classList.add("active");
        document.getElementById(`content-tab${currentTab}`).classList.add("show", "active");

        toggleButtons();
    };

    document.addEventListener("DOMContentLoaded", () => {
        const lastTab = parseInt(sessionStorage.getItem('lastTab'));

        if (!isNaN(lastTab) && lastTab >= 1 && lastTab <= totalTabs) {
            activateTab(lastTab);
        } else {
            activateTab(1); // Default to Tab 1
        }

        document.getElementById("nextTabBtn").onclick = () => switchTab(1);
        document.getElementById("backTabBtn").onclick = () => switchTab(-1);

        // Clear tab memory on form submission
        const form = document.getElementById("submitSemakan");
        if (form) {
            form.addEventListener("submit", () => {
                sessionStorage.removeItem('lastTab');
            });
        }
    });
</script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
                const cadangTarikhContainer = $('#cadangTarikhContainer');
                const cadangTarikhInput = $('#dateCadang');

                function toggleCadangTarikh() {
                    if ($('#semakan_1').is(':checked')) {
                        cadangTarikhContainer.slideDown();
                        cadangTarikhInput.prop('required', true);
                    } else {
                        cadangTarikhContainer.slideUp();
                        cadangTarikhInput.prop('required', false).val('');
                    }
                }

                // Event listeners
                $('#semakan_1, #semakan_2').on('change', toggleCadangTarikh);

                // Initial check on page load
                toggleCadangTarikh();
            });
    </script>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @endpush
