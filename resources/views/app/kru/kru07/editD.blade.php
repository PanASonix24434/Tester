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
                                <li class="breadcrumb-item"><a href="{{ route('pembaharuanpenggunaankrubukanwarganegara.permohonan.index') }}">Pembaharuan Penggunaan Kru Bukan Warganegara Untuk Bekerja Di Atas Vesel Penangkapan Ikan Tempatan</a></li>
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
                                                <a class="nav-link disabled" href="{{route('pembaharuanpenggunaankrubukanwarganegara.permohonan.edit',$id)}}">Senarai Vesel</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link disabled" href="{{route('pembaharuanpenggunaankrubukanwarganegara.permohonan.editB',$id)}}">Maklumat Am</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link disabled" href="{{route('pembaharuanpenggunaankrubukanwarganegara.permohonan.editC',$id)}}">Senarai Kru Bukan Warganegara</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active disabled" href="{{route('pembaharuanpenggunaankrubukanwarganegara.permohonan.editD',$id)}}">Maklumat Dokumen</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link disabled" href="{{route('pembaharuanpenggunaankrubukanwarganegara.permohonan.editE',$id)}}">Perakuan</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content p-4" id="myTabContent">
                                            <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application-tab">
                                                <form id="form" method="POST" enctype="multipart/form-data" action="{{ route('pembaharuanpenggunaankrubukanwarganegara.permohonan.updateD',$id) }}">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Salinan Kad Pengenalan Majikan (individu)</label>
                                                                <div class="input-group">
                                                                    @if ( $docIc != null)
                                                                        <a href="{{ route('kruhelper.previewDoc', $docIc->id) }}" target="_blank">{{$docIc->file_name}}</a>&nbsp;
                                                                        <button type="button" class="btn btn-danger btn-sm"
                                                                            onclick="event.preventDefault(); if (confirm('Hapus Dokumen?')) {
                                                                                    document.getElementById('delete-link-form-{{ $docIc->id }}').submit();
                                                                                }">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    @else
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" id="kadPengenalanDoc" name="kadPengenalanDoc">
                                                                            <label class="custom-file-label" for="exampleInputFile">Pilih Fail</label>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            @error('kadPengenalanDoc')
                                                                <span id="kadPengenalanDoc_error" class="text-danger" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Salinan Pendaftaran Syarikat (Sdn Bhd/ Enterprise/ Koperasi/ Persatuan)</label>
                                                                <div class="input-group">
                                                                    @if ( $docSsm != null)
                                                                        <a href="{{ route('kruhelper.previewDoc', $docSsm->id) }}" target="_blank">{{$docSsm->file_name}}</a>&nbsp;
                                                                        <button type="button" class="btn btn-danger btn-sm"
                                                                            onclick="event.preventDefault(); if (confirm('Hapus Dokumen?')) {
                                                                                    document.getElementById('delete-link-form-{{ $docSsm->id }}').submit();
                                                                                }">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    @else
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" id="ssmDoc" name="ssmDoc">
                                                                            <label class="custom-file-label" for="ssmDoc">Pilih Fail</label>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            @error('ssmDoc')
                                                                <span id="ssmDoc_error" class="text-danger" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Salinan Kelulusan Penggajian Pekerja Asing (Jabatan Tenaga Kerja Semenanjung Malaysia) <span style="color: red;">*</span></label>
                                                                <div class="input-group">
                                                                    @if ( $docPenggajian != null)
                                                                        <a href="{{ route('kruhelper.previewDoc', $docPenggajian->id) }}" target="_blank">{{$docPenggajian->file_name}}</a>&nbsp;
                                                                        <button type="button" class="btn btn-danger btn-sm"
                                                                            onclick="event.preventDefault(); if (confirm('Hapus Dokumen?')) {
                                                                                    document.getElementById('delete-link-form-{{ $docPenggajian->id }}').submit();
                                                                                }">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    @else
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" id="penggajianDoc" name="penggajianDoc" required>
                                                                            <label class="custom-file-label" for="penggajianDoc">Pilih Fail</label>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            @error('penggajianDoc')
                                                                <span id="penggajianDoc_error" class="text-danger" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <br\>
                                                    <div class="row">
                                                        <div class="col-lg-12 text-lg-center mt-3">
                                                            <a href="{{ route('pembaharuanpenggunaankrubukanwarganegara.permohonan.editC',$id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                            <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm($('<span>Simpan Maklumat Permohonan?</span>').text())">
                                                                <i class="fas fa-save"></i> Simpan & Seterusnya
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                                @if ( $docIc != null)
                                                    <form id="delete-link-form-{{ $docIc->id }}" 
                                                        action="{{route('kruhelper.deleteDoc',$docIc->id)}}" 
                                                        method="POST" 
                                                        style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                @endif
                                                @if ( $docSsm != null)
                                                    <form id="delete-link-form-{{ $docSsm->id }}" 
                                                        action="{{route('kruhelper.deleteDoc',$docSsm->id)}}" 
                                                        method="POST" 
                                                        style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                @endif
                                                @if ( $docPenggajian != null)
                                                    <form id="delete-link-form-{{ $docPenggajian->id }}" 
                                                        action="{{route('kruhelper.deleteDoc',$docPenggajian->id)}}" 
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
