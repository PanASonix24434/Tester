@extends('layouts.app')

@push('styles')
    <style type="text/css">
    </style>
@endpush

@section('content')
    <!-- Page Content -->
    <div id="app-content">
        <!-- Container fluid -->
        <div class="app-content-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <!-- Page header -->
                    <div class="mb-8">
                        <h3 class="mb-0">Permohonan Elaun Sara Hidup Nelayan Darat</h3>
                    </div>
                </div>
                <div class="col-md-4">
                </div>
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-12">
                    <!-- card -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary">
                            <h4 class="mb-0" style="color:white;">Senarai Permohonan</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Pemilik Vesel</label>
                                    <input type="text" class="form-control" value="{{$subApplication->fullname}}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. Kad Pengenalan</label>
                                    <input type="text" class="form-control" value="{{$subApplication->icno}}" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Tarikh Permohonan</label>
                                    <input type="text" class="form-control" value="{{$subApplication->created_at}}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. Rujukan Permohonan</label>
                                    <input type="text" class="form-control" value="{{$subApplication->registration_no}}" readonly>
                                </div>
                            </div>
                            <br/>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active disabled" id="custom-content-form-tab" data-bs-toggle="tab" href="#custom-content-form" role="tab"
                                    aria-controls="custom-content-form" aria-selected="true">Butiran Pemohon</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link disabled" id="work-tab" data-bs-toggle="tab" href="#work" role="tab"
                                    aria-controls="work" aria-selected="false">Butiran Pekerjaan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link disabled" id="dependent-tab" data-bs-toggle="tab" href="#dependent" role="tab"
                                    aria-controls="dependent" aria-selected="false">Butiran Tanggungan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link disabled" id="education-tab" data-bs-toggle="tab" href="#education" role="tab"
                                    aria-controls="education" aria-selected="false">Tahap Pendidikan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link disabled" id="document-tab" data-bs-toggle="tab" href="#document" role="tab"
                                    aria-controls="document" aria-selected="false">Dokumen Permohonan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link disabled" id="landing-tab" data-bs-toggle="tab" href="#landing" role="tab"
                                    aria-controls="landing" aria-selected="false">Maklumat Pendaratan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link disabled" id="log-tab" data-bs-toggle="tab" href="#log" role="tab"
                                    aria-controls="log" aria-selected="false">Status Permohonan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link disabled" id="action-tab" data-bs-toggle="tab" href="#action" role="tab"
                                    aria-controls="action" aria-selected="false">Tindakan</a>
                                </li>
                            </ul>
                            <div class="tab-content p-4" id="tabContent">
                                <div class="tab-pane fade show active" id="custom-content-form" role="tabpanel" aria-labelledby="custom-content-form-tab">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Nama Pemohon</label>
                                                <input type="text" class="form-control" value="{{$subApplication->fullname ?? ''}}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">No. Kad Pengenalan</label>
                                                <input type="text" class="form-control" value="{{$subApplication->icno ?? ''}}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Umur</label>
                                                <input type="text" class="form-control" value="{{$subApplication->icno != null ? Helper::convertIcToAge($subApplication->icno) : ''}}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">No. Telefon Rumah/Bimbit</label>
                                                <input type="text" class="form-control" value="{{$subApplication->contact_number ?? ''}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Alamat Surat Menyurat</label>
                                                <input type="text" class="form-control" value="{{$subApplication->address1 ?? ''}}" readonly>
                                                <input type="text" class="form-control" value="{{$subApplication->address2 ?? ''}}" readonly>
                                                <input type="text" class="form-control" value="{{$subApplication->address3 ?? ''}}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Poskod</label>
                                                <input type="text" class="form-control" value="{{$subApplication->postcode ?? ''}}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Daerah</label>
                                                <input type="text" class="form-control" value="{{ $subApplication != null ? ($subApplication->district_id != null ? strtoupper(Helper::getCodeMasterNameById($subApplication->district_id)) : '-Tiada Daerah-') : '-Tiada Maklumat Profail-' }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Negeri</label>
                                                <input type="text" class="form-control" value="{{ $subApplication != null ? ($subApplication->state_id != null ? strtoupper(Helper::getCodeMasterNameById($subApplication->state_id)) : '-Tiada Daerah-') : '-Tiada Maklumat Profail-' }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">Nama Bank</label>
                                                <input type="text" class="form-control" value="{{$subApplication->bank_id != null ? Helper::getCodeMasterNameById($subApplication->bank_id) : ''}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">No. Akaun Bank</label>
                                                <input type="text" class="form-control" value="{{$subApplication->no_account}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">Cawangan Bank</label>
                                                <input type="text" class="form-control" value="{{$subApplication->state_bank_id != null ? Helper::getCodeMasterNameById($subApplication->state_bank_id) : ''}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-md-12 text-md-center mt-3 mt-lg-0">
                                            <a href="{{ route('subsistence-allowance.list-application.index') }}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                            <button class="btn btn-dark btn-sm next-tab-btn" data-next-tab="work-tab"><i class="fas fa-arrow-right"></i> Seterusnya</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="work" role="tabpanel" aria-labelledby="work-tab">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">Status Nelayan</label>
                                                <input type="text" class="form-control" value="{{ $subApplication->fisherman_type_id != null ? Helper::getCodeMasterNameById($subApplication->fisherman_type_id) : '--Tiada Rekod--' }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">Tahun Mula Menjadi Nelayan</label>
                                                <input type="text" class="form-control" value="{{ $subApplication->year_become_fisherman ?? '--Tiada Rekod--' }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">Tempoh Menjadi Nelayan</label>
                                                <input type="text" class="form-control" value="{{ $subApplication->becoming_fisherman_duration ?? '--Tiada Rekod--' }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Bilangan hari menangkap ikan dalam sebulan</label>
                                                <input type="text" class="form-control" value="{{ $subApplication->working_days_fishing_per_month ?? '--Tiada Rekod--' }}" readonly>
                                            </div>
                                        </div>
                                        {{--
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Tangkapan Bulanan</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">RM</span>
                                                        <input type="text" class="form-control" value="Auto" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        --}}
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Purata Pendapatan Bulanan:</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">a. Hasil daripada menangkap ikan</label>
                                        </div>
                                        <div class="col-md-6 d-flex">
                                            <span class="input-group-text">RM</span>
                                            <input type="text" class="form-control" value="{{ $subApplication->tot_incomefish ?? '0' }}"  readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">b. Hasil daripada pekerjaan lain (*jika ada)</label>
                                        </div>
                                        <div class="col-md-6 d-flex">
                                            <span class="input-group-text">RM</span>
                                            <input type="text" class="form-control" value="{{ $subApplication->tot_incomeother ?? '0' }}"  readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 fw-bold">
                                            <label class="form-label">Jumlah:</label>
                                        </div>
                                        <div class="col-md-6 d-flex">
                                            <span class="input-group-text">RM</span>
                                            <input type="text" class="form-control fw-bold" value="{{ $subApplication->tot_allincome ?? '' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @php
                                            $percentage = $subApplication->tot_allincome != 0 ? round(($subApplication->tot_incomefish / $subApplication->tot_allincome) * 100,2) : 0;
                                        @endphp
                                        <div class="col-md-6 fw-bold">
                                            <label class="form-label">Peratus Pendapatan Hasil Daripada Menangkap Ikan:</label>
                                        </div>
                                        <div class="col-md-6 d-flex">
                                            @if ($percentage >= 75)
                                                <input style="background-color: greenyellow;" type="text" class="form-control fw-bold" value="{{ $percentage }}%" readonly>
                                            @else
                                                <input style="background-color: salmon;" type="text" class="form-control fw-bold" value="{{ $percentage }}%" readonly>
                                            @endif
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                            <button class="btn btn-dark btn-sm next-tab-btn" data-next-tab="custom-content-form-tab"><i class="fas fa-arrow-left"></i> Kembali</button>
                                            <button class="btn btn-dark btn-sm next-tab-btn" data-next-tab="dependent-tab"><i class="fas fa-arrow-right"></i> Seterusnya</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="dependent" role="tabpanel" aria-labelledby="dependent-tab">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Bilangan Tanggungan</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">a. Bilangan Anak</label>
                                        </div>
                                        <div class="col-md-6 d-flex">
                                            <input type="text" class="form-control" value="{{$subApplication->tot_child}}" readonly>
                                            <span class="input-group-text">Orang</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">b. Lain-lain</label>
                                        </div>
                                        <div class="col-md-6 d-flex">
                                            <input type="text" class="form-control" value="{{$subApplication->tot_otherchild}}" readonly>
                                            <span class="input-group-text">Orang</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 fw-bold">
                                            <label class="form-label">Jumlah Tanggungan</label>
                                        </div>
                                        <div class="col-md-6 d-flex">
                                            <input type="text" class="form-control fw-bold" value="{{$subApplication->tot_allchild}}" readonly>
                                            <span class="input-group-text">Orang</span>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                            <button class="btn btn-dark btn-sm next-tab-btn" data-next-tab="work-tab"><i class="fas fa-arrow-left"></i> Kembali</button>
                                            <button class="btn btn-dark btn-sm next-tab-btn" data-next-tab="education-tab"><i class="fas fa-arrow-right"></i> Seterusnya</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="education" role="tabpanel" aria-labelledby="education-tab">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group" >
                                                <label class="col-form-label">Tahap Pendidikan Pemohon</label>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="education" value="is_primary" id="is_primary" {{ !empty($subApplication->is_primary) && $subApplication->is_primary == 1 ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="primary">Sekolah Rendah</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="education" value="is_secondary" id="is_secondary" {{ !empty($subApplication->is_secondary) && $subApplication->is_secondary == 1 ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="secondary">Sekolah Menengah</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="education" value="is_uni" id="is_uni" {{ !empty($subApplication->is_uni) && $subApplication->is_uni == 1 ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="college">Kolej / Universiti</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="education" value="no_school" id="no_school" {{ !empty($subApplication->no_school) && $subApplication->no_school == 1 ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="no_school">Tidak Bersekolah</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                            <button class="btn btn-dark btn-sm next-tab-btn" data-next-tab="dependent-tab"><i class="fas fa-arrow-left"></i> Kembali</button>
                                            <button class="btn btn-dark btn-sm next-tab-btn" data-next-tab="document-tab"><i class="fas fa-arrow-right"></i> Seterusnya</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="document" role="tabpanel" aria-labelledby="document-tab">
                                    <div class="col-md-12 table-responsive">
                                        <div class="form-group">
                                            <label class="col-form-label">Senarai Dokumen:</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width:1%;">Bil</th>
                                                    <th>Tarikh Dicipta</th>
                                                    <th>Dokumen</th>
                                                    <th>Tindakan Oleh</th>
                                                </tr>
                                            </thead>
                                            <tbody id="listDoc">
                                                @if (!$docs->isEmpty())
                                                    @php
                                                        $count = 0;
                                                    @endphp
                                                    @foreach ($docs as $doc)
                                                        <tr>
                                                            <td>{{++$count}}</td>
                                                            <td>{{$doc->created_at->format('d/m/Y h:i:s A')}}</td>
                                                            <td><a href="{{ route('subsistence-allowance.downloadDoc', $doc->id) }}" target="_blank">{{$doc->title}}</a></td>
                                                            <td>{{strtoupper(Helper::getUsersNameById($doc->created_by))}}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="4" style="text-align: center;">-Tiada Dokumen-</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                            <button class="btn btn-dark btn-sm next-tab-btn" data-next-tab="education-tab"><i class="fas fa-arrow-left"></i> Kembali</button>
                                            <button class="btn btn-dark btn-sm next-tab-btn" data-next-tab="landing-tab"><i class="fas fa-arrow-right"></i> Seterusnya</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="landing" role="tabpanel" aria-labelledby="landing-tab">
                                    <form id="landingSearchForm">
                                        @csrf
                                        <input type="hidden" id="landingUserId" name="landingUserId" value="{{ $subApplication->user_id }}">
                                        <input type="hidden" id="landingYearSearch" name="landingYearSearch" value="">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="col-form-label">RINGKASAN PENDARATAN</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="landingMonthSearch">Pendaratan : </label>
                                                    <select class="form-select" id="landingMonthSearch" name="landingMonthSearch" autocomplete="off" width="100%" required>
                                                        <option value="">{{ __('app.please_select')}}</option>
                                                        @foreach ( $landings as $landing)
                                                            <option value="{{$landing->month}}"
                                                                data-year="{{$landing->year}}"
                                                                >
                                                                    {{ $landing->year }} {{ $landing->month }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-md-center">
                                                <button id="btnlandingsearch" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Cari</button>
                                            </div>
                                        </div>
                                    </form>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">TAHUN</label>
                                                <input type="text" class="form-control" id="searchedYear" value="" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">BULAN</label>
                                                <input type="text" class="form-control" id="searchedMonth" value="" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">HARI OPERASI</label>
                                                <input type="text" class="form-control" id="searchedOperatedDays" value="" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">JUMLAH PENDARATAN (KG)</label>
                                                <input type="text" class="form-control" id="searchedTotalLanding" value="" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="searchedSpeciesList">
                                        <hr/>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-form-label">SENARAI SPESIES: </label>
                                                </div>
                                            </div>
                                            <div class="col-md-12 table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Spesies</th>
                                                            <th>Jumlah Berat (KG)</th>
                                                            <th>Jumlah Harga (RM)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="listSpecies">
                                                        <tr>
                                                            <td colspan="3">-</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                            <button class="btn btn-dark btn-sm next-tab-btn" data-next-tab="document-tab"><i class="fas fa-arrow-left"></i> Kembali</button>
                                            <button class="btn btn-dark btn-sm next-tab-btn" data-next-tab="log-tab"><i class="fas fa-arrow-right"></i> Seterusnya</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="log" role="tabpanel" aria-labelledby="log-tab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="timeline">
                                                @if (!$logs->isEmpty())
                                                    @php
                                                        $count=0;
                                                        $date=0;
                                                    @endphp
                                                    @foreach ($logs as $log)
                                                        @php
                                                            $count++;
                                                            $userlog = App\Models\User::find($log->created_by);
                                                            $roles = $userlog->roles;
                                                        @endphp
                                                        @if ($log->created_at->format('d/m/Y') > $date)
                                                            @php
                                                                $date = $log->created_at->format('d/m/Y');
                                                            @endphp
                                                            <div class="time-label">
                                                                <span class="bg-white">{{$log->created_at->format('d/m/Y')}}</span>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="timeline-item">
                                                            <span class="time"><i class="fas fa-clock"></i> {{$log->created_at->format('h:i:s A')}}</span>
                                                            <h3 class="timeline-header" style="color: black; font-weight: bold; border-bottom: 1px solid #D3D3D3; font-size: 100%; padding-top: 1%; padding-bottom: 1%;">
                                                                Status&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                {{--
                                                                @if ($redStatusIds->contains('id',$log->kru_application_status_id))
                                                                    <span class="badge bg-danger">{{Helper::getCodeMasterNameById($log->kru_application_status_id)}}</span>
                                                                @elseif ($orangeStatusIds->contains('id',$log->kru_application_status_id))
                                                                    <span class="badge bg-warning">{{Helper::getCodeMasterNameById($log->kru_application_status_id)}}</span>
                                                                @else
                                                                @endif
                                                                --}}
                                                                <span class="badge bg-success">{{$log->status}}</span>
                                                            </h3>

                                                            <h3 class="timeline-header" style="color: black; font-weight: bold; border-bottom: 1px solid #D3D3D3; font-size: 100%; padding-top: 1%; padding-bottom: 1%;">
                                                                Ulasan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <br><br>
                                                                <span style="color: black; font-weight: normal; text-align: justify; line-height: 1.6; font-size: 105%;">
                                                                    {{$log->remark}}
                                                                </span>
                                                            </h3>

                                                            <!-- Hidden Nama and Peranan section -->
                                                            <div id="{{'details'.$count}}" style="display: none;">
                                                            <h3 class="timeline-header" style="color: black; font-weight: bold; border-bottom: 1px solid #D3D3D3; font-size: 100%; padding-top: 1%; padding-bottom: 1%;">
                                                                &nbsp;&nbsp;&nbsp;Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <a href="#"
                                                                style="color: black; font-weight: normal;"
                                                                onmouseover="this.style.color='blue';"
                                                                onmouseout="this.style.color='black';">
                                                                    {{$log->name}}
                                                                </a>
                                                            </h3>

                                                            <h3 class="timeline-header" style="color: black; font-weight: bold; border-bottom: 1px solid #D3D3D3; font-size: 100%; padding-top: 1%; padding-bottom: 1%;">
                                                                &nbsp;&nbsp;&nbsp;Peranan&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <a href="#" style="color: black; font-weight: normal;">
                                                                    {{$userlog->roles->sortBy('name')->pluck('name')->implode(', ')}}
                                                                </a>
                                                            </h3>

                                                            </div>
                                                                <div style="text-align: right;">
                                                                    <button onclick="toggleDetails('{{'details'.$count}}', this)" class="btn btn-link" style="text-decoration: none;">
                                                                        <i class="fas fa-angle-down"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.timeline-label -->
                                                    @endforeach

                                                @endif
                                                <!-- timeline item -->
                                                <div>
                                                    <i class="fas fa-clock bg-gray"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                            <button class="btn btn-dark btn-sm next-tab-btn" data-next-tab="landing-tab"><i class="fas fa-arrow-left"></i> Kembali</button>
                                            <button class="btn btn-dark btn-sm next-tab-btn" data-next-tab="action-tab"><i class="fas fa-arrow-right"></i> Seterusnya</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="action" role="tabpanel" aria-labelledby="action-tab">
                                    <form method="POST" action="{{ route('subsistence-allowance.list-application.store') }}">
                                        @csrf
                                        <input type="hidden" id="application_id" name="application_id" value="{{ $subApplication->id }}">
                                        <div class="row">
                                            <div class="mb-3">
                                                <h5>Semakan Permohonan</h5>
                                                <div class="form-group">
                                                    <div>
                                                        <input type="radio" id="lengkap" name="dokumen" value="lengkap" required>
                                                        <label for="lengkap">Lengkap</label>
                                                    </div>
                                                    <div>
                                                        <input type="radio" id="tidak_lengkap" name="dokumen" value="tidak_lengkap">
                                                        <label for="tidak_lengkap">Tidak Lengkap</label>
                                                    </div>
                                                </div>
                                                <div class="form-group mt-3">
                                                    <label for="ulasan">Ulasan</label>
                                                    <textarea id="ulasan" name="ulasan" class="form-control" rows="3">{{ $subApplication->checked_remarks ?? '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row">
                                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                                <a class="btn btn-dark btn-sm next-tab-btn" data-next-tab="log-tab"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                <button id="btnSubmit" type="submit" name="action" value="submit" disabled class="btn btn-success btn-sm" onclick="return confirm($('<span>Hantar Permohonan?</span>').text())">
                                                    <i class="fas fa-paper-plane"></i> Hantar
                                                </button>
                                            </div>
                                        </div>
                                    </form>
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
<script type="text/javascript">
    const nextTabButtons = document.querySelectorAll('.next-tab-btn');
    const tabList = document.getElementById('myTab');

    nextTabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const nextTabId = this.dataset.nextTab;
            const nextTabTrigger = tabList.querySelector(`#${nextTabId}`);

            if (nextTabTrigger) {
            const nextTabBootstrap = bootstrap.Tab.getOrCreateInstance(nextTabTrigger);
            nextTabBootstrap.show();
            }
        });
    });

    $(document).ready(function () {
        $('#btnSubmit').prop("disabled",true);
        
        $('input[type=radio][name=dokumen]').change(function() {
            $('#btnSubmit').prop("disabled",false);
            if ($(this).val()=='lengkap') {
                $('#ulasan').prop("required",false);
            }else if ($(this).val()=='tidak_lengkap'){
                $('#ulasan').prop("required",true);
            }
        });

        $('#landingMonthSearch').change(function() {
            var selectedOption = $(this).find(':selected');
            var year = selectedOption.data('year');
            $('#landingYearSearch').val(year);
        });

        $('#landingSearchForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default browser form submission
            const form = $(this);

            $.ajax({
                url: '{{ route("subsistenceallowancehelper.getLandingSummary") }}',
                type: 'POST', // Will be POST, PUT, DELETE, etc.
                data: form.serialize(), // Includes _token and _method if present
                success: function(response) {
                    $('#searchedYear').val(response.year);
                    $('#searchedMonth').val(response.month);
                    $('#searchedOperatedDays').val(response.operatedDays);
                    $('#searchedTotalLanding').val(response.totalLanding);

                    $('#searchedSpeciesList').empty();
                    var district = '';
                    var location = '';
                    var hasOpener = false;
                    var hasCloser = true;
                    var tableHtml = '';
                    $.each(response.data, function(index, data) {
                        tableHtml = `
                            <hr/>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-form-label">SENARAI SPESIES: ${data.location}, ${data.district}</label>
                                    </div>
                                </div>
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Spesies</th>
                                                <th>Jumlah Berat (KG)</th>
                                                <th>Jumlah Harga (RM)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                        `;
                        $.each(data.species, function(index, species) {
                            tableHtml += `
                                            <tr>
                                                <td>${species.speciesName}</td>
                                                <td>${species.totalWeight}</td>
                                                <td>${species.totalPrice}</td>
                                            </tr>
                            `;
                        });
                        tableHtml += `
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        `;
                        $('#searchedSpeciesList').append(tableHtml);
                    });
                },
            });
        });
    });

    function toggleDetails(detailsId, button) {
        var details = document.getElementById(detailsId);
        if (details.style.display === "none") {
        details.style.display = "block";
        button.innerHTML = '<i class="fas fa-angle-up"></i>';
        } else {
        details.style.display = "none";
        button.innerHTML = '<i class="fas fa-angle-down"></i>';
        }
    }
    
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
        alert(msg);
    }
</script>
@endpush
