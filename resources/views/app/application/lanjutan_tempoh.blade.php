@extends('layouts.app')

@section('content')
<div id="app-content">
    <div class="app-content-area">
        <div class="container py-4">
            <div class="card shadow-sm">
                <div class="card-header" style="background-color: #3C2387; color: #fff; font-weight: 500;">
                    Permohonan
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ url('application/lanjutan-tempoh/perakuan') }}" enctype="multipart/form-data">
                        @csrf
                        <ul class="nav nav-tabs mb-4" id="lanjutanTab" role="tablist" style="border-bottom: 2px solid #0084ff;">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="butiran-tab" data-bs-toggle="tab" data-bs-target="#butiran" type="button" role="tab" aria-controls="butiran" aria-selected="true" style="color: #0084ff; font-weight: 500;">Butiran Permohonan</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="dokumen-tab" data-bs-toggle="tab" data-bs-target="#dokumen" type="button" role="tab" aria-controls="dokumen" aria-selected="false" style="color: #0084ff;">Dokumen Permohonan</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="perakuan-tab" data-bs-toggle="tab" data-bs-target="#perakuan" type="button" role="tab" aria-controls="perakuan" aria-selected="false" style="color: #0084ff;">Perakuan</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="lanjutanTabContent">
                            <div class="tab-pane fade show active" id="butiran" role="tabpanel" aria-labelledby="butiran-tab">
                                @include('app.application.partials.lanjutan_tempoh_butiran')
                            </div>
                            <div class="tab-pane fade" id="dokumen" role="tabpanel" aria-labelledby="dokumen-tab">
                                @include('app.application.partials.lanjutan_tempoh_dokumen')
                            </div>
                            <div class="tab-pane fade" id="perakuan" role="tabpanel" aria-labelledby="perakuan-tab">
                                @include('app.application.partials.lanjutan_tempoh_perakuan')
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @include('app.application.partials.lanjutan_tempoh_scripts')
@endpush 