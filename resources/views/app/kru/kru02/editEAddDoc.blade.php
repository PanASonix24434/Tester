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
                                                <a class="nav-link" id="application-tab" href="{{route('pembaharuankadpendaftarannelayan.permohonan.edit',$id)}}"
                                                aria-controls="application" aria-selected="true">Maklumat Permohonan</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="address-tab" href="{{route('pembaharuankadpendaftarannelayan.permohonan.editB',$id)}}"
                                                aria-controls="address" aria-selected="false">Alamat Kru</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="contact-tab" href="{{route('pembaharuankadpendaftarannelayan.permohonan.editC',$id)}}"
                                                aria-controls="contact" aria-selected="false">Maklumat Perhubungan</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="health-tab" href="{{route('pembaharuankadpendaftarannelayan.permohonan.editD',$id)}}"
                                                aria-controls="health" aria-selected="false">Maklumat Kesihatan</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active" id="document-tab" data-bs-toggle="tab" href="#document" role="tab"
                                                aria-controls="document" aria-selected="false">Maklumat Dokumen</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="acknowledgement-tab" href="{{route('pembaharuankadpendaftarannelayan.permohonan.editF',$id)}}"
                                                aria-controls="acknowledgement" aria-selected="false">Perakuan</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content p-4" id="myTabContent">
                                            <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application-tab">
                                                <form id="form" method="POST" enctype="multipart/form-data" action="{{ route('pembaharuankadpendaftarannelayan.permohonan.updateEAddDoc',$id) }}">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Salinan Kad Pengenalan <span style="color: red;">*</span></label>
                                                                <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="kadPengenalanDoc" name="kadPengenalanDoc">
                                                                    <label class="custom-file-label" for="exampleInputFile">Pilih Fail</label>
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Gambar Ukuran Pasport <span style="color: red;">*</span></label>
                                                                <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="kruPic" name="kruPic" >
                                                                    <label class="custom-file-label" for="kruPic">Pilih Fail</label>
                                                                </div>
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
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="extraDoc" name="extraDoc">
                                                                        <label class="custom-file-label" for="extraDoc">Pilih Fail</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="description">Keterangan bagi Dokumen Tambahan</label>
                                                                <input type="text" name="description" class="form-control" id="description">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                                            <a href="{{ route('pembaharuankadpendaftarannelayan.permohonan.editE',$id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                            <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm($('<span>Simpan Dokumen?</span>').text())">
                                                                <i class="fas fa-save"></i> Simpan
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
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

        //Peranan tidak dipilih
        var msg2 = '{{Session::get('alert2')}}';
        var exist2 = '{{Session::has('alert2')}}';
        if(exist2){
            alert(msg2);
        }

    </script>
@endpush
