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
                                                <a class="nav-link disabled" href="{{route('pembaharuanpenggunaankrubukanwarganegara.permohonan.editD',$id)}}">Maklumat Dokumen</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active disabled" href="{{route('pembaharuanpenggunaankrubukanwarganegara.permohonan.editE',$id)}}">Perakuan</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content p-4" id="myTabContent">
                                            <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application-tab">
                                                <form id="form" method="POST" action="{{ route('pembaharuanpenggunaankrubukanwarganegara.permohonan.updateE',$id) }}">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-12 text-center">
                                                            <div class="form-group mb-0">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" name="terms" class="custom-control-input" id="terms" required>
                                                                    <label class="custom-control-label" for="terms">Saya dengan ini mengakui dan mengesahkan bahawa semua maklumat yang diberikan oleh saya adalah benar. Sekiranya terdapat maklumat yang tidak benar, pihak Jabatan boleh menolak permohonan saya dan tindakan undang-undang boleh dikenakan ke atas saya.</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br\>
                                                    @if ($app->kru_application_status_id == $statusIncompleteId)
                                                        <div class="form-group">
                                                            <label for="remark">Ulasan Tambahan</label>
                                                            <textarea id="remark" name="remark" class="form-control" rows="4"></textarea>
                                                        </div>
                                                        <br\>
                                                    @endif
                                                    <div class="row">
                                                        <div class="col-lg-12 text-lg-center mt-3">
                                                            <a href="{{ route('pembaharuanpenggunaankrubukanwarganegara.permohonan.editD',$id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                            <button id="btnSubmit" type="submit" disabled class="btn btn-sm" style="background-color: #28a745; color: #fff; border: none; border-radius: 8px; padding: 8px 16px; font-weight: bold; box-shadow: 0 2px 8px rgba(40,167,69,0.3);" onclick="return confirm($('<span>Hantar Permohonan?</span>').text())">
                                                                <i class="fas fa-paper-plane" style="color: #fff;"></i> Hantar
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
    <script type="text/javascript">

        $(document).ready(function () {

            $('#terms').change(function() {
                if (this.checked) {
                    $('#btnSubmit').prop("disabled",false);
                    
                }else{
                    $('#btnSubmit').prop("disabled",true);
                }
            });

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
