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
                        <h3 class="mb-0">Permohonan Ubahsuai Vesel</h3>
                    </div>
                </div>
                <div class="col-md-4">
                </div>
            </div>
           
            <div>
                <form method="POST" enctype="multipart/form-data" action="">
                    @csrf
                <!-- row -->
                <div class="row">
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary">
								<h4 class="mb-0" style="color:white;">Borang Permohonan Ubahsuai Vesel </h4>
                            </div>

                                <div class="card-body">
                                    <h5><strong>Ukuran Vesel<span class="text-danger">*</span></strong></h5>
                                    <div class="form-group row mb-3">
                                        <label class="col-sm-3 col-form-label">Panjang (m):</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="Autofilled" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-3">
                                        <label class="col-sm-3 col-form-label">Lebar (m):</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="Autofilled" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-3">
                                        <label class="col-sm-3 col-form-label">Dalam (m):</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="Autofilled" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label">Muatan (GRT):</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="Autofilled" readonly>
                                        </div>
                                    </div>
                                    

                                    <div class="row">
                                        <div class="col-sm-5">
                                            <div class="mb-3">
                                                <label for="">Surat Pengesahan Tukang Vesel  <span style="color:red;">*</span></label>
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

                                        <div class="col-sm-5">
                                            <div class="mb-3">
                                                <label for="">Surat Akaun <span style="color:red;">*</span></label>
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

                                    <!-- button action -->
                                    <div class="card-body">
                                        <div class="row">
                                            <br />
                                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                                <a href="{{ route('profile.veselProfile.show', $vessel->id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Simpan Permohonan Ubahsuai Vesel?</span>').text())">
                                                    <i class="fas fa-save"></i> {{ __('app.save') }}
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

        $(document).on('input', "input[type=text]", function () {
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
        });

        

        

        
        

</script>   
@endpush
