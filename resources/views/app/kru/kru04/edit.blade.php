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
                                <li class="breadcrumb-item"><a href="{{ route('pembatalankadpendaftarannelayan.permohonan.index') }}">Pembatalan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)</a></li>
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
                                                <a class="nav-link active" id="application-tab" data-bs-toggle="tab" href="#application" role="tab"
                                                aria-controls="application" aria-selected="true">Maklumat Permohonan</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="acknowledgement-tab" href="{{route('pembatalankadpendaftarannelayan.permohonan.editF',$id)}}"
                                                aria-controls="acknowledgement" aria-selected="false">Perakuan</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content p-4" id="myTabContent">
                                            <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application-tab">
                                                <form id="form" method="POST" action="{{ route('pembatalankadpendaftarannelayan.permohonan.update',$id) }}">
                                                    @csrf
                                                    <div class="row">
                                                        <!-- Vessel -->
                                                        <div class="col-6">
                                                            <div class="mb-3">
                                                                <label for="vessel" class="form-label">Vesel : </label>
                                                                <input type="text" class="form-control" value="{{$vessel->no_pendaftaran}}" disabled/>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-12 table-responsive">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width:1%;">Bil</th>
                                                                            <th>No. Kad Pengenalan</th>
                                                                            <th>Nama</th>
                                                                            <th>Tarikh Tamat</th>
                                                                            <th>Pilih Untuk Pembatalan</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="listKru">
                                                                        @if (!$krus->isEmpty())
                                                                            @php
                                                                                $count = 0;
                                                                            @endphp
                                                                            @foreach ($krus as $kru)
                                                                                <tr>
                                                                                    <td>{{++$count}}</td>
                                                                                    <td>{{$kru->ic_number}}</td>
                                                                                    <td>{{$kru->name}}</td>
                                                                                    <td>{{$kru->registration_end}}</td>
                                                                                    <td style="text-align: center;">
                                                                                        <div class="custom-control custom-checkbox">
                                                                                            <input type="checkbox" name="selKrus[]" class="custom-control-input" id="{{'kru'.$count}}" value="{{$kru->id}}" {{$selectedKrus->contains('ic_number', $kru->ic_number) ? 'checked' : '' }} >
                                                                                            <label class="custom-control-label" for="{{'kru'.$count}}"></label>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        @else
                                                                            <tr>
                                                                                <td colspan="5" style="text-align: center;">-Tiada Kru-</td>
                                                                            </tr>
                                                                        @endif
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                                            <a href="{{ route('pembatalankadpendaftarannelayan.permohonan.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                            <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm($('<span>Simpan Maklumat Permohonan?</span>').text())">
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
