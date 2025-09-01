@extends('layouts.app')
@section('content')
<div id="app-content">
    <div class="app-content-area">
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <h3 class="mb-4">Ringkasan Permohonan</h3>
    <div class="card mb-4">
        <div class="card-header">Butiran Permohonan</div>
        <div class="card-body">
            @if($perakuan)
                <ul>
                    <li><strong>Jenis Pindaan Syarat:</strong> {{ $perakuan->jenis_pindaan_syarat ?? '-' }}</li>
                    @if($perakuan->jenis_bahan_binaan_vesel)
                        <li><strong>Jenis Bahan Binaan Vesel:</strong> {{ $perakuan->jenis_bahan_binaan_vesel }}</li>
                    @endif
                    @if($perakuan->nyatakan)
                        <li><strong>Nyatakan:</strong> {{ $perakuan->nyatakan }}</li>
                    @endif
                    @if($perakuan->jenis_perolehan)
                        <li><strong>Jenis Perolehan:</strong> {{ $perakuan->jenis_perolehan }}</li>
                    @endif
                    @if($perakuan->negeri_limbungan_baru)
                        <li><strong>Negeri Limbungan:</strong> {{ $perakuan->negeri_limbungan_baru }}</li>
                    @endif
                    @if($perakuan->nama_limbungan_baru)
                        <li><strong>Nama Limbungan:</strong> {{ $perakuan->nama_limbungan_baru }}</li>
                    @endif
                    @if($perakuan->daerah_baru)
                        <li><strong>Daerah:</strong> {{ $perakuan->daerah_baru }}</li>
                    @endif
                    @if($perakuan->alamat_baru)
                        <li><strong>Alamat Limbungan:</strong> {{ $perakuan->alamat_baru }}</li>
                    @endif
                    @if($perakuan->poskod_baru)
                        <li><strong>Poskod:</strong> {{ $perakuan->poskod_baru }}</li>
                    @endif
                    @if($perakuan->pernah_berdaftar)
                        <li><strong>Pernah Berdaftar:</strong> {{ $perakuan->pernah_berdaftar }}</li>
                    @endif
                    @if($perakuan->no_pendaftaran_vesel)
                        <li><strong>No Pendaftaran Vesel:</strong> {{ $perakuan->no_pendaftaran_vesel }}</li>
                    @endif
                    @if($perakuan->negeri_asal_vesel)
                        <li><strong>Negeri Asal Vesel:</strong> {{ $perakuan->negeri_asal_vesel }}</li>
                    @endif
                    @if($perakuan->pelabuhan_pangkalan)
                        <li><strong>Pelabuhan/Pangkalan:</strong> {{ $perakuan->pelabuhan_pangkalan }}</li>
                    @endif
                    @if($perakuan->pangkalan_asal)
                        <li><strong>Pangkalan Asal:</strong> {{ $perakuan->pangkalan_asal }}</li>
                    @endif
                    @if($perakuan->pangkalan_baru)
                        <li><strong>Pangkalan Baru:</strong> {{ $perakuan->pangkalan_baru }}</li>
                    @endif
                    @if($perakuan->justifikasi_pindaan)
                        <li><strong>Justifikasi Pindaan Syarat:</strong> {{ $perakuan->justifikasi_pindaan }}</li>
                    @endif
                </ul>
            @else
                <div class="alert alert-warning">Butiran permohonan tidak dijumpai.</div>
            @endif
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">Dokumen Permohonan</div>
        <div class="card-body">
            @if($dokumenSokongan && $dokumenSokongan->count() > 0)
                <ul>
                    @foreach($dokumenSokongan as $dokumen)
                        <li>
                            <strong>{{ ucfirst(str_replace('_', ' ', $dokumen->file_type)) }}:</strong> 
                            {{ $dokumen->file_name }}
                            <small class="text-muted">({{ $dokumen->getFileSizeInKB() }} KB)</small>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="alert alert-warning">Tiada dokumen dimuat naik.</div>
            @endif
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">Perakuan</div>
        <div class="card-body">
            @if($perakuan && $perakuan->perakuan)
                <span class="badge bg-success">Telah diperakui</span>
            @else
                <span class="badge bg-secondary">Tidak diperakui</span>
            @endif
        </div>
    </div>
    <a href="{{ route('dashboard') }}" class="btn btn-primary">Kembali ke Laman Utama</a>
</div>
</div>
</div>

@endsection 