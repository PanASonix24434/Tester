@extends('layouts.app')

@push('styles')
    <style type="text/css">
    </style>
@endpush

@section('content')

    <!-- Page Content -->
    <div id="app-content">
        <!-- Container fluid -->
        <div class="app-content-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <!-- Page header -->
                        <div class="mb-8">
                            <h3 class="mb-0">Pengisytiharan Pendaratan Perikanan Darat</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                    </div>
                </div>
                <div class="row">
                </div>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="content-a-tab" data-bs-toggle="tab" href="#content-a" role="tab"
                        aria-controls="content-a" aria-selected="true">Maklumat Pendaratan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="content-b-tab" data-bs-toggle="tab" href="#content-b" role="tab"
                        aria-controls="content-b" aria-selected="false">Tindakan</a>
                    </li>
                </ul>
                <div class="tab-content p-4" id="tabContent">
                    <div class="tab-pane fade show active" id="content-a" role="tabpanel" aria-labelledby="content-a-tab">
                        <div class="row">
                            <div class="col-12">
                                <!-- card -->
                                <div class="card mb-4">
                                    <div class="card-header bg-primary">
                                        <h4 class="mb-0" style="color:white;">Maklumat Pendaratan </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 table-responsive">
                                                <div class="form-group">
                                                    <label class="col-form-label">Senarai Pendaratan:</label>
                                                    <a href="{{ route('landinghelper.exportExcel',['userId'=>$id, 'year'=>$year, 'month'=>$month]) }}" class="btn btn-sm btn-primary float-right">
                                                        <i class="fas fa-print"></i>Cetak
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:1%;">Bil</th>
                                                            <th>Tahun</th>
                                                            <th>Bulan</th>
                                                            <th>Minggu</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="listDoc">
                                                        @if (!$apps->isEmpty())
                                                            @php
                                                                $count = 0;
                                                            @endphp
                                                            @foreach ($apps as $app)
                                                                <tr>
                                                                    <td>{{++$count}}</td>
                                                                    <td>{{$app->year}}</td>
                                                                    <td>{{$app->month}}</td>
                                                                    <td>
                                                                        {{$app->week}}
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('landingdeclaration.check.showWeek',$app->id) }}" class="btn btn-sm btn-primary">
                                                                            <i class="fas fa-search"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="4" style="text-align: center;">-Tiada Dokumen-</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <br />
                                                <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                                    <a href="{{ route('landingdeclaration.check.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="content-b" role="tabpanel" aria-labelledby="content-b-tab">
                        <div class="col-12">
                            <!-- card -->
                            <div class="card mb-4">
                                <div class="card-header bg-primary">
                                    <h4 class="mb-0" style="color:white;">Tindakan</h4>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('landingdeclaration.check.update',['id'=>$id,'year'=>$year,'month'=>$month]) }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-12">
                                                <h5 class="text-primary"><b>Maklumat Pendaratan</b></h5>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="vessel" class="form-label"><span @if ($apps->count() < $weekCount) style="color: red;" @else style="color: green;" @endif>Bilangan minggu dihantar: {{$apps->count()}}/{{$weekCount}}</span></label>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <h5 class="text-primary"><b>Sokongan Permohonan</b></h5>
                                            <div class="col-12">
                                                <strong>Tindakan :</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="applicationStatus" id="supported" value="supported" @if (!$canProceed) disabled @endif>
                                                    <label class="form-check-label" for="supported">Sokong</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="applicationStatus" id="notSupported" value="notSupported" @if (!$canProceed) disabled @endif>
                                                    <label class="form-check-label" for="notSupported">Tidak Sokong</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="applicationStatus" id="incomplete" value="incomplete">
                                                    <label class="form-check-label" for="incomplete">Tidak Lengkap</label>
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                        <div id="lengkap" class="row hidden" >{{--$savedLog!=null ? ($savedLog->completed ? '' : 'hidden') : 'hidden'--}}
                                            <div class="col-12">
                                                <label>Minggu:</label>
                                                <div class="form-group">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="remark" class="form-label"><strong>Ulasan</strong></label>
                                                <textarea class="form-control" id="remark" name = "remark" rows="3"   {{--@if(!empty ($app->supported_remarks)) disabled @endif--}}>{{-- $app->supported_remarks ?? '' --}}</textarea>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row">
                                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                                <a href="{{ route('landingdeclaration.check.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                <button id="btnSubmit" type="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Simpan Sokongan ?</span>').text())">
                                                    <i class="fas fa-paper-plane"></i> Hantar
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

@endsection

@push('scripts')
<script src="{{ asset('template/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript">

    $(document).on('input', "input[type=text]", function () {
        $(this).val(function (_, val) {
            return val.toUpperCase();
        });
    });
    
    $(document).ready(function () {
        $('#btnSubmit').prop("disabled",true);
        
        $('input[type=radio][name=applicationStatus]').change(function() {
            $('#btnSubmit').prop("disabled",false);
            if ($(this).val()=='supported') {
                $('#remark').prop("required",false);
            }else if ($(this).val()=='notSupported' || $(this).val()=='incomplete'){
                $('#remark').prop("required",true);
            }

            if ($(this).val()=='supported' || $(this).val()=='notSupported') {
                $('#lengkap').addClass('hidden');
            }else if ( $(this).val()=='incomplete'){
                $('#lengkap').removeClass('hidden');
            }
        });
    });

        

        

        
        

</script>   
@endpush
