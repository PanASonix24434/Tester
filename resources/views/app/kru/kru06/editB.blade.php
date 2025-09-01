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
                                                <a class="nav-link disabled" href="{{route('kelulusanpenggunaankrubukanwarganegara.permohonan.edit',$id)}}">Senarai Vesel</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active disabled" href="{{route('kelulusanpenggunaankrubukanwarganegara.permohonan.editB',$id)}}">Maklumat Am</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link disabled" href="{{route('kelulusanpenggunaankrubukanwarganegara.permohonan.editC',$id)}}">Senarai Kru Bukan Warganegara</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link disabled" href="{{route('kelulusanpenggunaankrubukanwarganegara.permohonan.editD',$id)}}">Maklumat Dokumen</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link disabled" href="{{route('kelulusanpenggunaankrubukanwarganegara.permohonan.editE',$id)}}">Perakuan</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content p-4" id="myTabContent">
                                            <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application-tab">
                                                <form id="form" method="POST" action="{{ route('kelulusanpenggunaankrubukanwarganegara.permohonan.updateB',$id) }}">
                                                    @csrf
                                                    <div class="row">
                                                        <!-- Vessel -->
                                                        <div class="col-6">
                                                            <div class="mb-3">
                                                                <label for="txtOwner" class="form-label">Nama Majikan / Syarikat : </label>
                                                                <input type="text" class="form-control" id="txtOwner" name="txtOwner" value="{{ $vesselOwner->name }}" disabled/>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="selOffice">Pejabat Imigresen : <span style="color:red;">*</span></label>
                                                                <select class="form-select select2" id="selOffice" name="selOffice" autocomplete="off" height="100%" width="100%" disabled>
                                                                    <option value="">{{ __('app.please_select')}}</option>
                                                                    @foreach ( $imigresenOffices as $office )
                                                                        <option value="{{$office->id}}" @if ($appForeign!=null) {{ $appForeign->immigration_office_id == $office->id ? 'selected' : '' }}  @endif>{{ strtoupper($office->name) }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            @error('selOffice')
                                                                <span id="selOffice_error" class="text-danger" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        @if($appPermission->kru_application_type_id==$kru05Id)
                                                            <div class="col-6">
                                                                <div class="mb-3">
                                                                    <label for="txtDate" class="form-label">Tarikh Jangka Masuk Ke Malaysia : <span style="color:red;">*</span></label>
                                                                    <input type="date" id="txtDate" name="txtDate" value="{{ $appForeign!=null ? optional($appForeign->immigration_date)->format('Y-m-d') : '' }}" class="form-control" min="{{ now()->toDateString() }}" disabled />
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="mb-3">
                                                                    <label for="selGate" class="form-label">Pintu Masuk Imigresen : <span style="color:red;">*</span></label>
                                                                    <select class="form-select select2" id="selGate" name="selGate" autocomplete="off" height="100%" width="100%" disabled>
                                                                        <option value="">{{ __('app.please_select')}}</option>
                                                                        @foreach ( $imigresenGates as $gate )
                                                                            <option value="{{$gate->id}}" @if ($appForeign!=null) {{ $appForeign->immigration_gate_id == $gate->id ? 'selected' : '' }}  @endif>{{ strtoupper($gate->name) }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    {{--<input type="text" class="form-control" id="selGate" name="selGate" value="{{ $appForeign!=null ? $appForeign->immigration_gate : '' }}" style="text-transform: uppercase" required />--}}
                                                                </div>
                                                            </div>
                                                        @elseif($appPermission->kru_application_type_id==$kru07Id)
                                                            <div class="col-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Penempatan Kru Terkini : </label>
                                                                    <input type="text" class="form-control" value="{{ $appForeign!=null ? $appForeign->crew_placement : '' }}" disabled/>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Di Bawah Pengawasan : </label>
                                                                    <input type="text" class="form-control" value="{{ $appForeign!=null ? $appForeign->supervised : '' }}" disabled/>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                                            <a href="{{ route('kelulusanpenggunaankrubukanwarganegara.permohonan.edit',$id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                            <a href="{{ route('kelulusanpenggunaankrubukanwarganegara.permohonan.editC',$id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-right"></i> Seterusnya</a>
                                                            <!-- <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm($('<span>Simpan Maklumat Permohonan?</span>').text())">
                                                                <i class="fas fa-save"></i> Simpan
                                                            </button> -->
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
