@extends('layouts.app')

@section('content')
<div id="app-content">
    <div class="app-content-area">
        <div class="container py-5">
            <div class="card shadow-sm">
                <div class="card-header" style="background-color: #0084ff; color: #fff; font-weight: 500;">
                    Semakan Permohonan Lanjutan Tempoh
                </div>
                <div class="card-body">
                    <h5 class="mb-4">Sila semak maklumat permohonan anda sebelum dihantar:</h5>
                    <dl class="row mb-4">
                        <dt class="col-sm-4">Justifikasi Lanjutan Tempoh</dt>
                        <dd class="col-sm-8">{{ $perakuan->justifikasi_lanjutan_tempoh ?? '-' }}</dd>
                        <dt class="col-sm-4">Dokumen Sokongan</dt>
                        <dd class="col-sm-8">
                            @if($perakuan->dokumen_sokongan_path)
                                <a href="{{ asset('storage/' . $perakuan->dokumen_sokongan_path) }}" target="_blank">Muat turun dokumen</a>
                            @else
                                -
                            @endif
                        </dd>
                    </dl>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Kembali ke Laman Utama</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 