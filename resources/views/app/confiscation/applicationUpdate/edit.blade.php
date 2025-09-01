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
                <form method="POST" enctype="multipart/form-data" action="{{ route('confiscation.update-application.update', $confiscation->id) }}">
                    @csrf
                    <div class="row d-flex align-items-stretch">
                        <!-- Profile -->
                        <div class="col-md-4 d-flex">
                            <div class="card flex-fill">
                                <div class="card-body text-center">
                                    <img src="{{ asset('images/avatar.png') }}" class="img-fluid rounded-circle mb-3" width="100" alt="User">
                                    <h4 class="mb-1">Nama: {{$confiscation->fullname}}</h4>
                                    <p class="text-muted">No KP: {{$confiscation->icno}}</p>
                                    
                                    <div class="text-left">
                                        <p><strong>No Fail:</strong> <a>{{$confiscation->registration_no}}</a></p>
                                        <p><strong>No Akaun:</strong> <a>{{$confiscation->no_account}}</a></p>
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
                                    <form action="{" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label>Keputusan:<span style="color: red;">*</span></label>
                                            <div>
                                                <input type="checkbox" id="keputusan" name="keputusan" value="Ya" required>
                                                <label for="keputusan">Pembatalan Akaun</label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="selReason">Sebab Pelucutan Hak : <span style="color:red;">*</span></label>
                                            <select class="form-select select2" id="selReason" name="selReason" autocomplete="off" width="100%" required>
                                                <option value="">{{ __('app.please_select')}}</option>
                                                @foreach ($reasons as $r)
                                                    <option value="{{$r->id}}">{{ $r->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Dokumen Sokongan : <span style="color:red;">*</span></label>
                                            <div class="input-group">
                                                {{--
                                                @if ( $docSalesReceipt != null)
                                                    <a href="{{ route('landinghelper.previewDoc', $docSalesReceipt->id) }}" target="_blank">{{$docSalesReceipt->file_name}}</a>&nbsp;
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="event.preventDefault(); if (confirm('Hapus Dokumen?')) {
                                                                document.getElementById('delete-link-form-{{ $docSalesReceipt->id }}').submit();
                                                            }">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @else
                                                --}}
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="doc" name="doc" required>
                                                        <label class="custom-file-label" for="doc">Pilih Fail</label>
                                                    </div>
                                                    {{--
                                                @endif--}}
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
                                            <label for="ulasan">Ulasan</label><span style="color: red;">*</span>
                                            <textarea class="form-control" id="txtUlasan" name="txtUlasan" rows="3" placeholder="Masukkan ulasan..." required></textarea>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('confiscation.update-application.index') }}" class="btn btn-warning">
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
@push('scripts')
<script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script type="text/javascript">
       bsCustomFileInput.init();
</script>   
@endpush
