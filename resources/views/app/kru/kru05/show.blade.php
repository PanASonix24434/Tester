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
                                <li class="breadcrumb-item"><a href="{{ route('kebenaranpenggunaankrubukanwarganegara.permohonan.index') }}">Permohonan Kebenaran Penggunaan Kru Bukan Warganegara Untuk Bekerja Di Atas Vesel Penangkapan Ikan Tempatan</a></li>
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
                                    <a class="nav-link" id="vesel-tab" data-bs-toggle="tab" href="#vesel" role="tab"
                                    aria-controls="vesel" aria-selected="false">Senarai Vesel</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="kru-tab" data-bs-toggle="tab" href="#kru" role="tab"
                                    aria-controls="kru" aria-selected="false">Senarai Kru Bukan Warganegara</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="document-tab" data-bs-toggle="tab" href="#document" role="tab"
                                    aria-controls="document" aria-selected="false">Maklumat Dokumen</a>
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
                                                <label class="form-label">Nama Majikan / Syarikat : </label>
                                                <input type="text" class="form-control" value="{{ $vesselOwner->name }}" disabled/>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label">Pejabat Imigresen : </label>
                                                <input type="text" class="form-control" value="{{ $appForeign!=null ? strtoupper(App\Models\Kru\ImmigrationOffice::withTrashed()->find($appForeign->immigration_office_id)->name) : '' }}" disabled/>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label">Tarikh Jangka Masuk Ke Malaysia : </label>
                                                <input type="date" class="form-control" value="{{ $appForeign!=null ? optional($appForeign->immigration_date)->format('Y-m-d') : '' }}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label">Pintu Masuk Imigresen : </label>
                                                <input type="text" class="form-control" value="{{ $appForeign!=null ? strtoupper(App\Models\Kru\ImmigrationGate::withTrashed()->find($appForeign->immigration_gate_id)->name) : '' }}" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <br\>
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3">
                                            <a href="{{ route('kebenaranpenggunaankrubukanwarganegara.permohonan.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                            @if ($app->kru_application_status_id == $statusIncompleteId)
                                                <a href="{{ route('kebenaranpenggunaankrubukanwarganegara.permohonan.edit',$id) }}" class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i> Kemaskini</a>
                                            @endif
                                            @if ($app->is_approved)
                                                <a href="{{ route('kebenaranpenggunaankrubukanwarganegara.permohonan.exportPermissionLetter',$id) }}" target="_blank" class="btn btn-warning btn-sm"><i class="fas fa-print"></i> Surat Kebenaran</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="vesel" role="tabpanel" aria-labelledby="vesel-tab">
                                    <div class="row">
                                        <div class="col-sm-12 table-responsive">
                                            <div class="form-group">
                                                <label class="col-form-label">Senarai Vesel:</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Bil</th>
                                                        <th>Vesel</th>
                                                        <th>Zon</th>
                                                        <th>Bilangan Kuota Kru Maksimum</th>
                                                        <th>Baki Kuota Kru Boleh Dipohon</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="listDoc">
                                                    @php
                                                        $vesselCount = 0;
                                                    @endphp
                                                    @if ($vessels != null && !$vessels->isEmpty())
                                                        @foreach ( $vessels as $vessel )
                                                            <tr>
                                                                <td>{{++$vesselCount}}</td>
                                                                <td>{{$vessel->no_pendaftaran}}</td>
                                                                <td>{{$vessel->zon}}</td>
                                                                <td>{{$vessel->maximumForeignKru()}}</td>
                                                                <td>{{$vessel->totalForeignKruQuotaLeft()}}</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="4">- Tiada Vesel Berkaitan -</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="vessel" class="form-label">Vesel Pilihan: </label>
                                                <input type="text" class="form-control" value="{{ $app->vessel_id != null ? App\Models\Vessel::withTrashed()->find($app->vessel_id)->no_pendaftaran : ''}}" disabled/>
                                            </div>
                                        </div>
                                    </div>
                                    <br\>
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3">
                                            <a href="{{ route('kebenaranpenggunaankrubukanwarganegara.permohonan.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                            @if ($app->kru_application_status_id == $statusIncompleteId)
                                                <a href="{{ route('kebenaranpenggunaankrubukanwarganegara.permohonan.edit',$id) }}" class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i> Kemaskini</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="kru" role="tabpanel" aria-labelledby="kru-tab">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                            <label for="gate">Baki Kuota Kru Boleh Dipohon:</label>
                                            <input type="text" class="form-control" value="{{$vessel->totalForeignKruQuotaLeft()}}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 table-responsive">
                                            <div class="form-group">
                                                <label class="col-form-label">Senarai Kru:</label>
                                                <div class="float-right">
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="col-sm-12 table-responsive">
                                            <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                <th>Bil</th>
                                                <th>Nama Kru</th>
                                                <th>Warganegara</th>
                                                <th>Tarikh Lahir</th>
                                                <th>Jantina</th>
                                                <th>Nombor Pasport</th>
                                                <th>Tarikh Tamat Pasport</th>
                                                <th>Jawatan</th>
                                                <th>Status Keberadaan Kru</th>
                                                </tr>
                                            </thead>
                                            <tbody id="listKru">
                                                @php
                                                    $count = 0;
                                                @endphp
                                                @foreach ($foreignKrus as $foreignKru)
                                                    @php
                                                        $doc = App\Models\Kru\KruForeignDocument::where('kru_application_foreign_kru_id',$foreignKru->id)->where('description',$passportDocName)->latest()->first();
                                                    @endphp
                                                    <tr>
                                                        <td>{{++$count}}</td>
                                                        <td>{{$foreignKru->name}}</td>
                                                        <td>{{Helper::getCodeMasterNameById($foreignKru->source_country_id)}}</td>
                                                        <td>{{$foreignKru->birth_date->format('d/m/Y')}}</td>
                                                        <td>{{$foreignKru->gender_id != null ? Helper::getCodeMasterNameById($foreignKru->gender_id) : ''}}</td>
                                                        <td><a href="{{ route('kruhelper.previewKruForeignDoc', $doc->id) }}" target="_blank">{{$foreignKru->passport_number}}</a></td>
                                                        <td>{{$foreignKru->passport_end_date->format('d/m/Y')}}</td>
                                                        <td>{{$foreignKru->foreign_kru_position_id != null ? Helper::getCodeMasterNameById($foreignKru->foreign_kru_position_id) : ''}}</td>
                                                        <td>{{$foreignKru->crew_whereabout}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <br\>
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3">
                                            <a href="{{ route('kebenaranpenggunaankrubukanwarganegara.permohonan.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                            @if ($app->kru_application_status_id == $statusIncompleteId)
                                                <a href="{{ route('kebenaranpenggunaankrubukanwarganegara.permohonan.edit',$id) }}" class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i> Kemaskini</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="document" role="tabpanel" aria-labelledby="document-tab">
                                    <div class="row">
                                        <div class="col-sm-12 table-responsive">
                                            <div class="form-group">
                                                <label class="col-form-label">Senarai Dokumen:</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width:1%;">Bil</th>
                                                        <th>Tarikh Dicipta</th>
                                                        <th>Dokumen</th>
                                                        <th>Tindakan Oleh</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="listDoc">
                                                    @if (!$docs->isEmpty())
                                                        @php
                                                            $count = 0;
                                                        @endphp
                                                        @foreach ($docs as $doc)
                                                            <tr>
                                                                <td>{{++$count}}</td>
                                                                <td>{{$doc->created_at->format('d/m/Y h:i:s A')}}</td>
                                                                <td><a href="{{ route('kruhelper.previewDoc', $doc->id) }}" target="_blank">{{$doc->description}}</a></td>
                                                                <td>{{strtoupper(Helper::getUsersNameById($doc->created_by))}}</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="5" style="text-align: center;">-Tiada Dokumen-</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <br\>
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3">
                                            <a href="{{ route('kebenaranpenggunaankrubukanwarganegara.permohonan.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                            @if ($app->kru_application_status_id == $statusIncompleteId)
                                                <a href="{{ route('kebenaranpenggunaankrubukanwarganegara.permohonan.edit',$id) }}" class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i> Kemaskini</a>
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
                                            <a href="{{ route('kebenaranpenggunaankrubukanwarganegara.permohonan.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                            @if ($app->kru_application_status_id == $statusIncompleteId)
                                                <a href="{{ route('kebenaranpenggunaankrubukanwarganegara.permohonan.edit',$id) }}" class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i> Kemaskini</a>
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
