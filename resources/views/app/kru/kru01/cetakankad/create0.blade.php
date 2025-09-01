@extends('layouts.app')


<style>
    .select2-container--open {
        z-index: 2000;
    } 
</style>
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
                            <h3 class="mb-0">Cetakan Kad</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-right">
                            <!-- Breadcrumb -->
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('kadpendaftarannelayan.cetakankad.index') }}">Permohonan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Cetakan Kad</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Card -->
                    <div class="card">
                        <!-- card body -->
                        <div class="card-body">
                            <h6 class="section-title" style="font-weight: bold; color: #1070d5; border-bottom: 2px solid #1070d5; padding-bottom: 5px; margin-bottom: 0%;">Cetakan Kad</h6>
                            <form id="form" method="POST" action="{{ route('kadpendaftarannelayan.cetakankad.saveSSD',$id) }}">
                                @csrf
                                <br/>
                                <div class="row">
                                    <div class="col-sm">
                                        <a id="print-ssd" class="btn btn-block btn-secondary" href="{{route('kadpendaftarannelayan.cetakankad.print',$id)}}" target="_blank">
                                            <li class="fas fa-print"></li>
                                            Cetak
                                        </a>
                                    </div>
                                </div>
                                <div class="row pt-3">
                                    <div class="col-sm">
                                        <div class="alert alert-warning alert-dismissible">
                                        <h5>
                                            <i class="icon fas fa-exclamation-triangle"></i>
                                            Perhatian!
                                        </h5>
                                        *Pastikan cetakan berjaya dahulu sebelum memasukkan no SSD
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="ssd">No. SSD Baru</label>
                                            <input type="text" name="ssd" class="form-control" id="ssd" value="{{$app->ssd_number}}" {{$app->ssd_number!=null?'disabled':''}} required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 text-lg-center mt-3">
                                        <a href="{{ route('kadpendaftarannelayan.cetakankad.show',$id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <button id="btnSubmit" type="submit" name="action" value="submit" class="btn btn-secondary btn-sm" onclick="return confirm($('<span>Simpan SSD?</span>').text())" {{$app->ssd_number!=null?'disabled':''}}>
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

@endsection

@push('scripts')
    <script src="{{ asset('template/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script type="text/javascript">
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
