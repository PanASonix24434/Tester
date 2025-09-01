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
                            <h3 class="mb-0">Profil Kru</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-right">
                            <!-- Breadcrumb -->
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('crewvessel.index') }}">Kru</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Profil Kru</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h4 style="color:white;">Profil Kru </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="text-center">
                                        <label class="form-label">{{ $nelayan->name }}</label>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label class="form-label">Vesel : </label>
                                        <input class="form-control" value="{{ $nelayan->vessel_id != null ? App\Models\Vessel::withTrashed()->find($nelayan->vessel_id)->no_pendaftaran : '' }}" disabled/>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Jawatan : </label>
                                        <input class="form-control" value="{{ $nelayan->kru_position_id != null ? App\Models\Codemaster::withTrashed()->find($nelayan->kru_position_id)->name_ms : '' }}" disabled/>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">No. Kad Pengenalan : </label>
                                        <input class="form-control" value="{{ $nelayan->ic_number }}" disabled/>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Tarikh Tamat : </label>
                                        <input class="form-control" value="{{ optional($nelayan->registration_end)->format('d/m/Y') }}" disabled/>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="application-tab" data-bs-toggle="tab" href="#application" role="tab"
                                    aria-controls="application" aria-selected="true">Maklumat Kru</a>
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
                            </ul>
                            <div class="tab-content p-4" id="tabContent">
                                <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application-tab">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">Bangsa : </label>
                                                <input class="form-control" value="{{ $nelayan->race_id != null ? App\Models\Codemaster::withTrashed()->find($nelayan->race_id)->name_ms : '' }}" disabled/>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Status Kewarganegaraan : </label>
                                                <input class="form-control" value="{{ $nelayan->kewarganegaraan_status_id != null ? App\Models\Codemaster::withTrashed()->find($nelayan->kewarganegaraan_status_id)->name_ms : '' }}" disabled/>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">Bumiputera : </label>
                                                <input class="form-control" value="{{ $nelayan->bumiputera_status_id != null ? App\Models\Codemaster::withTrashed()->find($nelayan->bumiputera_status_id)->name_ms : '' }}" disabled/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">Alamat : </label>
                                                <input type="text" class="form-control" style="text-transform: uppercase" value="{{ $nelayan->address1 }}" disabled />
                                                <input type="text" class="form-control" style="text-transform: uppercase" value="{{ $nelayan->address2 }}" disabled/>
                                                <input type="text" class="form-control" style="text-transform: uppercase" value="{{ $nelayan->address3 }}" disabled/>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Poskod : </label>
                                                <input type="number" class="form-control" value="{{ $nelayan->postcode }}" disabled/>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Bandar : </label>
                                                <input type="text" class="form-control" style="text-transform: uppercase" value="{{ $nelayan->city }}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">Daerah : </label>
                                                <input type="text" class="form-control" value="{{ Helper::getCodeMasterNameById($nelayan->district_id) }}" disabled/>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Negeri : </label>
                                                <input type="text" class="form-control" value="{{ Helper::getCodeMasterNameById($nelayan->state_id) }}" disabled/>
                                            </div>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">Parlimen : </label>
                                                <input type="text" class="form-control" value="{{ $nelayan->parliament_id != null ? App\Models\Parliament::withTrashed()->find($nelayan->parliament_id)->parliament_name : '' }}" disabled/>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">Dun : </label>
                                                <input type="text" class="form-control" value="{{ $nelayan->parliament_seat_id != null ? App\Models\ParliamentSeat::withTrashed()->find($nelayan->parliament_seat_id)->parliament_seat_name : '' }}" disabled/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="mobilePhoneNumber" class="form-label">Nombor Telefon Bimbit : </label>
                                                <div class="input-group has-validation">
                                                    <span class="input-group-text" id="inputGroupPrepend">+60</span>
                                                    <input type="number" class="form-control" value="{{ $nelayan->mobile_contact_number }}"
                                                    aria-describedby="inputGroupPrepend" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Emel : </label>
                                                <input type="email" class="form-control" disabled value="{{ $nelayan->email }}"/>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="homePhoneNumber" class="form-label">Nombor Telefon Rumah : </label>
                                                <div class="input-group has-validation">
                                                    <span class="input-group-text" id="inputGroupPrepend">+60</span>
                                                    <input type="number" class="form-control" value="{{ $nelayan->home_contact_number }}"
                                                    aria-describedby="inputGroupPrepend" disabled>
                                                </div>
                                            </div>
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
                                                                <td>{{-- ++$count --}}</td>
                                                                <td>{{-- $doc->created_at->format('d/m/Y h:i:s A') --}}</td>
                                                                <td><a href="{{-- route('kruhelper.previewKruDoc', $doc->id) --}}" target="_blank">{{-- $doc->description --}}</a></td>
                                                                <td>{{-- strtoupper(Helper::getUsersNameById($doc->created_by)) --}}</td>
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
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-lg-center">
                                    <a href="{{ route('crewvessel.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                    @if (true) <!-- $app->kru_application_status_id == $statusIncompleteId -->
                                        {{--<a href="{{ route('kadpendaftarannelayan.permohonan.edit',$id) }}" class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i> Kemaskini</a>--}}
                                    @endif
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

        var msg = '{{-- Session::get('alert') --}}';
        var exist = '{{-- Session::has('alert') --}}';
        if(exist){
            alert(msg);
        }

        //Peranan tidak dipilih
        var msg2 = '{{-- Session::get('alert2') --}}';
        var exist2 = '{{-- Session::has('alert2') --}}';
        if(exist2){
            alert(msg2);
        }

    </script>
@endpush
