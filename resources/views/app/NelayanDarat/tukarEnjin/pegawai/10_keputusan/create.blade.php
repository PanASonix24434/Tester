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
                        <small>{{$moduleName->name}} - {{$roleName}}</small>
                    </div>
                </div>
                <div class="col-md-6 align-content-center">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="d-flex   justify-content-end">
                        <ol class="breadcrumb text-center">
                            <li class="breadcrumb-item"><a href="http://127.0.0.1:8000/tukarEnjin/keputusanR-05">{{ \Illuminate\Support\Str::ucfirst(strtolower($applicationType->name)) }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$moduleName->name}}</a></li>
                            {{-- <li class="breadcrumb-item active" aria-current="page">Permohonan</a></li> --}}

                        </ol>
                    </nav>
                </div>

            </div>
            <div>
                <div class="row">
                    <div class="col-12">

                        <form method="POST" id="submitPermohonan" action="{{ route('tukarEnjin.keputusanR-05.store', $application->id) }}">
                            @csrf
                            <div class="card card-primary card-tabs">
                                <div class="card-header"></div>
                                <div class="card-body">

                                    <div class="border p-5" style="border-radius: 20px">
                                        <div class="row">
                                            <!-- Left Column -->
                                            <div class="col-md-6">
                                                <table class="table table-borderless">
                                                    <tbody>
                                                        <tr>
                                                            <td class="col-md-3">Nama Pemohon</td>
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
                                                                <input type="text" class="form-control" value="{{ $jetty->jetty_name ?? 'Tidak Diketahui' }}" readonly>
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
                                                <table class="table table-borderless">
                                                    <tbody>
                                                        <tr>
                                                            <td class="col-md-3">Jenis Permohonan</td>
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
                                    </div>

                                    <br>

                                    <div class="card card-primary">
                                        <div class="card-header pb-0">
                                            <ul class="nav nav-tabs" id="pills-tab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link custom-nav-link active" id="tab1-link" aria-disabled="true"> Pemohon</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link custom-nav-link" id="tab2-link" aria-disabled="true"> Pangkalan</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link custom-nav-link" id="tab3-link" aria-disabled="true"> Peralatan</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link custom-nav-link" id="tab4-link" aria-disabled="true"> Vesel</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link custom-nav-link" id="tab5-link" aria-disabled="true">Dokumen </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link custom-nav-link" id="tab6-link" aria-disabled="true">Rekod Kesalahan </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link custom-nav-link" id="tab7-link" aria-disabled="true">Pendaratan </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link custom-nav-link" id="tab8-link" aria-disabled="true">Status </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link custom-nav-link" id="tab9-link" aria-disabled="true">Tindakan </a>
                                                </li>
                                            </ul>

                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content" id="pills-tabContent">
                                                <div class="tab-pane fade p-4 pt-0 show active" id="content-tab1" role="tabpanel" aria-labelledby="tab1-link">

                                                    <h5 class="fw-bold mb-0">Maklumat Peribadi</h5>
                                                    <small class="text-muted">Sila isikan maklumat peribadi anda dengan lengkap</small>
                                                    <hr>

                                                    <table class="table table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <td class="col-md-4">Nama</td>
                                                                <td class="col-md-1 text-center">:</td>
                                                                <td>{{ $user_detail->name ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>No. I/C</td>
                                                                <td class="text-center">:</td>
                                                                <td>{{ $user_detail->identity_card_number ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>No. Telefon</td>
                                                                <td class="text-center">:</td>
                                                                <td>{{ $user_detail->phone_number ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    <br>

                                                    <h5 class="fw-bold mb-0">Alamat Surat-Menyurat</h5>
                                                    <small class="text-muted">Alamat lengkap surat-menyurat</small>
                                                    <hr>

                                                    <table class="table table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <td class="col-md-4">Alamat</td>
                                                                <td class="col-md-1 text-center">:</td>
                                                                <td>{{ $user_detail->address ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Poskod</td>
                                                                <td class="text-center">:</td>
                                                                <td>{{ $user_detail->postcode ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Daerah</td>
                                                                <td class="text-center">:</td>
                                                                <td>{{ $user_detail->district ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Negeri</td>
                                                                <td class="text-center">:</td>
                                                                <td>{{ $user_detail->state ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    <br>

                                                    <h5 class="fw-bold mb-0">Maklumat Sebagai Nelayan</h5>
                                                    <small class="text-muted">Maklumat berkaitan pengalaman dan aktiviti sebagai nelayan</small>
                                                    <hr>

                                                    <table class="table table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <td class="col-md-4">Tahun Menjadi Nelayan</td>
                                                                <td class="col-md-1 text-center">:</td>
                                                                <td>{{ $fishermanInfo->year_become_fisherman ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Tempoh Menjadi Nelayan (Tahun)</td>
                                                                <td class="text-center">:</td>
                                                                <td>{{ $fishermanInfo->becoming_fisherman_duration ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Hari Bekerja Menangkap Ikan Sebulan</td>
                                                                <td class="text-center">:</td>
                                                                <td>{{ $fishermanInfo->working_days_fishing_per_month ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pendapatan Tahunan Dari Menangkap Ikan</td>
                                                                <td class="text-center">:</td>
                                                                <td>{{ $fishermanInfo->estimated_income_yearly_fishing ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    <br>

                                                    <h5 class="fw-bold mb-0">Maklumat Pekerjaan Lain</h5>
                                                    <small class="text-muted">Sekiranya anda mempunyai pekerjaan lain, berikut adalah maklumat tersebut</small>
                                                    <hr>

                                                    <table class="table table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <td class="col-md-4">Pendapatan Dari Pekerjaan Lain</td>
                                                                <td class="col-md-1 text-center">:</td>
                                                                <td>{{ $fishermanInfo->estimated_income_other_job ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Hari Bekerja Di Pekerjaan Lain Sebulan</td>
                                                                <td class="text-center">:</td>
                                                                <td>{{ $fishermanInfo->days_working_other_job_per_month ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    <br>

                                                    <h5 class="fw-bold mb-0">Maklumat Kewangan</h5>
                                                    <small class="text-muted">Status bantuan dan pencen yang diterima</small>
                                                    <hr>

                                                    <table class="table table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <td class="col-md-4">Menerima Pencen</td>
                                                                <td class="col-md-1 text-center">:</td>
                                                                <td>{{ ($fishermanInfo->receive_pension ?? null) == 1 ? 'Ya' : 'Tidak' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Menerima Bantuan Kewangan</td>
                                                                <td class="text-center">:</td>
                                                                <td>{{ ($fishermanInfo->receive_financial_aid ?? null) == 1 ? 'Ya' : 'Tidak' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Agensi Memberi Bantuan</td>
                                                                <td class="text-center">:</td>
                                                                <td>{{ $fishermanInfo->financial_aid_agency ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pencarum KWSP</td>
                                                                <td class="text-center">:</td>
                                                                <td>{{ ($fishermanInfo->epf_contributor ?? null) == 1 ? 'Ya' : 'Tidak' }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="tab-pane fade p-4" id="content-tab2" role="tabpanel" aria-labelledby="tab2-link">
                                                    <h4 class="fw-bold mb-0">Maklumat Pangkalan Pendaratan</h4>
                                                    <small class="text-muted">Sila semak maklumat pangkalan yang telah dipilih</small>
                                                    <hr>

                                                    {{-- Jetty Info --}}
                                                    @if(isset($jetty))
                                                    <table class="table table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <td class="col-md-3">Negeri</td>
                                                                <td class="col-md-1">:</td>
                                                                <td>{{ $jetty->state ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Daerah</td>
                                                                <td>:</td>
                                                                <td>{{ $jetty->district ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Nama Sungai/Tasik</td>
                                                                <td>:</td>
                                                                <td>{{ $jetty->river ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pangkalan</td>
                                                                <td>:</td>
                                                                <td>{{ $jetty->jetty_name ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    @else
                                                    <p class="text-center">Tiada data pangkalan dipilih.</p>
                                                    @endif

                                                    <br>

                                                    {{-- Jetty History --}}
                                                    <div class="mt-4">
                                                        <h4 class="fw-bold mb-0">Sejarah Pangkalan</h4>
                                                        <small class="text-muted">Senarai perubahan berkaitan pangkalan yang telah direkodkan sebelum ini</small>
                                                        <hr>

                                                        @if($jettyHistory && $jettyHistory->count())
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-striped">
                                                                <thead class="table-light">
                                                                    <tr>
                                                                        <th>Tarikh</th>
                                                                        <th>Nama Pangkalan</th>
                                                                        <th>Negeri</th>
                                                                        <th>Daerah</th>
                                                                        <th>Sungai</th>
                                                                        <th>Dicipta Oleh</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($jettyHistory as $history)
                                                                    <tr>
                                                                        <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                                                                        <td>{{ $history->jetty_name ?? '-' }}</td>
                                                                        <td>{{ $history->state ?? '-' }}</td>
                                                                        <td>{{ $history->district ?? '-' }}</td>
                                                                        <td>{{ $history->river ?? '-' }}</td>
                                                                        <td>{{ $history->creator->name ?? 'Tidak Diketahui' }}</td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        @else
                                                        <p class="text-muted">Tiada sejarah pangkalan tersedia.</p>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade p-4" id="content-tab3" role="tabpanel" aria-labelledby="tab3-link">

                                                    {{-- Section: Current Equipment --}}
                                                    <h4 class="fw-bold mb-0">Peralatan Semasa</h4>
                                                    <small class="text-muted">Senarai peralatan menangkap ikan yang digunakan sekarang</small>
                                                    <hr>

                                                    <table class="table table-borderless">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Bil</th>
                                                                <th class="col-md-5">Nama Peralatan</th>
                                                                <th>Jenis</th>
                                                                <th>Kuantiti</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($equipments as $equipment)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $equipment->name ?? 'Tidak Diketahui' }}</td>
                                                                <td>{{ $equipment->type ?? 'Tidak Diketahui' }}</td>
                                                                <td>{{ $equipment->quantity ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                            @empty
                                                            <tr>
                                                                <td colspan="4" class="text-center text-muted">Tiada peralatan semasa direkodkan.</td>
                                                            </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>

                                                    <br>

                                                    {{-- Section: Equipment History --}}
                                                    <h4 class="fw-bold mb-0">Sejarah Peralatan</h4>
                                                    <small class="text-muted">Senarai perubahan berkaitan peralatan yang telah direkodkan sebelum ini</small>
                                                    <hr>

                                                    <table class="table table-borderless">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Bil</th>
                                                                <th class="col-md-5">Nama Peralatan</th>
                                                                <th>Jenis</th>
                                                                <th>Kuantiti</th>
                                                                <th>Tarikh</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($equipmentHistory as $history)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $history->name ?? 'Tidak Diketahui' }}</td>
                                                                <td>
                                                                    @if($history->type === 'main') Utama
                                                                    @elseif($history->type === 'additional') Tambahan
                                                                    @else Tidak Diketahui
                                                                    @endif
                                                                </td>
                                                                <td>{{ $history->quantity ?? 'Tidak Diketahui' }}</td>
                                                                <td>{{ optional($history->created_at)->format('d/m/Y') ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                            @empty
                                                            <tr>
                                                                <td colspan="5" class="text-center text-muted">Tiada sejarah peralatan direkodkan.</td>
                                                            </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>

                                                </div>

                                                <div class="tab-pane fade" id="content-tab4" role="tabpanel" aria-labelledby="tab4-link">
                                                    <div class="row">
                                                        @if(!empty($vessel) && $vessel->own_vessel)
                                                        {{-- Left Column: Maklumat Vesel --}}
                                                        <div class="col-md-6">
                                                            <h4 class="fw-bold mb-0">Maklumat Vesel</h4>
                                                            <small class="text-muted">Maklumat asas vesel yang dimiliki</small>
                                                            <hr>

                                                            <table class="table table-borderless">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="col-md-5">No. Pendaftaran Vesel</td>
                                                                        <td class="col-md-1">:</td>
                                                                        <td>{{ $vessel->vessel_registration_number ?? 'Tidak Diketahui' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Jenis Kulit Vesel</td>
                                                                        <td>:</td>
                                                                        <td>{{ $hull->hull_type ?? 'Tidak Diketahui' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Panjang (m)</td>
                                                                        <td>:</td>
                                                                        <td>{{ $hull->length ?? 'Tidak Diketahui' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Lebar (m)</td>
                                                                        <td>:</td>
                                                                        <td>{{ $hull->width ?? 'Tidak Diketahui' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Kedalaman (m)</td>
                                                                        <td>:</td>
                                                                        <td>{{ $hull->depth ?? 'Tidak Diketahui' }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        {{-- Right Column: Maklumat Enjin --}}
                                                        <div class="col-md-6">
                                                            <h4 class="fw-bold mb-0">Maklumat Enjin</h4>
                                                            <small class="text-muted">Spesifikasi enjin utama vesel</small>
                                                            <hr>

                                                            <table class="table table-borderless">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="col-md-5">Model Enjin</td>
                                                                        <td>:</td>
                                                                        <td>{{ $engine->engine_model ?? 'Tidak Diketahui' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Jenama Enjin</td>
                                                                        <td>:</td>
                                                                        <td>{{ $engine->engine_brand ?? 'Tidak Diketahui' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Kuasa Kuda (HP)</td>
                                                                        <td>:</td>
                                                                        <td>{{ $engine->horsepower ?? 'Tidak Diketahui' }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        @else
                                                        <div class="col-md-12 text-center">
                                                            <p class="text-muted mt-3">Tiada maklumat vesel direkodkan.</p>
                                                        </div>
                                                        @endif
                                                    </div>

                                                    <hr class="my-4">
                                                    <h4 class="fw-bold mb-0">Sejarah Maklumat Vesel</h4>
                                                    <small class="text-muted">Senarai perubahan maklumat berkaitan vesel, kulit, dan enjin</small>
                                                    <hr>

                                                    {{-- Vessel History --}}
                                                    @if($vesselHistory->isNotEmpty())
                                                    <h5 class="fw-semibold">Sejarah Vesel</h5>
                                                    <table class="table table-bordered">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Tarikh</th>
                                                                <th>No. Pendaftaran</th>
                                                                <th>Jenis Pengangkutan</th>
                                                                <th>Dikemaskini Oleh</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($vesselHistory as $record)
                                                            <tr>
                                                                <td>{{ $record->created_at->format('d/m/Y') }}</td>
                                                                <td>{{ $record->vessel_registration_number ?? '-' }}</td>
                                                                <td>{{ $record->transportation ?? '-' }}</td>
                                                                <td>{{ $record->creator->name ?? '-' }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    @endif

                                                    {{-- Hull History --}}
                                                    @if($hullHistory->isNotEmpty())
                                                    <h5 class="fw-semibold mt-4">Sejarah Kulit Vesel</h5>
                                                    <table class="table table-bordered">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Tarikh</th>
                                                                <th>Jenis Kulit</th>
                                                                <th>Panjang (m)</th>
                                                                <th>Lebar (m)</th>
                                                                <th>Kedalaman (m)</th>
                                                                <th>Dikemaskini Oleh</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($hullHistory as $record)
                                                            <tr>
                                                                <td>{{ $record->created_at->format('d/m/Y') }}</td>
                                                                <td>{{ $record->hull_type ?? '-' }}</td>
                                                                <td>{{ $record->length ?? '-' }}</td>
                                                                <td>{{ $record->width ?? '-' }}</td>
                                                                <td>{{ $record->depth ?? '-' }}</td>
                                                                <td>{{ $record->creator->name ?? '-' }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    @endif

                                                    {{-- Engine History --}}
                                                    @if($engineHistory->isNotEmpty())
                                                    <h5 class="fw-semibold mt-4">Sejarah Enjin</h5>
                                                    <table class="table table-bordered">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Tarikh</th>
                                                                <th>Model</th>
                                                                <th>Jenama</th>
                                                                <th>Kuasa Kuda (HP)</th>
                                                                <th>Dikemaskini Oleh</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($engineHistory as $record)
                                                            <tr>
                                                                <td>{{ $record->created_at->format('d/m/Y') }}</td>
                                                                <td>{{ $record->engine_model ?? '-' }}</td>
                                                                <td>{{ $record->engine_brand ?? '-' }}</td>
                                                                <td>{{ $record->horsepower ?? '-' }}</td>
                                                                <td>{{ $record->creator->name ?? '-' }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    @endif

                                                    @if($vesselHistory->isEmpty() && $hullHistory->isEmpty() && $engineHistory->isEmpty())
                                                    <p class="text-muted">Tiada rekod sejarah untuk vesel, kulit atau enjin.</p>
                                                    @endif
                                                </div>


                                                <div class="tab-pane fade" id="content-tab5" role="tabpanel" aria-labelledby="tab5-link">
                                                    <div class="card-header mb-3 pl-0">
                                                        <h4 class="fw-bold mb-0">Senarai Dokumen Dimuatnaik</h4>
                                                        <small class="text-muted">Berikut merupakan senarai dokumen yang telah dimuat naik oleh pengguna</small>
                                                    </div>

                                                    <div class="table-responsive mt-3">
                                                        <table class="table table-borderless">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th style="width: 5%">Bil.</th>
                                                                    <th class="col-md">Nama Fail</th>
                                                                    <th class="col-md-2">Tarikh Muat Naik</th>
                                                                    <th style="width: 5%">Tindakan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse ($documents as $file)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $file->title ?? '-' }}</td>
                                                                    <td>{{ $file->created_at ? $file->created_at->format('d/m/Y H:i') : '-' }}</td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#docModal_{{ $file->id }}">
                                                                            <i class="fa fa-search"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>

                                                                <!-- MODAL PER FILE -->
                                                                <div class="modal fade" id="docModal_{{ $file->id }}" tabindex="-1" aria-labelledby="docModalLabel_{{ $file->id }}" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-md-down">
                                                                        <div class="modal-content p-3">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="docModalLabel_{{ $file->id }}">{{ $file->title }}</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                                            </div>
                                                                            <div class="modal-body text-center">
                                                                                @php
                                                                                $extension = pathinfo($file->file_path, PATHINFO_EXTENSION);
                                                                                @endphp

                                                                                @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                                                                                <img src="{{ route('tukarEnjin.keputusanR-05.viewDocument', $file->id) }}" class="img-fluid rounded" style="max-height: 85vh;">
                                                                                @elseif(strtolower($extension) === 'pdf')
                                                                                <iframe src="{{ route('tukarEnjin.keputusanR-05.viewDocument', $file->id) }}" width="100%" height="700px" frameborder="0"></iframe>
                                                                                @else
                                                                                <a href="{{ route('tukarEnjin.keputusanR-05.viewDocument', $file->id) }}" target="_blank" class="btn btn-outline-primary">Buka Dokumen</a>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @empty
                                                                <tr>
                                                                    <td class="text-center" colspan="4">Tiada dokumen dimuat naik.</td>
                                                                </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <hr class="my-4">

                                                    <h4 class="fw-bold mb-0">Senarai Pemeriksaan Vesel</h4>
                                                    <small class="text-muted">Berikut merupakan rekod pemeriksaan vesel</small>

                                                    <div class="table-responsive mt-3">
                                                        <table class="table table-borderless">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th style="width: 5%">Bil.</th>
                                                                    <th>Tarikh Pemeriksaan</th>
                                                                    <th>Disemak Oleh</th>
                                                                    <th>Tarikh Sah</th>
                                                                    <th style="width: 5%">Tindakan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse($inspections as $inspection)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $inspection->inspection_date ? \Carbon\Carbon::parse($inspection->inspection_date)->format('d/m/Y') : '-' }}</td>
                                                                    <td>{{ $inspection->creator->name ?? '-' }}</td>
                                                                    <td>{{ $inspection->valid_date ?? '-' }}</td>

                                                                    <td>
                                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inspectionModal_{{ $inspection->id }}">
                                                                            <i class="fa fa-search"></i>
                                                                        </button>

                                                                        <!-- MODAL -->
                                                                        <div class="modal fade" id="inspectionModal_{{ $inspection->id }}" tabindex="-1" aria-labelledby="inspectionModalLabel_{{ $inspection->id }}" aria-hidden="true">
                                                                            <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-md-down">
                                                                                <div class="modal-content p-3">
                                                                                    <div class="modal-header">
                                                                                        <div class="mb-3 pl-0">
                                                                                            <h4 class="fw-bold mb-0">Maklumat Pemeriksaan</h4>
                                                                                            <small class="text-muted">Maklumat lengkap berkaitan pemeriksaan vesel</small>
                                                                                        </div>

                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <table class="table table-borderless">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td class="col-md-4">Tarikh Pemeriksaan</td>
                                                                                                    <td class="col-md-1">:</td>
                                                                                                    <td>{{ $inspection->inspection_date ? \Carbon\Carbon::parse($inspection->inspection_date)->format('d/m/Y') : '-' }}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>Disemak Oleh</td>
                                                                                                    <td>:</td>
                                                                                                    <td>{{ $inspection->creator->name ?? '-' }}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>Tarikh Sah</td>
                                                                                                    <td>:</td>
                                                                                                    <td>{{ $inspection->valid_date ? \Carbon\Carbon::parse($inspection->valid_date)->format('d/m/Y') : '-' }}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>Lokasi Pemeriksaan</td>
                                                                                                    <td>:</td>
                                                                                                    <td>{{ $inspection->inspection_location ?? '-' }}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>Status Sokongan</td>
                                                                                                    <td>:</td>
                                                                                                    <td>{{ $inspection->is_support ? 'Disokong' : 'Tidak Disokong' }}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>Ringkasan Pemeriksaan</td>
                                                                                                    <td>:</td>
                                                                                                    <td>{{ $inspection->inspection_summary ?? '-' }}</td>
                                                                                                </tr>

                                                                                                <tr>
                                                                                                    <td colspan="3">
                                                                                                        <hr><strong>Maklumat Vesel</strong></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>No. Pendaftaran Vesel</td>
                                                                                                    <td>:</td>
                                                                                                    <td>{{ $inspection->vessel_registration_number ?? '-' }}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>Keadaan Vesel</td>
                                                                                                    <td>:</td>
                                                                                                    <td>{{ $inspection->vessel_condition ?? '-' }}</td>
                                                                                                </tr>

                                                                                                <tr>
                                                                                                    <td colspan="3">
                                                                                                        <hr><strong>Maklumat Kulit Vesel</strong></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>Jenis Kulit Vesel</td>
                                                                                                    <td>:</td>
                                                                                                    <td>{{ $inspection->hull_type ?? '-' }}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>Digerudi</td>
                                                                                                    <td>:</td>
                                                                                                    <td>{{ $inspection->drilled ? 'Ya' : 'Tidak' }}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>Berwarna Cerah</td>
                                                                                                    <td>:</td>
                                                                                                    <td>{{ $inspection->brightly_painted ? 'Ya' : 'Tidak' }}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>Catatan No. Pendaftaran</td>
                                                                                                    <td>:</td>
                                                                                                    <td>{{ $inspection->vessel_registration_remarks ?? '-' }}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>Panjang (m)</td>
                                                                                                    <td>:</td>
                                                                                                    <td>{{ $inspection->length ?? '-' }}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>Lebar (m)</td>
                                                                                                    <td>:</td>
                                                                                                    <td>{{ $inspection->width ?? '-' }}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>Kedalaman (m)</td>
                                                                                                    <td>:</td>
                                                                                                    <td>{{ $inspection->depth ?? '-' }}</td>
                                                                                                </tr>

                                                                                                <tr>
                                                                                                    <td colspan="3">
                                                                                                        <hr><strong>Maklumat Enjin</strong></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>Model Enjin</td>
                                                                                                    <td>:</td>
                                                                                                    <td>{{ $inspection->engine_model ?? '-' }}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>Jenama Enjin</td>
                                                                                                    <td>:</td>
                                                                                                    <td>{{ $inspection->engine_brand ?? '-' }}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>Kuasa Kuda</td>
                                                                                                    <td>:</td>
                                                                                                    <td>{{ $inspection->horsepower ?? '-' }}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>No. Enjin</td>
                                                                                                    <td>:</td>
                                                                                                    <td>{{ $inspection->engine_number ?? '-' }}</td>
                                                                                                </tr>

                                                                                                <tr>
                                                                                                    <td colspan="3">
                                                                                                        <hr><strong>Maklumat Jaket Keselamatan</strong></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>Ada Jaket Keselamatan?</td>
                                                                                                    <td>:</td>
                                                                                                    <td>{{ $inspection->safety_jacket_status ? 'Ya' : 'Tidak' }}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>Kuantiti Jaket</td>
                                                                                                    <td>:</td>
                                                                                                    <td>{{ $inspection->safety_jacket_quantity ?? '-' }}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>Keadaan Jaket</td>
                                                                                                    <td>:</td>
                                                                                                    <td>{{ $inspection->safety_jacket_condition ?? '-' }}</td>
                                                                                                </tr>

                                                                                                <tr>
                                                                                                    <td colspan="3">
                                                                                                        <hr><strong>Fail Berkaitan</strong></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>Borang Kehadiran</td>
                                                                                                    <td>:</td>
                                                                                                    <td>
                                                                                                        @if($inspection->attendance_form_path)
                                                                                                        @php
                                                                                                        $extension = pathinfo($inspection->attendance_form_path, PATHINFO_EXTENSION);
                                                                                                        @endphp

                                                                                                        @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                                                                                                        <img src="{{ route('tukarEnjin.keputusanR-05.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'attendance_form_path']) }}" class="img-fluid rounded" style="max-height: 300px;">
                                                                                                        @elseif(strtolower($extension) === 'pdf')
                                                                                                        <iframe src="{{ route('tukarEnjin.keputusanR-05.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'attendance_form_path']) }}" width="100%" height="400px" frameborder="0"></iframe>
                                                                                                        @else
                                                                                                        <a href="{{ route('tukarEnjin.keputusanR-05.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'attendance_form_path']) }}" target="_blank" class="btn btn-outline-primary">Buka Fail</a>
                                                                                                        @endif
                                                                                                        @else
                                                                                                        Tiada
                                                                                                        @endif
                                                                                                    </td>
                                                                                                </tr>

                                                                                                <tr>
                                                                                                    <td>Gambar Vesel</td>
                                                                                                    <td>:</td>
                                                                                                    <td>
                                                                                                        @if($inspection->vessel_image_path)
                                                                                                        @php
                                                                                                        $extension = pathinfo($inspection->vessel_image_path, PATHINFO_EXTENSION);
                                                                                                        @endphp

                                                                                                        @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                                                                                                        <img src="{{ route('tukarEnjin.keputusanR-05.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'vessel_image_path']) }}" class="img-fluid rounded" style="max-height: 300px;">
                                                                                                        @elseif(strtolower($extension) === 'pdf')
                                                                                                        <iframe src="{{ route('tukarEnjin.keputusanR-05.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'vessel_image_path']) }}" width="100%" height="400px" frameborder="0"></iframe>
                                                                                                        @else
                                                                                                        <a href="{{ route('tukarEnjin.keputusanR-05.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'vessel_image_path']) }}" target="_blank" class="btn btn-outline-primary">Buka Fail</a>
                                                                                                        @endif
                                                                                                        @else
                                                                                                        Tiada
                                                                                                        @endif
                                                                                                    </td>
                                                                                                </tr>

                                                                                                <tr>
                                                                                                    <td>Gambar Pemilik & Pemeriksa</td>
                                                                                                    <td>:</td>
                                                                                                    <td>
                                                                                                        @if($inspection->inspector_owner_image_path)
                                                                                                        @php
                                                                                                        $extension = pathinfo($inspection->inspector_owner_image_path, PATHINFO_EXTENSION);
                                                                                                        @endphp

                                                                                                        @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                                                                                                        <img src="{{ route('tukarEnjin.keputusanR-05.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'inspector_owner_image_path']) }}" class="img-fluid rounded" style="max-height: 300px;">
                                                                                                        @elseif(strtolower($extension) === 'pdf')
                                                                                                        <iframe src="{{ route('tukarEnjin.keputusanR-05.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'inspector_owner_image_path']) }}" width="100%" height="400px" frameborder="0"></iframe>
                                                                                                        @else
                                                                                                        <a href="{{ route('tukarEnjin.keputusanR-05.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'inspector_owner_image_path']) }}" target="_blank" class="btn btn-outline-primary">Buka Fail</a>
                                                                                                        @endif
                                                                                                        @else
                                                                                                        Tiada
                                                                                                        @endif
                                                                                                    </td>
                                                                                                </tr>

                                                                                                <tr>
                                                                                                    <td>Gambar Keseluruhan</td>
                                                                                                    <td>:</td>
                                                                                                    <td>
                                                                                                        @if($inspection->overall_image_path)
                                                                                                        @php
                                                                                                        $extension = pathinfo($inspection->overall_image_path, PATHINFO_EXTENSION);
                                                                                                        @endphp

                                                                                                        @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                                                                                                        <img src="{{ route('tukarEnjin.keputusanR-05.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'overall_image_path']) }}" class="img-fluid rounded" style="max-height: 300px;">
                                                                                                        @elseif(strtolower($extension) === 'pdf')
                                                                                                        <iframe src="{{ route('tukarEnjin.keputusanR-05.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'overall_image_path']) }}" width="100%" height="400px" frameborder="0"></iframe>
                                                                                                        @else
                                                                                                        <a href="{{ route('tukarEnjin.keputusanR-05.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'overall_image_path']) }}" target="_blank" class="btn btn-outline-primary">Buka Fail</a>
                                                                                                        @endif
                                                                                                        @else
                                                                                                        Tiada
                                                                                                        @endif
                                                                                                    </td>
                                                                                                </tr>

                                                                                                <tr>
                                                                                                    <td>Gambar Enjin</td>
                                                                                                    <td>:</td>
                                                                                                    <td>
                                                                                                        @if($inspection->engine_image_path)
                                                                                                        @php
                                                                                                        $engineImgExt = pathinfo($inspection->engine_image_path, PATHINFO_EXTENSION);
                                                                                                        @endphp

                                                                                                        @if(in_array(strtolower($engineImgExt), ['jpg', 'jpeg', 'png']))
                                                                                                        <img src="{{ route('tukarEnjin.keputusanR-05.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'engine_image_path']) }}" class="img-fluid rounded" style="max-height: 300px;">
                                                                                                        @elseif(strtolower($engineImgExt) === 'pdf')
                                                                                                        <iframe src="{{ route('tukarEnjin.keputusanR-05.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'engine_image_path']) }}" width="100%" height="400px" frameborder="0"></iframe>
                                                                                                        @else
                                                                                                        <a href="{{ route('tukarEnjin.keputusanR-05.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'engine_image_path']) }}" target="_blank" class="btn btn-outline-primary">Buka Fail</a>
                                                                                                        @endif
                                                                                                        @else
                                                                                                        Tiada
                                                                                                        @endif
                                                                                                    </td>
                                                                                                </tr>

                                                                                                <tr>
                                                                                                    <td>Gambar Nombor Enjin</td>
                                                                                                    <td>:</td>
                                                                                                    <td>
                                                                                                        @if($inspection->engine_number_image_path)
                                                                                                        @php
                                                                                                        $engineNumExt = pathinfo($inspection->engine_number_image_path, PATHINFO_EXTENSION);
                                                                                                        @endphp

                                                                                                        @if(in_array(strtolower($engineNumExt), ['jpg', 'jpeg', 'png']))
                                                                                                        <img src="{{ route('tukarEnjin.keputusanR-05.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'engine_number_image_path']) }}" class="img-fluid rounded" style="max-height: 300px;">
                                                                                                        @elseif(strtolower($engineNumExt) === 'pdf')
                                                                                                        <iframe src="{{ route('tukarEnjin.keputusanR-05.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'engine_number_image_path']) }}" width="100%" height="400px" frameborder="0"></iframe>
                                                                                                        @else
                                                                                                        <a href="{{ route('tukarEnjin.keputusanR-05.viewInspectionDocument', ['id' => $inspection->id, 'field' => 'engine_number_image_path']) }}" target="_blank" class="btn btn-outline-primary">Buka Fail</a>
                                                                                                        @endif
                                                                                                        @else
                                                                                                        Tiada
                                                                                                        @endif
                                                                                                    </td>
                                                                                                </tr>

                                                                                            </tbody>
                                                                                        </table>

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </td>

                                                                </tr>
                                                                @empty
                                                                <tr>
                                                                    <td class="text-center" colspan="6">Tiada rekod pemeriksaan tersedia.</td>
                                                                </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>

                                                <div class="tab-pane fade p-4" id="content-tab6" role="tabpanel" aria-labelledby="tab6-link">
                                                    <div class="card-header mb-3 pl-0">
                                                        <h4 class="fw-bold mb-0">Rekod Kesalahan</h4>
                                                        <small class="text-muted">Berikut merupakan senarai kesalahan yang pernah direkodkan oleh pengguna</small>
                                                    </div>

                                                    <div class="table-responsive mt-3">
                                                        <table class="table table-borderless">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th style="width: 5%">Bil</th>
                                                                    <th>Jenis Kesalahan</th>
                                                                    <th>Tarikh Kesalahan</th>
                                                                    <th>Kaedah</th>
                                                                    <th>Seksyen Kaedah</th>
                                                                    <th>Perintah Mahkamah</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse ($faultRecord as $index => $rekod)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $rekod->fault_type ?? '-' }}</td>
                                                                    <td>{{ $rekod->fault_date ? \Carbon\Carbon::parse($rekod->fault_date)->format('d/m/Y') : '-' }}</td>
                                                                    <td>{{ $rekod->method ?? '-' }}</td>
                                                                    <td>{{ $rekod->method_section ?? '-' }}</td>
                                                                    <td>{{ $rekod->decision ?? '-' }}</td>
                                                                </tr>
                                                                @empty
                                                                <tr>
                                                                    <td class="text-center" colspan="6">Tiada rekod kesalahan direkodkan.</td>
                                                                </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade " id="content-tab7" role="tabpanel" aria-labelledby="tab7-link">
                                                    <div class="card-header mb-3 pl-0">
                                                        <h4 class="fw-bold mb-0">Maklumat Pendaratan</h4>
                                                        <small class="text-muted">Maklumat berkaitan hasil tangkapan dan pendaratan ikan</small>
                                                    </div>

                                                    @php
                                                    $malayMonths = [
                                                    '01' => 'Januari',
                                                    '02' => 'Februari',
                                                    '03' => 'Mac',
                                                    '04' => 'April',
                                                    '05' => 'Mei',
                                                    '06' => 'Jun',
                                                    '07' => 'Julai',
                                                    '08' => 'Ogos',
                                                    '09' => 'September',
                                                    '10' => 'Oktober',
                                                    '11' => 'November',
                                                    '12' => 'Disember',
                                                    ];
                                                    @endphp

                                                    <!-- Year & Month Filter Form -->
                                                    <form id="filterForm" method="GET">
                                                        <div class="row">
                                                            <div class="col-md">
                                                                <label>Tahun:</label>
                                                                <select name="year" id="year" class="form-select">
                                                                    <option value="" selected disabled>-- Pilih Tahun --
                                                                    </option>
                                                                    @for ($y = date('Y') - 5; $y <= date('Y'); $y++) <option value="{{ $y }}">
                                                                        {{ $y }}</option>
                                                                        @endfor
                                                                </select>
                                                            </div>

                                                            <div class="col-md">
                                                                <label>Bulan:</label>
                                                                <select name="month" id="month" class="form-select">
                                                                    <option value="" selected disabled>-- Pilih Bulan --
                                                                    </option>
                                                                    @foreach ($malayMonths as $key => $month)
                                                                    <option value="{{ $key }}">
                                                                        {{ $month }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-primary mt-4 col-md" id="searchButton">Carian</button>
                                                    </form>

                                                    <br>
                                                    <hr>

                                                    <!-- Content to be updated dynamically -->
                                                    <div id="logDataContent"></div>
                                                </div>

                                                <div class="tab-pane fade" id="content-tab8" role="tabpanel" aria-labelledby="tab8-link">
                                                    <div class="card-header mb-3 pl-0">
                                                        <h4 class="fw-bold mb-0">Status Permohonan</h4>
                                                        <small class="text-muted">Maklumat semakan dan status permohonan pemohon</small>
                                                    </div>

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
                                                                @php $prevDate = $log->created_at->format('d/m/Y'); @endphp
                                                                <div class="time-label">
                                                                    <span class="bg-white">{{ $prevDate }}</span>
                                                                </div>
                                                                @endif

                                                                <div>
                                                                    <div class="timeline-item">
                                                                        <span class="time"><i class="fas fa-clock"></i> {{ $log->created_at->format('h:i:s A') }}</span>

                                                                        <!-- Status -->
                                                                        <h3 class="timeline-header" style="color: black; font-weight: bold; border-bottom: 1px solid #D3D3D3; font-size: 100%; padding-top: 1%; padding-bottom: 1%;">
                                                                            Status&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                            {{ $log->applicationStatus->name_ms ?? 'Tidak Diketahui' }}
                                                                        </h3>

                                                                        @php
                                                                        $flagBadges = [];

                                                                        if (!is_null($log->review_flag)) {
                                                                        $flagBadges[] = '<span class="badge ' . ($log->review_flag ? 'bg-success' : 'bg-danger') . '">' . ($log->review_flag ? 'LENGKAP' : 'TIDAK LENGKAP') . '</span>';
                                                                        }

                                                                        if (!is_null($log->support_flag)) {
                                                                        $flagBadges[] = '<span class="badge ' . ($log->support_flag ? 'bg-success' : 'bg-danger') . '">' . ($log->support_flag ? 'DISOKONG' : 'TIDAK DISOKONG') . '</span>';
                                                                        }

                                                                        if (!is_null($log->decision_flag)) {
                                                                        $flagBadges[] = '<span class="badge ' . ($log->decision_flag ? 'bg-success' : 'bg-danger') . '">' . ($log->decision_flag ? 'LULUS' : 'TIDAK LULUS') . '</span>';
                                                                        }

                                                                        if (!is_null($log->confirmation_flag)) {
                                                                        $flagBadges[] = '<span class="badge ' . ($log->confirmation_flag ? 'bg-success' : 'bg-danger') . '">' . ($log->confirmation_flag ? 'DISAHKAN' : 'TIDAK DISAHKAN') . '</span>';
                                                                        }
                                                                        @endphp

                                                                        @if (count($flagBadges))
                                                                        <h3 class="timeline-header d-flex align-items-center flex-wrap gap-2" style="color: black; font-weight: bold; border-bottom: 1px solid #D3D3D3;
                                                                               font-size: 100%; padding-top: 1%; padding-bottom: 1%;">
                                                                            Label&nbsp;&nbsp;&nbsp;:
                                                                            <div class="d-flex flex-wrap gap-2">
                                                                                {!! implode(' <span>/</span> ', $flagBadges) !!}
                                                                            </div>
                                                                        </h3>
                                                                        @endif

                                                                        <!-- Ulasan -->
                                                                        @if (!empty($log->remarks))
                                                                        <h3 class="timeline-header" style="color: black; font-weight: bold; border-bottom: 1px solid #D3D3D3; font-size: 100%; padding-top: 1%; padding-bottom: 1%;">
                                                                            Ulasan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                            <br><br>
                                                                            <span style="color: black; font-weight: normal; text-align: justify; line-height: 1.6; font-size: 105%;">
                                                                                {{ $log->remarks }}
                                                                            </span>
                                                                        </h3>
                                                                        @endif

                                                                        <!-- Hidden Detail Section -->
                                                                        <div id="details{{ $count }}" style="display: none;">
                                                                            <!-- Pelaku -->
                                                                            <h3 class="timeline-header" style="color: black; font-weight: bold; border-bottom: 1px solid #D3D3D3; font-size: 100%; padding-top: 1%; padding-bottom: 1%;">
                                                                                &nbsp;&nbsp;&nbsp;Pelaku&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                <a href="#" style="color: black; font-weight: normal;" onmouseover="this.style.color='blue';" onmouseout="this.style.color='black';">
                                                                                    {{ strtoupper($log->creator->name ?? 'Tidak Diketahui') }}
                                                                                </a>
                                                                            </h3>

                                                                            <!-- Jawatan -->
                                                                            <h3 class="timeline-header" style="color: black; font-weight: bold; border-bottom: 1px solid #D3D3D3; font-size: 100%; padding-top: 1%; padding-bottom: 1%;">
                                                                                &nbsp;&nbsp;&nbsp;Jawatan&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                <a href="#" style="color: black; font-weight: normal;">
                                                                                    @if ($log->creator && $log->creator->userRoles->isNotEmpty())
                                                                                    {{ $log->creator->userRoles->pluck('name')->join(', ') }}
                                                                                    @else
                                                                                    Tidak Diketahui
                                                                                    @endif
                                                                                </a>
                                                                            </h3>
                                                                        </div>

                                                                        <!-- Toggle Button -->
                                                                        <div style="text-align: right;">
                                                                            <button onclick="toggleDetails('details{{ $count }}', this)" class="btn btn-link" style="text-decoration: none;">
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
                                                <div class="tab-pane fade" id="content-tab9" role="tabpanel" aria-labelledby="tab10-link">

                                                    <!-- Semakan -->
                                                    <div class="card-header mb-3 pl-0">
                                                        <h4 class="fw-bold mb-0">Semakan</h4>
                                                        <small class="text-muted">Sila pilih status semakan borang ini</small>
                                                    </div>
                                                    <div class="d-flex gap-4 mb-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="review_flag" id="lengkap" value="1">
                                                            <label class="form-check-label" for="lengkap">Lengkap</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="review_flag" id="tidak_lengkap" value="0">
                                                            <label class="form-check-label" for="tidak_lengkap">Tidak Lengkap</label>
                                                        </div>
                                                    </div>

                                                    <!-- Keputusan (conditional) -->
                                                    <div id="keputusanSection" style="display: none;">
                                                        <div class="card-header mb-3 pl-0">
                                                            <h4 class="fw-bold mb-0">Keputusan</h4>
                                                            <small class="text-muted">Sila nyatakan keputusan terhadap permohonan ini</small>
                                                        </div>
                                                        <div class="d-flex gap-4 mb-4">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="decision_flag" id="lulus" value="1">
                                                                <label class="form-check-label" for="lulus">Lulus</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="decision_flag" id="tidak_lulus" value="0">
                                                                <label class="form-check-label" for="tidak_lulus">Tidak Lulus</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Ulasan -->
                                                    <div class="card-header mb-3 pl-0">
                                                        <h4 class="fw-bold mb-0">Ulasan</h4>
                                                        <small class="text-muted">Sila berikan ulasan terhadap semakan dan keputusan ini</small>
                                                    </div>
                                                    <textarea name="remarks" class="form-control mb-4" rows="4" placeholder="Masukkan ulasan..."></textarea>

                                                </div>

                                                @push('scripts')
                                                <script>
                                                    $(document).ready(function() {
                                                        $('input[name="review_flag"]').on('change', function() {
                                                            if ($(this).val() === '1') {
                                                                $('#keputusanSection').slideDown();
                                                            } else {
                                                                $('#keputusanSection').slideUp();
                                                                $('input[name="decision_flag"]').prop('checked', false);
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
                                                    <button id="backTabBtn" type="button" class="btn btn-light" style="width:120px">Kembali</button>
                                                    <button id="nextTabBtn" type="button" class="btn btn-light" style="width:120px">Seterusnya</button>
                                                </div>

                                                <!-- Submit Buttons -->
                                                <div class="d-flex gap-3">

                                                    <!-- Hantar Button -->
                                                    <button id="submitBtn" type="submit" form="submitPermohonan" class="btn btn-success" style="width:120px; display:none;">
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

{{-- pop up alert --}}
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

        // Hide initially
        document.getElementById('submitBtn').style.display = 'none';
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

{{-- LPI --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const validDateSpan = document.getElementById("validDate");
        const lpiStatus = document.getElementById("lpiStatus");

        // Get the LPI date as a string
        let validDateStr = validDateSpan.textContent.trim();
        let validDate = (validDateStr !== "Tiada rekod" && validDateStr !== "") ? new Date(validDateStr) : null;
        let today = new Date();
        today.setHours(0, 0, 0, 0); // Normalize today's date for comparison

        // Check if LPI is valid
        function isLpiDateValid() {
            return validDate && validDate >= today;
        }

        // Display the appropriate message based on LPI status
        if (isLpiDateValid()) {
            lpiStatus.textContent = "(Masih sah)";
            lpiStatus.classList.add("text-success");
            lpiStatus.style.display = "inline"; // Show the message
        } else {
            lpiStatus.textContent = "(Tamat tempoh)";
            lpiStatus.classList.add("text-danger");
            lpiStatus.style.display = "inline"; // Show the message
        }
    });

</script>

{{-- Pendaratan --}}
<script>
    console.log('Year:', year);
    console.log('Month:', month);

    $(document).ready(function() {
        $('#searchButton').click(function(e) {
            e.preventDefault(); // Prevent the default form submission

            var year = $('#year').val();
            var month = $('#month').val();
            var applicationId =
                '{{ $application->id }}'; // Application ID passed from Blade

            console.log('Sending data - Year:', year, 'Month:', month);

            // Check if both year and month are selected
            if (year && month) {
                $.ajax({
                    url: '{{ route('tukarEnjin.keputusanR-05.fetchData', ['id'=> $application->id]) }}'
                    , method: 'GET'
                    , data: {
                        year: year
                        , month: month
                    }
                    , success: function(response) {
                        console.log(response);
                        var logData = `
    <div class="card-header mb-3 pl-0">
        <h4>Data Log Pendaratan ${response.year} - ${response.month}</h4>
    </div>
    <div class="row">
        <div class="col-md">
            <h5>Bilangan Hari Beroperasi: <input type="text" class="form-control" value="${response.daysOfOperation}"></h5>
        </div>
        <div class="col-md">
            <h5>Negeri Didaftarkan: <input type="text" class="form-control" value="${response.pangkalan.state.name || 'Tidak Diketahui'}"></h5>
        </div>
    </div>

    <div class="card-header mb-3 pl-0">
        <h4>Kawasan Menangkap Ikan</h4>
    </div>
    <table class="table table-borderless">
        <thead class="table-light">
            <tr>
                <th style="width: 5%">Bil.</th>
                <th>Daerah</th>
                <th>Sungai</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            ${response.catchingLocations.length === 0
            ? `<tr>
                <td colspan="4" class="text-center">Tiada aktiviti memancing direkodkan.</td>
            </tr>`
            : response.catchingLocations.map((location, index) => `
            <tr>
                <td>${index + 1}</td>
                <td>${location.district_name}</td>
                <td>${location.river_name}</td>
                <td>${location.total}</td>
            </tr>`).join('')
            }
        </tbody>
    </table>

    <div class="card-header mb-3 pl-0">
        <h4>Spesies Ikan Yang Ditangkap</h4>
    </div>
    <table class="table table-borderless">
        <thead class="table-light">
            <tr>
                <th style="width: 5%">Bil.</th>
                <th>Jenis Spesies</th>
                <th>Jumlah Berat (KG)</th>
            </tr>
        </thead>
        <tbody>
            ${response.fishType.length === 0
            ? `<tr>
                <td colspan="3" class="text-center">Tiada pendaratan ikan direkodkan.</td>
            </tr>`
            : response.fishType.map((landing, index) => `
            <tr>
                <td>${index + 1}</td>
                <td>${landing.species_name}</td>
                <td>${landing.total_weight}</td>
            </tr>`).join('')
            }
        </tbody>
    </table>

    <div class="card-header mb-3 pl-0">
        <h4>Harga Jualan Ikan Mengikut Spesies</h4>
    </div>
    <div class="table-responsive">
    <table class="table table-borderless">
        <thead class="table-light">
            <tr>
                <th style="width: 5%">Bil.</th>
                <th>Jenis Spesies</th>
                <th>Jumlah Berat Dijual (KG)</th>
                <th>Purata Harga per KG (RM)</th>
                <th>Jumlah Dijual (RM)</th>
            </tr>
        </thead>
        <tbody>
            ${response.salesData.length === 0
            ? `<tr>
                <td colspan="5" class="text-center">Tiada jualan ikan direkodkan.</td>
            </tr>`
            : response.salesData.map((sale, index) => `
            <tr>
                <td>${index + 1}</td>
                <td>${sale.species_name}</td>
                <td>${sale.total_sold_weight}</td>
                <td>${sale.avg_price_per_kg}</td>
                <td>${sale.total_sales}</td>
            </tr>`).join('')
            }
        </tbody>
    </table>
     </div>
    `;
                        // Dynamically update the content inside the logDataContent div
                        $('#logDataContent').html(logData);
                    },

                    error: function() {
                        alert('Error fetching data.');
                    }
                });
            } else {
                alert('Please select both year and month.');
            }
        });
    });

</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endpush
