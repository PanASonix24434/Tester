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
                    <a class="nav-link active" id="custom-content-education-tab" href="#" role="tab" aria-controls="custom-content-education" aria-selected="true">Tahap Pendidikan</a>
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
                            <h4 class="mb-0" style="color:white;">Tahap Pendidikan</h4>
                        </div>

                        <div class="card-body">

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Tahap Pendidikan Pemohon</label>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="is_primary" value="1" id="is_primary" {{ !empty($subApplication->is_primary) && $subApplication->is_primary == 1 ? 'checked' : '' }} disabled>
                                            <label class="form-check-label" for="primary">Sekolah Rendah</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="is_secondary" value="1" id="is_secondary" {{ !empty($subApplication->is_secondary) && $subApplication->is_secondary == 1 ? 'checked' : '' }} disabled>
                                            <label class="form-check-label" for="secondary">Sekolah Menengah</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="is_uni" value="1" id="is_uni" {{ !empty($subApplication->is_uni) && $subApplication->is_uni == 1 ? 'checked' : '' }} disabled>
                                            <label class="form-check-label" for="college">Kolej / Universiti</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="is_notschool" value="1" id="no_school" {{ !empty($subApplication->no_school) && $subApplication->no_school == 1 ? 'checked' : '' }} disabled>
                                            <label class="form-check-label" for="no_school">Tidak Bersekolah</label>
                                        </div>

                                    </div>
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
