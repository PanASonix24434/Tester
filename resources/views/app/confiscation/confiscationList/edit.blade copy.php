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
                <form method="POST" enctype="multipart/form-data" action="{{ route('confiscation.support-application.update', $confiscation->id) }}">
                    @csrf
                    <div class="row">
                        <!-- Profile -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <img src="{{ asset('images/avatar.png') }}" class="img-fluid rounded-circle mb-3" width="100" alt="User">
                                    <h4 class="mb-1">Nama: {{$confiscation->fullname}}</h4>
                                    <p class="text-muted">No KP: {{$confiscation->icno}}</p>
                                    
                                    <div class="text-left">
                                        {{-- <p><strong>Umur:</strong> <a>{{$confiscation->registration_no}}</a></p> --}}
                                        <p><strong>No Pendaftaran:</strong> <a>{{$confiscation->registration_no}}</a></p>
                                        <p><strong>No Akaun:</strong> <a>{{$confiscation->no_account}}</a></p>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Form Section -->
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="mb-0">Pelucutan Hak ESHND</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label>Keputusan:</label>
                                            <div>
                                                <input type="radio" id="keputusan" name="keputusan" value="Ya" required>
                                                <label for="pembatalan">Disokong</label>
                                                <input type="radio" id="keputusan" name="keputusan" value="Tidak" style="margin-left:40%;"required>
                                                <label for="pembatalan">Tidak Disokong</label>
                                            </div>
                                            <div>
                                                
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="ulasan">Ulasan</label>
                                            <textarea class="form-control" id="txtUlasan" name="txtUlasan" rows="3" placeholder="Masukkan ulasan..."></textarea>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('confiscation.support-application.index') }}" class="btn btn-warning">
                                                <i class="fas fa-arrow-left"></i> Kembali
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save"></i> Kemaskini Status
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
