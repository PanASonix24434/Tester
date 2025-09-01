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
                        <h3 class="mb-0">Permohonan Elaun Sara Hidup Nelayan Darat</h3>
                    </div>
                </div>
                <div class="col-md-4">
                </div>
            </div>
            <ul class="nav nav-tabs" id="custom-content-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link disabled" id="custom-content-form-tab" data-toggle="pill" href="#custom-content-form" role="tab" aria-controls="custom-content-form" aria-selected="false">Butiran Pemohon</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" id="custom-content-work-tab" href="#" role="tab" aria-controls="custom-content-work" aria-selected="false">Butiran Pekerjaan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" id="custom-content-depandents-tab" href="#" role="tab" aria-controls="custom-content-dependents" aria-selected="false">Butiran Tanggungan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" id="custom-content-education-tab" href="#" role="tab" aria-controls="custom-content-education" aria-selected="true">Tahap Pendidikan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" id="custom-content-education-tab" href="#" role="tab" aria-controls="custom-content-document" aria-selected="false">Dokumen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" id="custom-content-declaration-tab" href="#" role="tab" aria-controls="custom-content-declaration" aria-selected="false">Perakuan</a>
                </li>
            </ul>
            <br />
            <div>
                <form method="POST" enctype="multipart/form-data" action="{{ route('subsistence-allowance.application.storeDoc') }}">
                    @csrf
                    <!-- row -->
                    <div class="row">
                        <input type="hidden" id="application_id" name="application_id" value="{{ $subApplication->id }}">
                        <div class="col-12">
                            <!-- card -->
                            <div class="card mb-4">
                                <div class="card-header bg-primary">
                                    <h4 class="mb-0" style="color:white;">Dokumen</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="">Keputusan Saringan Air Kencing AADK/Hospital/Klinik Kesihatan KKM  <small>Maksimum Saiz : 5MB </small><span style="color:red;">*</span></label>
                                                <div class="input-group">
                                                    @if ( $documentADK != null )
                                                        <a href="{{ route('subsistence-allowance.downloadDoc', $documentADK->id) }}" target="_blank">
                                                            {{ $documentADK->title }}
                                                        </a>
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="event.preventDefault(); if (confirm('Hapus Dokumen?')) {
                                                                    document.getElementById('delete-link-form-{{ $documentADK->id }}').submit();
                                                                }">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @else
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="fileAADK" name="fileAADK" required>
                                                            <label class="custom-file-label" for="fileAADK">Pilih Fail</label>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            @error('fileAADK')
                                                <span id="fileAADK_error" class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="">Dokumen KWSP Berkenaan Caruman Bermajikan  <small>Maksimum Saiz : 5MB </small><span style="color:red;">*</span></label>
                                                <div class="input-group">
                                                    @if ($documentKWSP != null)
                                                        <a href="{{ route('subsistence-allowance.downloadDoc', $documentKWSP->id) }}" target="_blank">
                                                            {{ $documentKWSP->title }}
                                                        </a>
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="event.preventDefault(); if (confirm('Hapus Dokumen?')) {
                                                                    document.getElementById('delete-link-form-{{ $documentKWSP->id }}').submit();
                                                                }">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @else
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="fileResult" name="fileResult" required>
                                                            <label class="custom-file-label" for="fileResult">Pilih Fail</label>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            @error('fileResult')
                                                <span id="fileResult_error" class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="">Akuan Sumpah <small>Maksimum Saiz : 5MB </small><span style="color:red;">*</span> <a href="{{ route('subsistence-allowance.downloadDocApp', $subApplication->id) }}" target="_blank"><i class="fas fa-download"></i>Borang Permohonan</a></label>
                                                <div class="input-group">
                                                    @if ($documentAkuan!=null)
                                                        <a href="{{ route('subsistence-allowance.downloadDoc', $documentAkuan->id) }}" target="_blank">
                                                            {{ $documentAkuan->title }}
                                                        </a>
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="event.preventDefault(); if (confirm('Hapus Dokumen?')) {
                                                                    document.getElementById('delete-link-form-{{ $documentAkuan->id }}').submit();
                                                                }">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @else
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="fileAkuan" name="fileAkuan" required>
                                                            <label class="custom-file-label" for="fileAkuan">Pilih Fail</label>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            @error('fileAkuan')
                                                <span id="fileAkuan_error" class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                            <a href="{{ route('subsistence-allowance.application.formeducation' ,  $subApplication->id) }}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                            <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Simpan Permohonan ?</span>').text())">
                                                <i class="fas fa-save"></i> {{ __('app.save_next') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                @if ( $documentADK != null)
                    <form id="delete-link-form-{{ $documentADK->id }}" 
                        action="{{route('subsistenceallowancehelper.deleteDoc',$documentADK->id)}}" 
                        method="POST" 
                        style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                @endif
                @if ( $documentKWSP != null)
                    <form id="delete-link-form-{{ $documentKWSP->id }}" 
                        action="{{route('subsistenceallowancehelper.deleteDoc',$documentKWSP->id)}}" 
                        method="POST" 
                        style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                @endif
                @if ( $documentAkuan != null)
                    <form id="delete-link-form-{{ $documentAkuan->id }}" 
                        action="{{route('subsistenceallowancehelper.deleteDoc',$documentAkuan->id)}}" 
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

@endsection

@push('scripts')
<script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script type="text/javascript">
    bsCustomFileInput.init();
</script>
@endpush
