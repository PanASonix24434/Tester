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
                        <small>{{$moduleName->name}} - {{$roleName}}</small>
                    </div>
                </div>
                <div class="col-md-6 align-content-center">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="d-flex   justify-content-end">
                        <ol class="breadcrumb text-center">
                            <li class="breadcrumb-item"><a href="http://127.0.0.1:8000/kadPendaftaran/semakanBayaran-08">{{ \Illuminate\Support\Str::ucfirst(strtolower($applicationType->name)) }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$moduleName->name}}</a></li>
                            {{-- <li class="breadcrumb-item active" aria-current="page">Permohonan</a></li> --}}

                        </ol>
                    </nav>
                </div>

            </div>
            <div>
                <div class="row">
                    <div class="col-12">

                        <form method="POST" id="submitPermohonan" action="{{ route('kadPendaftaran.semakanBayaran-08.store', $application->id) }}" enctype="multipart/form-data">
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
                                                            <td><input type="text" class="form-control" value="{{ $user->name ?? 'Tidak Diketahui' }}" readonly></td>
                                                        </tr>
                                                        <tr>
                                                            <td>No. Kad Pengenalan</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="form-control" value="{{ $user->username }}" readonly></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Pangkalan</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="form-control" value="{{ $currentBase->jetty->name ?? 'Tidak Diketahui' }}" readonly></td>
                                                        </tr>
                                                        <tr>
                                                            <td>No. Pendaftaran Vesel</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="form-control" value="{{ $vessel->vessel_registration_number ?? 'Tiada Vesel' }}" readonly></td>
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
                                                            <td><input type="text" class="form-control" value="{{ $application->applicationType->name ?? 'Tidak Diketahui' }}" readonly></td>
                                                        </tr>
                                                        <tr>
                                                            <td>No. Rujukan</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="form-control" value="{{ $application->no_rujukan ?? 'Tidak Diketahui' }}" readonly></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tarikh Permohonan</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="form-control" value="{{ $application->created_at->format('d-m-Y') ?? 'Tidak Diketahui' }}" readonly></td>
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
                                                    <a class="nav-link custom-nav-link" id="tab8-link" aria-disabled="true">Lain Lain </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link custom-nav-link" id="tab9-link" aria-disabled="true">Status </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link custom-nav-link   " id="tab10-link" aria-disabled="true">
                                                        Tindakan

                                                    </a>
                                                </li>

                                            </ul>

                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content" id="pills-tabContent">
                                                <div class="tab-pane fade p-4 pt-0 show active" id="content-tab1" role="tabpanel" aria-labelledby="tab1-link">

                                                    <h4>Maklumat Peribadi</h4>
                                                    <hr>

                                                    <table class="table table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <td class="col-md-3">Nama</td>
                                                                <td class="col-md-1"> :</td>
                                                                <td>{{ $user->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>No. I/C</td>
                                                                <td>:</td>
                                                                <td>{{ $user->username }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>No. Telefon</td>
                                                                <td>:</td>
                                                                <td>{{ $user->contact_number }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <br>
                                                    <table class="table table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <td class="col-md-3">Alamat</td>
                                                                <td class="col-md-1">:</td>
                                                                <td>
                                                                    {{ $user->address1 ?? 'Tidak Diketahui' }}<br>
                                                                    {{ $user->address2 ?? '' }}<br>
                                                                    {{ $user->address3 ?? '' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Poskod</td>
                                                                <td>:</td>
                                                                <td>{{ $user->postcode ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Daerah</td>
                                                                <td>:</td>
                                                                <td>{{ $user->district ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Negeri</td>
                                                                <td>:</td>
                                                                <td>{{ $user->state_id ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="tab-pane fade p-4" id="content-tab2" role="tabpanel" aria-labelledby="tab2-link">

                                                    <h4>Maklumat Pangkalan Pendaratan</h4>
                                                    <hr>

                                                    @if(isset($currentBase))
                                                    <table class="table table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <td class="col-md-3">Negeri</td>
                                                                <td class="col-md-1">:</td>
                                                                <td>{{ $currentBase->state->name ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Daerah</td>
                                                                <td>:</td>
                                                                <td>{{ $currentBase->district->name ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Nama Sungai/Tasik</td>
                                                                <td>:</td>
                                                                <td>{{ $currentBase->river->name ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pangkalan</td>
                                                                <td>:</td>
                                                                <td>{{ $currentBase->jetty->name ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    @else
                                                    <p class="text-center">Tiada data pangkalan dipilih.</p>
                                                    @endif

                                                    <br>
                                                    <hr>

                                                    <h5>Rekod Pangkalan</h5>

                                                    @if($pangkalans->count())
                                                    @php
                                                    $groupedPangkalans = $pangkalans->groupBy(function($item) {
                                                    return $item->created_at->toDateString(); // group by date
                                                    });
                                                    @endphp

                                                    <table class="table table-borderless">

                                                        <tbody>
                                                            @foreach($groupedPangkalans as $date => $records)
                                                            @php $collapseId = 'pangkalanCollapse_' . \Str::slug($date); @endphp

                                                            {{-- Date Row (toggle) --}}
                                                            <tr class="table-light text-center" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" style="cursor:pointer;">
                                                                <td>{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</td>
                                                            </tr>

                                                            {{-- Collapsible content --}}
                                                            <tr class="collapse" id="{{ $collapseId }}">
                                                                <td class="p-0 border-0">
                                                                    <table class="table table-borderless mb-0">
                                                                        <thead class="table-light">
                                                                            <tr>
                                                                                <th>Negeri</th>
                                                                                <th>Daerah</th>
                                                                                <th>Nama Sungai/Tasik</th>
                                                                                <th>Pangkalan</th>

                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach($records as $p)
                                                                            <tr>
                                                                                <td>{{ $p->state->name ?? '-' }}</td>
                                                                                <td>{{ $p->district->name ?? '-' }}</td>
                                                                                <td>{{ $p->river->name ?? '-' }}</td>
                                                                                <td>{{ $p->jetty->name ?? '-' }}</td>

                                                                            </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    @else
                                                    <p class="text-center">Tiada rekod pangkalan ditemui.</p>
                                                    @endif

                                                </div>

                                                <div class="tab-pane fade p-4" id="content-tab3" role="tabpanel" aria-labelledby="tab3-link">
                                                    <h4>Peralatan Menangkap Ikan</h4>
                                                    <hr>

                                                    {{-- Peralatan Semasa --}}
                                                    <h5>Peralatan Semasa</h5>
                                                    <table class="table table-borderless">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Bil</th>
                                                                <th>Peralatan</th>
                                                                <th>Jenis</th>
                                                                <th>Kuantiti</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($equipments as $equipment)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $equipment->equipment->name ?? '-' }}</td>
                                                                <td>{{ $equipment->type == 1 ? 'Utama' : ($equipment->type == 2 ? 'Tambahan' : '-') }}</td>
                                                                <td>{{ $equipment->quantity }}</td>
                                                            </tr>
                                                            @empty
                                                            <tr>
                                                                <td colspan="4" class="text-center">Tiada Peralatan Semasa</td>
                                                            </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>

                                                    <br>
                                                    <hr>
                                                    {{-- Rekod Peralatan --}}
                                                    <h5>Rekod Peralatan</h5>

                                                    @if($equipmentRecords->count())
                                                    <table class="table table-borderless">
                                                        <tbody>
                                                            @foreach($equipmentRecords as $date => $records)
                                                            @php $collapseId = 'collapse_' . \Str::slug($date); @endphp

                                                            {{-- Group header row (date toggle) --}}
                                                            <tr class="table-light text-center" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" style="cursor:pointer;">
                                                                <td colspan="4">{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</td>
                                                            </tr>

                                                            {{-- Collapsible group content --}}
                                                            <tr class="collapse" id="{{ $collapseId }}">
                                                                <td colspan="4" class="p-0 border-0">
                                                                    <table class="table table-borderless mb-0">
                                                                        <thead class="table-light">
                                                                            <tr>
                                                                                <th>Bil</th>
                                                                                <th>Peralatan</th>
                                                                                <th>Jenis</th>
                                                                                <th>Kuantiti</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach($records as $index => $item)
                                                                            <tr>
                                                                                <td>{{ $index + 1 }}</td>
                                                                                <td>{{ $item->equipment->name ?? '-' }}</td>
                                                                                <td>{{ $item->type == 1 ? 'Utama' : ($item->type == 2 ? 'Tambahan' : '-') }}</td>
                                                                                <td>{{ $item->quantity }}</td>
                                                                            </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    @else
                                                    <p class="text-center">Tiada rekod peralatan ditemui.</p>
                                                    @endif
                                                </div>

                                                <div class="tab-pane fade " id="content-tab4" role="tabpanel" aria-labelledby="tab4-link">
                                                    <div class="card-header mb-3 pl-0">
                                                        <h4>Maklumat Vesel</h4>
                                                    </div>

                                                    {{-- Current Record --}}
                                                    <table class="table table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <td class="col-md-3">Memiliki Vesel</td>
                                                                <td class="col-md-1">:</td>
                                                                <td>{{ $vessel->owns_vessel ? 'ADA' : 'TIADA' }}</td>
                                                            </tr>

                                                            @if (!$vessel->owns_vessel)
                                                            <tr>
                                                                <td class="col-md-3">Pengangkutan (Tidak Memiliki Vesel)</td>
                                                                <td class="col-md-1">:</td>
                                                                <td>{{ $vessel->transportName->name ?? 'TIDAK DIKETAHUI' }}</td>
                                                            </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>

                                                    @if ($vessel->owns_vessel)
                                                    <table class="table table-borderless mt-2">
                                                        <tbody>
                                                            <tr>
                                                                <td class="col-md-3">No. Pendaftaran Vesel</td>
                                                                <td class="col-md-1">:</td>
                                                                <td>{{ $vessel->vessel_registration_number ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Jenis Bahan Vesel</td>
                                                                <td>:</td>
                                                                <td>{{ $vessel->hullType->name ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Panjang Vesel (m)</td>
                                                                <td>:</td>
                                                                <td>{{ $vessel->length ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Jenama Enjin</td>
                                                                <td>:</td>
                                                                <td>{{ $vessel->brand ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Kuasa Kuda (kk)</td>
                                                                <td>:</td>
                                                                <td>{{ $vessel->horsepower ?? 'Tidak Diketahui' }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    @endif

                                                    <br>
                                                    <hr>

                                                    <h5> Rekod Vesel</h5>

                                                    @if($vesselHistories->count())
                                                    <table class="table table-borderless">

                                                        <tbody>
                                                            @foreach($vesselHistories as $date => $records)
                                                            @php $collapseId = 'vesselCollapse_' . \Str::slug($date); @endphp

                                                            {{-- Collapsible Header --}}
                                                            <tr class="table-light text-center" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" style="cursor:pointer;">
                                                                <td>{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</td>
                                                            </tr>

                                                            {{-- Collapsible Content --}}
                                                            <tr class="collapse" id="{{ $collapseId }}">
                                                                <td class="p-0 border-0">
                                                                    @foreach($vesselHistories as $record)
                                                                    <table class="table table-borderless mt-2">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="col-md-3">Memiliki Vesel</td>
                                                                                <td class="col-md-1">:</td>
                                                                                <td>{{ $record->owns_vessel ? 'Ya' : 'Tidak' }}</td>
                                                                            </tr>

                                                                            @if(!$record->owns_vessel)
                                                                            <tr>
                                                                                <td class="col-md-3">Pengangkutan</td>
                                                                                <td class="col-md-1">:</td>
                                                                                <td>{{ $record->transportName->name ?? 'Tidak Diketahui' }}</td>
                                                                            </tr>
                                                                            @else
                                                                            <tr>
                                                                                <td class="col-md-3">No. Pendaftaran Vesel</td>
                                                                                <td class="col-md-1">:</td>
                                                                                <td>{{ $record->vessel_registration_number ?? 'Tidak Diketahui' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Jenis Bahan Vesel</td>
                                                                                <td>:</td>
                                                                                <td>{{ $record->hullType->name ?? 'Tidak Diketahui' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Panjang Vesel (m)</td>
                                                                                <td>:</td>
                                                                                <td>{{ $record->length ?? 'Tidak Diketahui' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Jenama Enjin</td>
                                                                                <td>:</td>
                                                                                <td>{{ $record->brand ?? 'Tidak Diketahui' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Kuasa Kuda (kk)</td>
                                                                                <td>:</td>
                                                                                <td>{{ $record->horsepower ?? 'Tidak Diketahui' }}</td>
                                                                            </tr>
                                                                            @endif
                                                                        </tbody>
                                                                    </table>

                                                                    <hr class="my-3">
                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    @else
                                                    <p class="text-center">Tiada rekod sejarah vesel ditemui.</p>
                                                    @endif

                                                </div>

                                                <div class="tab-pane fade " id="content-tab5" role="tabpanel" aria-labelledby="tab5-link">
                                                    <div class="card-header mb-3 pl-0">
                                                        <h4>Senarai Dokumen Dimuatnaik</h4>
                                                    </div>

                                                    <!-- Table for Uploaded Documents -->
                                                    <div class="table-responsive">
                                                        <table class="table table-borderless">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th style="width: 5%">Bil.</th>
                                                                    <th class="col-md-2">Nama Fail</th>
                                                                    <th class="col-md-2">Penerangan</th>
                                                                    <th class="col-md-2">Tarikh Muat Naik</th>
                                                                    <th class="col-md-1">Tindakan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if ($documents->count())
                                                                @foreach ($documents as $file)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $file->name }}</td>
                                                                    <td>{{ $file->description }}</td>
                                                                    <td>{{ $file->created_at->format('d/m/Y H:i') }}</td>
                                                                    <td>
                                                                        <a class="btn btn-primary col-md" href="{{ route('kadPendaftaran.semakanBayaran-08.viewFile', $file->id) }}">
                                                                            <i class="fa fa-eye"></i> Lihat
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                                @else
                                                                <tr>
                                                                    <td class="text-center" colspan="5">Tiada dokumen dimuat naik.</td>
                                                                </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <hr>

                                                    <!-- LPI Records Table -->
                                                    <div class="card-header mb-3 pl-0">
                                                        <h4>Senarai Rekod LPI</h4>
                                                    </div>

                                                    <div class="table-responsive">
                                                        <table class="table table-borderless">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th style="width: 5%">Bil.</th>
                                                                    <th class="col-md-2">Tarikh LPI Dibuat</th> <!-- Created Date -->
                                                                    <th class="col-md-2">Tarikh Sah LPI</th> <!-- Valid Date -->
                                                                    <th class="col-md-2">Sah / Tamat</th> <!-- Expiry Date -->

                                                                    <th class="col-md-1">Tindakan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if ($lpiRecords->count())
                                                                @foreach ($lpiRecords as $record)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($record->created_at)->format('d/m/Y') }}</td> <!-- Created Date -->
                                                                    <td>{{ \Carbon\Carbon::parse($record->valid_date)->format('d/m/Y') }}</td> <!-- Valid Date -->
                                                                    <td>
                                                                        <span class="btn col-md
                                                                        @if ($record->is_draft)
                                                                            bg-warning text-white
                                                                        @elseif ($record->is_active && \Carbon\Carbon::parse($record->valid_date)->isToday() || \Carbon\Carbon::parse($record->valid_date)->isFuture())
                                                                            bg-success text-white
                                                                        @elseif ($record->is_active && \Carbon\Carbon::parse($record->valid_date)->isPast())
                                                                            bg-danger text-white
                                                                        @else
                                                                            bg-secondary text-white
                                                                        @endif
                                                                    " style="pointer-events: none; cursor: default;">
                                                                            @if ($record->is_draft)
                                                                            Dalam Semakan
                                                                            @elseif ($record->is_active && \Carbon\Carbon::parse($record->valid_date)->isToday() || \Carbon\Carbon::parse($record->valid_date)->isFuture())
                                                                            Sah
                                                                            @elseif ($record->is_active && \Carbon\Carbon::parse($record->valid_date)->isPast())
                                                                            Tamat Tempoh
                                                                            @else
                                                                            Tiada Status
                                                                            @endif
                                                                        </span>

                                                                    </td>
                                                                    <td>
                                                                        @if ($vessel && $vessel->owns_vessel == 1)
                                                                            <a class="btn btn-primary col-md" href="{{ route('kadPendaftaran.semakanBayaran-08.showLpi', $application->id) }}">
                                                                                <i class="fa fa-eye"></i> Lihat
                                                                            </a>
                                                                        @else
                                                                            <a class="btn btn-primary col-md" href="{{ route('kadPendaftaran.semakanBayaran-08.showLpi2', $application->id) }}">
                                                                                <i class="fa fa-eye"></i> Lihat
                                                                            </a>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                                @else
                                                                <tr>
                                                                    <td class="text-center" colspan="6">Tiada rekod LPI tersedia.</td>
                                                                </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>

                                                <div class="tab-pane fade   p-4" id="content-tab6" role="tabpanel" aria-labelledby="tab6-link">

                                                    <h4>Rekod Kesalahan</h4>
                                                    <hr>

                                                    <div class="table-responsive">
                                                        <table class="table table-borderless">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th scope="col">Bil</th>
                                                                    <th scope="col">Jenis Kesalahan</th>
                                                                    <th scope="col">Tarikh Kesalahan</th>
                                                                    <th scope="col">Kaedah</th>
                                                                    <th scope="col">Kaedah Dalam Seksyen</th>
                                                                    <th scope="col">Perintah Mahkamah</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse ($faultRecords as $index => $rekod)
                                                                <tr>
                                                                    <th scope="row">{{ $index + 1 }}</th>
                                                                    <td>{{ $rekod->fault_type }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($rekod->fault_date)->format('d/m/Y') }}</td>
                                                                    <td>{{ $rekod->method }}</td>
                                                                    <td>{{ $rekod->method_section }}</td>
                                                                    <td>{{ $rekod->decision }}</td>
                                                                </tr>
                                                                @empty
                                                                <tr>
                                                                    <td class="text-center" colspan="6">Tiada Rekod Kesalahan.</td>
                                                                </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>

                                                <div class="tab-pane fade " id="content-tab7" role="tabpanel" aria-labelledby="tab7-link">
                                                    <h4>Maklumat Pendaratan</h4>
                                                    <hr>

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

                                                    <h4>Lain - Lain </h4>
                                                    <hr>

                                                    @if($kadPendaftaran)
                                                    <h5 class="mt-3">Maklumat Nelayan</h5>

                                                    <table class="table table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <td class="col-md-3">1. Tahun Mula Nelayan</td>
                                                                <td class="col-md-1">:</td>
                                                                <td>{{ $kadPendaftaran->start_fishing_year }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>2. Tempoh Menjadi Nelayan</td>
                                                                <td>:</td>
                                                                <td>{{ $kadPendaftaran->fishing_duration }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>3. Hari Menangkap Ikan</td>
                                                                <td>:</td>
                                                                <td>{{ $kadPendaftaran->days_fishing_monthly }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>4. Pendapatan Menangkap Ikan (RM)</td>
                                                                <td>:</td>
                                                                <td>RM {{ number_format($kadPendaftaran->annual_income_fishing, 2) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>5. Pendapatan Kerja Lain (RM)</td>
                                                                <td>:</td>
                                                                <td>RM {{ number_format($kadPendaftaran->annual_income_other, 2) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>6. Hari Kerja Lain</td>
                                                                <td>:</td>
                                                                <td>{{ $kadPendaftaran->days_other_work_monthly }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    <br>

                                                    <h5 class="mt-4">Maklumat Kewangan</h5>

                                                    <table class="table table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <td class="col-md-3">1. Menerima Pencen</td>
                                                                <td class="col-md-1">:</td>
                                                                <td>{{ $kadPendaftaran->pension ? 'Ya' : 'Tidak' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>2. Bantuan Kewangan dari Agensi</td>
                                                                <td>:</td>
                                                                <td>{{ $kadPendaftaran->financial_aid ? 'Ya' : 'Tidak' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>3. Pencarum KWSP</td>
                                                                <td>:</td>
                                                                <td>{{ $kadPendaftaran->kwsp ? 'Ya' : 'Tidak' }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    @else
                                                    <div class="mt-3">Tiada data kad pendaftaran dijumpai.</div>
                                                    @endif
                                                </div>

                                                <div class="tab-pane fade " id="content-tab9" role="tabpanel" aria-labelledby="tab9-link">
                                                    <h4>Status Permohonan</h4>
                                                    <hr>
                                                    <!-- Timelime example -->
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <!-- The time line -->
                                                            <div class="timeline">

                                                                @if ($applicationLogs->isEmpty())
                                                                <!-- Show "Tiada Rekod" if no logs exist -->
                                                                <div class="text-muted text-center">
                                                                    <p class="mt-4">Tiada Rekod</p>
                                                                </div>
                                                                @else
                                                                <!-- Show Timeline Items -->
                                                                @foreach ($applicationLogs as $log)
                                                                <div class="time-label">
                                                                    <span class="">{{ $log->created_at->format('d/m/Y') }}</span>
                                                                </div>
                                                                <div>
                                                                    <div class="timeline-item border p-3">

                                                                        <!-- Header: name -->
                                                                        <h5 class="mb-2 timeline-header">{{ $log->applicationStatus->name ?? 'Tidak Diketahui' }}</h5>

                                                                        <div class="timeline-body">

                                                                            <!-- Hide Semakan row if review_flag is null -->
                                                                            @if (!is_null($log->review_flag))
                                                                            <div class="d-flex align-items-start mb-2">
                                                                                <label class="form-label mb-0 me-2" style="white-space: nowrap; min-width: 90px; font-weight: bold;">
                                                                                    Semakan :
                                                                                </label>
                                                                                <span class="@if ($log->review_flag === 1) bg-success
                                                                                                @elseif ($log->review_flag === 0) bg-danger
                                                                                                @endif rounded px-2 py-1 text-white">
                                                                                    {{ $log->review_flag === 1 ? 'LENGKAP' : 'TIDAK LENGKAP' }}
                                                                                </span>
                                                                            </div>
                                                                            <hr>
                                                                            @endif

                                                                            <!-- Ulasan -->
                                                                            @if (!empty($log->remarks))
                                                                            <div class="d-flex align-items-start mb-2">
                                                                                <label class="form-label mb-0 me-2" style="white-space: nowrap; min-width: 90px; font-weight: bold;">
                                                                                    Ulasan :
                                                                                </label>
                                                                                <span>{{ $log->remarks }}</span>
                                                                            </div>
                                                                            <hr>
                                                                            @endif

                                                                            <!-- Hidden Fields for Nama Penyemak and Jawatan -->
                                                                            <div class="collapse" id="viewMoreSection{{ $loop->index }}">

                                                                                <!-- Penyemak (Display Name Only) -->
                                                                                <div class="d-flex align-items-start mb-2">
                                                                                    <label class="form-label mb-0 me-2" style="white-space: nowrap; min-width: 90px; font-weight: bold;">
                                                                                        Pelaku :
                                                                                    </label>
                                                                                    <span>{{ strtoupper($log->creator->name ?? 'Tidak Diketahui') }}</span>
                                                                                </div>
                                                                                <hr>

                                                                                <!-- Jawatan (Display Roles) -->
                                                                                <div class="d-flex align-items-start mb-2">
                                                                                    <label class="form-label mb-0 me-2" style="white-space: nowrap; min-width: 90px; font-weight: bold;">
                                                                                        Jawatan :
                                                                                    </label>
                                                                                    <span>
                                                                                        @if ($log->creator && $log->creator->userRoles->isNotEmpty())
                                                                                        {{ $log->creator->userRoles->pluck('name')->join(', ') }}
                                                                                        @else
                                                                                        Tidak Diketahui
                                                                                        @endif
                                                                                    </span>
                                                                                </div>

                                                                            </div>

                                                                            <!-- View More Link -->
                                                                            <div class="text-right">
                                                                                <a class="btn btn-link p-0" data-bs-toggle="collapse" href="#viewMoreSection{{ $loop->index }}" role="button" aria-expanded="false" aria-controls="viewMoreSection{{ $loop->index }}">
                                                                                    <small>View More</small>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                @endforeach
                                                                @endif
                                                                <div>
                                                                    <i class="fa fa-circle-outer bg-grey"></i>
                                                                </div>
                                                            </div>
                                                            <!-- END timeline item -->
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade" id="content-tab10" role="tabpanel" aria-labelledby="tab10-link">

                                                    <div class="card-header pl-0 d-flex align-items-center">
                                                        <h4>Semakan Dan Pengesahan Bayaran</h4>
                                                    </div>

                                                    <br>


                                                    <div class="row">
                                                        <!-- Receipt Number -->
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">No. Resit</label>
                                                            <input class="form-control" type="text" value="{{ $receipt->receipt_number ?? 'Tiada Maklumat' }}" readonly>
                                                        </div>

                                                        <!-- Payment Date -->
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Tarikh Pembayaran</label>
                                                            <input class="form-control" type="text" value="{{ isset($receipt->payment_date) ? \Carbon\Carbon::parse($receipt->payment_date)->format('d/m/Y') : 'Tiada Maklumat' }}" readonly>
                                                        </div>
                                                    </div>

                                                    <!-- Receipt File -->
                                                    <div class="mb-3">
                                                        <span class="bold"><i class="fa fa-info-circle"></i> Klik pautan untuk
                                                            melihat:</span>
                                                        <a class="text-primary ms-2" href="{{ route('kadPendaftaran.semakanBayaran-08.viewReceipt', $receipt->id) }}" target="_blank">
                                                            Resit Pembayaran
                                                        </a>
                                                    </div>

                                                    <hr>
                                                    <br>

                                                    <!-- Payment Items Section -->
                                                    <h5>Senarai Item Bayaran</h5>
                                                    <table class="table table-borderless">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Bil.</th>
                                                                <th>Item</th>
                                                                <th>Jumlah (RM)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($receipt->items as $index => $item)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $item->name }}</td>
                                                                <td>RM {{ number_format($item->price, 2) }}</td>
                                                            </tr>
                                                            @empty
                                                            <tr>
                                                                <td colspan="3" class="text-center">Tiada Item Bayaran</td>
                                                            </tr>
                                                            @endforelse
                                                            <tr></tr>
                                                        </tbody>
                                                    </table>
                                                    <!-- Total Amount -->
                                                    <div class="mb-3">
                                                        <h5>Jumlah Keseluruhan:
                                                            <span class="fw-bold">RM {{ number_format($receipt->items->sum('price') ?? 0, 2) }}</span>
                                                        </h5>
                                                    </div>

                                                    <hr>
                                                    <br>
                                                    <!-- Semakan Section -->
                                                    <div class="row mb-3">
                                                        <label class="form-label" for="textSemakan">Semakan <span class="text-danger">*</span></label>
                                                        <div class="col-md">
                                                            <div class="col-md form-check">
                                                                <input class="form-check-input" id="semakan_1" name="review_flag" type="radio" value="1" required>
                                                                <label class="form-check-label" for="semakan_1">Lengkap</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md">
                                                            <div class="col-md form-check">
                                                                <input class="form-check-input" id="semakan_2" name="review_flag" type="radio" value="0" required>
                                                                <label class="form-check-label" for="semakan_2">Tidak Lengkap</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Pengesahan Section (Hidden by Default) -->
                                                    <div class="row mb-3" id="pengesahanSection" style="display: none;">
                                                        <label class="form-label" for="textPengesahan">Pengesahan <span class="text-danger">*</span></label>
                                                        <div class="col-md">
                                                            <div class="col-md form-check">
                                                                <input class="form-check-input" id="pengesahan_1" name="confirmation_flag" type="radio" value="1">
                                                                <label class="form-check-label" for="pengesahan_1">Sah</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md">
                                                            <div class="col-md form-check">
                                                                <input class="form-check-input" id="pengesahan_2" name="confirmation_flag" type="radio" value="0">
                                                                <label class="form-check-label" for="pengesahan_2">Tidak Sah</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Ulasan Section -->
                                                    <div class="mb-3">
                                                        <label class="form-label" for="textareaUlasanSemakan">Ulasan <span class="text-danger">*</span></label>
                                                        <textarea class="form-control" id="textareaUlasanSemakan" name="remarks" rows="6" required></textarea>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="card-footer pr-0">
                                                <div class="d-flex justify-content-end gap-3">
                                                    <!-- Back and Next Buttons -->

                                                        <button id="backTabBtn" type="button" class="btn btn-light" style="width:120px">Kembali</button>
                                                        <button id="nextTabBtn" type="button" class="btn btn-light" style="width:120px">Seterusnya</button>

                                                        <button id="submitBtn" type="button" class="btn btn-success" style="width:120px; display:none;">
                                                            Hantar
                                                        </button>

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

        {{-- Tab --}}
        <script>
            let currentTab = 1;
            const totalTabs = 10;

            const toggleSubmitButton = () => {
                const isLast = currentTab === totalTabs;
                document.getElementById('submitBtn').style.display = isLast ? 'inline-block' : 'none';
            };

            const switchTab = (direction) => {
                const newTab = currentTab + direction;
                if (newTab < 1 || newTab > totalTabs) {
                    alert(`Ini adalah tab ${newTab < 1 ? 'pertama' : 'terakhir'}.`);
                    return;
                }

                // Hide current tab
                document.getElementById(`tab${currentTab}-link`).classList.remove("active");
                document.getElementById(`content-tab${currentTab}`).classList.remove("show", "active");

                // Show new tab
                currentTab = newTab;
                document.getElementById(`tab${currentTab}-link`).classList.add("active");
                document.getElementById(`content-tab${currentTab}`).classList.add("show", "active");

                toggleSubmitButton();
            };

            document.addEventListener("DOMContentLoaded", () => {
                document.getElementById("nextTabBtn").addEventListener("click", () => switchTab(1));
                document.getElementById("backTabBtn").addEventListener("click", () => switchTab(-1));
                document.getElementById("submitBtn").addEventListener("click", () => {
                    document.getElementById('submitPermohonan').submit();
                });
                toggleSubmitButton();
            });

        </script>

        {{-- Tindakan --}}
        <script>
            $(document).ready(function () {
                // Hide Pengesahan section by default
                $('#pengesahanSection').hide();
                $('input[name="confirmation_flag"]').prop('required', false);

                // Show/Hide Pengesahan section based on Semakan selection
                $('input[name="review_flag"]').on('change', function () {
                    if ($('#semakan_1').is(':checked')) {
                        $('#pengesahanSection').slideDown("slow");
                        $('input[name="confirmation_flag"]').prop('required', true);
                    } else if ($('#semakan_2').is(':checked')) {
                        $('#pengesahanSection').slideUp("slow");
                        $('input[name="confirmation_flag"]').prop('required', false).prop('checked', false);
                    }
                });
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
                            url: '{{ route('kadPendaftaran.keputusan-08.fetchData',['id'=> $application->id]) }}'
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
