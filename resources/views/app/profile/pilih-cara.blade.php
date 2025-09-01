@extends('layouts.app')

@section('content')

<!-- Page Content -->
<div id="app-content">

<!-- Container fluid -->
<div class="app-content-area">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <!-- Page header -->
            <div class="mb-8">
                <h3 class="mb-0"></h3>
            </div>
        </div>
        <div class="col-md-4">
        </div>
    </div>

    <div class="container">
        <h3>Pilih Kaedah Isi Maklumat Pendaratan</h3>

        <p>Sila pilih kaedah:</p>
        
        <div style="margin-top: 20px;">
            <a href="{{ route('profile.formaddpendaratan', $vessel->id) }}" class="btn btn-primary">Isi Secara Manual</a>
            <a href="{{ route('profile.elogbook.redirect') }}" class="btn btn-secondary">Isi Secara Dalam Talian (e-Logbook)</a>
        </div>
    </div>
   
   
</div>
</div>
</div>

@endsection
