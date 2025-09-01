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
                        <h3 class="mb-0">Permohonan Elaun Sara Diri Nelayan</h3>
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
                <form method="POST" enctype="multipart/form-data" action="{{ route('subsistence-allowance.store') }}">
                    @csrf
                <!-- row -->
                <div class="row">
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary">
								<h4 class="mb-0" style="color:white;">A. Butiran Pemohon </h4>
                            </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <!-- Nama Pemohon -->
                                            <div class="form-group">
                                                <label class="col-form-label">1. Nama Pemohon :</label>
                                                <input type="text" class="form-control" id="AppName"  name="fullname" value="{{ Auth::user()->name }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!-- No Kad Pengenalan -->
                                            <div class="form-group">
                                                <label class="col-form-label">2. No Kad Pengenalan :</label>
                                                <input type="text" class="form-control" id="AppIC" name="icno" value="{{ Auth::user()->username }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <!-- Umur -->
                                            <div class="form-group">
                                                <label class="col-form-label">3. Umur :</label>
                                                <input type="text" class="form-control" id="AppAge" value="Auto" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <!-- Alamat Surat Menyurat -->
                                            <div class="form-group">
                                                <label class="col-form-label">4. Alamat Surat Menyurat :</label>
                                                <input type="text" class="form-control" id="AppAddress1" value="Auto" readonly>
                                                <input type="text" class="form-control" id="AppAddress2" value="Auto" readonly>
                                                <input type="text" class="form-control" id="AppAddress3" value="Auto" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!-- Daerah-->
                                            <div class="form-group">
                                                <label class="col-form-label">5. Daerah :</label>
                                                <input type="text" class="form-control" id="AppDaerah" value="Auto" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <!-- Poskod -->
                                            <div class="form-group">
                                                <label class="col-form-label">6. Poskod :</label>
                                                <input type="text" class="form-control" id="AppPoskod" value="Auto" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!-- Negeri-->
                                            <div class="form-group">
                                                <label class="col-form-label">5. Negeri :</label>
                                                <input type="text" class="form-control" id="AppState" value="Auto" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <!-- No Telefon -->
                                            <div class="form-group">
                                                <label class="col-form-label">6. No Telefon Rumah/Bimbit :</label>
                                                <input type="text" class="form-control" id="AppNoTel" value="Auto" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <!--Nama Bank -->
                                            <div class="form-group">
                                            <label for="selNamaBank">9. Nama Bank : <span style="color:red;">*</span></label>
                                            <select class="form-control select2" id="selNamaBank" name="bank_id" autocomplete="off">
                                                <option value="">-- Sila Pilih --</option>
                                                @foreach($bank as $st2)
                                                    <option value="{{$st2->id}}">{{ strtoupper($st2->name_ms) }}</option>                           
                                                @endforeach	
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <!--No Akaun Bank -->
                                            <div class="form-group">
                                                <label class="col-form-label">10. No Akaun Bank : <span style="color:red;">*</span></label>
                                                <input type="text" class="form-control" id="AppNoAkaun" name="no_account" placeholder="Sila Masukkan" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <!--Cawangan Bank -->
                                            <div class="form-group">
                                            <label for="selNamaBank">11. Cawangan Bank : <span style="color:red;">*</span></label>
                                            <select class="form-control select2" id="selStateBaru" name="state_bank_id" autocomplete="off">
                                                <option value="">-- Sila Pilih --</option>
                                                @foreach($states as $st1)
                                                    <option value="{{$st1->id}}">{{ strtoupper($st1->name_ms) }}</option>                           
                                                @endforeach		
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                    {{--
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="">1. Keputusan Saringan Air Kencing AADK/Hospital/Klinik Kesihatan KKM  <small>Maksimum Saiz : 5MB </small><span style="color:red;">*</span></label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="fileAADK" name="fileAADK" required>
                                                    <label class="custom-file-label" for="fileAADK">Pilih Fail</label>
                                                    </div>
                                                </div>
                                            </div>
                                            @error('fileAADK')
                                                <span id="fileAADK_error" class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="">2. Dokumen KWSP Berkenaan Caruman Bermajikan  <small>Maksimum Saiz : 5MB </small><span style="color:red;">*</span></label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="fileResult" name="fileResult" required>
                                                    <label class="custom-file-label" for="fileResult">Pilih Fail</label>
                                                    </div>
                                                </div>
                                            </div>
                                            @error('fileResult')
                                                <span id="fileResult_error" class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    --}}

                                      <!-- button action -->
                                    <div class="card-body">
                                        <div class="row">
                                            <br />
                                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                                <a href="{{ route('subsistence-allowance.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Simpan Permohonan Elaun Sara Diri Nelayan?</span>').text())">
                                                    <i class="fas fa-save"></i> {{ __('app.save') }}
                                                </button>
                                                <!-- <a href="{{ route('subsistence-allowance.formwork') }}" class="btn btn-dark btn-sm"> <i class="fas fa-arrow-right"></i> {{ __('app.next') }}</a> -->
                                               
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
    </div>

@endsection

@push('scripts')
<script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script src="{{ asset('template/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript">

       bsCustomFileInput.init();

        $(document).on('input', "input[type=text]", function () {
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
        });

        

        

        
        

</script>   
@endpush
