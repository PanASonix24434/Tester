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
                                <li class="breadcrumb-item"><a href="{{ route('kadpendaftarannelayan.sokongandaerah.index') }}">Permohonan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)</a></li>
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
                                        <label>Pemohon</label>
                                        <input type="text" class="form-control" value="{{ $applicant->name }}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>No. Kad Pengenalan</label>
                                        <input type="text" class="form-control" value="{{ $applicant->username }}" disabled>
                                    </div>
                                </div>
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
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Tarikh Permohonan</label>
                                        <input type="text" class="form-control" value="{{  $app->submitted_at!=null ? $app->submitted_at->format('d/m/Y h:i:s A') : '' }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active disabled" id="application-tab" data-bs-toggle="tab" href="#application" role="tab"
                                    aria-controls="application" aria-selected="true">Maklumat Permohonan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link disabled" id="address-tab" data-bs-toggle="tab" href="#address" role="tab"
                                    aria-controls="address" aria-selected="false">Alamat Kru</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link disabled" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab"
                                    aria-controls="contact" aria-selected="false">Maklumat Perhubungan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link disabled" id="document-tab" data-bs-toggle="tab" href="#document" role="tab"
                                    aria-controls="document" aria-selected="false">Maklumat Dokumen</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link disabled" id="log-tab" data-bs-toggle="tab" href="#log" role="tab"
                                    aria-controls="log" aria-selected="false">Status Permohonan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link disabled" id="action-tab" data-bs-toggle="tab" href="#action" role="tab"
                                    aria-controls="action" aria-selected="false">Tindakan</a>
                                </li>
                            </ul>
                            <div class="tab-content p-4" id="tabContent">
                                <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application-tab">
                                    <div class="row">
                                        <!-- AppType -->
                                        <div class="mb-6">
                                            <label class="form-label">Jenis Permohonan : </label>
                                            <input class="form-control" value="{{$app->application_type}}" disabled/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label">Vesel : </label>
                                                <input class="form-control" value="{{ $app->vessel_id != null ? App\Models\Vessel::withTrashed()->find($app->vessel_id)->no_pendaftaran : ''}}" disabled/>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label">Jawatan : </label>
                                                <input class="form-control" value="{{ $kru->kru_position_id != null ? App\Models\Codemaster::withTrashed()->find($kru->kru_position_id)->name_ms : ''}}" disabled/>
                                            </div>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label">No. Kad Pengenalan : </label>
                                                <input class="form-control" value="{{$kru->ic_number}}" disabled/>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Bangsa : </label>
                                                <input class="form-control" value="{{ $kru->race_id != null ? App\Models\Codemaster::withTrashed()->find($kru->race_id)->name_ms : ''}}" disabled/>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Status Kewarganegaraan : </label>
                                                <input class="form-control" value="{{ $kru->kewarganegaraan_status_id != null ? App\Models\Codemaster::withTrashed()->find($kru->kewarganegaraan_status_id)->name_ms : ''}}" disabled/>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label">Nama : </label>
                                                <input class="form-control" value="{{$kru->name}}" disabled />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Bumiputera : </label>
                                                <input class="form-control" value="{{ $kru->bumiputera_status_id != null ? App\Models\Codemaster::withTrashed()->find($kru->bumiputera_status_id)->name_ms : ''}}" disabled/>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 text-lg-center mt-3">
                                            <a href="{{ route('kadpendaftarannelayan.sokongandaerah.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                            <button class="btn btn-info btn-sm next-tab-btn" data-next-tab="address-tab"><i class="fas fa-arrow-right"></i> Seterusnya</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                                    <div class="row">
                                        <div class="col-6">
                                            <!-- Address -->
                                            <div class="mb-3">
                                                <label class="form-label">Alamat : </label>
                                                <input type="text" class="form-control" style="text-transform: uppercase" value="{{$kru->address1}}" disabled />
                                                <input type="text" class="form-control" style="text-transform: uppercase" value="{{$kru->address2}}" disabled/>
                                                <input type="text" class="form-control" style="text-transform: uppercase" value="{{$kru->address3}}" disabled/>
                                            </div>
                                            <!-- Postcode -->
                                            <div class="mb-3">
                                                <label class="form-label">Poskod : </label>
                                                <input type="number" class="form-control" value="{{$kru->postcode}}" disabled/>
                                            </div>
                                            <!-- City -->
                                            <div class="mb-3">
                                                <label class="form-label">Bandar : </label>
                                                <input type="text" class="form-control" style="text-transform: uppercase" value="{{$kru->city}}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <!-- Daerah -->
                                                <label class="form-label">Daerah : </label>
                                                <input type="text" class="form-control" value="{{Helper::getCodeMasterNameById($kru->district_id)}}" disabled/>
                                            <!-- Negeri -->
                                            <div class="mb-3">
                                                <label class="form-label">Negeri : </label>
                                                <input type="text" class="form-control" value="{{Helper::getCodeMasterNameById($kru->state_id)}}" disabled/>
                                            </div>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label">Parlimen : </label>
                                                <input type="text" class="form-control" value="{{ $kru->parliament_id != null ? App\Models\Parliament::withTrashed()->find($kru->parliament_id)->parliament_name : ''}}" disabled/>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label">Dun : </label>
                                                <input type="text" class="form-control" value="{{ $kru->parliament_seat_id != null ? App\Models\ParliamentSeat::withTrashed()->find($kru->parliament_seat_id)->parliament_seat_name : ''}}" disabled/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3">
                                            <button class="btn btn-info btn-sm next-tab-btn" data-next-tab="application-tab"><i class="fas fa-arrow-left"></i> Kembali</button>
                                            <button class="btn btn-info btn-sm next-tab-btn" data-next-tab="contact-tab"><i class="fas fa-arrow-right"></i> Seterusnya</button>
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
                                                    <input type="number" class="form-control" value="{{$kru->mobile_contact_number}}"
                                                    aria-describedby="inputGroupPrepend" disabled>
                                                </div>
                                            </div>
                                            <!-- Email -->
                                            <div class="mb-3">
                                                <label class="form-label">Emel : </label>
                                                <input type="email" class="form-control" disabled value="{{$kru->email}}"/>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <!-- Mobile Phone No -->
                                            <div class="mb-3">
                                                <label for="homePhoneNumber" class="form-label">Nombor Telefon Rumah : </label>
                                                <div class="input-group has-validation">
                                                    <span class="input-group-text" id="inputGroupPrepend">+60</span>
                                                    <input type="number" class="form-control" value="{{$kru->home_contact_number}}"
                                                    aria-describedby="inputGroupPrepend" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                            <button class="btn btn-info btn-sm next-tab-btn" data-next-tab="address-tab"><i class="fas fa-arrow-left"></i> Kembali</button>
                                            <button class="btn btn-info btn-sm next-tab-btn" data-next-tab="document-tab"><i class="fas fa-arrow-right"></i> Seterusnya</button>
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
                                                                <td><a href="{{ route('kruhelper.previewKruDoc', $doc->id) }}" target="_blank">{{$doc->description}}</a></td>
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
                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                            <button class="btn btn-info btn-sm next-tab-btn" data-next-tab="contact-tab"><i class="fas fa-arrow-left"></i> Kembali</button>
                                            <button class="btn btn-info btn-sm next-tab-btn" data-next-tab="log-tab"><i class="fas fa-arrow-right"></i> Seterusnya</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="log" role="tabpanel" aria-labelledby="log-tab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- The time line -->
                                            <div class="timeline">
                                                @if (!$logs->isEmpty())
                                                    @php
                                                        $count=0;
                                                        $date=0;
                                                    @endphp
                                                    @foreach ($logs as $log)
                                                        @php
                                                            $count++;
                                                            $userlog = App\Models\User::find($log->created_by);
                                                            $roles = $userlog->roles;
                                                        @endphp
                                                        @if ($log->updated_at->format('d/m/Y') > $date)
                                                            @php
                                                                $date = $log->updated_at->format('d/m/Y');
                                                            @endphp
                                                            <div class="time-label">
                                                                <span class="bg-white">{{$log->updated_at->format('d/m/Y')}}</span>
                                                            </div>
                                                        @endif
                                                        
                                                        <!-- Timeline Item 2 -->
                                                        <div>
                                                            <div class="timeline-item">
                                                            <span class="time"><i class="fas fa-clock"></i> {{$log->updated_at->format('h:i:s A')}}</span>
                                                            
                                                            <!-- Status and Ulasan at the top -->
                                                            <h3 class="timeline-header" style="color: black; font-weight: bold; border-bottom: 1px solid #D3D3D3; font-size: 100%; padding-top: 1%; padding-bottom: 1%;">
                                                                Status&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                                                @if ($redStatusIds->contains('id',$log->kru_application_status_id))
                                                                    <span class="badge bg-danger">{{Helper::getCodeMasterNameById($log->kru_application_status_id)}}</span>
                                                                @elseif ($orangeStatusIds->contains('id',$log->kru_application_status_id))
                                                                    <span class="badge bg-warning">{{Helper::getCodeMasterNameById($log->kru_application_status_id)}}</span>
                                                                @else
                                                                    <span class="badge bg-success">{{Helper::getCodeMasterNameById($log->kru_application_status_id)}}</span>
                                                                @endif
                                                            </h3>
                                                            
                                                            <h3 class="timeline-header" style="color: black; font-weight: bold; border-bottom: 1px solid #D3D3D3; font-size: 100%; padding-top: 1%; padding-bottom: 1%;">
                                                                Ulasan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                                                <br><br>
                                                                <span style="color: black; font-weight: normal; text-align: justify; line-height: 1.6; font-size: 105%;">
                                                                    {{$log->remark}}
                                                                </span>
                                                            </h3>
                                                        
                                                            <!-- Hidden Nama and Peranan section -->
                                                            <div id="{{'details'.$count}}" style="display: none;">
                                                            <h3 class="timeline-header" style="color: black; font-weight: bold; border-bottom: 1px solid #D3D3D3; font-size: 100%; padding-top: 1%; padding-bottom: 1%;">
                                                                &nbsp;&nbsp;&nbsp;Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <a href="#" 
                                                                style="color: black; font-weight: normal;" 
                                                                onmouseover="this.style.color='blue';" 
                                                                onmouseout="this.style.color='black';">
                                                                {{$log->name}}
                                                                </a>
                                                            </h3>
                                                            
                                                            <h3 class="timeline-header" style="color: black; font-weight: bold; border-bottom: 1px solid #D3D3D3; font-size: 100%; padding-top: 1%; padding-bottom: 1%;">
                                                                &nbsp;&nbsp;&nbsp;Peranan&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                                                <a href="#" 
                                                                style="color: black; font-weight: normal;" >{{$userlog->roles->sortBy('name')->pluck('name')->implode(', ')}}
                                                            </a>
                                                            </h3>
                                                            </div>
                                                        
                                                            <div style="text-align: right;">
                                                            <button onclick="toggleDetails('{{'details'.$count}}', this)" class="btn btn-link" style="text-decoration: none;">
                                                                <i class="fas fa-angle-down"></i>
                                                            </button>
                                                            </div>
                                                            
                                                            </div>
                                                        </div>
                                                        <!-- /.timeline-label -->
                                                    @endforeach
                                                    
                                                @endif
                                                <!-- timeline item -->
                                                <div>
                                                    <i class="fas fa-clock bg-gray"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br\>
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3">
                                            <button class="btn btn-info btn-sm next-tab-btn" data-next-tab="document-tab"><i class="fas fa-arrow-left"></i> Kembali</button>
                                            <button class="btn btn-info btn-sm next-tab-btn" data-next-tab="action-tab"><i class="fas fa-arrow-right"></i> Seterusnya</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="action" role="tabpanel" aria-labelledby="action-tab">
                                    <!-- <h6 class="section-title" style="font-weight: bold; color: #1070d5; border-bottom: 2px solid #1070d5; padding-bottom: 5px; margin-bottom: 0%;">Maklumat Penting</h6> -->
                                    <!-- <br> -->
                                    @php
                                        $pkndoc = $docs->where('description',App\Models\Kru\KruDocument::DOC_PKN)->first();
                                    @endphp
                                    <!-- <div>1. Dokumen Pemeriksaan Kesihatan Nelayan : @if ($pkndoc != null) <a href="{{ route('kruhelper.previewKruDoc', $pkndoc->id) }}" target="_blank">{{$pkndoc->description}}</a> @else '-Tiada Dokumen-' @endif</div> -->
                                    <br>
                                    <h6 class="section-title" style="font-weight: bold; color: #1070d5; border-bottom: 2px solid #1070d5; padding-bottom: 5px; margin-bottom: 0%;">Sokongan Permohonan</h6>
                                    <form id="form" method="POST" action="{{ route('kadpendaftarannelayan.sokongandaerah.update',$id) }}">
                                        @csrf
                                        <div class="card-body">
                                            <label style="margin-top: 0;">Maklumat dan Dokumen Permohonan :</label>
                                            <div class="form-group">
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" id="radio" name="applicationStatus" value="supported" {{$savedLog!=null ? ($savedLog->supported === true ? 'checked' : '') : ''}} required>
                                                    <label for="radio" class="custom-control-label" style="font-weight: normal;">Sokong</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" id="radio2" name="applicationStatus" value="notsupported" {{$savedLog!=null ? ($savedLog->supported === false ? 'checked' : '') : ''}}>
                                                    <label for="radio2" class="custom-control-label" style="font-weight: normal;">Tidak Sokong</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" id="radio3" name="applicationStatus" value="incomplete" {{$savedLog!=null ? ($savedLog->completed === false ? 'checked' : '') : ''}}>
                                                    <label for="radio3" class="custom-control-label" style="font-weight: normal;">Tidak Lengkap</label>
                                                </div>
                                            </div>
                                            <div id="lengkap" class="{{$savedLog!=null ? ($savedLog->completed ? '' : 'hidden') : 'hidden'}}" >
                                                <div class="form-group">
                                                    <label>Kesihatan Kru: @if ($pkndoc != null) <a href="{{ route('kruhelper.previewKruDoc', $pkndoc->id) }}" target="_blank">{{$pkndoc->description}}</a> @else '-Tiada Dokumen-' @endif</label>
                                                    <select class="form-control select2" id="kruHealth" name="kruHealth" style="width: 100%;" required>
                                                        <option selected="selected" value="">-Sila Pilih-</option>
                                                        @foreach ($kruHealths as $kruHealth)
                                                            <option value="{{$kruHealth->id}}" {{$kru->kru_health_id==$kruHealth->id ? 'selected' : ''}}>{{$kruHealth->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="remark">Ulasan</label>
                                                <textarea id="remark" name="remark" class="form-control" rows="4">{{$savedLog!=null ? $savedLog->remark : ''}}</textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 text-lg-center mt-3">
                                                <a class="btn btn-info btn-sm next-tab-btn" data-next-tab="log-tab"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                <button type="submit" name="action" value="save" class="btn btn-secondary btn-sm" onclick="return confirm($('<span>Simpan Maklumat?</span>').text())">
                                                    <i class="fas fa-save"></i> Simpan
                                                </button>
                                                <button id="btnSubmit" type="submit" name="action" value="submit" disabled class="btn btn-primary btn-sm" onclick="return confirm($('<span>Hantar Permohonan?</span>').text())">
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
    <script type="text/javascript">
        const nextTabButtons = document.querySelectorAll('.next-tab-btn');
        const tabList = document.getElementById('myTab');

        nextTabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const nextTabId = this.dataset.nextTab;
                const nextTabTrigger = tabList.querySelector(`#${nextTabId}`);

                if (nextTabTrigger) {
                const nextTabBootstrap = bootstrap.Tab.getOrCreateInstance(nextTabTrigger);
                nextTabBootstrap.show();
                }
            });
        });

        $(document).ready(function () {
            
            $('#btnSubmit').prop("disabled",true);
            
            $('input[type=radio][name=applicationStatus]').change(function() {
                $('#btnSubmit').prop("disabled",false);
                if ($(this).val()=='supported') {
                    $('#remark').prop("required",false);
                }else if ($(this).val()=='notsupported' || $(this).val()=='incomplete'){
                    $('#remark').prop("required",true);
                }
                
                if ($(this).val()=='supported' || $(this).val()=='notsupported') {
                    $('#lengkap').removeClass('hidden');
                }else if ( $(this).val()=='incomplete'){
                    $('#lengkap').addClass('hidden');
                }
            });

        });
  
        function toggleDetails(detailsId, button) {
            var details = document.getElementById(detailsId);
            if (details.style.display === "none") {
            details.style.display = "block";
            button.innerHTML = '<i class="fas fa-angle-up"></i>';
            } else {
            details.style.display = "none";
            button.innerHTML = '<i class="fas fa-angle-down"></i>';
            }
        }

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
