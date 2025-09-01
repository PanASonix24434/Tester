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
                                <li class="breadcrumb-item"><a href="{{ route('kelulusanpenggunaankrubukanwarganegara.permohonan.index') }}">Kelulusan Penggunaan Kru Bukan Warganegara Untuk Bekerja Di Atas Vesel Penangkapan Ikan Tempatan</a></li>
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
                                                <a class="nav-link" href="{{route('kelulusanpenggunaankrubukanwarganegara.permohonan.edit',$id)}}">Senarai Vesel</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('kelulusanpenggunaankrubukanwarganegara.permohonan.editB',$id)}}">Maklumat Am</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active" href="{{route('kelulusanpenggunaankrubukanwarganegara.permohonan.editC',$id)}}">Senarai Kru Bukan Warganegara</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('kelulusanpenggunaankrubukanwarganegara.permohonan.editD',$id)}}">Maklumat Dokumen</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('kelulusanpenggunaankrubukanwarganegara.permohonan.editE',$id)}}">Perakuan</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content p-4" id="myTabContent">
                                            <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application-tab">
                                                <form id="form" method="POST" enctype="multipart/form-data" action="{{ route('kelulusanpenggunaankrubukanwarganegara.permohonan.updateCAddKru',$foreignKru->id) }}">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <label class="col-form-label">Maklumat Kru:</label>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="name" class="form-label">Nama Kru </label>
                                                                <input type="text" class="form-control" id="name" name="name" value="{{$foreignKru->name}}" style="text-transform: uppercase" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="nationality" class="form-label">Warganegara </label>
                                                                <input type="text" class="form-control" id="nationality" name="nationality" value="{{ Helper::getCodeMasterNameById($foreignKru->source_country_id) }}" style="text-transform: uppercase" disabled>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-6">
                                                            <div class="mb-3">
                                                                <label for="birthDate" class="form-label">Tarikh Lahir </label>
                                                                <input type="date" id="birthDate" name="birthDate" value="{{$foreignKru->birth_date->format('Y-m-d')}}" class="form-control" disabled />
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="gender" class="form-label">Jantina </label>
                                                                <select class="form-control select2" id="gender" name="gender" style="width: 100%;" disabled>
                                                                    <option selected="selected" value="">- Sila Pilih -</option>
                                                                    @foreach ( $genders as $gender )
                                                                        <option value="{{$gender->id}}" @if ($foreignKru->gender_id==$gender->id) selected @endif>{{$gender->name_ms}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Jawatan </label>
                                                                <select class="form-control select2" id="position" name="position" style="width: 100%;" disabled>
                                                                    <option selected="selected" value="">- Sila Pilih -</option>
                                                                    @foreach ( $positions as $position )
                                                                        <option value="{{$position->id}}" @if ($foreignKru->foreign_kru_position_id == $position->id) selected @endif>{{$position->name_ms}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="kruWhereabout" class="form-label">Status Keberadaan Kru </label>
                                                                <input type="text" class="form-control" id="kruWhereabout" name="kruWhereabout" value="{{$foreignKru->crew_whereabout}}" style="text-transform: uppercase" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="passport" class="form-label">Nombor Pasport </label>
                                                                <input type="text" class="form-control" id="passport" name="passport" value="{{$foreignKru->passport_number}}" style="text-transform: uppercase" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="mb-3">
                                                                <label for="passportEndDate" class="form-label">Tarikh Tamat Pasport </label>
                                                                <input type="date" id="passportEndDate" name="passportEndDate" value="{{$foreignKru->passport_end_date->format('Y-m-d')}}" class="form-control" disabled />
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="plksNo" class="form-label">Nombor PLKS <span style="color: red;">*</span></label>
                                                                <input type="text" class="form-control" id="plksNo" name="plksNo" value="{{$foreignKru->plks_number}}" style="text-transform: uppercase" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="mb-3">
                                                                <label for="plksEndDate" class="form-label">Tarikh Tamat PLKS <span style="color: red;">*</span></label>
                                                                <input type="date" id="plksEndDate" name="plksEndDate" value="{{optional($foreignKru->plks_end_date)->format('Y-m-d')}}" class="form-control" required/>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Salinan Pasport Kru yang dicetak Pelekat PLKS : <span style="color: red;">( saiz maksimum: 5mb)*</span></label>
                                                                <div class="input-group">
                                                                    @if ( $docPassport != null)
                                                                        <a href="{{ route('kruhelper.previewKruForeignDoc', $docPassport->id) }}" target="_blank">{{$docPassport->file_name}}</a>&nbsp;
                                                                        <button type="button" class="btn btn-danger btn-sm"
                                                                            onclick="event.preventDefault(); if (confirm('Hapus Dokumen?')) {
                                                                                    document.getElementById('delete-link-form-{{ $docPassport->id }}').submit();
                                                                                }">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    @else
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" id="passportDoc" name="passportDoc" required>
                                                                            <label class="custom-file-label" for="passportDoc">Pilih Fail</label>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            @error('passportDoc')
                                                                <span id="passportDoc_error" class="text-danger" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                                            <a href="{{ route('kelulusanpenggunaankrubukanwarganegara.permohonan.editC',$id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                            <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm($('<span>Simpan Maklumat Kru?</span>').text())">
                                                                <i class="fas fa-save"></i> Simpan
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                                @if ( $docPassport != null)
                                                    <form id="delete-link-form-{{ $docPassport->id }}" 
                                                        action="{{route('kruhelper.deleteKruForeignDoc',$docPassport->id)}}" 
                                                        method="POST" 
                                                        style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                @endif
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
