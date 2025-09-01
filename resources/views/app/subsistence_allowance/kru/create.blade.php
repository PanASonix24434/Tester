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
            <ul class="nav nav-tabs" id="custom-content-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="custom-content-form-tab" data-toggle="pill" href="#custom-content-form" role="tab" aria-controls="custom-content-form" aria-selected="true">Butiran Pemohon</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" id="custom-content-work-tab" href="#" role="tab" aria-controls="custom-content-work" aria-selected="false">Butiran Pekerjaan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" id="custom-content-depandents-tab" href="#" role="tab" aria-controls="custom-content-dependents" aria-selected="false">Butiran Tanggungan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" id="custom-content-education-tab" href="#" role="tab" aria-controls="custom-content-education" aria-selected="false">Tahap Pendidikan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" id="custom-content-education-tab" href="#" role="tab" aria-controls="custom-content-document" aria-selected="false">Dokumen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" id="custom-content-declaration-tab" href="#" role="tab" aria-controls="custom-content-declaration" aria-selected="false">Perakuan</a>
                </li>
            </ul>
            <br />
            <div>
                <form method="POST" action="{{ route('subsistence-allowance.application.store') }}">
                    @csrf
                    <!-- row -->
                    <div class="row">
                        <div class="col-12">
                            <!-- card -->
                            <div class="card mb-4">
                                <div class="card-header bg-primary">
                                    <h4 class="mb-0" style="color:white;">Butiran Pemohon </h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Nama Pemohon -->
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Pemohon :</label>
                                                <input type="text" class="form-control" id="AppName"  name="fullname" value="{{ Auth::user()->name }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- No Kad Pengenalan -->
                                            <div class="form-group">
                                                <label class="col-form-label">No Kad Pengenalan :</label>
                                                <input type="text" class="form-control" id="AppIC" name="icno" value="{{ Auth::user()->username }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Umur -->
                                            <div class="form-group">
                                                <label class="col-form-label">Umur :</label>
                                                <input type="text" class="form-control" id="AppAge" value="{{ $age }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Alamat Surat Menyurat -->
                                            <div class="form-group">
                                                <label class="col-form-label">Alamat Surat Menyurat :</label>
                                                <input type="text" class="form-control" id="address1" name="address1" value="{{ $userProfile != null ? strtoupper($userProfile->address1) : '-Tiada Maklumat Profail-' }}" readonly>
                                                <input type="text" class="form-control" id="address2" name="address2" value="{{ $userProfile != null ? strtoupper($userProfile->address2) : '-Tiada Maklumat Profail-' }}" readonly>
                                                <input type="text" class="form-control" id="address3" name="address3" value="{{ $userProfile != null ? strtoupper($userProfile->address3) : '-Tiada Maklumat Profail-' }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- Daerah-->
                                            <div class="form-group">
                                                <label class="col-form-label">Daerah :</label>
                                                <input type="text" class="form-control" id="district" value="{{ $userProfile != null ? ($userProfile->district != null ? strtoupper(Helper::getCodeMasterNameById($userProfile->district)) : '-Tiada Daerah-') : '-Tiada Maklumat Profail-' }}" readonly>
                                                <input type="hidden" name="districtId" value="{{ $userProfile != null ? ($userProfile->district != null ? $userProfile->district : null) : null }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Poskod -->
                                            <div class="form-group">
                                                <label class="col-form-label">Poskod :</label>
                                                <input type="text" class="form-control" id="postcode" name="postcode" value="{{ $userProfile != null ? $userProfile->poskod : '-Tiada Maklumat Profail-' }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- Negeri-->
                                            <div class="form-group">
                                                <label class="col-form-label">Negeri :</label>
                                                <input type="text" class="form-control" id="state" value="{{ $userProfile != null ? ($userProfile->state != null ? strtoupper(Helper::getCodeMasterNameById($userProfile->state)) : '-Tiada Negeri-') : '-Tiada Maklumat Profail-' }}" readonly>
                                                <input type="hidden" name="stateId" value="{{ $userProfile != null ? ($userProfile->state != null ? $userProfile->state : null) : null }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <!-- No Telefon -->
                                            <div class="form-group">
                                                <label class="col-form-label">No Telefon Rumah/Bimbit :</label>
                                                <input type="text" class="form-control" id="phoneNo" name="phoneNo" value="{{ $userProfile != null ? $userProfile->no_phone : '-Tiada Maklumat Profail-' }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!--Nama Bank -->
                                            <div class="form-group">
                                                <label for="selNamaBank">Nama Bank : <span style="color:red;">*</span></label>
                                                <select class="form-control select2" id="selNamaBank" name="bank_id" autocomplete="off" required>
                                                    <option value="">-- Sila Pilih --</option>
                                                    @foreach($bank as $st2)
                                                        <option value="{{$st2->id}}">{{ strtoupper($st2->name_ms) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!--No Akaun Bank -->
                                            <div class="form-group">
                                                <label class="col-form-label">No Akaun Bank : <span style="color:red;">*</span></label>
                                                <input type="text" class="form-control" id="AppNoAkaun" name="no_account" placeholder="Sila Masukkan" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!--Cawangan Bank -->
                                            <div class="form-group">
                                            <label for="selNamaBank">Cawangan Bank : <span style="color:red;">*</span></label>
                                            <select class="form-control select2" id="selStateBaru" name="state_bank_id" autocomplete="off" required>
                                                <option value="">-- Sila Pilih --</option>
                                                @foreach($states as $st1)
                                                    <option value="{{$st1->id}}">{{ strtoupper($st1->name_ms) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                            <a href="{{ route('subsistence-allowance.application.index') }}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                            <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Simpan Permohonan Elaun Sara Diri Nelayan?</span>').text())">
                                                <i class="fas fa-save"></i> Simpan & Seterusnya
                                            </button>
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
    </div>

@endsection

@push('scripts')
<script src="{{ asset('template/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript">
    $(document).on('input', "input[type=text]", function () {
        $(this).val(function (_, val) {
            return val.toUpperCase();
        });
    });
</script>
@endpush
