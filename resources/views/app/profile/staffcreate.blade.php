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
            <div class="row">
                <div class="col-md-9">
                    <!-- Page header -->
                    <div class="mb-5">
                        <h3 class="mb-0">Tambah Kakitangan</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-right">
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{ route('profile.stafflist') }}">Kakitangan</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Tambah Kakitangan</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div>
                
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                      <!-- Card -->
                      <div class="card mb-10 row">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('profile.staffstore') }}">
                            @csrf
                            <input type="hidden" id="hide_aid2" name="hide_aid2" value="{{ Helper::uuid() }}">

                            <div class="card-body row">
                                <div class="col-lg-6">

                                    <!-- Tajuk Pekeliling -->
                                    <div class="mb-3">
                                        <label for="txtName" class="form-label">Nama : <span style="color:red;">*</span></label>
                                        <input type="text" id="txtName" name="txtName" class="form-control" required />
                                    </div>
                                    @error('txtName')
                                        <span id="txtName_error" class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    <div class="mb-3">
                                        <label for="txtEmail" class="form-label">Emel : <span style="color:red;">*</span></label>
                                        <input type="email" id="txtEmail" name="txtEmail" class="form-control" required />
                                    </div>
                                    
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="txtICNO" class="form-label">No. Kad Pengenalan : <span style="color:red;">*</span></label>
                                        <input type="text" id="txtICNO" name="txtICNO" class="form-control" required />
                                    </div>
                                </div>
    
                                
                            </div>
                            <br/>
                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                <a href="{{ route('profile.stafflist') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Simpan Kakitangan ?</span>').text())">
                                    <i class="fas fa-save"></i> {{ __('app.save') }}
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
