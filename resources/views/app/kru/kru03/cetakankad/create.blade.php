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
                                    <li class="breadcrumb-item"><a href="{{ route('gantiankadpendaftarannelayan.cetakankad.index') }}">Gantian Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)</a></li>
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
                            <br>
                            <div class="row">
                                <div class="col-sm-12 table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width:1%;">Bil</th>
                                                <th>No. Kad Pengenalan</th>
                                                <th>Nama</th>
                                                <th>No. SSD Baru</th>
                                                <th>Cetak</th>
                                                <th>Hasil Cetakan</th>
                                            </tr>
                                        </thead>
                                        <tbody id="listKru">
                                            @if (!$selectedKrus->isEmpty())
                                                @php
                                                    $count = 0;
                                                @endphp
                                                @foreach ($selectedKrus as $kru)
                                                    <tr>
                                                        <td>{{++$count}}</td>
                                                    <td>
                                                        <a href="{{ route('gantiankadpendaftarannelayan.cetakankad.showKru',$kru->id) }}" target="_blank">{{$kru->ic_number}}</a>
                                                    </td>
                                                        <td>{{$kru->name}}</td>
                                                        <td>
                                                            @php
                                                                $faultySsds = App\Models\Ssd::where('application_table_name','kru_application_krus')->where('application_id',$kru->id)->where('is_faulty',true)->orderBy('updated_at','asc')->get();
                                                            @endphp
                                                            @if (!$faultySsds->isEmpty())
                                                                @foreach ( $faultySsds as $fSsd )
                                                                <div style="color: red;"><del>{{$fSsd->ssd_number}}</del></div>
                                                                @endforeach
                                                            @endif
                                                            @if ( $kru->ssd_number == null || $kru->has_sucessfully_printed === false )
                                                                <form method="GET" action="{{ route('gantiankadpendaftarannelayan.cetakankad.createSSD',$kru->id) }}">
                                                                    <!-- <input type="hidden" name="" value=""> -->
                                                                    <button type="submit" class="btn btn-secondary btn-sm" ><i class="fas fa-edit"></i> Input No. SSD</button>
                                                                </form>
                                                            @else
                                                                {{ $kru->ssd_number }}
                                                            @endif
                                                            @if ($kru->kewarganegaraan_status_id == $warganegaraId)
                                                                <div style="color: blue;">Kru adalah warganegara. Sila cetak diatas Kad Pendaftaran Biru.</div>
                                                            @elseif($kru->kewarganegaraan_status_id == $pemastautinId)
                                                                <div style="color: red;">Kru adalah warganegara. Sila cetak diatas Kad Pendaftaran MERAH.</div>
                                                            @endif
                                                        </td>
                                                        <td style="text-align: center;">
                                                            @if ( $kru->ssd_number != null && $kru->has_sucessfully_printed === null)
                                                                <a class="btn btn-secondary btn-sm" href="{{route('gantiankadpendaftarannelayan.cetakankad.print',$kru->id)}}" target="_blank"><i class="fas fa-print"></i> Cetak</a>
                                                            @else
                                                                <!-- <button class="btn btn-secondary btn-sm" disabled><i class="fas fa-print"></i> Cetak</button> -->
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ( $kru->ssd_number != null && $kru->has_sucessfully_printed === null)
                                                                <form method="POST" action="{{ route('gantiankadpendaftarannelayan.cetakankad.updatePrinted',$kru->id) }}">
                                                                    @csrf
                                                                    <button type="submit" name="printCondition" value="good" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Cetakan Sempurna</button>
                                                                    <button type="submit" name="printCondition" value="broken" class="btn btn-danger btn-sm"><i class="fas fa-times"></i> Cetakan Rosak</button>
                                                                </form>
                                                            @elseif ($kru->has_sucessfully_printed === false)
                                                                Cetakan Rosak
                                                            @elseif ($kru->has_sucessfully_printed === true)
                                                                Cetakan Sempurna
                                                            @else
                                                                <!-- <button class="btn btn-primary btn-sm" disabled><i class="fas fa-check"></i> Cetakan Sempurna</button>
                                                                <button class="btn btn-danger btn-sm" disabled><i class="fas fa-times"></i> Cetakan Rosak</button> -->
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="6" style="text-align: center;">-Tiada Kru-</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-lg-center mt-3">
                                    <form method="POST" action="{{ route('gantiankadpendaftarannelayan.cetakankad.updateCompleted',$id) }}">
                                        @csrf
                                        <a href="{{ route('gantiankadpendaftarannelayan.cetakankad.show',$id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        @if ($allHasPrintedSucessfully)
                                            <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Permohonan Selesai Dicetak?</span>').text())"><i class="fas fa-paper-plane"></i> Selesai Permohonan</button>
                                        @endif
                                    </form>
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
