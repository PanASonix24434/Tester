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
                            <h3 class="mb-0">Pengisytiharan Pendaratan Perikanan Darat</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                    </div>
                </div>
                <ul class="nav nav-tabs" id="custom-content-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-content-a-tab" data-toggle="pill" href="#custom-content-a" role="tab" aria-controls="custom-content-a" aria-selected="true">Maklumat Nelayan Darat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-content-b-tab" href="#" role="tab" aria-controls="custom-content-b" aria-selected="false">Waktu Pendaratan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" id="custom-content-c-tab" href="#" role="tab" aria-controls="custom-content-c" aria-selected="false">Maklumat Kawasan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" id="custom-content-d-tab" href="#" role="tab" aria-controls="custom-content-d" aria-selected="false">Maklumat Pendaratan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" id="custom-content-e-tab" href="#" role="tab" aria-controls="custom-content-e" aria-selected="false">Perakuan</a>
                    </li>
                </ul>
                <br />
                <div>
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
                                        <div class="col-sm-6">
                                            <!-- Nama Pemohon -->
                                            <div class="form-group">
                                                <label class="col-form-label">1. Nama Pemohon :</label>
                                                <input type="text" class="form-control" id="AppName"  name="fullname" value="{{ $app->name }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <!-- No Kad Pengenalan -->
                                            <div class="form-group">
                                                <label class="col-form-label">2. No Kad Pengenalan :</label>
                                                <input type="text" class="form-control" id="AppIC" name="icno" value="{{ $app->username }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <!-- Alamat Surat Menyurat -->
                                            <div class="form-group">
                                                <label class="col-form-label">3. Alamat :</label>
                                                <input type="text" class="form-control" id="AppAddress1" value="Auto" readonly>
                                                <input type="text" class="form-control" id="AppAddress2" value="Auto" readonly>
                                                <input type="text" class="form-control" id="AppAddress3" value="Auto" readonly>
                                            </div>
                                        </div>
                                    </div>
                                        <!-- button action -->
                                    <div class="card-body">
                                        <div class="row">
                                            <br />
                                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                                <a href="{{ route('landingdeclaration.application.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                <a href="{{ route('landingdeclaration.application.editB',$app->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-arrow-right"></i> Seterusnya</a>
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
