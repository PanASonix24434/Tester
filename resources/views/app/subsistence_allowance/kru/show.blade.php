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
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header bg-primary">
                            <h4 class="mb-0" style="color:white;">Permohonan</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jenis Permohonan</label>
                                        <input type="text" class="form-control" value="{{ strtoupper($subApplication->type_registration) }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nombor Rujukan</label>
                                        <input type="text" class="form-control" value="{{ $subApplication->registration_no }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pejabat Permohonan</label>
                                        <input type="text" class="form-control" value="{{ $subApplication->entity_id != null ? strtoupper(Helper::getEntityNameById($subApplication->entity_id)) : '' }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <input type="text" class="form-control" value="{{ strtoupper($subApplication->sub_application_status) }}" disabled>
                                    </div>
                                </div>
                                {{--
                                @if ($app->kru_application_status_id == $statusIncompleteId)
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Sebab Tidak Lengkap</label>
                                            <textarea class="form-control" rows="4" disabled>{{ $incompleteLog->remark }}</textarea>
                                        </div>
                                    </div>
                                @endif
                                @if ($app->kru_application_status_id == $statusRejectedId)
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Sebab Tidak Lengkap</label>
                                            <textarea class="form-control" rows="4" disabled>{{ $rejectedLog->remark }}</textarea>
                                        </div>
                                    </div>
                                @endif
                                --}}
                            </div>
                            <br/>
                            <ul class="nav nav-tabs" id="custom-content-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-content-form-tab" data-bs-toggle="tab" href="#custom-content-form"
                                    role="tab" aria-controls="custom-content-form" aria-selected="true">Butiran Pemohon</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-content-work-tab" data-bs-toggle="tab" href="#custom-content-work"
                                    role="tab" aria-controls="custom-content-work" aria-selected="false">Butiran Pekerjaan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-content-depandents-tab" data-bs-toggle="tab" href="#custom-content-depandents"
                                    role="tab" aria-controls="custom-content-dependents" aria-selected="false">Butiran Tanggungan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-content-education-tab" data-bs-toggle="tab" href="#custom-content-education"
                                    role="tab" aria-controls="custom-content-education" aria-selected="false">Tahap Pendidikan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-content-doc-tab" data-bs-toggle="tab" href="#custom-content-doc"
                                    role="tab" aria-controls="custom-content-doc" aria-selected="false">Dokumen</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-content-declaration-tab" data-bs-toggle="tab" href="#custom-content-declaration"
                                    role="tab" aria-controls="custom-content-declaration" aria-selected="false">Perakuan</a>
                                </li>
                            </ul>
                            <div class="tab-content p-4" id="tabContent">
                                <div class="tab-pane fade show active" id="custom-content-form" role="tabpanel" aria-labelledby="custom-content-form-tab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Pemohon :</label>
                                                <input type="text" class="form-control" value="{{$subApplication->fullname ?? ''}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">No Kad Pengenalan :</label>
                                                <input type="text" class="form-control" value="{{$subApplication->icno ?? ''}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Umur :</label>
                                                <input type="text" class="form-control" value="{{$subApplication->icno != null ? Helper::convertIcToAge($subApplication->icno) : ''}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Alamat Surat Menyurat :</label>
                                                <input type="text" class="form-control" value="{{$subApplication->address1 ?? ''}}" readonly>
                                                <input type="text" class="form-control" value="{{$subApplication->address2 ?? ''}}" readonly>
                                                <input type="text" class="form-control" value="{{$subApplication->address3 ?? ''}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Daerah :</label>
                                                <input type="text" class="form-control" value="{{ $subApplication != null ? ($subApplication->district_id != null ? strtoupper(Helper::getCodeMasterNameById($subApplication->district_id)) : '-Tiada Daerah-') : '-Tiada Maklumat Profail-' }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Poskod :</label>
                                                <input type="text" class="form-control" value="{{$subApplication->postcode ?? ''}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Negeri :</label>
                                                <input type="text" class="form-control" value="{{ $subApplication != null ? ($subApplication->state_id != null ? strtoupper(Helper::getCodeMasterNameById($subApplication->state_id)) : '-Tiada Daerah-') : '-Tiada Maklumat Profail-' }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">No Telefon Rumah/Bimbit :</label>
                                                <input type="text" class="form-control" value="{{$subApplication->contact_number ?? ''}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="selNamaBank">Nama Bank : </label>
                                                <input type="text" class="form-control" value="{{$subApplication->bank_id != null ? strtoupper(Helper::getCodeMasterNameById($subApplication->bank_id)) : ''}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-form-label">No Akaun Bank : </label>
                                                <input type="text" class="form-control" id="AppNoAkaun" name="no_account" value="{{$subApplication->no_account ?? ''}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="selNamaBank">Cawangan Bank : </label>
                                                <input type="text" class="form-control" value="{{$subApplication->state_bank_id != null ? strtoupper(Helper::getCodeMasterNameById($subApplication->state_bank_id)) : ''}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3">
                                            <a href="{{ route('subsistence-allowance.application.index') }}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="custom-content-work" role="tabpanel" aria-labelledby="custom-content-work-tab">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Status Nelayan :</label>
                                                <input type="text" class="form-control" value="{{ $subApplication->fisherman_type_id != null ? Helper::getCodeMasterNameById($subApplication->fisherman_type_id) : '--Tiada Rekod--' }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Bilangan Hari Menangkap Ikan Sebulan:</label>
                                                <input type="text" class="form-control" value="{{ $subApplication->working_days_fishing_per_month ?? '--Tiada Rekod--' }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
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
                                            <input type="number" class="form-control" value="{{ $subApplication->tot_incomefish ?? '--Tiada Rekod--' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">b. Hasil daripada pekerjaan lain (*jika ada)</label>
                                        </div>
                                        <div class="col-md-6 d-flex">
                                            <span class="input-group-text">RM</span>
                                            <input type="number" class="form-control" value="{{ $subApplication->tot_incomeother ?? '--Tiada Rekod--' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 fw-bold">
                                            <label class="form-label">Jumlah:</label>
                                        </div>
                                        <div class="col-md-6 d-flex">
                                            <span class="input-group-text">RM</span>
                                            <input type="number" class="form-control fw-bold" value="{{ $subApplication->tot_allincome ?? '--Tiada Rekod--' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3">
                                            <a href="{{ route('subsistence-allowance.application.index') }}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="custom-content-depandents" role="tabpanel" aria-labelledby="custom-content-depandents-tab">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Bilangan Tanggungan</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                Bilangan tanggungan adalah jumlah tanggungan keluarga termasuk pemohon. Anak-anak yang telah bekerja atau berumahtangga dan berumur 21 tahun ke atas tidak termasuk di bawah tanggungan ibubapa/ penjaga, walaubagaimanapun pengecualian diberikan kepada anak kurang upaya atau masih menuntut di Institusi Pengajian Tinggi di peringkat Ijazah Pertama.
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">a. Bilangan Anak</label>
                                        </div>
                                        <div class="col-md-6 d-flex">
                                            <input type="number" class="form-control" value="{{ $subApplication->tot_child ?? '0' }}" readonly>
                                            <span class="input-group-text">Orang</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">b. Lain-lain (pemohon , isteri, ibu-bapa yang tinggal sekali dengan pemohon)</label>
                                        </div>
                                        <div class="col-md-6 d-flex">
                                            <input type="number" class="form-control" value="{{ $subApplication->tot_otherchild ?? '0' }}" readonly>
                                            <span class="input-group-text">Orang</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 fw-bold">
                                            <label class="form-label">Jumlah Tanggungan</label>
                                        </div>
                                        <div class="col-md-6 d-flex">
                                            <input type="number" class="form-control fw-bold" value="{{ $subApplication->tot_allchild ?? '' }}" readonly>
                                            <span class="input-group-text">Orang</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3">
                                            <a href="{{ route('subsistence-allowance.application.index') }}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="custom-content-education" role="tabpanel" aria-labelledby="custom-content-education-tab">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Tahap Pendidikan Pemohon</label>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" id="is_primary" {{ !empty($subApplication->is_primary) && $subApplication->is_primary == 1 ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="primary">Sekolah Rendah</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" id="is_secondary" {{ !empty($subApplication->is_secondary) && $subApplication->is_secondary == 1 ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="secondary">Sekolah Menengah</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" id="is_uni" {{ !empty($subApplication->is_uni) && $subApplication->is_uni == 1 ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="college">Kolej / Universiti</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" id="no_school" {{ !empty($subApplication->no_school) && $subApplication->no_school == 1 ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="no_school">Tidak Bersekolah</label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3">
                                            <a href="{{ route('subsistence-allowance.application.index') }}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="custom-content-doc" role="tabpanel" aria-labelledby="custom-content-doc-tab">
                                    <div class="row">
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
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3">
                                            <a href="{{ route('subsistence-allowance.application.index') }}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="custom-content-declaration" role="tabpanel" aria-labelledby="custom-content-declaration-tab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-12 text-center">
                                                    <div class="form-group mb-0">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="terms" checked disabled>
                                                            <label class="custom-control-label" for="terms">Saya dengan ini mengakui dan mengesahkan bahawa semua maklumat yang diberikan oleh saya adalah benar. Sekiranya terdapat maklumat yang tidak benar, pihak Jabatan boleh menolak permohonan saya dan tindakan undang-undang boleh dikenakan ke atas saya.</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3">
                                            <a href="{{ route('subsistence-allowance.application.index') }}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
<script type="text/javascript">
</script>
@endpush
