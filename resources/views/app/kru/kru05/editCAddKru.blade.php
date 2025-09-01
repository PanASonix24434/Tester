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
                                <li class="breadcrumb-item"><a href="{{ route('kebenaranpenggunaankrubukanwarganegara.permohonan.index') }}">Kebenaran Penggunaan Kru Bukan Warganegara Untuk Bekerja Di Atas Vesel Penangkapan Ikan Tempatan</a></li>
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
                                                <a class="nav-link" href="{{route('kebenaranpenggunaankrubukanwarganegara.permohonan.edit',$id)}}">Senarai Vesel</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('kebenaranpenggunaankrubukanwarganegara.permohonan.editB',$id)}}">Maklumat Am</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active" href="{{route('kebenaranpenggunaankrubukanwarganegara.permohonan.editC',$id)}}">Senarai Kru Bukan Warganegara</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('kebenaranpenggunaankrubukanwarganegara.permohonan.editD',$id)}}">Maklumat Dokumen</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('kebenaranpenggunaankrubukanwarganegara.permohonan.editE',$id)}}">Perakuan</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content p-4" id="myTabContent">
                                            <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application-tab">
                                                <form id="form" method="POST" enctype="multipart/form-data" action="{{ route('kebenaranpenggunaankrubukanwarganegara.permohonan.updateCAddKru',$id) }}">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <label class="col-form-label">Maklumat Kru:</label>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="name" class="form-label">Nama Kru <span style="color: red;">*</span></label>
                                                                <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" style="text-transform: uppercase" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="nationality">Warganegara <span style="color: red;">*</span></label>
                                                                <select class="form-control select2" id="nationality" name="nationality" style="width: 100%;" required>
                                                                    <option selected="selected" value="">- Sila Pilih -</option>
                                                                    @foreach ( $sourceCountries as $sourceCountry )
                                                                        <option value="{{$sourceCountry->id}}" @if (old('nationality') == $sourceCountry->id) selected @endif>{{$sourceCountry->name_ms}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="mb-3">
                                                                <label for="birthDate" class="form-label">Tarikh Lahir : <span style="color:red;">*</span></label>
                                                                <input type="date" id="birthDate" name="birthDate" value="{{old('birthDate')}}" class="form-control" max="{{ now()->toDateString() }}" required />
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="gender" class="form-label">Jantina <span style="color: red;">*</span></label>
                                                                <select class="form-control select2" id="gender" name="gender" style="width: 100%;" required>
                                                                    <option selected="selected" value="">- Sila Pilih -</option>
                                                                    @foreach ( $genders as $gender )
                                                                        <option value="{{$gender->id}}" @if (old('gender')==$gender->id) selected @endif>{{$gender->name_ms}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="position" >Jawatan <span style="color: red;">*</span></label>
                                                                <select class="form-control select2" id="position" name="position" style="width: 100%;" required>
                                                                    <option selected="selected" value="">- Sila Pilih -</option>
                                                                    @foreach ( $positions as $position )
                                                                        <option value="{{$position->id}}" @if (old('position') == $position->id) selected @endif>{{$position->name_ms}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="kruWhereabout" class="form-label">Status Keberadaan Kru <span style="color: red;">*</span></label>
                                                                <input type="text" class="form-control" id="kruWhereabout" name="kruWhereabout" value="{{old('kruWhereabout')}}" style="text-transform: uppercase" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="passport" class="form-label">Nombor Pasport <span style="color: red;">*</span></label>
                                                                <input type="text" class="form-control" id="passport" name="passport" value="{{old('passport')}}" style="text-transform: uppercase" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="mb-3">
                                                                <label for="passportEndDate" class="form-label">Tarikh Tamat Pasport : <span style="color:red;">*</span></label>
                                                                <input type="date" id="passportEndDate" name="passportEndDate" value="{{old('passportEndDate')}}" class="form-control" min="{{  $minPassport  }}" required />
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Salinan Pasport Kru (muka depan maklumat sahaja) : <span style="color: red;">(saiz maksimum: 5mb)*</span></label>
                                                                <div class="input-group">
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="passportDoc" name="passportDoc" required>
                                                                        <label class="custom-file-label" for="passportDoc">Pilih Fail</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @error('passportDoc')
                                                                <span id="passportDoc_error" class="text-danger" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                                            <a href="{{ route('kebenaranpenggunaankrubukanwarganegara.permohonan.editC',$id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                            <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm($('<span>Simpan Maklumat Kru?</span>').text())">
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
