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
                            <h3 class="mb-0">Pengesahan Bayaran</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-right">
                            <!-- Breadcrumb -->
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('pembaharuankadpendaftarannelayan.pengesahanbayaran.index') }}">Pembaharuan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Pengesahan Bayaran</li>
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
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="kru-tab" data-bs-toggle="tab" href="#kru" role="tab"
                                    aria-controls="kru" aria-selected="true">Maklumat Kru</a>
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
                                    <a class="nav-link" id="health-tab" data-bs-toggle="tab" href="#health" role="tab"
                                    aria-controls="health" aria-selected="false">Maklumat Kesihatan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="document-tab" data-bs-toggle="tab" href="#document" role="tab"
                                    aria-controls="document" aria-selected="false">Maklumat Dokumen</a>
                                </li>
                            </ul>
                            <div class="tab-content p-4" id="tabContent">
                                <div class="tab-pane fade show active" id="kru" role="tabpanel" aria-labelledby="kru-tab">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label">Vesel : </label>
                                                <input type="text" class="form-control" value="{{$vessel->vessel_number}}" disabled/>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label">No. Kad Pengenalan : </label>
                                                <input type="number" class="form-control" value="{{$appKru->ic_number}}" disabled/>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label">Nama : </label>
                                                <input type="text" class="form-control" value="{{$appKru->name}}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-lg-12 text-lg-center mt-3">
                                            <a href="{{ route('pembaharuankadpendaftarannelayan.pengesahanbayaran.show',$id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label">Alamat : </label>
                                                <input type="text" class="form-control" value="{{$appKru->address1}}" disabled />
                                                <input type="text" class="form-control" value="{{$appKru->address2}}" disabled />
                                                <input type="text" class="form-control" value="{{$appKru->address3}}" disabled />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Poskod : </label>
                                                <input type="number" class="form-control" value="{{$appKru->postcode}}" disabled />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Bandar : </label>
                                                <input type="text" class="form-control" value="{{$appKru->city}}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label">Daerah : </label>
                                                <input type="text" class="form-control" value="{{ $appKru->district_id != null ? App\Models\CodeMaster::find($appKru->district_id)->name : '' }}" disabled />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Negeri : </label>
                                                <input type="text" class="form-control" value="{{ $appKru->state_id != null ? App\Models\CodeMaster::find($appKru->state_id)->name : '' }}" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3">
                                            <a href="{{ route('pembaharuankadpendaftarannelayan.pengesahanbayaran.show',$id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label">Nombor Telefon Bimbit : </label>
                                                <div class="input-group has-validation">
                                                    <span class="input-group-text" >+60</span>
                                                    <input type="number" class="form-control" value="{{$appKru->mobile_contact_number}}"
                                                    aria-describedby="inputGroupPrepend" disabled>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Emel : </label>
                                                <input type="email" class="form-control" disabled value="{{$appKru->email}}"/>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label">Nombor Telefon Rumah : </label>
                                                <div class="input-group has-validation">
                                                    <span class="input-group-text" >+60</span>
                                                    <input type="number" class="form-control" value="{{$appKru->home_contact_number}}"
                                                    aria-describedby="inputGroupPrepend" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3">
                                            <a href="{{ route('pembaharuankadpendaftarannelayan.pengesahanbayaran.show',$id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="health" role="tabpanel" aria-labelledby="health-tab">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label">Perakuan Kesihatan : </label>
                                                <input type="text" class="form-control" value="{{$appKru->health_declaration}}" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3">
                                            <a href="{{ route('pembaharuankadpendaftarannelayan.pengesahanbayaran.show',$id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
                                                    @if (!$kruDocs->isEmpty())
                                                        @php
                                                            $count = 0;
                                                        @endphp
                                                        @foreach ($kruDocs as $kruDoc)
                                                            <tr>
                                                                <td>{{++$count}}</td>
                                                                <td>{{$kruDoc->created_at->format('d/m/Y h:i:s A')}}</td>
                                                                <td><a href="{{ route('kruhelper.downloadKruDoc', $kruDoc->id) }}">{{$kruDoc->file_name}}</a></td>
                                                                <td>{{$kruDoc->description}}</td>
                                                                <td>{{strtoupper(Helper::getUsersNameById($kruDoc->created_by))}}</td>
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
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3">
                                            <a href="{{ route('pembaharuankadpendaftarannelayan.pengesahanbayaran.show',$id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
