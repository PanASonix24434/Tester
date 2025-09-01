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
                        <div class="card card-primary">
                            <form method="POST" id="submitPermohonan"
      action="{{ route('kadPendaftaran.permohonan-08.storeAppeal', ['application' => $application->id]) }}" enctype="multipart/form-data">
    @csrf


                            <div class="card-header pb-0">
                                <h5 class="card-title m-0 mb-2">Maklumat Rayuan</h5>
                            </div>

                            <div class="card-body">
                                {{-- Section 1: Officer's Comment --}}
                                <div class="mb-4">
                                    <h5 class="fw-bold">Ulasan Pegawai</h5>
                                    <div class="border rounded p-3 bg-light">
                                        {{ $applicationLogs->remarks ?? 'Tiada ulasan disediakan.' }}
                                    </div>
                                </div>

                                {{-- Section 2: Applicant Appeal Input --}}
                                <div>
                                    <h5 class="fw-bold">Rayuan Pemohon  <span
                                                class="text-danger">*</span></h5>

                                    <div class="form-group mb-3">
                                        <small for="appeal_text">Sila nyatakan alasan rayuan</small>
                                                <br>
                                        <textarea name="appeal_text" id="appeal_text" rows="5" class="form-control"
                                            required>{{ old('appeal_text') }}</textarea>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="appeal_attachment">Muat naik dokumen sokongan</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="appeal_attachment"
                                                name="appeal_attachment" accept=".pdf,.jpg,.jpeg,.png">
                                            <label class="custom-file-label" for="appeal_attachment">Pilih Fail</label>
                                        </div>
                                        <small class="text-muted">Dokumen sokongan adalah pilihan tetapi
                                            digalakkan.</small>
                                    </div>
                                </div>
                            </div>
                            @push('scripts')
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('appeal_attachment');
        const label = input.nextElementSibling;

        input.addEventListener('change', function () {
            label.textContent = this.files.length > 0 ? this.files[0].name : 'Pilih Fail';
        });
    });
                            </script>
                            @endpush



                            </form>

                            <div class="card-footer text-end">
                                    <button class="btn btn-success" form="submitPermohonan" >Hantar</button>
                            </div>

                        </div>


                        <div class="card card-primary">
                            <div class="card-header pb-0">
                                <ul class="nav nav-tabs" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link custom-nav-link active" id="tab1-link" aria-disabled="true">
                                            Pemohon</a>
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
                                        <a class="nav-link custom-nav-link" id="tab5-link" aria-disabled="true">Dokumen
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link custom-nav-link" id="tab6-link" aria-disabled="true">Rekod
                                            Kesalahan </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link custom-nav-link" id="tab7-link"
                                            aria-disabled="true">Pendaratan </a>
                                    </li>

                                </ul>

                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="pills-tabContent">
                                    <!-- -->
                                    <div class="tab-pane fade show active p-4 pt-0" id="content-tab1" role="tabpanel"
                                        aria-labelledby="tab1-link">

                                        <h5 class="fw-bold mb-0">Maklumat Peribadi</h5>
                                        <small class="text-muted">Sila isikan maklumat peribadi anda dengan
                                            lengkap</small>
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
                                                    <td>
                                                        {{ $userDetail->icno ??
                                                        'Tidak
                                                        Diketahui' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>No. Telefon</td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $userDetail->no_phone ?? 'Tidak Diketahui' }}
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
                                                    <td>{{ $userDetail->address1 ?? '' }} {{
                                                        $userDetail->address2 ?? '' }} {{ $userDetail->address3
                                                        ?? '' }} </td>
                                                </tr>
                                                <tr>
                                                    <td>Poskod</td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $userDetail->poskod ?? 'Tidak Diketahui' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Daerah</td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $userDetail->district ?? 'Tidak Diketahui' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Negeri</td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $userDetail->state ?? 'Tidak Diketahui' }}</td>
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
                                                        collect([
                                                        $userDetail->secondary_address_1 ?? null,
                                                        $userDetail->secondary_address_2 ?? null,
                                                        $userDetail->secondary_address_3 ?? null
                                                        ])
                                                        ->filter()
                                                        ->implode(', ') ?: 'Tidak Diketahui'
                                                        }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Poskod</td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $userDetail->secondary_postcode ?? 'Tidak Diketahui' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Daerah</td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $userDetail->secondary_district ?? 'Tidak Diketahui' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Negeri</td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $userDetail->secondary_state ?? 'Tidak Diketahui' }}
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
                                                    'Tidak
                                                    Diketahui' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tempoh Menjadi Nelayan</td>
                                                <td class="text-center">:</td>
                                                <td>{{ $fishermanInfo['becoming_fisherman_duration'] ?? 'Tidak
                                                    Diketahui' }}
                                                    Tahun</td>
                                            </tr>
                                            <tr>
                                                <td>Hari Bekerja Menangkap Ikan Sebulan</td>
                                                <td class="text-center">:</td>
                                                <td>{{ $fishermanInfo['working_days_fishing_per_month'] ??
                                                    'Tidak Diketahui' }}
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
                                                <td>{{ ($fishermanInfo['receive_pension'] ?? 0) == 1 ? 'Ya' :
                                                    'Tidak' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Menerima Bantuan Kewangan</td>
                                                <td class="text-center">:</td>
                                                <td>{{ ($fishermanInfo['receive_financial_aid'] ?? 0) == 1 ?
                                                    'Ya' : 'Tidak' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Pencarum KWSP</td>
                                                <td class="text-center">:</td>
                                                <td>{{ ($fishermanInfo['epf_contributor'] ?? 0) == 1 ? 'Ya' :
                                                    'Tidak' }}
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
                                                    <td>{{ isset($jettyInfo['state']) ? Str::upper($jettyInfo['state'])
                                                        : 'TIDAK DIKETAHUI' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Daerah</td>
                                                    <td>:</td>
                                                    <td>{{ isset($jettyInfo['district']) ?
                                                        Str::upper($jettyInfo['district']) : 'TIDAK DIKETAHUI' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Nama Sungai/Tasik</td>
                                                    <td>:</td>
                                                    <td>{{ isset($jettyInfo['river']) ? Str::upper($jettyInfo['river'])
                                                        : 'TIDAK DIKETAHUI' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Pangkalan</td>
                                                    <td>:</td>
                                                    <td>{{ isset($jettyInfo['jetty_name']) ?
                                                        Str::upper($jettyInfo['jetty_name']) : 'TIDAK DIKETAHUI' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <br>

                                    </div>

                                    <div class="tab-pane fade p-4" id="content-tab3" role="tabpanel"
                                        aria-labelledby="tab3-link">
                                        <div class="mb-3">
                                            <h5 class="fw-bold">Maklumat Peralatan</h5>
                                            <small class="text-muted">Bahagian ini memaparkan maklumat peralatan
                                                menangkap ikan yang dimohon oleh pemohon.</small>
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
                                                    <td>{{ e($equipment['name'] ?? 'Tidak Diketahui') }}</td>
                                                    <td>
                                                        @if ($equipment['type'] === 'UTAMA')
                                                        UTAMA
                                                        @elseif ($equipment['type'] === 'TAMBAHAN')
                                                        TAMBAHAN
                                                        @else
                                                        Tidak Diketahui
                                                        @endif
                                                    </td>
                                                    <td>{{ $equipment['quantity'] ?? 'Tidak Diketahui' }}</td>
                                                    <td>
                                                        @if (!empty($equipment['file_path']))
                                                        <a href="{{ route('kadPendaftaran.semakanDokumen-08.viewEquipment', [
                                    'type' => $equipment['type'],
                                    'index' => $index,
                                    'application_id' => $application->id
                                ]) }}" class="btn btn-primary" target="_blank">
                                                            <i class="fa fa-search p-1"></i>
                                                        </a>
                                                        @else
                                                        <span class="text-muted">Tiada Fail</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="5" class="text-muted text-center">Tiada peralatan
                                                        direkodkan.</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="tab-pane fade p-4" id="content-tab4" role="tabpanel"
                                        aria-labelledby="tab4-link">
                                        <div class="mb-4">
                                            <h5 class="fw-bold mb-0">Maklumat Pemilikan Vesel</h5>
                                            <small class="text-muted">Maklumat ini memaparkan butiran pemilikan
                                                vesel.</small>
                                            <hr>
                                        </div>

                                        <table class="table-borderless table">
                                            <tbody>
                                                @if (($vesselInfo['has_vessel'] ?? '') === 'no' &&
                                                !empty($vesselInfo['transport_type']))
                                                <tr>
                                                    <td class="col-md-4">Jenis Pengangkutan Digunakan</td>
                                                    <td class="col-md-1 text-center">:</td>
                                                    <td>{{ $vesselInfo['transport_type'] }}</td>
                                                </tr>
                                                @endif

                                                @if (($vesselInfo['has_vessel'] ?? '') === 'yes')
                                                <tr>
                                                    <td class="col-md-4 fw-bold table-light" colspan="3">Maklumat Vesel
                                                    </td>
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
                                                    <td class="fw-bold table-light" colspan="3">Maklumat Enjin</td>
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
                                        <h5 class="fw-bold mb-0">Dokumen Permohonan</h5>
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
                                                    <td>{{ $doc['title'] ?? 'Tidak Diketahui' }}</td>
                                                    <td>
                                                        @if (!empty($doc['file_path']))
                                                        <!-- Trigger Button -->
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
                                                            <div class="modal-dialog modal-xl">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="documentModalLabel{{ $index }}">
                                                                            Paparan Dokumen</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Tutup"></button>
                                                                    </div>
                                                                    <div class="modal-body" style="height: 80vh;">
                                                                        <iframe
                                                                            src="{{ route('kadPendaftaran.semakanDokumen-08.viewDocument', ['index' => $index, 'application_id' => $application->id]) }}"
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
                                                    data-bs-toggle="modal" data-bs-target="#rekodKesalahanModal">
                                                    Kemaskini
                                                </button> --}}

                                            </div>
                                        </div>
                                        <hr>

                                        <!-- Rekod Kesalahan Modal (Extra Large & Centered) -->
                                        <div class="modal fade" id="rekodKesalahanModal" tabindex="-1"
                                            aria-labelledby="rekodKesalahanModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                                <form method="POST"
                                                    action="{{ route('kadPendaftaran.semakanDokumen-08.updateFault', ['application_id' => $application->id]) }}"
                                                    enctype="multipart/form-data" class="modal-content">
                                                    @csrf

                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="rekodKesalahanModalLabel">
                                                            Kemaskini Rekod Kesalahan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Tutup"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="case_number" class="form-label">Nombor
                                                                Kes</label>
                                                            <input type="text" name="case_number" id="case_number"
                                                                class="form-control">
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
                                                                <option value="Menangkap spesies ikan yang dilindungi">
                                                                    Menangkap spesies ikan yang dilindungi
                                                                </option>
                                                                <option value="Menggunakan racun atau bahan letupan">
                                                                    Menggunakan racun atau bahan letupan
                                                                </option>
                                                                <option value="Menangkap ikan melebihi kuota">
                                                                    Menangkap ikan melebihi kuota</option>
                                                                <option value="Mengganggu habitat semula jadi ikan">
                                                                    Mengganggu habitat semula jadi ikan</option>
                                                                <option value="Tidak melaporkan hasil tangkapan">
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
                                                            <label for="method" class="form-label">Kaedah</label>
                                                            <input type="text" name="method" id="method"
                                                                class="form-control">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="method_section" class="form-label">Seksyen
                                                                Kaedah</label>
                                                            <input type="text" name="method_section" id="method_section"
                                                                class="form-control">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="decision" class="form-label">Perintah
                                                                Mahkamah</label>
                                                            <textarea class="form-control" name="decision" id="decision"
                                                                rows="5"></textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="case_document" class="form-label">Muat
                                                                Naik Dokumen Kes</label>
                                                            <input type="file" name="case_document" id="case_document"
                                                                class="form-control"
                                                                accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                                            <small class="text-muted">Format dibenarkan: PDF,
                                                                JPG, JPEG, PNG, DOC, DOCX. Saiz maksimum:
                                                                2MB.</small>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-success">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

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
                                                            <button class="btn btn-primary" data-bs-toggle="modal"
                                                                data-bs-target="#viewDocumentModal{{ $rekod->id }}">
                                                                <i class="fa fa-search p-1"></i>
                                                            </button>

                                                            <!-- Modal -->
                                                            <div class="modal fade"
                                                                id="viewDocumentModal{{ $rekod->id }}" tabindex="-1"
                                                                aria-labelledby="viewDocumentLabel{{ $rekod->id }}"
                                                                aria-hidden="true">
                                                                <div
                                                                    class="modal-dialog modal-xl modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="viewDocumentLabel{{ $rekod->id }}">
                                                                                Paparan Dokumen Kes</h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Tutup"></button>
                                                                        </div>
                                                                        <div class="modal-body" style="height: 80vh;">
                                                                            <iframe
                                                                                src="{{ route('kadPendaftaran.semakanDokumen-08.viewFaultDocument', ['application_id' => $application->id, 'record_id' => $rekod->id]) }}"
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
                                                <iframe src="{{ route('kadPendaftaran.semakanDokumen-08.viewDocument', [
                    'index' => array_search($pendaratanDoc, $documents),
                    'application_id' => $application->id
                ]) }}" style="width: 80%; height: 800px;" frameborder="0" class="mx-auto">
                                                </iframe>
                                            </div>
                                        </div>
                                        @else
                                        <div class="alert alert-warning text-center">
                                            Dokumen "Borang Pengisytiharan Pendaratan" tidak dijumpai atau tiada fail
                                            dimuat naik.
                                        </div>
                                        @endif

                                    </div>

                                </div>

                                <div class="card-footer">
                                    <div class="d-flex justify-content-end gap-3">
                                        <!-- Back and Next Buttons -->
                                        <div class="d-flex gap-3">
                                            <button id="backTabBtn" type="button" class="btn btn-light"
                                                style="width:120px; display:none;">
                                                Kembali
                                            </button>

                                            <button id="nextTabBtn" type="button" class="btn btn-light"
                                                style="width:120px">Seterusnya</button>
                                        </div>

                                        <!-- Submit Buttons -->
                                        <div class="d-flex gap-3">

                                            <!-- Hantar Button -->
                                            {{-- <button id="submitBtn" type="submit" form="submitsemakanDokumen"
                                                class="btn btn-success" style="width:120px; display:none;">
                                                Hantar
                                            </button> --}}
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
        <script>
            $(document).ready(function() {
                $('input[name="review_flag"]').on('change', function() {
                    if ($(this).val() === '1') {
                        $('#inspectionDateSection').slideDown();
                        $('#dateCadang').val(''); // Clear the value
                    } else {
                        $('#inspectionDateSection').slideUp();
                        $('#dateCadang').val(''); // Also clear when hiding, if needed
                    }
                });
            });
        </script>

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
    const totalTabs = 7;

    const updateButtonVisibility = () => {
        // Show "Submit" only on last tab
        const submitBtn = document.getElementById('submitBtn');
        if (submitBtn) {
            submitBtn.style.display = (currentTab === totalTabs) ? 'inline-block' : 'none';
        }

        // Show/hide "Kembali"
        const backBtn = document.getElementById('backTabBtn');
        if (backBtn) {
            backBtn.style.display = (currentTab === 1) ? 'none' : 'inline-block';
        }

        // Show/hide "Seterusnya"
        const nextBtn = document.getElementById('nextTabBtn');
        if (nextBtn) {
            nextBtn.style.display = (currentTab === totalTabs) ? 'none' : 'inline-block';
        }
    };

    const switchTab = (direction) => {
        const newTab = currentTab + direction;

        // Prevent switching outside bounds
        if (newTab < 1 || newTab > totalTabs) {
            return;
        }

        // Deactivate current tab
        const currentLink = document.getElementById(`tab${currentTab}-link`);
        const currentContent = document.getElementById(`content-tab${currentTab}`);
        if (currentLink && currentContent) {
            currentLink.classList.remove("active");
            currentContent.classList.remove("show", "active");
        }

        // Update currentTab
        currentTab = newTab;

        // Activate new tab
        const newLink = document.getElementById(`tab${currentTab}-link`);
        const newContent = document.getElementById(`content-tab${currentTab}`);
        if (newLink && newContent) {
            newLink.classList.add("active");
            newContent.classList.add("show", "active");
        }

        updateButtonVisibility();
    };

    document.addEventListener("DOMContentLoaded", () => {
        // Set initial visibility
        updateButtonVisibility();

        // Attach button handlers
        const nextBtn = document.getElementById("nextTabBtn");
        const backBtn = document.getElementById("backTabBtn");

        if (nextBtn) nextBtn.onclick = () => switchTab(1);
        if (backBtn) backBtn.onclick = () => switchTab(-1);
    });
        </script>



        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        @endpush
