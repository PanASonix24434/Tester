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
                              <li class="breadcrumb-item"><a href="{{ route('kadpendaftarannelayan.permohonan.index') }}">Permohonan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)</a></li>
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
                                        <a class="nav-link" id="application-tab" href="{{route('kadpendaftarannelayan.permohonan.edit',$id)}}"
                                        aria-controls="application" aria-selected="true">Maklumat Permohonan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="address-tab" href="{{route('kadpendaftarannelayan.permohonan.editB',$id)}}"
                                        aria-controls="address" aria-selected="false">Alamat Kru</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="contact-tab" href="{{route('kadpendaftarannelayan.permohonan.editC',$id)}}"
                                        aria-controls="contact" aria-selected="false">Maklumat Perhubungan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="document-tab" data-bs-toggle="tab" href="#document" role="tab"
                                        aria-controls="document" aria-selected="false">Maklumat Dokumen</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="acknowledgement-tab" href="{{route('kadpendaftarannelayan.permohonan.editE',$id)}}"
                                        aria-controls="acknowledgement" aria-selected="false">Perakuan</a>
                                    </li>
                                </ul>
                                <div class="tab-content p-4" id="myTabContent">
                                    <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application-tab">
                                        <div class="row">
                                            <div class="col-sm-12 table-responsive">
                                                <div class="form-group">
                                                    <label class="col-form-label">Senarai Dokumen:</label>
                                                    <a href="{{ route('kadpendaftarannelayan.permohonan.editDAddDoc',$id) }}" class="btn btn-secondary btn-sm float-right"><i class="fas fa-plus"></i> Tambah</a>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:1%;">Bil</th>
                                                            <th>Tarikh Dicipta</th>
                                                            <th>Dokumen</th>
                                                            <th>Keterangan</th>
                                                            <th>Dimasukkan Oleh</th>
                                                            <th>Tindakan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="listDoc">
                                                        @if (!$documents->isEmpty())
                                                            @php
                                                                $count = 0;
                                                            @endphp
                                                            @foreach ($documents as $doc)
                                                                <tr>
                                                                    <td>{{++$count}}</td>
                                                                    <td>{{$doc->created_at->format('d/m/Y h:i:s A')}}</td>
                                                                    <td><a href="{{ route('kadpendaftarannelayan.permohonan.downloadDoc', $doc->id) }}">{{$doc->file_name}}</a></td>
                                                                    <td>{{$doc->description}}</td>
                                                                    <td>{{strtoupper(Helper::getUsersNameById($doc->created_by))}}</td>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                    <form method="post" action="{{ route('kadpendaftarannelayan.permohonan.deleteDoc',$doc->id) }}"> 
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" href="{{ route('kadpendaftarannelayan.permohonan.deleteDoc',$doc->id) }}" onclick="return confirm($('<span>Hapus Dokumen?</span>').text())" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>
                                                                    </form>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="6" style="text-align: center;">-Tiada Dokumen-</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                                <a href="{{ route('kadpendaftarannelayan.permohonan.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
        </div>
    </div>

@endsection

@push('scripts')
    <script type="text/javascript">

        $(document).ready(function () {

            //No Telefon Bimbit - Validation
            $('#mobilePhoneNumber').keypress(function (e) {
                var charCode = (e.which) ? e.which : event.keyCode
                if (String.fromCharCode(charCode).match(/[^0-9]/g)|| $(this).val().length >= 10)
                    return false;
            });

            //No Telefon Rumah - Validation
            $('#homePhoneNumber').keypress(function (e) {
                var charCode = (e.which) ? e.which : event.keyCode
                if (String.fromCharCode(charCode).match(/[^0-9]/g)|| $(this).val().length >= 10)
                    return false;
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
