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
                        <h3 class="mb-0">Kemaskini Maklumat Kakitangan</h3>
                    </div>
                    <div class="mb-5">
                      <label style="font:#007bff;"> Butiran Am Individu</label>
                        __________________________________________________________________________________________________
                    </div>
                </div>
            <div>
                
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                      <!-- Card -->
                      <div>
                      <form method="POST" enctype="multipart/form-data" action="{{ route('appointment.search.updateappt', $appt->id) }}" autocomplete="off">
                      
                       @csrf

                           <input type="hidden" id="hide_aid2" name="hide_aid2" value="{{ $appt->id }}"> 
                          <!--  <input type="hidden" id="hide_uid2" name="hide_uid2" value="{{ $appt->user_id }}"> -->

                            <div class="card-body row">
                                <div class="col-lg-6">

                                    <div class="mb-3">
                                        <label for="txtName" class="form-label">Nama Individu : <span style="color:red;">*</span></label>
                                        <input type="text" id="txtName" name="txtName" class="form-control" value="{{ $appt->name }}" required />
                                    </div>                                 
                                        <span id="txtName_error" class="text-danger" role="alert">
                                            <strong></strong>
                                        </span>
                                    <div class="mb-3">
                                        <label for="txtRole" class="form-label">Jawatan : <span style="color:red;">*</span></label>
                                        <br />
                                        <select id="selRole" class="form-control" name="selRole" autocomplete="off">   
                                            @foreach($roleAppt as $roleAppt)
                                                <option value="{{ $roleAppt->name }}" selected>{{ strtoupper($roleAppt->name) }}</option>
                                            @endforeach	
                                            @foreach($role as $role)
                                                <option value="{{ $role->name }}">{{ strtoupper($role->name) }}</option>
                                            @endforeach	
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                            <label for="txtEmail" class="form-label">Emel : <span style="color:red;">*</span></label>
                                            <input type="email" id="txtEmail" name="txtEmail" class="form-control" value="{{ $appt2[0]->email }}" required />
                                        </div>
                                        <div class="mb-3">
                                            <label for="txtReportDate" class="form-label">Tarikh Pelantikan/Pertukaran : <span style="color:red;">*</span></label>
                                            <input type="date" id="txtDate" name="txtReportDate" class="form-control" value="{{ $appt->report_date }}" required />
                                        </div>
                                                             
                                </div>

                                <div class="col-lg-6">
                                <div class="mb-3">
                                        <label for="txtICNO" class="form-label">No Kad Pengenalan ( Tanpa '-' ) : <span style="color:red;">*</span></label>
                                        <input type="text" id="txtICNO" name="txtICNO" class="form-control" value="{{ $appt->icno }}" required />
                                    </div>                                        
                                    <div class="mb-3">
                                        <label for="txtLevel" class="form-label">Peringkat : <span style="color:red;">*</span></label>
                                        <select id="selLevel" class="form-control" name="selLevel" autocomplete="off">
                                            @foreach($level as $level)
                                                    <option value="{{ $level->entity_name }}" selected>{{ strtoupper($level->entity_name) }}</option>
                                            @endforeach
                                            @foreach($appt_level as $appt_level)
                                                    <option value="{{ $appt_level->entity_name }}" selected>{{ strtoupper($appt_level->entity_name) }}</option>
                                            @endforeach
                                        </select>	
                                            
                                    </div>
                                    <div class="mb-3">
                                    <label class="form-label" for="selectOne">Pejabat Bertugas : <span style="color:red;">*</span></label>
									<select class="form-select select2" id="selEntity" name="selEntity" autocomplete="off" height="100%">
                                        @foreach($entities as $entities)
                                            <option value="{{ $entities->entity_name }}" selected>{{ $entities->entity_name }}</option>                                                   
                                        @endforeach
                                        @foreach($entities_office as $entities_office)
                                            <option value="{{ $entities_office->entity_name }}" selected>{{ $entities_office->entity_name }}</option>                                                   
                                        @endforeach	
                                    </select>
								</div>
                                    <div class="mb-3" id="cawanganField">
                                        <label for="txtUnit" class="form-label">Cawangan : <span style="color:red;">*</span></label>
                                        <select id="selUnit" class="form-control" name="selUnit" autocomplete="off">
                                                @foreach($depart as $depart)
                                                    <option value="{{ $depart->name }}" selected>{{ $depart->name }}</option>                                                   
                                                @endforeach
                                                @foreach($depart_appt as $depart_appt)
                                                    <option value="{{ $depart_appt->name }}" selected>{{ $depart_appt->name }}</option>                                                   
                                                @endforeach	
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="icDoc">Salinan Kad Pengenalan Kakitangan: <small>Maksimum Saiz : 5MB </small><span style="color:red;">*</span></label>
                                        <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="icDoc" name="icDoc" value="{{ $appt2[0]->ic_file_name }}">
                                            <label class="custom-file-label" for="icDoc">Choose file</label>
                                        </div>
                                        </div>
                                    </div>
                                    @error('icDoc')
                                        <span id="icDoc_error" class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="letterDoc">Surat Pelantikan/Surat Pertukaran Penempatan/Surat Penangguhan Kerja: <small>Maksimum Saiz : 5MB </small><span style="color:red;">*</span></label>
                                            <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="letterDoc" name="letterDoc" value="{{ $appt2[0]->letter_file_name }}">
                                                <label class="custom-file-label" for="letterDoc">Choose file</label>
                                            </div>
                                            </div>
                                        </div>
                                        @error('letterDoc')
                                            <span id="letterDoc_error" class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </div>                           
                                </div>
                                
                            </div>
                            <br/>
                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                <a href="{{ route('appointment.search.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                <form action="{{ route('button.action') }}" method="POST">
                                @csrf
                                <button type="submit" name="action" value="save" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Kemaskini Kakitangan ?</span>').text())">
                                    <i class="fas fa-update"></i> {{ __('app.update') }}
                                </button>
                                <button type="submit" name="action" value="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Hantar Permohonan ?</span>').text())">
                                    <i class="fas fa-paper-plane"></i> {{ __('app.submit') }}
                                </button><br/>
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
