@extends('layouts.app')

@push('styles')
    <style type="text/css">
       
       
    </style>
@endpush

@section('content')
<div id="app-content">
    <div class="app-content-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <!-- Page header -->
                    <div class="mb-8">
                        <h3 class="mb-0">Lucut Hak Penerimaan Elaun Sara Hidup Nelayan Darat </h3>
                    </div>
                </div>
                <div class="col-md-4">
                </div>
            </div>
            <div>
                <form method="POST" enctype="multipart/form-data" action="{{ route('confiscation.name-list.update', $confiscation->id) }}">
                    @csrf
                    <div class="row d-flex align-items-stretch">
                        <!-- Profile -->
                        <div class="col-md-4 d-flex">
                            <div class="card flex-fill">
                                <div class="card-body text-center">
                                    <img src="{{ asset('images/avatar.png') }}" class="img-fluid rounded-circle mb-3" width="100" alt="User">
                                    <h4 class="mb-1">Nama: {{$confiscation->fullname}}</h4>
                                    <p class="text-muted">No KP: {{$confiscation->icno}}</p></br>
                                    
                                    <div class=" py-2 d-flex justify-content-between">
                                        <strong>No Fail</strong>
                                        <a href="#" class="text-primary">{{$confiscation->registration_no}}</a>
                                    </div>
                                    <div class="border-top py-2 d-flex justify-content-between">
                                        <strong>No Akaun</strong>
                                        <a href="#" class="text-primary">{{$confiscation->no_account}}</a>
                                    </div>
                            
                                </div>
                            </div>
                        </div>

                        <!-- Form Section -->
                        <div class="col-md-8 d-flex">
                            <div class="card flex-fill">
                                <div class="card-header">
                                    <h4 class="mb-0">Pelucutan Hak ESHND</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-label" for="selReason">Sebab Pelucutan Hak :</label>
                                        <select class="form-select select2" id="selReason" name="selReason" autocomplete="off" width="100%" disabled>
                                            <option value="">{{ __('app.please_select')}}</option>
                                            @foreach ($reasons as $r)
                                                <option value="{{$r->id}}" @if ($r->id == $confiscation->confiscation_reason_id ) selected @endif>{{ $r->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Dokumen Sokongan : </label>
                                        <div class="input-group">
                                            @if ( $document != null)
                                                <a href="{{ route('confiscation.helper.downloadDoc', $document->id) }}" target="_blank">{{$document->title}}</a>&nbsp;
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Pendaratan Terkini:</label>
                                        <div>
                                            @if ($latestLanding != null)
                                                @if ($month < 3)
                                                    <span style="color: green;">{{$latestLanding->year}} / {{$latestLanding->month}} (beza {{$month}} bulan)</span>
                                                @else
                                                    <span style="color: red;">{{$latestLanding->year}} / {{$latestLanding->month}} (beza {{$month}} bulan)</span>
                                                @endif
                                            @else
                                                <span style="color: red;">-Tiada Pendaratan-</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="ulasan">Ulasan FAD Daerah</label>
                                        <textarea class="form-control" id="txtUlasan" name="txtUlasan" rows="3" placeholder="Masukkan ulasan..." disabled>{{$confiscation->remark_lucut}}</textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="ulasan">Ulasan KDP (@if ($confiscation->support_lucut == 'Ya') <span style="color: green;">Disokong Daerah</span> @else <span style="color: red;">Tidak Disokong Daerah</span> @endif)</label>
                                        <textarea class="form-control" id="txtUlasan" name="txtUlasan" rows="3" placeholder="Masukkan ulasan..." disabled>{{$confiscation->remark_support}}</textarea>
                                    </div>

                                    <form action="{" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label>Keputusan: <span style="color: red;">*</span></label>
                                            <div>
                                                <input type="radio" id="lulus" name="keputusan" value="Ya" required>
                                                <label for="lulus">Lulus</label>
                                                <input type="radio" id="tidak_lulus" name="keputusan" value="Tidak" style="margin-left:40%;"required>
                                                <label for="tidak_lulus">Tidak Lulus</label>
                                            </div>
                                            <div>
                                                
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="ulasan">Ulasan</label>
                                            <textarea class="form-control" id="txtUlasan" name="txtUlasan" rows="3" placeholder="Masukkan ulasan..."></textarea>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('confiscation.name-list.index') }}" class="btn btn-warning">
                                                <i class="fas fa-arrow-left"></i> Kembali
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-paper-plane"></i> Simpan & Hantar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
     </div>
</div>
@endsection
