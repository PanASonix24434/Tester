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
                                <li class="breadcrumb-item"><a href="{{ route('pembaharuankadpendaftarannelayan.permohonan.index') }}">Pembaharuan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)</a></li>
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
                                            <a class="nav-link active" id="address-tab" href="#address"
                                            aria-controls="address" aria-selected="true">Alamat Kru</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link disabled" id="contact-tab" href="{{route('pembaharuankadpendaftarannelayan.permohonan.editC',$appKru->id)}}"
                                            aria-controls="contact" aria-selected="false">Maklumat Perhubungan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link disabled" id="health-tab" href="{{route('pembaharuankadpendaftarannelayan.permohonan.editD',$appKru->id)}}"
                                            aria-controls="health" aria-selected="false">Maklumat Kesihatan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link disabled" id="document-tab" href="{{route('pembaharuankadpendaftarannelayan.permohonan.editE',$appKru->id)}}"
                                            aria-controls="document" aria-selected="false">Maklumat Dokumen</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content p-4" id="myTabContent">
                                        <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application-tab">
                                            <form id="form" method="POST" action="{{ route('pembaharuankadpendaftarannelayan.permohonan.updateB',$appKru->id) }}">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-6">
                                                        <!-- Address -->
                                                        <div class="mb-3">
                                                            <label for="address1" class="form-label">Alamat : <span style="color:red;">*</span></label>
                                                            <input type="text" id="address1" name="address1" class="form-control" style="text-transform: uppercase" value="{{$appKru->address1}}" required />
                                                            <input type="text" id="address2" name="address2" class="form-control" style="text-transform: uppercase" value="{{$appKru->address2}}" />
                                                            <input type="text" id="address3" name="address3" class="form-control" style="text-transform: uppercase" value="{{$appKru->address3}}" />
                                                        </div>
                                                        @error('address1')
                                                            <span id="address1_error" class="text-danger" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        @error('address2')
                                                            <span id="address2_error" class="text-danger" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        @error('address3')
                                                            <span id="address3_error" class="text-danger" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <!-- Postcode -->
                                                        <div class="mb-3">
                                                            <label for="postcode" class="form-label">Poskod : <span style="color:red;">*</span></label>
                                                            <input type="number" id="postcode" class="form-control" name="postcode" maxlength="5" minlength="5" value="{{$appKru->postcode}}" required/>
                                                        </div>
                                                        @error('postcode')
                                                            <span id="postcode_error" class="text-danger" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <!-- City -->
                                                        <div class="mb-3">
                                                            <label for="city" class="form-label">Bandar : <span style="color:red;">*</span></label>
                                                            <input type="text" id="city" name="city" class="form-control" style="text-transform: uppercase" value="{{$appKru->city}}" required />
                                                        </div>
                                                        @error('city')
                                                            <span id="city_error" class="text-danger" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-6">
                                                        <!-- Negeri -->
                                                        <div class="mb-3">
                                                            <label class="form-label" for="selState">Negeri : <span style="color:red;">*</span></label>
                                                            <select class="form-select select2" id="selState" name="selState" autocomplete="off" height="100%" required>
                                                                <option value="">{{ __('app.please_select')}}</option>
                                                                @foreach($states as $state)
                                                                    <option value="{{$state->id}}" {{$appKru->state_id==$state->id?'selected':''}}>{{$state->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @error('selPosition')
                                                            <span id="selPosition_error" class="text-danger" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <!-- Daerah -->
                                                        <div class="mb-3">
                                                            <label class="form-label" for="selDistrict">Daerah : <span style="color:red;">*</span></label>
                                                            <select class="form-select select2" id="selDistrict" name="selDistrict" autocomplete="off" height="100%" required>
                                                                <option value="">{{ __('app.please_select')}}</option>
                                                                @foreach($districts as $district)
                                                                    <option value="{{$district->id}}" {{$appKru->district_id==$district->id?'selected':''}}>{{$district->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @error('selPosition')
                                                            <span id="selPosition_error" class="text-danger" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                                        <a href="{{ route('pembaharuankadpendaftarannelayan.permohonan.edit',$id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                        <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm($('<span>Simpan Alamat Kru?</span>').text())">
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
            $('#postcode').keypress(function (e) {
                var charCode = (e.which) ? e.which : event.keyCode
                if (String.fromCharCode(charCode).match(/[^0-9]/g)|| $(this).val().length >= 5)
                    return false;
            });
            
            $('#selState').on('change', function() {
                var stateId = $(this).val();
                if (stateId) {
                    $.ajax({
                        url: '{{ route('helper.getDistricts') }}',
                        type: 'GET',
                        data: { state_id: stateId },
                        dataType: 'json',
                        success: function(data) {
                            $('#selDistrict').empty();
                            $('#selDistrict').append('<option value="">- Sila Pilih -</option>');
                            $.each(data, function(key, value) {
                                $('#selDistrict').append('<option value="' + key + '">' + value + '</option>');
                            });
                            $('#selDistrict').trigger('change'); // Enable and update Select2

                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX error:", error);
                        }
                    });
                } else {
                    $('#selDistrict').empty();
                    $('#selDistrict').append('<option value="">- Sila Pilih -</option>');
                }
            });

        });

        var msg = '{{Session::get('alert')}}';
        var exist = '{{Session::has('alert')}}';
        if(exist){
            alert(msg);
        }
    </script>
@endpush
