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
                      <form method="POST" enctype="multipart/form-data" action="{{ route('appointment.search.store') }}" autocomplete="off">
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
                                        <label for="txtRole" class="form-label">Jawatan : <span style="color:red;">*</span></label>
                                        <br />
                                        <select id="selRole" class="form-control" name="selRole" autocomplete="off">
                                            <option value="">Pilih Jawatan</option>
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
                                            <label for="txtReportDate" class="form-label">Tarikh Pelantikan/Pertukaran : <span style="color:red;">*</span></label>
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
                                        <select id="selLevel" class="form-control" name="selLevel" autocomplete="off">
                                            <option value="">Pilih Peringkat</option>
                                            <option value="1">Ibu Pejabat (HQ)</option>
                                            <option value="2">Negeri</option>
                                            <option value="3">Wilayah</option>
                                            <option value="4">Daerah</option>

                                            {{--@foreach($level as $a)
                                                    @if ($level == $a->selLevel)
                                                    <option value="{{ $a->state_code }}|{{ $a->entity_name }}|{{ $a->id }}" selected>{{ strtoupper($a->entity_name) }}</option>
                                                    @else
                                                    <option value="{{ $a->state_code }}|{{ $a->entity_name }}|{{ $a->id }}">{{ strtoupper($a->entity_name) }}</option>
                                                    @endif
                                                    
                                            @endforeach	--}}
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                    <label class="form-label" for="selectOne">Pejabat Bertugas : <span style="color:red;">*</span></label>
									<select class="form-select select2" id="selEntity" name="selEntity" autocomplete="off" height="100%">
                                        <option value="">Pilih Pejabat</option>
                                        {{--@foreach($entities as $entity)
                                            <option value="{{$entity->entity_name}}">{{$entity->entity_name}}</option>
                                        @endforeach--}}
                                    </select>
								    </div>
                                    <br/>
                                    <div class="mb-3" id="cawanganField" style="display: none;">
                                        <label for="txtUnit" class="form-label">Cawangan : <span style="color:red;">*</span></label>
                                        <select id="selUnit" class="form-control" name="selUnit" autocomplete="off">
                                            <option value="">Pilih Cawangan</option>
                                            @foreach($depart as $a)
                                                    @if ($depart == $a->selUnit)
                                                    <option value="{{ $a->name }}" selected>{{ strtoupper($a->name) }}</option>
                                                    @else
                                                    <option value="{{ $a->name }}">{{ strtoupper($a->name) }}</option>
                                                    @endif
                                                    
                                                @endforeach	
                                        </select>
                                    </div>
                                </div>  
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="icDoc">Salinan Kad Pengenalan Kakitangan: <small>Maksimum Saiz : 5MB </small><span style="color:red;">*</span></label>
                                        <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="icDoc" name="icDoc">
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
                                            <input type="file" class="custom-file-input" id="letterDoc" name="letterDoc">
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

    $(document).on('input', "input[type=text]", function () {
        $(this).val(function (_, val) {
            return val.toUpperCase();
        });
    });

    /*$('#selLevel').on('change', function() {
        // Get the value of the selected option (which contains the multiple values separated by pipe)
        var selectedValue = $(this).val();
        
        if (selectedValue) {
            // Split the value by the pipe delimiter
            var levelData = selectedValue.split('|');
            
            // The country data will now be in an array
            var statecode = levelData[0];    
            var entityname = levelData[1]; 
            var id = levelData[2];

            // You can now use these values, for example:
            console.log("state code: " + statecode);
            console.log("entity Name: " + entityname);
            console.log("id: " + id);

            if(statecode == ''){
                $('#selEntity').empty();
                $('#selEntity').append('<option value="">Select Pejabat</option>');
            }else{
            // Clear the current pejabat dropdown options
            $('#selEntity').empty();
            $('#selEntity').append('<option  id="selEntity" name="selEntity" autocomplete="off" value="'+ entityname +'">'+ entityname +'</option>');

            }

            if(entityname == 'Jabatan Perikanan Malaysia HQ'){
                cawanganField.style.display = 'block';
            }else{
            // Clear the current cawangan dropdown options
                cawanganField.style.display = 'none';
            }
        }
    });*/

    $(document).ready(function(){
		$(document).on('change', '#selLevel', function(){
				var level = $('#selLevel option:selected').val();
				var entities = $('#selEntity');
				entities.empty();
				entities.append("<option value=''>{{ __('app.please_select')}}</option>");
				
				if(level){
					$.get("{{ url('entities') }}/"+level, function(data){
						$.each(data, function(key,value){
							entities.append("<option value='"+value.id+"'>"+value.entity_name.toUpperCase()+"</option>");
						});
					});
				}
		});
	});

    bsCustomFileInput.init();

    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
        alert(msg);
    }

</script>
@endpush
