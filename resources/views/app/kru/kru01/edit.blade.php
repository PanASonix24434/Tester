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
                                        <a class="nav-link disabled" id="address-tab" 
                                        aria-controls="address" aria-selected="false">Alamat Kru</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link disabled" id="contact-tab" 
                                        aria-controls="contact" aria-selected="false">Maklumat Perhubungan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link disabled" id="document-tab" 
                                        aria-controls="document" aria-selected="false">Maklumat Dokumen</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link disabled" id="acknowledgement-tab" 
                                        aria-controls="acknowledgement" aria-selected="false">Perakuan</a>
                                    </li>
                                </ul>
                                <div class="tab-content p-4" id="myTabContent">
                                    <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application-tab"> 
                                        <form id="form" method="POST" action="{{ route('kadpendaftarannelayan.permohonan.update',$id) }}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Vesel : </label>
                                                        <input class="form-control" value="{{ $app->vessel_id != null ? App\Models\Vessel::withTrashed()->find($app->vessel_id)->no_pendaftaran : ''}}" disabled/>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="selPosition">Jawatan : <span style="color:red;">*</span></label>
                                                        <select class="form-select select2" id="selPosition" name="selPosition" autocomplete="off" height="100%" required>
                                                            <option value="">{{ __('app.please_select')}}</option>
                                                            @foreach($kruPositions as $kruPosition)
                                                                <option value="{{$kruPosition->id}}" 
                                                                    @if ($kruPosition->id == $pemilikVeselId)
                                                                        @if (!$isPemilik)
                                                                            disabled
                                                                        @endif
                                                                    @endif
                                                                    @if ($kruPosition->id == $kru->kru_position_id)
                                                                        selected
                                                                    @endif
                                                                {{old('selPosition')==$kruPosition->id?'selected':''}} {{old('selPosition')==$kruPosition->id?'selected':''}}
                                                                >{{$kruPosition->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('selPosition')
                                                        <span id="selPosition_error" class="text-danger" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="form-label">No. Kad Pengenalan ( Tanpa '-' ) : </label>
                                                        <input class="form-control" value="{{$kru->ic_number}}" disabled/>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="name" class="form-label">Nama ( Masukkan seperti dalam kad pengenalan) : <span style="color:red;">*</span></label>
                                                        <input type="text" id="name" name="name" class="form-control" style="text-transform: uppercase" value="{{$kru->name}}" required />
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="selRace">Bangsa : <span style="color:red;">*</span></label>
                                                        <select class="form-select select2" id="selRace" name="selRace" autocomplete="off" height="100%" required>
                                                            <option value="">{{ __('app.please_select')}}</option>
                                                            @foreach($races as $race)
                                                                <option value="{{$race->id}}"
                                                                    @if ($race->id == $kru->race_id)
                                                                        selected
                                                                    @endif 
                                                                >{{$race->name_ms}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="selWarganegara">Status Kewarganegaraan : <span style="color:red;">*</span></label>
                                                        <select class="form-select select2" id="selWarganegara" name="selWarganegara" autocomplete="off" height="100%" required>
                                                            <option value="">{{ __('app.please_select')}}</option>
                                                            @foreach($kewarganegaraanStatus as $warganegara)
                                                                <option value="{{$warganegara->id}}"
                                                                    @if ($warganegara->id == $kru->kewarganegaraan_status_id)
                                                                        selected
                                                                    @endif 
                                                                >{{$warganegara->name_ms}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="selBumi">Bumiputera : <span style="color:red;">*</span></label>
                                                        <select class="form-select select2" id="selBumi" name="selBumi" autocomplete="off" height="100%" required>
                                                            <option value="">{{ __('app.please_select')}}</option>
                                                            @foreach($bumiputeraStatus as $bumi)
                                                                <option value="{{$bumi->id}}" 
                                                                    @if ($bumi->id == $kru->bumiputera_status_id)
                                                                        selected
                                                                    @endif 
                                                                >{{$bumi->name_ms}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                                    <a href="{{ route('kadpendaftarannelayan.permohonan.index') }}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                    <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Simpan Maklumat Permohonan?</span>').text())">
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

            //No Kad Pengenalan - Validation
            $('#icNum').keypress(function (e) {
                var charCode = (e.which) ? e.which : event.keyCode
                if (String.fromCharCode(charCode).match(/[^0-9]/g)|| $(this).val().length >= 12)
                    return false;
            });

            $('#selWarganegara').on('change', function() {
                var warganegaraId = $(this).val();
                const pemastautinTetapId = '{{$pemastautinTetapId}}';
                const tiadaId = '{{$tiadaId}}';

                if (warganegaraId) {
                    if(warganegaraId == pemastautinTetapId){
                        $('#selBumi').find('option').prop('disabled', true);

                        // Then, enable the specific option
                        $('#selBumi').find('option[value="' + tiadaId + '"]').prop('disabled', false);

                        // Optional: Set the selected option to the one you just enabled,
                        // especially if another disabled option was previously selected.
                        $('#selBumi').val(tiadaId);
                        $('#selBumi').trigger('change'); // Enable and update Select2
                    }
                    else{
                        $('#selBumi').find('option').prop('disabled', false);
                        
                        $('#selBumi').find('option[value="' + tiadaId + '"]').prop('disabled', true);

                        $('#selBumi').val('');
                        $('#selBumi').trigger('change'); // Enable and update Select2
                    }
                } else {
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
