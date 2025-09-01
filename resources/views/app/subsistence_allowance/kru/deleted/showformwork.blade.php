@extends('layouts.app')

@push('styles')
    <style type="text/css">
    </style>
@endpush

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
                        <h3 class="mb-0">Permohonan Elaun Sara Hidup Nelayan Darat</h3>
                    </div>
                </div>
                <div class="col-md-4">
                </div>
            </div>
            <ul class="nav nav-tabs" id="custom-content-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link" id="custom-content-form-tab" href="{{ route('subsistence-allowance.application.showformdetails',$subApplication->id) }}" role="tab" aria-controls="custom-content-form" aria-selected="false">Butiran Pemohon</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" id="custom-content-work-tab" href="#" role="tab" aria-controls="custom-content-work" aria-selected="true">Butiran Pekerjaan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-content-depandents-tab" href="{{ route('subsistence-allowance.application.showformdependent',$subApplication->id) }}" role="tab" aria-controls="custom-content-dependents" aria-selected="false">Butiran Tanggungan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-content-education-tab" href="{{ route('subsistence-allowance.application.showformeducation',$subApplication->id) }}" role="tab" aria-controls="custom-content-education" aria-selected="false">Tahap Pendidikan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-content-declaration-tab" href="{{ route('subsistence-allowance.application.showformdeclaration',$subApplication->id) }}" role="tab" aria-controls="custom-content-declaration" aria-selected="false">Perakuan</a>
                </li>
            </ul>
            <br />
            <div class="row">
                <div class="col-12">
                    <!-- card -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary">
                            <h4 class="mb-0" style="color:white;">Butiran Pekerjaan </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Status Nelayan :</label>
                                        <input type="text" class="form-control" id="StatusNelayan" value="Auto" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Bilangan Hari Menangkap Ikan sebulan:</label>
                                        <input type="text" class="form-control" id="AppAge" value="Auto" readonly>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Purata Pendapatan Bulanan:</label>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">a. Hasil daripada menangkap ikan</label>
                                </div>
                                <div class="col-md-6 d-flex">
                                    <span class="input-group-text">RM</span>
                                    <input type="number" class="form-control" name="fishing_income" id="fishing_income" value="{{ $subApplication->tot_incomefish ?? '0' }}" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">b. Hasil daripada pekerjaan lain (*jika ada)</label>
                                </div>
                                <div class="col-md-6 d-flex">
                                    <span class="input-group-text">RM</span>
                                    <input type="number" class="form-control" name="other_income" id="other_income" value="{{ $subApplication->tot_incomeother ?? '0' }}" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 fw-bold">
                                    <label class="form-label">Jumlah:</label>
                                </div>
                                <div class="col-md-6 d-flex">
                                    <span class="input-group-text">RM</span>
                                    <input type="number" class="form-control fw-bold" name="total_income" id="total_income" value="{{ $subApplication->tot_allincome ?? '' }}" readonly>
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                    <a href="{{ route('subsistence-allowance.application.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

@endsection

@push('scripts')
<script type="text/javascript">

</script>
@endpush
