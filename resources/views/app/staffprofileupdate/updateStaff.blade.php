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
                        <h3 class="mb-0">Input Maklumat Kakitangan</h3>
                    </div>
                    <div class="mb-5">
                      <label style="font:#007bff;"> Butiran Am Individu</label>
                        __________________________________________________________________________________________________
                    </div>
                </div>
            <!--    <div class="col-md-3">
                    <div class="text-right">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{ route('appointment.search.create') }}">Senarai Kakitangan</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Tambah Kakitangan</li>
                            </ol>
                        </nav>
                    </div>
                </div> 
            </div> -->
            <div>
                
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                      <!-- Card -->
                      <div>
                      <form method="POST" enctype="multipart/form-data" action="{{ route('appointment.search.store') }}">
                        <!-- <form id="form-appointment-create" method="POST" action="{{ route('appointment.search.store') }}" autocomplete="off"> -->
                        @csrf

                            <input type="hidden" id="hide_aid2" name="hide_aid2" value="{{ Helper::uuid() }}">

                            <div class="card-body row">
                                <div class="col-lg-6">

                                    <div class="mb-3">
                                        <label for="txtName" class="form-label">Nama Individu : <span style="color:red;">*</span></label>
                                        <input type="text" id="txtName" name="txtName" class="form-control" required />
                                    </div>
                                 
                                        <span id="txtName_error" class="text-danger" role="alert">
                                            <strong></strong>
                                        </span>
                                    <div class="mb-3">
                                        <label for="txtRole" class="form-label">Peranan : <span style="color:red;">*</span></label>
                                        <br />
                                        <select id="selRole" class="form-control" name="selRole" autocomplete="off">
                                            <option value="">Pilih Peranan</option>
                                            @foreach($role as $a)
                                                    @if ($role == $a->selRole)
                                                    <option value="{{ $a->name }}" selected>{{ strtoupper($a->name) }}</option>
                                                    @else
                                                    <option value="{{ $a->name }}">{{ strtoupper($a->name) }}</option>
                                                    @endif
                                                    
                                                @endforeach	
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                            <label for="txtEmail" class="form-label">Emel : <span style="color:red;">*</span></label>
                                            <input type="email" id="txtEmail" name="txtEmail" class="form-control" required />
                                        </div>
                                        <div class="mb-3">
                                            <label for="txtReportDate" class="form-label">Tarikh Lapor Diri : <span style="color:red;">*</span></label>
                                            <input type="date" id="txtDate" name="txtReportDate" class="form-control" required />
                                        </div>
                                                             
                                </div>

                                <div class="col-lg-6">
                                <div class="mb-3">
                                        <label for="txtICNO" class="form-label">No Kad Pengenalan ( Tanpa '-' ) : <span style="color:red;">*</span></label>
                                        <input type="text" id="txtICNO" name="txtICNO" class="form-control" required />
                                    </div>                                        
                                    <div class="mb-3">
                                        <label for="txtLevel" class="form-label">Peringkat : <span style="color:red;">*</span></label>
                                        <br />
                                        <label>
                                            <input type="radio" name="level" value="daerah">
                                                Daerah
                                            </label>
                                            &nbsp; &nbsp;
                                            <label>
                                                <input type="radio" name="level" value="negeri">
                                                Negeri
                                            </label>
                                    </div>
                                    <div class="mb-3">
                                        <label for="txtUnit" class="form-label">Bahagian/Cawangan/Unit : <span style="color:red;">*</span></label>
                                        <br />
                                        <select id="selUnit" class="form-control" name="selUnit" autocomplete="off">
                                            <option value="">Pilih Bahagian/Cawangan/Unit</option>
                                            @foreach($depart as $a)
                                                    @if ($depart == $a->selRole)
                                                    <option value="{{ $a->name }}" selected>{{ strtoupper($a->name) }}</option>
                                                    @else
                                                    <option value="{{ $a->name }}">{{ strtoupper($a->name) }}</option>
                                                    @endif
                                                    
                                                @endforeach	
                                        </select>
                                    </div>
                                    <br />
                                    <div class="mb-3">
                                    <label class="form-label" for="selectOne">Pejabat Bertugas : <span style="color:red;">*</span></label>
									<select class="form-select select2" id="selEntity" name="selEntity" autocomplete="off" height="100%">
                                        <option value="">Pilih Pejabat</option>
                                        @foreach($entities as $entity)
                                            <option value="{{$entity->id}}">{{$entity->entity_name}}</option>
                                        @endforeach	
                                    </select>
								</div>
                                </div>
                                
                            </div>
                            <br/>
                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                <a href="{{ route('appointment.search.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                <form action="{{ route('button.action') }}" method="POST">
                                @csrf
                                <button type="submit" name="action" value="save" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Simpan Kakitangan ?</span>').text())">
                                    <i class="fas fa-save"></i> {{ __('app.save') }}
                                </button>
                                <button type="submit" name="action" value="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Hantar Permohonan ?</span>').text())">
                                    <i class="fas fa-paper-plane"></i> {{ __('app.submit') }}
                                </button>
                                </form><br/>
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
