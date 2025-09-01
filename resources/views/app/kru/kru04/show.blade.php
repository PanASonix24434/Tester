@extends('layouts.app')


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
                                <li class="breadcrumb-item"><a href="{{ route('pembatalankadpendaftarannelayan.permohonan.index') }}">Pembatalan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Permohonan</li>
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
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Jenis Permohonan</label>
                                        <input type="text" class="form-control" value="{{ App\Models\Kru\KruApplicationType::find($app->kru_application_type_id)->name }}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Nombor Rujukan</label>
                                        <input type="text" class="form-control" value="{{$app->reference_number}}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Pejabat Permohonan</label>
                                        <input type="text" class="form-control" value="{{ $app->entity_id != null ? strtoupper(Helper::getEntityNameById($app->entity_id)) : '' }}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <input type="text" class="form-control" value="{{ Helper::getCodeMasterNameById($app->kru_application_status_id) }}" disabled>
                                    </div>
                                </div>
                                @if ($app->kru_application_status_id == $statusIncompleteId)
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Sebab Tidak Lengkap</label>
                                            <textarea class="form-control" rows="4" disabled>{{ $incompleteLog->remark }}</textarea>
                                        </div>
                                    </div>
                                @endif
                                @if ($app->kru_application_status_id == $statusRejectedId)
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Sebab Tidak Lengkap</label>
                                            <textarea class="form-control" rows="4" disabled>{{ $rejectedLog->remark }}</textarea>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <br/>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="application-tab" data-bs-toggle="tab" href="#application" role="tab"
                                    aria-controls="application" aria-selected="true">Maklumat Permohonan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="acknowledgement-tab" data-bs-toggle="tab" href="#acknowledgement" role="tab"
                                    aria-controls="acknowledgement" aria-selected="false">Perakuan</a>
                                </li>
                            </ul>
                            <div class="tab-content p-4" id="tabContent">
                                <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application-tab">
                                    <div class="row">
                                        <!-- Vessel -->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="vessel" class="form-label">Vesel : </label>
                                                <input type="text" class="form-control" value="{{$vessel->no_pendaftaran}}" disabled/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:1%;">Bil</th>
                                                            <th>No. Kad Pengenalan</th>
                                                            <th>Nama</th>
                                                            @if ( $decisionStatusIds->contains('id',$app->kru_application_status_id) )
                                                                <th>Keputusan</th>
                                                            @endif
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
                                                                    <td>{{$kru->ic_number}}</td>
                                                                    <td>{{$kru->name}}</td>
                                                                    @if ( $decisionStatusIds->contains('id',$app->kru_application_status_id) )
                                                                        <td>{{$kru->selected_for_approval ? 'Dibatalkan' : 'Tidak Dibatalkan'}}</td>
                                                                    @endif
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="5" style="text-align: center;">-Tiada Kru-</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <br\>
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3">
                                            <a href="{{ route('pembatalankadpendaftarannelayan.permohonan.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                            @if ($app->kru_application_status_id == $statusIncompleteId)
                                                <a href="{{ route('pembatalankadpendaftarannelayan.permohonan.edit',$id) }}" class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i> Kemaskini</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="acknowledgement" role="tabpanel" aria-labelledby="acknowledgement-tab">
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="terms" class="custom-control-input" id="terms" checked disabled>
                                                    <label class="custom-control-label" for="terms">Saya dengan ini mengakui dan mengesahkan bahawa semua maklumat yang diberikan oleh saya adalah benar. Sekiranya terdapat maklumat yang tidak benar, pihak Jabatan boleh menolak permohonan saya dan tindakan undang-undang boleh dikenakan ke atas saya.</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br\>
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3">
                                            <a href="{{ route('pembatalankadpendaftarannelayan.permohonan.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                            @if ($app->kru_application_status_id == $statusIncompleteId)
                                                <a href="{{ route('pembatalankadpendaftarannelayan.permohonan.edit',$id) }}" class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i> Kemaskini</a>
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

@endsection

@push('scripts')
    <script type="text/javascript">

        $(document).ready(function () {
            $('.select2').select2()
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
