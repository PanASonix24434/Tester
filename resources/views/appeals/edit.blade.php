@extends('layouts.app')

@section('content')
<div id="app-content">
    <div class="app-content-area">
        <div class="container">
            <h3>Edit & Resubmit Permohonan</h3>
            <form method="POST" action="{{ route('appeals.update', $appeal->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="justifikasi_pindaan" class="form-label">Justifikasi Pindaan</label>
                    <textarea name="justifikasi_pindaan" id="justifikasi_pindaan" class="form-control" required>{{ old('justifikasi_pindaan', $perakuan->justifikasi_pindaan ?? '') }}</textarea>
                    @error('justifikasi_pindaan')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <input type="hidden" id="jenis_pindaan_syarat" name="jenis_pindaan_syarat" value="{{ $perakuan->jenis_pindaan_syarat }}">
                <input type="hidden" id="jenis_perolehan" name="jenis_perolehan" value="{{ $perakuan->jenis_perolehan }}">
                <input type="hidden" id="jenis_bahan_binaan_vesel" name="jenis_bahan_binaan_vesel" value="{{ $perakuan->jenis_bahan_binaan_vesel }}">
                @include('appeals.partials.dokumen_pemohon')
                <button type="submit" class="btn btn-primary">Hantar Semula</button>
                <a href="{{ route('appeals.status', $appeal->id) }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection 