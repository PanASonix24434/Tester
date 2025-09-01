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
                        <h3 class="mb-0">Permohonan</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-right">
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{ route('pembaharuankadpendaftarannelayan.permohonan.index') }}">Pembaharuan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Permohonan</li>
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
                        <!-- Tab content -->
                        <div class="tab-content p-4" id="pills-tabContent-javascript-behavior">
                            <div class="tab-pane tab-example-design fade show active" id="pills-javascript-behavior-design"
                                role="tabpanel" aria-labelledby="pills-javascript-behavior-design-tab">
                                <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link disabled" id="address-tab" href="{{route('pembaharuankadpendaftarannelayan.permohonan.editB',$appKru->id)}}"
                                        aria-controls="address" aria-selected="false">Alamat Kru</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link disabled" id="contact-tab" href="{{route('pembaharuankadpendaftarannelayan.permohonan.editC',$appKru->id)}}"
                                        aria-controls="contact" aria-selected="false">Maklumat Perhubungan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link disabled" id="health-tab" href="{{route('pembaharuankadpendaftarannelayan.permohonan.editD',$appKru->id)}}"
                                        aria-controls="health" aria-selected="false">Maklumat Kesihatan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="document-tab" data-bs-toggle="tab" href="#document" role="tab"
                                        aria-controls="document" aria-selected="true">Maklumat Dokumen</a>
                                    </li>
                                </ul>
                                <div class="tab-content p-4" id="myTabContent">
                                    <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application-tab">
                                        <form id="form" method="POST" enctype="multipart/form-data" action="{{ route('pembaharuankadpendaftarannelayan.permohonan.updateE',$appKru->id) }}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Salinan Kad Pengenalan <span style="color: red;">*</span></label>
                                                        <div class="input-group">
                                                            @if ( $icDoc != null)
                                                                <a href="{{ route('kruhelper.previewKruDoc', $icDoc->id) }}" target="_blank">{{$icDoc->file_name}}</a>&nbsp;
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                    onclick="event.preventDefault(); if (confirm('Hapus Dokumen?')) {
                                                                            document.getElementById('delete-link-form-{{ $icDoc->id }}').submit();
                                                                        }">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            @else
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="kadPengenalanDoc" name="kadPengenalanDoc">
                                                                    <label class="custom-file-label" for="kadPengenalanDoc">Pilih Fail</label>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Gambar Ukuran Pasport <span style="color: red;">*</span></label>
                                                        <div class="input-group">
                                                            @if ( $picDoc != null)
                                                                <a href="{{ route('kruhelper.previewKruDoc', $picDoc->id) }}" target="_blank">{{$picDoc->file_name}}</a>&nbsp;
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                    onclick="event.preventDefault(); if (confirm('Hapus Dokumen?')) {
                                                                            document.getElementById('delete-link-form-{{ $picDoc->id }}').submit();
                                                                        }">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            @else
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="kruPic" name="kruPic">
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
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">Dokumen Tambahan : <small>Maksimum Saiz : 5MB </small></label>
                                                        <div class="input-group">
                                                            @if ( $extraDoc != null)
                                                                <a href="{{ route('kruhelper.previewKruDoc', $extraDoc->id) }}" target="_blank">{{$extraDoc->file_name}}</a>&nbsp;
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                    onclick="event.preventDefault(); if (confirm('Hapus Dokumen?')) {
                                                                            document.getElementById('delete-link-form-{{ $extraDoc->id }}').submit();
                                                                        }">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            @else
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="extraDoc" name="extraDoc">
                                                                    <label class="custom-file-label" for="extraDoc">Pilih Fail</label>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        @if ( $extraDoc != null)
                                                            <label for="description">Keterangan bagi Dokumen Tambahan</label>
                                                            <input type="text" name="description" class="form-control" id="description" value="{{$extraDoc->description}}" disabled>
                                                        @else
                                                            <label for="description">Keterangan bagi Dokumen Tambahan</label>
                                                            <input type="text" name="description" class="form-control" id="description">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                                    <a href="{{ route('pembaharuankadpendaftarannelayan.permohonan.editD',$appKru->id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                    <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm($('<span>Simpan Dokumen?</span>').text())">
                                                        <i class="fas fa-save"></i> Simpan & Seterusnya
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        
                                        @if ( $icDoc != null)
                                            <form id="delete-link-form-{{ $icDoc->id }}" 
                                                action="{{route('kruhelper.deleteKruDoc',$icDoc->id)}}" 
                                                method="POST" 
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endif
                                        @if ( $picDoc != null)
                                            <form id="delete-link-form-{{ $picDoc->id }}" 
                                                action="{{route('kruhelper.deleteKruDoc',$picDoc->id)}}" 
                                                method="POST" 
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endif
                                        @if ( $extraDoc != null)
                                            <form id="delete-link-form-{{ $extraDoc->id }}" 
                                                action="{{route('kruhelper.deleteKruDoc',$extraDoc->id)}}" 
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
        </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script type="text/javascript">

        bsCustomFileInput.init();  
        $(document).ready(function () {
        });

        var msg = '{{Session::get('alert')}}';
        var exist = '{{Session::has('alert')}}';
        if(exist){
            alert(msg);
        }

    </script>
@endpush
