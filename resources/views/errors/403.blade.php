@extends('layouts.app')

@section('title', 'Unauthorized')

@section('content')
<div class="container text-center" style="margin-top: 100px;">
    <h1 class="display-1 text-danger">403</h1>
    <h2 class="mb-4">Akses Tidak Dibenarkan</h2>
    <p class="lead mb-4">Maaf, anda tidak mempunyai kebenaran untuk mengakses halaman ini.</p>
    <a href="/" class="btn btn-primary">Kembali ke Laman Utama</a>
</div>
@endsection 