@extends('layouts.app')

@push('styles')
    <style type="text/css">
      textarea { text-transform: uppercase; }
    </style>
@endpush

@section('content')

    <!-- Page Content -->
    <div id="app-content">

        <!-- Container fluid -->
        <div class="app-content-area">
        <div class="container-fluid">
            <div class="card mb-10 row">
                <div class="col-md-9">
                    <!-- Page header -->
                    <div class="mb-5">
                        <h3 class="mb-0">Penyahaktifan Kakitangan</h3>
                    </div>
                    <div class="mb-5">
                      <label style="font:#007bff;">Maklumat Kakitangan</label>
                    </div>
                    <div class="mb-5">
                      <label style="font:#007bff;">Butiran Am Individu</label>
                      <br />
                        __________________________________________________________________________________________________
                    </div>
                </div>
            <div>
                
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                      <!-- Card -->
                      <div>
                      <form method="POST" enctype="multipart/form-data" action="{{ route('appointment.search.update', $appt->user_id) }}" autocomplete="off">
                      
                       @csrf
                       <input type="hidden" id="hide_uid2" name="hide_uid2" value="{{ $appt->user_id }}">
                       <input type="hidden" id="hide_appt" name="hide_appt" value="{{ $appt->id }}">
                       <input type="hidden" id="hide_name" name="hide_name" value="{{ $appt->name }}">
                       <input type="hidden" id="hide_icno" name="hide_icno" value="{{ $appt->icno }}">

                            <div class="card-body row">
                                <div class="col-lg-6">

                                    <div class="mb-3">
                                        <label for="txtName" class="form-label">Nama Individu : </label>
                                        <input type="text" id="txtName" name="txtName" class="form-control" value="{{ $appt->name }}" disabled />
                                    </div>
                                    <div class="mb-3">
                                        <label for="txtRole" class="form-label">Peranan : </label>
                                        <input type="text" id="txtRole" name="txtRole" class="form-control" value="{{ $appt->role }}" disabled />
                                    </div>
                                    <div class="mb-3">
                                        <label for="txtEmail" class="form-label">Emel : </label>
                                        <input type="email" id="txtEmail" name="txtEmail" class="form-control" value="{{ $appt2[0]->email }}" disabled />
                                    </div>
                                    <div class="mb-3">
                                        <label for="txtReportDate" class="form-label">Tarikh Lapor Diri : </label>
                                        <input type="date" id="txtDate" name="txtReportDate" class="form-control" value="{{ $appt->report_date }}" disabled />
                                    </div>                                        
                                    <div class="mb-3">
                                        <label for="txtRetireDate" class="form-label">Tarikh Persaraan/Pertukaran : <span style="color:red;">*</span></label>
                                        <input type="date" id="txtRetire" name="txtRetire" class="form-control" required />
                                    </div>
                                    <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="inactiveDoc">Surat Pertukaran/Persaraan: <small>Maksimum Saiz : 5MB </small><span style="color:red;">*</span></label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="inactiveDoc" name="inactiveDoc" required />
                                                    <label class="custom-file-label" for="inactiveDoc">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                        @error('inactiveDoc')
                                            <span id="inactiveDoc_error" class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                                             
                                </div>

                                <div class="col-lg-6">
                                <div class="mb-3">
                                        <label for="txtICNO" class="form-label">No Kad Pengenalan ( Tanpa '-' ) : </label>
                                        <input type="text" id="txtICNO" name="txtICNO" class="form-control" value="{{ $appt->icno }}" disabled />
                                    </div>                                        
                                    <div class="mb-3">
                                        <label for="txtLevel" class="form-label">Peringkat : </label>
                                        <input type="text" id="txtLevel" name="txtLevel" class="form-control" value="{{ $appt->level }}" disabled />
                                    </div>
                                    <div class="mb-3">
                                        <label for="txtUnit" class="form-label">Bahagian/Cawangan/Unit : </label>
                                        <input type="text" id="txtDepart" name="txtDepart" class="form-control" value="{{ $appt->department }}" disabled />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Pejabat Bertugas : </label>
									    <input type="text" id="txtOffice" name="txtOffice" class="form-control" value="{{ $appt->office_duty }}" disabled />
								    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Ulasan Nyahaktif : </label>
									    <textarea style="width: 100%; height: 100px;" id="txtNote" name="txtNote" required></textarea>
								    </div>
                                   
                                </div>
                                
                            </div>
                            <br/>
                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                <a href="{{ route('appointment.search.update', $appt->user_id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Nyahaktifkan Kakitangan ?</span>').text())">
                                    <i class="fas fa-save"></i> {{ __('app.save') }}
                                </button>
                            </div>
                            <br/>
                        </form>
                      </div>
                    </div>
                </div>
                
            </div>
        </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script type="text/javascript"> 

    bsCustomFileInput.init();

    $(document).on('input', "input[type=text]", function () {
        $(this).val(function (_, val) {
            return val.toUpperCase();
        });
    });

    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
        alert(msg);
    }

</script>
@endpush
