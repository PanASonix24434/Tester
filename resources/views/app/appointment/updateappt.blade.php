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

                            <input type="text" id="hide_aid2" name="hide_aid2" value="{{ $appt->id }}"> 
                         <!--   <input type="hidden" id="hide_uid2" name="hide_uid2" value="{{ $appt->user_id }}"> -->

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
                                        <label for="txtRole" class="form-label">Peranan : <span style="color:red;">*</span></label>
                                        <br />
                                        <select id="selRole" class="form-control" name="selRole" autocomplete="off">
                                                                                        
                                            @foreach($role as $a)
                                                    @if ($role == $a->selRole)
                                                    <option value="{{ $appt->role }}" selected>{{ strtoupper($a->role) }}</option>
                                                    @else
                                                    <option value="{{ $appt->role }}">{{ strtoupper($a->name) }}</option>
                                                    @endif
                                                    
                                                @endforeach	
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                            <label for="txtEmail" class="form-label">Emel : <span style="color:red;">*</span></label>
                                            <input type="email" id="txtEmail" name="txtEmail" class="form-control" value="{{ $appt2[0]->email }}" required />
                                        </div>
                                        <div class="mb-3">
                                            <label for="txtReportDate" class="form-label">Tarikh Lapor Diri : <span style="color:red;">*</span></label>
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
                                            @foreach($level as $a)
                                                    @if ($level == $a->selLevel)
                                                    <option value="{{ $appt->level }}" selected>{{ strtoupper($a->level) }}</option>
                                                    @else
                                                    <option value="{{ $appt->level }}">{{ strtoupper($a->name) }}</option>
                                                    @endif
                                                    
                                                @endforeach	
                                        </select>	
                                            
                                    </div>
                                    <div class="mb-3">
                                        <label for="txtUnit" class="form-label">Bahagian/Cawangan/Unit : <span style="color:red;">*</span></label>
                                        <select id="selUnit" class="form-control" name="selUnit" autocomplete="off">
                                                @foreach($depart as $a)
                                                    @if ($depart == $a->selUnit)
                                                    <option value="{{ $appt->department }}" selected>{{ strtupper($a->department) }}</option>
                                                    @else
                                                    <option value="{{ $appt->department }}">{{ strtoupper($a->name) }}</option>
                                                    @endif
                                                    
                                                @endforeach	
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                    <label class="form-label" for="selectOne">Pejabat Bertugas : <span style="color:red;">*</span></label>
									<select class="form-select select2" id="selEntity" name="selEntity" autocomplete="off" height="100%">
                                        @foreach($entities as $entity)
                                            @if ($entities == $a->selEntity)
                                            <option value="{{$entity->id}}">{{$entity->entity_name}}</option>
                                            @else
                                            <option value="{{$entity->id}}">{{$entity->entity_name}}</option>
                                            @endif
                                        @endforeach	
                                    </select>
								</div>
                                </div>
                                
                            </div>
                            <br/>
                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                <a href="{{ route('appointment.search.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Kemaskini Kakitangan ?</span>').text())">
                                    <i class="fas fa-update"></i> {{ __('app.update') }}
                                </button>
                                <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Hantar Permohonan ?</span>').text())">
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
