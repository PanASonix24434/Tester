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
                        <a class="nav-link" href="#" role="tab" aria-selected="false">Maklumat Nelayan Darat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" role="tab" aria-selected="false">Waktu Pendaratan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" role="tab" aria-selected="false">Maklumat Kawasan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" role="tab" aria-selected="false">Maklumat Pendaratan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#" role="tab" ria-selected="true">Perakuan</a>
                    </li>
                </ul>
                <br />
                <div>
                    <form method="POST" action="{{ route('landingdeclaration.application.updateE',$app->id) }}">
                        @csrf
                        <!-- row -->
                        <div class="row">
                            <div class="col-12">
                                <!-- card -->
                                <div class="card mb-4">
                                    <div class="card-header bg-primary">
                                        <h4 class="mb-0" style="color:white;">Perakuan Pemohon</h4>
                                    </div>
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="col-form-label">Perakuan</label>

                                                    <p class="mb-3">
                                                        Saya dengan ini mengakui dan mengesahkan bahawa semua maklumat yang diberikan oleh saya adalah benar. 
                                                        Sekiranya terdapat maklumat yang tidak benar, pihak Jabatan boleh menolak permohonan saya dan tindakan undang-undang boleh dikenakan ke atas saya.
                                                    </p>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="confirmation" id="agree" value="Setuju" >
                                                        <label class="form-check-label" for="agree">Setuju</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="confirmation" id="disagree" value="Tidak Setuju" >
                                                        <label class="form-check-label" for="disagree">Tidak Setuju</label>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <!-- button action -->
                                        <div class="card-body">
                                            <div class="row">
                                                <br />
                                                <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                                    <a href="{{ route('landingdeclaration.application.editD',$app->id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                    <button id="btnSubmit" type="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Simpan Pengisytiharan Pendaratan?</span>').text())" disabled>
                                                        <i class="fas fa-save"></i> {{ __('app.save_next') }}
                                                    </button>
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

       
        $('#agree').change(function() {
            if (this.checked) {
                $('#btnSubmit').prop("disabled",false);
                
            }else{
                $('#btnSubmit').prop("disabled",true);
            }
        });
        
        $('#disagree').change(function() {
            if (this.checked) {
                $('#btnSubmit').prop("disabled",true);
                
            }else{
                $('#btnSubmit').prop("disabled",false);
            }
        });

        

        

        
        

</script>   
@endpush
