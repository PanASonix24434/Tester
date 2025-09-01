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
                <div class="col-md-7">
                </div>
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header mb-0 bg-primary">
                            <span style="color: white;"><b>Dokumen Diperlukan</b></span>
                        </div>
                        <div class="card-body">
                            <div>1) Gambar Ukuran Passport</div>
                            <div>2) Salinan Kad Pengenalan</div>
                            <div>3) Penyata KWSP</div>
                                <div>4) <a href="{{ route('kruhelper.downloadPKN') }}" download><i class="fas fa-download"></i> Pemeriksaan Kesihatan Nelayan (PKN.01.2024)</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div>

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                      <!-- Card -->
                      <div class="card mb-10">
                        <form id="form" method="POST" action="{{ route('kadpendaftarannelayan.permohonan.store') }}">
                            @csrf
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
                                            <a class="nav-link disabled" id="address-tab" data-bs-toggle="tab" href="#address" role="tab"
                                            aria-controls="address" aria-selected="false">Alamat Kru</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link disabled" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab"
                                            aria-controls="contact" aria-selected="false">Maklumat Perhubungan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link disabled" id="document-tab" data-bs-toggle="tab" href="#document" role="tab"
                                            aria-controls="document" aria-selected="false">Maklumat Dokumen</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link disabled" id="acknowledgement-tab" data-bs-toggle="tab" href="#acknowledgement" role="tab"
                                            aria-controls="acknowledgement" aria-selected="false">Perakuan</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content p-4" id="myTabContent">
                                        <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application-tab">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="selVessel">Vesel : <span style="color:red;">*</span></label>
                                                        <select class="form-select " id="selVessel" name="selVessel" autocomplete="off" height="100%" required>
                                                            <option value="">{{ __('app.please_select')}}</option>
                                                            @foreach($vessels as $vessel)
                                                                <option value="{{$vessel->id}}" {{old('selVessel')==$vessel->id?'selected':''}} {{ $vessel->hasLocalQuota() ? '' : 'disabled' }}>{{$vessel->no_pendaftaran}} | Jumlah:{{$vessel->totalKru()}}, Maksimum:{{$vessel->maximumKru()}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('selVessel')
                                                        <span id="selVessel_error" class="text-danger" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="icNum" class="form-label">No. Kad Pengenalan ( Tanpa '-' ) : <span style="color:red;">*</span></label>
                                                        <input type="number" id="icNum" class="form-control" name="icNum" maxlength="12" minlength="12" value="{{old('icNum')}}" required/>
                                                    </div>
                                                    @error('icNum')
                                                        <span id="icNum_error" class="text-danger" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                                    <a href="{{ route('kadpendaftarannelayan.permohonan.index') }}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                    <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Simpan Maklumat Permohonan?</span>').text())">
                                                        <i class="fas fa-save"></i> Simpan & Seterusnya
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

@endsection

@push('scripts')
    <!-- <script src="{{ asset('template/plugins/jquery-validation/jquery.validate.min.js') }}"></script> -->
    <script type="text/javascript">

        $(document).ready(function () {
            //No Kad Pengenalan - Validation
            $('#icNum').keypress(function (e) {
                var charCode = (e.which) ? e.which : event.keyCode
                if (String.fromCharCode(charCode).match(/[^0-9]/g)|| $(this).val().length >= 12)
                    return false;
            });
            
			// $('#form').validate({
			// 	errorElement: 'span',
            //     errorPlacement: function (error, element) {
            //         error.addClass('text-danger');
            //         element.closest('.form-group').append(error);
            //     },
            //     highlight: function (element, errorClass, validClass) {
            //         $(element).addClass('is-invalid');
            //     },
            //     unhighlight: function (element, errorClass, validClass) {
            //         $(element).removeClass('is-invalid');
            //     }
			// });

			// $('#form').on('submit', function(e) {
			// 	e.preventDefault();
			// 	if($(this).valid()) {
			// 		document.getElementById('form').submit();
			// 	}
			// });
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
