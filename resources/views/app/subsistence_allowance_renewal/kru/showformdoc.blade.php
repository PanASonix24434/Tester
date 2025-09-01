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
                        <h3 class="mb-0">Permohonan Pembaharuan ESH Nelayan</h3>
                    </div>
                </div>
                <div class="col-md-4">
                </div>
            </div>
            <ul class="nav nav-tabs" id="custom-content-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link" id="custom-content-form-tab" data-toggle="pill" href="#custom-content-form" role="tab" aria-controls="custom-content-form" aria-selected="false">Butiran Pemohon</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-content-work-tab" href="#" role="tab" aria-controls="custom-content-work" aria-selected="false">Butiran Pekerjaan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-content-depandents-tab" href="#" role="tab" aria-controls="custom-content-dependents" aria-selected="false">Butiran Tanggungan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-content-education-tab" href="#" role="tab" aria-controls="custom-content-education" aria-selected="true">Tahap Pendidikan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" id="custom-content-doc-tab" href="#" role="tab" aria-controls="custom-content-doc" aria-selected="false">Dokumen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-content-declaration-tab" href="#" role="tab" aria-controls="custom-content-declaration" aria-selected="false">Perakuan</a>
                </li>
            </ul>
            <br />
            <div>
                <form method="POST" enctype="multipart/form-data" action="{{ route('subsistence-allowance-renewal.storeDoc') }}">
                    @csrf
                <!-- row -->
                <div class="row">
                <input type="hidden" id="application_id" name="application_id" value="{{ $subApplication->id }}">
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary">
								<h4 class="mb-0" style="color:white;">E. Dokumen Yang Pemohon Perlu Muatnaik</h4>
                            </div>

                                <div class="card-body">

                                <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="">Keputusan AADK  <span style="color:red;">*</span></label>
                                                <!-- <div class="input-group">
                                                    <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="fileAADK" name="fileAADK" >
                                                    <label class="custom-file-label" for="fileAADK">Pilih Fail</label>
                                                    </div>
                                                </div> -->
                                            </div>
                                            @if (!empty($documentADK->file_detail))
                                                <div class="mt-2">
                                                   <a href="{{ route('subsistence-allowance.downloadDoc', $documentADK->id) }}" target="_blank">
                                                        Lihat Dokumen
                                                    </a>
                                                </div>
                                            @endif
                                            @error('fileAADK')
                                                <span id="fileAADK_error" class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="">Keputusan Surat KWSP berkenaan pengesahan tiada akaun  <span style="color:red;">*</span></label>
                                                <!-- <div class="input-group">
                                                    <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="fileResult" name="fileResult">
                                                    <label class="custom-file-label" for="fileResult">Pilih Fail</label>
                                                    </div>
                                                </div> -->
                                            </div>
                                            <!-- Show existing file with download option -->
                                            @if (!empty($documentKWSP->file_detail))
                                                <div class="mt-2">
                                                   <a href="{{ route('subsistence-allowance.downloadDoc', $documentKWSP->id) }}" target="_blank">
                                                        Lihat Dokumen
                                                    </a>
                                                </div>
                                            @endif
                                            @error('fileResult')
                                                <span id="fileResult_error" class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="">Surat Sokongan JKKK/JPKK/JPKKP/MPKK/JKOA dan seangkatan  <span style="color:red;">*</span></label>
                                                <!-- <div class="input-group">
                                                    <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="fileSupport" name="fileSupport">
                                                    <label class="custom-file-label" for="fileSupport">Pilih Fail</label>
                                                    </div>
                                                </div> -->
                                            </div>
                                            <!-- Show existing file with download option -->
                                            @if (!empty($documentSupport->file_detail))
                                                <div class="mt-2">
                                                   <a href="{{ route('subsistence-allowance.downloadDoc', $documentSupport->id) }}" target="_blank">
                                                        Lihat Dokumen
                                                    </a>
                                                </div>
                                            @endif
                                            @error('fileSupport')
                                                <span id="fileSupport_error" class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="">Salinan Penyata Bank <span style="color:red;">*</span></label>
                                                <!-- <div class="input-group">
                                                    <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="fileBank" name="fileBank">
                                                    <label class="custom-file-label" for="fileBank">Pilih Fail</label>
                                                    </div>
                                                </div> -->
                                            </div>
                                            <!-- Show existing file with download option -->
                                            @if (!empty($documentBank->file_detail))
                                                <div class="mt-2">
                                                   <a href="{{ route('subsistence-allowance.downloadDoc', $documentBank->id) }}" target="_blank">
                                                        Lihat Dokumen
                                                    </a>
                                                </div>
                                            @endif
                                            @error('fileBank')
                                                <span id="fileBank_error" class="text-danger" role="alert">
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
                                                <a href="{{ route('subsistence-allowance-renewal.showformeducation' ,  $subApplication->id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                <!-- <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Simpan Permohonan ?</span>').text())">
                                                    <i class="fas fa-save"></i> {{ __('app.save') }}
                                                </button> -->
                                                <a href="{{ route('subsistence-allowance-renewal.showformdeclaration' ,  $subApplication->id) }}" class="btn btn-dark btn-sm"> <i class="fas fa-arrow-right"></i> {{ __('app.next') }}</a>
                                               
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
