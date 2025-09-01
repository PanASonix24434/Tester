@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('plugins/jstree/dist/themes/default/style.min.css') }}">
@endpush

@section('content')

    <!-- Page Content -->
    <div id="app-content">

        <!-- Container fluid -->
        <div class="app-content-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    <!-- Page header -->
                    <div class="mb-5">
                        <h3 class="mb-0">Tambah Data Utama</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-right">
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{ route('master-data.index', $slug) }}">Data Utama</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Tambah Data Utama</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div>
                
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                      <!-- Card -->
                      <div class="card mb-10">
                        <form id="form-master-data-add" method="POST" action="{{ route('master-data.store', $slug) }}">
                            @csrf

                        <!-- Tab content -->
                        <div class="tab-content p-4" id="pills-tabContent-javascript-behavior">
                          <div class="tab-pane tab-example-design fade show active" id="pills-javascript-behavior-design"
                            role="tabpanel" aria-labelledby="pills-javascript-behavior-design-tab">

                                <!-- Name -->
								<div class="mb-3">
									<label for="name" class="form-label">Nama Data Utama : <span style="color:red;">*</span></label>
									<input type="text" id="name" name="name" class="form-control" required="" />
								</div>

                          </div>
                        </div>

                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                            <a href="{{ route('master-data.index', $slug) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                            <!--<a href="javascript:void(0);" class="btn btn-secondary btn-sm" onclick="event.preventDefault(); document.getElementById('form-master-data-add').submit();"><i class="fas fa-save"></i> Simpan</a>-->
                            <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm($('<span>Simpan Data Utama ?</span>').text())">
                                <i class="fas fa-save"></i> Simpan
                            </button><br/>
                        </div><br/>

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
<script type="text/javascript">   

    $(document).on('input', "input[type=text]", function () {
        $(this).val(function (_, val) {
            return val.toUpperCase();
        });
    });

    $(document).ready(function(){

        //Nama Data Utama
        $('#name').keypress(function (e) { 
            var charCode = (e.which) ? e.which : event.keyCode    
            if ( String.fromCharCode(charCode).match(/[a-zA-Z ]/g) ){

            }
            else{
                return false; 
            }    
                                    
        }); 

    });

    //Display success message
    var msgSuccess = '{{Session::get('cm_success')}}';
    var existSuccess = '{{Session::has('cm_success')}}';
    if(existSuccess){
        alert(msgSuccess);
    }

    //Display failed message
    var msgFailed = '{{Session::get('cm_failed')}}';
    var existFailed = '{{Session::has('cm_failed')}}';
    if(existFailed){
        alert(msgFailed);
    }

</script>
@endpush
