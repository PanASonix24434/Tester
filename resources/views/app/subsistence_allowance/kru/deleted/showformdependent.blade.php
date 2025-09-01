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
                  <a class="nav-link" id="custom-content-form-tab" data-toggle="pill" href="{{ route('subsistence-allowance.application.showformdetails',$subApplication->id) }}" role="tab" aria-controls="custom-content-form" aria-selected="false">Butiran Pemohon</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-content-work-tab" href="{{ route('subsistence-allowance.application.showformwork',$subApplication->id) }}" role="tab" aria-controls="custom-content-work" aria-selected="false">Butiran Pekerjaan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" id="custom-content-depandents-tab" href="#" role="tab" aria-controls="custom-content-dependents" aria-selected="true">Butiran Tanggungan</a>
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
                            <h4 class="mb-0" style="color:white;">Butiran Tanggungan</h4>
                        </div>

                        <div class="card-body">

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Bilangan Tanggungan</label>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        Bilangan tanggungan adalah jumlah tanggungan keluarga termasuk pemohon. Anak-anak yang telah bekerja atau berumahtangga dan berumur 21 tahun ke atas tidak termasuk di bawah tanggungan ibubapa/ penjaga, walaubagaimanapun pengecualian diberikan kepada anak kurang upaya atau masih menuntut di Institusi Pengajian Tinggi di peringkat Ijazah Pertama.
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">a. Bilangan Anak</label>
                                </div>
                                <div class="col-md-6 d-flex">
                                    <input type="number" class="form-control" name="tot_child" id="tot_child" value="{{ $subApplication->tot_child ?? '0' }}" readonly>
                                    <span class="input-group-text">Orang</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">b. Lain-lain</label>
                                </div>
                                <div class="col-md-6 d-flex">
                                    <input type="number" class="form-control" name="child_other" id="child_other" value="{{ $subApplication->tot_otherchild ?? '0' }}" readonly>
                                    <span class="input-group-text">Orang</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 fw-bold">
                                    <label class="form-label">Jumlah Tanggungan</label>
                                </div>
                                <div class="col-md-6 d-flex">
                                    <input type="number" class="form-control fw-bold" name="total_allchild" id="total_allchild" value="{{ $subApplication->tot_allchild ?? '' }}" readonly>
                                    <span class="input-group-text">Orang</span>
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                    <a href="{{ route('subsistence-allowance.application.index',  $subApplication->id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
