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
                                <li class="breadcrumb-item"><a href="{{ route('gantiankadpendaftarannelayan.permohonan.index') }}">Gantian Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)</a></li>
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
                                @if ($app->kru_application_status_id == $statusDilulusId)
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Nombor Pendaftaran</label>
                                            <input type="text" class="form-control" value="{{ $app->registration_number }}" disabled>
                                        </div>
                                    </div>
                                @endif
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
                                    <a class="nav-link" id="address-tab" data-bs-toggle="tab" href="#address" role="tab"
                                    aria-controls="address" aria-selected="false">Alamat Kru</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab"
                                    aria-controls="contact" aria-selected="false">Maklumat Perhubungan</a>
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
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label">Vesel : </label>
                                                <input type="text" class="form-control" value="{{$vesel->no_pendaftaran}}" disabled/>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label">Kru : </label>
                                                <input type="text" class="form-control" value="{{ $selectedKru->name}} ({{$selectedKru->ic_number}})" disabled/>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label">Sebab Penggantian Kad : </label>
                                                <input type="text" class="form-control" value="{{$app->application_type}}" disabled/>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 text-lg-center mt-3">
                                            <a href="{{ route('gantiankadpendaftarannelayan.permohonan.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                            @if ($app->kru_application_status_id == $statusIncompleteId)
                                                <a href="{{ route('gantiankadpendaftarannelayan.permohonan.edit',$id) }}" class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i> Kemaskini</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                                    <div class="row">
                                        <div class="col-6">
                                            <!-- Address -->
                                            <div class="mb-3">
                                                <label class="form-label">Alamat : </label>
                                                <input type="text" class="form-control" style="text-transform: uppercase" value="{{$selectedKru->address1}}" disabled />
                                                <input type="text" class="form-control" style="text-transform: uppercase" value="{{$selectedKru->address2}}" disabled/>
                                                <input type="text" class="form-control" style="text-transform: uppercase" value="{{$selectedKru->address3}}" disabled/>
                                            </div>
                                            <!-- Postcode -->
                                            <div class="mb-3">
                                                <label class="form-label">Poskod : </label>
                                                <input type="number" class="form-control" value="{{$selectedKru->postcode}}" disabled/>
                                            </div>
                                            <!-- City -->
                                            <div class="mb-3">
                                                <label class="form-label">Bandar : </label>
                                                <input type="text" class="form-control" style="text-transform: uppercase" value="{{$selectedKru->city}}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <!-- Daerah -->
                                                <label class="form-label">Daerah : </label>
                                                <input type="text" class="form-control" value="{{Helper::getCodeMasterNameById($selectedKru->district_id)}}" disabled/>
                                            <!-- Negeri -->
                                            <div class="mb-3">
                                                <label class="form-label">Negeri : </label>
                                                <input type="text" class="form-control" value="{{Helper::getCodeMasterNameById($selectedKru->state_id)}}" disabled/>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 text-lg-center mt-3">
                                            <a href="{{ route('gantiankadpendaftarannelayan.permohonan.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                            @if ($app->kru_application_status_id == $statusIncompleteId)
                                                <a href="{{ route('gantiankadpendaftarannelayan.permohonan.edit',$id) }}" class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i> Kemaskini</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                    <div class="row">
                                        <div class="col-6">
                                            <!-- Mobile Phone No -->
                                            <div class="mb-3">
                                                <label for="mobilePhoneNumber" class="form-label">Nombor Telefon Bimbit : </label>
                                                <div class="input-group has-validation">
                                                    <span class="input-group-text" id="inputGroupPrepend">+60</span>
                                                    <input type="number" class="form-control" value="{{$selectedKru->mobile_contact_number}}"
                                                    aria-describedby="inputGroupPrepend" disabled>
                                                </div>
                                            </div>
                                            <!-- Email -->
                                            <div class="mb-3">
                                                <label class="form-label">Emel : </label>
                                                <input type="email" class="form-control" disabled value="{{$selectedKru->email}}"/>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <!-- Mobile Phone No -->
                                            <div class="mb-3">
                                                <label for="homePhoneNumber" class="form-label">Nombor Telefon Rumah : </label>
                                                <div class="input-group has-validation">
                                                    <span class="input-group-text" id="inputGroupPrepend">+60</span>
                                                    <input type="number" class="form-control" value="{{$selectedKru->home_contact_number}}"
                                                    aria-describedby="inputGroupPrepend" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                            <a href="{{ route('gantiankadpendaftarannelayan.permohonan.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                            @if ($app->kru_application_status_id == $statusIncompleteId)
                                                <a href="{{ route('gantiankadpendaftarannelayan.permohonan.edit',$id) }}" class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i> Kemaskini</a>
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
                                                        <th>Keterangan</th>
                                                        <th>Dimasukkan Oleh</th>
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
                                                                <td><a href="{{ route('kruhelper.previewKruDoc', $doc->id) }}" target="_blank">{{$doc->file_name}}</a></td>
                                                                <td>{{$doc->description}}</td>
                                                                <td>{{strtoupper(Helper::getUsersNameById($doc->created_by))}}</td>
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
                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                            <a href="{{ route('gantiankadpendaftarannelayan.permohonan.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                            @if ($app->kru_application_status_id == $statusIncompleteId)
                                                <a href="{{ route('gantiankadpendaftarannelayan.permohonan.edit',$id) }}" class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i> Kemaskini</a>
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
                                            <a href="{{ route('gantiankadpendaftarannelayan.permohonan.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                            @if ($app->kru_application_status_id == $statusIncompleteId)
                                                <a href="{{ route('gantiankadpendaftarannelayan.permohonan.edit',$id) }}" class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i> Kemaskini</a>
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
