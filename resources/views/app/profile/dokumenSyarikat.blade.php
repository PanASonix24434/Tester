@extends('layouts.app')

@push('styles')
    <style type="text/css">
    </style>
@endpush

@section('content')
<form id="form-profile-update" method="POST" enctype="multipart/form-data" action="{{ route('profile.maklumatSyarikat') }}">
    @csrf
    <div id="app-content">

        <!-- Container fluid -->
        <div class="app-content-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <!-- Page header -->
                    <div class="mb-5">
                    <h3 class="">Profil Syarikat</h3>
                    </div>
                </div>
            </div>
            <div>
                <!-- row -->
                <div class="row">
                    <div class="col-10>
                        <!-- card -->
                        <div class="card mb-4">

                            <div class="card-body">
                            <div class="row">
          
                <!-- Single Column: Card with Form Inside -->
                <div class="col-lg-12">
                  <div class="card card-primary" style="outline: 2px solid lightgray;">
                    <div class="card-header" style="padding-bottom: 2px;">
                        <h6 style="color: white; font-size: 0.9rem;">
                                {{ $company->company_name ?? 'PROFIL SYARIKAT' }}
                        </h6>
                        </div>
                
                        <div class="card-body">
                        <ul class="nav nav-tabs" id="tabMenu" role="tablist">
                        <li class="nav-item">
                                    <a class="nav-link" id="maklumat-am-tab" data-bs-toggle="tab" onclick="redirectToPage('{{ route('profile.maklumatSyarikat', ['company_id' => $company->id]) }}')"  role="tab" aria-controls="maklumat-am" aria-selected="true">
                                        Butiran Am
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pendaftaran-tab" data-bs-toggle="tab" onclick="redirectToPage('{{ route('profile.pendaftaranPerniagaan', ['company_id' => $company->id]) }}')" role="tab" aria-controls="pendaftaran" aria-selected="false">
                                        Pendaftaran Perniagaan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pemegang-saham-tab" data-bs-toggle="tab" onclick="redirectToPage('{{ route('profile.pemilikanPentadbiran', ['company_id' => $company->id]) }}')" role="tab" aria-controls="pemegang-saham" aria-selected="false">
                                        Pemilikan & Pentadbiran
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="penglibatan-tab" data-bs-toggle="tab" onclick="redirectToPage('{{ route('profile.penglibatanSyarikat', ['company_id' => $company->id]) }}')" role="tab" aria-controls="penglibatan" aria-selected="false">
                                        Penglibatan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="butiran-kewangan-tab" data-bs-toggle="tab" onclick="redirectToPage('{{ route('profile.kewanganSyarikat', ['company_id' => $company->id]) }}')" role="tab" aria-controls="butiran-kewangan" aria-selected="false">
                                        Butiran Kewangan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" id="dokumen-tab" data-bs-toggle="tab" onclick="redirectToPage('{{ route('profile.dokumenSyarikat', ['company_id' => $company->id]) }}')" role="tab" aria-controls="dokumen" aria-selected="false">
                                        Dokumen
                                    </a>
                                </li>
                        </ul>
                        <br>

                                    <h6 class="section-title" style="font-weight: bold; font-size: 0.9rem; color: #1070d5; border-bottom: 2px solid #1070d5; padding-bottom: 5px; margin-bottom: 2%;">Dokumen Syarikat</h6>
                                     <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <table class="table table-bordered" style="border: 1px solid #D3D3D3; border-collapse: collapse; width: 100%;">
                                                <thead class="table-light" style="border: 1px solid #ddd;">
                                                        <tr>
                                                            <th style="border: 1px solid #D3D3D3; width: 5%; text-align: center;">Bil</th>
                                                            <th style="border: 1px solid #D3D3D3; width: 35%; font-weight: bold;">Nama Dokumen</th>
                                                            <th style="border: 1px solid #D3D3D3; width: 60%;">Dokumen Dimuatnaik</th>
                                                            <th style="border: 1px solid #D3D3D3; width: 5%;">Tindakan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <!-- <tr>
                                                        <td rowspan="2" style="border: 1px solid #D3D3D3; text-align: center;">1</td>
                                                        <td rowspan="2" style="border-right: none; border-top: 1px solid #D3D3D3; border-left: 1px solid #D3D3D3; border-bottom: 1px solid #D3D3D3; font-weight: bold;">
                                                            Salinan Profil Perniagaan (Enterprise)
                                                        </td>
                                                        <td style="border: 1px solid #D3D3D3;">
                                                            <label for="borang-e" style="font-weight: bold;">Borang E - Kaedah 13</label>
                                                            <div class="input-group">
                                                                <input type="text" id="borang-e" class="form-control" value="Borang E - Kaedah 13.pdf" style="border-top: 1px solid #ced4da; border-bottom: 1px solid #ced4da; border-left: 1px solid #ced4da; border-right: none;" readonly>
                                                                <div class="input-group-append">
                                                                    <button type="button" class="btn btn-light" style="background-color: #e9ecef; border-top: 1px solid #ced4da; border-bottom: 1px solid #ced4da; border-right: 1px solid #ced4da; border-left: none; color: rgb(4, 148, 4);">
                                                                        <i class="fas fa-check"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td style="border: 1px solid #D3D3D3;">
                                                            <div class="input-group" style="justify-content: center;">
                                                                <button type="button" class="btn btn-light">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid #D3D3D3;">
                                                            <label for="salinan-profil" style="font-weight: bold;">Salinan Profil Perniagaan</label>
                                                            <div class="input-group">
                                                                <input type="text" id="salinan-profil" class="form-control" value="Salinan Profil Perniagaan.pdf" style="border-top: 1px solid #ced4da; border-bottom: 1px solid #ced4da; border-left: 1px solid #ced4da; border-right: none;" readonly>
                                                                <div class="input-group-append">
                                                                    <button type="button" class="btn btn-light" style="background-color: #e9ecef; border-top: 1px solid #ced4da; border-bottom: 1px solid #ced4da; border-right: 1px solid #ced4da; border-left: none; color: rgb(4, 148, 4);">
                                                                        <i class="fas fa-check"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td style="border: 1px solid #D3D3D3;">
                                                            <div class="input-group" style="justify-content: center;">
                                                                <button type="button" class="btn btn-light">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr> -->
                                                    <tr>
                                                    <td rowspan="4" style="text-align: center;">1</td>
                                                    <td rowspan="4" style="font-weight: bold;">Salinan Profil Perniagaan (Syarikat)</td>
                                                    <td>
                                                        <label for="form-9" style="font-weight: bold;">Borang 9</label>
                                                        <div class="input-group">
                                                        <input type="text" id="form-9" class="form-control" value="AzharRaudah_Borang9.pdf" readonly>
                                                        <div class="input-group-append">
                                                                <button type="button" class="btn btn-light" style="background-color: #e9ecef; border-top: 1px solid #ced4da; border-bottom: 1px solid #ced4da; border-right: 1px solid #ced4da; border-left: none; color: rgb(4, 148, 4);">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                        </div>
                                                        </div>
                                                        <td style="border: 1px solid #D3D3D3;">
                                                        <div class="input-group" style="justify-content: center; margin-top: 17%;">
                                                                <button type="button" class="btn btn-light view-doc-btn" data-toggle="modal" data-target="#documentModal" data-file="AzharRaudah_Borang44.pdf">
                                                                <i class="fas fa-search"></i>
                                                                </button>
                                                        </div>
                                                        </td>
                                                    </td>
                                                    </tr>
                                                    <tr>
                                                    <td>
                                                        <label for="form-9" style="font-weight: bold;">Borang 24</label>
                                                        <div class="input-group">
                                                        <input type="text" id="form-24" class="form-control" value="AzharRaudah_Borang24.pdf" readonly>
                                                        <div class="input-group-append">
                                                                <button type="button" class="btn btn-light" style="background-color: #e9ecef; border-top: 1px solid #ced4da; border-bottom: 1px solid #ced4da; border-right: 1px solid #ced4da; border-left: none; color: rgb(4, 148, 4);">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                        </div>
                                                        </div>
                                                        <td style="border: 1px solid #D3D3D3;">
                                                        <div class="input-group" style="justify-content: center; margin-top: 17%;">
                                                                <button type="button" class="btn btn-light view-doc-btn" data-toggle="modal" data-target="#documentModal" data-file="AzharRaudah_Borang44.pdf">
                                                                <i class="fas fa-search"></i>
                                                                </button>
                                                        </div>
                                                        </td>
                                                    </td>
                                                    </tr>
                                                    <tr>
                                                    <td>
                                                        <label for="form-9" style="font-weight: bold;">Borang 44</label>
                                                        <div class="input-group">
                                                        <input type="text" id="form-44" class="form-control" value="AzharRaudah_Borang44.pdf" readonly>
                                                        <div class="input-group-append">
                                                                <button type="button" class="btn btn-light" style="background-color: #e9ecef; border-top: 1px solid #ced4da; border-bottom: 1px solid #ced4da; border-right: 1px solid #ced4da; border-left: none; color: rgb(4, 148, 4);">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                        </div>
                                                        </div>
                                                        <td style="border: 1px solid #D3D3D3;">
                                                        <div class="input-group" style="justify-content: center; margin-top: 17%;">
                                                                <button type="button" class="btn btn-light view-doc-btn" data-toggle="modal" data-target="#documentModal" data-file="AzharRaudah_Borang44.pdf">
                                                                <i class="fas fa-search"></i>
                                                                </button>
                                                        </div>
                                                        </td>
                                                    </td>
                                                    </tr>
                                                    <tr>
                                                    <td>
                                                        <label for="form-9" style="font-weight: bold;">Borang 49</label>
                                                        <div class="input-group">
                                                        <input type="text" id="form-49" class="form-control" value="AzharRaudah_Borang49.pdf" readonly>
                                                        <div class="input-group-append">
                                                                <button type="button" class="btn btn-light" style="background-color: #e9ecef; border-top: 1px solid #ced4da; border-bottom: 1px solid #ced4da; border-right: 1px solid #ced4da; border-left: none; color: rgb(4, 148, 4);">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                        </div>
                                                        </div>
                                                        <td style="border: 1px solid #D3D3D3;">
                                                        <div class="input-group" style="justify-content: center; margin-top: 17%;">
                                                                <button type="button" class="btn btn-light view-doc-btn" data-toggle="modal" data-target="#documentModal" data-file="AzharRaudah_Borang44.pdf">
                                                                <i class="fas fa-search"></i>
                                                                </button>
                                                        </div>
                                                        </td>
                                                    </td>
                                                    </tr>
                                                    <!--<tr>
                                                        <td rowspan="2" style="border: 1px solid #D3D3D3; text-align: center;">3</td>
                                                        <td rowspan="2" style="border-right: none; border-top: 1px solid #D3D3D3; border-left: 1px solid #D3D3D3; border-bottom: 1px solid #D3D3D3; font-weight: bold;">
                                                            Salinan Profil Perniagaan (Persatuan) 
                                                        </td>
                                                        <td style="border: 1px solid #D3D3D3;">
                                                            <label for="file1">Pendaftaran Persatuan </label>
                                                            <div class="input-group">
                                                                <input id="file1" type="text" class="form-control" value="Pendaftaran_Persatuan.pdf" style="border-top: 1px solid #ced4da; border-bottom: 1px solid #ced4da; border-left: 1px solid #ced4da; border-right: none;" readonly>
                                                                <div class="input-group-append">
                                                                    <button type="button" class="btn btn-light" style="background-color: #e9ecef; border-top: 1px solid #ced4da; border-bottom: 1px solid #ced4da; border-right: 1px solid #ced4da; border-left: none; color: rgb(4, 148, 4);">
                                                                        <i class="fas fa-check"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td style="border: 1px solid #D3D3D3;">
                                                            <div class="input-group" style="justify-content: center;">
                                                                <button type="button" class="btn btn-light">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid #D3D3D3;">
                                                            <label for="file2">Salinan Profil Perniagaan </label>
                                                            <div class="input-group">
                                                                <input id="file2" type="text" class="form-control" value="Salinan Profil Perniagaan.pdf" style="border-top: 1px solid #ced4da; border-bottom: 1px solid #ced4da; border-left: 1px solid #ced4da; border-right: none;" readonly>
                                                                <div class="input-group-append">
                                                                    <button type="button" class="btn btn-light" style="background-color: #e9ecef; border-top: 1px solid #ced4da; border-bottom: 1px solid #ced4da; border-right: 1px solid #ced4da; border-left: none; color: rgb(4, 148, 4);">
                                                                        <i class="fas fa-check"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td style="border: 1px solid #D3D3D3;">
                                                            <div class="input-group" style="justify-content: center;">
                                                                <button type="button" class="btn btn-light">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td rowspan="2" style="border: 1px solid #D3D3D3; text-align: center;">4</td>
                                                        <td rowspan="2" style="border-right: none; border-top: 1px solid #D3D3D3; border-left: 1px solid #D3D3D3; border-bottom: 1px solid #D3D3D3; font-weight: bold;">
                                                            Salinan Profil Perniagaan (Koperasi)
                                                        </td>
                                                        <td style="border: 1px solid #D3D3D3;">
                                                            <label for="file3">Pendaftaran Koperasi </label>
                                                            <div class="input-group">
                                                                <input id="file3" type="text" class="form-control" value="Pendaftaran_Koperasi.pdf" style="border-top: 1px solid #ced4da; border-bottom: 1px solid #ced4da; border-left: 1px solid #ced4da; border-right: none;" readonly>
                                                                <div class="input-group-append">
                                                                    <button type="button" class="btn btn-light" style="background-color: #e9ecef; border-top: 1px solid #ced4da; border-bottom: 1px solid #ced4da; border-right: 1px solid #ced4da; border-left: none; color: rgb(4, 148, 4);">
                                                                        <i class="fas fa-check"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td style="border: 1px solid #D3D3D3;">
                                                            <div class="input-group" style="justify-content: center;">
                                                                <button type="button" class="btn btn-light">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid #D3D3D3;">
                                                            <label for="file4">Salinan Profil Perniagaan </label>
                                                            <div class="input-group">
                                                                <input id="file4" type="text" class="form-control" value="Salinan Profil Perniagaan.pdf" style="border-top: 1px solid #ced4da; border-bottom: 1px solid #ced4da; border-left: 1px solid #ced4da; border-right: none;" readonly>
                                                                <div class="input-group-append">
                                                                    <button type="button" class="btn btn-light" style="background-color: #e9ecef; border-top: 1px solid #ced4da; border-bottom: 1px solid #ced4da; border-right: 1px solid #ced4da; border-left: none; color: rgb(4, 148, 4);">
                                                                        <i class="fas fa-check"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td style="border: 1px solid #D3D3D3;">
                                                            <div class="input-group" style="justify-content: center;">
                                                                <button type="button" class="btn btn-light">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>-->

                                                    <tr>
                                                            <td style="border: 1px solid #D3D3D3; text-align: center;">2</td>
                                                            <td style="border-right: none; border-top: 1px solid #D3D3D3; border-left: 1px solid #D3D3D3; border-bottom: 1px solid #D3D3D3; font-weight: bold;">Memorandum And Articles Of Association (MAA)</td>
                                                            <td style="border: 1px solid #D3D3D3;">
                                                                <div class="input-group">
                                                                <input type="text" id="form-mma" class="form-control" value="-" readonly>
                                                                    <div class="input-group-append">
                                                                        <button type="button" class="btn btn-light" style="background-color: #e9ecef; border-top: 1px solid #ced4da; border-bottom: 1px solid #ced4da; border-right: 1px solid #ced4da; border-left: none; color: rgb(4, 148, 4);">
                                                                            <i class="fas fa-times" style="color: red;"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td style="border: 1px solid #D3D3D3;">
                                                                <div class="input-group" style="justify-content: center;">
                                                                        <button disabled type="button" class="btn btn-light view-doc-btn" data-toggle="modal" data-target="#documentModal" data-file="">
                                                                        <i class="fas fa-search"></i>
                                                                        </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border: 1px solid #D3D3D3; text-align: center;">3</td>
                                                            <td style="border-right: none; border-top: 1px solid #D3D3D3; border-left: 1px solid #D3D3D3; border-bottom: 1px solid #D3D3D3; font-weight: bold;">Dokumen Pemunya Benefisial </td>
                                                            <td style="border: 1px solid #D3D3D3;">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" value="Application_Form_BO_AzharRaudah.pdf" style="border-top: 1px solid #ced4da; border-bottom: 1px solid #ced4da; border-left: 1px solid #ced4da; border-right: none;" readonly>
                                                                    <div class="input-group-append">
                                                                    <button type="button" class="btn btn-light" style="background-color: #e9ecef; border-top: 1px solid #ced4da; border-bottom: 1px solid #ced4da; border-right: 1px solid #ced4da; border-left: none; color: rgb(4, 148, 4);">
                                                                        <i class="fas fa-check"></i>
                                                                    </button>
                                                                </div>
                                                                </div>
                                                            </td>
                                                            <td style="border: 1px solid #D3D3D3;">
                                                                <div class="input-group" style="justify-content: center;">
                                                                    <button type="button" class="btn btn-light view-doc-btn" data-toggle="modal" data-target="#documentModal" data-file="Application_Form_BO_AzharRaudah.pdf">
                                                                    <i class="fas fa-search"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                        <td style="border: 1px solid #D3D3D3; text-align: center;">4</td>
                                                        <td style="border-right: none; border-top: 1px solid #D3D3D3; border-left: 1px solid #D3D3D3; border-bottom: 1px solid #D3D3D3; font-weight: bold;">Salinan Terkini Penyata Kewangan/Akaun Bank
                                                            (3 bulan terakhir) </td>
                                                        <td style="border: 1px solid #D3D3D3;">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="AzharRaudah_penyatakewangan.pdf" style="border-top: 1px solid #ced4da; border-bottom: 1px solid #ced4da; border-left: 1px solid #ced4da; border-right: none;" readonly>
                                                                <div class="input-group-append">
                                                                    <button type="button" class="btn btn-light" style="background-color: #e9ecef; border-top: 1px solid #ced4da; border-bottom: 1px solid #ced4da; border-right: 1px solid #ced4da; border-left: none; color: rgb(4, 148, 4);">
                                                                        <i class="fas fa-check"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td style="border: 1px solid #D3D3D3;">
                                                            <div class="input-group" style="justify-content: center;">
                                                                <button type="button" class="btn btn-light view-doc-btn" data-toggle="modal" data-target="#documentModal" data-file="AzharRaudah_penyatakewangan.pdf">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid #D3D3D3; text-align: center;">5</td>
                                                        <td style="border-right: none; border-top: 1px solid #D3D3D3; border-left: 1px solid #D3D3D3; border-bottom: 1px solid #D3D3D3; font-weight: bold;">Penyata Akaun Syarikat/Enterprise yang Telah Diaudit </td>
                                                        <td style="border: 1px solid #D3D3D3;">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="AzharRaudah_PenyataAkaun.pdf" style="border-top: 1px solid #ced4da; border-bottom: 1px solid #ced4da; border-left: 1px solid #ced4da; border-right: none;" readonly>
                                                                <div class="input-group-append">
                                                                <button type="button" class="btn btn-light" style="background-color: #e9ecef; border-top: 1px solid #ced4da; border-bottom: 1px solid #ced4da; border-right: 1px solid #ced4da; border-left: none; color: rgb(4, 148, 4);">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                            </div>
                                                            </div>
                                                        </td>
                                                        <td style="border: 1px solid #D3D3D3;">
                                                        <div class="input-group" style="justify-content: center;">
                                                                <button type="button" class="btn btn-light view-doc-btn" data-toggle="modal" data-target="#documentModal" data-file="AzharRaudah_penyatakewangan.pdf">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                        </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    <td style="border: 1px solid #D3D3D3; text-align: center;">6</td>
                                                    <td style="border-right: none; border-top: 1px solid #D3D3D3; border-left: 1px solid #D3D3D3; border-bottom: 1px solid #D3D3D3; font-weight: bold;">Lain-lain Dokumen</td>
                                                    <td style="border: 1px solid #D3D3D3;">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" value="-" style="border-top: 1px solid #ced4da; border-bottom: 1px solid #ced4da; border-left: 1px solid #ced4da; border-right: none;" readonly>
                                                            <div class="input-group-append">
                                                                <button type="button" class="btn btn-light" style="background-color: #e9ecef; border-top: 1px solid #ced4da; border-bottom: 1px solid #ced4da; border-right: 1px solid #ced4da; border-left: none; color: rgb(4, 148, 4);">
                                                                    <i class="fas fa-times" style="color: red;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="border: 1px solid #D3D3D3;">
                                                        <div class="input-group" style="justify-content: center;">
                                                            <button disabled type="button" class="btn btn-light">
                                                                <i class="fas fa-search"></i> <!-- Search icon -->
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                     <!-- Modal for Document Viewer -->
                                    <div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="documentModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="documentModalLabel">Paparan Dokumen</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                            <iframe id="documentViewer" src="" style="width: 100%; height: 500px;" frameborder="0"></iframe>
                                            </div>
                                            <div class="modal-footer">
                                            <a id="enlargeBtn" target="_blank" class="btn btn-info">Paparan Skrin Penuh</a>
                                            <a id="downloadBtn" class="btn btn-primary" download>Muat Turun</a>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
  
                          <!-- End of row -->
                          <div class="form-group">
                              <div class="profile-info w-100" style="margin-bottom: -30px;">
                                  <ul class="list-group list-group-unbordered mb-3 w-100" style="margin-top: 20px;">
                                      <li class="list-group-item w-100 d-flex justify-content-center align-items-center" style="border-bottom: none;">
                                          <div style="display: flex; gap: 10px;">
                                              <button type="button" class="btn btn-light scalable back" onclick="history.back();">
                                                  <span>Kembali</span>
                                              </button>
                                          </div>
                                      </li>
                                  </ul>
                              </div>
                          </div>
                      </div>
                </div> 
                            </div>
                            

                        </div>
                    </div>

                </div>
            </div>
        </div>
        </div>
    </div>
</div>
</form>

@endsection

@push('scripts')
<script type="text/javascript">

        $(document).on('input', "input[type=text]", function () {
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
        });

        //Display success message
        var msg = '{{Session::get('alert')}}';
        var exist = '{{Session::has('alert')}}';
        if(exist){
            alert(msg);
        }

        $(document).ready(function () {  


            //No Telefon Bimbit - Validation
            $('#txtPhoneNo').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g)|| $(this).val().length >= 10)    
                    return false;                        
            }); 

            //No Telefon Pejabat - Validation
            $('#txtOfficePhoneNo').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g)|| $(this).val().length >= 10)    
                    return false;                        
            }); 

            $('#poskod').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g)|| $(this).val().length >= 5)    
                    return false;                        
            }); 

        });

</script>   
<script>
    function redirectToPage(url) {
        window.location.href = url; // Redirect to the specified URL
    }
</script>
<script>
    // Wait for the DOM to load
    document.addEventListener("DOMContentLoaded", function () {
        const icInput = document.getElementById("icno");
        const ageInput = document.getElementById("age");

        // Function to calculate age from IC number
        function calculateAgeFromIC(icNumber) {
            if (!icNumber || icNumber.length < 6) return "";

            const yearPrefix = icNumber.slice(0, 2); // First 2 digits
            const currentYear = new Date().getFullYear();
            let birthYear = parseInt(yearPrefix, 10);

            // Determine if the birth year is in the 1900s or 2000s
            birthYear += birthYear < 30 ? 2000 : 1900;

            // Calculate age
            return currentYear - birthYear;
        }

        // Extract IC value and calculate age
        const icNumber = icInput.value;
        if (icNumber) {
            const age = calculateAgeFromIC(icNumber);
            ageInput.value = age; // Set age in the input field
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const icnoField = document.getElementById("icno");
        const genderField = document.getElementById("gender");
        const genderDisplayField = document.getElementById("gender_display");

        if (icnoField && genderField && genderDisplayField) {
            // Extract the last digit from Kad Pengenalan
            const icno = icnoField.value.trim();
            if (icno) {
                const lastDigit = parseInt(icno.charAt(icno.length - 1), 10);

                // Determine gender based on the last digit
                if (!isNaN(lastDigit)) {
                    const gender = lastDigit % 2 === 0 ? "PEREMPUAN" : "LELAKI";
                    genderField.value = gender; // Update the hidden input value
                    genderDisplayField.value = gender; // Update the disabled select field
                }
            }
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('salinan_ic');
        const label = input.nextElementSibling;

        input.addEventListener('change', function (e) {
            const fileName = input.files[0] ? input.files[0].name : "No File Chosen";
            label.textContent = fileName;
        });
    });
</script>
<script>
function showProcessingIndicator() {
    const processingDiv = document.getElementById('process-img');
    processingDiv.classList.remove('hidden'); // Show spinner
}

function hideProcessingIndicator() {
    const processingDiv = document.getElementById('process-img');
    processingDiv.classList.add('hidden'); // Hide spinner
}

</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const documentViewer = document.getElementById('documentViewer');
  const enlargeBtn = document.getElementById('enlargeBtn');
  const downloadBtn = document.getElementById('downloadBtn');
  const documentModalLabel = document.getElementById('documentModalLabel');

  document.querySelectorAll('.view-doc-btn').forEach(button => {
    button.addEventListener('click', function () {
      const fileName = this.getAttribute('data-file');

      // Check for a nearby <label> element
      let documentTitle = "Dokumen Tidak Dikenali";
      const labelElement = this.closest('tr').querySelector('label');

      if (labelElement) {
        documentTitle = labelElement.innerText.trim();
      } else {
        // Fallback: Use the second <td> text as the document title
        const titleElement = this.closest('tr').querySelector('td:nth-child(2)');
        if (titleElement) {
          documentTitle = titleElement.textContent.trim();
        }
      }

      const fileUrl = `/storage/syarikat/${fileName}`;

      // Update modal title, iframe, enlarge, and download button links
      documentModalLabel.innerText = documentTitle;
      documentViewer.src = fileUrl;
      enlargeBtn.href = fileUrl;
      downloadBtn.href = fileUrl;
      downloadBtn.download = fileName;
    });
  });
});



  </script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
@endpush
