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
                    <a class="nav-link" id="custom-content-depandents-tab" href="{{ route('subsistence-allowance.application.showformdependent',$subApplication->id) }}" role="tab" aria-controls="custom-content-dependents" aria-selected="false">Butiran Tanggungan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-content-education-tab" href="{{ route('subsistence-allowance.application.showformeducation',$subApplication->id) }}" role="tab" aria-controls="custom-content-education" aria-selected="false">Tahap Pendidikan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" id="custom-content-declaration-tab" href="#" role="tab" aria-controls="custom-content-declaration" aria-selected="true">Perakuan</a>
                </li>
            </ul>
            <br />
            <div class="row">
                <div class="col-12">
                    <!-- card -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary">
                            <h4 class="mb-0" style="color:white;">Perakuan</h4>
                        </div>

                        <div class="card-body">

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="col-12 text-center">
                                            <div class="form-group mb-0">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="terms" class="custom-control-input" id="terms" checked disabled>
                                                    <label class="custom-control-label" for="terms">Saya dengan ini mengakui dan mengesahkan bahawa semua maklumat yang diberikan oleh saya adalah benar. Sekiranya terdapat maklumat yang tidak benar, pihak Jabatan boleh menolak permohonan saya dan tindakan undang-undang boleh dikenakan ke atas saya.</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                    <a href="{{ route('subsistence-allowance.application.index', $subApplication->id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
