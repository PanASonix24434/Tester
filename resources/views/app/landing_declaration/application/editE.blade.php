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
                        <a class="nav-link active" data-toggle="pill" href="#" role="tab" ria-selected="true">Maklumat Dokumen</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" role="tab" aria-selected="false">Perakuan</a>
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
                                    <h4 class="mb-0" style="color:white;">Dokumen</h4>
                                </div>
                                <div class="card-body">
                                    <form method="POST" enctype="multipart/form-data" action="{{ route('landingdeclaration.application.updateE',$app->id) }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Resit Jualan</label>
                                                    <div class="input-group">
                                                        @if ( $docSalesReceipt != null)
                                                            <a href="{{ route('landinghelper.previewDoc', $docSalesReceipt->id) }}" target="_blank">{{$docSalesReceipt->file_name}}</a>&nbsp;
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                onclick="event.preventDefault(); if (confirm('Hapus Dokumen?')) {
                                                                        document.getElementById('delete-link-form-{{ $docSalesReceipt->id }}').submit();
                                                                    }">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        @else
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="salesReceipt" name="salesReceipt" >
                                                                <label class="custom-file-label" for="salesReceipt">Pilih Fail</label>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Surat Sebab</label>
                                                    <div class="input-group">
                                                        @if ( $docReason != null)
                                                            <a href="{{ route('landinghelper.previewDoc', $docReason->id) }}" target="_blank">{{$docReason->file_name}}</a>&nbsp;
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                onclick="event.preventDefault(); if (confirm('Hapus Dokumen?')) {
                                                                        document.getElementById('delete-link-form-{{ $docReason->id }}').submit();
                                                                    }">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        @else
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="kruPic" name="kruPic" >
                                                                <label class="custom-file-label" for="kruPic">Pilih Fail</label>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                @error('kruPic')
                                                    <span id="selPosition_error" class="text-danger" role="alert">
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
                                                    <a href="{{ route('landingdeclaration.application.editD',$app->id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                    <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Simpan Dokumen?</span>').text())">
                                                        <i class="fas fa-save"></i> {{ __('app.save_next') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    @if ( $docSalesReceipt != null)
                                        <form id="delete-link-form-{{ $docSalesReceipt->id }}" 
                                            action="{{route('landinghelper.deleteDoc',$docSalesReceipt->id)}}" 
                                            method="POST" 
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif
                                    @if ( $docReason != null)
                                        <form id="delete-link-form-{{ $docReason->id }}" 
                                            action="{{route('landinghelper.deleteDoc',$docReason->id)}}" 
                                            method="POST" 
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif
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

        

        

        
        

</script>   
@endpush
