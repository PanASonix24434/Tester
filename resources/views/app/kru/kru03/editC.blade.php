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
                                                <a class="nav-link disabled active" id="contact-tab"
                                                aria-controls="contact" aria-selected="false">Maklumat Perhubungan</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link disabled" id="document-tab" href="{{route('gantiankadpendaftarannelayan.permohonan.editD',$id)}}" 
                                                aria-controls="document" aria-selected="false">Maklumat Dokumen</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link disabled" id="acknowledgement-tab" href="{{route('gantiankadpendaftarannelayan.permohonan.editE',$id)}}"
                                                aria-controls="acknowledgement" aria-selected="false">Perakuan</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content p-4" id="myTabContent">
                                            <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application-tab">
                                                <form id="form" method="POST" action="{{ route('gantiankadpendaftarannelayan.permohonan.updateC',$appKru->id) }}">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <!-- Mobile Phone No -->
                                                            <div class="mb-3">
                                                                <label for="mobilePhoneNumber" class="form-label">Nombor Telefon Bimbit : <span style="color:red;">*</span></label>
                                                                <div class="input-group has-validation">
                                                                    <span class="input-group-text" id="inputGroupPrepend">+60</span>
                                                                    <input type="number" class="form-control" id="mobilePhoneNumber" name="mobilePhoneNumber" value="{{$appKru->mobile_contact_number}}"
                                                                    aria-describedby="inputGroupPrepend" required>
                                                                </div>
                                                            </div>
                                                            <!-- Email -->
                                                            <div class="mb-3">
                                                                <label for="email" class="form-label">Emel : <span style="color:red;">*</span></label>
                                                                <input type="email" id="email" name="email" class="form-control" required value="{{$appKru->email}}"/>
                                                            </div>
                                                            @error('email')
                                                                <span id="email_error" class="text-danger" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-6">
                                                            <!-- Mobile Phone No -->
                                                            <div class="mb-3">
                                                                <label for="homePhoneNumber" class="form-label">Nombor Telefon Rumah : </label>
                                                                <div class="input-group has-validation">
                                                                    <span class="input-group-text" id="inputGroupPrepend">+60</span>
                                                                    <input type="number" class="form-control" id="homePhoneNumber" name="homePhoneNumber" value="{{$appKru->home_contact_number}}"
                                                                    aria-describedby="inputGroupPrepend">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                                            <a href="{{ route('gantiankadpendaftarannelayan.permohonan.editB',$id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                            <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm($('<span>Simpan Maklumat Perhubungan?</span>').text())">
                                                                <i class="fas fa-save"></i> Simpan & Seterusnya
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
