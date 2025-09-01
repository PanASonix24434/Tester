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
                                <li class="breadcrumb-item"><a href="{{ route('gantiankadpendaftarannelayan.permohonan.index') }}">Gantian Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)</a></li>
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
                                                <a class="nav-link disabled" id="application-tab" href="{{route('gantiankadpendaftarannelayan.permohonan.edit',$id)}}"
                                                aria-controls="application" aria-selected="true">Maklumat Permohonan</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link disabled" id="address-tab" href="{{route('gantiankadpendaftarannelayan.permohonan.editB',$id)}}"
                                                aria-controls="address" aria-selected="false">Alamat Kru</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link disabled" id="contact-tab" href="{{route('gantiankadpendaftarannelayan.permohonan.editC',$id)}}" 
                                                aria-controls="contact" aria-selected="false">Maklumat Perhubungan</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link disabled active" id="document-tab"
                                                aria-controls="document" aria-selected="false">Maklumat Dokumen</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link disabled" id="acknowledgement-tab" href="{{route('gantiankadpendaftarannelayan.permohonan.editE',$id)}}"
                                                aria-controls="acknowledgement" aria-selected="false">Perakuan</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content p-4" id="myTabContent">
                                            <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application-tab">
                                                <form id="form" method="POST" enctype="multipart/form-data" action="{{ route('gantiankadpendaftarannelayan.permohonan.updateD',$selectedKru->id) }}">
                                                    @csrf
                                                    <div class="row">
                                                        @if ($app->application_type === 'KAD HILANG')
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Laporan Polis <span style="color: red;">*</span></label>
                                                                    <div class="input-group">
                                                                        @if ( $policeReportDoc != null)
                                                                            <a href="{{ route('kruhelper.previewKruDoc', $policeReportDoc->id) }}" target="_blank">{{$policeReportDoc->file_name}}</a>&nbsp;
                                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                                onclick="event.preventDefault(); if (confirm('Hapus Dokumen?')) {
                                                                                        document.getElementById('delete-link-form-{{ $policeReportDoc->id }}').submit();
                                                                                    }">
                                                                                <i class="fas fa-trash"></i>
                                                                            </button>
                                                                        @else
                                                                            <div class="custom-file">
                                                                                <input type="file" class="custom-file-input" id="policeReportDoc" name="policeReportDoc" required>
                                                                                <label class="custom-file-label" for="policeReportDoc">Pilih Fail</label>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @elseif ($app->application_type === 'KAD ROSAK')
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Gambar Kad Pendaftaran Nelayan <span style="color: red;">*</span></label>
                                                                    <div class="input-group">
                                                                        @if ( $kpnDoc != null)
                                                                            <a href="{{ route('kruhelper.previewKruDoc', $kpnDoc->id) }}" target="_blank">{{$kpnDoc->file_name}}</a>&nbsp;
                                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                                onclick="event.preventDefault(); if (confirm('Hapus Dokumen?')) {
                                                                                        document.getElementById('delete-link-form-{{ $kpnDoc->id }}').submit();
                                                                                    }">
                                                                                <i class="fas fa-trash"></i>
                                                                            </button>
                                                                        @else
                                                                            <div class="custom-file">
                                                                                <input type="file" class="custom-file-input" id="kpnDoc" name="kpnDoc" required>
                                                                                <label class="custom-file-label" for="kpnDoc">Pilih Fail</label>
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
                                                        @endif
                                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                                            <a href="{{ route('gantiankadpendaftarannelayan.permohonan.editC',$id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                            <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm($('<span>Simpan Dokumen?</span>').text())">
                                                                <i class="fas fa-save"></i> Simpan & Seterusnya
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                                @if ( $policeReportDoc != null)
                                                    <form id="delete-link-form-{{ $policeReportDoc->id }}" 
                                                        action="{{route('kruhelper.deleteKruDoc',$policeReportDoc->id)}}" 
                                                        method="POST" 
                                                        style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                @endif
                                                @if ( $kpnDoc != null)
                                                    <form id="delete-link-form-{{ $kpnDoc->id }}" 
                                                        action="{{route('kruhelper.deleteKruDoc',$kpnDoc->id)}}" 
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

        //Peranan tidak dipilih
        var msg2 = '{{Session::get('alert2')}}';
        var exist2 = '{{Session::has('alert2')}}';
        if(exist2){
            alert(msg2);
        }

    </script>
@endpush
